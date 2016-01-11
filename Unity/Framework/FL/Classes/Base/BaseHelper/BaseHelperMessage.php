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
class BaseHelperMessage {


  protected $messages = array();
  
  /**
   * static funtion
   * setMessage
   * 
   * @params (string)message
   *
   */   
  public static function setMessage($MSG_NAME,$MSG_TYPE,$MSG_DESC,$MSG_OPTIONS=false){ 

		self::$messages[]['MSG_NAME'] = $MSG_NAME;		
		self::$messages[]['MSG_TYPE'] = $MSG_TYPE;		
		self::$messages[]['MSG_DESC'] = $MSG_DESC;		
		self::$messages[]['MSG_OPTS'] = $MSG_OPTIONS;		
  }

  /**
   * static funtion
   * getMessage
   * 
   * @params (string) name
   * @return (array)  messages
   */   
  public static function getMessageAll($MSG_NAME){ 

		if(is_array(self::$messages)){
			return self::$messages;
		}
		return false;
  }

  /**
   * static funtion
   * showMessage
   * 
   * @params (string) message
   */   
  public static function showMessage($MSG_DESC,$MSG_OPTIONS=false){ 

		if(isset($MSG_DESC)){
			echo trim($MSG_DESC);
			
			if($MSG_OPTIONS !== false)
			{
			  if(is_array($MSG_OPTIONS))
			  {
			    foreach ($MSG_OPTIONS as $key => $value){
			    	if(isset($value)){
			    	  echo $value;
					}  
			    }
			  }
			}						
 		}
  }


  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
}
?>
