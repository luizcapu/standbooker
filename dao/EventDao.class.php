<?php

@require_once "../to/Event.class.php";
@require_once "../dao/LocationDao.class.php";

define("EVENT_BASE_SELECT",
"select event.*, location.name as location_name, location.map_ref as location_map_ref, country.name as country_name, country.map_ref as country_map_ref" .
" from event, location, country" .
" where location.location_id=event.location_id and country.country_id=location.country_id"
);

class EventDao {


    function __construct() {
    }
	
    private function getNextId($conn){
    	$sql = "select nextval('event_event_id_seq');";
    
    	$stmt = $conn->getStmt($sql);
    	$ret  = $stmt->execStmt();
    	$stmt->close();
    
    	$row = @pg_fetch_assoc($ret);
    
    	if ($row["nextval"] > 0){
    		return $row["nextval"];
    	}else{
    		return -1;
    	}
    }
    
    public function getById($eventId, $conn){
    	$sql  = constant("EVENT_BASE_SELECT");
    	$sql .= " and event.event_id=$1";
    	    	
    	$stmt = $conn->getStmt($sql);
    	$stmt->setInt(1, $eventId);
    	$ret = $stmt->execStmt();
    	$stmt->close();
    	
    	if (@pg_num_rows($ret) == 1){
    		return $this->toObject(@pg_fetch_assoc($ret));
    	}else{
    		return null;
    	}
    }
    
    public function save($objEvent, $conn){
    	
    	$objEvent->setEventId(EventDao::getNextId($conn));
    	
    	$sql   = "insert into event";
    	$sql  .= " (event_id, location_id, name, start_date, end_date, address, details)";
    	$sql  .= " values ($1, $2, $3, to_date($4, 'YYYY-MM-DD'), to_date($5, 'YYYY-MM-DD'), $6, $7)";

		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $objEvent->getEventId());
		$stmt->setInt(2, $objEvent->getObjLocation()->getLocationId());
		$stmt->setString(3, $objEvent->getName());
		$stmt->setString(4, $objEvent->getStartDate());
		$stmt->setString(5, $objEvent->getEndDate());
		$stmt->setString(6, $objEvent->getAddress());
		$stmt->setString(7, $objEvent->getDetails());
		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;
    }
    
	public function listByLocationId($locationId, $futures, $conn){
		$sql  = constant("EVENT_BASE_SELECT");
		$sql .= " and location.location_id=$1";
		
		if ($futures){
			$sql .= " and event.start_date >= current_date";				
		}
		
		$sql .= " order by start_date, end_date, name";

		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $locationId);
		$ret = $stmt->execStmt();
		$stmt->close();

		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);			
		}else{
			return null;
		}						
	}
	
	public function listAll($conn){
		$sql  = constant("EVENT_BASE_SELECT");
		$sql .= " order by start_date, end_date, name";
		
		$stmt = $conn->getStmt($sql);
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
            $retorno[] = $this->toObject($row);
        }

        return $retorno;

    }

    private function toObject($row) {

        $obj = new Event();
        
        $obj->setObjLocation(LocationDao::toObject($row));
		
        if (isset($row["event_id"])) $obj->setEventId($row["event_id"]);
        if (isset($row["name"])) $obj->setName($row["name"]);
		if (isset($row["start_date"])) $obj->setStartDate($row["start_date"]);
		if (isset($row["end_date"])) $obj->setEndDate($row["end_date"]);
		if (isset($row["address"])) $obj->setAddress($row["address"]);
		if (isset($row["details"])) $obj->setDetails($row["details"]);
		
        return $obj;
    }

}
?>
