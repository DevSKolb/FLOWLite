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
class Router extends System{
  
  /**
   * @access private
   * NameOfController
   */  
   private $NameOfController;
  /**
   * @access private
   * NameOfAction
   */  
   private $NameOfAction;
  /**
   * @access private
   * NameOfAction
   */  
   private $NameOfScreen;
  /**
   * @access private
   * NameOfAction
   */  
   private $NameOfUnity;

	/*
     * @access private
     * request
     */  
	private $request;

	/*
     * @access private
     * request
     */  
	private $slash = '/';

	/*
     * rules
     */  
	private $urlRules;

	/*
     * controller position
     */  
	private $controllerPosition;

	/*
     * controller of app
     */  
	private $appController		= '';

	/*
     * action of app
     */  
	private $appAction 			= '';
	
	/**
	 * Environment object
	 * @var object
	 */
	public $debug;
   
	/**
	 * @access private
	 * route_AJAX
	 * 
	 */  
	public function getNameOfUnity() {

		/*
		 * 	@param 	ac	(ajaxController)
		 */
		if(isset($this->NameOfUnity) && $this->NameOfUnity > '')
			return $this->NameOfUnity;
			
		return false;		
	}

	/**
	 * @access private
	 * route_AJAX
	 * 
	 */  
	private function route_AJAX() {

		/*
		 * 	@param 	ac	(ajaxController)
		 */
		$this->NameOfController = $this->request->getGet('ac');

		/*
		 * 	action response
		 */
		$this->NameOfAction = 'response';
	}
  
	/**
	 * teminateSlashes
	 */  
	private	function teminateSlashes($route){
	 
		// delete first and last slash 
		while(substr($route,  0, 1) == "/" 
	    ||    substr($route, -1, 1) == "/")
		{
			if(substr($route, 0, 1) == "/"){
				$route = substr($route, 1);
			}

			if(substr($route, -1, 1) == "/"){
				$route = substr($route, 0, -1);
 			}
 		}
		return $route;
	}  

	/**
	 * extractScriptName
	 */  
	private	function extractScriptName($scriptName){

		// callback is false
		$callback 		= false;

		// delete first and last slashes from script name
		$scriptName   	= $this->teminateSlashes($scriptName);

		// extract script name
		$NameOfScript 	= explode('/',$scriptName);
		
		// callback is name of script
		$callback 		= strtolower($NameOfScript[0]);
		
		// return
		return $callback;
	}

	/**
	 * teminateScriptName
	 *
	 * @param route
	 * @param name
	 */  
	private	function teminateScriptName($route,$name){
	 
		// callback is route
		$callback = $route;

		$nameOfScriptFromRoute = '';

		// where is position of slash in route
		$pos = strpos($route,'/');

		// namen extrahieren
		if($pos > 0 && $pos !== false){		 
			$nameOfScriptFromRoute = substr($route, 0, $pos);		 
		}
		else
		if($pos == 0 && $pos !== false){		 
			$nameOfScriptFromRoute = substr($route, 0, strlen($name));		 
		}
		$nameOfScriptFromRoute = strtolower($nameOfScriptFromRoute);		 

		// callback
		if($nameOfScriptFromRoute == $name){
		 	$callback = substr($route,$pos,strlen($route));
		} 

		return $callback;
	}  

	/**
	 * teminateDirnameOfPHP_SELF
	 *
	 * @param route
	 * @param dirname
	 */  
	private	function teminateDirnameOfPHP_SELF($route,$dirname){
	 
		// callback is route
		$callback = $route;

		$nameOfScriptFromRoute = '';

		// where is position of slash in route
		$pos = strpos($route,$dirname);

		// namen extrahieren
		if($pos > 0 && $pos !== false){		 
			$nameOfScriptFromRoute = substr($route, 0, $pos);		 
		}
		else
		if($pos == 0 && $pos !== false){		 	
			$nameOfScriptFromRoute = substr($route, 0, strlen($dirname));		 
		}

		// callback
		if($nameOfScriptFromRoute == $dirname){
		 	$callback = substr($route,strlen($dirname),strlen($route));
		} 

		return $callback;
	}  
	 
	/*
	 * set arguments ro route
	 */	   	  
	private function setArgumentsOfRoute($routeParam) {
    
		/*
		 * count of params in route
		 */
		$countOfRoute = count($routeParam);

		/*
		 * registry entry 
		 *
		 * '$this->registry->countArguments'
		 */
		$this->registry->{'countArguments'} = $countOfRoute;		 

		/*
		 * registry entry of arguments fro route
		 *
		 * $this->registry->argument0 .. n 
		 */
		for($i = 0; $i < $countOfRoute; $i++)
		{
			$this->registry->{'argument'.$i} = $routeParam[$i];		 
		} 

	}	 
	
	/*
	 * @access private
	 * 
	 */  
	private function getRoutingParam($paramObjekt,$numberOfParam) {

		if( ! is_array($paramObjekt)) return false;
		
		if(isset($paramObjekt[$numberOfParam])){
			return $paramObjekt[$numberOfParam];		
		} 
	}
     
  /**
   * @access private
   * route_USC
   * 
   */  
   private function route_USD() {

		/*
	     * @flrp (FLOWLite Router Protocol)
	     */
		$flrp = $this->objectManager->getObject('flrp');

		// init Object
        $usaAdapter = $this->objectManager->getObject('UsaAdapter');

		/* USD Unity Screen Design
		 * USA Adapter
		 */
		$USD_U = '';
		$USD_S = '';
		$USD_A = '';
			
		/*
		 * get USA Params from request
		 */
		list($USD_U,$USD_S,$USD_A) = $usaAdapter->getUSAParams();
			
		/*
		 * set USA Params to FLRP (FLOWLite Router Protocol)
		 */				
		$flrp->initUSA();
		$flrp->setUSA($USD_U,$USD_S,$USD_A);

        // if Unity and Screenno. => Controller else Default
        if(isset($USD_U) && isset($USD_S))
		{  
           $this->NameOfController = $USD_U .'_'. $USD_S;
        }  
		else 
		   $this->NameOfController = $this->registry->standardController;
	                   
		// interface USA
		$this->NameOfUnity  = $USD_U;
		$this->NameOfScreen = $USD_S;
		$this->NameOfAction = $USD_A;
   }
   

   /**
    * @access private
    * route Rewrite
    * 
    */  
	private function route_REWRITE() {

		/*
		 * init empty flag controller & action
		 */	   	  
		$FLAG_EMPTY_CONTROLLER 	= false;
		$FLAG_EMPTY_ACTION 		= false;

		/*
		 * init name of controller & action 
		 */	   	  
		$this->appController 	= '';
		$this->appAction 		= '';
		
		/*
		 * find urlRules class
		 */	   	
		$this->urlRulesClass = NameSpaces::getNamespaceOfClassSpecification('urlRules',true);

		/*
		 * reading url rules, if find urlRules class
		 */	   	
		if(is_array($this->urlRulesClass)){
			$this->urlRules = $this->objectManager->getObject('urlRules')->rules();		  
		}

		/*
		 * route
		 *
		 * The URI which was given in order to access this page; for instance, '/index.html'. 
		 *
		 * @param REQUEST_URI
		 */	   	
		$route = $_SERVER['REQUEST_URI'];

		/*
		 * script
		 *
		 * Contains the current script's path. This is useful for pages
		 * which need to point to themselves. The __FILE__ constant 
		 * contains the full path and filename of the current file. 
		 *
		 * @param SCRIPT_NAME
		 */	   	
		$script = $_SERVER['SCRIPT_NAME'];

		/*
		 * delete left and right slash in route
		 */
		$route = $this->teminateSlashes($route);

		/*
		 * pathname of script 
		 *
		 * Returns parent directory's path of PHP_SELF
		 *
		 * @param dirname(PHP_SELF)
		 */	   	
		$dirPathOfPHP_SELF = dirname($_SERVER['PHP_SELF']);

		/*
		 * delete left and right slash in dirPathOfPHP_SELF
		 */
		$dirPathOfPHP_SELF = $this->teminateSlashes($dirPathOfPHP_SELF);

		/*
		 * delete dirPathOfPHP_SELF in route
		 */
		$route = $this->teminateDirnameOfPHP_SELF($route,$dirPathOfPHP_SELF);

		/*
		 * delete left and right slash in route
		 */
		$route = $this->teminateSlashes($route);

		/*
		 * add slash to route
		 */
		$routeParam = explode('/',$route);

		/*
		 * set arguments in registry of route
		 */
		$this->setArgumentsOfRoute($routeParam);

		/*
		 * set default, if zero arguments
		 */
		if($this->registry->countArguments == 0){
				
	        $this->NameOfController = $this->registry->standardController;
    	    $this->NameOfAction     = $this->registry->standardAction;

			return false; 
		} 

		/*
		 * controller position (first/last)
		 */
		$this->controllerPosition = 'first';		// default

		/*
		 * first or last from urlRules (urlControllerInPath)
		 */
		if( is_array($this->urlRules) 
		|| 	isset($this->urlRules[0]['urlControllerInPath']))
		{
			$this->controllerPosition = $this->urlRules[0]['urlControllerInPath'];				
		}

		/*
		 * Who is my Controller without "unity screen design"
		 */
		if($this->registry->countArguments >= 1 && $this->registry->routerUnity === false){

			switch($this->controllerPosition)
			{			 
				case 'first' : { $this->appController = $this->getRoutingParam($routeParam,0); break; }
				case 'last'  : { $this->appController = $this->getRoutingParam($routeParam,$this->registry->countArguments-1); 
								 break; }
				default      : { $this->appController = $this->registry->standardController; break;}
			}	
		}

		/*
		 * Who is my Controller with "unity screen design"
		 */
		if($this->registry->countArguments >= 1 && $this->registry->routerUnity === true){

			switch($this->controllerPosition)
			{			 
				case 'first' : { $this->NameOfUnity  = $this->getRoutingParam($routeParam,0); 
				 				 $this->NameOfScreen = $this->getRoutingParam($routeParam,1); 
								 break; 
							   }
				case 'last'  : { $this->NameOfUnity  = $this->getRoutingParam($routeParam,$this->registry->countArguments-1); 
								 $this->NameOfScreen = $this->getRoutingParam($routeParam,$this->registry->countArguments-2); 
				                 break; 
							   }
				default      : { $this->appController = $this->registry->standardController; break; }
			}	

			/*
			 * Controller = Unity + ... (see you later )
			 */
			$this->appController = $this->NameOfUnity ;
		}
	
		/*
		 * Controller is empty default set
		 */
		if(empty($this->appController)){	 
			$this->appController = $this->registry->standardController; 
		}		

		/*
		 * Filter of Extensions * SEO Component (htm|html)
		 *
		 * 1.) 	Es existieren Extension in den urlRules (url Regeln)
		 *     	Die Extension müssen grundsätzlich als Array angegeben werden
		 *
		 *     	a.) Extension ist 'all' oder 'ALL'
		 *          Eine in der URL gefundene Extension wird immer abgeschnitten
		 *
		 *	   	b.) Extension besteht aus einer Auflistung (z.B. 'htm'|'html')
		 *			Eine in der URL gefundene Extension muss auch im 
		 *        	vorgegbenen Array gefunden werden, so wird sie abgeschnitten,
		 *			ansonsten bleibt sie Bestandteil des Controllers
		 */
		if( is_array($this->urlRules) 
		|| 	isset($this->urlRules[0]['extensions']))
		{
			// Returns information about a file path
			$pathInfoOfController = pathinfo($this->appController);
			
			// find extension in pathinfo
			if(array_key_exists('extension',$pathInfoOfController))
			{
				/*
				 * a.) all extension are allowed
				 */
				if(in_array('all',$this->urlRules[0]['extensions'])
				|| in_array('ALL',$this->urlRules[0]['extensions'])
				)
				{			
					$this->appController = $pathInfoOfController['filename'];			 	
				}	
				else
				/*
				 * b.) Filter of Extension ... only certain extension are permitted
				 */
				if( ! in_array('all',$this->urlRules[0]['extensions']) 
				 || ! in_array('ALL',$this->urlRules[0]['extensions']) 
			    )
				{			
					// if customer extension in urlRules ?
					if(in_array($pathInfoOfController['extension'],$this->urlRules[0]['extensions']))
					{
						$this->appController = $pathInfoOfController['filename'];			 	
					}	
				}
			}
		}		

		/*
		 * USD (Unity Screen Design ? )
		 */
		if($this->registry->routerUnity === true){
			$this->appController .= $this->NameOfScreen;
		} 

		/*
		 * Who is my Action ?
		 */
		if($this->registry->countArguments >= 2  && $this->registry->routerUnity === false){

			switch($this->controllerPosition)
			{
				case 'first' : { $this->appAction = $this->getRoutingParam($routeParam,1); break; }
				case 'last'  : { $this->appAction = $this->getRoutingParam($routeParam,$this->registry->countArguments-2); break; }
				default      : { $this->appAction = $this->registry->standardAction; break;}
			}	
		}

		/*
		 * Who is my Action with "unity screen design"
		 */
		if($this->registry->countArguments >= 2 && $this->registry->routerUnity === true){

			switch($this->controllerPosition)
			{			 
				case 'first' : { $this->appAction = $this->getRoutingParam($routeParam,2); break; }				
				case 'last'  : { $this->appAction = $this->getRoutingParam($routeParam,$this->registry->countArguments-3); break; }
				default      : { $this->appAction = $this->registry->standardAction; break;}
			}	
		}

		/*
		 * Action is empty default set
		 */
		if(empty($this->appAction)){
			$this->appAction = $this->registry->standardAction;
		}		

		/*
		 * Interface to FLRP (FLOWLite Router Protocol)
		 */
		$this->NameOfController = $this->appController;
        $this->NameOfAction     = $this->appAction;
	}

	/**
	 * @access public
	 * router for controller and action
	 * 
	 */  
	public function getRoute($route) {

		$route = strtoupper($route);

		/*
		 * is Ajax ?		
		 *
		 * Routing ajax, if ac variable aviable, else url_rewrite
		 */
		$this->request = $this->objectManager->getObject('Request');

		if($this->request->isAjax() || $this->request->isObligatoryAjax()){
		 
		 	$ac = $this->request->getGet('ac');
		 	
		 	if(!empty($ac)){
				$route = 'AJAX';	
			}
			else
				$route = 'URL_REWRITE';	
		}

		/*
		 * Routing 
		 */
		switch($route){
       
        /*
         * AJAX
         * @controller
         * @action
         */
        case 'AJAX': { $this->route_AJAX();  break; }

        /*
         * UL_REWRITE (URI)
         * @controller
         * @action
         */
         case 'URL_REWRITE' :  { $this->route_REWRITE();  break;  }                  

       /*
         * USD - Unity Screen Design
         * @unity
         * @screen
         * @action
         */
        case 'STANDARD': { 
		 
		 		if($this->registry->routerUsd == true)
				 {
					 $this->route_USD();  
					 break; 
				}
				else
				{
					 $this->route_REWRITE();  
					 break; 
				}	 
		}
 
        /*
         * Default
         * @controller
         * @action
         */
	     default: {
              $this->NameOfController = $this->registry->standardController;
              $this->NameOfAction     = $this->registry->standardAction;  
		  	  break;                       
         }
		}
#echo      $this->NameOfController;
#echo 	    $this->NameOfAction;
		/*
	     * @flrp (FLOWLite Router Protocol)
	     */
		$this->flrp = $this->objectManager->getObject('flrp');
		
		// USD (Unity Screen Design) ?
		if($this->registry->routerUsd === true)
		{
			// set unity
			$this->flrp->setUnity($this->getNameOfUnity());

			// set screen
			$this->flrp->setScreen($this->NameOfScreen);
		}
	
		// set controller
		$this->flrp->setController($this->NameOfController);

		// set action
		$this->flrp->setAction($this->NameOfAction);
	} 
}
?>