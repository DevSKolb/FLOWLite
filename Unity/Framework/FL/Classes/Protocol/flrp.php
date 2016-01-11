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
class flrp
{
    /**
     * FLRP: FLOWLite Router Protocol
     *
     * @var    array
     */
	private $flrp_controller;

    /**
     * USA Adapter
     *
     * @U :: Unity
     * @S :: Screen
     * @A :: Action
     */
	private $usaAdapter = array();

    /**
     * CAP: Controller Action Protocol
     *
     * @var    array
     */
	private $flrp_action;

	private $flrp_unity;
	private $flrp_screen;


    /**
     * init USA Adapter
     */
	public function initUSA(){
		
		// set unity, screen and action
		$this->usaAdapter['unity']  = '';
		$this->usaAdapter['screen'] = '';
		$this->usaAdapter['action'] = '';		
	}  

    /**
     * set USA Adapter
     */
	public function setUSA($unity, $screen, $action){
		
		// set unity, screen and action
		$this->usaAdapter['unity']  = $unity;
		$this->usaAdapter['screen'] = $screen;
		$this->usaAdapter['action'] = $action;			
	}  

    /**
     * get USA Adapter
     */
	public function getUSA(){		
		return $this->usaAdapter;
	}  
	
    /**
     * CAP: Controller Action Protocol
     *
     * @var    array
     */
	public function setController($controller){
		$this->flrp_controller = $controller;	  	  
	}  
	public function setUnity($unity){
		$this->flrp_unity = $unity;	  	  
	}  
	public function setScreen($screen){
		$this->flrp_screen = $screen;	  	  
	}  

    /**
     * CAP: Controller Action Protocol
     *
     * @var    array
     */
	public function getController(){
		return $this->flrp_controller;	  	  
	}  
	public function getUnity(){
		return $this->flrp_unity;	  	  
	}  	
	public function getScreen(){
		return $this->flrp_screen;	  	  
	}  
    /**
     * CAP: Controller Action Protocol
     *
     * @var    array
     */
	public function setAction($action){
		$this->flrp_action = $action;	  	  
	}  

    /**
     * CAP: Controller Action Protocol
     *
     * @var    array
     */
	public function getAction(){
		return $this->flrp_action;	  
	}  
}	
?>