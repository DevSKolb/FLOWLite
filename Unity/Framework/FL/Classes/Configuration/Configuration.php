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
 * If not, see http://www.gnu.org/licenses/lgpl.html                      */
 
class Configuration
{  
	/**
     * @access private 
     * @var array configuration
     */  
	private $configuration = array();

	/**
     * @access private 
     * @var object instance 
     * registry
     */  
	private $registry;

	/**
     * @access private 
     * @var object instance 
     * objectManager
     */  
	private $objectManager;
   
	/**
     * @access private 
     * @var object instance 
     */  
	private $xml;

	/**
     * @access private
     * Singleton __clone-Interzeptormethode
     */        
	private function __clone()  { }

	/**
     * @access public
     * __construct initialize
     */        
	public function __construct(){

		$this->objectManager = ObjectManager::getInstance();               
	} 
	
	
	/**
     * @access private
     * Object to array
     */        
	private function objectsIntoArray($arrObjData, $arrSkipIndices = array())
	{
    	$arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
	}

	/**
     * @access public
     * @param string path
     * 
     * reading a config (config.xml) 
     */  
	public function setConfig($path)
	{    
		// instance of registry
		$this->registry = $this->objectManager->getObject('Registry');
			    
		// if path and file exists
		if(file_exists($path))
		{
		 	// import xml file 
        	$xml = simplexml_load_file($path);

			// XML Object in Array umwandeln
			$arrXml = $this->objectsIntoArray($xml);

			// Zuweisung zur Registry       	
			foreach($arrXml as $key => $arrValue){
			 
			 	if(is_array($arrValue)){
					// Array weiter auflösen
					foreach($arrValue as $index => $value){

						if(!is_array($value)){

						// Camelcase (Param1:klein)(Param2:erster Buchstabe groß, Rest klein)
						// Sample: securityFile
						$regKey = strtolower($key).strtoupper(substr($index, 0, 1)) . substr($index, 1);

						// convert to Registry
						if($value == 'true')  { $this->registry->{$regKey} = (bool) true; } else		
						if($value == 'false') { $this->registry->{$regKey} = (bool) false;} else		

						$this->registry->{$regKey} = $value;
						}
					}
			 	}
			} 
	 	}
     	else
     	{
      # 		throw new Exception($path." :: file not found!", 404);
     	}
     	
#     	print_r($this->registry);
  	}  
}
?>