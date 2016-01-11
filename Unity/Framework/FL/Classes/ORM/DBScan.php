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
class DBScan extends System
{
	/**
	 * @var DatabasePointer
	 */
  	  private $DatabasePointer;
  
	/**
	 * @var Record-ID
	 */
	  private $id = 0;

	/**
	 * @var Name of Datenbase Table
	 */
	  private $table;

	/**
	 * @var Fields of Table
	 */
	  private $fields = array();

    /**
	 * Initializes database table object 
	 * params
	 * :: Table :: Name of Database Table
	 * :: Fields:: Array with Fields from Table
	 *
	 * @return void
	 */
	 
	/**
	 * private
	 * database name
	 */
	private $DBNAME;
	
	/**
	 * private
	 * host name
	 */
	private $HostName;

	/**
	 * private
	 * access
	 */
	private $DB_Access;

	/**
	 * private
	 * database name
	 */
	private $DB_Name;
	
	/**
	 * private
	 * user name
	 */
	private $DB_User;

	/**
	 * private
	 * password
	 */
	private $DB_Pass;

	/**
	 * private
	 * sub folder
	 */
	private $ORM_Folder = '';

	/**
	 * private
	 * db prefix
	 */
	private $ORM_Prefix = '';

	/**
	 * public
	 *
	 * fields of a table
	 */
	public function fields($tabname){
   
   		$strPrepare = str_replace('{{ins-table}}',$tabname,$this->ShowColumns);
   
    	$res = $this->DatabasePointer->prepare( $strPrepare );    
    	$res->execute();
		   
		$result = $res->fetchAll(PDO::FETCH_COLUMN,0);

	    return $result;
  	}

	/**
	 * public
	 *
	 * tables of database
	 */
	public function tables(){
  
   		if(!empty($this->DB_Name) && is_string($this->DB_Name)){
     
	   		$strPrepare = str_replace('{{ins-database}}',$this->DB_Name,$this->ShowTables);
   
   		 	$res = $this->DatabasePointer->prepare( $strPrepare );    

	    	$res->execute();
    
			$tablesOfDB = $res->fetchAll(PDO::FETCH_COLUMN);
	
			return $tablesOfDB;      
    	} 
		else
			trigger_error("Could not found database");
  	}
 
	/**
	 * private
	 *
	 * create table class
	 */
	private function TableToObject($table,$fields){
  
  	  foreach(array_keys($fields) as $key){
   		    $sets []= "'".$fields[ $key ]."'";
	    }
    	$set = join( ", ", $sets );

	    $strObj  = '';
	    $strObj .= "<?php";
	    $strObj .= "\n";
		$strObj .= 'class '. $this->ORM_Prefix . $table .' extends DBObject';
	    $strObj .= "\n";
	    $strObj .= '{';
	    $strObj .= "\n";
	    $strObj .= 'function __construct(){';
	    $strObj .= "\n";  
	    $strObj .= '     parent::__construct(\''.$table.'\',array('.$set.'));';
	    $strObj .= "\n";
	    $strObj .= '}';
	    $strObj .= "\n";
	    $strObj .= '}';
	    $strObj .= "\n";
	    $strObj .= '?>';

	    return $strObj;
	}

	/**
	 * public
	 *
	 * scaning a database
	 */
	public function scan(){

	   	$this->HostName   = $this->registry->databaseHost;     
	   	$this->DB_Access  = $this->registry->databaseAccess;     
	   	$this->DB_Name    = $this->registry->databaseDbname;     
	   	$this->DB_User    = $this->registry->databaseDbuser;
	   	$this->DB_Pass    = $this->registry->databaseDbpass;
		$this->DB_Port    = $this->registry->databasePost;
		$this->ORM_Folder = $this->registry->ormfolder;
		$this->ORM_Prefix = $this->registry->ormprefix;
		
	// Database pointer from connect
    $this->DatabasePointer = $this->objectManager->getObject('DBConnectManager')->connectRouter();  

	// all tables from database
    $TablesOfDatabase = $this->tables();	      
   
	// create external class for tables of database
	foreach(array_keys($TablesOfDatabase) as $key){
	
 		$FieldsOfTable = $this->fields($TablesOfDatabase[ $key ]);

		$data = '';
		$data = $this->TableToObject($TablesOfDatabase[ $key ],$FieldsOfTable );
    
		/* Filename */
#		$filename = FL_PATH_ORM . '/' .$TablesOfDatabase[ $key ].'.php'; 

		// Path to ORM
		$ormPath = FL_PATH_ORM . '/';  
		
		// sub folder for orm tables
		if(!empty($this->ORM_Folder)) 
		{
			$ormPath .= $this->ORM_Folder . '/'; 
		}
		
		// prefix and name of table
		$filename = $ormPath . $this->ORM_Prefix . $TablesOfDatabase[ $key ].'.php'; 

		/* is not path writable, chmod 0777 */
#		if(!is_writable($filename)){
#			chmod ($filename, 0666);	
#  	    }
  	    
		/* file open */
		$handler = fOpen($filename , "w+");

		/* file write */
		fWrite($handler , $data);

		/* file close */
		fClose($handler); 
		
#		}
#	else trigger_error($filename.' not writable',2342);
	}
  } 
}
?>