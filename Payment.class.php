<?php
namespace Feenicia;

/**
 * Payment
 *
 * Feenicia Payment Class
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
 * @category   Payment
 * @package    Feenicia
 * @copyright  Copyright 2019 Jorge Alberto Ponce Turrubiates
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0.0, 2019-07-08
 * @author     Jorge Alberto Ponce Turrubiates (the.yorch@gmail.com)
 */
class Payment
{
	/**
	 * Credit/Debit Card
	 * 
	 * @var string
	 */
	private $card = '';

	/**
	 * Card Holder Name
	 * 
	 * @var string
	 */
	private $cardHolderName = '';

	/**
	 * CVV
	 * 
	 * @var string
	 */
	private $CVV = '';

	/**
	 * Card Expiration Date (YYMM)
	 * 
	 * @var string
	 */
	private $expDate = '';

	/**
	 * Payment Items Detail
	 * 
	 * @var array
	 */
	private $items = array();

	/**
	 * Payment Amount
	 * 
	 * @var float
	 */
	private $amount = 0.00;

	/**
	 * Send Mail
	 * 
	 * @var boolean
	 */
	private $sendMail = false;

	/**
	 * User Email
	 * 
	 * @var string
	 */
	private $mail = '';

	/**
	 * Sets Credit/Debit Card
	 * 
	 * @param string $card Customer Card
	 */
	public function setCard($card) 
	{
		$this->card = $card;
	}

	/**
	 * Gets Credit/Debit Card
	 * 
	 * @return string Customer Card
	 */
	public function getCard() 
	{
		return $this->card;
	}

	/**
	 * Sets CardHolder Name
	 * 
	 * @param string $cardHolderName CardHolder Name
	 */
	public function setCardHolderName($cardHolderName) 
	{
		$this->cardHolderName = $cardHolderName;
	}

	/**
	 * Gets CardHolder Name
	 * 
	 * @return string CardHolder Name
	 */
	public function getCardHolderName() 
	{
		return $this->cardHolderName;
	}

	/**
	 * Sets CVV
	 * 
	 * @param string $CVV CVV
	 */
	public function setCVV($CVV) 
	{
		$this->CVV = $CVV;
	}

	/**
	 * Gets CVV
	 * 
	 * @return string CVV
	 */
	public function getCVV() 
	{
		return $this->CVV;
	}

	/**
	 * Sets Expiration Date (YYMM)
	 * 
	 * @param string $expDate Expiration Date
	 */
	public function setExpirationDate($expDate) 
	{
		$this->expDate = $expDate;
	}

	/**
	 * Gets Expiration Date (YYMM)
	 * 
	 * @return string Expiration Date
	 */
	public function getExpirationDate() 
	{
		return $this->expDate;
	}

	/**
	 * Indicates if will send Email
	 * 
	 * @param  boolean $sendMail Send Mail Flag
	 */
	public function sendMail($sendMail) 
	{
		$this->sendMail = $sendMail;
	}

	/**
	 * Sets Email
	 * 
	 * @param string $mail Customer Mail
	 */
	public function setMail($mail) 
	{
		$this->mail = $mail;
	}

	/**
	 * Gets Amount
	 * 
	 * @return float Amount
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * Gets Send Mail Flag
	 * 
	 * @return boolean Will Send Mail Flag
	 */
	public function getSendMail()
	{
		return $this->sendMail;
	}

	/**
	 * Gets Customer Mail
	 * 
	 * @return string Customer Mail
	 */
	public function getMail()
	{
		return $this->mail;
	}

	/**
	 * Set Payment Item
	 * 
	 * @param string $description Item Description
	 * @param float  $price       Unit Price
	 * @param int    $quantity    Quantity
	 */
	public function setItem($description, $price, $quantity)
	{
		$aItem = array(
			    "Quantity"    => (string)$quantity,
			    "description" => $description,
			    "unitPrice"   => (string)$price,
			    "amount"    => $price * $quantity,
			    "Id"      => (int)0
			  );

		$this->amount = $this->amount + ($price * $quantity);

		array_push($this->items, $aItem);
	}

	/**
	 * Gets Payment Items
	 * 
	 * @return array Items
	 */
	public function getItems() {
		return $this->items;
	}
}
?>