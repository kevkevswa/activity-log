<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<?php $getUserByID = getUserByID($pdo, $_GET['id']); ?>
	<h1>Edit the user!</h1>
	<form action="core/handleForms.php?id=<?php echo $_GET['id']; ?>" method="POST">
        <p>
			<label for="MED ID">MED ID</label> 
			<input readonly type="text" name="med_id" value="<?php echo $getUserByID['med_id']; ?> ">
		</p>
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="FirstName" value="<?php echo $getUserByID['FirstName']; ?>">
		</p>
		<p>
			<label for="firstName">Last Name</label> 
			<input type="text" name="LastName" value="<?php echo $getUserByID['LastName']; ?>">
		</p>
		<p>
			<label for="firstName">Age</label> 
			<input type="text" name="Age" value="<?php echo $getUserByID['Age']; ?>">
		</p>
		<p>
			<label for="firstName">Years of Experience</label> 
			<input type="text" name="YearsOfExperience" value="<?php echo $getUserByID['YearsOfExperience']; ?>">
		</p>
		<p>
			<label for="firstName">Specialization</label> 
			<input type="text" name="Specialization" value="<?php echo $getUserByID['Specialization']; ?>">
		</p>
		<p>
			<label for="firstName">Branch</label> 
			<input type="text" name="Branch" value="<?php echo $getUserByID['Branch']; ?>">
		</p>
		<p>
			<input type="submit" value="Save" name="editUserBtn">
		</p>
	</form>
</body>
</html>