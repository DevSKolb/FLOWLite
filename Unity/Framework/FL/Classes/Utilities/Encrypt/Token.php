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
final class Token  
{  	
	/**
	  * static funtion
	  * createGuid
	  * 
	  * return  microsoft-compatible GUID's or uniGuid's.
	  *
	  * namespace : 23 individually characters
	  * delimiter : Microsoft compatible or not
	  *
	  */   
	public static function createGuid($namespace = '', $delimiter = true) {    
  
	    static $guid = '';	

	    // Gets a prefixed unique identifier based on the 
		// current time in microseconds. 
		$uid = uniqid("", true);

	    // Can be useful, for instance, if you generate identifiers 
		// simultaneously on several hosts that might happen to generate 
		// the identifier at the same microsecond. With an empty prefix, 
		// the returned string will be 13 characters long. If more_entropy 
		// is TRUE, it will be 23 characters.
		$data  = $namespace;

		// time now
	    $data .= time();
    
		// server and location params 
		$data .= $_SERVER['HTTP_USER_AGENT'];
	    $data .= $_SERVER['SERVER_ADDR'];
	    $data .= $_SERVER['SERVER_PORT'];
	    $data .= $_SERVER['REMOTE_ADDR'];
	    $data .= $_SERVER['REMOTE_PORT'];
  
		// building hash
	    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
  
  		// I use this function to generate microsoft-compatible GUID's.
		if($delimiter==true){
	    $guid = '{' .  
            substr($hash,  0,  8) . '-' .
            substr($hash,  8,  4) . '-' .
            substr($hash, 12,  4) . '-' .
            substr($hash, 16,  4) . '-' .
            substr($hash, 20, 12) .
            '}';
    	} else
	  	// I use this function to generate GUID's without delimiter.
		{  	
	    $guid = 
            substr($hash,  0,  8) .
            substr($hash,  8,  4) .
            substr($hash, 12,  4) .
            substr($hash, 16,  4) .
            substr($hash, 20, 12) ;
	 	}	
		return $guid;  
  	}
	 
	/**
     * Singleton-Elements: private __construct
     *                      private __clone   
     */     
	private function __construct() {} // verhindern, dass new verwendet wird
	private function __clone() {}	  // verhindern, dass durch Kopieren 2 Objekte entstehen 
} 
?>