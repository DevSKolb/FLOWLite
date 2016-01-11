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
 * Validator for not empty values
 *
 */
class StringLenghtValidator  {

	/**
	 * Checks if the given property ($propertyValue) is not empty (NULL or empty string).
	 */
	public function isValid($value,$lenght) {

		if(strlen($value) <> $lenght){
		   trigger_error('Lenght is '.strlen($value).', not '.$lenght, E_USER_ERROR);
		   }

   		return TRUE;
	}
}

?>