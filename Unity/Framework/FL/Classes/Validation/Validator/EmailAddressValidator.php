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
 * Validator for email addresses
 */
class EmailAddressValidator {

    /*
	 * (from http://ex-parrot.com/~pdw/Mail-RFC822-Address.html)
	 */
	public function isValid($value) {

		if(is_string($value) && preg_match('
				/
					[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*
					@
					(?:
						(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|aero|asia|biz|cat|com|edu|coop|gov|info|int|invalid|jobs|localdomain|mil|mobi|museum|name|net|org|pro|tel|travel)|
						localhost|
						(?:(?:\d{1,2}|1\d{1,2}|2[0-5][0-5])\.){3}(?:(?:\d{1,2}|1\d{1,2}|2[0-5][0-5]))
					)
					\b
				/ix', $value)) return TRUE;
				
	#	trigger_error('The given subject was not a valid email address. Got: "' . $value . '"', 1221559976);
		return FALSE;
	}
}

?>