<?php

/**
 * WatsonPhone - Resources Factory
 * WatsonResources factory class, builds new resources for WatsonPhone
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\WatsonResources;

use WatsonPhone\Common\Http\Client\ClientInterface;
use WatsonPhone\Domains\DomainObjectFactory;
use WatsonPhone\Domains\DomainObjectInterface;

class ResourcesFactory
{
	//@var DomainObjectFactory $domainObjectFactory; Domain object factory
	protected $domainObjectFactory;

	//@var StreamClient $httpClient; Http client
	protected $httpClient;
	

	/**
	 * __construct function
	 * Intializer.
	 */
	public function __construct( DomainObjectFactory $domainObjectFactory,
								 ClientInterface $httpClient )
	{
		$this->domainObjectFactory = $domainObjectFactory;
		$this->httpClient = $httpClient;
	}

	/**
	 * build method
	 * Factory method that returns a resource instance
	 * 
	 * @param string $name; Resource name
	 */
	public function build( $resource_name, DomainObjectInterface $domainObject = null )
	{
		$class_name = __NAMESPACE__ . "\\" . $resource_name;

		$instance = null;
		if(class_exists($class_name))
		{
			if(!$domainObject) {
				$domainObject = $this->domainObjectFactory->build($resource_name);
			}

			$instance = new $class_name( $domainObject, $this->domainObjectFactory, $this->httpClient );
		}

		return $instance;
	}
}