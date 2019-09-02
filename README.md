# Feenicia SDK #

## Description ##
Unofficial Feenicia PHP SDK Library

## Requirements ##
* [PHP 5.4.1 or higher](http://www.php.net/)

## Developer Documentation ##
Execute phpdoc -d feenicia/

## Test ##
Change credentials and run test.php

## Installation ##
Create file composer.json
~~~

{
    "require": {
    	"php": ">=5.4.0",
      "apache/log4php": "2.3.0",
      "yorch/feenicia" : "dev-master"
    }
}

~~~

Execute composer.phar install

## Example ##
~~~

// Configure log
$config = array(
    'appenders' => array(
        'default' => array(
            'class' => 'LoggerAppenderFile',
            'layout' => array(
                'class' => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '%date %logger %-5level %msg%n'
                )
            ),
            'params' => array(
                'file' => ('feenicia.log'),
                'append' => true
            ),
        ),
    ),
    'rootLogger' => array(
        'appenders' => array('default'),
    ),
);

\Logger::configure($config);

// Configure Feenicia
$cfgFeeKeys = array('MERCHANT_REQUEST_IV' => '', 
                 'MERCHANT_REQUEST_KEY' => '', 
                 'MERCHANT_REQUEST_SIGNATURE_IV' => '', 
                 'MERCHANT_REQUEST_SIGNATURE_KEY' => '', 
                 'MERCHANT_RESPONSE_IV' => '', 
                 'MERCHANT_RESPONSE_KEY' => '', 
                 'MERCHANT_RESPONSE_SIGNATURE_IV' => '', 
                 'MERCHANT_RESPONSE_SIGNATURE_KEY' => '');

$cfgFeeCredentials = array('MERCHANTID' => '',
                        'AFFILIATION' => '',
                        'USERID' => '',
                        'PASSWORD' => '');

$fee = Feenicia\SDK::getInstance(Feenicia\SDK::SANDBOX);

$fee->setKeys($cfgFeeKeys);
$fee->setCredentials($cfgFeeCredentials);

$payment = new Feenicia\Payment();
$payment->setCard('4917988912987740');
$payment->setCardHolderName('FEENICIA');
$payment->setCVV('703');
$payment->setExpirationDate('1909');
$payment->sendMail(true);
$payment->setMail("the.yorch@gmail.com");
$payment->setItem('Producto 1', 10.00, 2);
$payment->setItem('Producto 2', 5.00, 3);

$result = $fee->applyPayment($payment);

if (!$result["ERRORTRAN"]) {
    var_dump($result);
  //$fee->reversePayment($result);
}
else {
    var_dump($result);
}

~~~

## Notes ##
This unofficial library for payments gateway feenicia.

## References ##
https://www.feenicia.com/

P.D. Let's go play !!!




