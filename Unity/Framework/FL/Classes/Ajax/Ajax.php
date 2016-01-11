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
class Ajax {
  
	public static function getJavascriptForAjax(){	
		return "<script type=\"text/javascript\" src=\"".$_SERVER["DOCUMENT_ROOT"] ."/FLOWLite/Unity/Framework/FL/Resources/js/FL_Ajax.js\">";  
	}  

  /**
   * static funtion
   * setResponse
   * 
   */   
	public static function setResponse($OuputResponseToAjax){

		echo $OuputResponseToAjax;

		exit();
	}

  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 

}
?>