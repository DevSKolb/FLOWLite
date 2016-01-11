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
class ViewHelperLanguage {

	/**
	 * funtion
	 * setLanguageContent
	 * 
	 * @params langContentArr	Texte als (Key,Value) Paare
	 * @params unitObj			object instance of unit object		
	 *
	 */   
	public static function setLanguageContent($langContentArr,$unitObj){

		// is empty array ?
		if( ! is_array($langContentArr) || empty($langContentArr) ) return false;

		// is not object ?
		if( ! is_object($unitObj) ) return false;

		/*
		 * Zuweisung der key => value Paare
		 *
		 * key 	 => Placeholder in template
		 * value => Content for Placeholder
		 *
		 */
		foreach($langContentArr as $key => $value){
			
			$unitObj->assign($key,$value);		 
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
