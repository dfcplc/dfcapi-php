<?php
class DfcapiTest extends PHPUnit_Framework_TestCase
{

	public function testCheckApiKey()
	{
		$dfcapi = new Dfcapi();
		$dfcapi->setCheckKeyUrl('http://httpbin.org/get');

		$dfcapi->CheckApiKey('TEST-TEST-TEST-TEST','fee78bd3bf59bfb36238b3f67de0a6ea103de130');
		$this->assertEquals(200, $dfcapi->getResponseCode());
		$this->assertEquals('Basic VEVTVC1URVNULVRFU1QtVEVTVDpmZWU3OGJkM2JmNTliZmIzNjIzOGIzZjY3ZGUwYTZlYTEwM2RlMTMw',$dfcapi->getResponseBody()->headers->Authorization);
	}

	public function testViewDirectDebits()
	{
		$dfcapi = new Dfcapi();
		$dfcapi->setViewDirectDebitUrl('http://httpbin.org/get');

		$dfcapi->ViewDirectDebit('TEST-TEST-TEST-TEST','fee78bd3bf59bfb36238b3f67de0a6ea103de130','000101AA0001');

		$this->assertEquals(200, $dfcapi->getResponseCode());
		$this->assertEquals('Basic VEVTVC1URVNULVRFU1QtVEVTVDpmZWU3OGJkM2JmNTliZmIzNjIzOGIzZjY3ZGUwYTZlYTEwM2RlMTMw',$dfcapi->getResponseBody()->headers->Authorization);
		$this->assertEquals('000101AA0001',$dfcapi->getResponseBody()->args->dfc_reference);
	}

	public function testViewDirectDebitsBreakdown()
	{
		$dfcapi = new Dfcapi();

		$dfcapi->setViewDirectDebitBreakdownUrl('http://httpbin.org/get');

		$dfcapi->ViewDirectDebitBreakdown('TEST-TEST-TEST-TEST','fee78bd3bf59bfb36238b3f67de0a6ea103de130','000101AA0001');

		$this->assertEquals(200, $dfcapi->getResponseCode());
		$this->assertEquals('Basic VEVTVC1URVNULVRFU1QtVEVTVDpmZWU3OGJkM2JmNTliZmIzNjIzOGIzZjY3ZGUwYTZlYTEwM2RlMTMw',$dfcapi->getResponseBody()->headers->Authorization);
		$this->assertEquals('000101AA0001',$dfcapi->getResponseBody()->args->dfc_reference);
	}

	public function testCreateDirectDebit()
	{
		$dfcapi = new Dfcapi();

		$dfcapi->setCreateDirectDebitUrl('http://httpbin.org/post');

		$dfcapi->CreateDirectDebit('TEST-TEST-TEST-TEST','fee78bd3bf59bfb36238b3f67de0a6ea103de130','0001','ABC00001','Mr','Joe','Bloggs','1 Park Lane','','','London','','E15 2JG',array(10,10,10,10,10,10,10,10,10,10,10,10),'joebloggs@email.com','00000000','000000','2015-01-01',12,1,'MONTH','Y','1970-01-01','01234567890','07777777777','Y','Gym Membership','');
		
		$this->assertEquals(200, $dfcapi->getResponseCode());
		$this->assertEquals('{"authentication":{"apikey":"TEST-TEST-TEST-TEST","apisecret":"fee78bd3bf59bfb36238b3f67de0a6ea103de130","client_ref":"0001"},"payer":{"title":"Mr","first_name":"Joe","last_name":"Bloggs","birth_date":"1970-01-01"},"address":{"address1":"1 Park Lane","address2":"","address3":"","town":"London","county":"","postcode":"E15 2JG","skip_check":false},"contact":{"phone":"07777777777","mobile":"01234567890","email":"joebloggs@email.com","no_email":"Y"},"account":{"account_number":"00000000","sortcode":"000000"},"subscription":{"reference":"ABC00001","description":"Gym Membership","amounts":[10,10,10,10,10,10,10,10,10,10,10,10],"interval":{"unit":1,"frequency":"MONTH"},"start_from":"2015-01-01","installments":12,"bacs_reference":"","roll_status":"Y"}}',$dfcapi->getResponseBody()->data);
	}

	public function testUpdateDirectDebit()
	{
		$dfcapi = new Dfcapi();

		$dfcapi->setUpdateDirectDebitUrl('http://httpbin.org/post');

		$dfcapi->UpdateDirectDebit('TEST-TEST-TEST-TEST','fee78bd3bf59bfb36238b3f67de0a6ea103de130','000101AA0001','','','','','','','','','','','','','','','','','15','012015','','','','','');

		$this->assertEquals(200, $dfcapi->getResponseCode());
		$this->assertEquals('{"authentication":{"apikey":"TEST-TEST-TEST-TEST","apisecret":"fee78bd3bf59bfb36238b3f67de0a6ea103de130","dfc_ref":"000101AA0001"},"payer":{"title":"","first_name":"","last_name":"","birth_date":""},"address":{"address1":"","address2":"","address3":"","town":"","county":"","postcode":""},"contact":{"phone":"","mobile":"","email":""},"bank":{"account_number":"","sort_code":""},"general":{"yourref":"","paymentdate":"15","installmentduedate":"","installmentamount":"","latepayment":"","applyfrom":"","applyfrom_paydate":"012015","newamount":""}}',$dfcapi->getResponseBody()->data);
	}


	public function testCancelDirectDebit()
	{
		$dfcapi = new Dfcapi();

		$dfcapi->setCancelDirectDebitUrl('http://httpbin.org/post');

		$dfcapi->CancelDirectDebit('TEST-TEST-TEST-TEST','fee78bd3bf59bfb36238b3f67de0a6ea103de130','000101AA0001','2015-01-01');
		
		$this->assertEquals(200, $dfcapi->getResponseCode());
		$this->assertEquals('{"authentication":{"apikey":"TEST-TEST-TEST-TEST","apisecret":"fee78bd3bf59bfb36238b3f67de0a6ea103de130","dfc_ref":"000101AA0001"},"cancel":{"apply_from":"2015-01-01"}}',$dfcapi->getResponseBody()->data);
	}

}