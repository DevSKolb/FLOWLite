<?php
/*                                                                        *
 * This script required the FLOWLite framework.                           *
 * --------------------------------------------------------------------   *
 * Projekt:                   | ""                                        *
 * Titel:                     | Scaffolding Application                   *
 * --------------------------------------------------------------------   *
 * Class Name:                | standardController                        *
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
		 * View Object (tpl_rahmen)
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
        $langTextArray 	= $lang->getPhrase($this->registry->localeLanguage,true);

		/*
		 * CONTENT
		 */
		$content = "Hello World !";


		/*
		 * content in unitView füllen
		 */
		$unitView->assign('CONTENT',$content);



		/*
		 * content in View füllen
		 */
		$view->assign('CONTENT',$unitView);

		/*
		 * Template unit
		 */
		$unitView->setTemplate('tpl_standardController.htm');
	}
}
?>