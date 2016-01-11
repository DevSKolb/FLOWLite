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
final class ObjectFactory {   
     
   /**
    * @objects
    * 
    */     
    private $objects = array();    

   /**
    * @object
    * 
    */     
    private $ObjectInstance;    

   /**
    * @object
    * 
    */     
    private $ObjectNames = array();

   /**
    * @object
    * 
    */     
    private $ObjectInstanceFromList = null;    

   /**
    * @object
    * 
    */     
    private $ObjectBuilder;    

   /**
    * @object
    * 
    */     
    protected $NameOfObject;    

   /**
    * @instance
    * 
    */     
    private static $instance = null;
	  
   /**
    * @public
    *
    */   
    public static function getInstance(){
       if(self::$instance === null){
          self::$instance = new ObjectFactory();
       }
       return self::$instance;
    } 

   /**
    * @public
    *
    */   
     public function set($name, $object) {
            $this->objects[$name] = $object;   
	 }  

   /**
    * @public
    *
    */      
    public function get($name) {  
		if($this->isObjectRegistered($name)){
		   return $this->objects[$name]; 
		} else
	   return trigger_error('Object ['.$name.'] nicht registriert!');  
    } 

   /**
    * @public
    *
    */   
     public function destroy($name) {
            unset($this->objects[$name]);   
	 }  


   /**
    * @private
    *
    */      
    private function getClassName($ClassName){
         return get_class($ClassName); 
     }
    
   /**
    * @public
    *    
    */
	public function getAllObjectInstances() { 
         return $this->objects;	              
    }
   /**
    * @public
    *    
    */
	public function getAllObjectNames() { 

       foreach($this->objects as $key => $value){ 
   	           if(is_object($value)){                        
			      $this->ObjectNames[$key] = $this->getClassName($value);		  

			   }
       }           
       return $this->ObjectNames; 
    } 

   /**
    * @protected
    *
    * is object in cache
    */      
    public function isObjectRegistered($className){
          if(isset($this->objects[$className])){
             return (is_object($this->objects[$className])) ? true : false;
          } 
		  else return false;   
    }

   /**
    * @private
    *
    */      
    private function getObjectName($ClassName,$AliasName) {       
        if(empty($AliasName)) return $ClassName;       
        return (strcmp ($ClassName,$AliasName)==0) ? $ClassName : $AliasName;
    }  
  
   /**
    * @public
    * create object over ObjectBuilder
    */      
    private function createObject($ClassName,$AliasName='') { 

         // Object Builder instanzieren
         $this->ObjectBuilder = ObjectBuilder::getInstance(); 

         // Name of Object
         $this->NameOfObject = $this->getObjectName($ClassName,$AliasName);

         // Object über Object Builder anfordern
         $this->ObjectInstance = $this->ObjectBuilder->createObject($ClassName);

         // set ObjectInstance in ObjectManager
		 $this->set($this->NameOfObject,$this->ObjectInstance);

         // Destroy Object Instance über Object Builder
         $this->ObjectBuilder->destroy($this->ObjectInstance);

         // return ObjectInstance from ObjectManager
         return $this->get($this->NameOfObject);
    }

   /**
    * @public
    * @params Name of class
    * @params Aliasname of class
    *
    */      
    public function getObject($ClassName,$AliasName) { 

         // Singleton    
         if(strcmp ($ClassName,$AliasName)==0 || empty($AliasName)){		     		    
            if(!$this->isObjectRegistered($ClassName)) {          
                $this->createObject($ClassName);
            }
            return $this->get($ClassName);
         }
         else  {
         // Objects over Name of Alias
            if(!$this->isObjectRegistered($AliasName)) {                        
                $this->createObject($ClassName,$AliasName);
            }         
            return $this->get($AliasName);     
         }
    }    
}
?>