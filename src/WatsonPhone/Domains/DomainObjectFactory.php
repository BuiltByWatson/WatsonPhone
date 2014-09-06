<?php

/**
 * WatsonPhone - DomainObject Factory
 * Domain object factory class.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Domains;

class DomainObjectFactory
{
	/**
	 * build method
	 * Factory method that returns domain object instance.
	 * 
	 * @param string $name; Domain object name.
	 */
	public function build( $name )
	{
		$className = __NAMESPACE__ . "\\" . $name;
		$instance = new $className();

		if( method_exists($instance, 'prepare') ) // is_callable was replaced by method_exists
		{
			$instance->prepare();
		}

		return $instance;
	}
}