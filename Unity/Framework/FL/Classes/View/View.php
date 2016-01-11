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
 * 
 */	
final class View extends System {

  /**
   * Template
   */
   private $template;

  /**
   * Partial
   */
   private $partial;

  /**
   * Delimiter Start
   */
   private $delimiterStart = "{";

  /**
   * Delimiter End
   */
   private $delimiterEnd   = "}";

  /**
   * pl
   */
   private $pl;

  /**
   * Path To Application Template
   */
   private $PathToApplTemplate;
   
  /**
   * Fehlermeldung, wenn Template nicht geladen werden kann
   */
   private $TPL_ERR_FILE = "Could not load tpl file.";

  /**
   * Request
   */
   protected $request;
   
  /**
   * Template
   */
   protected $templateTyp;

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

/* 
    private function parseFunctions() {
        // Includes ersetzen ( {include file="..."} )
        while( preg_match( "/" .$this->leftDelimiterF ."include file=\"(.*)\.(.*)\""
                           .$this->rightDelimiterF ."/isUe", $this->template) )
        {
            $this->template = preg_replace( "/" .$this->leftDelimiterF ."include file=\"(.*)\.(.*)\""
                                            .$this->rightDelimiterF."/isUe",
                                            "file_get_contents(\$this->templateDir.'\\1'.'.'.'\\2')",
                                            $this->template );
        }


        // Kommentare löschen
        $this->template = preg_replace( "/" .$this->leftDelimiterC ."(.*)" .$this->rightDelimiterC ."/isUe",
                                        "", $this->template );
    }
	*/ 
	  	
  /**
   * Load a Template file of .TPL, .HTM and .HTML
   * This is only useful if it is not possible to
   */
   private function getPathToTemplate(){

		$realPath = '';

		/*
	 	 * with Unity Screen Design
	 	 * templates from unity/templates
		 */ 
		if($this->registry->routerUsd == true){
	
			// who is my unity
			$unity = $this->flrp->getUnity();
		 
			// set unity
			$unity 	=== empty($unity) 
					? $this->registry->standardUnity
					: $unity;
		
			// set path to template	
			if($unity === 'LOGIN'){ $realPath = '/Templates/ '; } else
			{
				switch($this->templateTyp){
				 	case 'APPS'  : { $realPath = '/Templates/ '; break; }
				 	case 'UNIT'  : { $realPath = '/Unity/'.$unity.'/Templates/'; break; }
				 	case 'YAML'  : { $realPath = '/yaml/project/tc/'; break; }
					default      : { $realPath = '/Templates/ '; break; }
			 	}	
			}
		}
		else $realPath = '/Templates/ ';

		// return path to template
		return trim(dirname(realpath($_SERVER['SCRIPT_FILENAME'])) . $realPath);
   }

   public function deleteTemplate()
   { 
		$this->template = '';	
   }

  /**
   * Load a Template file of .TPL, .HTM and .HTML
   * This is only useful if it is not possible to
   * set a template filename by creating an instance of
   * the template class.
   */
   private function loadTemplate($file)
   { 
	    $FILE_PATH_AND_FILENAME = $this->getPathToTemplate() . $file;

	    if(file_exists($FILE_PATH_AND_FILENAME))
		{ 
	       $this->template = file_get_contents($FILE_PATH_AND_FILENAME);

			// utf8 encode
	    	if($this->registry->tplUtf8){   
			       $this->template = utf8_encode($this->template);
			}       
	    } 
		else
		throw new Exception('File ['.$FILE_PATH_AND_FILENAME.'] not found', 404);  
   }

   /**
    * Constructor function.
    * If a template filename is submitted, this function will
    * initialize the template object tree.
    */
   public function setTemplate($filename = "", $typ = 'UNIT')
   {    
		$this->templateTyp = $typ;
      	
		$this->loadTemplate($filename);
   }

  /**
    * getPlaceholder
    */
	public function getPlaceholder(){

		if(empty($this->template)) return false;

		$pattern = "/{[^{(.*)^}]*}/";

		preg_match_all($pattern, $this->template, $matches);

		

        return $matches;		
	}

  /**
    * Assign value to an existing placeholder.
    * If this function is called multiple, the contents
    * will be added.
    *
    * The parameter $varName can be a string, an associative
    * array or a Template object.
    */
	public function assign($varName,$varValue=false)
    {
    	if (is_array($varValue))
	    {
		foreach ($varValue as $key => $value)
		    {
			$this->pl[$varName][] = $value;
		    }
	    }
	    else
	    {
		$this->pl[$varName][] = $varValue;
	    }
	}

  /**
    * Assign value to an existing placeholder.
    * If this function is called multiple, the contents
    * will be added.
    *
    * The parameter $varName can be a string, an associative
    * array or a Template object.
    */
	public function assignObligatory($varName,$varValue=false)
    {
    	if (is_array($varValue))
	    {
		foreach ($varValue as $key => $value)
		    {
			if(	isset($this->pl[$varName])){
				 $this->pl[$varName][0] = $value;
			} 
			else $this->pl[$varName][] = $value;
		    }
	    }
	    else
	    {
			if(	isset($this->pl[$varName])){
				 $this->pl[$varName][0] = $varValue;
			} 
			else $this->pl[$varName][] = $varValue;
	    }
	}
  /**
    * Returns a template with all replacements done.
    * Replace values at placeholders. Objects was
    * to compartmentalize with recursive function.
    */
	private function get()
    { 
	    if (is_array($this->pl))
	    {
		foreach ($this->pl as $key => $value)
		    {
			$search = $this->delimiterStart . $key . $this->delimiterEnd;
			$replaceText = "";
			for ($i = 0; $i < count($this->pl[$key]); $i++)
			{
			    if (is_object($this->pl[$key][$i]))
				$replaceText .= $this->pl[$key][$i]->get();
			    else
				$replaceText .= $this->pl[$key][$i];
			}
			$this->template = str_replace($search,$replaceText,$this->template);
		    }
	    }
	    return $this->template;
	}

	/**
 	 * Set to loop 
     * @param Partial Template for loop
     * @param Placeholder in Head Template
     * @param Array of data
     * @access private
     */
  	public function assignLoop($rplh,$tpl,$plh,$Array) {
        
    	$this->partial = "";                           
    
		foreach ($Array as $element) 
		{
    	  $PartialTemplate = new View($tpl); 
		  
		  $PartialTemplate->setTemplate($tpl);
		  
		  $PartialTemplate->assign($plh,$element);
	  
	      $this->partial .= $PartialTemplate->get(); 
	    }
	    $this->assign($rplh,$this->partial);
	}

	/**
     * Delete the contents of submitted variables
     * from a submitted templates.
     */
   	public function reset()
   	{
     	unset($this->pl);
   	}

	/**
     * Print a template with all replacements done.
     *
     */
	public function renderHidden(){
     	return $this->get();
   	}
  	
	/**
     * Print a template with all replacements done.
     *
     */
	public function render(){
     	echo $this->get();
   	}
}
?>
