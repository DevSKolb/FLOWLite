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
class Acl
{
    /**
     * roles
     *
     * @access protected
     */
	protected $roles = array();
  
    /**
     * resources
     *
     * @access protected
     */
	protected $resources = array();
  
    /**
     * rules
     *
     * @access protected
     */
	protected $rules = array();
  
    /**
     * addRole
     */
	public function addRole($role, array $parents = null)
    {    
	    // Name of Role (Instance)
		$roleName = $role->getRoleName();   

		// Eltern
		$parentArray = array();
		
	    // Role aufnehmen
		$this->roles[$roleName] = array
     	                          (
            	                     "instance" => $role,      	 //Instance of Role
                	                 "parents"  => $parentArray, //Array if Inherit
        	                         "children" => array()    	 //No Children
                    	           );       
	    return $this;
	}
	
  /**
   *  @access protected
   *  @return Acl_Role instanz
   *  @param string $name
   */  
	protected function getRoleByName($name)
	{
    	return $this->roles[$name]["instance"];
	}	
	
  /**
   * @access public
   * @return instanz der Klasse
   * @param string $role
   */ 
	public function removeRole($role)
	{
    	$role = (string)strtolower($role);
    
	    unset($this->roles[$role]);
    	
		return $this;
    }

  /**
   * @access public
   * @return bool
   * @param string $role      
   * 
   * Prüft, ob eine Rolle existiert      
   */     
	protected function roleExists($role)
	{
    	$role = (string)strtolower($role);

	    return isset($this->roles[$role]);
	}	
	
	
}
?>