<?php
namespace Feenicia;

/**
 * Feenicia
 *
 * Feenicia PHP SDK
 *
 * Copyright 2019 Jorge Alberto Ponce Turrubiates
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category   SDK
 * @package    Feenicia
 * @copyright  Copyright 2019 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2019-07-08
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
class SDK
{
	/**
	 * Sandbox Mode
	 */
	const SANDBOX = 0;

	/**
	 * Production Mode
	 */
	const PRODUCTION = 1;

	/**
	 * Default Instance
	 * 
	 * @var SDK
	 */
	private static $_instance;
	
	/**
	 * Feenicia Keys 
	 * 
	 * @var array
	 */
	private $_keys = array();

	/**
	 * Feenicia Credentials
	 * 
	 * @var array
	 */
	private $_credentials = array();

	/**
	 * Feenicia Mode 0 SANDBOX 1 PRODUCTION
	 * 
	 * @var integer
	 */
	private $_mode = 1;

	/**
	 * Feenicia generated order ID
	 * 
	 * @var string
	 */
	private $_orderId = '';

	/**
	 * Feenicia Transaction ID
	 * 
	 * @var string
	 */
	private $_transactionId	= '';

	/**
	 * Feenicia Authentication Number
	 * 
	 * @var string
	 */
	private $_authNum = '';

	/**
	 * Feenicia Card Termination
	 * 
	 * @var string
	 */
	private $_panTermination = '';

	/**
	 * Feenicia Receipt ID
	 * 
	 * @var string
	 */
	private $_receiptId = '';

	/**
	 * Feenicia Transaction Date
	 * 
	 * @var string
	 */
	private $_transactionDate = '';

	/**
	 * Log
	 *  
	 * @var \Logger
	 */
	private $log;

	/**
	 * PDF Base 64
	 * 
	 * @var string
	 */
	private $pdfBase64 = '';

	/**
	 * Errors Array
	 * 
	 * @var array
	 */
	private $errorArray = array(
		'01'	=> 'Call To Authorize 02 Call To Carnet',
		'03'	=> 'Invalid Trade 04 Hold Back Card',
		'05'	=> 'Rejected 06 Call To Carnet',
		'07'	=> 'Hold Back Card 08 Call To Carnet',
		'09'	=> 'Call To Carnet 1 Rejected SWA',
		'10'	=> 'Rejected 11 Approved Transaction',
		'12'	=> 'Invalid Transaction 13 Invalid Amount',
		'14'	=> 'Invalid Card 15 Rejected',
		'16'	=> 'Rejected 17 Rejected',
		'18'	=> 'Rejected 19 Rejected',
		'2'		=> 'Rejected SWA 20 Rejected',
		'21'	=> 'Rejected 22 Rejected',
		'23'	=> 'Rejected 24 Rejected',
		'25'	=> 'Rejected 26 Rejected',
		'27'	=> 'Rejected 28 Rejected',
		'29'	=> 'Rejected 3 Rejected SWA',
		'30'	=> 'Rejected 31 Rejected',
		'32'	=> 'Rejected 33 Expired Card',
		'34'	=> 'Hold Back Card 35 Hold Back Card',
		'36'	=> 'Hold Back Card 37 Hold Back Card',
		'38'	=> 'Rejected 39 Rejected',
		'4'		=> 'Rejected SWA 40 Rejected',
		'41'	=> 'Hold Back Card 42 Rejected',
		'43'	=> 'Hold Back Card 44 Rejected',
		'45'	=> 'Rejected 46 Rejected',
		'47'	=> 'Rejected 48 Rejected',
		'49'	=> 'Rejected 5 Rejected SWA',
		'50'	=> 'Rejected 51 Rejected',
		'52'	=> 'Rejected 53 Rejected',
		'54'	=> 'Expired Card 55 Incorrect PIN',
		'56'	=> 'Call To Authorize 57 Rejected',
		'58'	=> 'Invalid Transaction 59 Rejected',
		'6'		=> 'Rejected SWA 60 Rejected',
		'61'	=> 'Rejected 62 Rejected',
		'63'	=> 'Rejected 64 Rejected',
		'65'	=> 'Call To Carnet 66 Rejected',
		'67'	=> 'Rejected 68 Try Again',
		'69'	=> 'Rejected 70 Rejected',
		'71'	=> 'Rejected 72 Rejected',
		'73'	=> 'Rejected 74 Rejected',
		'75'	=> 'Rejected 76 Approved Transaction',
		'77'	=> 'Approved Transaction 78 Approved Transaction',
		'79'	=> 'Approved Transaction 8 Rejected SWA',
		'80'	=> 'Approved Transaction 81 Approved Transaction',
		'82'	=> 'Rejected 83 Rejected',
		'84'	=> 'Rejected 85 Rejected',
		'86'	=> 'Rejected 87 Rejected',
		'88'	=> 'Call To Carnet 89 Rejected',
		'90'	=> 'Call To Carnet 91 Service not available (Call the administrator)',
		'92'	=> 'Rejected 93 Rejected',
		'94'	=> 'Call To Carnet 95 Rejected',
		'96'	=> 'Rejected 97 Rejected',
		'98'	=> 'Deferred Payment Not Allowed 99 Payment Deferred Parameter Inv',
		'A001'	=> 'Data Validation Error',
		'A002'	=> 'Missing data like cvv2 or pan ( if manual refund ) or track2 ( if card refund )',
		'A004'	=> 'Invalid affiliation number',
		'A006'	=> 'Invalid request encryption',
		'A007'	=> 'Transaction Not Found',
		'A008'	=> 'Invalid request merchant',
		'A009'	=> 'Not Approved Transaction', 
		'A010'	=> 'Transaction already refunded',
		'A011'	=> 'Authnum does not match',
		'A012'	=> 'EMV request not present and no fallback flag was set',
		'A013'	=> 'Fallback flag was set but emvtags are present',
		'A014'	=> 'Incomplete EMV Tags',
		'A015'	=> 'Exceeded EMV Tags',
		'A016'	=> 'EMV Tags length exceeded',
		'A017'	=> 'Limit reached for the day',
		'A018'	=> 'Limit for transaction',
		'P001'	=> 'No manual sales are allowed',
		'P002'	=> 'No card sales allowed',
		'P003'	=> 'No deferral payments allowed',
		'P004'	=> 'No tipping allowed',
		'P005'	=> 'No manual refunds allowed',
		'P006'	=> 'No Card refunds allowed',
		'P007'	=> 'No manual reversals allowed',
		'P008'	=> 'No Card reversals allowed',
		'S001'	=> 'Null Access Token',
		'S002'	=> 'Null Request',
		'S003'	=> 'Invalid Access Token Format',
		'S004'	=> 'Invalid Encription',
		'S005'	=> 'Invalid Signature',
		'A024'  => 'Undocumented Error'
	);

	/**
	 * Private Constructor
	 * 
	 * @param integer $type 1 PRODUCTION 0 SANDBOX
	 */
	private function __construct($type = self::PRODUCTION)
	{
		$this->_mode = $type;
		$this->log = \Logger::getLogger(__CLASS__);
	}

	/**
	 * Gets default instance
	 * 
	 * @param  integer $type 1 PRODUCTION 0 SANDBOX
	 * @return SDK       Default instance
	 */
	public static function getInstance($type = self::PRODUCTION)
	{
		if(self::$_instance){
			return self::$_instance;
		}
		else{
			$class = __CLASS__;
			self::$_instance = new $class($type);

			return self::$_instance;
		}
	}

	/**
	 * Crypt data
	 * 
	 * @param  string $data Data to encrypt
	 * @return string       Encrypted data
	 */
	public function cryptData($data){
		$requestIv	= pack('H*', $this->getKey('MERCHANT_REQUEST_IV'));
		$requestKey	= pack('H*', $this->getKey('MERCHANT_REQUEST_KEY'));
		$enc		= MCRYPT_RIJNDAEL_128;
		$mode		= MCRYPT_MODE_CBC;
		$block		= 16;
		$pad		= $block - (strlen($data) % $block);
		$data		.= str_repeat(chr($pad), $pad);
		$cData	= bin2hex(mcrypt_encrypt($enc, $requestKey, $data, $mode, $requestIv));
		
		return $cData;
	}

	/**
	 * Crypt Mail
	 * 
	 * @param  string $data Mail
	 * @return string       Encrypted data
	 */
	public function cryptMail($data){
		$requestIv	= pack('H*', $this->getKey('MERCHANT_REQUEST_IV'));
		$requestKey	= pack('H*', $this->getKey('MERCHANT_REQUEST_KEY'));
		$enc		= MCRYPT_RIJNDAEL_128;
		$mode		= MCRYPT_MODE_CBC;
		$block		= 16;
		$pad		= $block - (strlen($data) % $block);
		$data		.= str_repeat(chr($pad), $pad);
		$cData	= bin2hex(mcrypt_encrypt($enc, $requestKey, $data, $mode, $requestIv));
		
		return $cData;
	}

	/**
	 * Sign JSON
	 * 
	 * @param  string $json JSON to encrypt
	 * @return string       Encripted JSON
	 */
	public function signJSON($json){
		$sigIv		= pack('H*', $this->getKey('MERCHANT_REQUEST_SIGNATURE_IV'));
		$sigKey		= pack('H*', $this->getKey('MERCHANT_REQUEST_SIGNATURE_KEY'));
		
		$sha256Key	= hash("sha256", (string)$json);

		$block		= 16;
		$pad		= $block - (strlen($sha256Key) % $block);
		$sha256Key .= str_repeat(chr($pad), $pad);

		$rijndael256Key = bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $sigKey, $sha256Key, MCRYPT_MODE_CBC, $sigIv));

		$requestWith = $this->getCredential('MERCHANTID') . "_" . $rijndael256Key;
		
		return $requestWith;
	}

	/**
	 * Sets Feenicia Keys
	 * 
	 * @param array $aKeys Array keys
	 */
	public function setKeys($aKeys) 
	{
		$this->_keys = $aKeys;
	}

	/**
	 * Sets Feenicia Credentials
	 * 
	 * @param array $aCredentials Array credentials
	 */
	public function setCredentials($aCredentials)
	{
		$this->_credentials = $aCredentials;
	}

	/**
	 * Gets key value
	 * 
	 * @param  string $keyValue Key value
	 * @return string           Key value
	 */
	private function getKey($keyValue)
	{
		return $this->_keys[$keyValue];
	}

	/**
	 * Gets credential item
	 * 
	 * @param  string $credential Credential item
	 * @return string             Credential value
	 */
	private function getCredential($credential) 
	{
		return $this->_credentials[$credential];
	}

	/**
	 * Apply Feenicia Payment
	 * 
	 * @param  Payment $payment Payment
	 * @return array            Feenicia Payment Array
	 */
	public function applyPayment($payment)
	{
		// Create Order
		$errorTran = false;
		$errorMsg = '';

		$retArray = array();

		$this->_transactionDate = round(microtime(true) * 1000);
		
		$postData = array(
			"amount"	=> (float)$payment->getAmount('amount'),
			"items"		=> $payment->getItems(),
			"merchant"	=> $this->getCredential('MERCHANTID'),
			"userId"	=> $this->getCredential('USERID')
		);

		$signJSON = $this->signJSON(json_encode($postData));

		if ($this->_mode == self::PRODUCTION) {
			$sEndpoint	= 'https://www.feenicia.com/receipt/order/create';	
		}
		else {
			$sEndpoint	= 'http://54.203.245.137/receipt/order/create';	
		}

		$data = json_encode($postData);

		$response = $this->requestAPI($sEndpoint, $signJSON, $data);
		$jResponse = json_decode($response);

		if($jResponse->responseCode == '00'){
			$this->_orderId = $jResponse->orderId;

			$retArray["ORDERID"] = $jResponse->orderId;
		}
		else{
			$errorMsg = $this->getFeeniciaError($jResponse->responseCode);
			$errorTran = true;
			$this->log->error($errorMsg);
		}

		// Create Manual Sale
		if (! $errorTran) {
			$postData = array(
				'affiliation'		=> $this->getCredential('AFFILIATION'),
				'amount'			=> $payment->getAmount(),
				'transactionDate'	=> $this->_transactionDate,
				'orderId'			=> $this->_orderId,
				'tip'				=> 0,
				'pan'				=> $this->cryptData($payment->getCard()),
				'cardholderName'	=> $this->cryptData($payment->getCardHolderName()),
				'cvv2'				=> $this->cryptData($payment->getCVV()),
				'expDate'			=> $this->cryptData($payment->getExpirationDate())
			);

			$signJSON = $this->signJSON(json_encode($postData));

			if ($this->_mode == self::PRODUCTION) {
				$sEndpoint	= 'https://www.feenicia.com/atena-swa-services-0.1/sale/manual';
			}
			else {
				$sEndpoint	= 'http://54.203.245.137:10080/atna/sale/manual';
			}

			$data = json_encode($postData);
			
			$response = $this->requestAPI($sEndpoint, $signJSON, $data);
			$jResponse = json_decode($response);

			if($jResponse->responseCode == '00') {
				$this->_authNum = $jResponse->authnum;
				$this->_transactionId = $jResponse->transactionId;
				$this->_panTermination = $jResponse->card->last4Digits;

				$retArray["AUTHNUM"] = $jResponse->authnum;
				$retArray["TRANSACTIONID"] = $jResponse->transactionId;
				$retArray["PANTERMINATION"] = $jResponse->card->last4Digits;
			}
			else {
				$errorMsg = $this->getFeeniciaError($jResponse->responseCode);
				$errorTran = true;
				$this->log->error($errorMsg);
			}	
		}

		// Save Sale
		if (! $errorTran) {
			$postData = array(			
				"orderId"=> $this->_orderId,
				"transactionId"=> $this->_transactionId,
				"authnum"=> $this->_authNum,
				"transactionDate"=> date("Y-m-d H:i"),
				"panTermination"=> $this->_panTermination,
				"affiliation"=> $this->getCredential('AFFILIATION'),
				"merchant"=> $this->getCredential('MERCHANTID')
			);

			$signJSON = $this->signJSON(json_encode($postData));

			if ($this->_mode == self::PRODUCTION) {
				$sEndpoint	= 'https://www.feenicia.com/receipt/signature/save';
			}
			else {
				$sEndpoint	= 'http://54.203.245.137/receipt/signature/save';
			}

			$data = json_encode($postData);

			$response = $this->requestAPI($sEndpoint, $signJSON, $data);
			$jResponse = json_decode($response);

			if($jResponse->responseCode == '00') {
				$retArray["SAVESALE"] = true;
			}
			else {
				$errorMsg = $this->getFeeniciaError($jResponse->responseCode);
				$errorTran = true;
				$this->log->error($errorMsg);
			}
		}

		// Create Receipt
		if (! $errorTran) {
			$postData = array(			
				"OrderId"=>$this->_orderId, 
				"TransactionId"=>$this->_transactionId,
				"Total"=>$payment->getAmount(),
				"LegalEntityName"=>'Ayddo',
				"MerchantStreetNumColony"=>null, 
				"MerchantCityStateZipCode"=>null,
				"AffiliationId"=>$this->getCredential('AFFILIATION'), 
				"LastDigitsCard"=>$this->_panTermination,
				"Base64ImgSignature"=>null, 
				"AuthNumber"=>$this->_authNum,
				"OperationId"=>null, 
				"ControlNumber"=>null,
				"NameInCard"=>$this->cryptData($payment->getAmount()), 
				"DescriptionCard"=>null,
				"ReceiptDateTime"=>"0001-01-01T00:00:00",
				"AID"=>null, 
				"ARQC"=>null, 
				"MensajeComercio"=>'Compra realizada exitosamente',
				"ClientLogoBase64Data"=>null, 
				"ClientLogoDataType"=>'png',
				"SendUrlByMail"=>false,
				"Propina"=>0.0,
				"strMerchantId"=>null
			);

			$signJSON = $this->signJSON(json_encode($postData));

			if ($this->_mode == self::PRODUCTION) {
				$sEndpoint	= 'https://www.feenicia.com/receipt/receipt/CreateReceipt';
			}
			else {
				$sEndpoint	= 'http://54.203.245.137/receipt/receipt/CreateReceipt';
			}

			$data = json_encode($postData);

			$response = $this->requestAPI($sEndpoint, $signJSON, $data);
			$jResponse = json_decode($response);

			if($jResponse->responseCode == '00') {
				$this->_receiptId = $jResponse->receiptId;

				$retArray["RECEIPTID"] = $jResponse->receiptId;
			}
			else {
				$errorMsg = $this->getFeeniciaError($jResponse->responseCode);
				$errorTran = true;
				$this->log->error($errorMsg);
			}
		}

		// Send Receipt
		if (! $errorTran) {
			if ($payment->getSendMail()) {
				$email = $this->cryptData($payment->getMail());

				$postData = array(			
					"receiptId"=> $this->_receiptId,
					"Email"=>array($email)
				);

				$signJSON = $this->signJSON(json_encode($postData));

				if ($this->_mode == self::PRODUCTION) {
					$sEndpoint	= 'https://www.feenicia.com/receipt/receipt/SendReceipt';
				}
				else {
					$sEndpoint	= 'http://54.203.245.137/receipt/receipt/SendReceipt';
				}

				$data = json_encode($postData);

				$response = $this->requestAPI($sEndpoint, $signJSON, $data);
				$jResponse = json_decode($response);

				if($jResponse->responseCode == '00') {
					$retArray["SENT_MAIL"] = true;

					$this->pdfBase64 =  $jResponse->Base64Pdf;
				}
				else {
					$retArray["SENT_MAIL"] = false;
					$errorMsg = $this->getFeeniciaError($jResponse->responseCode);
					$errorTran = true;
					$this->log->error($errorMsg);
				}
			}
			else {
				$retArray["SENT_MAIL"] = false;
			}
		}

		$retArray["AMOUNT"] = $payment->getAmount();
		$retArray["CARD"] = $payment->getCard();
		$retArray["CARDHOLDER"] = $payment->getCardHolderName();
		$retArray["CVV"] = $payment->getCVV();
		$retArray["EXPDATE"] = $payment->getExpirationDate();
		$retArray["ERRORTRAN"] = $errorTran;
		$retArray["ERRORMSG"] = $errorMsg; 

		return $retArray;
	}

	/**
	 * Gets Base64 PDF Receipt
	 * 
	 * @return string Base64 PDF
	 */
	public function getPDFBase64()
	{
		return $this->pdfBase64;
	}

	/**
	 * Reverse Feenicia Payment
	 * 
	 * @param  array $encPayment Payment array
	 * @return boolean
	 */
	public function reversePayment($aPayment){
		$this->_transactionDate = round(microtime(true) * 1000);

		$postData = array(			
			"affiliation"=> $this->getCredential('AFFILIATION'),
			"amount"=> $aPayment["AMOUNT"],
			"transactionDate"=> $this->_transactionDate,
			"orderId"=> $aPayment["ORDERID"],
			"pan"=>$this->cryptData($aPayment["CARD"]),
			"cardholderName"=>$this->cryptData($aPayment["CARDHOLDER"]),
			"cvv2"=>$this->cryptData($aPayment["CVV"]),
			"expDate"=>$this->cryptData($aPayment["EXPDATE"]),
			"authnum"=>$aPayment["AUTHNUM"],
			"transactionId"=>$aPayment["TRANSACTIONID"]
		);

		$signJSON = $this->signJSON(json_encode($postData));

		if ($this->_mode == self::PRODUCTION) {
			$sEndpoint	= 'https://www.feenicia.com/atena-swa-services-0.1/reversal';
		}
		else {
			$sEndpoint	= 'http://54.203.245.137:10080/atna/reversal';
		}

		$data = json_encode($postData);

		$response = $this->requestAPI($sEndpoint, $signJSON, $data);

		$jResponse = json_decode($response);

		if ($jResponse->responseCode == '00')
			return true;
		else {
			$errorMsg = $this->getFeeniciaError($jResponse->responseCode);
			$this->log->error($errorMsg);

			return false;
		}
	}

	/**
	 * Returns Feenicia error message
	 * 
	 * @param  string $errorKey Error Key
	 * @return string           Error Message
	 */
	public function getFeeniciaError($errorKey)
	{
		return $this->errorArray[$errorKey];
	}

	/**
	 * Execute request to API
	 * 
	 * @param  string $sEndpoint      API EndPoint
	 * @param  string $xRequestedWith Signed Data
	 * @param  string $data           JSON Data
	 * @return mixed                  CURL Response
	 */
	private function requestAPI($sEndpoint, $xRequestedWith, $data){
		$array_headers = array(
			'Accept:application/json',
			'Content-Type:application/json',
			'X-Requested-With:' .  $xRequestedWith
		);

		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, $sEndpoint);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $array_headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}
}
?>