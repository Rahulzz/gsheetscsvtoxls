<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(Google_Service_Drive::DRIVE);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

function fetchFolderId($service, $folderName){
	
	$folderId = null;
	
	// Fetch all folder within the drive.
	$optParams = array(
	  'fields' => 'nextPageToken, files(id, name)',
	  'q' => "mimeType='application/vnd.google-apps.folder' and trashed=false"
	);
	
	$folders = $service->files->listFiles($optParams);
	
	if (count($folders->getFiles()) == 0) {
		print "No folders found.\n";
	} else {
		foreach ($folders->getFiles() as $folder) {
			if($folder->getName() == $folderName){
				$folderId = $folder->getId();
				break;				
			}
		}
	}
	
	return $folderId;	
}

function fetchFilesInFolder($service, $folderId){
	
	// Fetch all files within the folder.
	$optParams = array(
		'fields' => 'nextPageToken, files(id, name)',
		'q' => "mimeType!='application/vnd.google-apps.folder' and '".$folderId."' in parents and trashed=false"
	);
	
	$files = $service->files->listFiles($optParams);
	
	return $files;
}

function createSpreadSheet($service, $fileName){
	
	$spreadsheet = new Google_Service_Sheets_Spreadsheet(['properties' => ['title' => $fileName]]);
	$spreadsheet = $service->spreadsheets->create($spreadsheet, [
		'fields' => 'spreadsheetId'
	]);
	$spreadsheetId = $spreadsheet->spreadsheetId;
	
	return $spreadsheetId;
	
}

function updateSpreadSheet($service, $spreadsheetId, $fileContent){
	
	$fileContentArray = explode("\n",$fileContent);	
	$spreadSheetValues = array();	
	foreach ($fileContentArray as $contentLine) {
		if($contentLine != ""){
			$lineArray = explode(",",$contentLine);
			$lineValues = array();
			foreach ($lineArray as $value) {
				$lineValues[] = $value;
			}
			$spreadSheetValues[] = $lineValues;
		}
	}
	$body = new Google_Service_Sheets_ValueRange([
		'values' => $spreadSheetValues
	]);	
	$params = [
		'valueInputOption' => "RAW"
	];	
	$range = "A1";	
	$result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
	
}

function convertCsvFileToSpreadsheet($client, $service, $folderId, $fileId, $fileName, $sortColumnIndex, $sortColumnType){
	
	// Do not limit the server memory
	ini_set('memory_limit', '-1');

	// Fetch file content
	$fileObject = $service->files->get($fileId, array('alt' => 'media'));
	$fileContent = $fileObject->getBody()->getContents();
	
	// Create a new spreadsheet, update values and add filter criteria
	$sheetsService = new Google_Service_Sheets($client);
	$spreadsheetId = createSpreadSheet($sheetsService, $fileName.".xls");	
	updateSpreadSheet($sheetsService, $spreadsheetId, $fileContent);
	addFilterToTheSheet($sheetsService, $spreadsheetId, $sortColumnIndex, $sortColumnType);
	
	// Move file to appropriate folder
	$emptyFileMetadata = new Google_Service_Drive_DriveFile();
	$file = $service->files->get($spreadsheetId, array('fields' => 'parents'));
	$previousParents = join(',', $file->parents);
	$file = $service->files->update($spreadsheetId, $emptyFileMetadata, array(
		'addParents' => $folderId,
		'removeParents' => $previousParents,
		'fields' => 'id, parents'));

	return "https://docs.google.com/spreadsheets/d/".$spreadsheetId;
	
}

function fetchFilesAndConvert($folderName, $sortColumnIndex, $sortColumnType){
	
	$requiredFileType = ".csv";
	
	// Get the API client and construct the service object.
	$client = getClient();
	$service = new Google_Service_Drive($client);

	$folderId = fetchFolderId($service, $folderName);

	if($folderId != null){
		$files = fetchFilesInFolder($service, $folderId);		
		if (count($files->getFiles()) == 0) {
			print "No files found within folder '".$folderName."'.\n";
		}
		else {
			foreach ($files->getFiles() as $file) {
				$fileName = $file->getName();
				$fileId = $file->getId();
				if(substr_compare($fileName, $requiredFileType, strlen($fileName)-strlen($requiredFileType), strlen($requiredFileType)) === 0){
					$sheetUrl = convertCsvFileToSpreadsheet($client, $service, $folderId, $fileId, str_replace($requiredFileType,"",$fileName), $sortColumnIndex, $sortColumnType);
					print $sheetUrl."\n";
				}
			}
		}
	}
	else {
		print "Unable to find folder with name '".$folderName."'. \n";
	}
}

function addFilterToTheSheet($service, $spreadsheetId, $sortColumnIndex, $sortColumnType){
	$filterRange = ["sheetId"=> 0,"startRowIndex"=> 0,"startColumnIndex"=> 0];
	$addFilterViewRequest = [
		'addFilterView'=> [
			'filter'=> [
				'title'=> 'Sample Filter',
				'range'=> $filterRange,
				'sortSpecs'=> [[
					'dimensionIndex'=> $sortColumnIndex,
					'sortOrder'=> $sortColumnType
				]],
			]
		]
	];
	$body = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
		'requests' => $addFilterViewRequest
	]);
	$addFilterViewResponse = $service->spreadsheets->batchUpdate($spreadsheetId, $body);
	
}


$folderName = "gsheetscsvtoxls";
$sortColumnIndex = 7;
$sortColumnType = "ASCENDING";

fetchFilesAndConvert($folderName, $sortColumnIndex, $sortColumnType);





