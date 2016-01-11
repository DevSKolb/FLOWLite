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
//----------------------------------------------------------------------
// Differenz zwischen zwei Timestamps.
// Berücksichtigt wird ein komplettes Datum in Form ( YYYY-MM-TT HH:MM:SS )
// Diese Function errechnet die Differenz zwischen zwei Timestamps
// und gibt die Differenz in Tage, Stunden und Minuten zurück.
// ---------------------------------------------------------------------
// Aufruf: list($day,$std,$min) = zeit_differenz($t2,$t1,1);
//----------------------------------------------------------------------
 */
class DateTimeFunc {

	/**
	 * Check timestamp
	 *
	 * @param   datetime
	 * @format  2011-04-12 14:45:46	 
 	 */
	public static function dateTimeNow()
	{
		$timestamp 	= time();
		$datum 		= date("d.m.Y",$timestamp);
		$uhrzeit 	= date("H:i:s",$timestamp);

		return $datum . $uhrzeit;		
	}

	/**
	 * Check lag two timestamps
	 *
	 * @param   datetime
	 * @param   datetime
	 * @param   convert
	 *
	 * @return  day
	 * @return  hour
	 * @return  minute
 	 */
	public static function lag($time1,$time2,$tstp)
	{
		#- Beide Timestamps müssen gefüllt sein
		if($time1>0 and $time2>0){

		#- Timestamp in richtiger Reihenfolge bringen
	    if ($time1 < $time2) {
        	$temp 	= $time2;  
			$time2 	= $time1;   
			$time1 	= $temp;
        } else {
            $temp = $time1; 
        }

		#- Parameter der Umwandlung muss 0 oder 1 sein
		if($tstp==0 or $tstp==1){

		#- Wird ein Datum übergeben, kann dieses mittels Function zunächst
		#- in einen Timestamp umgewandelt werden ($tstp=1).
		#- Umwandlung eines Datums in Timestamp
 	    if($tstp==1)
	    {
		      $t1_tmp = strtotime($time1);
		      $t2_tmp = strtotime($time2);
		}
		else if($tstp==0)
		{
		      $t1_tmp = $time1;
		      $t2_tmp = $time2;
		}
		#- Differenz bilden, das zweite Datum wird vom ersten abgezogen
		   $ws_diff = $t1_tmp - $t2_tmp;

		#- In $s zwischenspeichern
		   $s = $ws_diff;

		#- Umrechnung in Tage, Stunden, Minuten und Sekunden
		   $m = (int)($s / 60);
		   $h = (int)($s / 60 / 60);
		   $d = (int)($s / 60 / 60 / 24 );
	
		   $h = $h % 24;
		   $m = $m % 60;
		   $s = $s % 60;

		#- Rückgabe der Differenz in Tage, Stunden, Minuten und Sekunden
		   return array ( $d, $h, $m, $s );
  		}
 	  }
	}

}
?>