<?php

/**
 * WatsonPhone - Abstract Helper
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\WatsonResources;

use WatsonPhone\Services\AbstractService;

use WatsonPhone\Domains\DomainObjectFactory;
use WatsonPhone\Domains\DomainObjectInterface;

use WatsonPhone\WatsonResources\Exception\InvalidDomainObject;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Common\Http\Uri\UriInterface;
use WatsonPhone\Common\Exception\Exception;

abstract class AbstractResources
{	
	//@var DomainObjectFactory $domainObjectFactory; Domain object factory
	protected $domainObjectFactory;
	
	//@var DomainObjectInterface $domainObject; Account domain object
	protected $domainObject;
	

	//@var ClientInterface $httpClient; Http client
	protected $httpClient;

	//@var (array) $subresources;
	protected $subresources;
	
	
	/**
	 * __construct function
	 * Initializer.
	 */
	public function __construct( DomainObjectInterface $domainObject, 
								 DomainObjectFactory $domainObjectFactory,
								 ClientInterface $httpClient
	){
		// intialize
		$this->httpClient          = $httpClient;
		$this->domainObjectFactory = $domainObjectFactory;
		$this->domainObject        = $domainObject;
	}
	
	public function __call( $resource_name, $args )
	{
		/*if($this->validResource($resource_name))
		{
			$resourceFactory = new ResourceFactory($this->domainObjectFactory);
			$resource = $resourceFactory->build($resource_name);
			
			return $resource;
		}
		*/
		throw new Exception("Resource isn't available, please check docs for further instructions.");
		
	}

	public function __get( $property )
	{	
		if(isset($this->domainObject->$property))
		{
			return $this->domainObject->$property;
		}
		
		return null;
	}


	/**
	 * registerSubresources function
	 * This function registers restful subresources to watson's resource manager
	 *
	 * @param (array) $subresources; array of subresources
	 * @return void;
	 */
	public function registerSubresources( array $subresources )
	{
		foreach($subresources as $resource => $uri)
		{
			if($this->validateResource($resource)) {
				// valid subresource, setup the subresource here.
				$resourcesFactory = new ResourcesFactory( $this->domainObjectFactory );
				
				$newResource = $resourcesFactory->build($resource);
			}
		}
	}
	
	/**
	 * validateResource function
	 * Validates a resource name
	 *
	 * @param  (string) $resource_name; The resource name
	 * @return (bool); true on valid resource, false on non-valid resource
	 */
	protected function validateResource( $resource_name )
	{
		$resource_name = __NAMESPACE__ . "\\" . ucfirst($resource);
			
		if(class_exists($resource_name)){
			return true;
		}
		
		return false;
	}
} 