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
final class generatePass 
{  	
	/**
	  * static funtion
	  * create_sessid
	  * 
	  * return encrypt 32 byte hash
	  *
	  * MD5    : Returns the hash as a 32-character hexadecimal number
	  * UNIQID : Returns the unique identifier, as a string.
	  * RAND   : A pseudo random value between min (or 0) and max (or getrandmax(), inclusive). 
	  *
	  */   
	public static function create_password($len) {

		$password = '';
		
		$alphaNumeric = "qwertzupasdfghkyxcvbnm123456789!$&?WERTZUPLKJHGFDSAYXCVBNM";

		srand((double)microtime()*1000000);

		#-- Startwert für den Zufallsgenerator festlegen
		for($i = 0; $i < $len; $i++)
		{
	  		$password .= substr($alphaNumeric,(rand()%(strlen ($alphaNumeric))), 1);
		}
	
		return $password;
	}

	 
  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
} 


?>