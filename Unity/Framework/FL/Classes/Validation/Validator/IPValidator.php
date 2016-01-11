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
 * Validator for ip address
 */
class IPValidator {

	/**
	 * Returns TRUE, if the given property ($Value) is a valid
	 *
	 */
	public function isValid($value, $filter=false) {

		if(empty($value)) return false;
	
		if( ! $filter){
			return (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $value)) ? true : false;
		}
		else
		if($filter)
		{
			switch($filter)
			{
			case 'IP':  	{return (filter_var($value, FILTER_VALIDATE_IP)) ? true : false; }
			case 'IPRR':    {return (filter_var($value, FILTER_VALIDATE_IP | FILTER_FLAG_NO_RES_RANGE)) ? true : false; }
			case 'IPPR':    {return (filter_var($value, FILTER_VALIDATE_IP | FILTER_FLAG_NO_PRIV_RANGE)) ? true : false; }
			case 'IPRRPR':  {return (filter_var($value, FILTER_VALIDATE_IP | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE)) ? true : false; }
			
			case 'IPv4':  	{return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) ? true : false; }
			case 'IPv4RR':  {return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE)) ? true : false; }
			case 'IPv4PR':  {return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) ? true : false; }
			case 'IPv4RRPR':{return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE)) ? true : false; }
			case 'IPv6':    {return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? true : false; }			 	 
			case 'IPv6RR':  {return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE)) ? true : false; }
			case 'IPv6PR':  {return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE)) ? true : false; }
			case 'IPv6RRPR':{return (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE)) ? true : false; }
			
			default:  	    {return (filter_var($value, FILTER_VALIDATE_IP)) ? true : false; }
			} 
		} 
		trigger_error('The given subject was not a valid IP address. Got: "' . $value . '"', 1221551328);
		return FALSE;
	}
}
?>