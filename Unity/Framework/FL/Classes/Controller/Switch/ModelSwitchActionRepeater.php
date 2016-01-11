<?php
/*                                                                        *
 * This script required the FLOWLite framework.                           *
 * This corpuscle is a component of the TC Project.                       *
 * --------------------------------------------------------------------   *
 * Projekt:                   | Technical Configurator (TC)               *
 * Titel:                     | Set action and repeater                   *
 * --------------------------------------------------------------------   *
 * Class Name:                | ModelSwitchActionRepeater                 *
 * Programmtyp:               | Model                            		  *
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
final class ModelSwitchActionRepeater extends System {

  /**
   * @access private
   * screen nr
   */
	private $screen;
   
  /**
   * @access private
   * action
   */
	private $action;

  /**
   * @access private
   * repeater
   */
	private $repeater;

  /**
   * @access public
   * 
   * switching action code of index
   * set SystemFrontControllerRepeater of true
   *
   */  
   public function setActionAndRepeater($screen='1000',$action='index',$repeater=false,$unity=false) {

		$this->request = $this->objectManager->getObject('Request');
        $USC_UNITY     = $this->request->getPost($this->registry->hiddenfieldsUnity);
        $USC_SCREEN    = $this->request->getPost($this->registry->hiddenfieldsScreen);
		$this->registry->controllerName = $USC_UNITY.'_'.$USC_SCREEN;


		// is screen ?
		$this->screen = (empty($screen)) ? '1000' : $screen;

		// is action ?
		$this->action = (empty($action)) ? 'index' : $action;

		// is repeater ?
		$this->repeater = (empty($repeater)) ? false : $repeater;


		// Restore POST data
#		$this->request = $this->objectManager->getObject('Request');
		$this->request->setWriteSecurity();	
		$this->request->setPost('apps_screen',$this->screen,'f0dd00aae5d2aeb141b984566f3101558ee87cd8');	
		$this->request->setPost('apps_action',$this->action,'f0dd00aae5d2aeb141b984566f3101558ee87cd8');	

		if($unity !== false){
		  $this->request->setPost('apps_unity',$unity,'f0dd00aae5d2aeb141b984566f3101558ee87cd8');	
		}

		$this->request->closeWriteSecurity();

		$this->registry->controllerName = $USC_UNITY.'_'.$this->screen;
		$this->registry->controllerForStep = $this->registry->controllerName;

		/*
	     * @flrp (FLOWLite Router Protocol)
	     */
#		$flrp = $this->objectManager->getObject('flrp');



		// set repeater for system front controller
		$this->registry->SystemFrontControllerRepeater = $this->repeater;		
   }
}
?>