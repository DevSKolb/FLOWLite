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
class FLOWLiteException extends Exception 
{
	/**
     * throw new exeption
     * exeption go to logger
     */
	public static function getStaticException($exception)
    {
		/**
	     * get error message
	     */
    	$ErrorMessage = $exception->getMessage();
		/**
	     * get error number
	     */
       	$ErrorNumber  = $exception->getCode();
		/**
	     * get error file (in source)
	     */
       	$ErrorFile    = $exception->getFile();
		/**
	     * get error line (in source)
	     */
       	$ErrorLine    = $exception->getLine();

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