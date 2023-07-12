# Upstox PHP SDK for API v2

## Introduction

The official PHP client for communicating with the <a href="https://upstox.com/uplink/">Upstox API</a>.

Upstox API is a set of rest APIs that provide data required to build a complete investment and trading platform. Execute orders in real time, manage user portfolio, stream live market data (using Websocket), and more, with the easy to understand API collection. 

- API version: v2
- Build package: io.swagger.codegen.v3.generators.php.PhpClientCodegen

This PHP package is automatically generated by the [Swagger Codegen](https://github.com/swagger-api/swagger-codegen) project:

## Documentation.

<a href="https://upstox.com/developer/api-documentation">Upstox API Documentation</a>

## Requirements

PHP 7.4 and later

## Installation & Usage
### Composer
Run `composer require upstox/upstox-php-sdk` to install the SDK from Packagist.

### Github
#### Composer Installation

Download the latest release and run `composer install`

#### Manual Installation

Download the files and include `autoload.php`:

```php
    require_once('/path/to/UpstoxClient/vendor/autoload.php');
```

## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAUTH2
$config = Upstox\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Upstox\Client\Api\ChargeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$instrument_token = "instrument_token_example"; // string | Key of the instrument
$quantity = 56; // int | Quantity with which the order is to be placed
$product = "product_example"; // string | Product with which the order is to be placed
$transaction_type = "transaction_type_example"; // string | Indicates whether its a BUY or SELL order
$price = 3.4; // float | Price with which the order is to be placed
$api_version = "api_version_example"; // string | API Version Header

try {
    $result = $apiInstance->getBrokerage($instrument_token, $quantity, $product, $transaction_type, $price, $api_version);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ChargeApi->getBrokerage: ', $e->getMessage(), PHP_EOL;
}
?>
```

## Documentation for API Endpoints

All URIs are relative to *https://api-v2.upstox.com*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*ChargeApi* | [**getBrokerage**](docs/Api/ChargeApi.md#getbrokerage) | **GET** /charges/brokerage | Brokerage details
*HistoryApi* | [**getHistoricalCandleData**](docs/Api/HistoryApi.md#gethistoricalcandledata) | **GET** /historical-candle/{instrumentKey}/{interval}/{to_date} | Historical candle data
*HistoryApi* | [**getHistoricalCandleData1**](docs/Api/HistoryApi.md#gethistoricalcandledata1) | **GET** /historical-candle/{instrumentKey}/{interval}/{to_date}/{from_date} | Historical candle data
*HistoryApi* | [**getIntraDayCandleData**](docs/Api/HistoryApi.md#getintradaycandledata) | **GET** /historical-candle/intraday/{instrumentKey}/{interval} | Intra day candle data
*LoginApi* | [**authorize**](docs/Api/LoginApi.md#authorize) | **GET** /login/authorization/dialog | Authorize API
*LoginApi* | [**logout**](docs/Api/LoginApi.md#logout) | **DELETE** /logout | Logout
*LoginApi* | [**token**](docs/Api/LoginApi.md#token) | **POST** /login/authorization/token | Get token API
*MarketQuoteApi* | [**getFullMarketQuote**](docs/Api/MarketQuoteApi.md#getfullmarketquote) | **GET** /market-quote/quotes | Market quotes and instruments - Full market quotes
*MarketQuoteApi* | [**getMarketQuoteOHLC**](docs/Api/MarketQuoteApi.md#getmarketquoteohlc) | **GET** /market-quote/ohlc | Market quotes and instruments - OHLC quotes
*MarketQuoteApi* | [**ltp**](docs/Api/MarketQuoteApi.md#ltp) | **GET** /market-quote/ltp | Market quotes and instruments - LTP quotes.
*OrderApi* | [**cancelOrder**](docs/Api/OrderApi.md#cancelorder) | **DELETE** /order/cancel | Cancel order
*OrderApi* | [**getOrderBook**](docs/Api/OrderApi.md#getorderbook) | **GET** /order/retrieve-all | Get order book
*OrderApi* | [**getOrderDetails**](docs/Api/OrderApi.md#getorderdetails) | **GET** /order/history | Get order details
*OrderApi* | [**getTradeHistory**](docs/Api/OrderApi.md#gettradehistory) | **GET** /order/trades/get-trades-for-day | Get trades
*OrderApi* | [**getTradesByOrder**](docs/Api/OrderApi.md#gettradesbyorder) | **GET** /order/trades | Get trades for order
*OrderApi* | [**modifyOrder**](docs/Api/OrderApi.md#modifyorder) | **PUT** /order/modify | Modify order
*OrderApi* | [**placeOrder**](docs/Api/OrderApi.md#placeorder) | **POST** /order/place | Place order
*PortfolioApi* | [**convertPositions**](docs/Api/PortfolioApi.md#convertpositions) | **PUT** /portfolio/convert-position | Convert Positions
*PortfolioApi* | [**getHoldings**](docs/Api/PortfolioApi.md#getholdings) | **GET** /portfolio/long-term-holdings | Get Holdings
*PortfolioApi* | [**getPositions**](docs/Api/PortfolioApi.md#getpositions) | **GET** /portfolio/short-term-positions | Get Positions
*TradeProfitAndLossApi* | [**getProfitAndLossCharges**](docs/Api/TradeProfitAndLossApi.md#getprofitandlosscharges) | **GET** /trade/profit-loss/charges | Get profit and loss on trades
*TradeProfitAndLossApi* | [**getTradeWiseProfitAndLossData**](docs/Api/TradeProfitAndLossApi.md#gettradewiseprofitandlossdata) | **GET** /trade/profit-loss/data | Get Trade-wise Profit and Loss Report Data
*TradeProfitAndLossApi* | [**getTradeWiseProfitAndLossMetaData**](docs/Api/TradeProfitAndLossApi.md#gettradewiseprofitandlossmetadata) | **GET** /trade/profit-loss/metadata | Get profit and loss meta data on trades
*UserApi* | [**getProfile**](docs/Api/UserApi.md#getprofile) | **GET** /user/profile | Get profile
*UserApi* | [**getUserFundMargin**](docs/Api/UserApi.md#getuserfundmargin) | **GET** /user/get-funds-and-margin | Get User Fund And Margin
*WebsocketApi* | [**getMarketDataFeed**](docs/Api/WebsocketApi.md#getmarketdatafeed) | **GET** /feed/market-data-feed | Market Data Feed
*WebsocketApi* | [**getMarketDataFeedAuthorize**](docs/Api/WebsocketApi.md#getmarketdatafeedauthorize) | **GET** /feed/market-data-feed/authorize | Market Data Feed Authorize
*WebsocketApi* | [**getPortfolioStreamFeed**](docs/Api/WebsocketApi.md#getportfoliostreamfeed) | **GET** /feed/portfolio-stream-feed | Portfolio Stream Feed
*WebsocketApi* | [**getPortfolioStreamFeedAuthorize**](docs/Api/WebsocketApi.md#getportfoliostreamfeedauthorize) | **GET** /feed/portfolio-stream-feed/authorize | Portfolio Stream Feed Authorize

## Documentation For Models

 - [ApiGatewayErrorResponse](docs/Model/ApiGatewayErrorResponse.md)
 - [BrokerageData](docs/Model/BrokerageData.md)
 - [BrokerageTaxes](docs/Model/BrokerageTaxes.md)
 - [BrokerageWrapperData](docs/Model/BrokerageWrapperData.md)
 - [CancelOrderData](docs/Model/CancelOrderData.md)
 - [CancelOrderResponse](docs/Model/CancelOrderResponse.md)
 - [ConvertPositionData](docs/Model/ConvertPositionData.md)
 - [ConvertPositionRequest](docs/Model/ConvertPositionRequest.md)
 - [ConvertPositionResponse](docs/Model/ConvertPositionResponse.md)
 - [Depth](docs/Model/Depth.md)
 - [DepthMap](docs/Model/DepthMap.md)
 - [DpPlan](docs/Model/DpPlan.md)
 - [GetBrokerageResponse](docs/Model/GetBrokerageResponse.md)
 - [GetFullMarketQuoteResponse](docs/Model/GetFullMarketQuoteResponse.md)
 - [GetHistoricalCandleResponse](docs/Model/GetHistoricalCandleResponse.md)
 - [GetHoldingsResponse](docs/Model/GetHoldingsResponse.md)
 - [GetIntraDayCandleResponse](docs/Model/GetIntraDayCandleResponse.md)
 - [GetMarketQuoteLastTradedPriceResponse](docs/Model/GetMarketQuoteLastTradedPriceResponse.md)
 - [GetMarketQuoteOHLCResponse](docs/Model/GetMarketQuoteOHLCResponse.md)
 - [GetOrderBookResponse](docs/Model/GetOrderBookResponse.md)
 - [GetOrderResponse](docs/Model/GetOrderResponse.md)
 - [GetPositionResponse](docs/Model/GetPositionResponse.md)
 - [GetProfileResponse](docs/Model/GetProfileResponse.md)
 - [GetProfitAndLossChargesResponse](docs/Model/GetProfitAndLossChargesResponse.md)
 - [GetTradeResponse](docs/Model/GetTradeResponse.md)
 - [GetTradeWiseProfitAndLossDataResponse](docs/Model/GetTradeWiseProfitAndLossDataResponse.md)
 - [GetTradeWiseProfitAndLossMetaDataResponse](docs/Model/GetTradeWiseProfitAndLossMetaDataResponse.md)
 - [GetUserFundMarginResponse](docs/Model/GetUserFundMarginResponse.md)
 - [HistoricalCandleData](docs/Model/HistoricalCandleData.md)
 - [HoldingsData](docs/Model/HoldingsData.md)
 - [IntraDayCandleData](docs/Model/IntraDayCandleData.md)
 - [LogoutResponse](docs/Model/LogoutResponse.md)
 - [MarketQuoteOHLC](docs/Model/MarketQuoteOHLC.md)
 - [MarketQuoteSymbol](docs/Model/MarketQuoteSymbol.md)
 - [MarketQuoteSymbolLtp](docs/Model/MarketQuoteSymbolLtp.md)
 - [ModifyOrderData](docs/Model/ModifyOrderData.md)
 - [ModifyOrderRequest](docs/Model/ModifyOrderRequest.md)
 - [ModifyOrderResponse](docs/Model/ModifyOrderResponse.md)
 - [OAuthClientException](docs/Model/OAuthClientException.md)
 - [OAuthClientExceptionCause](docs/Model/OAuthClientExceptionCause.md)
 - [OAuthClientExceptionCauseStackTrace](docs/Model/OAuthClientExceptionCauseStackTrace.md)
 - [OAuthClientExceptionCauseSuppressed](docs/Model/OAuthClientExceptionCauseSuppressed.md)
 - [Ohlc](docs/Model/Ohlc.md)
 - [OrderBookData](docs/Model/OrderBookData.md)
 - [OrderData](docs/Model/OrderData.md)
 - [OtherTaxes](docs/Model/OtherTaxes.md)
 - [PlaceOrderData](docs/Model/PlaceOrderData.md)
 - [PlaceOrderRequest](docs/Model/PlaceOrderRequest.md)
 - [PlaceOrderResponse](docs/Model/PlaceOrderResponse.md)
 - [PositionData](docs/Model/PositionData.md)
 - [Problem](docs/Model/Problem.md)
 - [ProfileData](docs/Model/ProfileData.md)
 - [ProfitAndLossChargesData](docs/Model/ProfitAndLossChargesData.md)
 - [ProfitAndLossChargesTaxes](docs/Model/ProfitAndLossChargesTaxes.md)
 - [ProfitAndLossChargesWrapperData](docs/Model/ProfitAndLossChargesWrapperData.md)
 - [ProfitAndLossMetaData](docs/Model/ProfitAndLossMetaData.md)
 - [ProfitAndLossMetaDataWrapper](docs/Model/ProfitAndLossMetaDataWrapper.md)
 - [ProfitAndLossOtherChargesTaxes](docs/Model/ProfitAndLossOtherChargesTaxes.md)
 - [TokenRequest](docs/Model/TokenRequest.md)
 - [TokenResponse](docs/Model/TokenResponse.md)
 - [TradeData](docs/Model/TradeData.md)
 - [TradeWiseMetaData](docs/Model/TradeWiseMetaData.md)
 - [TradeWiseProfitAndLossData](docs/Model/TradeWiseProfitAndLossData.md)
 - [UserFundMarginData](docs/Model/UserFundMarginData.md)
 - [WebsocketAuthRedirectResponse](docs/Model/WebsocketAuthRedirectResponse.md)
 - [WebsocketAuthRedirectResponseData](docs/Model/WebsocketAuthRedirectResponseData.md)
