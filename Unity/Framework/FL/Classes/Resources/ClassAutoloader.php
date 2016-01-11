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
/** 
 * ClassAutoloader with FlexiNSP
 * @author Silvan Kolb
 * 
 */
class ClassAutoloader
{
	/**
     * @param ListOfNameSpaces
     * @type array 
     */   
	private static $ListOfNameSpaces = array();

	/**
     * Singleton-Elements: private __construct
     *                     private __clone   
     */     
	private function __construct() {} //verhindern, dass new verwendet wird
	private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen

	/**
     * FlexiNSP
     *
     * @access public
     * @param string classname
     * @loading class from namespace of framework
     */  
	public static function load($className)
	{
		// all registered namespaces
		self::$ListOfNameSpaces = NameSpaces::getNSPList();


	    // if object registerd ?
	    if(count(self::$ListOfNameSpaces)>0){
	

			// searching in namespace ...
		    foreach(self::$ListOfNameSpaces as $Key => $Value){ 
#print_r(NameSpaces::${$Value});

if(array_key_exists($className, NameSpaces::${$Value})){

#if(isset(NameSpaces::${$Value}[$className])){
				
				$pathToClass = NameSpaces::${$Value}[$className];

         		if(isset($pathToClass)){  
				       
         		 if(file_exists($pathToClass)){ 
			  
		      			// ... so wird sie eingebunden
				  		require_once($pathToClass); 
					} 
					break; 
         		}
}


	         	// ${$Value} = name of class
				// {$classname} = name of property (Path) ~ name of class
         		// Korrespondiert mit der STATIC Klasse "NameSpaces"
/*
         		if(isset(NameSpaces::${$Value}->{$className})){       

					// Name des Pfades und der Klasse
					$ExternalPathAndNameOfClass = NameSpaces::${$Value}->{$className};

            		// Existiert die Klasse, ...
            		if(file_exists($ExternalPathAndNameOfClass)){ 
			  
		      			// ... so wird sie eingebunden
				  		require_once($ExternalPathAndNameOfClass); 
					} 
	        		break;        
         		} #if
*/
    		} #foreach
    	} #count
	} #function

	/**
     * @access public static
     * @param mixed autoloader
     * 
     * registry autoloader for classes
     */  
	public static function register($autoloader = null){   
		if($autoloader === null) { 
      		spl_autoload_register(array('ClassAutoloader', 'load'));
    	}
    	else { spl_autoload_register($autoloader);	}
  	}
}
?>