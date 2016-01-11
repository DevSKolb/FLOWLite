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
class Registry
{
  /**
   * @var array $data
   * @access protected
   * 
   * Hier werden die Daten abgelegt.
   * Kann nur über __get, __set und __unset manipuliert werden            
   */     
  protected $___data;
   
  /**
   * @access public
   * @param string $key
   * @param mixed  $value
   * @return Registry Fluent interface
   *    
   * Einen neuen Wert der Registry hinzufügen           
   */     
  public function __set($key, $value)
  {
    $this->___data[$key] = $value;

    return $this;
  }
  
  /**
   * @access public
   * @param string $key
   * @return mixed|null
   * 
   * Einen Wert aus der Registry anhand von $key lesen
   * Liefert null, wenn der Wert nicht existiert               
   */     
  public function __get($key){
    return (isset($this->___data[$key])) ? $this->___data[$key] : null;

  }
  
  /**
   * @access public
   * @param string key
   * @return bool
   * 
   * Prüft, ob ein $key vorhanden ist            
   */     
  public function __isset($key) {
    return isset($this->___data[$key]);
  }
  
  /**
   * @access public
   * @param string key
   * @return Registry Fluent interface
   *     
   * Einen Wert aus der Registry löschen         
   */     
  public function __unset($key)
  {
    unset($this->___data[$key]);
    return $this;
  }
}
?>