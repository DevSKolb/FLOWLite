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
class UsaAdapter extends System  {

	/*
	 * instance of request object
	 */
	private $request;

	/*
	 * Request Method  GET/POST
	 */
	private $method;

	/*
	 * USA Adapter
	 */
	public function getUSAParams(){
	 
		/*
		 * Request object
		 */	
		$this->request = $this->objectManager->getObject('Request');

		/*
		 * Debug object
		 */	
		$this->debug = $this->objectManager->getObject('Debug');

		/*
		 * Request Method
		 */	
		$this->method = $this->request->getMethod();
		
		/*
		 * USA Adapter required, if method POST
		 */ 
		if($this->method 			     === 'POST' 
		&& $this->registry->routerUsd    === true
		&& $this->registry->routerRouter === 'STANDARD'
		){
		 	
	        // U : Name of Unity
        	// S : Number of Screen
        	// A : Name of Action         
	        $USA_UNITY  = $this->request->getPost($this->registry->hiddenfieldsUnity);
	        $USA_SCREEN = $this->request->getPost($this->registry->hiddenfieldsScreen);
	        $USA_ACTION = $this->request->getPost($this->registry->hiddenfieldsAction);
		} 
		else
		
		/*
		 * USA Adapter required, if method GET
		 */ 
		if($this->method                 === 'GET' 
		&& $this->registry->routerUsd    === true
		&& $this->registry->routerRouter === 'STANDARD'
		){
		 	
	        // U : Name of Unity
        	// S : Number of Screen
        	// A : Name of Action         
	        $USA_UNITY  = $this->request->getGet($this->registry->hiddenfieldsUnity);
	        $USA_SCREEN = $this->request->getGet($this->registry->hiddenfieldsScreen);
	        $USA_ACTION = $this->request->getGet($this->registry->hiddenfieldsAction);
		}

		// set standard, if fields are empty
		$USD_UNITY     = (empty($USD_UNITY))  ? $this->registry->standardUnity  : $USD_UNITY;
		$USD_SCREEN    = (empty($USD_SCREEN)) ? $this->registry->standardScreen : $USD_SCREEN;
		$USD_ACTION    = (empty($USD_ACTION)) ? $this->registry->standardAction : $USD_ACTION;	
		$USD_ACTION    = (empty($USD_ACTION)) ? 'index' : $USD_ACTION;
		
		// Debug/Trace
		$this->debug->trace('USD Params: UNITY: ('.$USD_UNITY.'), SCREEN: ('.$USD_SCREEN.'), ACTION: ('.$USD_ACTION.')'
		  		                       ,'Dispatcher/Router'
							);	
		
		// get USA Adapter
		return array( $USD_UNITY, $USD_SCREEN, $USD_ACTION);
	} 
}
?>