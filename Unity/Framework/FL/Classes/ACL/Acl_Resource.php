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
class Acl_Resource
{
  /**
   * @access protected
   * @var string $resource_name
   * 
   * Der Name der Ressource         
   */
  protected $resource_name;
  
  /**
   * @access public
   * @param string $resource_name
   * 
   * Legt den Ressourcennamen fest         
   */ 
  public function __construct($resource_name)
  {
    $this->resource_name = (string) $resource_name;
  }
  
  /**
   * @access public
   * @return string
   * 
   * Gibt den Ressourcennamen zurück         
   */ 
  public function getResourceName()
  {
    return $this->resource_name;
  }
}
?>