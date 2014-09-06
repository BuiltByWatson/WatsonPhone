<?php

/**
 * WatsonPhone - Plivo Service Implementation
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Common\Credentials;

use WatsonPhone\Common\Credentials\CredentialsInterface;
use WatsonPhone\Common\Exception\Exception;


class Credentials implements CredentialsInterface
{
	//@const (int) TEST_CREDENTIALS;
	const TEST_CREDENTIALS = 0;
	
	//@const (int) STANDARD_CREDENTIALS;
	const STANDARD_CREDENTIALS = 1;


	//@var (string) $auth_id;
	protected $auth_id;
	
	//@var (string) $auth_token;
	protected $auth_token;
	
	//@var (string) $type;
	protected $type;
	
	
	/**
	 * __construct function
	 * Service Credentials interface for most services.
	 *
	 * @param (string) $auth_id; authentication id
	 * @param (string) $auth_token; authentication token
	 */
	public function __construct( $auth_id, $auth_token, $type = 0 )
	{
		if(!isset($auth_id) || empty($auth_id) || (!$auth_id)) {
			throw new Exception("No valid authentication id.");
		}
		
		if(!isset($auth_token) || empty($auth_token) || (!$auth_token)) {
			throw new Exception("No valid authentication token.");
		}
		
		$this->auth_id    = $auth_id;
		$this->auth_token = $auth_token;
		$this->type       = $type;
	}
	
	/**
	 * getAuthId function
	 * returns auth_id
	 *
	 * @return $this->auth_id;
	 */
	public function getAuthId()
	{
		return $this->auth_id;
	}
	
	/**
	 * getAuthToken function
	 * returns auth_token
	 *
	 * @return $this->auth_token;
	 */
	public function getAuthToken()
	{
		return $this->auth_token;
	}
	
	/**
	 * getCredentialType
	 * returns type
	 *
	 * @return $this->type;
	 */
	public function getCredentialType()
	{
		return $this->type;
	}
}