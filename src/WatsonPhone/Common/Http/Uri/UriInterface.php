<?php
/**
 * WatsonPhone - Uri Interface
 *
 * @package WatsonPhone
 * @author  <nybouchard@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
 
namespace WatsonPhone\Common\Http\Uri;

//use InvalidArgumentException;

interface UriInterface {

  /**
   * @param string $uri
   */
  public function __construct($uri = NULL);
  
  /**
   * @param str $uri
   * @throws \InvalidArgumentException
   */
  public function parseUri($uri);
  
  /**
   * @return string
   */
  public function getScheme();
  
  /**
   * @return string
   */
  public function getHost();
  
  /**
   * @return int
   */
  public function getPort();
  
  /**
   * @return string
   */
  public function getPath();
  
  /**
   * @return string
   */
  public function getQuery();
  
  /**
   * @return string
   */
  public function getFragment();

}