<?php

/**
 * WatsonPhone - Twilio Service Implementation
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Services;

use WatsonPhone\Domains\DomainObjectInterface;

use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Uri\UriInterface;
use WatsonPhone\Common\Http\Uri\Uri;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Exception\Exception;

class Twilio extends AbstractService
{
	// @var (array) $versions; Twilio apis version supported
	protected $versions = array('2008-08-01', '2010-04-01');
	
	
	/**
	 * __construct function
	 * Initializer.
	 *
	 * @params CredentialsInterface $credentials; Service credentials
	 * @params ClientInterface $httpClient; Http client
	 * @params UriInterface $baseApiUri|null; Service base api
	 * @return void;
	 */
	public function __construct( 
		CredentialsInterface $credentials,
		ClientInterface $httpClient,
		UriInterface $baseApiUri = null
	){
		// construct the abstract service
		parent::__construct($credentials, $httpClient, $baseApiUri);
		
		if($baseApiUri === null){
			$this->baseApiUri = new Uri('https://api.twilio.com/'.end($this->versions));
		}
	}
	
	public function parseJsonData( $data )
	{
		// parse data
		$data = json_decode($data, true);	
		if($data === null || !is_array($data)) {
			throw new Exception("Unable to parse response.");
		}
		
		return $data;
	}
	
	/**
	 * Service Specific Functions
	 */
	
	/**
	 * getAccountApiUri function
	 * returns the base api uri for connecting to a service account
	 */
	public function getAccountApiUri( $account_id )
	{	
		return new Uri(
			$this->baseApiUri->getAbsoluteUri()."/Accounts/{$account_id}.json"
		);
	}
	
	/**
	 * getAccountExtraHeaders function
	 */
	public function getAccountExtraHeaders()
	{
		return array();
	}
	
	/**
	 * getAccountAdditionalParameters function
	 */
	public function getAccountAdditionalParameters()
	{
		return array();
	}
	
	/**
	 * parseAccountResponse function
	 */
	public function parseAccountResponse( DomainObjectInterface $accountDomain, $response_body )
	{	
		// parse data
		$data = $this->parseJsonData($response_body);
		
		// iterate through the data and set appropriate domain properties
		foreach($data as $key => $value) 
		{
			if($key == 'friendly_name') {
				$accountDomain->setAccountName($value);
				continue;
			}
			
			if($key == 'subresource_uris') {
				$accountDomain->setSubresources($value);
				continue;
			}
			
			// add to domain's extra properties
			$accountDomain->$key = $value;
		}
				
		return $accountDomain;
	}
	
	/**
	 * getCallApiUri function
	 * returns the base api uri for making calls
	 */
	public function getCallApiUri( $account_id, $call_id = null )
	{	
		return new Uri(
			$this->baseApiUri->getAbsoluteUri()."/Accounts/{$account_id}/Calls/{$call_id}.json"
		);
	}
	
	/**
	 * getAccountExtraHeaders function
	 */
	public function getCallExtraHeaders()
	{
		return array();
	}
	
	/**
	 * getCallAdditionalParameters function
	 */
	public function getCallAdditionalParameters()
	{
		return array();
	}
	
	/**
	 * parseCallResponse function
	 */
	public function parseCallResponse( DomainObjectInterface $callDomain, $api_response )
	{
		$callCollectionDomain = null; // collection of calls
	
		// parse data
		$data = $this->parseJsonData($api_response);
				
		// depending on the data received, start a collection of calls
		if(isset($data["calls"])) {
			$callCollectionDomain = $this->domainObjectFactory->build("CallsCollection");
		}
		
		// parse call data
		if($callCollectionDomain) {
			foreach($data["calls"] as $i => $call) {
				$callCollectionDomain->addToCollection($this->parseCall($call));
			}
			
			$callDomain = $callCollectionDomain;
		} else {
			$callDomain = $this->parseCall($data);
		}
		
		// return domain object
		return $callDomain;
	}
	
	public function parseCall( array $call )
	{
		$callDomain = $this->domainObjectFactory->build("Calls");
	
		// iterate through the data and set appropriate domain properties
		foreach($call as $key => $value)
		{
			if($key == "account_sid"){
				$callDomain->setAccountId($value);
				continue;
			}
		
			if($key == "sid"){
				$callDomain->setCallId($value);
				continue;
			}
			
			if($key == "parent_call_sid"){
				$callDomain->setCallParentId($value);
				continue;
			}
		
			if($key == "to"){
				$callDomain->setToNumber(substr($value, 1));
				continue;
			}
			
			if($key == "from"){
				$callDomain->setFromNumber(substr($value, 1));
				continue;
			}
			
			if($key == "status"){
				$callDomain->setStatus($value);
				continue;
			}
			
			if($key == "price"){
				$callDomain->setPrice($value." ".$call["price_unit"]);
				continue;
			}
			
			if($key == "duration"){
				$callDomain->setDuration($value);
				continue;
			}
			
			if($key == "start_time"){
				$callDomain->setStartTime($value);
				continue;
			}
			
			if($key == "end_time"){
				$callDomain->setEndTime($value);
				continue;
			}
			
			if($key == "direction"){
				$callDomain->setDirection($value);
				continue;
			}
			
			// register subresources
			if($key == "subresource_uris"){
				$callDomain->setSubresources($value);
				continue;
			}
			
			
			// add to domain's extra properties
			$callDomain->$key = $value;
		}
		
		return $callDomain;
	}
	
	/**
	 * getMessageApiUri function
	 * returns the base api uri for messages
	 */
	public function getMessageApiUri( $account_id, $message_id = null )
	{
		return new Uri(
			$this->baseApiUri->getAbsoluteUri()."/Accounts/{$account_id}/Messages/{$message_id}.json"
		);
	}
	
	/**
	 * getMessageExtraHeaders function
	 */
	public function getMessageExtraHeaders()
	{
		return array();
	}
	
	/**
	 * getMessageAdditionalParameters function
	 */
	public function getMessageAdditionalParameters()
	{
		return array();
	}
	
	/**
	 * parseMessageResponse function
	 */
	public function parseMessageResponse( DomainObjectInterface $callDomain, $api_response )
	{
	
	}
}