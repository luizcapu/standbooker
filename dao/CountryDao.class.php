<?php

@require_once "../to/Country.class.php";

define("COUNTRY_BASE_SELECT",
"select country.*" .
" from country");

class CountryDao {


    function __construct() {
    }
	
	public function listAll($conn){
		$sql  = constant("COUNTRY_BASE_SELECT");
		$sql .= " order by name";
		
		$stmt = $conn->getStmt($sql);
		$ret = $stmt->execStmt();
		$stmt->close();

		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);			
		}else{
			return null;
		}						
	}
	
	public function listHavingEvents($conn){
		$sql  = constant("COUNTRY_BASE_SELECT");
		$sql .= " where country_id in (select location.country_id from event, location where event.start_date > current_date and location.location_id=event.location_id)";
		$sql .= " order by name";
		
		$stmt = $conn->getStmt($sql);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);
		}else{
			return null;
		}		
	}
	
	public function getById($id, $conn){
		$sql  = constant("COUNTRY_BASE_SELECT");
		$sql .= " where country_id=$1";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $id);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) == 1){
			return $this->toObject(@pg_fetch_assoc($ret));
		}else{
			return null;
		}
	}
	
	public function getByMapRef($mapRef, $conn){
		$sql  = constant("COUNTRY_BASE_SELECT");
		$sql .= " where map_ref=$1";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setString(1, strtoupper($mapRef));
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) == 1){
			return $this->toObject(@pg_fetch_assoc($ret));
		}else{
			return null;
		}	
	}
	
    private function toList($result) {
        $retorno = array ();

        while ($row = pg_fetch_assoc($result)) {
            $retorno[] = $this->toObject($row);
        }

        return $retorno;

    }

    private function toObject($row) {

        $obj = new Country();
		
        if (isset($row["country_id"])) $obj->setCountryId($row["country_id"]);
		if (isset($row["name"])) $obj->setName($row["name"]);
		if (isset($row["map_ref"])) $obj->setMapRef($row["map_ref"]);

        return $obj;
    }

}
?>
