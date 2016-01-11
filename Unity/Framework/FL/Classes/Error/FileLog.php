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
final class FileLog extends System
{
    /**
     * Message 
     */
	private $ErrorMessage;

    /**
     * Log Art (File)
     */
	private $logArt;

	/**
     * @public
     * 
     * LogError
     */
    public function setMessage($ErrorMessage,$logArt='LOG'){
       
    	$this->ErrorMessage = $ErrorMessage;	       
    	$this->logArt 		= $logArt;	       
       	$this->ErrorOutputToFile();
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
     * isFilePutContents
     */
	private function getErrorLogFileName(){
	 
	 	switch($this->logArt){
	 	 	case 'LOG' : {
					    	return $_SERVER["DOCUMENT_ROOT"] .'/'. $this->registry->loggerFile; break;
					     }	
		}
    }     
	      
    /**
     * @private
     * 
     * file_put_contents
     */
	private function file_put_contents($ErrorLogFileName,$Data,$FILE_OPTION){

		$ErrorFileHandle = @fopen($ErrorLogFileName,"a+");
        
        if (!$ErrorFileHandle){ return false; }
        else
        {
        	fwrite($ErrorFileHandle,$Data);
          	fclose($ErrorFileHandle);
          	
		    return true;          
        }
     }

	/**
     * @private
     * 
     * ErrorOutputToFile
     */
    private function ErrorOutputToFile(){

		$MessageLogData = Date("d-M-Y h:i:s", time()) ." = ". $this->ErrorMessage . " \r\n";                   

		$ErrorLogFileName = $this->getErrorLogFileName();

			if($this->isFilePutContents()){
            	$fileok = file_put_contents($ErrorLogFileName, $MessageLogData, FILE_APPEND);
         	} else
            	$fileok = $this->file_put_contents($ErrorLogFileName, $MessageLogData, FILE_APPEND);
		
#		echo "Error Message File logged !";
     } 
}
?>