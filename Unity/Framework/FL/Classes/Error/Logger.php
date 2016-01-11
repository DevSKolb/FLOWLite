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
class Logger extends System
{
	/**
     * Number of Error
     */
	private $ErrorNumber;

    /**
     * Message 
     */
	private $ErrorMessage;

    /**
     * Filename
     */
	private $ErrorFile;

    /**
     * Line of File
     */
	private $ErrorLine;

    /**
     * Routes of Error
     */
	private $ErrorRoutes = array('DISPLAY','USER_DISPLAY','FILE');

    /**
     * Send Error to Mail
     */
	private $ErrorMail;

    /**
     * Mail Webmaster
     */
	private $MailToWebmaster;

	/**
     * @public
     * 
     * LogError
     */
	public function LogError($ErrorNumber, $ErrorMessage, $ErrorFile, $ErrorLine){
       
    	$this->ErrorNumber  = $ErrorNumber;
       	$this->ErrorMessage = $ErrorMessage;
       	$this->ErrorFile    = $ErrorFile;
       	$this->ErrorLine    = $ErrorLine;

		$errorRouter = $this->getErrorRoute();

		switch($errorRouter){
        	case 'DISPLAY' 		: { $this->outputError(); break; }
          	case 'USER_DISPLAY' : { $this->outputUserError(); break; }
          	case 'FILE'    		: 
		  	{ 

				$FileLogging = $this->objectManager->getObject('FileLog');
	          	$FileLogging->setMessage($this->generateMessage());
		      	break; 
		  	}
		}
		
		// Send Error Mailing
		if($this->errorMail) {

#			$this->Mail = $this->objectManager->getObject('Mailing');
#	        $this->Mail->sendTo($this->MailToWebmaster,'FLOWLite Error Handling',$this->generateMessage());
	        
BaseHelperMessage::showMessage('Mail to Webmaster: '.$this->MailToWebmaster);
		} 
	}

	/**
      * @protected
      *
      * route of error
      *
      */
    private function getErrorRoute(){

		$this->errorMail = (isset($this->registry->loggerMail)) ? $this->registry->loggerMail : null;
		$this->MailToWebmaster = (isset($this->registry->LOG_MAIL_WEBMASTER)) ? $this->registry->LOG_MAIL_WEBMASTER : null;

		if(isset($this->registry->loggerOutput)){
			if(in_array($this->registry->loggerOutput,$this->ErrorRoutes)){
	     		return $this->registry->loggerOutput; 
			}
	   	}	
		else return "USER_DISPLAY";
	}

	/**
     * @protected
     *
     * Generates the error id.
     *
     */
	protected function generateErrorID($ErrorNumber, $ErrorMessage, $ErrorFile, $ErrorLine){
		return md5($ErrorMessage.$ErrorNumber.$ErrorFile.$ErrorLine);
	}   
	  
	/**
     * @protected
     *
     * Generates the error id.
     *
     */
	protected function generateMessage(){         
   		return '['.$this->ErrorNumber.'] '.$this->ErrorMessage.' (File: '.$this->ErrorFile.', Line: '.$this->ErrorLine.')'; 
	}

	/**
     * @protected
     *
     * output message
     *
     */
	protected function outputError(){         
   		BaseHelperMessage::showMessage($this->generateMessage());
	}
    
	/**
     * @protected
     *
     * ouput message for user
     *
     */
	protected function outputUserError(){

		$UserMessage  = '<pre>';
        $UserMessage .= 'err  : '  . $this->ErrorNumber . "\n";
        $UserMessage .= 'desc : ' . $this->ErrorMessage . "\n";
        $UserMessage .= 'file : ' . $this->ErrorFile . "\n";
        $UserMessage .= 'line : ' . $this->ErrorLine . "\n";
        $UserMessage .= '</pre>';
           
		// Output Message 
		BaseHelperMessage::showMessage($UserMessage);
	}   
}
?>