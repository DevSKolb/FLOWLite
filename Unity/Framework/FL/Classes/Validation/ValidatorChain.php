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
class ValidatorChain implements ValidatorInterface
{
	/*
	 * Validators
	 * 
	 * @access private
	 */
	private $validators  = array();

	/*
	 * Request object
	 * 
	 * @access private
	 */
	private $request     = null;
  
	/*
	 * @access public static
     * @param mixed autoloader
     * 
     * addFilter
   	 */ 
  	public function addValidator(ValidatorInterface $validator){
    	$this->validators[] = $validator;
  	}
  
  	/*
     * @access public static
     * @param mixed autoloader
     * 
     * execute
     */ 
	public function execute(Request $req){
    	foreach($this->validators as $validator){
        	if(is_callable(array($validator, 'execute'))){
           		$validator->execute($req);
	        }
    	    else
			 throw new Exception("Validator nicht ausführbar", 4001);
	    }
 	}	
}
?>