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
/*
 * see also RFC 2616 - Hypertext Transfer Protocol -- HTTP/1.1
 */ 
class Response
{
	/*
	 * @var array
	 */
	private $headers = array();
	
	/*
	 * @var string
	 */
	private $status = "302";
	
	/*
	 * @var string
	 */
	private $location = "Location";

	/*
	 * @var string
	 */
	private $content = "";

	/*
	 * protocol
	 * @var string
	 */
	public $protocol = 'HTTP/1.1';
 
	/*
	 * HTTP status codes
	 *
	 * The following is a list of HyperText Transfer Protocol (HTTP) response status codes.
	 *
	 * The first is a header that starts with the string "HTTP/" (case is not significant), 
	 * which will be used to figure out the HTTP status code to send. For example, if you 
	 * have configured Apache to use a PHP script to handle requests for missing files 
	 * (using the ErrorDocument directive), you may want to make sure that your script 
	 * generates the proper status code. 
	 *
	 * @var array
	 */
	private $statusCodes = array
	(					
		100 => '100 Continue',
		101 => '101 Switching Protocols',
		102 => '102 Processing (WebDAV) (RFC 2518)',
		103 => '122 Request-URI too long',

		200 => '200 OK',
		201 => '201 Created',
		202 => '202 Accepted',
		203 => '203 Non-Authoritative Information (since HTTP/1.1)',
		204 => '204 No Content',
		205 => '205 Reset Content',
		206 => '206 Partial Content',
		207 => '207 Multi-Status (WebDAV) (RFC 4918)',
		226 => '226 IM Used (RFC 3229)',

		300 => '300 Multiple Choices',
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other (since HTTP/1.1)',
		304 => '304 Not Modified',
		305 => '305 Use Proxy (since HTTP/1.1)',
		306 => '306 Switch Proxy',
		307 => '307 Temporary Redirect (since HTTP/1.1)',

		400 => '400 Bad Request',
		401 => '401 Unauthorized',
		402 => '402 Payment Required',
		403 => '403 Forbidden',
		404 => '404 Not Found',
		405 => '405 Method Not Allowed',
		406 => '406 Not Acceptable',
		407 => '407 Proxy Authentication Required',
		408 => '408 Request Timeout',
		409 => '409 Conflict',
		410 => '410 Gone',
		411 => '411 Length Required',
		412 => '412 Precondition Failed',
		413 => '413 Request Entity Too Large',
		414 => '414 Request-URI Too Long',
		415 => '415 Unsupported Media Type',
		416 => '416 Requested Range Not Satisfiable',
		417 => '417 Expectation Failed',
		418 => '418 I\'m a teapot',
		422 => '422 Unprocessable Entity (WebDAV) (RFC 4918)',
		423 => '423 Locked (WebDAV) (RFC 4918)',
		424 => '424 Failed Dependency (WebDAV) (RFC 4918)',
		425 => '425 Unordered Collection (RFC 3648)',
		426 => '426 Upgrade Required (RFC 2817)',
		444 => '444 No Response',
		449 => '449 Retry With',
		450 => '450 Blocked by Windows Parental Controls',
		499 => '499 Client Closed Request',

		500 => '500 Internal Server Error',
		501 => '501 Not Implemented',
		502 => '502 Bad Gateway',
		503 => '503 Service Unavailable',
		504 => '504 Gateway Timeout',
		505 => '505 HTTP Version Not Supported',
		506 => '506 Variant Also Negotiates (RFC 2295)',
		507 => '507 Insufficient Storage (WebDAV) (RFC 4918)',
		509 => '509 Bandwidth Limit Exceeded (Apache bw/limited extension)',
		510 => '510 Not Extended (RFC 2774)',
	);


	public function __construct(){
		return $this; 
	}

	/*
	 * add information to header
	 */
	public function addHeader($headinfo, $content) {
		$this->headers[$headinfo] = $content;
	}

	/*
	 * setStatus 
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/*
	 * addContent 
	 */
	public function addContent($content){
    	$this->content .= $content;
  	}

	/*
	 * getContent 
	 */
	public function getContent(){
	    return $this->content;
  	}  

	/*
	 * replaceContent 
	 */
	public function replaceContent($newContent){
	    $this->content = $newContent;
  	}

	/*
     * header allready send
	 */
	private function msgHeaderAllreadySend($filename,$linenum){
		echo "Header bereits gesendet in $filename in Zeile $linenum; Redirect nicht moeglich\n";
    	exit;
	}

	/*
     * header direct send
	 */
	public function send() {
	    
		// Header wurde bereits versendet
		if (headers_sent($filename,$linenum)) {
	     	$this->msgHeaderAllreadySend($filename,$linenum);
    	}

		// Setzen protocol and status
		header($this->protocol.' '.$this->status);

		// alle header informations absetzen
		if($this->headers !== null)
		{
	    	foreach($this->headers as $location => $content) 
			{      
		  		header($location.": ".$content);
	    	}
	    }
		echo "<h1>".$this->status."</h1>";

	    // init
    	$this->content = "";
    	$this->headers = null;
  	}

	/*
	 * Sets the location header and sets the status code 
     *
     * @param url
     * @param immediately
     * @param status code
	 */
	public function redirect($url, $immediately = true, $status = 301)
	{
		// Setzen status
		if(in_array($status,$this->statusCodes)){
			$this->status = $this->statusCodes[$status];
		}
		else	
			$this->status = $this->statusCodes[404];

		// url or status code
		if(in_array($url,$this->statusCodes)){
			$this->status  = $this->statusCodes[$url];
			$this->headers = null;
		}
		else
			$this->addHeader($this->location, $url);

		// goto
	    if($immediately === true)
    	{
      		$this->send();
      		exit();
    	}
  	}
}
?>