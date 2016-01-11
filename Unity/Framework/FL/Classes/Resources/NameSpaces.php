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
 * @class FlexiNSP NameSpaces
 * 
 */
final class NameSpaces
{
  /**
   * namespace classes
   * @[0] = packages (FLOWLite,Application)                 
   * @[1] = path of classes
   */     
   public static $NameSpaceClasses = array();

   public static $NSP_Framework			= array();
   public static $NSP_Application		= array();	
   public static $NSP_ApplicationOnly	= array();
   public static $NSP_ORM				= array();
  
   public static $ListOfNameSpaces = array();

  /**
   * return namespace 
   * 
   * @return
   */ 
   private static $ReturnNameSpaces = array();

  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen
    

  /**
   * @public
   * @recursve
   *
   * array convert to object
   */  
  public static function array2Object( $array ) {      
   
   return $array;
   
    if(is_object($array)) return $array;
   
   	$object = (object) $array;
   /*
   
    $object = new stdClass();   
	   
    foreach( $array as $key => $value ) {          
    
	    if( is_array( $value ) ) {              
    
	        $object->$key = $this->array2Object( $value );          
        }  
        else {         
            $object->$key = $value;          
        }      
    } 
*/
    return $object; 
  } 

  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function setNamespaceObject($NSP,$NameSpaceObject){    

if(is_object($NameSpaceObject)){ echo "Objekt";}

      // Object erzeugen    
     self::${$NSP} = $NameSpaceObject;

       // Objectname in Liste aufnehmen
 	  self::setNamespaceToObjectList($NSP); 
    }    


  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces
   */ 
    public static function setNamespace($NameSpaces){
           self::$NameSpaceClasses = array_merge((array)self::$NameSpaceClasses,(array)$NameSpaces);
    }
    
  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function setNamespaceToObjectList($NSP){    
         if(isset($NSP) && !in_array($NSP,self::$ListOfNameSpaces)){
        	 self::$ListOfNameSpaces[] = $NSP;  
		 }
   }

  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function getNSPList(){    
        return self::$ListOfNameSpaces; 
   }

  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function destroyNSPApplication($NSP){    

		// destroy Namespace area
        self::$NSP_Application = array(); 
        
        // remove NSP_Application from List of NSP
        self::removeNSPApplication($NSP);
   }

  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function removeNSPApplication($NSP){    

		if(isset(self::$ListOfNameSpaces[$NSP])){
			unset(self::$ListOfNameSpaces[$NSP]);
		}
   }

  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function setNamespaceToObject($NSP,$NameSpaces){    

      // Object erzeugen    
      self::${$NSP} = self::array2Object($NameSpaces);
#      self::${$NSP} = (object) $NameSpaces;
 
       // Objectname in Liste aufnehmen
 	  self::setNamespaceToObjectList($NSP);	
    }

  /**
   * @access public static
   * @param namespaces
   * 
   * set namespaces to object
   */ 
   public static function setObject($NSP,$NSPObject){    

      // Object zuweisen    
      self::${$NSP} = $NSPObject;
 
       // Objectname in Liste aufnehmen
 	  self::setNamespaceToObjectList($NSP);	
    }
	    
  /**
   * @access public static
   * 
   * get all namespaces (array)
   */ 
    public static function getAllNamespace(){
           return self::$NameSpaceClasses;
    }

  /**
   * @access public static
   * @param namespaces
   * 
   * get namespaces
   */ 
    public static function setNSPTO($directory = FL_PATH_CLASSES, $recursive=true, $blacklist=false)
	{
// 1. Cache aktiv ?
// 2. NSP Object au scache holen
// 3. NSP Object zur Liste fügen
           ResourcesNameSpaces::getNamespaces($directory,$recursive,$blacklist);
           
// 1. cache aktiv ?
// 2. NSP Object lesen ?
// 3. NSP Object neu aufbauen
// 4. In cache legen           
    }
    
    
  /**
   * @access public static
   * @param classname
   * 
   * all classes of specification name
   */ 
    public static function getNamespaceOfClassSpecification($ClassName,$subset=false){
						   
       self::$ReturnNameSpaces = null;

       // Alle registrierten Objekte betrachten
	   foreach(self::$ListOfNameSpaces as $key => $value){
	    		    
            // Die Eigenschaften aller registrierten Objekt durchsuchen
    	    foreach(self::${$value} as $obj => $property){

              // Suchefunktion
    	      if(self::searchClassInNamespaceObject($ClassName,$obj) !== false){

                  // Teilklasse gefunden => Aufnahme der gefundenen Klassen
				  if($subset === true){
					if($ClassName === $obj){
					   self::$ReturnNameSpaces[] = $obj;
					}   
				  } 
				  else self::$ReturnNameSpaces[] = $obj;
    	       
    	      }    	      
    	    }
       }
  	   if(is_array(self::$ReturnNameSpaces)) sort(self::$ReturnNameSpaces);

 	   return self::$ReturnNameSpaces;
    }

  /**
   * @access public static
   * @param classname
   * 
   * all classes of specification name
   */ 
    public static function classExistsInApplication($ClassName){

        // Die Eigenschaften aller registrierten Objekt durchsuchen
	    foreach(self::$NSP_Application as $obj => $property){

         // search object in class
   	     if(self::searchClassInNamespaceObject($ClassName,$obj) !== false)
		 {   	       
            return true;    	       
    	 }    	      
    	}
        return false;
    }

  /**
   * @access public static
   * @param classname
   * 
   * all classes of specification name
   */ 
    public static function classExistsInApplicationOnly($ClassName){

        // Die Eigenschaften aller registrierten Objekt durchsuchen
	    foreach(self::$NSP_ApplicationOnly as $obj => $property){

         // search object in class
   	     if(self::searchClassInNamespaceObject($ClassName,$obj) !== false)
		 {   	       
            return true;    	       
    	 }    	      
    	}
        return false;
    }
    
  /**
   * @access public static
   * @param classname
   * @param path of class
   * 
   * find class at specifications
   */ 
    private static function searchClassInNamespaceObject($ClassName,$ObjectProperty){

            $ResultPosition = false;
		    $ResultPosition = strpos($ObjectProperty, $ClassName);

            return (boolean) ($ResultPosition !== false) ? $ObjectProperty : false; 
    }

}
?>