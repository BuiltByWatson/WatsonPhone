<?php

/**
 * WatsonPhone - Calls WatsonResources
 * Main resource used for making calls out from watson.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\WatsonResources;

use WatsonPhone\Domains\DomainObjectInterface;
use WatsonPhone\Domains\DomainObjectFactory;

use WatsonPhone\WatsonResources\ResourcesFactory;
use WatsonPhone\WatsonResources\Exception\InvalidDomainObjectException;

class Calls
{	
	//@var DomainObjectInterface $domainObject; Account domain object
	protected $domainObject;
	
	
	/**
	 * __construct function
	 * Initialize.
	 */
	public function __construct( DomainObjectInterface $domainObject, 
								 DomainObjectFactory $domainObjectFactory,
								 ClientInterface $httpClient
	){
		if(!is_a($domainObject, 'WatsonPhone\Domains\Calls') &&
		   !is_a($domainObject, 'WatsonPhone\Domains\CallsCollection')) {
			throw new InvalidDomainObject('Invalid Domain Object given \''.$domainObject.'\'');	
		}
		
		// intialize abstract resource
		parent::__construct($domainObject, $domainObjectFactory, $httpClient);
	}
	
	/**
	 * call function
	 * Main function used to make calls out from WatsonPhone
	 */
	public function call( $to = null, $from = null, $endpoint = null )
	{
	}
	
	public function connect()
	{
		echo "Connecting...";
	}
}