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
	<h1>Insert the user!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="firstName">First Name</label>   
			<input type="text" name="FirstName">
		</p>
		<p>
			<label for="firstName">Last Name</label> 
			<input type="text" name="LastName">
		</p>
		<p>
			<label for="firstName">Age</label> 
			<input type="text" name="Age">
		</p>
		<p>
			<label for="firstName">Years of Experience</label> 
			<input type="text" name="YearsOfExperience">
		</p>
		<p>
			<label for="firstName">Specialization</label> 
			<input type="text" name="Specialization">
		</p>
		<p>
			<label for="firstName">Branch</label> 
			<input type="text" name="Branch">
		</p>
		<p>
			<input type="submit" name="insertUserBtn">
		</p>
	</form>
</body>
</html>