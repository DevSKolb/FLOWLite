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
 	 * app name
 	 */
	private $appName;

 	/*
 	 * folder
 	 */
	private $folder;

 	/*
 	 * indexAction
 	 */
    public function indexAction(){

		// VIEW Object
     	$view =  $this->objectManager->getObject('View');    

		// TITLE
		$view->assign('APPS-TITLE','FLOWLite - Scaffolding App');		
	
		// Error ?
		if(empty($this->errorMessage)){
			$view->assign('ERROR-SHOW','none');		
		}
		else
		{
			$view->assign('ERROR-MESSAGE',$this->errorMessage);		
			$view->assign('ERROR-SHOW','block');		
  	    }	

		$FOLDER_NAME = $this->request->getPost('appname');
	
		$view->assign('INPUT-APPNAME',$FOLDER_NAME);	

		$INPUT_HOST = $this->request->getPost('host');
		$INPUT_DB 	= $this->request->getPost('dbname');
		$INPUT_USER = $this->request->getPost('dbuser');
		$INPUT_PASS = $this->request->getPost('dbpass');

		$INPUT_HOST = (empty($INPUT_HOST)) ? 'localhost' : $INPUT_HOST;		

		$view->assign('INPUT-HOST',$INPUT_HOST);	
		$view->assign('INPUT-DB'  ,$INPUT_DB);	
		$view->assign('INPUT-USER',$INPUT_USER);	
		$view->assign('INPUT-PASS',$INPUT_PASS);	

		$START_MENU = '<a href="/FLOWLite_1.0/Unity/Support/">Menue</a>';
		$view->assign('START_MENU',$START_MENU);	

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

		$appname = $this->request->getPost('appname');
		$uritype = $this->request->getPost('uritype');

		// app folder
		$APP_FOLDER  = $_SERVER['DOCUMENT_ROOT'] . '/';

		// Validate
		if(empty($appname) || !is_string($appname)){
			 $this->errorMessage = 'Bitte geben Sie eine Applikation ein !';
		}

		// is folder exists
		$APP_FOLDER = $APP_FOLDER . $appname . '/';

		// name of application
		$this->appName = $appname;
		$this->folder  = $APP_FOLDER;
		
		if(!empty($APP_FOLDER))
		{
			if(is_dir($APP_FOLDER))
			{		 
			 	$this->errorMessage = 'Application "'.$appname.'" already exists.';		    	 	
			} 
		}

		if(empty($this->errorMessage))
		{
		  	$this->createAppAction();
		}
		else
			$this->indexAction();
	}

	/*
 	 * create app
 	 */
    private function createAppAction(){

		// VIEW Object
     	$view =  $this->objectManager->getObject('View');    

		// TITLE
		$view->assign('APPS-TITLE','FLOWLite - Scaffolding App');		

		// Routing method
		$routing	 = $this->request->getPost('uritype');
		$useCache    = $this->request->getPost('usecache');
		$useORM      = $this->request->getPost('useorm');

		$INPUT_HOST = $this->request->getPost('host');
		$INPUT_DB 	= $this->request->getPost('dbname');
		$INPUT_USER = $this->request->getPost('dbuser');
		$INPUT_PASS = $this->request->getPost('dbpass');

		$appname 	= $this->request->getPost('appname');

		// Create Folder
		$folder_0  = $this->folder;
		$folder_1  = $this->folder . '/Classes/ActionController/';
		$folder_2  = $this->folder . '/Classes/Model/';
		$folder_3  = $this->folder . '/Classes/PreController/';
		$folder_4  = $this->folder . '/Classes/PostController/';
		$folder_5  = $this->folder . '/Configuration/';
		$folder_6  = $this->folder . '/images/';
		$folder_7  = $this->folder . '/js/';
		$folder_8  = $this->folder . '/Language/de/';
		$folder_9  = $this->folder . '/Language/en/';
		$folder_10 = $this->folder . '/Logs/';
		$folder_11 = $this->folder . '/styles/';
		$folder_12 = $this->folder . '/Templates/';

		$this->errorMessage = '';


		// Applikationsordner anlegen
		if (mkdir(${'folder_0'}, 0777, true)) 
		{

		// mkdir sub folder
		for ( $i = 1; $i < 13; $i++ ){

		 if (!mkdir(${'folder_'.$i}, 0777, true)) 
		 {
			$this->errorMessage = 'Das Anlegen der Applikation schlug fehl !';		    
		 }
		}

		// Language files de.php
		$filename = $this->folder . '/Language/de/de.php';
		
		if (!file_exists($filename)) 
		{
			$phrase = 
					'<?php '."\r\n".
					'	$phrase = array(' 	."\r\n".						 	
					'				\'title\'	=> \'FLOWLite Anlegen Applikation\''."\r\n".
					'	);'	."\r\n".
					'?>'."\r\n";
			
			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "de.php" schlug fehl !';		    

		// Language files en.php
		$filename = $this->folder . '/Language/en/en.php';
		
		if (!file_exists($filename)) 
		{
			$phrase = 
					'<?php '."\r\n".
					'	$phrase = array(' 	."\r\n".						 	
					'				\'title\'	=> \'FLOWLite Create Application\''."\r\n".
					'	);'	."\r\n".
					'?>'."\r\n";
			
			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "en.php" schlug fehl !';		    


		/*
		 *  Template tpl_standardController.htm anlegen
		 */ 
		$filename = $this->folder . '/Templates/tpl_standardController.htm';
		
		if (!file_exists($filename)) 
		{
			$phrase = '{CONTENT}';
			
			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "tpl_standardController.htm" schlug fehl !';		    


		/*
		 * Template tpl_index.htm anlegen
		 */
		$filename = $this->folder . '/Templates/tpl_index.htm';
		
		if (!file_exists($filename)) 
		{
			$phrase = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'."\r\n".
				'<html>'."\r\n".
				'<head>'."\r\n";
				
				if($routing == '1'){
					$phrase .= '{baseURL}'."\r\n";
				}	
				
				$phrase .=
				'<meta http-equiv="content-type" content="text/html; charset=UTF-8">'."\r\n".
				'<title>FLOWLite index.php</title>'."\r\n".
				'</head>'."\r\n".
				'<body>'."\r\n".
				'{CONTENT}'."\r\n".
				'</body>'."\r\n".
				'</html>'."\r\n";

			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "tpl_index.htm" schlug fehl !';		    

		/*
		 *  create index.php 
		 */ 
		$filename = $this->folder . '/index.php';
		
		if (!file_exists($filename)) 
		{
			$phrase = 
			
			'<?php'."\r\n".
			'/*                                                                        *'."\r\n".
			' * This script belongs to the FLOWLite framework.                         *'."\r\n".
			' *                                                                        *'."\r\n".
			' * It is free software; you can redistribute it and/or modify it under    *'."\r\n".
			' * the terms of the GNU Lesser General Public License as published by the *'."\r\n".
			' * Free Software Foundation, either version 3 of the License, or (at your *'."\r\n".
			' * option) any later version.                                             *'."\r\n".
			' *                                                                        *'."\r\n".
			' * This script is distributed in the hope that it will be useful, but     *'."\r\n".
			' * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *'."\r\n".
			' * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *'."\r\n".
			' * General Public License for more details.                               *'."\r\n".
			' *                                                                        *'."\r\n".
			' * You should have received a copy of the GNU Lesser General Public       *'."\r\n".
			' * License along with the script.                                         *'."\r\n".
			' * If not, see http://www.gnu.org/licenses/lgpl.html                      *'."\r\n".
			' *                                                                        */'."\r\n".
			'/**'."\r\n".
			' * Define FLOWLite Framework'."\r\n".
			' */'."\r\n".
			'define(\'FL_PATH_FRAMEWORK\',  $_SERVER["DOCUMENT_ROOT"] .\'/\'. \'FLOWLite_1.0/Unity/Framework/FL/Scripts/\');'."\r\n".
			'/**'."\r\n".
			' * FLOWLite start'."\r\n".
			' */'."\r\n".
			'require( FL_PATH_FRAMEWORK . \'FLOWLite.php\');'."\r\n".
			'?>'."\r\n";

			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "tpl_index.htm" schlug fehl !';		    

		/*
		 *  standard controller "standardController.php" anlegen
		 */ 
		$filename = $this->folder . '/Classes/ActionController/standardController.php';
		
		if (!file_exists($filename)) 
		{
			$phrase = 
			
			'<?php'."\r\n".
			'/*                                                                        *'."\r\n".
			' * This script required the FLOWLite framework.                           *'."\r\n".
			' * --------------------------------------------------------------------   *'."\r\n".
			' * Projekt:                   | "'.$appname.'"                            *'."\r\n".
			' * Titel:                     | Scaffolding Application                   *'."\r\n".
			' * --------------------------------------------------------------------   *'."\r\n".
			' * Class Name:                | standardController.php                    *'."\r\n".
			' * Programmtyp:               | Action Controller                         *'."\r\n".
			' * --------------------------------------------------------------------   *'."\r\n".
			' *                                                                        */'."\r\n".
			'class standardController extends CController {'."\r\n".
			''."\r\n".
			'	/*'."\r\n".
		    '	 * @action of index'."\r\n".
			'	 */'."\r\n".
			'	public function indexAction()'."\r\n".
			'	{'."\r\n".
			'		/*'."\r\n".
			'		 * View Object (tpl_index)'."\r\n".
			'		 */'."\r\n".
			'		$view = $this->objectManager->getObject(\'View\');    	'."\r\n".
			'		'."\r\n".
			'		/*'."\r\n".
			'		 * Unit View Object '."\r\n".
			'		 */'."\r\n".
			'		$unitView = $this->objectManager->getObject(\'View\',\'unitView\');    		'."\r\n".
			'		'."\r\n".
			'		/*'."\r\n".
			'		 * Translation'."\r\n".
			'		 * Übersetzungs Array '."\r\n".
			'		 */'."\r\n".
			'		$lang 			= $this->objectManager->getObject(\'Translator\');    '."\r\n".
		    '		$langTextArray 	= $lang->getPhrase($this->registry->localeLanguage);'."\r\n".
			'		'."\r\n".
			'		/*'."\r\n".
			'		 * CONTENT'."\r\n".
			'		 */'."\r\n".
			'		$content = "Hello World !";'."\r\n".
			'		'."\r\n".
			'		/*'."\r\n".
			'		 * content in unitView füllen'."\r\n".
			'		 */'."\r\n".
			'		$unitView->assign(\'CONTENT\',$content);'."\r\n".
			'		'."\r\n".
			'		/*'."\r\n".
			'		 * Template unit'."\r\n".
			'		 */'."\r\n".
			'		$unitView->setTemplate(\'tpl_standardController.htm\');'."\r\n".
			'		'."\r\n".
			'		/*'."\r\n".
			'		 * content in View füllen'."\r\n".
			'		 */'."\r\n".
			'		$view->assign(\'CONTENT\',$unitView);'."\r\n".
			'		'."\r\n".
			'	}'."\r\n".
			'}'."\r\n".
			'?>	'."\r\n";

			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "standardController.php" schlug fehl !';		    


		/*
		 *  post controller "PostControllerView.php" anlegen
		 */ 
		$filename = $this->folder . '/Classes/PostController/PostControllerView.php';
		
		if (!file_exists($filename)) 
		{
			$phrase = 
			
			'<?php'."\r\n".
			'/*                                                                        *'."\r\n".
			' * This script required the FLOWLite framework.                           *'."\r\n".
			' * --------------------------------------------------------------------   *'."\r\n".
			' * Projekt:                   | "'.$appname.'"                            *'."\r\n".
			' * Titel:                     | Scaffolding Application                   *'."\r\n".
			' * --------------------------------------------------------------------   *'."\r\n".
			' * Class Name:                | standardController.php                    *'."\r\n".
			' * Programmtyp:               | Action Controller                         *'."\r\n".
			' * --------------------------------------------------------------------   *'."\r\n".
			' *                                                                        */'."\r\n".
			'class PostControllerView extends CController {'."\r\n".
 			''."\r\n".
			'	public function execute(Request $request){'."\r\n".
			''."\r\n".
			'		// View Object instanzieren'."\r\n".
			'      	$view =  $this->objectManager->getObject(\'View\');    '."\r\n".
    		''."\r\n";
    		
    		
			if($routing == '1'){

			$phrase .= 

			'		// getSet baseURL'."\r\n".
			'		$this->request->setBaseUrl($this->request->getBaseUrl());'."\r\n".
			'		'."\r\n".
			'		// set baseURL to Placeholder'."\r\n".
			'		$baseURL = \'<base href="\'.$this->request->getBaseUrlOfApp().\'">\';'."\r\n".
			'		'."\r\n".
			'		// set placeholder to view'."\r\n".
			'		$view->assign(\'baseURL\',$baseURL);'."\r\n".
			'		'."\r\n";

			}
		
			$phrase .= 

			'		/*'."\r\n".
			'		 * Template view'."\r\n".
			'		 */'."\r\n".
			'		$view->setTemplate(\'tpl_index.htm\');'."\r\n".
			'		'."\r\n".
			'		// View render and Output'."\r\n".
			'    	$view->render();'."\r\n".
		    '	}'."\r\n".
			'}'."\r\n".
			'?>	'."\r\n";

			$fHandle = file_put_contents($filename, $phrase); 
		}
		else
			$this->errorMessage = 'Das Anlegen der "standardController.php" schlug fehl !';		    

		/*
		 *  Routing over URL-Rewriting
		 */
		if($routing == '1'){

			$filename = $this->folder . '/.htaccess';

			$phrase = 'Options +FollowSymLinks'."\r\n".
					  'IndexIgnore */*'."\r\n".
					  'RewriteEngine On'."\r\n".
					  'RewriteCond %{REQUEST_FILENAME} !-f'."\r\n".
					  'RewriteCond %{REQUEST_FILENAME} !-d'."\r\n".
					  'RewriteRule ^(.*) index.php '."\r\n";

			$fHandle = file_put_contents($filename, $phrase); 
		
		/*
		 *  urlRules URL-Rewriting
		 */
		$filename = $this->folder . '/Configuration/urlRules.php';

		$rules = 
		'
		<?php'."\r\n".
		'/*                                                                        *'."\r\n".
		' * This script belongs to the FLOWLite framework.                         *'."\r\n".
		' *                                                                        *'."\r\n".
		' * It is free software; you can redistribute it and/or modify it under    *'."\r\n".
		' * the terms of the GNU Lesser General Public License as published by the *'."\r\n".
		' * Free Software Foundation, either version 3 of the License, or (at your *'."\r\n".
		' * option) any later version.                                             *'."\r\n".
		' *                                                                        *'."\r\n".
		' * This script is distributed in the hope that it will be useful, but     *'."\r\n".
		' * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *'."\r\n".
		' * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *'."\r\n".
		' * General Public License for more details.                               *'."\r\n".
		' *                                                                        *'."\r\n".
		' * You should have received a copy of the GNU Lesser General Public       *'."\r\n".
		' * License along with the script.                                         *'."\r\n".
		' * If not, see http://www.gnu.org/licenses/lgpl.html                      *'."\r\n".
		' *                                                                        */'."\r\n".
		''."\r\n".
		'class urlRules '."\r\n".
		'{'."\r\n".
		''."\r\n".
		'  public function rules()  {'."\r\n".
		''."\r\n".
		'   $rules = array( '."\r\n".
		'   			array('."\r\n".
		'    		  \'urlControllerInPath\' => \'last\', '."\r\n".
		'    		  \'extensions\'		  => array(\'htm\',\'html\'), '."\r\n".
		'		      )		      '."\r\n".
		'    );    '."\r\n".
		''."\r\n".
		'	return $rules;'."\r\n".
		'  }'."\r\n".
		''."\r\n".
		'}'."\r\n".
		'?>'."\r\n";

		$fHandle = file_put_contents($filename, $rules); 
		}
		
		/*
		 *  config.xml
		 *
		 *  Minimalanforderung
		 */
		$filename = $this->folder . '/Configuration/config.xml';
		
		$xmlFile = 
		'<?xml version="1.0" encoding="utf-8"?>'."\r\n".
		'<!-- '."\r\n".
		'; *                                                                        *'."\r\n".
		'; * This script belongs to the FLOWLite framework.                         *'."\r\n".
		'; *                                                                        *'."\r\n".
		'; * It is free software; you can redistribute it and/or modify it under    *'."\r\n".
		'; * the terms of the GNU Lesser General Public License as published by the *'."\r\n".
		'; * Free Software Foundation, either version 3 of the License, or (at your *'."\r\n".
		'; * option) any later version.                                             *'."\r\n".
		'; *                                                                        *'."\r\n".
		'; * This script is distributed in the hope that it will be useful, but     *'."\r\n".
		'; * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *'."\r\n".
		'; * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *'."\r\n".
		'; * General Public License for more details.                               *'."\r\n".
		'; *                                                                        *'."\r\n".
		'; * You should have received a copy of the GNU Lesser General Public       *'."\r\n".
		'; * License along with the script.                                         *'."\r\n".
		'; * If not, see http://www.gnu.org/licenses/lgpl.html                      *'."\r\n".
		'; *                                                                        */ '."\r\n".
		'-->'."\r\n".
		'<configuration id="application">'."\r\n".
		''."\r\n".
		'	<!-- APPLICATION -->'."\r\n".
		'	<standard id="Standard Apps">'."\r\n".
		'		<controller>standardController</controller>'."\r\n".		
		'		<action>index</action>		'."\r\n".
		'	</standard>'."\r\n".
		''."\r\n".
		'	<!-- ROUTER -->'."\r\n".
		'	<router id="Router">'."\r\n";

		if($routing == '1'){
			$xmlFile .= '		<routing>URL_REWRITE</routing>'."\r\n";
			$xmlFile .= '		<htaccess>true</htaccess>			'."\r\n";
		}
		else
		{
			$xmlFile .= '		<routing>none</routing>'."\r\n";
			$xmlFile .= '		<htaccess>false</htaccess>			'."\r\n";	 
		}

		$useCacheApp = ($useCache == 1) ? 'true' : 'false';
		$useORMApp   = ($useORM   == 1) ? 'true' : 'false';

		$xmlFile .=
		'	</router>	'."\r\n".
		''."\r\n".
		'	<!-- CACHE -->'."\r\n".
		'	<cache id="Cache">'."\r\n".
		'		<use>'.$useCacheApp.'</use>'."\r\n".
		'	</cache>'."\r\n".
		''."\r\n".
		'	<!-- DATABASE -->'."\r\n".
		'	<database id="Database">'."\r\n".
		'		<access>MYSQL</access>'."\r\n".
		'		<host>'.$INPUT_HOST.'</host>'."\r\n".
		'		<dbname>'.$INPUT_DB.'</dbname>		'."\r\n".
		'		<dbuser>'.$INPUT_USER.'</dbuser>		'."\r\n".
		'		<dbpass>'.$INPUT_PASS.'</dbpass>		'."\r\n".
		'	</database>'."\r\n".
		''."\r\n".
		'	<!-- ORM -->'."\r\n".
		'	<orm id="ORM">'."\r\n".
		'		<use>'.$useORMApp.'</use>'."\r\n".
		'	</orm>'."\r\n".
		''."\r\n".
		'</configuration>';		
		
		// Datei schreiben
		$fHandle = file_put_contents($filename, $xmlFile); 		
				
		}
	 	else
			$this->errorMessage = 'Keine Berechtigung zum Anlegen der Folder !';		    
			
		// getSet baseURL
		$this->request->setBaseUrl($this->request->getBaseUrl());

		// set baseURL to Placeholder
		$baseURL = '<base href="'.$this->request->getBaseUrlOfApp().'">';

		// set placeholder to view
		$view->assign('baseURL',$baseURL);

		$view->assign('INPUT-APPNAME','');	

		if(!empty($this->errorMessage))
		{
			$this->indexAction();
		}
		else
		{
			$RESULT = "Die Applikation '".$this->appName."' wurde angelegt !";
			$view->assign('RESULT',$RESULT);	

			$START_MENU = '<a href="/FLOWLite_1.0/Unity/Support/">Menue</a>';
			$view->assign('START_MENU',$START_MENU);	

			// Template (CSS3)
		    $view->setTemplate('result.htm');
	    	$view->render();			
		}	
   }   
}
?>