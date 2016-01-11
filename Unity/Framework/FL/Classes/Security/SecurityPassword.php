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
class SecurityPassword  
{  
	/**
	  * static funtion
	  * checkComlexPassword
	  * 
	  * @params password
	  * @params len of password
	  * return boolean
	  */
	public static function checkComlexPassword($passw, $len = 8){
	/*
	**    Function        Checks consistency of a password
	**                    The password must consist of at least one digit,
	**                    lower- und uppercase letter and a special sign,
	**                    and the length must be at least $length characters
	**
	**    Parameter:      String: $passw         Password
	**                    Integer $length        Minimal length of the PW
	**
	**    Return value:   Boolean
	*/
	    if (strlen($passw) < $len){        // Passwort zu kurz
	        return false;
	    }

		// Nur 2 Zifern
	    $empty = array();
	    $ino   = preg_match_all('/[0-9]/',$passw,$empty);		
		if ($ino < 2 ){        
	        return false;
	    }

	    if(    preg_match('/[[:digit:]]/', $passw) &&         // Ziffern
	           preg_match('/[[:lower:]]/', $passw) &&         // Kleinbuchstaben
	           preg_match('/[[:upper:]]/', $passw) &&         // Grossbuchstaben
	           preg_match('/[[:punct:]]/', $passw)            // Sonderzeichen
	           )
	           return true;
           
	  return false;           	
	} 


	/**
	  * static funtion
	  * getGenPassword
	  * 
	  * @params salt
	  * @params len
	  * return string
	  */
	private static function getGenPassword($salt,$len){
	 
		$generatedPassword = '';
		
		for($index = 0; $index < $len; $index++){
		   	$generatedPassword .= substr($salt,(rand()%(strlen ($salt))), 1);
		}
		return $generatedPassword;
	}

	/**
	  * static funtion
	  * getGenComplexPassword
	  * 
	  * @params salt
	  * @params len
	  * return string
	  */
	private static function getGenComplexPassword($salt,$len){
	 
		do{
			$generatedPassword = '';
		
			for($index = 0; $index < $len; $index++){
			   	$generatedPassword .= substr($salt,(rand()%(strlen ($salt))), 1);
			}
		} while(!(self::checkComlexPassword($generatedPassword, $len)));
		
		return $generatedPassword;
	}

	/**
	  * static funtion
	  * generatePassword
	  * 
	  * @params len
	  * @params array with options
	  * return string
	  */
	public static function generatePassword($len,$options=array()){
 
  	    if(!$len) return false;   
	    $len = (int) $len;

		if(!empty($options))
		{
			if(array_key_exists('minLen',$options)){
				   $minLen  = $options['minLen'];
			} else $minLen  = 4;
		
			if(array_key_exists('maxLen',$options)){
				   $maxLen  = $options['maxLen'];
			} else $maxLen  = 8;

			if(array_key_exists('complex',$options)){
				   $complex  = ($options['complex'] === 'true') ? true : false;
			} else $complex  = false;
		}		

	    if($len < $minLen || $len > $maxLen) 
		#return false;
	      throw new Exception('Len of Password must beetween '.$minLen.' to '.$maxLen, 80125);
    
	    $PassAreaLowerChars		= "qwertzupasdfghkyxcvbnm";
		$PassAreaUpperChars 	= "WERTZUPLKJHGFDSAYXCVBNM";
	    $PassAreaNumeric 		= "23456789";
	    $PassAreaSpecialChars	= '"!#&%$';

	 	$salt =   $PassAreaLowerChars 
		 		. $PassAreaNumeric
		 		. $PassAreaSpecialChars
		 		. $PassAreaUpperChars
		 		;

		// mixed characters
		$salt = str_shuffle($salt);

		// init random
		srand ((double)microtime()*1000000);

		$generatedPassword = ($complex) 
						   ? self::getGenComplexPassword($salt,$len)
						   : self::getGenPassword($salt,$len)
						   ;
	 
	 	return $generatedPassword; 
	}
	 
  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
} 


?>