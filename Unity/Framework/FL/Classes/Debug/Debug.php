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
class Debug extends System {
  
  	/**
     * @public
     * trace message
     */
	private $traceMessage;
	
  	/**
     * @public
     * trace category
     */
	private $traceCategory;

  	/**
     * @public
     * trace category
     */
	private $traceNumber = 0;

  	/**
     * @public
     * date and time
     */
	private $effectiveDate;
	
  	/**
     * @public
     * trace message
     */
	public function trace($traceMessage, $traceCategory){
       
        if( ! FL_TRACE ) return false;
       
		// Message und Kategorie
    	$this->traceMessage  = $traceMessage;
       	$this->traceCategory = $traceCategory;

		// Couter der Meldung
       	$this->traceNumber++;
	
		// Datum und Uhrzeit
		$this->effectiveDate = $this->getEffectiveDate();	
		
		// Routing ermitteln
		$traceRouter = $this->getTraceRoute();	

		switch($traceRouter){
        	case 'DISPLAY' 		: { $this->outputTrace(); break; }
          	case 'FILE'    		: 
		  	{   	  
				$this->logTrace();
		      	break; 
		  	}
		}
		return true;
	}

	/**
      * @protected
      *
      * route of error
      *
      */
    private function getTraceRoute(){
		return 'FILE';		
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
	protected function generateTraceMessage(){       
   		return '('.$this->traceNumber.')::'.$this->effectiveDate.'::['.$this->traceCategory.']:'.$this->traceMessage; 
	}
		
  	/**
     * @private
     * 
     * output to screen
     */
	public function outputTrace(){
	  BaseHelperMessage::showMessage($this->generateTraceMessage(),array("<br>"));
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
	public function logTrace(){
		
		$ErrorLogFileName = FL_APPL_PATH .'Logs/trace.log';		
		$MessageLogData =  $this->generateTraceMessage() . " \r\n";                   

		if($this->isFilePutContents()){
            	$fileok = file_put_contents($ErrorLogFileName, $MessageLogData, FILE_APPEND);
         	} else
            	$fileok = $this->file_put_contents($ErrorLogFileName, $MessageLogData, FILE_APPEND);
    }
} 
?>