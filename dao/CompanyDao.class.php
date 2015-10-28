<?php

@require_once "../to/Company.class.php";

define("COMPANY_BASE_SELECT",
"select company.*" .
" from company");

class CompanyDao {


    function __construct() {
    }
	
	private function getNextId($conn){
		$sql = "select nextval('company_company_id_seq');";
		
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
	
	public function getIdByEmail($email, $conn){
		
		if (trim($email)=="") return false;
		
		$sql = "select company_id " .
				" from company" .
				" where email=$1" .
				" and email is not null";
				
		$stmt = $conn->getStmt($sql);
		$stmt->setString(1, $email);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		if (@pg_num_rows($ret) == 1){
			$row = @pg_fetch_assoc($ret);			
			return $row["company_id"];			
		}else{
			return -1;
		}		
	}
	
	public function listAll($conn){
		$sql  = constant("COMPANY_BASE_SELECT");
		
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
		
		if ($obj->getCompanyId() > 0){
			$sql = "update company set" .
					" name=$2," .
					" email=$3," .
					" phone=$4," .
					" admin_name=$5" .
					" where company_id=$1";			
			$stmt = $conn->getStmt($sql);
			$stmt->setInt(1, $obj->getCompanyId());
			$stmt->setString(2, $obj->getName());
			$stmt->setString(3, $obj->getEmail());
			$stmt->setString(4, $obj->getLogin());
		}else{
			
			$id = $this->getNextId($conn);
			
			if ($id <= 0) return false;
			
			$obj->setCompanyId($id);
			
			$sql = "insert into company" .
					" (company_id, phone, name, email, admin_name, pass)" .
					" values" .
					" ($1, $2, $3, $4, $5, $6)";						
			$stmt = $conn->getStmt($sql);
			$stmt->setInt(1, $obj->getCompanyId());
			$stmt->setString(2,$obj->getPhone());
			$stmt->setString(3, $obj->getName());
			$stmt->setString(4, $obj->getEmail());
			$stmt->setString(5, $obj->getAdminName());
			$stmt->setString(6, crypt($obj->getPass()));
		}

		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;						
	}
	
	public function getById($id, $conn){
		
		$sql  = constant("COMPANY_BASE_SELECT");
		$sql .= " where company_id=$1";

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
		
		$sql  = "delete from company";
		$sql .= " where company_id=$1";
		
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $id);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;
	}
	
	public function checkCurrentPass($idCompany, $pass, $conn){
		if (trim($pass)=="")
			return false;
		
		$sql = "select pass " .
				" from company" .
				" where company_id=$1";
		$stmt = $conn->getStmt($sql);
		$stmt->setInt(1, $idCompany);
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
	
	public function changePass($idCompany, $newPass, $conn){
		$sql = "update company" .
				" set pass=$1" .
				" where company_id=$2";
		$stmt = $conn->getStmt($sql);
		$stmt->setString(1, crypt($newPass));
		$stmt->setInt(2, $idCompany);
		$ret = $stmt->execStmt();
		$stmt->close();
		
		return $ret;
	}
	
    private function toList($result) {
        $retorno = array ();

        while ($row = pg_fetch_assoc($result)) {
            $retorno[] = CompanyDao::toObject($row);
        }

        return $retorno;

    }

    public static function toObject($row) {

        $objCompany = new Company();
		
        if (isset($row["company_id"])) $objCompany->setCompanyId($row["company_id"]);
		if (isset($row["name"])) $objCompany->setName($row["name"]);
		if (isset($row["email"])) $objCompany->setEmail($row["email"]);
		if (isset($row["phone"])) $objCompany->setPhone($row["phone"]);
		if (isset($row["admin_name"])) $objCompany->setAdminName($row["admin_name"]);
		
        return $objCompany;
    }

}
?>
