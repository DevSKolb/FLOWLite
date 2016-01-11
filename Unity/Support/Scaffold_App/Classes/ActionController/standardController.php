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
class standardController extends CController {

	/*
	 * @action of index
	 */
	public function indexAction()
	{
		/*
		 * View Object (tpl_index)
		 */
		$view = $this->objectManager->getObject('View');    	
		
		/*
		 * Unit View Object 
		 */
		$unitView = $this->objectManager->getObject('View','unitView');    		
		
		/*
		 * Translation
		 * Übersetzungs Array 
		 */
		$lang 			= $this->objectManager->getObject('Translator');    
		$langTextArray 	= $lang->getPhrase($this->registry->localeLanguage);
		
		/*
		 * CONTENT
		 */
		$content = "Hello World !";
		
		/*
		 * content in unitView füllen
		 */
		$unitView->assign('CONTENT',$content);
		
		/*
		 * Template unit
		 */
		$unitView->setTemplate('tpl_standardController.htm');
		
		/*
		 * content in View füllen
		 */
		$view->assign('CONTENT',$unitView);
		
	}
}
?>	
