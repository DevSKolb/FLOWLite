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
final class generateID  
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
	public static function create_sessid() {

		// generate 4 token
 		$token1 = md5(uniqid(rand(), true));
		$token2 = md5(uniqid(rand(), true));
		$token3 = md5(uniqid(rand(), true));
		$token4 = md5(uniqid(rand(), true));

		// generate a token from token 1 and 2
		$zufall = $token1."-".$token2;
		$zufall = md5($zufall);

		// generate a token from token 3 and 4
		$zufall2 = $token3."-".$token4;
		$zufall2 = md5($zufall2);

		// generate final token
		$sessiid = md5($zufall2.$zufall);
		
		// retrun token as 32 byte hash
		return $sessiid;
	}
	 
  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
} 


?>