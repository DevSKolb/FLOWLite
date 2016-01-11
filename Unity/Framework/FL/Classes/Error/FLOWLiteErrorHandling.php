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
class FLOWLiteErrorHandling
{  
	/**
     * @public function

     * ErrorHandling for trigger_error
     *
     */
	public static function ErrorHandling($ErrorNumber, $ErrorMessage, $ErrorFile, $ErrorLine){

		/**
	     * object instance of objectManager
	     */
		$objectManager = ObjectManager::getInstance();
 
		/**
	     * Logger instance 
	     */
		$Logger = $objectManager->getObject('Logger');
      
	    /**
	     * LogError to Logger
	     */
		$Logger->LogError($ErrorNumber, $ErrorMessage, $ErrorFile, $ErrorLine);
    }
}
?>