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
class Request
{
    /**
     * POST
     *
     * An associative array of variables passed to the 
	 * current script via the HTTP POST method 
     *
     * @var    array
     */
	private $post;
	
    /**
     * GET
     *
     * An associative array of variables passed to the current 
	 * script via the URL parameters
     *
     * @var    array
     */
	private $get;

    /**
     * COOKIE
     *
     * An associative array of variables passed to the 
	 * current script via HTTP Cookies
     *
     * @var    array
     */
	private $cookie;

    /**
     * FILE
     *
     * An associative array of items uploaded to the 
	 * current script via the HTTP POST method
     *
     * @var    array
     */
	private $file;

    /**
     * HEADER
     *
     * An associative array of variables 
	 * extracted from server start HTTP_
     *
     * @var    array
     */
	private $header;

    /**
     * SERVER
     *
     * an array containing information such as 
	 * headers, paths, and script locations
     *
     * @var    array
     */
	private $server;
 
    /**
     * GET & POST
     *
     * Concentration of GET and POST
     *
     * @var    array
     */
	private $gp;

    /**
     * SESSION
     *
     * @var    array
     */
	private $session;

    /**
     * user authentification 
     *
     * @var    user (string)
     * @var    pass (string)
     */
	private $auth;

	private $method;

	private $put = false;
	
	private $url;

	private $baseUrl;
	
	private $scriptFile;
	
	private $port;
	
	private $hostInfo;

	private $preferredLanguage;

	private $requestUri;

	private $scriptUrl = null;

	private $authUser;
				
	private $authPass;

	private $writeSecurity;
	
	private $slash = '/';

    /**
     * USA Adapter
     *
     * @U :: Unity
     * @S :: Screen
     * @A :: Action
     */
	private $usaAdapter = array();
	
    /**
     * Constructor
     *
     * @return void
     */
	private function initData(){

    	foreach($_SERVER as $key => $value){
	      if(substr($key, 0, 5)== "HTTP_"){
	        $key = strtolower($key);                 
	        $this->header[substr($key,5)] = $value;  
	      }      
	    } 
    
		if(isset($_SERVER["PHP_AUTH_USER"]))
		{
      		$this->auth["user"] = $_SERVER["PHP_AUTH_USER"];
	        $this->auth["pass"] = $_SERVER["PHP_AUTH_PW"];
	        
	        $this->authUser = $_SERVER["PHP_AUTH_USER"];
	        $this->authPass = $_SERVER["PHP_AUTH_PW"];
    	}
    	else
		{
      		$this->auth = null;
    	}
    	
    	$this->method = strtoupper($this->server['REQUEST_METHOD']);
     }  

    /**
     * Constructor
     *
     * Instance of Request	Init of external data 
     * @return void
     */
	public function __construct(){

			if(isset($_GET))		$this->get 		= &$_GET;
			if(isset($_POST))		$this->post 	= &$_POST;
			if(isset($_COOKIE))		$this->cookie 	= &$_COOKIE;
			if(isset($_FILES))		$this->file 	= &$_FILES;
			if(isset($_SERVER))		$this->server 	= &$_SERVER;
			if(isset($_SESSION))	$this->session 	= &$_SESSION;

			if(isset($_GET) && isset($_POST)){			
	   		    $this->params  	=   array_merge( $this->get, $this->post);
	   		}    

	      	$this->initData();
  	}
  
	/**
	 * Strips slashes from input data.
	 * This method is applied when magic quotes is enabled.
	 * @param mixed input data to be processed
	 * @return mixed processed data
	 */
/*
	public function stripSlashes(&$data)
	{
		return is_array( $data ) ? array_map( array( $this,'stripSlashes' ), $data )
								 : stripslashes( $data );
	}

*/

	/**
	 * Returns the named GET or POST parameter value.
	 * If the GET or POST parameter does not exist, the second parameter to this method will be returned.
	 * If both GET and POST contains such a named parameter, the GET parameter takes precedence.
	 */
	public function getParam($key,$defaultValue=null)
	{
		return isset($this->get[$key]) ? $this->get[$name] 
					: (isset($this->post[$key]) ? $this->post[$key] : $defaultValue);
	}

	/**
	 * Returns the named GET parameter value.
	 * If the GET parameter does not exist, the second parameter to this method will be returned.
	 * @param string the GET parameter name
	 */
	public function getQuery($key,$defaultValue=null)
	{
		return isset($this->get[$key]) ? $this->get[$key] : $defaultValue;
	}

	/**
	 * Returns the named POST parameter value.
	 * If the POST parameter does not exist, the second parameter to this method will be returned.
	 */
	public function getPost($key,$defaultValue=null)
	{
		return isset($this->post[$key]) ? $this->post[$key] : $defaultValue;
	}

	/**
	 * @return string part of the request URL that is after the question mark
	 */
	public function getQueryString()
	{
		return isset($this->server['QUERY_STRING']) ? $this->server['QUERY_STRING'] : '';
	}
	
			  
    /**
     * Clone
     *
     * protected for clone
     * @return void
     */
  	private function __clone() {}

    /**
     * @return void
     */
	public function getAuthData()
	{
    	return $this->auth;
	}
  
    /**
     * @return void
     */
	public function issetHeader($key)
  	{
    	 $key = strtolower($key);
	     return (isset($this->header[$key]));
    }
  
    /**
     * @return void
     */
	public function getHeader($key)
    {
    	$key = strtolower($key);
	    if($this->issetHeader($key))
	    {
	    	return $this->header[$key];
	    }
    	return null;
    }
    
    /**
     * validate issetGet
     *
     * @param $key (string)
     *
     * @return true/false
     */
	public function issetGet($key)
    {
    	return (isset($this->get[$key]));
    }
  
    /**
     * public getGet
     *
     * param $key (string)
     *
     * @return post data
     * @return null
     */
	public function getGet($key)
    {
    	if($this->issetGet($key))
    	{
      		return $this->get[$key];
    	}
    	return false;
    }
  
	public function setGet($key,$value)
    {
    	if($this->issetGet($key))
    	{
      		$this->get[$key] = $value;
    	}
    }


    
    /**
     * validate issetGet
     *
     * @param $key (string)
     *
     * @return true/false
     */
	private function issetSession($key)
    {
    	return (isset($this->session[$key]));
    }
	    /**
     * public getGet
     *
     * param $key (string)
     *
     * @return post data
     * @return null
     */
	public function getSession($key)
    {
    	if($this->issetSession($key))
    	{
      		return $this->session[$key];
    	}
    	return null;
    }
  
    /**
     * validate issetPost
     *
     * @param $key (string)
     *
     * @return true/false
     */
	public function issetPost($key)
    {
    	return (isset($this->post[$key]));
    }
  

    /**
     * public getPost
     *
     * @param $key (string) 
     *
     * @return void
     */
	public function setPost($key,$value,$hash)
    {
 	if($hash == 'f0dd00aae5d2aeb141b984566f3101558ee87cd8' 
		   && isset($key)
		   && isset($value)
		   && $this->isWriteSecurity()
		   )
	   		$this->post[$key] = $value;

 		else return false;
    }

    /**
     * public getPost
     */
	public function issetArgument($key){
		return (isset($this->gp[$key]));
    }
  
    /**
     * public getPost
     */
	public function getArgument($key){
    	if($this->issetArgument($key)){
      		return $this->gp[$key];
    	}
    	return null;
    }

    /**
     * public getPost
     */ 
	public function issetFile($key){
		return (isset($this->file[$key]));
    }
  
    /**
     * public getPost
     */
	public function getFile($key){
    	if($this->issetFile($key)){
      		return $this->file[$key];
    	}
    	return null;
  	}

    /**
     * public getPost
     */  
  	public function issetCookie($key){
    	return (isset($this->cookie[$key]));
  	}
  
    /**
     * public getPost
     */
	public function getCookie($key){
    	if($this->issetCookie($key)){
      		return $this->cookie[$key];
    	}
    	return null;
  	}

	public function getRequestUri()
	{
		if($this->requestUri===null)
		{
			if(isset($this->server['REQUEST_URI'])){
				$this->requestUri = $this->server['REQUEST_URI'];
			}
			else if(isset($this->server['HTTP_X_REWRITE_URL'])) {
				$this->requestUri = $this->server['HTTP_X_REWRITE_URL'];
			}
			else if(isset($this->server['ORIG_PATH_INFO']))  
			{
				$this->requestUri = $this->server['ORIG_PATH_INFO'];
				$er = $this->getQueryString();
				if(!empty($er))
					$this->requestUri .= '?'.$this->getQueryString();
			}
			else
			trigger_error('Request has not a valid request URI.',4002323);
		}

		if(strpos($this->requestUri,$this->server['HTTP_HOST'])!==false)
				$this->requestUri = preg_replace('/^\w+:\/\/[^\/]+/','',$this->requestUri);

		return $this->requestUri;
	}

	public function getUrl()
	{
		if($this->_url!==null)
			return $this->_url;
		else
		{
			if(isset($_SERVER['REQUEST_URI']))
				$this->_url=$_SERVER['REQUEST_URI'];
			
			return $this->_url;
		}
	}
	
    /**
     * public getClientIP
     */
	public function getClientIP(){

		// Static function (/Utilities/Helper/IP)
		return IP::getClientIP();
  	}

    /**
     * public getReferrer
     */
	public function getReferrer(){

		$referrer = false;

		if(getenv("HTTP_REFERER")){
			$referrer = getenv("HTTP_REFERER");
			
		} elseif($this->server['HTTP_REFERER']){	
			$referrer = $this->server['HTTP_REFERER'];
		}

		return $referrer;
	}


    /**
     * public hostName
     */
	public function hostInfo()
	{
		if($this->hostInfo===null)
		{
			if($secure=$this->getIsSecureConnection())
				$http='https';
			else
				$http='http';
				
			if(isset($_SERVER['HTTP_HOST']))
				$this->hostInfo=$http.'://'.$_SERVER['HTTP_HOST'];
			else
			{
				$this->hostInfo=$http.'://'.$this->hostName();
				
				$port=$secure ? $this->getSecurePort() : $this->getPort();
				if(($port!==80 && !$secure) || ($port!==443 && $secure))
					$this->hostInfo.=':'.$port;
			}
		}
		return $this->hostInfo;	 
	}

    /**
     * public hostName
     */
	public function hostName()
	{
		return (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : 'localhost';
	}


	/**
	 * Returns the relative URL for the application.
	 * This is similar to {@link getScriptUrl scriptUrl} except that
	 * it does not have the script file name, and the ending slashes are stripped off.
	 * @param boolean whether to return an absolute URL. Defaults to false, meaning returning a relative one.
	 * This parameter has been available since 1.0.2.
	 */
	public function getBaseUrlOfApp($absolute=false)
	{
		if($this->baseUrl===null)
			$this->baseUrl=rtrim(dirname($this->getScriptUrl()),'\\/');
			
		return $absolute ? $this->getHostInfo() . $this->baseUrl : $this->baseUrl;
	}

	/*
     * FLOWLite Router getBaseURL
     */
	public function getBaseUrl()
	{
	    // Dateiname des aktuell ausgeführten Skripts, relativ zum Document Root.
	    // @object request
	    $scriptURL = $this->getScriptUrl();

	    // Die folgenden assoziativen array-Elemente werden zurückgegeben: 
		// dirname, basename, extension (falls vorhanden) und filename. 
	    $pathInfo = pathinfo($scriptURL);
	    $dirname  = $pathInfo['dirname'];
 
    	// Der Hostname des Servers, auf dem das aktuelle Skript ausgeführt wird. 
	    $hostName = $this->hostName();

	    // Name und Versionsnummer des verwendeten Übertragungsprotokolls, 
		// mittels dessen die aktuelle Seite aufgerufen wurde, z. B. 'HTTP/1.0' 
    	$protocol = $this->getServerProtocol();

		// output
	    return $protocol . $hostName . $dirname . $this->slash;
	}

	/**
	 * Sets the relative URL for the application.
	 * By default the URL is determined based on the entry script URL.
	 * This setter is provided in case you want to change this behavior.
	 * @param string the relative URL for the application
	 */
	public function setBaseUrl($value)
	{
		$this->baseUrl = $value;
	}

	/**
	 * @return boolean if the request is sent via secure channel (https)
	 */
	public function getIsSecureConnection()
	{
	    if(isset($this->server['HTTPS'])){
		  	if(strcasecmp($this->server['HTTPS'],'on')){
		  		return true; 
		  	}
		}
		return false;  	
	}
	
	public function getScriptUrl()
	{
		if($this->scriptUrl===null)
		{
			$scriptName = basename($_SERVER['SCRIPT_FILENAME']);
			
			if(basename($_SERVER['SCRIPT_NAME'])===$scriptName)
				$this->scriptUrl=$_SERVER['SCRIPT_NAME'];
				
			else if(basename($_SERVER['PHP_SELF'])===$scriptName)
				$this->scriptUrl=$_SERVER['PHP_SELF'];
				
			else if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME'])===$scriptName)
				$this->scriptUrl=$_SERVER['ORIG_SCRIPT_NAME'];
				
			else if(($pos=strpos($_SERVER['PHP_SELF'],'/'.$scriptName))!==false)
				$this->scriptUrl=substr($_SERVER['SCRIPT_NAME'],0,$pos).'/'.$scriptName;

			else if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['DOCUMENT_ROOT'])===0)
				$this->scriptUrl=str_replace('\\','/',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));

			else
				trigger_error('Request is unable to determine the entry script URL.',3434);
		}
		return $this->scriptUrl;
	}
	
    /**
     * public isAjax
     * 
     * There's an HTTP variable set called HTTP_X_REQUESTED_WITH, 
	 * which will be set and set to 'xmlhttprequest' if it's send by AJAX.
     */
	public function isAjax(){
	 
	 	if(!isset($this->server['HTTP_X_REQUESTED_WITH'])){
	 	 	return false;
	 	} else 	
	 		return (strtolower($this->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}

    /**
     * public isAjax
     * 
     * There's an (..) variable set called hex key, 
	 * which will be set obligatory send by AJAX.
     */
	public function isObligatoryAjax(){
	 
		if( ! $this->issetGet('kay')) return false;

		if( ! $this->issetGet('ac')) return false;

		if($this->getGet('kay') == 'GMPXMJUFHPFTBKBY'){

			if( strlen ( $this->getGet('ac') ) > 14 )
			{
				if( substr($this->getGet('ac'),0,14) == 'AjaxController' ){
		
					return true;
			 	}
			}		 
		}	
		return false;
	}

	/**
	 * @return string server name
	 */
	public function getServerName()
	{
		return $this->server['SERVER_NAME'];
	}

	/**
	 * @return integer server port number
	 */
	public function getServerPort()
	{
		return $this->server['SERVER_PORT'];
	}

	/**
	 * @return string URL referrer, null if not present
	 */
	public function getUrlReferrer()
	{
		return isset($this->server['HTTP_REFERER']) ? $this->server['HTTP_REFERER'] : null;
	}

	/**
	 * @return string user agent
	 */
	public function getUserAgent()
	{
		return $this->server['HTTP_USER_AGENT'];
	}

	/**
	 * @return string user IP address
	 */
	public function getUserHostAddress()
	{
		return isset($this->server['REMOTE_ADDR']) ? $this->server['REMOTE_ADDR'] : '127.0.0.1';
	}

	/**
	 * Name und Versionsnummer des verwendeten Übertragungsprotokolls, 
	 * mittels dessen die aktuelle Seite aufgerufen wurde, z. B. 'HTTP/1.0'
	 *
	 * @return string Server Protocol
	 */
	public function getServerProtocol()
	{
		if( ! isset($this->server['SERVER_PROTOCOL']) ) return false;

		$string8 = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,8));

		return ($string8 == 'https://') ? 'https://' : 'http://';
	}

	/**
	 * @return string user host name, null if cannot be determined
	 */
	public function getUserHost()
	{
		return isset($this->server['REMOTE_HOST']) ? $this->server['REMOTE_HOST'] : null;
	}

	/**
	 * @return string entry script file path (processed w/ realpath())
	 */
	public function getScriptFile()
	{
		if($this->scriptFile !== null)
			return $this->scriptFile;
		else
			return $this->scriptFile = realpath($this->server['SCRIPT_FILENAME']);
	}

	/**
	 * @return string user browser accept types
	 */
	public function getAcceptTypes()
	{
		return $this->server['HTTP_ACCEPT'];
	}

 	/**
	 * Returns the port to use for insecure requests.
	 * Defaults to 80, or the port specified by the server if the current
	 * request is insecure.
	 * You may explicitly specify it by setting the {@link setPort port} property.
	 * @return integer port number for insecure requests.
	 * @see setPort
	 * @since 1.1.3
	 */
	public function getPort()
	{
		if($this->port===null)
			$this->port =! $this->getIsSecureConnection() && isset($this->server['SERVER_PORT']) 
						 ? (int) $this->server['SERVER_PORT'] 
						 : 80;

		return $this->port;
	}
	
	public function setPort($value)
	{
		$this->port = (int) $value;
		$this->hostInfo = null;
	}

	/**
	 * Returns the port to use for insecure requests.
	 * Defaults to 443, or the port specified by the server if the current
	 * request is secure.
	 * You may explicitly specify it by setting the {@link setSecurePort securePort} property.
	 * @return integer port number for secure requests.
	 * @see setSecurePort
	 * @since 1.1.3
	 */
	public function getSecurePort()
	{
		if($this->securePort===null)
			$this->securePort = $this->getIsSecureConnection() && isset($this->server['SERVER_PORT']) 
							  ? (int) $this->server['SERVER_PORT'] 
							  : 443;
		return $this->securePort;
	}

	/**
	 * Sets the port to use for secure requests.
	 * This setter is provided in case a custom port is necessary for certain
	 * server configurations.
	 * @param integer port number.
	 * @since 1.1.3
	 */
	public function setSecurePort($value)
	{
		$this->securePort = (int) $value;
		$this->hostInfo   = null;
	}

	public function getAcceptLanguage()
	{
	 	return $this->server['HTTP_ACCEPT_LANGUAGE'];
	}

    /**
     * Retrieve put method
     *
     * @return boolean
     */
	public function isWriteSecurity()	
	{	 
	 	return $this->writeSecurity;
	}

    /**
     * set put method ON
     *
     */
	public function setWriteSecurity()	
	{	 
	 	$this->writeSecurity = true;
	}

    /**
     * set put method OFF
     *
     */
	public function closeWriteSecurity()	
	{	 
	 	$this->writeSecurity = false;
	}

    /**
     * Retrieve call method
     *
     * @return string
     */
	public function getMethod()
	{	 
	 	return $this->method;
	}

    /**
     * public isPost
     */
	public function isPost(){	 
	 	return ($this->method === 'POST') ? true : false;
	}

    /**
     * public isGet
     */
	public function isGet(){	 
	 	return ($this->method === 'GET') ? true : false;
	}

    /**
     * public isPut
     */
	public function isPut(){	 
	 	return ($this->method === 'PUT') ? true : false;
	}

    /**
     * public isHead
     */
	public function isHead(){	 
	 	return ($this->method === 'HEAD') ? true : false;
	}

    /**
     * public isDelete
     */
	public function isDelete(){	 
	 	return ($this->method === 'DELETE') ? true : false;
	}

    /**
     * public isOptions
     */
	public function isOptions(){	 
	 	return ($this->method === 'OPTIONS') ? true : false;
	}

    /**
     * public getRawPOST
     *
     * get raw all post data, if you have a hash value
     *
     * @return array of all POST data
     */
	public function getRawPOST($hash)
    {
   		if($hash == 'f0dd00aae5d2aeb141b984566f3101558ee87cd8' 
		   && isset($this->post))
		   {
	      	return $this->post;
	       } 
		   else return null; 	
  	}

	public function setRawPOST($post,$hash)
    {
   		if($hash == 'f0dd00aae5d2aeb141b984566f3101558ee87cd8' 
		   && isset($post)
		   && $this->isWriteSecurity()
		   )
		   {
	      	$this->post = $post;
	       } 
		   else return null; 	
  	}
  	
    /**
     * public getRawGET
     *
     * get raw all get data, if you have a hash value
     *
     * @return array of all GET data
     */
	public function getRawGET($hash)
    {
   		if($hash == '8646611bd4094995f8c5667445e1b868f42a84e4' 
		   && isset($this->get))
		   {
	      	return $this->get;
	       }  	
		   else return null; 	
  	}

	public function setRawGET($get,$hash)
    {
   		if($hash == '8646611bd4094995f8c5667445e1b868f42a84e4' 
		   && isset($get)
		   && $this->isWriteSecurity()
		   )
		   {
	      	$this->get = $get;
	       } 
		   else return null; 	
  	}
  	
    /**
     * public getRawCOOKIE
     *
     * get raw all cookie data, if you have a hash value
     *
     * @return array of all COOKIE data
     */
	public function getRawCOOKIE($hash)
    {
   		if($hash == '4d09cbbffeebb03585ad2c7040e5b4c12bea9a76' 
		   && isset($this->cookie))
		   {
	      	return $this->cookie;
	       }  	
		   else return null; 	
  	}

    /**
     * public getRawFILES
     *
     * get raw all files data, if you have a hash value
     *
     * @return array of all FILES data
     */
	public function getRawFILE($hash)
    {
   		if($hash == '5979a35a5c7959f0de647ad665740501dcd2241b' 
		   && isset($this->file))
		   {
	      	return $this->file;
	       }  	
		   else return null; 	
  	}

}
?>