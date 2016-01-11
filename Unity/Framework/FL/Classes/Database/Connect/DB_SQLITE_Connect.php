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
class DB_SQLITE_Connect
{
    /**
	 * DBPointer
	 *
	 * @return instance of database
	 */  
     private static $DBPointer;
  
    /**
	 * connect MYSQL database
	 *
	 * @return void
	 */  
     public static function ConnectDB($dbname){

    	try 
		{   
		  // Database Pointer for MySQL params
	      $DBPointer = new PDO('sqlite:'.$dbname);
	      
		  // set attribute ERRMODE and EXCEPTION
          $DBPointer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // return database pointer, if ok
       	  return $DBPointer;
  	    }
  	    // Exception handling
	   	catch(PDOException $e) 
		{ 
			echo $e->getMessage();
			exit;
        }      
     }

  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen  
}
?>