<?php

/**
 * WatsonPhone - Account Domain Object
 * Domain object representing "account" for services.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Domains;

class Account
{
	//@var (string) $account_id;
	protected $account_id;
	
	//@var (string) $name; human readable name
	protected $name;
	
	//@var (array) $domainMap; collection of extra vars
	protected $domainMap;
	
	

	public function prepare()
	{
		// init function for the domain object
		$this->domainMap = array();
	}
	
	public function setAccountId( $account_id )
	{
		$this->account_id = $account_id;
	}
	
	public function setName( $name )
	{
		$this->name = $name;
	}
}