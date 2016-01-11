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
class DBObject
{
	/**
	 * @var objectManger
	 */
	  public  $objectManager;

	/**
	 * @var DatabasePointer
	 */
  	  private $DatabasePointer;
  
	/**
	 * @var Record-ID
	 */
	  private $id = 0;

	/**
	 * @var Name of Datenbase Table
	 */
	  private $table;

	/**
	 * @var Fields of Table
	 */
	  private $fields = array();

    /**
	 * Initializes database table object 
	 * params
	 * :: Table :: Name of Database Table
	 * :: Fields:: Array with Fields from Table
	 *
	 * @return void
	 */
	public function __construct( $table, $fields )
  	{
        // Database Table
	    $this->table = $table;

        // Init Fields of Table 
	    foreach( $fields as $key ){
	      $this->fields[ $key ] = null;
        }
	    // Instance of ObjectManager
        $this->objectManager = ObjectManager::getInstance();
		      
		// Connect Database 
	    $this->DatabasePointer = $this->objectManager->getObject('DBConnectManager')->connectRouter();
	}

    /**
	 * Magic function GET
	 *
	 * @return void
	 */
	function __get( $key ) {    
		return $this->fields[ $key ];
	}

    /**
	 * Magic function SET
	 *
	 * @return void
	 */ 
	function __set( $key, $value )  {
    	if ( array_key_exists( $key, $this->fields ) ) 	{
      		$this->fields[ $key ] = $value;
		    return true;
    	}
    	return false;
  	}

    /**
	 * load data record
	 *
	 * @return void
	 */
	function load( $id, $keyfield = 'id', $character = false )  {   
    
		if(empty($keyfield)) 
			throw new Exception('Invalid key field !',13009898);
			
		if(! is_string($keyfield)) 
			throw new Exception('Invalid key field, is not string value !',13009897);
		
		$keyfield = (string) $keyfield;
		
	    if($character){
			$sql =  "SELECT * FROM ".$this->table." WHERE ".$keyfield."='". $id ."'";
		} else
			$sql =  "SELECT * FROM ".$this->table." WHERE ".$keyfield."=". $id;
   
        $res = $this->DatabasePointer->prepare($sql);
        $res->execute();

        $row = $res->fetch(PDO::FETCH_ASSOC);
      
      	if(is_array($row))
		{
	    $this->id = $id;

        foreach( array_keys( $row ) as $key )
			$this->fields[ $key ] = $row[ $key ];
			
		}
		else return false;
		
		return true;
     }

    /**
	 * update data record
	 *
	 * @return void
	 */
    function update($character = false,$idc = false){

       $sets = array();

       foreach( array_keys( $this->fields ) as $field ) {
            if($field == 'id' && $idc || $field != 'id'){
               $sets []= $field . '=' . "'".$this->fields[ $field ]."'";  } else
               $sets []= $field . '=' .     $this->fields[ $field ];
       }
   	   $set = join( ", ", $sets );

		if($character){
        	$sql = 'UPDATE '.$this->table.' SET '.$set. ' WHERE id=\''.$this->id.'\'';
        } else
        	$sql = 'UPDATE '.$this->table.' SET '.$set. ' WHERE id='.$this->id;

	   return $this->DatabasePointer->exec($sql);
    }
  
    /**
	 * function Delete
	 *
	 * @return void
	 */
	 function delete(){
  	      return $this->DatabasePointer->exec('DELETE FROM '.$this->table.' WHERE id=' .$this->id);  	      
     }

    /**
	 * function Insert
	 *
	 * @return void
	 */
     function insert(){
   
	    $sets   = array();
    
		$fields = join( ", ", array_keys( $this->fields ) );

	    foreach( array_keys( $this->fields ) as $field )   $inspoints []= "?";

	    $inspt = join( ", ", $inspoints );

	    foreach( array_keys( $this->fields ) as $field ) {
	      $sets []=  "'".$this->fields[ $field ]."'";
        }
		$set = join( ", ", $sets );

		$sql = "INSERT INTO ".$this->table.  " ( $fields ) VALUES ( $set )";
		
	#	echo $sql;
	    $count = $this->DatabasePointer->exec($sql);

#    $res = $db->query( "SELECT last_insert_id()" );
#    $res->fetchInto( $row );
#    $this->id = $row[0];
#    return $row[0];
     }


	private function array_empty($array)
	{
		$array=array_unique($array);

		return (count($array)>0) ? false : true;
	}
    /**
	 * function drop down
	 *
	 * @return void
	 */
	public function resultData($fields=array(),$sort='', $selectedAll=true ,$id='' ,$keyfield = 'id'  )
	{
		if(is_array($fields) && ! $this->array_empty($fields)){
			$eFields = join( ", ", array_values( $fields ) );
		 }
		else $eFields = '*';

	   	$sortierung = ( ! empty($sort)) ? " order by ".$sort : ''; 
	  		
		if($selectedAll){
			$sql =  "SELECT ".$eFields." FROM ".$this->table . $sortierung;			
		}
		else
	 	{ 	
			if(empty($keyfield)) 
				throw new Exception('Invalid key field !',13009898);
			
			if(! is_string($keyfield)) 
				throw new Exception('Invalid key field, is not string value !',13009897);
		
			$keyfield = (string) $keyfield;

			if(empty($id)) 
				throw new Exception('Invalid value !',13009898);

	    	$sql =  "SELECT ".$eFields." FROM ".$this->table." WHERE ".$keyfield."=". $id;
  		    $sql .= $sortierung;
		}
  
        $res = $this->DatabasePointer->prepare($sql);
        $res->execute();

        $row = $res->fetchAll(PDO::FETCH_ASSOC);
	
		return $row;
	}

	 
//-----------------------------------------------------------------------
// DropDown Liste aus einer Tabelle zusammenstellen
//-----------------------------------------------------------------------
// Parameter:
// @ $dd_id       - Vorgabe ID für Selected (optional)
// @ $dd_sel      - ID, gegen die $dd_id geprüft wird
// @ $dd_value    - Value Wert für DropDown Box
// @ $dd_bez      - Bezeichnung für DropDown Box
// @ $dd_sort     - Wonach soll die DropDown Box sortiert werden ? (optional)
// @ $dd_null     - (0=Kein; 1=Zusätzlicher Nulleintrag  Value='0')
// @ $dd_aktiv    - nur Aktive Sätze (=1) selektieren
//-----------------------------------------------------------------------
	function dropdown($showField='', $name='selectbox', $selectedAll=true 
	
	 ,$dd_id='2'
	 ,$keyfield = 'id'
	 ,$dd_sort=''
	 ,$dd_value='id'
	 ,$dd_sel='id'
	 ,$dd_null=null 
	 
	 ){

		$dd_liste = '';

	   	$dd_sortierung = ( ! empty($dd_sort)) ? " order by ".$dd_sort : ''; 
	  		
		if($selectedAll){
			$sql =  "SELECT * FROM ".$this->table . $dd_sortierung;			
		}
		else
	 	{ 	
			if(empty($keyfield)) 
				throw new Exception('Invalid key field !',13009898);
			
			if(! is_string($keyfield)) 
				throw new Exception('Invalid key field, is not string value !',13009897);
		
			$keyfield = (string) $keyfield;
			$name = (string) $name;

	    	$sql =  "SELECT * FROM ".$this->table." WHERE ".$keyfield."=". $id;
  		    $sql .= $dd_sortierung;
		}
  
        $res = $this->DatabasePointer->prepare($sql);
        $res->execute();

        $row = $res->fetchAll(PDO::FETCH_ASSOC);
      
#		$dd_liste = "<select name=".$name.">";

		if($dd_null==1){ $dd_liste .= "<option value=\"0\">-</option>\n"; }

        // Alle Datensätze durchlaufen
        // [0][Array]
		foreach( $row as $key => $fieldArr )
		{
		// Datensatz bearbeiten
		// 'selected' 			
		   $SEL = ""; 

				if(!empty($dd_sel))
				{
           			if($dd_id==$fieldArr[$dd_sel]) $SEL = "selected";
				}

		$dd_liste .= "<option value=\"".$fieldArr[$dd_value]."\" ".$SEL.">".$fieldArr[$showField]."</option>\n";
	
		}
#		$dd_liste .= "</select>" . "\r\n";
		
		return $dd_liste;
	}

	function ul($showField='', $name='selectbox', $selectedAll=true 
	
	 ,$dd_id='2'
	 ,$keyfield = 'id'
	 ,$dd_sort=''
	 ,$dd_value='id'
	 ,$dd_sel='id'
	 ,$dd_null=null 
	 
	 ){

		$dd_liste = '';

	   	$dd_sortierung = ( ! empty($dd_sort)) ? " order by ".$dd_sort : ''; 
	  		
		if($selectedAll){
			$sql =  "SELECT * FROM ".$this->table . $dd_sortierung;			
		}
		else
	 	{ 	
			if(empty($keyfield)) 
				throw new Exception('Invalid key field !',13009898);
			
			if(! is_string($keyfield)) 
				throw new Exception('Invalid key field, is not string value !',13009897);
		
			$keyfield = (string) $keyfield;
			$name = (string) $name;

	    	$sql =  "SELECT * FROM ".$this->table." WHERE ".$keyfield."=". $id;
  		    $sql .= $dd_sortierung;
		}
  
        $res = $this->DatabasePointer->prepare($sql);
        $res->execute();

        $row = $res->fetchAll(PDO::FETCH_ASSOC);
      
		$dd_liste = "<ul>";

        // Alle Datensätze durchlaufen
        // [0][Array]
		foreach( $row as $key => $fieldArr )
		{
			$dd_liste .= "<li>".$fieldArr[$showField]."</li>\n";
		}
		$dd_liste .= "</ul>" . "\r\n";
		
#echo $dd_liste;		
		return $dd_liste;
	}

    /**
	 * function unorded list (<ul><li>)
	 *
	 * @return void
	 */
	function ul1( $showField='', $id='', $keyfield = 'id', $selectedAll=true ){

		if($selectedAll){
			$sql =  "SELECT * FROM ".$this->table;
			
			 if(isset($showField) && !empty($showField)){
			  $sql .= " ORDER BY ".$showField;
			  }
		}
		else
	 	{ 	
			if(empty($keyfield)) 
				throw new Exception('Invalid key field !',13009898);
			
			if(! is_string($keyfield)) 
				throw new Exception('Invalid key field, is not string value !',13009897);
		
			$keyfield = (string) $keyfield;


			$sql =  "SELECT * FROM ".$this->table." WHERE ".$keyfield."=". $id;

			 if(isset($showField) && !empty($showField)){
			  $sql .= " ORDER BY ".$showField;
			  }
		}
  
        $res = $this->DatabasePointer->prepare($sql);
        $res->execute();

        $row = $res->fetchAll(PDO::FETCH_ASSOC);
      
echo "<ul>";
print_r($row);
        foreach( $row as $key => $value )
		{
		 if(is_array($value)){
	        foreach( $value as $k => $v )
			{
			 if(isset($showField) && !empty($showField)){
			  if($showField == $k){

echo "<li>".$v."</li>";
}
} else
echo "<li>".$v."</li>";
			}	  
		  }	
		}
echo "</ul><br>";
	}

/*
  function delete_all()
  {
    global $db;
    $sth = $db->prepare( 'DELETE FROM '.$this->table );
    $db->execute( $sth );
  }
*/
}

?>