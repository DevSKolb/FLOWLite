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
 * Locale class
 *
 * LC_ALL - für alle Einstellungen
 * LC_COLLATE - Vergleich von Strings (Zeichenketten)
 * LC_CTYPE - Umwandlung von Strings (Zeichenkette), z.B. strtoupper()
 * LC_MONETARY - für Währungsangaben
 * LC_NUMERIC - für Dezimaltrennzeichen (numerische Operatoren)
 * LC_TIME - für Datum- und Zeitformatierungen bei strftime()
 *
 */
class Locale {

	/**
	 * Registrierungsstelle von ISO 639-2, Library of Congress (englisch) 
	 * http://www.loc.gov/standards/iso639-2/
	 */
	protected static $locale = array
	(
		'au' => 'AUS',	# Australia
		'at' => 'AUT',	# Austria
		'be' => 'BEL',	# Belgium
		'br' => 'BRA',	# Brazil
		'ca' => 'CAN',	# Canada
		'cn' => 'CHN',	# China
		'cz' => 'CZE',	# Czech Republic
		'dn' => 'DNK',	# Denmark
		'fi' => 'FIN',	# Finland
		'fr' => 'FRA',	# France	
		'de' => 'DEU',	# Germany
		'gr' => 'GRC',	# Greece
		'hk' => 'HKG',	# Hong Kong SAR	
		'hn' => 'HUN',	# Hungary
		'ic' => 'ISL',	# Iceland
		'ir' => 'IRL',	# Ireland
		'it' => 'ITA',	# Italy
		'jp' => 'JPN',	# Japan
		'ko' => 'KOR',	# Korea
		'mx' => 'MEX',	# Mexico
		'nl' => 'NLD',	# The Netherlands
		'nz' => 'NZL',	# New Zealand
		'no' => 'NOR',	# Norway
		'pl' => 'POL',	# Poland
		'pr' => 'PRT',	# Portugal
		'ru' => 'RUS',	# Russia
		'sg' => 'SGP',	# Singapore
		'sv' => 'SVK',	# Slovakia
		'es' => 'ESP',	# Spain
		'se' => 'SWE',	# Sweden
		'ch' => 'CHE',	# Switzerland
		'tw' => 'TWN',	# Taiwan
		'tr' => 'TUR',	# Turkey
		'gb' => 'GBR',	# United Kingdom
		'us' => 'USA',	# United States
	);
	
	// http://de.wikipedia.org/wiki/ISO_639
	// http://www.blogs.uni-erlangen.de/webworking/stories/81/
	protected static $localeTime = array
	(
		'iso15' 		=> 'iso_8859_15',	
		'iso1'			=> 'iso_8859_1',	
		'iso2'			=> 'iso_8859_2',	
		'hi'			=> 'hi_IN.UTF-8',	
		'cs'			=> 'cs_CZ',	
		'cs_iso2'		=> 'cs_CZ.ISO8859-2',	
		'cz'			=> 'cz',	
		'at'			=> 'de_AT',	
		'at_iso1'		=> 'de_AT.ISO8859-1',	
		'at_iso15'		=> 'de_AT.ISO8859-15',	
		'at_iso15eur'	=> 'de_AT.ISO8859-15@euro',	
		'ch'			=> 'de_CH',	
		'ch_iso1'		=> 'de_CH.ISO8859-1',	
		'de'			=> 'de_DE',	
		'de_iso1'		=> 'de.ISO8859-1',	
		'de_iso15'		=> 'de.ISO8859-15',	
		'at_iso15eur'	=> 'de_DE.ISO8859-15@euro',	
		'de_utf-8'		=> 'de.UTF-8',	
		'de_utf-8eur'	=> 'de.UTF-8@euro',	
		'fr'			=> 'fr',	
		'fr_ch'			=> 'fr_CH',	
		'fr_ch_iso1'	=> 'fr_CH.ISO8859-1',	
		'hu'			=> 'hu',	
		'hu_HU'			=> 'hu_HU',	
		'hu_HU_iso2'	=> 'hu_HU.ISO8859-2',	
		'pl'			=> 'pl',	
		'pl_utf-8'		=> 'pl.UTF-8',	
		'pl_PL'			=> 'pl_PL',	
		'pl_iso2'		=> 'pl_PL.ISO8859-2',	
		'pl_utf-8'		=> 'pl_PL.UTF-8',	
		'sk_SK'			=> 'sk_SK',	
		'sk_iso2'		=> 'sk_SK.ISO8859-2',	
		'en_CA'			=> 'en_CA',	
		'en_iso1'		=> 'en_CA.ISO8859-1',	
		'en_US'			=> 'en_US',	
		'us_iso1'		=> 'en_US.ISO8859-1',	
		'us_iso15'		=> 'en_US.ISO8859-15',	
		'us_iso15eur'	=> 'en_US.ISO8859-15@euro',	
		'es'			=> 'es',	
		'es_MX'			=> 'es_MX',	
		'es_MX_iso1'	=> 'es_MX.ISO8859-1',	
		'fr_CA'			=> 'fr_CA',	
		'fr_CA_iso1'	=> 'fr_CA.ISO8859-1',			
		'th'			=> 'th',			
		'th_TH'			=> 'th_TH',			
		'th_iso11'		=> 'th_TH.ISO8859-11',			
		'th_tis620'		=> 'th_TH.TIS620',			
		'th_utf-8'		=> 'th_TH.UTF-8',					
	);

	/**
	 * set locale information
	 *
	 * @return  void
	 */
	public static function setLocale_LC_ALL($language)
	{ 
		setlocale(LC_ALL, NULL);
		
		if(self::isLocale($language)){
  			setlocale(LC_ALL, self::getLocale($language));
		}
		
    }		

	/**
	 * Timezone
	 *
	 * @return  void
	 */
	public static function setTimezone($zone)
	{ 
		date_default_timezone_set($zone);
    }		

	/**
	 * set locale information
	 *
	 * @return  void
	 */
	public static function formatDateTime($lang,$dtime,$dnum,$td,$tz)
	{
	switch($lang){

		case 'de' : {

			switch($dnum){
		    	case  1: {$dateStr = strftime("%d".$td."%m".$td."%y",$dtime);break;}
			    case  2: {$dateStr = strftime("%d".$td."%m".$td."%Y",$dtime);break;}
			    case  3: {$dateStr = strftime("%d".$td."%m".$td."%Y %H".$tz."%M",$dtime);break;}
			    case  4: {$dateStr = strftime("%d".$td."%m".$td."%Y %H".$tz."%M".$tz."%S",$dtime);break;}
			    case  5: {$dateStr = strftime("%d".$td."%m".$td."%y %H".$tz."%M",$dtime);break;}
		    	case  6: {$dateStr = strftime("%d".$td."%m".$td."%y %H".$tz."%M".$tz."%S",$dtime);break;}
			    case  7: {$dateStr = strftime("%d".$td."%m",$dtime);break;}
			    case  8: {$dateStr = strftime("%d".$td."%M",$dtime);break;}
			    case  9: {$dateStr = strftime("%b".$td."%y",$dtime);break;}
		    	case 10: {$dateStr = strftime("%b".$td."%Y",$dtime);break;}
				case 11: {$dateStr = strftime("%B".$td."%y",$dtime);break;}
			    case 12: {$dateStr = strftime("%d".$td."%b".$td."%y",$dtime);break;}
		    	case 13: {$dateStr = strftime("%d".$td."%b".$td."%Y",$dtime);break;}
			    case 14: {$dateStr = strftime("%a, %d. %b %y",$dtime);break;}
			    case 15: {$dateStr = strftime("%a, %d. %b %y, %H:%M",$dtime);break;}
			    case 16: {$dateStr = strftime("%a, %d. %b %Y",$dtime);break;}
			    case 17: {$dateStr = strftime("%a, %d. %B %Y",$dtime);break;}
			    case 18: {$dateStr = strftime("%A, %d. %B %Y",$dtime);break;}
			    case 19: {$dateStr = strftime("%W KW",$dtime);break;}
			    case 20: {$dateStr = strftime("%Y".$td."%m".$td."%d %H".$tz."%M".$tz."%S",$dtime);break;}
		   }
		   return $dateStr;
		  }

	  default : {

		  switch($dnum){
			    case  1: {$dateStr = strftime("%m/%d",$dtime);break;}
			    case  2: {$dateStr = strftime("%m/%d/%Y",$dtime);break;}
			    case  3: {$dateStr = strftime("%m/%d/%Y %H:%M",$dtime);break;}
			    case  4: {$dateStr = strftime("%m/%d/%Y %H:%M:%S",$dtime);break;}
			    case  5: {$dateStr = strftime("%m/%d/%Y %H:%M %p",$dtime);break;}
			    case  6: {$dateStr = strftime("%m/%d/%Y %H:%M %r",$dtime);break;}
			    case  7: {$dateStr = strftime("%m/%d/%y %H:%M",$dtime);break;}
			    case  8: {$dateStr = strftime("%m/%d/%y %H:%M:%S",$dtime);break;}
			    case  9: {$dateStr = strftime("%m/%d/%y %H:%M:%S %p",$dtime);break;}
			    case 10: {$dateStr = strftime("%m/%d/%y %H:%M:%S %r",$dtime);break;}
			    case 11: {$dateStr = strftime("%m/%d",$dtime);break;}
			    case 12: {$dateStr = strftime("%b/%d",$dtime);break;}
			    case 13: {$dateStr = strftime("%b/%y",$dtime);break;}
			    case 14: {$dateStr = strftime("%b/%Y",$dtime);break;}
			    case 15: {$dateStr = strftime("%B/%y",$dtime);break;}
			    case 16: {$dateStr = strftime("%b/%d/%y",$dtime);break;}
			    case 17: {$dateStr = strftime("%b/%d/%Y",$dtime);break;}
			    case 18: {$dateStr = strftime("%b %d, %Y",$dtime);break;}
			    case 19: {$dateStr = strftime("%a, %b %d, %y",$dtime);break;}
			    case 20: {$dateStr = strftime("%a, %b %d, %y, %H:%M",$dtime);break;}
			    case 21: {$dateStr = strftime("%a, %b %d, %Y",$dtime);break;}
			    case 22: {$dateStr = strftime("%a, %B %d, %Y",$dtime);break;}
			    case 23: {$dateStr = strftime("%A, %B %d, %Y",$dtime);break;}
			    case 24: {$dateStr = strftime("Week %W",$dtime);break;}		
		   }
		  return $dateStr;
		}
		}
	return false;
	}

	/**
	 * is locale information
	 */
	private static function isLocale($lang)
   	{
		foreach(self::$locale as $key => $value){
			if($key == $lang){
				return true;
			} 
		}
		return false;
   	}

	/**
	 * get locale information
	 */
  	private static function getLocale($lang)
   	{
		foreach(self::$locale as $key => $value){
			if($key == $lang){
				return $value;
			} 
		}
		return "USA";
   	}

	/**
	 * Singleton-Elements: private __construct
	 *                     private __clone   
	 */     
	private function __construct() {} //verhindern, dass new verwendet wird
	private function __clone() {} //verhindern, dass durch Kopieren 2 Objekte entstehen
}