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
class Html {

	private static $output = '';

	private static $className = '';

	public static $selectName = 'Select';

	public static function initHtml(){
	 	self::$output = '';
	} 

	public static function setSelectName($selectName){
	 	return self::$selectName = $selectName;
	} 

	public static function setClassName($className){
	 	return self::$className = $className;
	} 

	public static function getHtml(){
	 	return self::$output;
	} 

	private static function setEmptyOption(){
	 	return "<option value=\"-1\">".self::$selectName."</option>";
	} 

	private static function setOptGroup($optGroup){
	 	return "<optgroup label=\"".$optGroup."\">";
	} 

	private static function setEndOptGroup(){
	 	return "</optgroup>";
	} 

	public static function setSelectOptgroupCheckbox($idName,$data,$deptData
							,$OptionIndex=false
							,$emptyOption=false
							,$select=true
							,$optGroup=false
	){
	 
	 	$countData = count($data);

		if($select === true){
			self::$output .= '<select size="5" id="'.$idName.'" multiple="multiple" name="'.$idName.'[]" ';

			if(self::$className > ''){
				self::$output .= 'class="'.self::$className.'"';
			}	
			self::$output .= ' >';
		}	

		if($emptyOption === true){ self::$output .= self::setEmptyOption(); }

		$emptyOption = false;

		$countData = count($data);
		$dept = '';

		for( $i = 0; $i < $countData; $i++ ){

			if($optGroup === true)
			{
				 if($dept != '' && $dept <> $data[$i]['optgroup']){
				  	self::$output .= self::setEndOptGroup(); 
				 }

				 if($dept <> $data[$i]['optgroup']){			
					 self::$output .= self::setOptGroup($data[$i]['optgroup']);
		 		}
		 	}
			$dept = $data[$i]['optgroup'];

			self::$output .= "<option ";

			if($OptionIndex != false 
			&& $OptionIndex === $data[$i]['id']) 
			{
#echo "<br>". $OptionIndex .':'. $data[$i]['id'] ;
			 self::$output .= " selected ";
			}

			self::$output .= "value=\"";
			self::$output .= $data[$i]['id'];
			self::$output .= "\" ";
			self::$output .= ">";
			self::$output .= $data[$i]['name'];
			self::$output .= "</option>";
			
		}
		if($optGroup === true){
			self::$output .= self::setEndOptGroup();
		}
		if($select === true){
			self::$output .= '</select>';
		}
	} 

	public static function setSelectOptgroupCheckbox1($idName,$data,$deptData
							,$OptionIndex=false
							,$emptyOption=false
							,$select=true
							,$optGroup=false
	){
	 
	 	$countData = count($data);

		if($select === true){
			self::$output .= '<select size="5" id="'.$idName.'" multiple="multiple" name="'.$idName.'[]" ';

			if(self::$className > ''){
				self::$output .= 'class="'.self::$className.'"';
			}	
			self::$output .= ' >';
		}	

		if($emptyOption === true){ self::$output .= self::setEmptyOption(); }

		$emptyOption = false;

		$countData = count($data);
		$dept = '';

		for( $i = 0; $i < $countData; $i++ ){

			if($optGroup === true)
			{
				 if($dept != '' && $dept <> $data[$i]['optgroup']){
				  	self::$output .= self::setEndOptGroup(); 
				 }

				 if($dept <> $data[$i]['optgroup']){			
					 self::$output .= self::setOptGroup($data[$i]['optgroup']);
		 		}
		 	}
			$dept = $data[$i]['optgroup'];

			self::$output .= "<option ";
/*
			if($OptionIndex != false 
			&& $OptionIndex === $data[$i]['id']) 
			{
#echo "<br>". $OptionIndex .':'. $data[$i]['id'] ;
			 self::$output .= " selected ";
			}
*/
			/*
			 * Selected from Case
			 */
			$SEL = (in_array($data[$i]['id'],$deptData)) ? 'selected="selected"' : '';

			self::$output .= "value=\"";
			self::$output .= $data[$i]['id'];
			self::$output .= "\" ";
			self::$output .= $SEL;
			self::$output .= ">";
			self::$output .= $data[$i]['name'];
			self::$output .= "</option>";
			
		}
		if($optGroup === true){
			self::$output .= self::setEndOptGroup();
		}
		if($select === true){
			self::$output .= '</select>';
		}
	} 


	public static function setSelectOptgroup($idName,$data,$deptData
							,$OptionIndex=false
							,$emptyOption=false
							,$select=true
							,$optGroup=false
	){
	 
	 	$countData = count($data);

		if($select === true){
			self::$output .= '<select size="1" id="'.$idName.'" name="'.$idName.'" ';

			if(self::$className > ''){
				self::$output .= 'class="'.self::$className.'"';
			}	
			self::$output .= ' >';
		}	

		if($emptyOption === true){ self::$output .= self::setEmptyOption(); }

		$emptyOption = false;

		$countData = count($data);
		$dept = '';

		for( $i = 0; $i < $countData; $i++ ){

			if($optGroup === true)
			{
				 if($dept != '' && $dept <> $data[$i]['optgroup']){
				  	self::$output .= self::setEndOptGroup(); 
				 }

				 if($dept <> $data[$i]['optgroup']){			
					 self::$output .= self::setOptGroup($data[$i]['optgroup']);
		 		}
		 	}
			$dept = $data[$i]['optgroup'];


			self::$output .= "<option ";

			if($OptionIndex != false 
			&& $OptionIndex === $data[$i]['id']) 
			{
#echo "<br>". $OptionIndex .':'. $data[$i]['id'] ;
		
			 self::$output .= " selected ";
			}

			self::$output .= "value=\"";
			self::$output .= $data[$i]['id'];
			self::$output .= "\" ";
			self::$output .= ">";
			self::$output .= $data[$i]['name'];
			self::$output .= "</option>";
			
		}
		if($optGroup === true){
			self::$output .= self::setEndOptGroup();
		}
		if($select === true){
			self::$output .= '</select>';
		}
	} 

	public static function setSelect($idName,$data,$OptionIndex=false,$emptyOption=false,$select=true){
	 
		if($select === true){
			self::$output .= '<select size="1" id="'.$idName.'" name="'.$idName.'" ';

			if(self::$className > ''){
				self::$output .= 'class="'.self::$className.'"';
			}	
			self::$output .= ' >';
		}	

		if($emptyOption === true){ self::$output .= self::setEmptyOption(); }

		$emptyOption = false;

		$countData = count($data);

		for( $i = 0; $i < $countData; $i++ ){

			self::$output .= "<option ";

			if($OptionIndex != false 
			&& $OptionIndex == $data[$i]['id']) 
			{
			 self::$output .= " selected ";
			}

			self::$output .= "value=\"";
			self::$output .= $data[$i]['id'];
			self::$output .= "\" ";
			self::$output .= ">";
			self::$output .= $data[$i]['name'];
			self::$output .= "</option>";
		}

		if($select === true){
			self::$output .= '</select>';
		}	
	} 
}
?>