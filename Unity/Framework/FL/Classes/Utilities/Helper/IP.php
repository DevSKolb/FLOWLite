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
final class IP
{
	/**
	 * Client IP address
	 *
	 * @access	protected
	 * @return	IP number or 0.0.0.0
	 */
	protected static $ClientIP = False;
	
	/**
	 * Singleton-Elements: private __construct
	 *                     private __clone   
	 */     
	private function __construct() {} //verhindern, dass new verwendet wird
	private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen

	/**
	 * Get IP
	 *
	 * @access	public
	 * @return	string
	 */
	public static function getClientIP()
	{
		if (self::$ClientIP !== FALSE){
		  	return self::$ClientIP;
		}

		$CieIP  = (isset($_SERVER['HTTP_CLIENT_IP'])       
			 	     AND $_SERVER['HTTP_CLIENT_IP'] != "")       
				       ? $_SERVER['HTTP_CLIENT_IP'] 
				       : FALSE;			 
						   
		$RemIP  = (isset($_SERVER['REMOTE_ADDR'])          
					 AND $_SERVER['REMOTE_ADDR'] != "")          
					   ? $_SERVER['REMOTE_ADDR'] 
					   : FALSE;
						   
		$ForIP  = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
					 AND $_SERVER['HTTP_X_FORWARDED_FOR'] != "") 
					   ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
					   : FALSE;

		if ($CieIP && $RemIP) 	self::$ClientIP = $CieIP;
		elseif ($RemIP)			self::$ClientIP = $RemIP;
		elseif ($CieIP)			self::$ClientIP = $CieIP;
		elseif ($ForIP)			self::$ClientIP = $ForIP;

		if (strstr(self::$ClientIP, ','))
		{
			$x = explode(',', self::$ClientIP);
			self::$ClientIP = end($x);
		}

		// checked IP address
		$CheckIP = new IPValidator();

		if ( ! $CheckIP->isValid(self::$ClientIP))
		{
			self::$ClientIP = '0.0.0.0';
		}
		
		unset($CheckIP);
		unset($CieIP);
		unset($RemIP);
		unset($ForIP);

		return self::$ClientIP;
	}
}
?>