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
 * 
 * static function 
 */ 
final class GarbageCollector {   
     
   /**
    * @private objects
    * 
    */     
    private static $objects = array();    

   /**
    * @private objectManager
    * 
    */     
    private static $objectManager;    

   /**
    * @private
    * destroy a instance of object
    */      
    private static function destroyObject($ObjectInstance) { 
           unset($ObjectInstance);          
    }

   /**
    * @public
    * destroy all objects
    */      
    public static function destroyAllObjects() {   

         $objectManager = ObjectManager::getInstance();
         self::$objects = $objectManager->getAllObjectInstances();
         
         foreach(self::$objects as $key => $ObjectInstance){
            if(is_object($ObjectInstance)){
               self::destroyObject($ObjectInstance);			     
            }   
         }
         self::BufferEmpty();
    }

   /**
    * @public
    * destroy buffer
    */      
    public static function BufferEmpty() {
	  if(!ob_get_contents()){    
         while (@ob_end_clean());
      }   
    }  
}
?>