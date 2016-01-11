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
class BrowserAgent{

	/**
	 * Singleton-Elements: private __construct
	 *                     private __clone   
	 */     
	private function __construct() {} //verhindern, dass new verwendet wird
	private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen
 
	// Browsersprache ermitteln
	public static function get() 
	{
		// get user agent
	 	$userAgent = $_SERVER["HTTP_USER_AGENT"];
	 
		// browser name
		$browserName = '';
		
		// who browser
		$agent  = (strstr($userAgent, "Gecko") 		? "Mozilla" 	: "");
		$agent .= (strstr($userAgent, "Firefox") 	? "Firefox" 	: "");
		$agent .= (strstr($userAgent, "MSIE") 		? "MSIE" 		: "");
		$agent .= (strstr($userAgent, "Avant") 		? "Avant" 		: "");
		$agent .= (strstr($userAgent, "Opera") 		? "Opera" 		: "");
		$agent .= (strstr($userAgent, "AppleWebKit")? "AppleWebKit" : "");
		$agent .= (strstr($userAgent, "Safari") 	? "Safari" 		: "");
		$agent .= (strstr($userAgent, "Konqueror") 	? "Konqueror" 	: "");
		$agent .= (strstr($userAgent, "Chrome") 	? "Chrome" 		: "");

		switch ($agent) {
		 case "MSIE":
	    	  $browserName = "Internet Explorer";
		      break;
		 case "MSIEAvant":
		      $browserName = "Avant";
		      break;
		 case "MozillaFirefox":
		      $browserName = "Mozilla Firefox";
		      break;
		 case "Opera":
		      $browserName = "Opera";
		      break;
		 case "MozillaAppleWebKitSafari":
		      $browserName = "Safari";
		      break;
		 case "MozillaKonqueror":
		      $browserName = "Konqueror";
		      break;
		 case "MozillaAppleWebKitSafariChrome":
		      $browserName = "Google Chrome";
		      break;
		 default:
		      $browserName = $userAgent;
	 	}

        // den gefundenen Browser zurückgeben
        return $browserName;
 	}
}
?>
