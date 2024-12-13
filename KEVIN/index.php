<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: green; text-align: center; background-color: ghostwhite; border-style: solid;">	
            <?php echo $_SESSION['message']; ?>
        </h1>
    <?php } unset($_SESSION['message']); ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
        <input type="text" name="searchInput" placeholder="Search here">
        <input type="submit" name="searchBtn">
    </form>

    <p><a href="index.php">Clear Search Query</a></p>
    <p><a href="insert.php">Insert New User</a></p>

    <table style="width:100%; margin-top: 20px;">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Years of Experience</th>
            <th>Specialization</th>
            <th>Branch</th>
            <th>Date Added</th>
            <th>Added By</th>
            <th>Last Updated</th>
            <th>Updated By</th>
            <th>Action</th>
        </tr>

        <?php if (!isset($_GET['searchBtn'])) { ?>
            <?php $getAllUsers = getAllUsers($pdo); ?>
            <?php foreach ($getAllUsers as $row) { ?>
                <tr>
                    <td><?php echo $row['FirstName']; ?></td>
                    <td><?php echo $row['LastName']; ?></td>
                    <td><?php echo $row['Age']; ?></td>
                    <td><?php echo $row['YearsOfExperience']; ?></td>
                    <td><?php echo $row['Specialization']; ?></td>
                    <td><?php echo $row['Branch']; ?></td>
                    <td><?php echo $row['date_added']; ?></td>
                    <td><?php echo $row['date_added_by']; ?></td>
                    <td><?php echo $row['last_updated']; ?></td>
                    <td><?php echo $row['last_update_by']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['med_id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $row['med_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <?php $searchForAUser =  searchForAUser($pdo, $_GET['searchInput']); ?>
            <?php foreach ($searchForAUser as $row) { ?>
                <tr>
                    <td><?php echo $row['FirstName']; ?></td>
                    <td><?php echo $row['LastName']; ?></td>
                    <td><?php echo $row['Age']; ?></td>
                    <td><?php echo $row['YearsOfExperience']; ?></td>
                    <td><?php echo $row['Specialization']; ?></td>
                    <td><?php echo $row['Branch']; ?></td>
                    <td><?php echo $row['date_added']; ?></td>
                    <td><?php echo $row['date_added_by']; ?></td>
                    <td><?php echo $row['last_updated']; ?></td>
                    <td><?php echo $row['last_update_by']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['med_id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $row['med_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>	
    </table>
</body>
</html>
