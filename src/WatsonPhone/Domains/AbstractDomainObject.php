<?php

/**
 * WatsonPhone - Abstract domain object.
 * Domain object factory class.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Domains;

use WatsonPhone\Domains\DomainObjectInterface;
use WatsonPhone\Common\Exception\Exception;


abstract class AbstractDomainObject implements DomainObjectInterface
{
	//@var (array) $domain_properties; extra domain properties
	//protected $domain_properties;
	
	//@var (array) $subresources; extra resources available to that domain
	protected $subresources;
	
	//@var (array) $domain_properties;
	protected $domain_properties;
		
	
	public function __construct()
	{
		$this->prepare(); // run init
	}
	
	public function prepare()
	{
		// empty initializer
	}
	
	public function __get( $property )
	{
		var_dump($property);
	
		if(isset($this->domain_properties[$property])) {
			return $this->domain_properties[$property];
		}
		
		return null;
	}
	
	public function __set( $property, $value = null )
	{
		if(isset($this->domain_properties[$property])) {
			throw new Exception("Property already assigned: ".$property);
		}
		
		$this->domain_properties[$property] = $value;
	}
	
	/**
	 * setSubresources function
	 * sets up the domain's subresources for watson resources
	 */
	public function setSubresources( array $subresources )
	{
		$this->subresources = $subresources;
	}
	
	/**
	 * getSubresources
	 * returns the subresources
	 */
	public function getSubresources()
	{
		return $this->subresources;
	}
}