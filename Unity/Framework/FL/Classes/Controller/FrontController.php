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
final class FrontController 
{
  /**
   * @var ObjectManager
   */
   private $objectManager;
  
  /**
   * @var security
   */
   private $security;
  
  /**
   * @access private
   * request filters
   */  
   private $requestFilters = array();

  /**
   * @access private
   * controller rules
   */  
	private $ControllerRulesClass;
	private $ControllerRules = array();
	
  /**
   * @access private
   * controllers
   */  
   private $PreControllers = array();

  /**
   * @access private
   * controllers
   */  
   private $PostControllers = array();

  /**
   * @access private
   * request filters
   */  
   private $requestFilter = array();
  
  /**
   * @access private
   * request validators
   */  
   private $requestValidator = array();

  /**
   * @access protected
   * name of controller
   */  
   protected $controller;


  /**
   * @access protected
   * name of action
   */  
   protected $action;


  /**
   * @access protected
   * name of action
   */  
   protected $debug;

	/**
     * @access private
     * init classes
     */  
	private function initChains() 
    {
 		$this->requestFilters     = $this->objectManager->getObject('FilterChain','requestFilterChain');
		$this->requestValidators  = $this->objectManager->getObject('ValidatorChain','requestValidatorChain');
 		$this->PreControllers     = $this->objectManager->getObject('PreControllerChain');
 		$this->PostControllers    = $this->objectManager->getObject('PostControllerChain');
    }
  
	/**
     * @access public
     * init ObjectManager
     */  
	public function __construct() {    

 		// Instance of object manager
 	  	$this->objectManager = ObjectManager::getInstance(); 

 		// Instance of registry
 	  	$this->registry = $this->objectManager->getObject('Registry');
	}

  /**
   * @access private
   * Singleton-__clone()-Interzeptor
   */ 
   private function __clone() {}
  
  /**
   * @access public
   * add request filter
   */ 
   private function addRequestFilter(FilterInterface $filter){
     $this->requestFilters->addFilter($filter);
   }

  /**
   * @access public
   * add controller
   */ 
   private function addPreController(ControllerInterface $controller){
     $this->PreControllers->addPreController($controller);
   }

  /**
   * @access public
   * add controller
   */ 
   private function addPostController(ControllerInterface $controller){
     $this->PostControllers->addPostController($controller);
   }

  /**
   * @access public
   * add validator
   */ 
   private function addRequestValidator(ValidatorInterface $validator){
     $this->requestValidators->addValidator($validator);
   }

  /**
   * @access public
   * @param string path
   * path of controller
   */  
   public function setControllerPath($path){
     $this->controllerpath = $path;
   }
 
  /**
   * @access private 
   * @initRequestFilter
   * 
   * @var instance
   */	
   private function initRequestFilter($requestFilters) { 
       if(is_array($requestFilters)){
          foreach($requestFilters as $RequestFilterName){           
	         $this->addRequestFilter($this->objectManager->getObject($RequestFilterName));
   	      }
       }      
   }

  /**
   * @access private 
   * initRequestValidators
   * 
   * @var instance
   */	
    private function initRequestValidators($requestValidators) { 
	   if(is_array($requestValidators)){
          foreach($requestValidators as $ValidatorName){        
	         $this->addRequestValidator($this->objectManager->getObject($ValidatorName));
   	      }
       }      
    }

  /**
   * @access private 
   * foundControllerActionInWhitelist
   *
   * @var string
   */
	private function foundControllerActionInWhitelist($ControllerName) { 

	if(is_array($this->ControllerRules))
	{
	  foreach($this->ControllerRules as $entry => $rule )
	  {		 
		$ControllerFound 	= false;
		$ActionFound 		= false;
	
		if(is_array($rule)) 
		{
			foreach($rule as $key => $value)
		    {
				if($key==='controller' && $value===$ControllerName)	{
					$ControllerFound = true; 
				}	
	
				if($key==='action' && $ControllerFound && is_array($value)) {
					if(in_array($this->action,$value)) 
						$ActionFound = true;  
				}
				else
				if($key==='action'	&& $ControllerFound && $value===$this->action) {		 	
				 	$ActionFound = true; 			
				}	
		  	
			  if($ControllerFound && $ActionFound){	break; }		
		  }
 		 if($ControllerFound && $ActionFound){	break; }		
		}
	  }

	  // if controller and action was found -> execute
      if($ControllerFound && $ActionFound){
  	    	return ($ControllerFound && $ActionFound) ? (boolean) true : (boolean) false; 				   	
	  }
  }
  
  // controller nor in whitelist -> execute
  if(!$ControllerFound) return (boolean) false;
  }

  /**
   * @access private 
   * initPreControllers
   *
   * @var instance
   */
	private function initPreControllers($controllers) { 

		if(is_array($controllers)){
        	foreach($controllers as $ControllerName)
		  	{
				// if PreControllers in Application Namespaces
				if(NameSpaces::classExistsInApplication($ControllerName) || NameSpaces::classExistsInApplicationOnly($ControllerName)){ 
			
				// Whitelist ?
				if(ArrayHelper::hasEntries($this->ControllerRules)){				 
					$PreControllerStart = $this->foundControllerActionInWhitelist($ControllerName);
				} else
						$PreControllerStart = true;
	
				// PreController Init
				if($PreControllerStart){
					$this->debug->trace('--- Pre Controller INIT: '.$ControllerName,'PreController (Execute)');				 
				 	$this->addPreController($this->objectManager->getObject($ControllerName));
				} 
			}
   	      }
       }      
    }
  /**
   * @access private 
   * initPostControllers
   * 
   * @var instance
   */
   private function initPostControllers($controllers) { 

	   if(is_array($controllers)){
          foreach($controllers as $ControllerName){
		   
				// if POSTControllers in Application Namespaces
				if(NameSpaces::classExistsInApplication($ControllerName) || NameSpaces::classExistsInApplicationOnly($ControllerName)){ 

				// Whitelist ?
				if(ArrayHelper::hasEntries($this->ControllerRules)){				 
					$PostControllerStart = $this->foundControllerActionInWhitelist($ControllerName);
				} 
				else
					$PostControllerStart = true;				

				// PreController Init
				if($PostControllerStart){
					$this->debug->trace('+++ Post Controller INIT: '.$ControllerName,'PreController (Excecute)');				 
				 	$this->addPostController($this->objectManager->getObject($ControllerName));
				} 
   	      	}
		 }
       }      
    }

  /**
   * @access private 
   * initPostControllers
   * 
   * @var instance
   */
   private function deletePostControllers($controllers) { 

	   if(is_array($controllers)){
          foreach($controllers as $ControllerName){
		   
				$obj = $this->objectManager->getObject($ControllerName);
				unset($obj);
   	      	}
		 }
	   $this->PostControllers = array();
    }

  /**
   * @access private 
   * 
   * initControllersVariable
   */
   private function initControllersVariable(){
       return array();
   }

  /**
   * @access private 
   * 
   * 
   * flow
   */
   private function initControllersVariableThis(){
       $this->controllers = array();
   }


  /**
   * @access public
   * @param object controller
   * @return bool        
   *    
   */  
  public function isValid($controller)  {
    return (is_object($controller));
  }


  /**
   * @access private 
   * return instanfe of Action Controller
   */
   private function initActionController($NameOfController){
  		  return $this->objectManager->getObject($NameOfController); 
   }

  /**
   * @private 
   * 
   * flow
   */	     
	private function flow() {
#Benchmark::start('CON');
#Benchmark::start('SYS');
		$this->debug = $this->objectManager->getObject('Debug');
	
    // ---------------------------------------------------------------------------------
	// Filter-/Controller chains instances
    // ---------------------------------------------------------------------------------
       $this->initChains();

    // ---------------------------------------------------------------------------------
	// Controller Rules
    // ---------------------------------------------------------------------------------
#print_r(NameSpaces::$NSP_Application);

	   	$this->ControllerRulesClass = NameSpaces::getNamespaceOfClassSpecification('ControllerRules',true);
		if(is_array($this->ControllerRulesClass)){
			$this->ControllerRules = $this->objectManager->getObject('ControllerRules')->rules();		  
		  }

    // ---------------------------------------------------------------------------------
    // Request 
    // GET,POST,FILES,SERVER,HEADER,COOKIE
    // ---------------------------------------------------------------------------------
	// Request auslösen
       $request = $this->objectManager->getObject('Request');

    // ---------------------------------------------------------------------------------
    // ActionController
    // Names from Dispatcher and Router
    //
    // $dispatcher->getControllerName();
    // $dispatcher->getActionName();
    // ---------------------------------------------------------------------------------
	// Dispatcher 
       $dispatcher = $this->objectManager->getObject('Dispatcher');

	// flrp (FLOWLite Router Protocol)
	   $this->flrp = $this->objectManager->getObject('flrp');

	// Dispatch Controller and Action over Routing
       $dispatcher->dispatchControllerAction($request);

	// get Controller over Protocol FLRP
       $this->controller = $this->flrp->getController();

	// get Action over Protocol FLRP
       $this->action = $this->flrp->getAction();

    // ---------------------------------------------------------------------------------
    // RequestFilters
    // ---------------------------------------------------------------------------------
	// Filter ermitteln (RequestFilter) FilterChain
	   $requestFilters = NameSpaces::getNamespaceOfClassSpecification('RequestFilter');

	   if(is_array($requestFilters) && count($requestFilters) > 0){

		// Filter instanzieren
		   $this->initRequestFilter($requestFilters);

		// Alle Filter ausführen (Request übergeben)
    	   $this->requestFilters->execute($request);    
		}
    // ---------------------------------------------------------------------------------
    // RequestValidator
    // ---------------------------------------------------------------------------------
	// Validator ermitteln (RequestValidator) ValidatorChain
	   $requestValidators = NameSpaces::getNamespaceOfClassSpecification('RequestValidator');

	   if(is_array($requestValidators) && count($requestValidators) > 0){

		// Validator instanzieren
		   $this->initRequestValidators($requestValidators);

		// Alle Validatoren ausführen (Request übergeben)
    	   $this->requestValidators->execute($request);    
		}
    // ---------------------------------------------------------------------------------
	// PreController
	// Before Action Controller
    // ---------------------------------------------------------------------------------
	// PreController ermitteln
       $PreControllers = NameSpaces::getNamespaceOfClassSpecification('PreController');

	   if(is_array($PreControllers) && count($PreControllers) > 0){

		// Controller instanzieren
	       $this->initPreControllers($PreControllers);     

		// Controller ausführen (Request übergeben)
	       $this->PreControllers->execute($request);    
		}
    // ---------------------------------------------------------------------------------
	// PostController
	// After Action Controller
    // ---------------------------------------------------------------------------------
	// PreController ermitteln
       $PostControllers = NameSpaces::getNamespaceOfClassSpecification('PostController');

	   if(is_array($PostControllers) && count($PostControllers) > 0){

		// Controller instanzieren
    	   $this->initPostControllers($PostControllers);     
		 			   
		}		 			   
    // ---------------------------------------------------------------------------------
    // @@@ ActionController
    // @@@ action with praefix "Action"
    // @@@ run
    // ---------------------------------------------------------------------------------
	// Init Object
		$this->debug->trace('Action Controller: '.$this->controller,'FrontController');
		$this->debug->trace('Action : '.$this->action,'FrontController');

		// Existiert eine Controller Whitelist
		$ControllerExceptions = $this->objectManager->getObject('ControllerExceptions')->getExceptions();

		// @@@ Check Controller
		// @@@
		// @@@ Ist der Controller innerhalb der Whitelist zu finden (Kann, muss nicht)
		// @@@ Der Controller muss im Namespacebereich der Application gefunden werden.
		// @@@    
#echo $this->controller; echo "<br>";
#echo $this->action; echo "<br>";		
#Benchmark::stop('CON');
#echo "CON ";
#BaseHelperMessage::showMessage(Benchmark::getBenchmarkTime('CON'),array(BaseHelperEscapeChars::getEscapeChar('BR')));
#print_r(NameSpaces::$NSP_Application);
#Benchmark::stop('SYS');
#echo "SYS ";
#BaseHelperMessage::showMessage(Benchmark::getBenchmarkTime('SYS'),array(BaseHelperEscapeChars::getEscapeChar('BR')));

	   if (in_array($this->controller, $ControllerExceptions) 
	   ||  NameSpaces::classExistsInApplication($this->controller))
	   {

        
		  // Inizialization controller
          $controller = $this->initActionController($this->controller);

	  	  // Action
	      $action = trim($this->action).'Action';
#echo $this->controller;
#echo "<br>";
#echo $this->action;
#exit;

		  // Call controller and action
		  // Check of object
		  // Check of callable
          if($this->isValid($controller) && is_callable(array($controller,$action))){
             $controller->$action();
          }   
          else
			// Controller nicht gefunden, kein Object oder nicht aufrufbar
          	throw new Exception('Controller not callable ('.$this->controller.'->'.$action.') !',273562354);
       }
       else
       // Controller nicht gefunden
	   throw new Exception('Controller or Action not found ('.$this->controller.') ! ',273562352);

    // ---------------------------------------------------------------------------------
	// PostController
	// After Action Controller
    // ---------------------------------------------------------------------------------
	   if($this->registry->SystemFrontControllerRepeater === false){
		   if(is_array($PostControllers) && count($PostControllers) > 0){
			  $this->PostControllers->execute($request); 
		   }	  
	   } 
	 else 	 
	 {
	  # $this->deletePostControllers($PostControllers);
	  }
  }  
  
  /**
   * @access public 
   * run
   */   
  public function run(){     	
		$this->flow();			
  }
}
?>