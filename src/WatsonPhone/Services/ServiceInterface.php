<?php

/**
 * WatsonPhone - ServiceInteface
 * Service interface.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Services;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Uri\UriInterface;

interface ServiceInterface
{	
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
	);
}