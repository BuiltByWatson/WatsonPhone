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

use WatsonPhone\Common\Http\Uri\Uri;
use WatsonPhone\Common\Http\Uri\UriInterface;


class Accounts extends AbstractDomainObject
{
	//@var (string) $account_id;
	public $account_id;
	
	//@var (string) $name; human readable name
	public $name;
	
	//@var (string) $account_balance; account balance
	public $balance;
	
	
	//@var \WatsonPhone\Common\Http\Uri\Uri $uri; uri relative to restful api
	public $uri;
	
	
	/**
	 * prepare function
	 * Initializer.
	 */
	public function prepare()
	{
		// init function for the domain object
	}
	
	public function setAccountId( $account_id )
	{
		$this->account_id = $account_id;
	}
	
	public function getAccountId()
	{
		return $this->account_id;
	}
	
	public function setAccountName( $name )
	{
		$this->name = $name;
	}
	
	public function getAccountName()
	{
		return $this->name;
	}
	
	public function setAccountBalance( $balance )
	{
		$this->balance = $balance;
	}
	
	public function getAccountBalance()
	{
		return $this->balance;
	}
	
	public function setAccountUri( UriInterface $uri )
	{
		$this->uri = $uri;
	}
	
	public function getAccountUri()
	{
		return $this->uri;
	}
}

/**
 * AccountsCollection should be a domain object for a collection of accounts, there
 * needs to be a legitimate reason to have this class, such as several subaccounts. But
 * could also be handled by the accounts collection. What about several calls, several messages
 * how you want to interface with it.
 */
class AccountsCollection extends AbstractDomainObject
{
	public $accounts;
	
	public function prepare()
	{
	}
}