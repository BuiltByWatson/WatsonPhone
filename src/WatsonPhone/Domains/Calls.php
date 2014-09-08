<?php

/**
 * WatsonPhone - Call Domain Object
 * Domain object representing "call" for services.
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Domains;

use WatsonPhone\Common\Http\Uri\Uri;


class Calls extends AbstractDomainObject
{
	//@var (string) $account_id; alphanumeric string identifying account
	protected $account_id;

	//@var (string) $call_id; alphanumeric string identifying calls
	protected $call_id;
	
	//@var (string) $call_parent_id; alphanumeric string identifying parent calls
	protected $call_parent_id;
	

	//@var (int) $from; from number
	protected $from;
	
	//@var (int) $to; to number
	protected $to;
	
	//@var (string) $direction; "outbound", "inbound" call direction
	protected $direction;
	
	
	//@var (int) $duration; duration of the call (in seconds)
	protected $duration;
	
	//@var (string) $price; the total cost of the call
	protected $price;
	
	//@var (string) $start_time;
	protected $start_time;
	
	//@var (string) $end_time;
	protected $end_time;
	
	
	//@var (UriInterface|string) $endpoint; the call callback
	protected $endpoint;
	
	//@var (int) $timeout; amount of time in seconds to let call ring
	protected $timeout = 60;
	
	
	//@var (string) $status;
	protected $status;
	


	public function prepare()
	{
		// init function for the domain object
	}
	
	public function normalizeNumber( $number )
	{
	}
	
	/**
	 * Setters and Getters
	 */
	public function setAccountId( $account_id )
	{
		$this->account_id = $account_id;
	}
	
	public function getAccountId()
	{
		return $this->account_id;
	}
	
	public function setCallId( $call_id )
	{
		$this->call_id = $call_id;
	}
	
	public function getCallId()
	{
		return $this->call_id;
	}
	
	public function setCallParentId( $call_parent_id )
	{
		$this->call_parent_id = $call_parent_id;
	}
	
	public function getCallParentId()
	{
		return $this->call_parent_id;
	}
	
	
	public function setToNumber( $to_number )
	{
		$this->to = (int) $to_number;
	}
	
	public function getToNumber()
	{
		return $this->to;
	}
	
	public function setFromNumber( $from_number )
	{
		$this->from = (int) $from_number;
	}
	
	public function getFromNumber()
	{
		return $this->from;
	}
	
	public function setDirection( $direction )
	{
		$this->direction = $direction;
	}
	
	public function getDirection()
	{
		return $this->direction;
	}
	
	
	public function setStatus( $status )
	{
		$this->status = $status;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function setStartTime( $start_time )
	{
		$this->start_time = $start_time;
	}
	
	public function getStartTime()
	{
		return $this->start_time;
	}
	
	public function setEndTime( $end_time )
	{
		$this->end_time = $end_time;
	}
	
	public function getEndTime()
	{
		return $this->end_time;
	}
	
	public function setPrice( $price )
	{
		$this->price = $price;
	}
	
	public function getPrice()
	{
		return $this->price;
	}
	
	public function setDuration( $duration )
	{
		$this->duration = (int) $duration;
	}
	
	public function getDuration()
	{
		return $this->duration;
	}
}

/**
 * Calls Collection
 */
class CallsCollection extends AbstractDomainObject
{
	//@var (array) $calls; collection of calls domains
	protected $collection;
	
	/**
	 * prepare function
	 * Initializer
	 */
	public function prepare()
	{
		// default initializer
		$this->collection = array();
	}
	
	/**
	 * addToCollection
	 */
	public function addToCollection( DomainObjectInterface $domainObject )
	{
		$this->collection[] = $domainObject;
	}
	
	/**
	 * getCollection
	 */
	public function getCollection()
	{
		return $this->collection;
	}
}