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
 */ 
class ObjectBuilder {   
     
   /**
    * @object instance static
    * 
    */           
    private static $instance = null;

   /**
    * @public 
    *
    */   
    public static function getInstance(){
       if(self::$instance === null){
          self::$instance = new ObjectBuilder();
       }
       return self::$instance;
    } 

   /**
    * @public 
    */      
    public function destroy($ObjectName) { 
           unset($ObjectName);
    }

   /**
    * @public
    */      
    public function createObject($ObjectName) {  

		/*
		 * object name (string)
		 */
		if(!is_string($ObjectName)){ 
		    throw new NotObjectInstanceException('Objekt Instanzierung nicht möglich!',100650);
	    }

		/*
		 * build instance of object
		 */
	    $ObjectInstance = new $ObjectName;

		/*
		 * callback: instance of object
		 */
        return $ObjectInstance;
    }
}
?>