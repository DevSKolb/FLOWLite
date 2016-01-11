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
class SecurityReport
{
    /**
     * filters
     *
     * @var   array
     */
	private $filters = array();

    /**
     * TotalImpact  
     *
     * @var   int
     */
	private $TotalImpact;

    /**
     * TotalImpact  
     *
     * @var   int
     */
	private $MessageToFile = '';

    /**
     * getReport
     *
     * started with configuration
 	 * 
     * @return void
     */
	private function outputMessage(){

		echo '<font color="red">';

        // report output
        foreach ($this->filters as $key => $filter ) 
		{			
			echo 'Impact: '.$filter->getImpact().'; '.$filter->getDescription() . "<br/>\n";;

			$this->TotalImpact = $this->TotalImpact + $filter->getImpact();
        }
	
		echo 'Total impact: ' . $this->TotalImpact . "<br/>\n";		
		echo '</font>';
	} 

	/**
      * @protected
      *
      * date and time
      *
      */
    private function getEffectiveDate(){     
     	return date("D M j G:i:s T Y"); 
	}
		
	/**
     * @protected
     * Generates the error id.
     *
     */
	protected function generateSecurityMessage(){       
   		return  "---------------------------------------------------------------------------"
   				. " \r\n"
		   		. "Detected very important malicious code at: " . $this->getEffectiveDate()
				. ": \r\n" 
 			  . "---------------------------------------------------------------------------"
				. " \r\n" 
				. $this->MessageToFile; 
	}
	
    /**
     * getReport
     *
     * started with configuration
 	 * 
     * @return void
     */
	private function outputFile(){

        // report output
        foreach ($this->filters as $key => $filter ) 
		{			
			$this->MessageToFile .= 'Impact: '.$filter->getImpact().'; '.$filter->getDescription() . " \r\n";

			$this->TotalImpact = $this->TotalImpact + $filter->getImpact();
        }	
		$this->MessageToFile .= 'Total impact: ' . $this->TotalImpact . " \r\n";		
	}

    /**
     * @private
     * 
     * isFilePutContents
     */
	private function isFilePutContents(){
    	return (function_exists('file_put_contents')) ? true : false; 
    }
		
  	/**
     * @private
	 *
     * log trace 
     */
	public function logToFile(){
		
		$ErrorLogFileName = $_SERVER["DOCUMENT_ROOT"] .'/FLOWLite_1.0/Unity/Framework/Logs/security.log';
		
		$MessageLogData =  $this->generateSecurityMessage();   
		
		if($this->isFilePutContents()){
            	$fileok = file_put_contents($ErrorLogFileName, $MessageLogData, FILE_APPEND);
         	} else
            	$fileok = $this->file_put_contents($ErrorLogFileName, $MessageLogData, FILE_APPEND);
     }
     
    /**
     * getReport
     *
     * started with configuration
 	 * 
     * @return void
     */
	public function output($filters,$typ='DISPLAY'){
		
   		// all filter found are bad values
		$this->filters = $filters;

		// LOG Typ ?
		switch($typ){
			case 'DISPLAY' : { $this->outputMessage(); break; }	  
			case 'LOG'     : { $this->outputFile(); $this->logToFile(); break; }	  
		}  
	}

    /**
     * getTotalImpact
     *
     * return to total impact for next action steps
 	 * 
     * @return int
     */
	public function getTotalImpact(){
	 	return $this->TotalImpact;
	}
}
?>