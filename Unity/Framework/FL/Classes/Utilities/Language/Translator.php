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
final class Translator extends System
{  	
	/*
	 * @access object request
	 */
	private $request;

	/*
	 * path to language phrase
	 */
	private $pathToLanguagePhrase;
	
	/*
	 * Name of unity
	 */
	private $reqUNITY;

	/*
	 * Name of Screen
	 */
	private $reqSCREEN;	
	
	/*
	 * get laguage path and file 
	 */   
	public function getTranslationRoute($lang,$unity=false) {

		// request object
		$this->request = $this->objectManager->getObject('Request');

		// document root path
		$this->pathToLanguagePhrase = $_SERVER["DOCUMENT_ROOT"];

		// unity screen design ?
		if( $unity )
		{
			/* 
			 * unity && screen from flowlite router protocol (flrp)
			 */		 
			$this->reqUNITY  = $this->flrp->getUnity();
			$this->reqSCREEN = $this->flrp->getScreen();

			// set language path
			$this->pathToLanguagePhrase .=  dirname($this->request->getScriptUrl()) 
			                               .'/Unity/' 
										   . $this->reqUNITY 
										   . '/Language/' 
										   . $lang 
										   . '/';	 

			// set filename (language && screennumber)										   
			$this->pathToLanguagePhrase .=  $lang 
			                                .'_'
											. $this->reqSCREEN
											. '.php';

		} 
		else
		{
			// path to language folder && file
			$this->pathToLanguagePhrase .= dirname($this->request->getScriptUrl()) .'/Language/' . $lang . '/';	 
			$this->pathToLanguagePhrase .= $lang . '.php';
		}
	}

	/**
	 * reading language phrase
 	 * 
 	 * @param $lang 	Language
 	 * @param $unity 	Unity Concept 
	 */   
	public function getPhrase($lang,$unity = false) {

		/*
	 	 * Routing to language file 
		 */   
		$this->getTranslationRoute($lang,$unity);
		
		/*
	 	 * reading language phrase, if language file exists 
		 */   
		if(file_exists($this->pathToLanguagePhrase))
		{
			require( $this->pathToLanguagePhrase );

			return $phrase;
		}
		return false;
	} 
} 
?>