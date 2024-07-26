<?php
$servername = "localhost";
$username = "root";  // Change to your MySQL username
$password = "";      // Change to your MySQL password
$dbname = "employeerecords_002";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create
if (isset($_POST['add'])) {
    $EmployeeName = $_POST['EmployeeName'];
    $Birthdate = $_POST['Birthdate'];
    $sql = "INSERT INTO Employee (EmployeeName, Birthdate) VALUES ('$EmployeeName', '$Birthdate')";
    $conn->query($sql);
}

// Handle Update
if (isset($_POST['update'])) {
    $NationalID = $_POST['NationalID'];
    $EmployeeName = $_POST['EmployeeName'];
    $Birthdate = $_POST['Birthdate'];
    $sql = "UPDATE Employee SET EmployeeName='$EmployeeName', Birthdate='$Birthdate' WHERE NationalID=$NationalID";
    $conn->query($sql);
}

// Handle Delete
if (isset($_POST['delete'])) {
    $NationalID = $_POST['NationalID'];
    $sql = "DELETE FROM Employee WHERE NationalID=$NationalID";
    $conn->query($sql);
}

// Fetch Data
$sql = "SELECT * FROM Employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Example with Arabic Text</title>
</head>
<body>
    <h1>CRUD Example with Arabic Text</h1>

    <!-- Create -->
    <form method="POST">
        <input type="text" name="EmployeeName" placeholder="Enter Employee Name" required>
        <input type="date" name="Birthdate" placeholder="Enter Birthdate" required>
        <button type="submit" name="add">Add</button>
    </form>

    <!-- Read -->
    <h2>Data</h2>
    <form method="POST">
        <label>
            <input type="checkbox" name="show_NationalID" <?php if (isset($_POST['show_NationalID'])) echo 'checked'; ?>> Show National ID
        </label>
        <label>
            <input type="checkbox" name="show_EmployeeName" <?php if (isset($_POST['show_EmployeeName'])) echo 'checked'; ?>> Show Employee Name
        </label>
        <label>
            <input type="checkbox" name="show_Birthdate" <?php if (isset($_POST['show_Birthdate'])) echo 'checked'; ?>> Show Birthdate
        </label>
        <button type="submit">Filter</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <?php if (isset($_POST['show_NationalID'])) echo '<th>National ID</th>'; ?>
                <?php if (isset($_POST['show_EmployeeName'])) echo '<th>Employee Name</th>'; ?>
                <?php if (isset($_POST['show_Birthdate'])) echo '<th>Birthdate</th>'; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <?php if (isset($_POST['show_NationalID'])) echo '<td>' . $row['NationalID'] . '</td>'; ?>
                <?php if (isset($_POST['show_EmployeeName'])) echo '<td>' . $row['EmployeeName'] . '</td>'; ?>
                <?php if (isset($_POST['show_Birthdate'])) echo '<td>' . $row['Birthdate'] . '</td>'; ?>
                <td>
                    <!-- Update -->
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="NationalID" value="<?php echo $row['NationalID']; ?>">
                        <input type="text" name="EmployeeName" value="<?php echo $row['EmployeeName']; ?>">
                        <input type="date" name="Birthdate" value="<?php echo $row['Birthdate']; ?>">
                        <button type="submit" name="update">Update</button>
                    </form>
                    <!-- Delete -->
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="NationalID" value="<?php echo $row['NationalID']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
