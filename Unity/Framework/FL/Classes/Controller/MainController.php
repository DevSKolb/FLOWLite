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
abstract class MainController implements ControllerInterface {

	/**
	 * @var object Manager
	 */
	protected $objectManager;
 
	/**
	 * @var Request
	 */
	protected $request;
 
   /**
    * @var Registry
    */
   	protected $registry;

   /**
    * @var layout (view)
    */
   	protected $layout;

	/**
	 * Database object
	 * @var object
	 */
	protected $database;

   /**
    * Initialize
    */
	public function __construct(){
      
   // ObjectManager aufrufen
	  $this->objectManager = ObjectManager::getInstance();
          
   // Registry
      $this->registry = $this->objectManager->getObject('Registry');	   
			
   // Request 
      $this->request = $this->objectManager->getObject('Request');	  

   // Debug Trace
      $this->debug = $this->objectManager->getObject('Debug');	  

		// Database access point
	    $this->database = $this->objectManager->getObject('Database');	  
		$this->database->connect();
		
 		return $this;
   } 
   
}
?>