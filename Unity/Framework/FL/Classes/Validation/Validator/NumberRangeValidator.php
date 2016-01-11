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
class NumberRangeValidator  {

	/**
	 * check range
	 */
	public function isValid($value,$min,$max) {

		if (!is_numeric($value)) {
		  trigger_error('Value s not numeric !', E_USER_ERROR); 
		  return false; 
		}

		$minimum = (isset($min)) ? intval($min) : 0;
		$maximum = (isset($max)) ? intval($max) : PHP_INT_MAX;

		if ($minimum > $maximum) {
			$x = $minimum;
			$minimum = $maximum;
			$maximum = $x;
		}

		if ($value >= $minimum && $value <= $maximum) return TRUE;

		trigger_error('The given subject was not in the valid range (' . $minimum . ' - ' . $maximum . '). Got: "' . $value . '"', E_USER_ERROR);
	
		return FALSE;
	}
}

?>