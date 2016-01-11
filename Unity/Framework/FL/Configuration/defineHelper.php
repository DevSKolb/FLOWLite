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
 * General define params
 *
 * DISLABS_OS	
 * DISLABS_OS_EXT
 * DISLABS_IS_WINDOWS
 * $HTTP_USER_AGENT
 * DISLABS_USER_OS
 * DISLABS_BROWSER_VERSION
 * DISLABS_BROWSER_AGENT
 * DISLABS_PHP_VER
 * DISLABS_PHP_SAFEMODE
 * DISLABS_PHP_MAXEXECUTION
 * DISLABS_PHP_MQ_GPC
 * DISLABS_PHP_EXTENSIONS
 * DISLABS_PHP_RAM
 * DISLABS_PHP_DOCROOT
 * DISLABS_PHP_SCRIPTROOT
 *
 */

		define('ERRLOG_DISPLAY',1050);
		define('ERRLOG_FILE',1060);
		define('DB_ERR_CONNECT',900901);

		if (!defined('DISLABS_OS')) 		
			define('DISLABS_OS', PHP_OS); 
		if (!defined('DISLABS_OS_EXT')) 	
			define('DISLABS_OS_EXT', php_uname()); 
		if (!defined('DISLABS_IS_WINDOWS')) { 
		    if (stristr(PHP_OS, 'win')) { 
		        define('DISLABS_IS_WINDOWS', 1); 
		    } else { 
		        define('DISLABS_IS_WINDOWS', 0); 
		    } 
		}

		// User Agent
		if (!defined('DISLABS_USER_OS')) 
		{ 
	    if (!empty($_SERVER['HTTP_USER_AGENT'])) { 
	        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT']; 
	    } else if (!isset($HTTP_USER_AGENT)) { 
	        $HTTP_USER_AGENT = ''; 
	    } 

	    // Betriebssystem 
	    if (strstr($HTTP_USER_AGENT, 'Win')) { 
	        define('DISLABS_USER_OS', 'Win'); 
	    } else if (strstr($HTTP_USER_AGENT, 'Mac')) { 
	        define('DISLABS_USER_OS', 'Mac'); 
	    } else if (strstr($HTTP_USER_AGENT, 'Linux')) { 
	        define('DISLABS_USER_OS', 'Linux'); 
	    } else if (strstr($HTTP_USER_AGENT, 'Unix')) { 
	        define('DISLABS_USER_OS', 'Unix'); 
	    } else if (strstr($HTTP_USER_AGENT, 'OS/2')) { 
	        define('DISLABS_USER_OS', 'OS/2'); 
	    } else { 
	        define('DISLABS_USER_OS', 'Other'); 
    	} 
		
	    // Browser und Browserversion
	    if (preg_match('@Opera(/| )([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) { 
	        define('DISLABS_BROWSER_VERSION', $log_version[2]); 
	        define('DISLABS_BROWSER_AGENT', 'OPERA'); 
	    } else if (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) { 
	        define('DISLABS_BROWSER_VERSION', $log_version[1]); 
	        define('DISLABS_BROWSER_AGENT', 'IE'); 
	    } else if (preg_match('@OmniWeb/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) { 
	        define('DISLABS_BROWSER_VERSION', $log_version[1]); 
	        define('DISLABS_BROWSER_AGENT', 'OMNIWEB'); 
	    } else if (preg_match('@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version)) { 
	        define('DISLABS_BROWSER_VERSION', $log_version[2]); 
	        define('DISLABS_BROWSER_AGENT', 'KONQUEROR'); 
	    } else if (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version) 
	               && preg_match('@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2)) { 
	        define('DISLABS_BROWSER_VERSION', $log_version[1] . '.' . $log_version2[1]); 
	        define('DISLABS_BROWSER_AGENT', 'SAFARI'); 
	    } else if (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) { 
	        define('DISLABS_BROWSER_VERSION', $log_version[1]); 
	        define('DISLABS_BROWSER_AGENT', 'MOZILLA'); 
	    } else { 
	        define('DISLABS_BROWSER_VERSION', 0); 
	        define('DISLABS_BROWSER_AGENT', 'OTHER'); 
	    }		
	
		}
		
		//PHP-Infos
		
		// PHP Version
		if (!defined('DISLABS_PHP_VER')) 		  
			define('DISLABS_PHP_VER', PHP_VERSION); 
			
		// PHP Safe Mode
		if (!defined('DISLABS_PHP_SAFEMODE')) 	  
			define('DISLABS_PHP_SAFEMODE',ini_get("safe_mode"));
			
		// PHP Maximal 
		if (!defined('DISLABS_PHP_MAXEXECUTION')) 
			define('DISLABS_PHP_MAXEXECUTION',ini_get("max_execution_time"));
			
		// PHP Magic Quotes
		if (!defined('DISLABS_PHP_MQ_GPC')) 
			define('DISLABS_PHP_MQ_GPC',ini_get("magic_quotes_gpc"));
			
		// PHP PHP Extensions
		if (!defined('DISLABS_PHP_EXTENSIONS')) 
			define('DISLABS_PHP_EXTENSIONS',implode(" ",get_loaded_extensions()));
			
		// PHP Ram Memory
		if (!defined('DISLABS_PHP_RAM')) 
			define('DISLABS_PHP_RAM',str_replace("M","",get_cfg_var("memory_limit")));

		// PHP doc path
		if (!defined('DISLABS_PHP_DOCROOT')) 
		  	define('DISLABS_PHP_DOCROOT', preg_replace("/[A-Z]{1}\:/is","",str_replace("\\","/",$_SERVER['DOCUMENT_ROOT'])));

		// PHP script path
		if (!defined('DISLABS_PHP_SCRIPTROOT')) 
		  define('DISLABS_PHP_SCRIPTROOT', preg_replace("/[A-Z]{1}\:/is","",str_replace("\\","/",realpath('./')))); 
?>