<?php

/**
 * WatsonPhone - WatsonPhone
 * WatsonPhone is a php5.3+ open-sourced library for connecting to phone services similar to
 * Twilio and Plivo. It's a modular implementation that is extendable to any other
 * services.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Client\StreamClient;
use WatsonPhone\Common\Http\Uri\UriInterface;
use WatsonPhone\Common\Exception\Exception;

 
class WatsonPhone
{
	//@var ClientInterface $httpClient; http client compliant to the clientinterface
	protected $httpClient;

	/**
	 * setHttpClient
	 * sets the http client
	 *
	 * @param ClientInterface $httpClient; The http client
	 * @return void
	 */
	public function setHttpClient( ClientInterface $httpClient )
	{
		$this->httpClient = $httpClient;
	}
	
	/**
	 * createService function
	 * Creates an existing service, \\Watson\\Services
	 *
	 * @param (string) $serviceName; The service name (required)
	 * @param CredentialsInterface $credentials; The service credentials (required)
	 * @param UriInterface $baseApiUri|null; The service base api uri (optional)
	 * @return ServiceInterface $service; The service object
	 */
	public function createService(
		$serviceName,
		CredentialsInterface $credentials,
		UriInterface $baseApiUri = null
	){		
		// if there are no http client selected, use default client
		if (!$this->httpClient) {
			$this->setHttpClient(new StreamClient()); // backwards compatibility
		}

		$normalizedServiceName = $this->normalizeServiceName($serviceName);
		
		if(!class_exists($normalizedServiceName)) {
			throw new Exception(sprintf('Service class %s does not exist.', $className));
		}
		
		return $this->buildService($normalizedServiceName, $credentials, $baseApiUri);
	}
	
	/**
	 * buildService
	 * Builds a service according to the service name, and returns it.
	 *
	 * @param (string) $serviceName; The service name (required)
	 * @param CredentialsInterface $credentials; The service credentials (required)
	 * @param UriInterface $baseApiUri|null; The service base api uri (optional)
	 * @return ServiceInterface $service; The service object
	 */
	private function buildService(
		$serviceName,
		CredentialsInterface $credentials,
		UriInterface $baseApiUri = null
	) {
		return new $serviceName($credentials, $this->httpClient, $baseApiUri);
	}
	
	/**
	 * normalizeServiceName
	 * Returns the correct/fully qualified service name
	 *
	 * @param (string) $serviceName; The service name
	 * @return (string) $serviceName; The normalized/qualified service name
	 */
	public function normalizeServiceName( $serviceName )
	{	
		return '\\WatsonPhone\\Services\\' . ucfirst($serviceName);
	}
}