<?php

/**
 * WatsonPhone - Call Domain Object
 * Domain object representing "call" for services.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Helper;

class Call
{	
	//@var (int) $timeout|60; The amount of time to let ring
	protected $timeout = 60;
	
	//@var (bool) $record; Boolean on whether or not to record the call
	protected $record = false;
	
	//@var (string) $caller_name; The name of the caller to appear
	protected $caller_name;
	
	
}