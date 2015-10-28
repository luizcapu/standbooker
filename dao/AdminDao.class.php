<?php

@require_once "../to/Admin.class.php";

define("ADMIN_BASE_SELECT",
"select admin.*" .
" from admin");

class AdminDao {


    function __construct() {
    }
	
	private function getNextId($conn){
		$sql = "select nextval('admin_admin_id_seq');";
		
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
	
	public function getIdByLogin($login, $conn){
		
		if (trim($login)=="") return false;
		
		$sql = "select admin_id " .
				" from admin" .
				" where login=$1" .
				" and login is not null";
				
		$stmt = $conn->getStmt($sql);
		$stmt->setString(1, $login);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) == 1){
			$row = @pg_fetch_assoc($ret);			
			return $row["admin_id"];			
		}else{
			return -1;
		}		
	}
	
	public function listAll($conn){
		$sql  = constant("ADMIN_BASE_SELECT");
		
		$stmt = $conn->getStmt($sql);
		$ret = $stmt->execStmt();
		$stmt->close();

		if (@pg_num_rows($ret) > 0){
			return $this->toList($ret);			
		}else{
			return null;
		}						
	}
	
	public function save($obj, $conn){
		
		if ($obj->getAdminId() > 0){
			$sql = "update admin set" .
					" name=$2," .
					" email=$3," .
					" login=$4" .
					" where admin_id=$1";			
			$stmt = $conn->getStmt($sql);
			$stmt->setInt(1, $obj->getAdminId());
			$stmt->setString(2, $obj->getName());
			$stmt->setString(3, $obj->getEmail());
			$stmt->setString(4, $obj->getLogin());
		}else{
			
			$id = $this->getNextId($conn);
			
			if ($id <= 0) return false;
			
			$obj->setAdminId($id);
			
			$sql = "insert into admin" .
					" (admin_id, login, name, email, pass)" .
					" values" .
					" ($1, $2, $3, $4, $5)";						
			$stmt = $conn->getStmt($sql);
			$stmt->setInt(1, $obj->getAdminId());
			$stmt->setString(2,$obj->getLogin());
			$stmt->setString(3, $obj->getName());
			$stmt->setString(4, $obj->getEmail());
			$stmt->setString(5, crypt($obj->getPass()));
		}

		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;						
	}
	
	public function getById($id, $conn){
		
		$sql  = constant("ADMIN_BASE_SELECT");
		$sql .= " where admin_id=$1";

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
	
	public function deleteById($id, $conn){
		
		$sql  = "delete from admin";
		$sql .= " where admin_id=$1";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $id);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;
	}
	
	public function checkCurrentPass($idAdmin, $pass, $conn){
		if (trim($pass)=="")
			return false;
		
		$sql = "select pass " .
				" from admin" .
				" where admin_id=$1";
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $idAdmin);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) > 0){
			$row = @pg_fetch_assoc($ret);
			
			if (trim($row["pass"])=="")
				return false;

			return (crypt($pass, $row["pass"])==$row["pass"]);			
		}else{
			return false;
		}
	}
	
	public function changePass($idAdmin, $newPass, $conn){
		$sql = "update admin" .
				" set pass=$1" .
				" where admin_id=$2";
		$stmt = $conn->getStmt($sql);
		$stmt->setString(1, crypt($newPass));
		$stmt->setInt(2, $idAdmin);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;
	}
	
    private function toList($result) {
        $retorno = array ();

        while ($row = pg_fetch_assoc($result)) {
            $retorno[] = $this->toObject($row);
        }

        return $retorno;

    }

    private function toObject($row) {

        $objAdmin = new Admin();
		
        if (isset($row["admin_id"])) $objAdmin->setAdminId($row["admin_id"]);
		if (isset($row["login"])) $objAdmin->setLogin($row["login"]);
		if (isset($row["name"])) $objAdmin->setName($row["name"]);
		if (isset($row["email"])) $objAdmin->setEmail($row["email"]);

        return $objAdmin;
    }

}
?>
