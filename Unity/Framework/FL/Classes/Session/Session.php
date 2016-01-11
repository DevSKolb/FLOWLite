<?php
/*                                                                        *
 * This script belongs to the FLOWLite framework.                         *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        */
/**
 *
 * FLOWLite Session class
 *
 * @start($sessionName='PHPSESSID')
 * @__construct()
 * @__set($key, $value)
 * @__get($key)
 * @__unset($key)
 * @exists($key)
 * @__isset($key)
 * @close()
 * @newID($del_old = false)
 * @getID()
 * @destroy()
 * @__destruct()
 */
final class Session
{
	/**
     * @access private static
     * @var string $sessArrayKey
   	 *
   	 * Unter diesem Key werden in $_SESSION alle Daten verwaltet
   	 */
	private $sessArrayKey = "__sessiondata"; //key im $_SESSION-array

	public $expireTime = 180; 

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		if (ini_get('session.auto_start') != 0) throw new Exception('PHP\'s session.auto_start must be disabled.', 1219848292);
	}

	/**
	 * @access private
     *
   	 * Startet die Session und legt das Array an
     */
	public function start($sessionName='PHPSESSID')
  	{
		if(!isset($_SESSION)) 
		{
			$this->expireTimeFunction();
	
		    if($sessionName <> 'PHPSESSID')
			{
	   			session_name($sessionName); 
			}
    
			// Start Session	
    		session_start();
    
    		if(!isset($_SESSION[$this->sessArrayKey]))
    		{
      			$_SESSION[$this->sessArrayKey] = array();
    		}
    
	    	$_SESSION['active'] = 1;
		} 
		else return false;
  	}  

	
	/**
	 * @access private
	 *
     * Kopierkonstruktor verbieten
     */
#	private function __clone() {}


	/**
     * @access public
     * @param string $key
     * @param mixed $value
     *
     * Ermöglicht Speichern von Sessionvariablen
     */
	public function __set($key, $value)
	{
    	$_SESSION[$this->sessArrayKey][$key] = $value;
  	}

	/**
   	 * @access public
   	 * @param string $key
   	 * @return mixed|null
   	 *
   	 * Ermöglicht Lesen von Sessionvariablen
   	 */
	public function __get($key)
  	{
    	if($this->exists($key))
    	{
      		return $_SESSION[$this->sessArrayKey][$key];
    	}
    	else
    	{
      		return null;
    	}
  	}

	/**
   	 * @access public
   	 * @param string $key
   	 * @return bool
   	 *
   	 * Ermöglicht Löschen von Sessionvariablen
   	 */
	public function __unset($key)
  	{
    	if($this->exists($key))
    	{
      		unset($_SESSION[$this->sessArrayKey][$key]);
      		return true;
    	}
    	else
    	{
      		return false;
    	}
  	}

	/**
   	 * @access public
   	 * @param string $key
   	 * @return bool
  	 *
   	 * gibt true zurück, wenn $key existiert
   	 * sonst false
   	 */
	public function exists($key)
	{
    	return (isset($_SESSION[$this->sessArrayKey][$key]) ? true : false);
  	}

	/**
   	 * @access public
   	 * @param string $key
   	 * @return bool
  	 *
   	 * ALIAS FÜR FW_Session::exists($key)
   	 */
  	public function __isset($key)
	{
    	return $this->exists($key);
  	}

	/**
   	 * @access public
   	 *
   	 * Schließt die Session
   	 */
  	public function close()
	{
    	session_write_close();
  	}

	/**
   	 * @access public
   	 * @param bool $del_old
   	 *
   	 * Generiert eine neue Session-ID
   	 */
  	public function newID($del_old = false)
  	{
    	session_regenerate_id($del_old);
  	}

	/*
	 * @access public
	 * 
	 * clean data
	 */  
	public function cleanData() {

		$valueDATA = array();

		foreach($_SESSION as $xKey=>$yps)
		    $valueDATA[]=$xKey;

		foreach($valueDATA as $xKey){
			$_SESSION[$xKey] = '';
   		}
  		return;
 	}
 	
	/**
   	 * @access public
   	 *
   	 * ini session
   	 */
  	public function init()
  	{
		session_unset();
	
		$_SESSION = array();	 
  	}

	/**
   	 * @access public
   	 *
   	 * set expire time
   	 */
  	public function expireTimeFunction()
  	{
	//	if(empty($this->expireTime)) return false;

		/* setzen der Cacheverwaltung auf 'private' */
	 //	session_cache_limiter('private');
	//	$cache_limiter = session_cache_limiter();

		/* setzen der Cache-Verfallszeit, default 180 Minuten  */
//		session_cache_expire($this->expireTime);

		
	//	$cache_expire = session_cache_expire();
  	}

	/**
   	 * @access public
   	 * @return string
   	 *
   	 * Liefert dei aktuelle Session-ID
   	 */
 	public function getID()
  	{
    	return session_id();
  	}

	/**
   	 * @access public
   	 *
   	 * Zerstört die Session
   	 */
  	public function destroy()
  	{
  	 	session_cache_expire(0);
  	 	$_SESSION = array();
  	 	
  	 	$besucher = session_id();
  	 	
    	session_destroy($besucher);
  	}

	/**
   	 * @access public
   	 *
   	 * Destruktor
   	 */
  	public function __destruct()
  	{
   		$this->close();
  	}
}
?>