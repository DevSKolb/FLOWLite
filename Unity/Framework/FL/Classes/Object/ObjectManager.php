<?php
/*                                                                        *
 * This script belongs to the IRS3 framework.                             *
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
final class ObjectManager {   
   /**
    * @object
    * 
    */     
    private $Objects;    
     
   /**
    * @object
    * 
    */     
    private $ObjectFactory;    

   /**
    * @object
    * 
    */     
    private $ObjectInstance = null;    

   /**
    * @object
    * 
    */     
    private $ObjectNames = null;    

   /**
    * @object
    * 
    */     
 #   private $ObjectInstances = array();    

   /**
    * @instance
    * 
    */     
    private static $instance = null;

   /**
    * @instance
    * 
    */     
    private $debug = null;

  /**
   * @access private
   * Singleton-Konstruktor     
   */  
   private function __construct() { }
  
  /**
   * @access private
   * Singleton-__clone()-Interzeptor
   */ 
   private function __clone() {}
  	  
   /**
    * @public
    *
    */   
    public static function getInstance(){
       if(self::$instance === null){
          self::$instance = new ObjectManager();
       }
       return self::$instance;
    } 
 
   /**
    * @public
    *
    */      
     public function getAllObjectInstances() { 
         // Object Factory instanzieren
         $this->ObjectFactory = ObjectFactory::getInstance(); 
         $this->Objects = $this->ObjectFactory->getAllObjectInstances();

         // return All ObjectInstances from ObjectFactory
         return $this->Objects;		 
    }

   /**
    * @public
    *
    */      
    public function destroy($Name) { 
 		
        // Object Factory instanzieren
        $this->ObjectFactory = ObjectFactory::getInstance(); 
		
		// Objeckt ist registriert
        if($this->ObjectFactory->isObjectRegistered($Name)){

			// Object Instance anfordern
			$this->ObjectInstance = $this->ObjectFactory->get($Name);

			// Object aus der Factory nehmen
        	$this->ObjectFactory->destroy($Name);
        	
        	// Object Instance zerstören
			unset($this->ObjectInstance);
 		}
 	}
 	
   /**
    * @public
    *
    */      
    public function getAllObjectNames() { 
    
         // Object Factory instanzieren
         $this->ObjectFactory = ObjectFactory::getInstance(); 
         $this->ObjectNames = $this->ObjectFactory->getAllObjectNames();

         // return All ObjectInstances from ObjectFactory
         return $this->ObjectNames;		 
    }
   /**
    * @public
    *
    */      
    public function get($Name) { 
    
         // Object Factory instanzieren
         $this->ObjectFactory = ObjectFactory::getInstance();          
         $this->ObjectInstance = $this->ObjectFactory->get($Name);

         // return ObjectInstance from ObjectFactory
         return $this->ObjectInstance;		 
    }
    
   /**
    * @public
    *
    */      
    private function setTrace($ClassName,$AliasName) { 
    
	    $class_concat  = $ClassName;
		$class_concat .= (!empty($AliasName)) ? ':'.$AliasName : '';
	 
		if($this->ObjectFactory->isObjectRegistered($ClassName))
		{
			$this->debug->trace('Objekt Instance angefordert: '.$class_concat ,'ObjectManager');			
		} else
		 	$this->debug->trace('Objekt registriert: '.$class_concat ,'ObjectManager');			
    }
	    
   /**
    * @public
    *
    */      
    public function getObject($ClassName,$AliasName='') { 

         // Object Factory instanzieren
         $this->ObjectFactory = ObjectFactory::getInstance(); 

		 // Wenn das Objekt Debug bereits registriert wurde, 
		 // gibt mit die Intance auf dieses Objekt

		 if(FL_TRACE){ 	
			 if(TRACE_SYSTEM){ 
				if($this->ObjectFactory->isObjectRegistered('Debug')){
			       $this->debug = $this->ObjectFactory->getObject('Debug','');
	    		   $this->setTrace($ClassName,$AliasName);
		 		}  
			 }
		 }

		 /*
		  * call object factory
		  */
         $this->ObjectInstance = $this->ObjectFactory->getObject($ClassName, $AliasName);
         // return ObjectInstance from ObjectFactory
         return $this->ObjectInstance;		 
    }
}
?>