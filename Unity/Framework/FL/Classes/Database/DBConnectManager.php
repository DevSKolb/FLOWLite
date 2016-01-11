<?php
/*                                                                        *
 * This script belongs to the IRS3 framework.                             *
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
 * 
/**
 * Object relationales Mapping (ORM)
 * see 
 */   
final class DBConnectManager extends DBConfiguration
{
 
  /**
   * @private
   * 
   * DB Pointer
   */  
  private $DBPointer;
 
  /**
   * @public
   * 
   * object convert to array
   */    
  public function __construct() { 

      parent::__construct();   
  } 	
			
  /**
   * @public
   * @recursve
   *
   * array convert to object
   */  
  public function connectRouter() { 	 

    switch($this->DB_Access){

		// connect with MySQL
		case 'MYSQL' : 
		{ 
			$this->DBPointer = DB_MYSQL_Connect::ConnectDB($this->HostName,$this->DB_Name,$this->DB_User,$this->DB_Pass); 

  			return $this->DBPointer;							            	  
			break; 
		}
		// connect with SQLite database
		case 'SQLITE' : 
		{ 
			$this->DBPointer = DB_SQLITE_Connect::ConnectDB($this->DB_Name); 

  			return $this->DBPointer;							            	  
			break; 
		}
		// connect with SQLite2 database
		case 'SQLITE2' : 
		{ 
			$this->DBPointer = DB_SQLITE2_Connect::ConnectDB($this->DB_Name); 

  			return $this->DBPointer;							            	  
			break; 
		}
		// connect with MSSQL
		case 'MSSQL' : 
	    { 
			 $this->DBPointer = DB_MSSQL_Connect::ConnectDB(
			 						$this->HostName,$this->DB_Name,$this->DB_User,$this->DB_Pass,$this->DB_Port
									); 

	  		 return $this->DBPointer;							            	  
			 break; 
		}
       
       default      : { trigger_error("Database not connected", E_USER_ERROR);  break; }
    }
  }
  

  /**
   * @set db
   */
  public function setDB($host,$access,$dbname,$dbuser,$dbpass,$dbport){

		$this->HostName  = $host;     
	   	$this->DB_Access = $access;     
	   	$this->DB_Name   = $dbname; 
	   	$this->DB_User   = $dbuser;
	   	$this->DB_Pass   = $dbpass;
		$this->DB_Port   = $dbport;

		return $this;
  }

  /**
   * @back to db
   */
  public function switchToConfigDB(){

	   	$this->HostName  = $this->registry->databaseHost;     
	   	$this->DB_Access = $this->registry->databaseAccess;     
	   	$this->DB_Name   = $this->registry->databaseDbname;     
	   	$this->DB_User   = $this->registry->databaseDbuser;
	   	$this->DB_Pass   = $this->registry->databaseDbpass;
		$this->DB_Port   = $this->registry->databasePost;
		
		return $this;
  }	  
}
?>