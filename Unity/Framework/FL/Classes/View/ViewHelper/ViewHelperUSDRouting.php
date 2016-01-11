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
class ViewHelperUSDRouting {

   /**
    * private static var
    * routing
    */ 
    private static $routing = array();

   /**
    * private static var
    * objectManager
    */ 
    private static $objectManager;
    
   /**
    * private static var
    * configuration
    */ 
    private static $registry;

   /**
    * private static var
    * linefeed CR
    */ 
    private static $CR;

  /**
   * static funtion
   * setHiddenFieldsOfRoute
   * 
   * @params NameOfUnity
   * @params NameOfScreen
   * @params NameOfAction
   *
   */   
  public static function setHiddenFieldsOfRoute($NameOfUnity,$NameOfScreen,$NameOfAction){

     // ObjectManager
     self::$objectManager = ObjectManager::getInstance();
     
     // Configuration
     self::$registry = self::$objectManager->getObject('Registry'); 

     // Fields of USC Routing
     $AppsFieldUnity  = self::$registry->hiddenfieldsUnity;
     $AppsFieldScreen = self::$registry->hiddenfieldsScreen;
     $AppsFieldAction = self::$registry->hiddenfieldsAction;

     // Line Feed
     self::$CR = BaseHelperEscapeChars::getEscapeChar('CR');

     // set ARRAY
     self::$routing = array(self::$CR.
     '<input type="hidden" id="'.$AppsFieldUnity.'"  name="'.$AppsFieldUnity.'"  value="'.$NameOfUnity.'">' .self::$CR
    ,'<input type="hidden" id="'.$AppsFieldScreen.'" name="'.$AppsFieldScreen.'" value="'.$NameOfScreen.'">'.self::$CR
    ,'<input type="hidden" id="'.$AppsFieldAction.'" name="'.$AppsFieldAction.'" value="'.$NameOfAction.'">'.self::$CR
	 );

     // Return of USC Routing
     return self::$routing;
  }

  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
}
?>
