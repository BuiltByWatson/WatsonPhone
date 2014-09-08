<?php

/**
 * WatsonPhone - Abstract Service
 * Service abstraction
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Services;

use WatsonPhone\Domains\DomainObjectFactory;
use WatsonPhone\WatsonResources\ResourcesFactory;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Uri\UriInterface;
use WatsonPhone\Common\Exception\Exception;


abstract class AbstractService implements ServiceInterface
{
	//@var DomainObjectFactory $domainObjectFactory; domain object factory
	protected $domainObjectFactory;
	
	//@var ResourcesFactory $resourcesFactory; WatsonResources object factory
	protected $resourcesFactory;
	
	
	//@var CredentialsInterface $credentials; service credentials
	protected $credentials;

	//@var UriInterface $baseApiUri|null; base api uri
	protected $baseApiUri;
	
	//@var ClientInterface $httpClient; http client
	protected $httpClient;
	
	
	/**
	 * __construct function
	 * Intializes the abstract service
	 *
	 * @param CredentialsInterface $credentials; Service credentials
	 * @param ClientInterface $httpClient; Http client
	 * @param UriInterface $baseApiUri; Uri Interface, base api uri
	 */
	public function __construct(
		CredentialsInterface $credentials,
		ClientInterface $httpClient,
		UriInterface $baseApiUri = null
	){
		// setup api requirements
		$this->credentials = $credentials;
		$this->httpClient  = $httpClient;
		$this->baseApiUri  = $baseApiUri;
		
		// setup factories
		$this->domainObjectFactory = new DomainObjectFactory();
		$this->resourcesFactory    = new ResourcesFactory( $this->domainObjectFactory,
														   $this->httpClient );
	}
	
	/**
	 * getAuthenticationHeaders()
	 * Returns a base64_encoded string containing the auth_id and auth_token as
	 * username and password. It's used as basic authentication for most services.
	 *
	 * @return (array) $authHeaders; extra header settings.
	 */
	public function getAuthenticationHeaders()
	{		
		return array(
			'Authorization' => 'Basic '.base64_encode($this->credentials->getAuthId().":".
													$this->credentials->getAuthToken())
		);
	}
	
	/**
	 * Mandatory Service Functions
	 */

	/**
	 * account function
	 * This function is part of the abstract service interface, it's mandatory for
	 * all services in this library.
	 */
	 public function account( 
	 	$account_id = null,
	 	$additionalParameters = array(), 
	 	$method = "GET"
	 ){
	 	if(!$account_id) {
	 		$account_id = $this->credentials->getAuthId();
	 	}
	 
	 	// setup account domain object
	 	$accountDomainObject = $this->domainObjectFactory->build('Accounts'); 	
	 	
	 	$accountDomainObject->setAccountId($account_id);
	 	$accountDomainObject->setAccountUri($this->getAccountApiUri($account_id));
	 	
	 	// setup the url
	 	$parameters = array_merge(
			$additionalParameters,
			$this->getAccountAdditionalParameters()
		);
		
		$url = clone $accountDomainObject->getAccountUri();
 		foreach($parameters as $key => $value) {
 			$url->addToQuery($key, $value);
 		}
	 	
		// make http request
	 	try
	 	{
	 		$response = $this->httpClient->retrieveResponse(
	 			$url,
	 			null, // request body
	 			array_merge(
	 				$this->getAccountExtraHeaders(),
	 				$this->getAuthenticationHeaders()
	 			),
	 			$method
	 		);
	 	} catch(Exception $e) { // request failed
	 		echo "WatsonPhone request failed: {$e->getMessage()}"; exit;
	 	}


		// parse response & setup account resource
		$accountDomain   = $this->parseAccountResponse($accountDomainObject, $response);
	 	$accountResource = $this->resourcesFactory->build('Accounts', $accountDomainObject);
	 	
	 	// register subresources
	 	//$accountResource->registerSubresources();

	 	return $accountResource;
	 }

	/**
	 * call function
	 */
	public function call(
		$call_id = null,
		$account_id = null,
		$additionalParameters = array(), 
		$method = "GET"
	){
		
		$account_id = ($account_id === null ? $this->credentials->getAuthId() : $account_id);
	
		// setup call domain
		$callDomain = $this->domainObjectFactory->build('Calls');
		$callDomain->setCallId($call_id);
		
		// setup the url
		$parameters = array_merge(
	 		$this->getCallAdditionalParameters(), $additionalParameters
	 	);
	 	
		$url = clone $this->getCallApiUri($account_id, $call_id);
 		foreach($parameters as $key => $value) {
 			$url->addToQuery($key, $value);
 		}
		
		// make http request
	 	try
	 	{
	 		$response = $this->httpClient->retrieveResponse(
	 			$url,
	 			null,
	 			array_merge(
	 				$this->getAccountExtraHeaders(),
	 				$this->getAuthenticationHeaders()
	 			),
	 			$method
	 		);
	 	} catch(Exception $e) {
	 		echo "WatsonPhone request failed: {$e->getMessage()}"; exit;
	 	}
				
		// parse response
		$callDomain = $this->parseCallResponse($callDomain, $response);
		$callResource  = $this->resourcesFactory->build('Calls', $callDomain);
				
		return $callResource;
	}
	
	/**
	 * messages function
	 */
	public function message( array $addtionalParameters = array() )
	{
		
	}
}