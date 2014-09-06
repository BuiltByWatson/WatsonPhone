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

use WatsonPhone\Helper\Call as HelperCall;
use WatsonPhone\Helper\Messages as HelperMessages;
use WatsonPhone\Helper\Account as HelperAccount;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Uri\UriInterface;
use WatsonPhone\Common\Exception\Exception;


abstract class AbstractService implements ServiceInterface
{
	//@var DomainObjectFactory $domainObjectFactory; domain object factory
	protected $domainObjectFactory;
	
	
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
	) {

		$this->domainObjectFactory = new DomainObjectFactory();
	
		$this->credentials = $credentials;
		$this->httpClient  = $httpClient;
		$this->baseApiUri  = $baseApiUri;
	}

	/**
	 * account function
	 */
	 public function account($auth_id = null)
	 {
	 	if(!$auth_id) {
	 		$auth_id = $this->credentials->getAuthId();
	 	}
	 
	 	$accountDomain = $this->domainObjectFactory->build('Account');
	 	$accountDomain->setAccountId($auth_id);
	 	
	 	$response = $this->httpClient->retrieveResponse(
	 		$this->getAccountApiUri(),
	 		""
	 	);

	 	return array($accountDomain, $response);
	 }

	/**
	 * createSubaccount function
	 */
	public function createSubaccount()
	{
	
	}

	/**
	 * call function
	 */
	public function call()
	{
		$callDomain = $this->domainObjectFactory->build('Call');
		$callHelper = new HelperCall( $callDomain );
		
		return $callDomain;
	}
}