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
class Captcha extends CController
{  
	
	/**
	  * get
	  * 
	  */   
	public function get()
	{
		// Session Manager
		$sess = $this->objectManager->getObject('Session');

		$ranStr = md5(microtime());

		$ranStr = substr($ranStr, 0, 6);

		$sess->cap_code = $ranStr;
		
		$newImage = imagecreatefromjpeg("http://tts.nri.de/FLOWLite_1.0/Unity/Framework/FL/Classes/Utilities/cap_bg.jpg");

		$txtColor = imagecolorallocate($newImage, 0, 0, 0);

		imagestring($newImage, 5, 5, 5, $ranStr, $txtColor);

		header("Content-type: image/jpeg");

		return imagejpeg($newImage);
	} 
} 
?>