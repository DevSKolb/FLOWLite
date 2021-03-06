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
/**
 * Validator for 32 hash
 */
class Hash32Validator {

	/**
	 * validate a 32 byte hash
	 *
	 * @param string $session_id String to validate
	 * @return boolean
	 *
	 */
	public function isValid($value) {
	 
		if(!empty($value) && preg_match('/^[a-zA-Z0-9]{32}$/', $value)) return true; 
		
#		trigger_error('The given subject was not a valid hash. Got: "' . $value . '"', E_USER_NOTICE );
		return FALSE;
	}
}

?>