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
class SecurityManager extends System
{
    /**
     * request
     *
     * @var   object instance of requests data
     */
	private $request;

    /**
     * storage
     *
     * @var   object instance of storage
     */
	private $storage;

    /**
     * report
     *
     * @var   object instance of report
     */
	private $report;

    /**
     * filter
     *
     * @var   object instance of filter object
     */
	private $filter;

    /**
     * filters
     *
     * @var   array
     */
	private $filters = array();

    /**
     * internal request data
     *
     * @var   array
     */
	private $InternalRequestData;

    /**
     * Constructor
     *
     * Instance of SecurityManager
     * @return void
     */
	public function __construct(){

		parent::__construct();
    
        // get instance of request
		$this->request = $this->objectManager->getObject('Request'); 		
  	}

    /**
     * run
     *
     * started with configuration
 	 * 
     * @return void
     */
	public function run(){

        // what data should be filtered => configuration FLOWLite.ini 
        $data_filter = explode(',',$this->registry->securityData);

        // request of the original data from the Request object
        foreach($data_filter as $key => $value)
		{
			if(is_string($value))
			{
			 switch($value){
			 	case 'POST'   : { $hash_value = 'f0dd00aae5d2aeb141b984566f3101558ee87cd8'; break;}
			 	case 'GET'    : { $hash_value = '8646611bd4094995f8c5667445e1b868f42a84e4'; break;}
			 	case 'COOKIE' : { $hash_value = '4d09cbbffeebb03585ad2c7040e5b4c12bea9a76'; break;}
			 	case 'FILE'   : { $hash_value = '5979a35a5c7959f0de647ad665740501dcd2241b'; break;}
			 } 	
			// original data only on hash value
			$this->InternalRequestData[$value]  = $this->request->{'getRaw'.$value}($hash_value);
			}
        }

		// load filters from xml
        $this->storage = $this->objectManager->getObject('SecurityStorage');   
        $this->storage->getFilterFromXML();

		// for all requests
        if (!empty($this->InternalRequestData)) 
		{
            // all requests (GET,POST)
			foreach ($this->InternalRequestData as $key => $value) 	
			{
			 	// array of request
				if(is_array($value))
				{
 					// Iterates all request params (GET DATA, POST DATA)
					foreach ( $value as $no => $vdata ) {

					 	// array of request
						if(is_array($vdata))
						{
		 					// Iterates all request params (DATA[])
							foreach ( $vdata as $n => $d ) 
							{
							    $this->_iterate($n, $d);	  
							} 
						} 
					    else $this->_iterate($no, $vdata);	  
					}
				} 
				else $this->_iterate($key, $value);
            }
        }		

		// getReport of Filters
		if(!empty($this->filters))
		{
		    // print report by infection
	        $this->report = $this->objectManager->getObject('SecurityReport');   
    	    $this->report->output($this->filters,'LOG');

			// actions step: Script stopped if Total Impact > TI in configuration
			if($this->report->getTotalImpact() > $this->registry->securityExit )
			{
			   // hardcore exit 
			   if($this->registry->securityCallback == '0')
			   {
				   throw new Exception('Detected very important malicious code !', 78860);
				   exit;
			   }  
			   // Security Callback Site
			   else 
			   {
			    	header('Location: '.$this->registry->securityCallback);
			    	exit;
			   }
			}
		}
	}

    /**
     * Iterates through given data 
     *
     * @param mixed $key   the former array key
     * @param mixed $value the former array value
     *
     * @return void
     */
    private function _iterate($key, $value)
    {
        $filterSet = $this->storage->getFilterSet();

		foreach ($filterSet as $filter) {
			if ($this->_match($value, $filter)) {
                $this->filters[] = $filter;                
            }
        }      
    }
    
    /**
     * Matches given value against given filter
     *
     * @param mixed  $value  the value to scan
     * @param object $filter the filter object
     *
     * @return boolean
     */
    private function _match($value, $filter)
    {
        if ($filter->match($value)) {
            return true;
        }
        return false;
    }
    
}
?>