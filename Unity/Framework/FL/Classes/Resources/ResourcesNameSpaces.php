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
 * @class ResourcesNameSpaces 
 * @package FLOWLite 1.0.2
 * @author Silvan Kolb <flowlite@silvankolb.de>
 *    
 */
class ResourcesNameSpaces
{
    /**
	 * FlexiNSP
	 * recurive function for all classes
	 *
	 * @return void
	 * @author Silvan Kolb 
	 *
	 * ~ param recursive for compatibilty 
	 */  
/*
	public static function getNamespaces($path = FL_PATH_CLASSES, $recursive=true, &$name = array() )
	{
	  	$path = $path == ''? dirname(__FILE__) : $path;
		$lists = @scandir($path);
 
 		if(!empty($lists))
		{
      		foreach($lists as $f){ 
				if(is_dir($path.DIRECTORY_SEPARATOR.$f) && $f != ".." && $f != "."){
					self::getNamespaces($path.DIRECTORY_SEPARATOR.$f, true, &$name);
      			}
      			else
      			{
					$fileInfo = pathinfo($path.DIRECTORY_SEPARATOR.$f);	
					if(isset($fileInfo['extension']) && $fileInfo['extension']=='php'){
						$name[$fileInfo['filename']] = $path.DIRECTORY_SEPARATOR.$f;
					}	
      			}
      		}
  		}
  		return $name;
	}
*/
     public static function getNamespaces($directory = FL_PATH_CLASSES, $recursive=true, $blacklist=false){

  		    $array_items = array();
  		    
  		    if (is_dir($directory))
			  {
					// Blacklist
 				    $flag_needle = 1;
					if(is_array($blacklist))
					{
						$blacklist_path = explode('/',$directory);				
						$blacklist_dir = $blacklist_path[count($blacklist_path)-2];

 						if(is_dir($directory) && in_array($blacklist_dir,$blacklist)){
 							$flag_needle = 0;
 						 }
					}
								   
		 	if ($handle = opendir($directory))
			 {
  	  		    while (false !== ($file = readdir($handle)))
					{				

					// Gültiger Name 
			        if ($file != "." && $file != "..")
				    {
				    if (is_dir($directory. "/" . $file) )
					{
 			   
					if($recursive && $flag_needle == 1){
  	                   $array_items = array_merge(
					                  (array)$array_items, 
					                  (array)self::getNamespaces($directory. "/" . $file, $recursive, $blacklist)
								 	  );
					}} else {
				      if(strpos($file,'.php')!== false)
					  {	
				         $FileClassName = explode('.',$file);							  
					     $file = $directory . "/" . $file;

						 if($flag_needle == 1){
						 	$array_items[$FileClassName[0]] = preg_replace("/\/\//si", "/", $file);						 
						 }
	                  }				
				   }
			     }
	  	       }
		       closedir($handle);
	       }}
	       return $array_items;
      }

	/**
     * Singleton-Elements: private __construct
     *                     private __clone   
     */     
	private function __construct() {} // statis class
	private function __clone() {} // no clone
}
?>