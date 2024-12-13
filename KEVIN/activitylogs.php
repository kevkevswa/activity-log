<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
	<div class="tableClass">
		<table style="width: 100%;" cellpadding="20">
			<tr>
				<th>Activity Log ID</th>
				<th>Operation</th>
				<th>Med ID </th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Years of Experience</th>
				<th>Specialization</th>
				<th>Branch</th>
				<th>Updated At</th>
				<th>Updated By</th>
			</tr>
			<?php $getAllActivityLogs = getAllActivityLogs($pdo); ?>
			<?php foreach ($getAllActivityLogs as $row) { ?>
			<tr>
				<td><?php echo $row['activity_log_id']; ?></td>
				<td><?php echo $row['Operation']; ?></td>
				<td><?php echo $row['med_id']; ?></td>
				<td><?php echo $row['FirstName']; ?></td>
				<td><?php echo $row['LastName']; ?></td>
				<td><?php echo $row['YearsOfExperience']; ?></td>
				<td><?php echo $row['Specialization']; ?></td>
				<td><?php echo $row['Branch']; ?></td>
				<td><?php echo $row['last_updated']; ?></td>
				<td><?php echo $row['last_update_by']; ?></td>
			</tr>
			<?php } ?>
		</table>
</body>
</html>