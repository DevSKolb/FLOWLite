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
abstract class System {

	/**
	 * Environment object
	 * @var object
	 */
	public $objectManager;

	/**
	 * Environment object
	 * @var object
	 */
	public $registry;

	/**
	 * Environment object
	 * @var object
	 */
	public $flrp;

	/**
	 * Environment object
	 * @var object
	 */
	public $debug;

	/**
	 * Database object
	 * @var object
	 */
	protected $database;

	/**
	 * Initialize
	 */
    public function __construct (){
      
		// ObjectManager
      	$this->objectManager = ObjectManager::getInstance();

		// Registry
    	$this->registry = $this->objectManager->getObject('Registry');

		// FLRP protocol
		$this->flrp = $this->objectManager->getObject('flrp');
	} 
}
?>