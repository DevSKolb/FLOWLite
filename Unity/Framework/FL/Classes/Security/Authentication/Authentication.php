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
class Authentication {

	/**
	 * @var objectManger
	 */
	public  $objectManager;

	/**
	 * @var pointer of database
	 */
	private $DatabasePointer = null;

	/**
	 * @var checkParam
	 */
	private $checkParam = false;

	/**
	 * @var checkUP
	 * check (U)ser/(P)assword
	 */
	private $checkUP;
	
	/**
	 * @var first alphabethic
	 */
	private $firstAlphabeth;

	/**
	 * @var params
	 */
	public $dbAuthTable     = 'user';					/// @var dbTable
	public $dbFieldUsername = 'username';				/// @var dbFieldUsername
	public $dbFieldPassword = 'password';				/// @var dbFieldPassword
	public $dbFieldLogname  = 'username';				/// @var dbFieldName
	public $dbFieldActive   = 0;  	  					/// @var dbFieldActive
	public $dbDisplayName   = array();					/// @var dbDisplayName

	private $dbFields       = '';						/// @var fields for dbDisplayName

	private $adapter;

	private $displayName 	= array();
	private $dispName 		= '';

	/**
	 * The username/password credentials
	 * @var array
	 */
	public $credentials = array('username' => '', 'password' => '');	

	/**
	 * Constructor
	 */
	public function __construct(){   
		$this->start();
	}

	/**
	 * start point
	 */
	public function start() {

	    // Instance of ObjectManager
        $this->objectManager = ObjectManager::getInstance();
		      
		// Connect Database 
	    $this->DatabasePointer = $this->objectManager->getObject('DBConnectManager')->connectRouter();

		return $this;
	}

	/**
	 * authenticate user/password
	 * 
	 */
	public function authenticate() 
	{ 
		// Wurden Parameter gesetzt ?
		if(!$this->checkParam) return false;
	
		// Aufnahme der Datenparameter
		$user = $this->credentials['username'];
		$pass = $this->credentials['password'];

		// Erster Buchstabe des Users
		if(is_string($user) && !empty($user)){
			$this->firstAlphabeth = substr($user,0,1);
		}	

		// Felder für DisplayName
		foreach($this->adapter['dbDisplayName'] as $item)
		{
#			if(isset($item)){
				$this->dbFields .= ','.$item;
#			}	
		} 

		/*
		 * Authenticate
		 * SQL Statement for prepare
		 */
	   	$strPrepare = "SELECT ".$this->dbFieldUsername
		                       .','
							   .$this->dbFieldPassword
							   .' '	  
							   .$this->dbFields
							   .', '	  
							   .$this->dbFieldActive
							   ."
			     	   FROM   ".$this->dbAuthTable."
		         	   WHERE 
					   SUBSTRING(".$this->dbFieldLogname.",1,1) = '".$this->firstAlphabeth."'					  
		";

		/*
		 * SQL Query
		 */
	    $stmt = $this->DatabasePointer->query($strPrepare);
	
		/*
		 * SQL fetchAll and Object 
		 */
    	$obj = $stmt->fetchAll(PDO::FETCH_OBJ);
    	
		/*
		 * INIT false
		 */
		$this->checkUP = false;

		/*
		 * User untersuchen
		 */
    	foreach($obj as $entry){

		    // Vergleich möglich ?
			if(!empty($entry->{$this->dbFieldUsername}) 
			&& !empty($entry->{$this->dbFieldPassword})
			){			  
			  // Authenticate ?	
			  if($entry->{$this->dbFieldUsername} == $this->credentials['username']
			  && $entry->{$this->dbFieldPassword} == $this->credentials['password']
			  && $entry->{$this->dbFieldActive}   == 1
			  )
			  {		  
					// authentication is OK
					$this->checkUP = true;

					// DisplayName
					foreach($this->adapter['dbDisplayName'] as $item)
					{
						if(isset($entry->{$item})){
							$this->displayName[] = $entry->{$item};
						}	
					} 
		      }	  
			}    	  
    	}
		return $this->checkUP; 
    } 

	/**
	 * show data
	 */
	public function showAuthData() { 

		return $this->adapter;
	}

	/**
	 * show display name
	 */
	public function showDisplayName() { 

		return $this->displayName;
	}

	/**
	 * show data
	 */
	public function showAuthID() { 

		return $this->r;
	}

	/**
	 * display name width delimiter
	 */
	public function getDisplayName($delimiter) { 

		// Felder für DisplayName
		foreach($this->displayName as $item)
		{
	 
			if(isset($item)){
				if(empty($this->dispName)){				 
					$this->dispName .= $item;
				}
				else
					$this->dispName .= $delimiter.$item;
			}	
		} 

		return $this->dispName;
	}

	/**
	 * show data
	 */
	public function setAuthData($adapter)
	{ 					
		// Aufnahme Parameter
		$this->dbAuthTable   	= $adapter['dbAuthTable'];
		$this->dbFieldUsername	= $adapter['dbFieldUsername'];
		$this->dbFieldPassword	= $adapter['dbFieldPassword'];
		$this->dbFieldLogname	= $adapter['dbFieldAlphabetic'];
		$this->dbDisplayName	= $adapter['dbDisplayName'];
		$this->dbFieldActive	= $adapter['dbFieldActive'];
		
		// Password mit MD5 Hash Algorithmus
		$adapter[$this->dbFieldPassword] = ($adapter['md5']) 
										 ? md5($adapter[$this->dbFieldPassword]) 
										 :     $adapter[$this->dbFieldPassword];
		// Credentials
		$this->credentials['username'] = $adapter[$this->dbFieldUsername];
		$this->credentials['password'] = $adapter[$this->dbFieldPassword];

		// Adapter
		$this->adapter = $adapter;

		// set param
		$this->checkParam = true;
	}
}
?> 
