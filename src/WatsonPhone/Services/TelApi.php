<?php

/**
 * WatsonPhone - TelApi Service Implementation
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

class TelApi extends AbstractService
{
	// @var (array) $versions; Twilio apis version supported
	protected $versions = array('v2');
		
	
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
		
		if($baseApiUri === null)
		{
			$this->baseApiUri = new Uri('https://api.telapi.com/'.end($this->versions).'/');
		}
	}
	
	/**
	 * getBaseApiUri function
	 * returns the base api uri
	 */
	public function getBaseApiUri()
	{
		return new Uri('https://api.telapi.com/'.end($this->versions).'/');
	}
}