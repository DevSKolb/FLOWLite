<?php
/*                                                                        *
 * This script required the FLOWLite framework.                           *
 * --------------------------------------------------------------------   *
 * Projekt:                   | "FLOWLite_App"                            *
 * Titel:                     | Scaffolding Application                   *
 * --------------------------------------------------------------------   *
 * Class Name:                | standardController.php                    *
 * Programmtyp:               | Action Controller                         *
 * --------------------------------------------------------------------   *
 *                                                                        */
class PostControllerView extends CController {

	public function execute(Request $request){

		// View Object instanzieren
      	$view =  $this->objectManager->getObject('View');    

		// getSet baseURL
		$this->request->setBaseUrl($this->request->getBaseUrl());
		
		// set baseURL to Placeholder
		$baseURL = '<base href="'.$this->request->getBaseUrlOfApp().'">';
		
		// set placeholder to view
		$view->assign('baseURL',$baseURL);
		
		/*
		 * Template view
		 */
		$view->setTemplate('tpl_index.htm');
		
		// View render and Output
    	$view->render();
	}
}
?>	
