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
class MemoryHelper
{  
    /**
     * @public
     * @recursve
     *
     * get free memory space
     */  
	public static function getFreeMem( ) {
   
		if (function_exists('memory_get_usage')){
			if ($memory_usage = memory_get_usage()) {
			    $unit=array('b','kb','mb','gb','tb','pb');    

			return @round($memory_usage/pow(1024,($i=floor(log($memory_usage,1024)))),2).' '.$unit[$i];
			}
		}
	}

    /**
     * @public
     * @recursve
     *
     * get free memory space
     */  
	public static function getSizeFormat( $MemSize ) {
   
			if($MemSize == 0) return false;

		    $unit=array('b','kb','mb','gb','tb','pb');    

			return @round($MemSize/pow(1024,($i=floor(log($MemSize,1024)))),2).' '.$unit[$i];
	}
}
?>