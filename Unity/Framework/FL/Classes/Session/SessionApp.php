<?php
/*                                                                        *
 * This script required the FLOWLite framework.                           *
 * This corpuscle is a component of the TC Project.                       *
 * --------------------------------------------------------------------   *
 * Projekt:                   | Technical Configurator (TC)               *
 * Titel:                     | Grundfunktionen der Session               *
 * --------------------------------------------------------------------   *
 * Class Name:                | SessionApp                                *
 * Programmtyp:               | Static Model                       		  *
 * System:                    | IS2                                       *
 * PHP Version:	              | PHP 5.2                                   *
 * --------------------------------------------------------------------   *
 * Autor:  Silvan Kolb                                               	  *
 *         National Rejectors, Inc. GmbH                             	  *
 *         Abteilung IT / Raum 46C / Platz A                         	  *
 *         Zum Fruchthof 6                                           	  *
 *         21614 Buxtehude                                           	  *
 *         Tel.: 04161 / 729-273                                     	  *
 *         SKolb@craneps.com	                                     	  *
 * --------------------------------------------------------------------   *
 *                                                                        */
final class SessionApp {
   
	/*
 	 * @access private static
	 * 
	 * Object: Request
	 */  
	private static $request;
	
	/*
	 * @access private static
	 * 
	 * Object: objectManager
	 */  
	private static $objectManager;

	/*
	 * @access public
	 * 
	 * Setzen eines Sessionwertes
	 */  
	public static function setSession($key,$value) {

		// is key ?
		if(empty($key)) return false;
	
		$_SESSION[$key] = $value;
		
		return true;
   }

	/*
	 * @access public
	 * 
	 * Lesen eines Sessionwertes
	 */  
	public static function getSession($key,$default=null) {

		// is key ?
		if(empty($key)) return false;
	
		$_SESSION[$key] = (isset($_SESSION[$key]) && !empty($_SESSION[$key]))
						? $_SESSION[$key]
						: $default
						;

		return $_SESSION[$key];
   }


	/*
	 * @access public
	 * 
	 * clean data
	 */  
	public static function cleanData() {

		$valueDATA = array();

		foreach($_SESSION as $xKey=>$yps)
		    $valueDATA[]=$xKey;

		foreach($valueDATA as $xKey){
			$_SESSION[$xKey] = '';
   		}
  		return;
 	}
}
?>