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
		$view->assign('APPS-TITLE','FLOWLite - System disgnostic');		

		
		$SYSTEM_TABLE  = '<table class="tabinfo" style="margin:0;width: 600px; border:0px solid #78C0FF;">';

		// Parameter
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#ccc">';
		$SYSTEM_TABLE .= 'Parameter';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#ccc">';
		$SYSTEM_TABLE .= 'Value';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// PHP Version
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'PHP Version';
		$SYSTEM_TABLE .= '</td>';
		if(version_compare(PHP_VERSION, '5.2.0', '>=')) {
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		}	
		else
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#FF9999">';

		$SYSTEM_TABLE .= phpversion();
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// System
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'System';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= php_uname() . PHP_OS;
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// Browser
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Browser Client';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['HTTP_USER_AGENT'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';


		// Document Root
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Document Root';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['DOCUMENT_ROOT'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// Servername
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Servername';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['SERVER_NAME'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// Serversoftware
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Serversoftware';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['SERVER_SOFTWARE'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// Gateway-Interface
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Gateway-Interface';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['GATEWAY_INTERFACE'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// Serverprotokoll
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Serverprotokoll';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['SERVER_PROTOCOL'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// Serverport
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Serverport';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		$SYSTEM_TABLE .= $_SERVER['SERVER_PORT'];
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';



		$SYSTEM_TABLE .= '</table><br>';


		$SYSTEM_TABLE .= '<table class="tabinfo" style="width: 600px; border:0px solid #78C0FF;">';

		// Parameter
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#ccc">';
		$SYSTEM_TABLE .= 'File Permissions';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '<td style="width:400px;background-color:#ccc">';
		$SYSTEM_TABLE .= 'Value';
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';


		// File Perm to /FLOWLite / Application / ORM
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'ORM ';
		$SYSTEM_TABLE .= '</td>';
		
		$filePerm = -1;
		$filePerm = substr(sprintf('%o', fileperms( $_SERVER['DOCUMENT_ROOT'] .'/'. 'FLOWLite_1.0/Unity/Application/ORM')), -4);
		
		if($filePerm == '0777'){		
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		}else	
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#FF9999">';
	
		$SYSTEM_TABLE .= $filePerm;			
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';


		// File Perm to /FLOWLite / Application / ORM
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Error log ';
		$SYSTEM_TABLE .= '</td>';
		
		$filePerm = -1;
		$filePerm = substr(sprintf('%o', fileperms( $_SERVER['DOCUMENT_ROOT'] .'/'. 'FLOWLite_1.0/Unity/Framework/Logs/error.log')), -4);
		
		if($filePerm == '0777'){		
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		}else	
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#FF9999">';
	
		$SYSTEM_TABLE .= $filePerm;			
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';

		// File Perm to /FLOWLite / Application / ORM
		$SYSTEM_TABLE .= '<tr>';
		$SYSTEM_TABLE .= '<td style="width:200px;background-color:#D4EFFD">';
		$SYSTEM_TABLE .= 'Security log ';
		$SYSTEM_TABLE .= '</td>';
		
		$filePerm = -1;
		$filePerm = substr(sprintf('%o', fileperms( $_SERVER['DOCUMENT_ROOT'] .'/'. 'FLOWLite_1.0/Unity/Framework/Logs/security.log')), -4);
		
		if($filePerm == '0777'){		
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#E1F2DC">';
		}else	
			$SYSTEM_TABLE .= '<td style="width:400px;background-color:#FF9999">';
	
		$SYSTEM_TABLE .= $filePerm;			
		$SYSTEM_TABLE .= '</td>';
		$SYSTEM_TABLE .= '</tr>';


		$SYSTEM_TABLE .= '</table><br>';



		// system table
		$view->assign('SYSTEM_TABLE',$SYSTEM_TABLE);

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


}
?>