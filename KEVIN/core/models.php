<?php  

require_once 'dbConfig.php';



function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM hr_user WHERE username = ?";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute([$username])) {
		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}
	return $response;

}

function insertNewUserHr($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {
		$sql = "INSERT INTO hr_user (username, FirstName, LastName, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}


function getAllUsers($pdo) {
	$sql = "SELECT * FROM medicalprofessionals 
			ORDER BY FirstName ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getUserByID($pdo, $id) {
	$sql = "SELECT * from medicalprofessionals WHERE med_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAUser($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM medicalprofessionals WHERE 
			CONCAT(FirstName,LastName,Age,YearsOfExperience,Specialization) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}



function insertNewUser($pdo,$FirstName,$LastName,$Age,$YearsOfExperience,$Specialization,$Branch, $Added_by) {
	$response = array();
	$sql = "INSERT INTO MedicalProfessionals (FirstName,LastName,Age,YearsOfExperience,Specialization ,Branch, date_added_by) VALUES(?,?,?,?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$insertBranch = $stmt->execute([$FirstName,$LastName,$Age,$YearsOfExperience,$Specialization,$Branch, $Added_by]);

	if ($insertBranch) {
		$findInsertedItemSQL = "SELECT * FROM MedicalProfessionals ORDER BY date_added DESC LIMIT 1";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute();
		$getBranchID = $stmtfindInsertedItemSQL->fetch();

		$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getBranchID['med_id'], 
			$getBranchID['FirstName'], $getBranchID['LastName'], 
			$getBranchID['Age'], $YearsOfExperience,$Specialization,$Branch,$_SESSION['username']);

		if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"Branch addedd successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
		
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of data failed!"
		);

	}

	return $response;
}

function insertAnActivityLog($pdo, $operation, $med_id, $FirstName, 
		$LastName, $Age, $YearsOfExperience,$Specialization,$branch,$username) {

	$sql = "INSERT INTO activity_logs (operation, med_id, FirstName, 
		LastName, Age, YearsOfExperience, Specialization, Branch, last_update_by) VALUES(?,?,?,?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$operation, $med_id, $FirstName, 
	$LastName, $Age, $YearsOfExperience,$Specialization,$branch,$username]);

	if ($executeQuery) {
		return true;
	}

}


function editUser($pdo, $FirstName, $LastName, $Age, $YearsOfExperience, $Specialization,$Branch,$Username, $Med_id) {
    $sql = "UPDATE medicalprofessionals
            SET FirstName = ?,
                LastName = ?,
                Age = ?,
                YearsOfExperience = ?,
                Specialization = ?,
				Branch =?,
				last_update_by =?
            WHERE med_id = ?";
    $stmt = $pdo->prepare($sql);
    $edited_user = $stmt->execute([$FirstName, $LastName, $Age, $YearsOfExperience, $Specialization,$Branch,$Username, $Med_id]);
	if ($edited_user) {

		$findInsertedItemSQL = "SELECT * FROM medicalprofessionals WHERE med_id = ?";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute([$Med_id]);
		$getBranchID = $stmtfindInsertedItemSQL->fetch(); 

		$insertAnActivityLog = insertAnActivityLog($pdo, "UPDATE", $getBranchID['med_id'], 
		$getBranchID['FirstName'], $getBranchID['LastName'], 
		$getBranchID['Age'], $getBranchID['YearsOfExperience'], $getBranchID['Specialization'],$getBranchID['Branch'],$_SESSION['username']);

		if ($insertAnActivityLog) {

			$response = array(
				"status" =>"200",
				"message"=>"Updated the branch successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}

	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error has occured with the query!"
		);
	}

	return $response;
}



function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs 
			ORDER BY last_updated DESC";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

function deleteUser($pdo, $id) {
	$sql = "SELECT * FROM MedicalProfessionals WHERE med_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$id]);
	$getBranchByID = $stmt->fetch();

	$insertAnActivityLog = insertAnActivityLog($pdo, "DELETE", $getBranchByID['med_id'], 
		$getBranchByID['FirstName'], $getBranchByID['LastName'], 
		$getBranchByID['Age'], $getBranchByID['YearsOfExperience'], $getBranchByID['Specialization'],$getBranchByID['Branch'],$_SESSION['username']);
		if ($insertAnActivityLog) {
			$deleteSql = "DELETE FROM MedicalProfessionals WHERE med_id = ?";
			$deleteStmt = $pdo->prepare($deleteSql);
			$deleteQuery = $deleteStmt->execute([$id]);
	
			if ($deleteQuery) {
				$response = array(
					"status" =>"200",
					"message"=>"Deleted the branch successfully!"
				);
			}
			else {
				$response = array(
					"status" =>"400",
					"message"=>"Insertion of activity log failed!"
				);
			}
		}
		else {
			$response = array(
				"status" =>"400",
				"message"=>"An error has occured with the query!"
			);
		}
	
		return $response;
}






?>