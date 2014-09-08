<?php

/**
 * WatsonPhone - DomainObject Interface
 * Domain object factory class.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Domains;

interface DomainObjectInterface
{
	/**
	 * prepare function
	 * Prepare acts as a __construct method, runs on intialization.
	 *
	 * @return void;
	 */
	public function prepare();
}