<?php  

require_once 'dbConfig.php';
require_once 'models.php';


if (isset($_POST['insertUserBtn'])) {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Age = $_POST['Age'];
    $YearsOfExperience = $_POST['YearsOfExperience'];
    $Specialization = $_POST['Specialization'];
    $Branch = $_POST['Branch'];
	

	if ($insertUser) {
		$_SESSION['message'] = "Successfully inserted!";
		header("Location: ../index.php");
	}

	if (!empty($FirstName) && !empty($LastName) && !empty($Age) && !empty($YearsOfExperience) && !empty($Specialization)&& !empty($Branch)) {
		$insertUser = insertNewUser($pdo, $FirstName, $LastName, $Age, $YearsOfExperience, $Specialization,$Branch, $_SESSION['username'] );
		$_SESSION['status'] =  $insertUser['status']; 
		$_SESSION['message'] =  $insertUser['message']; 
		header("Location: ../index.php");
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../index.php");
	}

}



if (isset($_POST['editUserBtn'])) {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Age = $_POST['Age'];
    $YearsOfExperience = $_POST['YearsOfExperience'];
    $Specialization = $_POST['Specialization'];
    $Branch = $_POST['Branch'];

    $editUser = editUser($pdo, $FirstName, $LastName, $Age, $YearsOfExperience, $Specialization,$Branch, $_SESSION['username'],$_GET['id']);
    if ($editUser) {
        $_SESSION['message'] = "Successfully edited!";
        header("Location: ../index.php");
      
    }
}


if (isset($_POST['deleteUserBtn'])) {
	$deleteUser = deleteUser($pdo,$_GET['id']);
	if ($deleteUser) {
		$_SESSION['message'] = "Successfully deleted!";
		header("Location: ../index.php");
	}
}

if (isset($_GET['searchBtn'])) {
	$searchForAUser = searchForAUser($pdo, $_GET['searchInput']);
	foreach ($searchForAUser as $row) {
		echo "<tr> 
				<td>{$row['med_id']}</td>
				<td>{$row['FirstName']}</td>
				<td>{$row['LastName']}</td>
				<td>{$row['Age']}</td>
				<td>{$row['YearsOfExperience']}</td>
				<td>{$row['Specialization']}</td>
			  </tr>";
	}
}
if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUserHr($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
			$_SESSION['message'] = $insertQuery['message'];

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../registration.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../registration.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../registration.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$usernameFromDB = $loginQuery['userInfoArray']['username'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			header("Location: ../index.php");
		}

		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}


?>