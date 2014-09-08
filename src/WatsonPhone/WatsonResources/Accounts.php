<?php

/**
 * WatsonPhone - Account Resource
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\WatsonResources;

use WatsonPhone\Domains\DomainObjectInterface;
use WatsonPhone\Domains\DomainObjectFactory;

use WatsonPhone\Common\Http\Client\ClientInterface;

use WatsonPhone\WatsonResources\ResourcesFactory;
use WatsonPhone\WatsonResources\Exception\InvalidDomainObjectException;


class Accounts extends AbstractResources
{
	/**
	 * __construct function
	 * Initialize.
	 */
	public function __construct( DomainObjectInterface $domainObject, 
								 DomainObjectFactory $domainObjectFactory,
								 ClientInterface $httpClient
	){	
		if(!is_a($domainObject, 'WatsonPhone\Domains\Accounts') && 
		   !is_a($domainObject, 'WatsonPhone\Domains\AccountsCollection')) {
			throw new InvalidDomainObjectException('Invalid Domain Object given.');	
		}
		
		// intialize abstract resource
		parent::__construct($domainObject, $domainObjectFactory, $httpClient);
	}
	
	public function __get( $property )
	{
	}
	
	/**
	 * Resource Functions
	 */
	
	/**
	 * account function
	 * Main function to get account data
	 */
	public function getAccount(
		DomainObjectInterface $accountDomain = null,
	 	$additionalParameters = array(), 
	 	$method = "GET"
	){
		// setup api url
		
		
		$url = clone $this->getAccountApiUri($account_id);
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
		$accountDomain   = $this->parseAccountResponse($accountDomain, $response);
	 	$accountResource = $this->resourcesFactory->build('Accounts', $accountDomain);
	}
}