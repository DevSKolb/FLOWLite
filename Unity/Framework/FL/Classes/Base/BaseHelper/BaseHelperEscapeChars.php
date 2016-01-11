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
class BaseHelperEscapeChars {

   /**
    * private static var
    * escape chars
    *
	* the sequence of characters matching the regular expression is a character in octal notation 
    * ,'NUM' => "\[0-7]{1,3}" 
    *
    * the sequence of characters matching the regular expression is a character in hexadecimal notation 
    * ,'HEX' => "\x[0-9A-Fa-f]{1,2}" 
    *
    */ 
	private static $EscapeChars = array(
	                     'CR'    => "\n"	// linefeed (LF or 0x0A (10) in ASCII)	 
	                    ,'LF'    => "\r"	// carriage return (CR or 0x0D (13) in ASCII)
	                    ,'CR_LF' => "\n\r"  // CR and LF 
	                    ,'FF'    => "\f"	// form feed (FF or 0x0C (12) in ASCII) (since PHP 5.2.5)
	                    ,'HTB'   => "\t"	// horizontal tab (HT or 0x09 (9) in ASCII)
	                    ,'VTB'   => "\v"	// vertical tab (VT or 0x0B (11) in ASCII) (since PHP 5.2.5)	                    
	                    ,'DQT'   => "\""	// double-quote
	                    ,'SQT'	 => "\'"	// single-qoute
	                    ,'USD'   => "\$"	// dollar sign
	                    ,'BSL'   => "\\"	// backslash
	                    ,'BR'    => "<br>"	// new line
						);

	/**
     * static funtion
     * setHiddenFieldsOfRoute
     * 
     * @params NameOfUnity
     * @params NameOfScreen
     * @params NameOfAction
     *
     */   
	public static function getEscapeChar($ESC_CODE)
	{ 
    	if(isset(self::$EscapeChars[$ESC_CODE]))
	 	{
        	return self::$EscapeChars[$ESC_CODE];
     	}
     	return false;
  	}

	/**
     * Singleton-Elements: private __construct
     *                     private __clone   
     */     
	private function __construct() {} //verhindern, dass new verwendet wird
	private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
}
?>
