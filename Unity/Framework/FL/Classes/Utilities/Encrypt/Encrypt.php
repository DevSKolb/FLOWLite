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
class Encrypt  
{  
	
	/*
	 * list of supported hashing algorithms
	 */
	protected static $hashAlgo = array 
	(
			 'md4'
			,'md5'
			,'sha1'
			,'sha256'
			,'sha384'
			,'sha512'
			,'ripemd128'
			,'ripemd160'
			,'whirlpool'
			,'tiger128,3'
			,'tiger160,3'
			,'tiger192,3'
			,'tiger128,4'
			,'tiger160,4'
			,'tiger192,4'
			,'snefru'
			,'gost'
			,'adler32'
			,'crc32'
			,'crc32b'
			,'haval128,3'
			,'haval160,3'
			,'haval192,3'
			,'haval224,3'
			,'haval256,3'
			,'haval128,4'
			,'haval160,4'
			,'haval192,4'
			,'haval224,4'
			,'haval256,4'
			,'haval128,5'
			,'haval160,5'
			,'haval192,5'
			,'haval224,5'
			,'haval256,5'
	 );
	 
	/**
	  * static funtion
	  * FL_Hash
	  * 
	  * @params (strring) hashMethod
	  * @params (string)  data
	  * @params (boolean) binaer
	  * return hex or digit (binär)
	  */
	public static function FL_Hash($hashMethod,$data,$binaer=false) 
	{	
		// data obligatory
		if(!$data) return false;
		
		// hash method must in lower chars
		$hashMethod = (string) strtolower($hashMethod);
		
 		// check if hash method in array
 		// alternate throw Exception
		if(!in_array($hashMethod,self::$hashAlgo)) return false;
		
		// Returns a string containing the calculated message digest as lowercase hexits 
		// unless raw_output is set to true in which case the raw binary representation 
		// of the message digest is returned. 
		return hash($hashMethod, $data, $binaer);
	}

	/**
	  * static funtion
	  * FL_Hash_HMAC
	  * 
	  * @params (strring) hashMethod
	  * @params (string)  data
	  * @params (string)  key
	  * @params (boolean) binaer
	  * return hex or digit (binär)
	  */
	public static function FL_Hash_HMAC($hashMethod,$data,$key,$binaer=false) 
	{
		// data obligatory
		if(!$data) return false;
		
		// key obligatory
		if(!$key) return false;

		// hash method must in lower chars
		$hashMethod = (string) strtolower($hashMethod);
		
 		// check if hash method in array
 		// alternate throw Exception
		if(!in_array($hashMethod,self::$hashAlgo)) return false;
		
		// Returns a string containing the calculated message digest as lowercase hexits 
		// unless raw_output is set to true in which case the raw binary representation 
		// of the message digest is returned. 
		return hash_hmac($hashMethod, $data, $key, $binaer);
	}

	/**
	  * static funtion
	  * FL_Hash_file
	  * 
	  * @params (strring) hashMethod
	  * @params (string)  FileName
	  * @params (boolean) binaer
	  * return hex or digit (binär)
	  */
	public static function FL_Hash_file($hashMethod,$FileName,$binaer=false) 
	{
		// data obligatory
		if(!$data) return false;
		
		// hash method must in lower chars
		$hashMethod = (string) strtolower($hashMethod);
		
 		// check if hash method in array
 		// alternate throw Exception
		if(!in_array($hashMethod,self::$hashAlgo)) return false;
		
		// if file exists
		if(file_exists($FileName)){

			// Returns a string containing the calculated message digest as lowercase hexits 
			// unless raw_output is set to true in which case the raw binary representation 
			// of the message digest is returned. 
			return hash_file($hashMethod, $FileName, $key, $binaer);
		}	
		return false;
	}

	/**
	  * static funtion
	  * FL_Hash_HMAC_file
	  * 
	  * @params (strring) hashMethod
	  * @params (string)  FileName
	  * @params (string)  key
	  * @params (boolean) binaer
	  * return hex or digit (binär)
	  */
	public static function FL_Hash_HMAC_file($hashMethod,$FileName,$key,$binaer=false) 
	{
		// data obligatory
		if(!$data) return false;
		
		// key obligatory
		if(!$key) return false;

		// hash method must in lower chars
		$hashMethod = (string) strtolower($hashMethod);
		
 		// check if hash method in array
 		// alternate throw Exception
		if(!in_array($hashMethod,self::$hashAlgo)) return false;

		// if file exists
		if(file_exists($FileName)){

			// Returns a string containing the calculated message digest as lowercase hexits 
			// unless raw_output is set to true in which case the raw binary representation 
			// of the message digest is returned. 
			return hash_hmac_file($hashMethod, $FileName, $key, $binaer);
		}	
		return false;
	}
	 
	/**
	  * static funtion
	  * encryptData
	  * 
	  * @params data
	  * @params key
	  * return encrypt string
	  */   
	public static function encryptData($data,$key)
	{
		// accept data and key
	    if(!$data) return false;   
    	if(!$key)  return false;
    
	    // key with max. 32 chars
		if(strlen($key)>32)
		   throw new Exception('key characters must be less than 32 long', 80542);
   
    	// accept type
		$data	= (string) $data;
   		$key 	= (string) $key;
   
    	// Returns the size of the IV of the opened algorithm
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

	    // Create an initialization vector (IV) from a random source
   		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   
	    // Encrypts plaintext with given parameters
    	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv);
   	
		// Encodes the given data with base64 and return data
    	return trim(base64_encode($crypttext));
	}

	/**
	  * static funtion
	  * decryptData
	  * 
	  * @params data
	  * @params key
	  * return decrypt string
	  */   
	public static function decryptData($data,$key)
	{
		// accept data and key
	    if(!$data) return false;   
	    if(!$key)  return false;
   
	    // accept type
		$data	= (string) $data;
	    $key 	= (string) $key;

	    // key with max. 32 chars
		if(strlen($key)>32)
		   throw new Exception('key characters must be less than 32 long', 80542);

	    // Decodes the given data with base64
		$crypttext = base64_decode($data); 
  
	    // Returns the size of the IV of the opened algorithm
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
  
		// Create an initialization vector (IV) from a random source	
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  
  		// Decrypts crypttext with given parameters
	    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
  
  		// return data
		return trim($decrypttext);
	}

	/**
	  * static funtion
	  * Calculates the crc32 polynomial of a string
	  * Generates the cyclic redundancy checksum polynomial of 32-bit lengths of the str.
	  * This is usually used to validate the integrity of data being transmitted.
	  *
	  * @params data
	  * return checksum
	  */   
	public static function crc32($data)
	{
		// accept data 
	    if(!$data) return false;   
   
	    // accept type
		$data	= (string) $data;

	    // Calculates the crc32 polynomial of a string
		$crc32 = crc32($data); 
  
  		// return data
		return trim($crc32);
	}
	 
  /**
   * Singleton-Elements: private __construct
   *                     private __clone   
   */     
  private function __construct() {} //verhindern, dass new verwendet wird
  private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen 
} 


?>