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
 * General central core FLOWLite bootstrap class
 */
final class xjBootstrap {

	/**
	 * Instance of Configuration
	 */
	protected $configuration;

	/**
	 * Instance of objectManager
	 */
	protected $objectManager;

	/**
	 * Instance of objectFactory
	 */
	protected $objectFactory;

	/**
	 * Instance of classLoader
	 */
	protected $classLoader;

	/**
	 * Instance of signalSlotDispatcher
	 */
#	protected $signalSlotDispatcher;

	/**
	 * Instance of Exception Handler
	 */
	protected $exceptionHandler;

	/**
	 * Instance of Cache
	 */
    protected $cache;

	/**
	 * Instance of Registry
	 */
    protected $registry;

	/**
	 * Arguments
	 */
	public $arguments = array();

	/**
	 * Instance of Objects
	 */
    protected $objects;
  
	/**
	 * Instance of Request
	 */
    private static $request  = null;

	/**
	 * Instance of Response
	 */
    private static $response = null;

	/**
	 * boolean ResetFrameworkCache 
	 */
    protected $ResetFrameworkCache = true;
  
	/**
	 * Instance of Session
	 */ 
  	private $session;

	/**
	 * Instance of Session
	 */ 
	private $auth;
  	
	/**
	 * Instance of Debug
	 */ 
	private $debug;

	/**
	 * Database object
	 */
	protected $Database;
	
	/**
	 * Constructor
	 * -----------
	 * Output Puffer ON
	 * not alreday header send
	 */
	public function __construct(){

		ob_start();
		
		$this->defineConstants();
  	}

	/**
	 * Initializes DEFINE
	 *
	 * @see run()
	 */
	private static function defineConstants() {
	
		error_reporting(E_ALL);		
		
	}
		
	/**
	 * Initializes all necessary FLOWLite objects 
	 *
	 * @see run()
	 */
	public function initialize() {


 		$this->initializeApplication();
 		$this->initializeSystem();
 		$this->initializeClassLoader();
		$this->initializeFrameworkNamespace(); 	

		$this->initializeExceptions();
		$this->initializeErrorHandling();
		$this->initializeObjectManager();
        $this->initializeConfiguration();

 		$this->initializeProtocol();
		$this->initializeRegistry();
		$this->initializeLocale();
        $this->initializeTrace();

		$this->initializeRepeater();

        $this->initializeNamespace(); 	

		$this->initializeCache();		
		$this->initializeSession();      		

 		$this->initializeORM();
		$this->initializeDatabase();
 		$this->initializeShutdown();
		

	}

    /**
	 * Initializes the actually application
	 * where is this ?
	 *
	 * @return void
	 */
		private function initializeApplication() {

			$doc_root = $_SERVER["DOCUMENT_ROOT"];
			$api_root = dirname(trim($_SERVER["SCRIPT_NAME"]));

			// path, classes and unity
			define('FL_APPL_CLASSES'  ,  $doc_root . $api_root );
			define('FL_APPL_PATH'     ,  $doc_root . $api_root .'/');
			define('FL_PATH_CACHE'    ,  $doc_root . $api_root .'/Cache/');
			define('FL_PATH_TO_UNITY' ,  $doc_root . $api_root .'/Unity/');

			define('FL_CONTROL'       ,  'AUTO');
			
			if ( ! defined('TRACE_ON')) {
				define('TRACE_ON'	      ,  false);
			}	
			// trace app
			if ( ! defined('FL_TRACE')) {
				define('FL_TRACE'	      ,  false);
			}	

			// dev or prod
			if ( ! defined('FL_MODE')) {
				define('FL_MODE'	      ,  'DEV');
			}	

			// trace framework
			if ( ! defined('TRACE_SYSTEM')) {
				define('TRACE_SYSTEM'	  ,  false);
			}	
		}

    /**
	 * Initializes the system:
	 * - Disable magic quotes at runtime
	 * - Disable register_globals at runtime
	 * - Disable safe_mode at runtime
	 *
	 * @return void
	 */
		private function initializeSystem() {

			 // Disable magic quotes at runtime. 			   
			   	ini_set("magic_quotes_runtime", 0);
			
			 // Disable register_globals at runtime. 			   			   
				ini_set("register_globals","off");

			 // Disable safe_mode at runtime. 			   			   
				ini_set('safe_mode',FALSE);
		}


    /**
	 * Initializes the class loader
	 *
	 * @return void
	 */
		private function initializeClassLoader() {

	        if (!class_exists( FL_PATH_CLASSES . '/Resources/ClassAutoloader.php', FALSE)) {
				      require( FL_PATH_CLASSES . '/Resources/ClassAutoloader.php');

	            ClassAutoloader::register();  
    	    }
		}
 
     /**
	 * Initializes the namespace of framework
	 *
	 * @return void
	 */
		private function initializeFrameworkNamespace(){   

             if (!class_exists( FL_PATH_CLASSES . '/Resources/NameSpaces.php', FALSE)) {
			           require( FL_PATH_CLASSES . '/Resources/NameSpaces.php');           
             }      
             if (!class_exists( FL_PATH_CLASSES . '/Resources/ResourcesNameSpaces.php', FALSE)) {
			           require( FL_PATH_CLASSES . '/Resources/ResourcesNameSpaces.php');           
             }      
		 	 if (!class_exists( FL_PATH_CLASSES . '/Cache/Cache.php', FALSE)) {
			 	       require( FL_PATH_CLASSES . '/Cache/Cache.php');           
             }      

			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:FrameWork:eac257e56aec1';

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			||   $this->ResetFrameworkCache === true 
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object(ResourcesNameSpaces::getNamespaces());

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_Framework',$aStaticUserData);
		}
	
    /**
	 * Manage the namespace of application
	 *
	 * @return void
	 */
		private function initializeNamespace(){   

			/*
			 * USD (Unity Screen Design)
			 *
			 * @autor Silvan Kolb
			 *
			 * @ no url rewrite (none)
			 * @ usd active     (true)
			 * @ method post 
			 */
	         if(    strtoupper($this->registry->routerRouting) == 'STANDARD'
			     && $this->registry->routerUsd == true
			   )
			 {          
           		$this->initializeApplicationNamespaceWithoutUnity();
           		$this->initializeApplicationUnityNamespace();
        	 } 
			 else
			/*
			 * URL Rewrite
			 *
			 * @method get
			 */
        	 if($this->registry->routerRouting == 'URL_REWRITE')
			 { 
				$this->registry->routerUnity = false;
        		
				if($this->registry->routerUnity == true)
				{
           			$this->initializeApplicationNamespaceWithoutUnity();
           			$this->initializeApplicationUnityNamespaceURLRewrite();
            	}
            	else
            	{	 
      		        $this->initializeApplicationNamespaceNoUnity(); 
                }       
			  }	
			  else
            	{	 
      		        $this->initializeApplicationNamespaceNoUnity(); 
                } 			
            
        } 

    /**
	 * Initializes the namespace of Application
	 *
	 * @return void
	 */
		private function initializeApplicationNamespace(){   

			if(FL_MODE === 'PROD'){
			
			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:Application:eac257e56aec1';

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			||   $this->ResetFrameworkCache === true 
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object( ResourcesNameSpaces::getNamespaces( FL_APPL_CLASSES, true  ));

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_Application',$aStaticUserData);

		 } else
             // namespace of the complete application
   	         NameSpaces::setNamespaceToObject('NSP_Application',
			 			 ResourcesNameSpaces::getNamespaces( FL_APPL_CLASSES, true  ));
        } 

    /**
	 * Initializes the namespace of Application
	 *
	 * @return void
	 */
		private function initializeApplicationNamespaceNoUnity(){   

			if(FL_MODE === 'PROD'){
#echo "JA";
			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:NoUnity:eac257e56aec210';

#			$aStaticUserData = $oCache->readCache($sCacheName);

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object(ResourcesNameSpaces::getNamespaces( FL_APPL_CLASSES, true , array('Unity') ));

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_Application',$aStaticUserData);

			} else
			{
             NameSpaces::setNamespaceToObject('NSP_Application',
			 			 ResourcesNameSpaces::getNamespaces( FL_APPL_CLASSES, true , array('Unity') ));		 			 

#print_r(NameSpaces::$NSP_Application);



			}


        } 

    /**
	 * Initializes the namespace of Application
	 *
	 * @return void
	 */
         private function initializeApplicationNamespaceWithoutUnity(){   

			if(FL_MODE === 'PROD'){

			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:AppOnly:eac257e56aec2';

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			||   $this->ResetFrameworkCache === true 
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object(ResourcesNameSpaces::getNamespaces( FL_APPL_PATH, true , array('Unity') ));

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_ApplicationOnly',$aStaticUserData);

			} else
             NameSpaces::setNamespaceToObject('NSP_ApplicationOnly',
			 			 ResourcesNameSpaces::getNamespaces( FL_APPL_PATH, true , array('Unity') ));		 			 
         } 

   /**
	 * Initializes the namespace of Application 
	 * Unity Screen Concept (USD)
	 *
	 * @return void
	 */
         private function initializeApplicationUnityNamespace(){   

			  // init namespaces
			  Namespaces::destroyNSPApplication('NSP_Application');

              // Request Object
              $req = $this->objectManager->getObject('Request');                          

              // Hidden Field of Unity 
              $FL_APPL_UNITY = $req->getPost($this->registry->hiddenfieldsUnity);

			  // if KAY then GET (Ajax)
			  if($req->getGet('kay')=='GMPXMJUFHPFTBKBY' && empty($FL_APPL_UNITY))
			  {
	              // Hidden Field of Unity
					$FL_APPL_UNITY = $req->getGet('unity');              
			  }	

              // Validate value of hidden field 
              $Validate = $this->objectManager->getObject('StringValidator');                          
              
        	  // Pfad zur Unity
			  $FL_APPL_SCAN  = FL_PATH_TO_UNITY . $FL_APPL_UNITY;

              // Pfad OK
              if(isset($FL_APPL_UNITY) && $Validate->isValid($FL_APPL_UNITY)){

			if(FL_MODE === 'PROD'){

			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:AppOnlyScan:eac257e56aec2';

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			||   $this->ResetFrameworkCache === true 
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object(ResourcesNameSpaces::getNamespaces( $FL_APPL_SCAN, true  ));

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_Application',$aStaticUserData);

			} else
		           // Namespace der Unity
				   NameSpaces::setNamespaceToObject('NSP_Application',
				               ResourcesNameSpaces::getNamespaces( $FL_APPL_SCAN, true  ));
  		 	  } 
	 	      else
	 	      {
                   // Standard Unity
				   $FL_APPL_SCAN  = FL_PATH_TO_UNITY . $this->registry->standardUnity . '/';


			if(FL_MODE === 'PROD'){

			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:AppOnlyScan:eac257e56aec7';

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			||   $this->ResetFrameworkCache === true 
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object(ResourcesNameSpaces::getNamespaces( $FL_APPL_SCAN, true  ));		 

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_Application',$aStaticUserData);

			} else
                   // Namespace der Standard Unity
              	   NameSpaces::setNamespaceToObject('NSP_Application',
				 			   ResourcesNameSpaces::getNamespaces( $FL_APPL_SCAN, true  ));		 	   
				 			   
	 	      }

				$this->unity = $FL_APPL_UNITY;
         } 
    /**
	 * Initializes the namespace of Application 
	 * URL Rewriting (Unity Concept)
	 *
	 * @return void
	 */
		private function initializeApplicationUnityNamespaceURLRewrite(){  

			$requestURI = explode('/', $_SERVER['REQUEST_URI']);
	  		$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

			$CountOfURI = count($requestURI);
	
			$ApplicationName = $scriptName[(count($scriptName)-2)];

		    $ApplicationNamePosition = array_search($ApplicationName,$requestURI);

		    $UnityName = '';

		    // Name of Unity
		    if($CountOfURI>=$ApplicationNamePosition+2){    
		      if(isset($requestURI[$ApplicationNamePosition+2])){
		         $UnityName = $requestURI[$ApplicationNamePosition+2];
		      } 

				// Standard Unity
				$FL_APPL_SCAN  = FL_PATH_TO_UNITY . $UnityName . '/';
		    } 

		    // if not unity => default
		    if(empty($UnityName) || $CountOfURI<$ApplicationNamePosition+1){    
		       $FLAG_EMPTY_UNITY = true;
		    }   
		    else

{
			if(FL_MODE === 'PROD'){

			// Cache Object
			$oCache = new Cache( FL_PATH_CACHE );

			// FileName with sha1 
			$sCacheName = 'FlexiNSP:AppOnlyScan:eac257e55aec2';

			// Daten in Cache ?
			if( ($aStaticUserData = $oCache->readCache($sCacheName)) === false
			||   $this->ResetFrameworkCache === true 
			) 
			{
				// Namespace from Framework to Object
    			$aStaticUserData = NameSpaces::array2Object(ResourcesNameSpaces::getNamespaces( $FL_APPL_SCAN, true  ));		 	   

				// Object of Namespace in Cache (serialize) one year
			    $oCache->writeCache($sCacheName, $aStaticUserData, (60 * 60 * 24 * 365));
			 }

			// Namespace registry
			NameSpaces::setNamespaceObject('NSP_Application',$aStaticUserData);

			} else

			// Namespace der Standard Unity
            NameSpaces::setNamespaceToObject('NSP_Application',
					   ResourcesNameSpaces::getNamespaces( $FL_APPL_SCAN, true  ));		 	   


}
        }


    /**
	 * Initializes the Object Manager
	 *
	 * @return void
	 */
         private function initializeObjectManager(){   
            $this->objectManager = ObjectManager::getInstance();               
         } 

    /**
	 * Initializes the Exceptions
	 *
	 * @return void
	 */
         private function initializeExceptions(){   
              set_exception_handler(array("FLOWLiteException", "getStaticException"));                
         } 

    /**
	 * Initializes the Error handling
	 *
	 * @return void
	 */
		private function initializeErrorHandling(){   
    		set_error_handler(array("FLOWLiteErrorHandling","ErrorHandling"));              
    	} 	
                             	
    /**
	 * Initializes the Configuration XML
	 *
	 * @return void
	 */
		private function initializeConfiguration(){                          
	
			// instance of configuration class
			$this->configuration = $this->objectManager->getObject('Configuration');                          
	
			// set path to config.xml file of framework
	        $this->configuration->setConfig(FL_PATH_XML);
	
			// set path to config.xml file of application
	        $this->configuration->setConfig(dirname($_SERVER["SCRIPT_FILENAME"]) . '/' .'Configuration/config.xml');
		} 	

    /**
	 * Initializes the Registry
	 *
	 * @return void
	 */
	    private function initializeRegistry(){   
				$this->registry = $this->objectManager->getObject('Registry');
	    } 		

    /**
	 * Initializes the Trace debugger
	 *
	 * @return void
	 */
         private function initializeTrace(){   
              
			$this->debug = $this->objectManager->getObject('Debug'); 

			if(TRACE_SYSTEM){

				$this->debug->trace('***** Start Application ','FLOWLite');
				$this->debug->trace('INIT System','Bootstrap');
				$this->debug->trace('INIT ClassLoader','Bootstrap');
				$this->debug->trace('INIT FrameworkNamespace','Bootstrap');
				$this->debug->trace('INIT Exceptions','Bootstrap');
				$this->debug->trace('INIT ErrorHandling','Bootstrap');
				$this->debug->trace('INIT ObjectManager','Bootstrap');
				$this->debug->trace('INIT Configuration','Bootstrap');
				$this->debug->trace('INIT Protocol','Bootstrap');
				$this->debug->trace('INIT Registry','Bootstrap');
				
			}	
         } 

    /**
	 * Initializes FrontControllerRepeater
	 *
	 * @set boolean false
	 */
	    private function initializeRepeater(){   
				$this->registry->SystemFrontControllerRepeater = false;
	    } 		

    /**
	 * Initializes the Security
	 * Security check
	 *
	 * @return void
	 */
	    private function initializeSecurity(){   

		// Request instance
	       $request = $this->objectManager->getObject('Request');

		// Security check
    	   $security = $this->objectManager->getObject('SecurityManager');
       	   $security->run();
		}

    /**
	 * Initializes the Cache by use, auto cleanup
	 *
	 * @return void
	 */
		private function initializeCache(){ 
		  
	  		// Trace
			$this->debug->trace('INIT Cache System','Bootstrap'); 

			// Cache init
    		if($this->registry->cacheUse === true){
        		$this->cache = $this->objectManager->getObject('Cache');
	            $this->cacheCleanCounts = $this->cache->cleanUpCache();
			}   
    	} 	

    /**
	 * Initializes the Session
	 *
	 * @return void
	 */
	private function initializeSession()
	{ 
    	// Sollen Sessions benutzt werden ?
		if($this->registry->sessionUse)
		{
         	// SESSION starten
			$this->session = $this->objectManager->getObject('Session')->start();	

			 if ( ! isset($_SESSION['active']) )  {
			  	throw new Exception('Session was terminated !',10310511201); }
	
	  		// Trace
 			$this->debug->trace('started normal session system','Bootstrap'); 
		}   
   	} 	

	/**
	 * init ORM
	 * DBScan
	 *
	 * @return void
	 */
		private function initializeORM(){   
		    NameSpaces::setNamespaceToObject('NSP_ORM',ResourcesNameSpaces::getNamespaces( FL_PATH_ORM, true  ));        
    	}

	/**
	 * init FLOWLite router Protocol (FLRP)
	 *
	 * @return void
	 */
		private function initializeProtocol()
		{   
			// FLRP - FLOWLite Router Protocol
        	$flrp = $this->objectManager->getObject('flrp');			
    	}

	/**
	 * init database access point
	 *
	 * @return void
	 */
		private function initializeDatabase()
		{
			if($this->registry->databaseAutoconnect == true){	
        		$this->database = $this->objectManager->getObject('Database');			
        		$this->database->connect();
        	}	
    	}

	/**
	 * @init initializeLocale
	 *
	 * @return void
	 */
		 private function initializeLocale(){   
	
			// sets the default timezone used by all date/time functions
			Locale::setTimezone($this->registry->localeTimezone);  
			
			// sets local LC_ALL 
			$LanguageForLocale = strtolower($this->registry->localeLanguage);

			// Content negotiation, if local language 'auto'
			if($LanguageForLocale == 'auto')
			{
			 	$this->registry->localeLanguage = BrowserLanguage::get(array ('de', 'en'), 'en', null, false);			 	 
            }
			// set locale LC_ALL			 
			Locale::setLocale_LC_ALL($this->registry->localeLanguage);	
		}

	/**
	 * Last function 
	 * Destroy all Instances objects incl. error and exception
	 *
	 * @return void
	 */
		private function initializeShutdown(){   
    		register_shutdown_function( array("GarbageCollector","destroyAllObjects") );
    	}
  
	/**
	 * Runs the the FLOWLite FrontController
	 *
	 * @return void
	 */
	public function run(){

		// start front controller
		$FrontController = $this->objectManager->getObject('xjFrontController');
   	    $FrontController->run();

	}
}
?>