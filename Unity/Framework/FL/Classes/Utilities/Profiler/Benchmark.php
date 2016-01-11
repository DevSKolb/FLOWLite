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
/*
 * Benchmark::start(<Token>);
 * Benchmark::stop(<Token>);
 * Benchmark::delete(<Token>);
 * Benchmark::getMarks(<Token>);
 * Benchmark::getMarksAll();
 * Benchmark::getBenchmarkTime(<Token>);
 * Benchmark::getBenchmarkMemory(<Token>);
 */

/**
 * Provides simple benchmarking and profiling
 */
class Benchmark {

	/*
	 * Collected benchmarks
	 */
	static protected $marks = array();

	/*
	 * Format for run time 
	 */
    static protected $timeout = "%01.6f"; 

	/*
	 * rounded factor
	 */
	static protected $timeprecision = 6;
	   
	/**
	 * Starts a new benchmark and returns a unique token.
	 *
	 * @param   string  benchmark name
	 * @return  string
	 */
	public static function start($token)
	{
		static $counter = 0;

		if(isset(self::$marks[$token])){
		  die('Token bereits vorhanden');
		 } 

		self::$marks[$token] = array
		(
			// Start the benchmark
			'start_time'   => self::getTime(),
			'start_memory' => memory_get_usage(),

			// Set the stop keys without values
			'stop_time'    => FALSE,
			'stop_memory'  => FALSE,
		);

		return $token;
	}	

	/**
	 * Stop the benchmark
	 *
	 * @param   string  token
	 * @return  void
	 */
	public static function stop($token)
	{
		self::$marks[$token]['stop_time']   = self::getTime();
		self::$marks[$token]['stop_memory'] = memory_get_usage();
	}

	/**
	 * Deletes a benchmark
	 *
	 * @param   string  token
	 * @return  void
	 */
	public static function delete($token)	{
		unset(self::$marks[$token]);
	}
	
	/**
	 * get Time
	 *
	 * @return  void
	 */		
	static protected function getTime() 	{ 
        return time()+microtime(TRUE); 
    } 
	 	
	/**
	 * get mark
	 *
	 * @return  void
	 */		
	static public function getMarks($token) 	{ 
        return self::$marks[$token]; 
    } 


	/**
	 * get marks all
	 *
	 * @return  void
	 */		
	static public function getMarksAll() 	{ 
        return self::$marks; 
    } 

	/**
	 * convert
	 *
	 * @param   size
	 * @return  string
	 */	
	 static protected function convert($size)
	 {
	    $unit=array('b','kb','mb','gb','tb','pb');
    	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	 }

	/**
	 * Gets benchmark result
	 *
	 * @param   string  token
	 * @return  array   execution time, memory
	 */
	public static function getBenchmarkTime($token) {
 
		// The benchmark has not been stopped yet
		if (self::$marks[$token]['stop_time'] === FALSE) {
			self::stop($token);
		} 

		// Import the benchmark data
		$mark = self::$marks[$token];
		
		// Total time in seconds
		$diffTime = $mark['stop_time'] - $mark['start_time'];			
		$diffTime = round($diffTime, self::$timeprecision);        
		$diffTime = sprintf(self::$timeout, $diffTime); 

		return $diffTime; 
	}
	
	/**
	 * Get benchmark result time
	 *
	 * @return  array   execution time, memory
	 */
	public static function getBenchmarkMemory($token) {

		// The benchmark has not been stopped yet
		if (self::$marks[$token]['stop_memory'] === FALSE) {
			self::stop($token);
		} 

		// Import the benchmark data
		$mark = self::$marks[$token];

		// Amount of memory in bytes
		$diffMemory = $mark['stop_memory'] - $mark['start_memory'];
		$diffMemory = self::convert($diffMemory);

		return $diffMemory;
    }
				
	final private function __construct()	{	}	
	final private function __clone()	{	}		
}