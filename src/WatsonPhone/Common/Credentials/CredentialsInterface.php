<?php

/**
 * WatsonPhone - CredentialsInterface
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Common\Credentials;


interface CredentialsInterface
{	
	/**
	 * __construct function
	 * Service Credentials interface for most services.
	 *
	 * @param (string) $auth_id; authentication id
	 * @param (string) $auth_token; authentication token
	 */
	public function __construct( $auth_id, $auth_token, $type = 0 );
	
	
	/**
	 * getAuthId function
	 * returns auth_id
	 *
	 * @return $this->auth_id;
	 */
	public function getAuthId();
	
	/**
	 * getAuthToken function
	 * returns auth_token
	 *
	 * @return $this->auth_token;
	 */
	public function getAuthToken();
}