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
class Database
{
	/**
	 * @var objectManger
	 */
	  private $objectManager;

	/**
	 * @var DatabasePointer
	 */
  	  private $DatabasePointer;
  
	/**
	 * @var Fields of Table
	 */
	  private $fields = array();

	/**
	 * @var Result data
	 */
	  public $dataResult = array();
	  
	  private $resResult;
#	  private $strQuery;
	  private $intIndex = -1;
	  private $intRowSum = -1;

	/**
	 * End indicator
	 * @var boolean
	 */
	private $blnDone = false;

    /**
	 * Initializes database table object 
	 * params
	 * :: Table :: Name of Database Table
	 * :: Fields:: Array with Fields from Table
	 *
	 * @return void
	 */
	public function __construct( )
  	{
	    return $this;
	}

    /**
	 * Magic function GET
	 *
	 * @return void
	 */
	public function connect() {    

	    // Instance of ObjectManager
        $this->objectManager = ObjectManager::getInstance();
		      
		// Connect Database 
	    $this->DatabasePointer = $this->objectManager->getObject('DBConnectManager')->connectRouter();
	    
	    return $this;
	}

    /**
	 * Magic function GET
	 *
	 * @return void
	 */
	public function __get( $key ) {    
		if(isset($this->fields[ $key ]))
			return $this->fields[ $key ];
		else	
			die('Field "'.$key.'" not found!');
	}

    /**
	 * Magic function SET
	 *
	 * @return void
	 */ 
	public function __set( $key, $value )  {
    	if ( array_key_exists( $key, $this->fields ) ) 	{
      		$this->fields[ $key ] = $value;
		    return true;
    	}
    	return false;
  	}
	/**
	 * Prepare a statement (return a Database_Statement object)
	 * @param  string
	 * @return object
	 *
	 * ~ PDO::Statement is $this->resResult
	 */
	public function prepare($strQuery)
	{
		$this->resResult = $this->DatabasePointer->prepare( $strQuery );    

		return $this;
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return object
	 */
	public function execute()
	{
		try {
		    $this->resResult->execute();   
		
			$this->dataResult = $this->resResult->fetchAll(PDO::FETCH_ASSOC);

			$this->intIndex = -1;

		} catch (Exception $e) {
	    	echo 'Exception: ',  $e->getMessage(), "\n";
		}

		return $this;
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return object
	 */
	public function executeOnly()
	{
		try {
		    $this->resResult->execute();   

		} catch (Exception $e) {
	    	echo 'Exception: ',  $e->getMessage(), "\n";
		}
		
		return $this;
	}


	/**
	 * error code (return a code)
	 * @param  string
	 * @return error code
	 */
	public function errorCode()
	{
	    return $this->resResult->errorCode();   
	}

	/**
	 * last insert ID from database pointer
	 *
	 * @return last id 
	 */
	public function lastInsertId()
	{
	    return $this->DatabasePointer->lastInsertId();   
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return object
	 */
	public function getRow()
	{
		return $this->dataResult;
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return object
	 */
	private function fillAnyKeys()
	{	
		if(is_array($this->dataResult) && count($this->dataResult)>0){
	        foreach( array_keys( $this->dataResult[$this->intIndex] ) as $key ){
				if(is_null($this->dataResult[$this->intIndex][ $key ])){
					$this->fields[ $key ] = 'NULL';
				} else
					$this->fields[ $key ] = $this->dataResult[$this->intIndex][ $key ];
				}
		}		
	}			

	/**
	 * Reading information of field meta data
	 * @param  index of col
	 * @return array
	 *
	 * ~ PDO::Statement::getColumnMeta
	 */
	public function getColumnMeta($colIndex)
	{
	 	$fieldMetaData = $this->resResult->getColumnMeta($colIndex);

		return $fieldMetaData;
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return intRowSum
	 */
	public function sumDataRow()
	{
	 	$intRowSum = count($this->dataResult) -1;

		return $intRowSum;
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return countIntRowSum
	 */
	public function countData()
	{
	 	$countIntRowSum = count($this->dataResult);

		return $countIntRowSum;
	}

	/**
	 * Go to the first row of the current result (reset)
	 * @return object
	 */
	public function seekFirstRow()
	{
		$this->intIndex = -1;

		return $this;
	}
		
	/**
	 * Go to the first row of the current result
	 * @return object
	 */
	public function first()
	{
		$this->intIndex = 0;

		$this->fillAnyKeys();

		return $this;
	}

	/**
	 * Go to the first row of the current result
	 * @return object
	 */
	public function last()
	{
		$this->intIndex = $this->sumDataRow();

		$this->fillAnyKeys();

		return $this;
	}
	
	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return object
	 */
	public function next()
	{		
		if ($this->intIndex < $this->sumDataRow())
		{
			++$this->intIndex;

	        $this->fillAnyKeys();
        
			return $this;
		}
		return false;
	}

	/**
	 * Execute a query (return a Database_Result object)
	 * @param  string
	 * @return object
	 */
	public function prev()
	{		
		if ($this->intIndex > 0)
		{
			--$this->intIndex;

	        $this->fillAnyKeys();
        
			return $this;
		}
		return false;
	}

	/**
	 * Begin a transaction
	 */
	public function beginOfTransaction()
	{
		$this->DatabasePointer->beginTransaction();
	}


	/**
	 * Commit a transaction
	 */
	public function commitTransaction()
	{
		$this->DatabasePointer->commit();
	}


	/**
	 * Rollback a transaction
	 */
	public function rollbackTransaction()
	{
		$this->DatabasePointer->rollBack();
	}	
}
?>