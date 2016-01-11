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
class ArrayHelper
{ 
	/**
     * @public
     * @recursve
     *
     * array convert to object
     */  
	public static function array2Object( $array ) {      
   
   		$object = new stdClass();   
	   
 	    foreach( $array as $key => $value ) {              
	    	if( is_array( $value ) ) {              
	        	$object->$key = $this->array2Object( $value );          
        }  
        else {         
            $object->$key = $value;          
        }      
    	} 
    	return $object; 
  	}

	/**
     * @public
     * @recursve
     *
     * convert object to array
     */  
	public static function object2Array( $obj ) {      
   
	    $_arr = is_object($obj) ? get_object_vars($obj) : $obj; 
	    $arr  = array();
	
	    foreach ($_arr as $key => $val) { 
	        $val = (is_array($val) || is_object($val)) ? object2array($val) : $val; 
	        $arr[$key] = $val; 
    	} 
	    return $arr;     
  	}
	/**
     * @public
     * @recursve
     *
     * array convert to object
     */  
	public static function in_multiarray($elem, $array) 
    { 
        // if the $array is an array or is an object 
         if( is_array( $array ) || is_object( $array ) ) 
         { 
             // if $elem is in $array object 
             if( is_object( $array ) ) 
             { 
                 $temp_array = get_object_vars( $array ); 
                 if( in_array( $elem, $temp_array ) ) 
                     return TRUE; 
             } 
             
             // if $elem is in $array return true 
             if( is_array( $array ) && in_array( $elem, $array ) ) 
                 return TRUE; 
                 
             
             // if $elem isn't in $array, then check foreach element 
             foreach( $array as $array_element ) 
             { 
                 // if $array_element is an array or is an object call the in_multiarray function to this element 
                 // if in_multiarray returns TRUE, than return is in array, else check next element 
                 if( ( is_array( $array_element ) || is_object( $array_element ) ) && self::in_multiarray( $elem, $array_element ) ) 
                 { 
                     return TRUE; 
                     exit; 
                 } 
             } 
         } 
         
         // if isn't in array return FALSE 
         return FALSE; 
    }
    
	/**
     * @public
     * @recursve
     *
     * array convert to object
     */  
	public static function hasEntries($array) {
	    if(is_array($array)){ 
			return ( count($array) > 0 ) ? true : false;
		}
		else return false;	
	}    
	
	
	/**
     * @public
     * string to array
     */  
	public static function strToArray($data){

		if ( ! is_array($data))
		{
			if (strpos($data, ',') !== FALSE){
				$data = preg_split('/[\s,]/', $data, -1, PREG_SPLIT_NO_EMPTY);
			}
			else 
			{
				$data = trim($data);
				settype($data, "array");
			}
		}
		return $data;
	}
	
	/**
     * @public
     * sort multi array 
     * @param1	array
     * @param2	sort key
     */  
    public static function natsort2d( &$arrIn, $index = null )
    {   
	    $arrTemp = array();
	    $arrOut = array();
    
	    foreach ( $arrIn as $key=>$value ) {
    	    reset($value);
	        $arrTemp[$key] = is_null($index)
                            ? current($value)
                            : $value[$index];
	    }    
    	natsort($arrTemp);
    
    	foreach ( $arrTemp as $key=>$value ) {
	        $arrOut[$key] = $arrIn[$key];
	    }
    
    	$arrIn = $arrOut;
	
	    return $arrIn;
   }	
}
?>