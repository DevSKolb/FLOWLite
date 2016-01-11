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
 * Validator for alphanumeric strings
 */
class AlphanumericValidator {

	/**
	 * Returns TRUE, if the given property ($propertyValue) is a valid
	 * alphanumeric string, which is defined as [a-zA-Z0-9]*.
	 *
	 */
	public function isValid($value) {

		if (is_string($value) && preg_match('/^[a-z0-9]*$/i', $value)) return TRUE;
	
		trigger_error('The given subject was not a valid alphanumeric string. Got: "' . $value . '"', 1221551320);
		return FALSE;
	}
}

?>