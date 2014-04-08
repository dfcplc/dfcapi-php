<?php
use mashape\unirestphp;

class Dfcapi
{

	private $api_url_checkkey 		   = 'https://api.debitfinance.co.uk/checkkey';
	private $api_url_viewdd 		   = 'https://api.debitfinance.co.uk/viewdd';
	private $api_url_viewdd_breakdown  = 'https://api.debitfinance.co.uk/viewddbreakdown';
	private $api_url_createDirectDebit = 'https://api.debitfinance.co.uk/setupdd';
	private $api_url_updateDirectDebit = 'https://api.debitfinance.co.uk/updatedd';
	private $api_url_cancelDirectDebit = 'https://api.debitfinance.co.uk/canceldd';

	private $errors = array();
	private $response_code = false;
	private $body = null;
	private $raw_body = null;
	private $headers = null;

	private $data = array();

	


	public function __construct($api_url = null)
	{
		if($api_url!==null)
		{
			$this->setApiUrl($api_url);
		}
	}

	public function setCheckKeyUrl($checkkey_url)
	{
		$this->api_url_checkkey = $checkkey_url;
	}

	public function setViewDirectDebitUrl($viewdd_url)
	{
		$this->api_url_viewdd = $viewdd_url;
	}

	public function setViewDirectDebitBreakdownUrl($viewdd_bd_url)
	{
		$this->api_url_viewdd_breakdown = $viewdd_bd_url;
	}

	public function setCreateDirectDebitUrl($setupdd)
	{
		$this->api_url_createDirectDebit = $setupdd;
	}

	public function setUpdateDirectDebitUrl($updatedd)
	{
		$this->api_url_updateDirectDebit = $updatedd;
	}

	public function setCancelDirectDebitUrl($cancelldd)
	{
		$this->api_url_cancelDirectDebit = $cancelldd;
	}

	/**
	 * Get API Returned Status
	 * @return string Returned Status
	 */
	public function getStatus()
	{
		return $this->body->status;
	}


	/**
	 * Get API Returned Errors
	 * @return string Returned Errors
	 */
	public function getErrors()
	{
		if(is_array($this->body->errors)){
			if(is_array($this->body->errors[0]))
				return $this->body->errors[0][0];
			else
				return $this->body->errors[0];
		}
		else
			return $this->body->errors;
	}

 

	/**
	 * Get API Response Code
	 * @return int HTTP Response Code
	 */
	public function getResponseCode()
	{
		return $this->response_code;
	}

	/**
	 * Get API Body (as an object)
	 * @return object API Body Object
	 */
	public function getResponseBody()
	{
		return $this->body;
	}

	/**
	 * Get API Details  
	 * @return object API Body Object
	 */
	public function getDetails()
	{
		return $this->body->details;
	}

	/**
	 * Get API Body (as raw)
	 * @return string API Body as RAW Data
	 */
	public function getResponseBodyRaw()
	{
		return $this->raw_body;
	}

	/**
	 * Get API Headers (as Array)
	 * @return array Headers Array
	 */
	public function getResponseHeaders()
	{
		return $this->headers;
	}

	/**
	 * Internal Method to clear the stored response
	 * - Called before each API Request is made
	 */
	private function clearStoredResponse()
	{
		$this->errors = array();
		$this->response_code = false;
		$this->body = null;
		$this->raw_body = null;
		$this->headers = null;
	}

	/**
	 * Internal method to set the stored response
	 *  - Called after each API Request is made
	 * 
	 * @param object $response Response Object from Unirest
	 */
	private function setStoredResponse($response)
	{
		if(isset($response->body) && isset($response->body->errors))
			$this->errors = $response->body->errors;
		$this->response_code = $response->code;
		$this->body = $response->body;
		$this->raw_body = $response->raw_body;
		$this->headers = $response->headers;
	}


	/**
	 * Check API Key/Secret for access
	 * 
	 * @param string $api_key DFC API Key
	 * @param string $api_secret DFC API Secret
	 * 
	 * @return boolean API Access Status (true/false)
	 */
	public function CheckApiKey($api_key,$api_secret)
	{
		$this->clearStoredResponse();

		$response = Unirest::get($this->api_url_checkkey, null, null, $api_key, $api_secret);

		$this->setStoredResponse($response);

		if(
			isset($response->code)
			&& $response->code===200
			&& isset($response->body->status)
			&& $response->body->status==='ok'
			&& isset($response->body->details->authentication->Access)
			&& $response->body->details->authentication->Access==='Live'
		)
		{
			return true;
		}

		return false;
	}



	/**
	 * View Direct Debits
	 * 
	 * @param string $api_key DFC API Key
	 * @param string $api_secret DFC API Secret
	 * @param string $dfc_ref DFC Reference Number
	 *
	 * @return object View Direct Debit Response
	 */
	public function ViewDirectDebit($api_key,$api_secret,$dfc_ref)
	{
		$this->clearStoredResponse();

		$response = Unirest::get($this->api_url_viewdd, null, array('dfc_reference'=>$dfc_ref), $api_key, $api_secret);
 
		$this->setStoredResponse($response);

		if(
			isset($response->code)
			&& $response->code===200
			&& isset($response->body->status)
			&& $response->body->status==='ok'
		)
		{
			return $reponse->body;
		}

		return false;
	}


	/**
	 * View Direct Debits Breakdown
	 * 
	 * @param string $api_key DFC API Key
	 * @param string $api_secret DFC API Secret
	 * @param string $dfc_ref DFC Reference Number
	 *
	 * @return object View Direct Debit Breakdown Response
	 */
	public function ViewDirectDebitBreakdown($api_key,$api_secret,$dfc_ref)
	{
		$this->clearStoredResponse();

		$response = Unirest::get($this->api_url_viewdd_breakdown, null, array('dfc_reference'=>$dfc_ref), $api_key, $api_secret);
		$this->setStoredResponse($response);

		if(
			isset($response->code)
			&& $response->code===200
			&& isset($response->body->status)
			&& $response->body->status==='ok'
		)
		{
			return $reponse->body;
		}

		return false;
	}

	/**
	 * Create Direct Debits  
	 * 
	 * @param string $api_key DFC API Key
	 * @param string $api_secret DFC API Secret
	 * @param string $client_reference DFC Client Reference Number
	 * @param string $reference 
	 * @param string $title 
	 * @param string $first_name 
	 * @param string $last_name 
	 * @param string $address1 
	 * @param string $address2 
	 * @param string $address3 
	 * @param string $town 
	 * @param string $county 
	 * @param string $postcode 
	 * @param array $amounts 
	 * @param string $email 
	 * @param string $account_number 
	 * @param string $sort_code 
	 * @param string $start_from
	 * @param string $installments
	 * @param int $frequency_unit
	 * @param string $frequncy_type
	 * @param string $roll_status 
	 * @param string $birth_date 
	 * @param string $mobile_number 
	 * @param string $phone_number 
	 * @param string $no_email 
	 * @param string $service_description
	 * @param string $bacs_reference
	 * @param boolean $skip_check  
	 *
	 * @return boolean API Return Status (true/false)
	 */
	public function CreateDirectDebit($api_key,$api_secret,$client_reference,$reference,$title,$first_name,$last_name,$address1,$address2,$address3,$town,$county,$postcode,$amounts,$email,$account_number,$sort_code,$start_from,$installments,$frequency_unit,$frequency_type,$roll_status,$birth_date,$mobile_number,$phone_number,$no_email,$service_description,$bacs_reference,$skip_check=false)
	{


		$data['authentication'] = array(
			'apikey'		=> $api_key,
			'apisecret'		=> $api_secret,
			'client_ref'	=> $client_reference
		);

		$data['payer']	=	array(
			'title'			=> $title,
			'first_name'	=> $first_name,
			'last_name'		=> $last_name,
			'birth_date'     => $birth_date
		);

		$data['address'] = array(
			'address1'	 => $address1,
			'address2'	 => $address2,
			'address3'	 => $address3,
			'town'		 => $town,
			'county'	 => $county,
			'postcode'	 => $postcode,
			'skip_check' => $skip_check
		);

		$data['contact'] = array(
			'phone'		=> $phone_number,
			'mobile'	=> $mobile_number,
			'email'		=> $email,
			'no_email'	=> $no_email
		);
		$data['bank'] = array(
			'account_number'	=>	$account_number,
			'sort_code'			=>	$sort_code
		);
		$data['subscription'] = array(
			'reference'		=> $reference,
			'description'	=> $service_description,
		    'amounts'	    => $amounts,
			'interval'	=> array(
				'unit'		=> $frequency_unit,
				'frequency'	=> $frequency_type
			),
			'start_from'		=> $start_from,
			'installments'		=> $installments,
			'bacs_reference'	=> $bacs_reference,
			'roll_status'		=> $roll_status
		);

		$this->clearStoredResponse();
		$response = Unirest::post($this->api_url_createDirectDebit, array( "Content-Type" => "application/json", "Accept" => "application/json" ),
		  json_encode(
		  	$data
		  )
		);
 
		$this->setStoredResponse($response);

		if(
			isset($response->code)
			&& $response->code===200
			&& isset($response->body->status)
			&& $response->body->status==='ok'
		)
		{
			return true;
		}

		return false;

	}


	/**
	 * Update Direct Debits  
	 * 
	 * @param string $api_key DFC API Key
	 * @param string $api_secret DFC API Secret
	 * @param string $dfc_ref DFC Customer Reference
	 * @param string $reference 
	 * @param string $title 
	 * @param string $first_name 
	 * @param string $last_name 
	 * @param string $address1 
	 * @param string $address2 
	 * @param string $address3 
	 * @param string $town 
	 * @param string $county 
	 * @param string $postcode
	 * @param string $email 
	 * @param string $account_number 
	 * @param string $sort_code
	 * @param string $birth_date 
	 * @param string $mobile_number 
	 * @param string $phone_number
	 * @param int $payment_date
	 * @param string $applyfrom_paydate
	 * @param string $installmentduedate
	 * @param string $installmentamount
	 * @param string $latepayment
	 * @param string $applyfrom
	 * @param string $newamount
	 *
	 * @return boolean API Direct Debit Update Status (true/false)
	 */
	public function UpdateDirectDebit($api_key,$api_secret,$dfc_ref,$reference,$title,$first_name,$last_name,$address1,$address2,$address3,$town,$county,$postcode,$email,$account_number,$sort_code,$birth_date,$mobile_number,$phone_number,$paymentdate,$applyfrom_paydate,$installmentduedate,$installmentamount, $latepayment, $applyfrom, $newamount)
	{

		$data['authentication'] = array(
			'apikey'		=> $api_key,
			'apisecret'		=> $api_secret,
			'dfc_ref'		=> $dfc_ref
		);

		$data['payer']	=	array(
			'type'			=> '',
			'title'			=> $title,
			'first_name'	=> $first_name,
			'last_name'		=> $last_name,
			'birth_date'	=> $birth_date
		);

		$data['address'] = array(
			'address1'	=> $address1,
			'address2'	=> $address2,
			'address3'	=> $address3,
			'town'		=> $town,
			'county'	=> $county,
			'postcode'	=> $postcode
		);

		$data['contact'] = array(
			'phone'		=> $phone_number,
			'mobile'	=> $mobile_number,
			'email'		=> $email
		);
		
		$data['bank'] = array(
			'account_number'	=>	$account_number,
			'sort_code'			=>	$sort_code
		);
				
		$data['cancel'] = array(
			'cancel_from'   => '',
		);

		$data['general'] = array(
			'yourref'		=> $reference,
			'paymentdate'	=> $paymentdate,
			'cancel_from'   => '',
			'installmentduedate'=> $installmentduedate,
			'installmentamount'		=> $installmentamount ,
			'latepayment'	=> $latepayment,
			'applyfrom'	=>  $applyfrom ,
			'applyfrom_paydate'	=> $applyfrom_paydate ,
			'newamount'	=> $newamount 							
		);




		$this->clearStoredResponse();
		$response = Unirest::post($this->api_url_updateDirectDebit, array( "Content-Type" => "application/json", "Accept" => "application/json" ),
		  json_encode(
		  	$data
		  )
		);


		$this->setStoredResponse($response);

		if(
			isset($response->code)
			&& $response->code===200
			&& isset($response->body->status)
			&& $response->body->status==='ok'
		)
		{
			return true;
		}

		return false;

	}


	/**
	 * Cancel Direct Debits  
	 * 
	 * @param string $api_key DFC API Key
	 * @param string $api_secret DFC API Secret
	 * @param string $dfc_ref DFC Customer Reference
	 * @param string $apply_from
	 *
	 * @return boolean API Cancel Status (true/false)
	 */	public function CancelDirectDebit($api_key,$api_secret,$dfc_ref,$apply_from)
	{
		
		$data['authentication'] = array(
			'apikey'		=> $api_key,
			'apisecret'		=> $api_secret,
			'dfc_ref'		=> $dfc_ref
		);

		$data['cancel'] = array(
			'apply_from'   => $apply_from,								
		);
 

		$this->clearStoredResponse();
		$response = Unirest::post($this->api_url_cancelDirectDebit, array( "Content-Type" => "application/json", "Accept" => "application/json" ),
		  json_encode(
		  	$data
		  )
		);

		$this->setStoredResponse($response);

		if(
			isset($response->code)
			&& $response->code===200
			&& isset($response->body->status)
			&& $response->body->status==='ok'
		)
		{
			return true;
		}

		return false;

	}

}
