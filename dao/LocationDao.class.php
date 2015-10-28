<?php

@require_once "../to/Location.class.php";

define("LOCATION_BASE_SELECT",
"select location.*, country.name as country_name, country.map_ref as country_map_ref" .
" from location, country" .
" where country.country_id=location.country_id"
);

class LocationDao {


    function __construct() {
    }
	
	public function listByCountryId($countryId, $conn){
		$sql  = constant("LOCATION_BASE_SELECT");
		$sql .= " and location.country_id=$1";
		$sql .= " order by name";

		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $countryId);
		$ret = $stmt->execStmt();
		$stmt->close();

		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);			
		}else{
			return null;
		}						
	}
	
	public function getByMapRef($mapRef, $conn){
		$sql  = constant("LOCATION_BASE_SELECT");
		$sql .= " and location.map_ref=$1";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setString(1, strtolower($mapRef));
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) == 1){
			return LocationDao::toObject(@pg_fetch_assoc($ret));
		}else{
			return null;
		}
	}
	
	public function listHavingEventsByCountry($countryId, $conn){
		$sql  = constant("LOCATION_BASE_SELECT");
		$sql .= " and location.country_id=$1";
		$sql .= " and location_id in (select event.location_id from event where event.start_date > current_date)";
		$sql .= " order by name";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $countryId);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);
		}else{
			return null;
		}		
	}
	
    private function toList($result) {
        $retorno = array ();

        while ($row = pg_fetch_assoc($result)) {
            $retorno[] = LocationDao::toObject($row);
        }

        return $retorno;

    }

    public static function toObject($row) {

        $obj = new Location();
		
        if (isset($row["location_id"])) $obj->setLocationId($row["location_id"]);
        
        if (isset($row["location_name"])) $obj->setName($row["location_name"]);
        elseif (isset($row["name"])) $obj->setName($row["name"]);
        
        if (isset($row["location_map_ref"])) $obj->setMapRef($row["location_map_ref"]);        
		elseif (isset($row["map_ref"])) $obj->setMapRef($row["map_ref"]);
		
		if (isset($row["country_id"])) $obj->getObjCountry()->setCountryId($row["country_id"]);
		if (isset($row["country_name"])) $obj->getObjCountry()->setName($row["country_name"]);
		if (isset($row["country_map_ref"])) $obj->getObjCountry()->setMapRef($row["country_map_ref"]);
		
        return $obj;
    }

}
?>
