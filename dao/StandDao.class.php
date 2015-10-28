<?php

@require_once "../to/Stand.class.php";
@require_once "../dao/CompanyDao.class.php";

define("STAND_BASE_SELECT",
"select stand.*, company.*" .
" from stand" .
" left join company on company.company_id=stand.owner_id"
);

class StandDao {


    function __construct() {
    }
	
    private function getNextId($conn){
    	$sql = "select nextval('stand_stand_id_seq');";
    
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
    
    public function getById($standId, $conn){
    	$sql  = constant("STAND_BASE_SELECT");
    	$sql .= " where stand.stand_id=$1";
    	
    	$stmt = $conn->getStmt($sql);
    	$stmt->setInt(1, $standId);
    	$ret = $stmt->execStmt();
    	$stmt->close();
    	
    	if (@pg_num_rows($ret) == 1){
    		return $this->toObject(@pg_fetch_assoc($ret));
    	}else{
    		return null;
    	}    	 
    }
    
    public function save($objStand, $conn){
    	
    	$objStand->setStandId(StandDao::getNextId($conn));
    	
    	$sql   = "insert into stand";
    	$sql  .= " (stand_id, event_id, stand_number, corridor, price)";
    	$sql  .= " values ($1, $2, $3, $4, $5)";

		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $objStand->getStandId());
		$stmt->setInt(2, $objStand->getEventId());
		$stmt->setInt(3, $objStand->getStandNumber());
		$stmt->setInt(4, $objStand->getCorridor());
		$stmt->setInt(5, $objStand->getPrice());
		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;
    }
    
    public function setOwner($standId, $ownerId, $conn){
    	$sql   = "update stand";
    	$sql  .= " set owner_id=$1";
    	// update only if owner_id still is null
    	$sql  .= " where stand_id=$2 and owner_id is null";
    	
    	$stmt = $conn->getStmt($sql);
    	$stmt->setInt(1, $ownerId);
    	$stmt->setInt(2, $standId);
    	$ret = $stmt->execStmt();
    	$stmt->close();
    	
    	// pg_affected_rows==1: ensure record was updated
    	return $ret && (@pg_affected_rows($ret) == 1);    	 
    }
    
	public function listByEventId($eventId, $conn){
		$sql  = constant("STAND_BASE_SELECT");
		$sql .= " where stand.event_id=$1";
		$sql .= " order by stand_number, corridor";

		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $eventId);
		$ret = $stmt->execStmt();
		$stmt->close();

		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);			
		}else{
			return null;
		}						
	}
	
	public function countRemainingByEventId($eventId, $conn){
		$sql  = "select count(1) from stand";
		$sql .= " where stand.event_id=$1 and owner_id is null";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $eventId);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) > 0){
			$row = @pg_fetch_assoc($ret);
			return $row["count"];
		}else{
			return 0;
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

        $obj = new Stand();
        
        if (isset($row["stand_id"])) $obj->setStandId($row["stand_id"]);
        if (isset($row["event_id"])) $obj->setEventId($row["event_id"]);
        if (isset($row["stand_number"])) $obj->setStandNumber($row["stand_number"]);
        if (isset($row["corridor"])) $obj->setCorridor($row["corridor"]);
        if (isset($row["price"])) $obj->setPrice($row["price"]);

        if (isset($row["owner_id"]) && $row["owner_id"] != null && $row["owner_id"] > 0) {        	
        	$obj->setObjOwner(CompanyDao::toObject($row));        	
        }
        
        return $obj;
    }

}
?>
