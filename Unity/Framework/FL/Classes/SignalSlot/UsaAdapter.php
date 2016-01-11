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
#		$this->method = $this->request->getMethod();
		$this->method = 'POST';
		/*
		 * who is my route ?
		 */	
		$routing = strtoupper($this->registry->routerRouting);

		/*
		 * init unity screen design -> usa adapter
		 */	
		$USD_U = '';
		$USD_S = '';
		$USD_A = '';
	    
		/*
		 * USA Adapter required, if method POST
		 */ 
		if($this->method 			     === 'POST' 
		&& $this->registry->routerUsd    === true
		&& $routing                      === 'STANDARD'
		){ 	
	        // U : Name of Unity
        	// S : Number of Screen
        	// A : Name of Action         
	        $USD_U = $this->request->getPost($this->registry->hiddenfieldsUnity);
	        $USD_S = $this->request->getPost($this->registry->hiddenfieldsScreen);
	        $USD_A = $this->request->getPost($this->registry->hiddenfieldsAction);

		} 
		else
		
		/*
		 * USA Adapter required, if method GET
		 */ 
		if($this->method                 === 'GET' 
		&& $this->registry->routerUsd    === true
		&& $routing                      === 'STANDARD'
		){

	        // U : Name of Unity
        	// S : Number of Screen
        	// A : Name of Action         
	        $USD_U = $this->request->getGet($this->registry->hiddenfieldsUnity);
	        $USD_S = $this->request->getGet($this->registry->hiddenfieldsScreen);
	        $USD_A = $this->request->getGet($this->registry->hiddenfieldsAction);
		}

		// set standard, if fields are empty
		$USD_U = (empty($USD_U)) ? $this->registry->standardUnity  : $USD_U;
		$USD_S = (empty($USD_S)) ? $this->registry->standardScreen : $USD_S;
		$USD_A = (empty($USD_A)) ? $this->registry->standardAction : $USD_A;	
		$USD_A = (empty($USD_A)) ? 'index' : $USD_A;
		
		// Debug/Trace
		$this->debug->trace('USD Params: UNITY: ('.$USD_U.'), SCREEN: ('.$USD_S.'), ACTION: ('.$USD_A.')'
		  		                       ,'Dispatcher/Router'
							);	
	
		// get USA Adapter
		return array( $USD_U, $USD_S, $USD_A);
	} 
}
?>