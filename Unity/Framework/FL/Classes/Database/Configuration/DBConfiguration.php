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
 * 
/**
 * DB_ 
 * Main class 
 */ 
class DBConfiguration extends System
{
	/**
	 * @private
	 * 
	 * Access
	 */
	public $DB_Access;

	/**
	 * @private
	 * 
	 * HOST
	 */
	public $HostName;

	/**
	 * @private
	 * 
	 * Port
	 */
	public $DB_Port;

	/**
	 * @private
	 * 
	 * DB Name
	 */
	public $DB_Name;

	/**
	 * @private
	 * 
	 * User db
	 */
	public $DB_User;

	/**
	 * @private
	 * 
	 * password db
	 */
	public $DB_Pass;

	/**
	 * @construct
	 */
    public function __construct(){

		parent::__construct();
		 
	   	$this->HostName  = $this->registry->databaseHost;     
	   	$this->DB_Access = $this->registry->databaseAccess;     
	   	$this->DB_Name   = $this->registry->databaseDbname;     
	   	$this->DB_User   = $this->registry->databaseDbuser;
	   	$this->DB_Pass   = $this->registry->databaseDbpass;
		$this->DB_Port   = $this->registry->databaseDbport;
	}
}
?>