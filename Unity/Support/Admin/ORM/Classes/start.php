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
class start extends CController {

 	/*
 	 * error message (string)
 	 */
	private $errorMessage = '';

 	/*
 	 * list of objects (array)
 	 */
	private $listObjects;
	
 	/*
 	 * indexAction
 	 */
    public function indexAction(){

		// VIEW Object
     	$view =  $this->objectManager->getObject('View');    

		// TITLE
		$view->assign('APPS-TITLE','FLOWLite - Scaffolding ORM');		

		// Error ?
		if(empty($this->errorMessage)){
			$view->assign('ERROR-SHOW','none');		
		}
		else
		{
			$view->assign('ERROR-MESSAGE',$this->errorMessage);		
			$view->assign('ERROR-SHOW','block');		
  	    }	

		$HOST = $this->request->getPost('host');
		$DB   = $this->request->getPost('dbname');
		$USER = $this->request->getPost('dbuser');
		$PASS = $this->request->getPost('dbpass');
		$PREFIX = $this->request->getPost('prefix');
		$SUBF = $this->request->getPost('sfolder');
		
		$view->assign('INPUT-HOST',$HOST);		
		$view->assign('INPUT-DB',$DB);		
		$view->assign('INPUT-USER',$USER);		
		$view->assign('INPUT-PASS',$PASS);		
		$view->assign('INPUT-PREFIX',$PREFIX);		
		$view->assign('INPUT-SFOLDER',$SUBF);		

		// getSet baseURL
		$this->request->setBaseUrl($this->request->getBaseUrl());

		// set baseURL to Placeholder
		$baseURL = '<base href="'.$this->request->getBaseUrlOfApp().'">';

		// set placeholder to view
		$view->assign('baseURL',$baseURL);
	
		// Template (CSS3)
	    $view->setTemplate('index.htm');
	    $view->render();
   }

 	/*
 	 * submitAction
 	 */
    public function submitAction(){

		$this->errorMessage = '';

		$HOST = $this->request->getPost('host');
		$DB   = $this->request->getPost('dbname');
		$USER = $this->request->getPost('dbuser');
		$PREFIX  = $this->request->getPost('prefix');
		$SFOLDER = $this->request->getPost('sfolder');

		// Sub folder
		$SUBF  = FL_PATH_ORM . '/';

		// Registry Entries
		$this->registry->ormprefix = $PREFIX;
		$this->registry->ormfolder = $SFOLDER;
			
		// Validate
		if(empty($HOST) || !is_string($HOST)){
			 $this->errorMessage = 'Bitte geben Sie einen Hostnamen ein !';
		}else
		if(empty($DB) || !is_string($DB)){
			 $this->errorMessage = 'Bitte geben Sie eine Datenbank ein !';
		}else
		if(empty($USER) || !is_string($USER)){
			 $this->errorMessage = 'Bitte geben Sie einen Datenbank-User ein !';
		}
		else
		{
		   	$this->registry->databaseHost		= $this->request->getPost('host');     
		   	$this->registry->databaseAccess		= 'MYSQL';     
		   	$this->registry->databaseDbname		= $this->request->getPost('dbname');          
		   	$this->registry->databaseDbuser 	= $this->request->getPost('dbuser');     
		   	$this->registry->databaseDbpass 	= $this->request->getPost('dbpass');    
	 	    

			// testing db connect for ORM
			try {
				$dbh = new PDO("mysql:host=".$this->registry->databaseHost.";dbname=".$this->registry->databaseDbname."",$this->registry->databaseDbuser,$this->registry->databaseDbpass);		    
		    
			    $dbh->exec("SET CHARACTER SET utf8");
			    $dbh = null;
		    
			} catch (PDOException $e) {
				 $this->errorMessage = 'Fehler beim Datenbank Connect !';
			}
		}
	
		// is folder exists
		if(!empty($SFOLDER))
		{
			$SUBF .= $SFOLDER.'/';

			if(!is_dir($SUBF))
			{
			 	$this->errorMessage = 'Sub folder "'.$SUBF.'" not found.';		    
			} 
		} 
		
		// scan oder nicht scan, das ist hier die Frage ?
		if(empty($this->errorMessage))
		{
		  	$this->scanAction();
		}
		else
			$this->indexAction();
	}

 	/*
 	 * scanAction
 	 */
    private function scanAction(){

		// VIEW Object
     	$view =  $this->objectManager->getObject('View');    

		// TITLE
		$view->assign('APPS-TITLE','FLOWLite - Scaffolding ORM');		

		// Scanning	
       	$dbscanning = $this->objectManager->getObject('DBScan_MYSQL');
      	$dbscanning->scan();		

		// Path to ORM
		$ormPath = FL_PATH_ORM . '/';  

		// sub folder for orm tables
		if(!empty($this->registry->ormfolder)) 
		{
			$ormPath .= $this->registry->ormfolder . '/'; 
		}

		// Namespace Bereich ORM aufnehmen
		$objekte = ResourcesNameSpaces::getNamespaces( $ormPath , false  );
		
		// ORM counter	
		$view->assign('ORM_FINISH','ORM generate of '.count($objekte).' objects:');		

		// Objekte
		foreach($objekte as $key => $value){

			$filestr = file_get_contents($value);

			$a = explode('array(',$filestr);
			$b = explode('))',$a[1]);
			
			$this->listObjects .= '<div id="orm_object">'.$key . "</div>";		 
			$this->listObjects .= '<div id="orm_object_fields">'.$b[0] . "</div>";		 
		}

		// ORM objecte
		$view->assign('LIST_ORM_TABLES',$this->listObjects);		

		// getSet baseURL
		$this->request->setBaseUrl($this->request->getBaseUrl());

		// set baseURL to Placeholder
		$baseURL = '<base href="'.$this->request->getBaseUrlOfApp().'">';

		// set placeholder to view
		$view->assign('baseURL',$baseURL);


		// link to start
		$linkToStart = '<a href="/FLOWLite_1.0/Unity/Support/Admin/ORM/start.html">Zur ORM Startseite</a>';
		$view->assign('ORM_START',$linkToStart);

		// Template (CSS3)
	    $view->setTemplate('result.htm');
	    $view->render();
   }
}
?>