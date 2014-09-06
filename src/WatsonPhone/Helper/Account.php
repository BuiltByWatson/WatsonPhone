<?php

/**
 * WatsonPhone - Account Helper
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Helper;

use WatsonPhone\Domains\Account;
use WatsonPhone\Domains\AccountCollection;

use WatsonPhone\Services\AbstractService;
use WatsonPhone\Domains\DomainObjectFactory;
use WatsonPhone\Helper\Exception\InvalidDomainObject;

class Account
{
	//@var Account\AccountCollection $account; Account domain object
	protected $account;
	

	/**
	 * __construct function
	 * Initialize.
	 */
	public function __construct( $domainObject )
	{
		if(!is_a($domainObject, 'WatsonPhone\Domains\Account') &&
		   !is_a($domainObject, 'WatsonPhone\Domains\AccountCollection')) {
			throw new InvalidDomainObject('Invalid Domain Object given \''.$domainObject.'\'');	
		}
	}
	
	public function __get( $action )
	{
		if(function_exists($this->$action)) {
			$this->$action( $params )
		}
		
		return $this->account;
	}
	
	public function create( $params )
	{
		
	}
}