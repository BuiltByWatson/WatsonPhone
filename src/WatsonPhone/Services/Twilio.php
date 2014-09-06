<?php

/**
 * WatsonPhone - Twilio Service Implementation
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Services;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Uri\UriInterface;
use WatsonPhone\Common\Http\Uri\Uri;
use WatsonPhone\Common\Exception\Exception;

class Twilio extends AbstractService
{
	// @var (array) $versions; Twilio apis version supported
	protected $versions = array('2008-08-01', '2010-04-01');
		
	
	/**
	 * __construct function
	 */
	public function __construct( 
		CredentialsInterface $credentials,
		ClientInterface $httpClient,
		UriInterface $baseApiUri = null
	) {
		// construct the abstract service
		parent::__construct($credentials, $httpClient, $baseApiUri);
		
		if($baseApiUri === null)
		{
			$this->baseApiUri = new Uri('https://api.twilio.com/'.end($this->versions).'/');
		}
	}
	
	/**
	 * getBaseApiUri function
	 * returns the base api uri
	 */
	public function getBaseApiUri()
	{
		return $this->baseApiUri->getAbsoluteUri();
	}
	
	/**
	 * getAccountApiUri function
	 * returns the base api uri for connecting to a service account
	 */
	public function getAccountApiUri()
	{
		return new Uri($this->getBaseApiUri().'Accounts/'.$this->credentials->getAuthId().'/');
	}
	
	public function getAccountParams(  )
	{
		
	}
	
	/**
	 * getCallApiUri function
	 * returns the base api uri for making calls
	 */
	public function getCallApiUri()
	{
		return new Uri($this->getBaseApiUri().'Accounts/'.$this->credentials->getAuthId().'/Calls/');
	}
}