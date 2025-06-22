<?php
session_start();

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "wtl_project"; // used as per your first script

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['e_mail'])) {
    header("Location: employee_login.html");
    exit();
}

$email = $_SESSION['e_mail'];

$sql = "SELECT * FROM salaries WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salary Details</title>
    <style>
           body {
          
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 1px 15px;
            background-color: #a0c7ef;
            z-index: 1000;
        }

        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .header ul {
            list-style: none;
            margin: 0;
            padding-left: 65%;
            display: flex;
            gap: 10px;
        }

        .header a {
            text-decoration: none;
            font-size: 16px;
            color: black;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .header a:hover {
            background-color: lightgray;
        }

        .container {
            margin-top: 100px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #9370DB;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #e6e6fa;
        }

        .btn {
            padding: 5px 10px;
            background-color: #9370DB;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #7a60b4;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">
        <img src="logo.png" alt="Company Logo">
    </div>
    <ul>
        <a href="employee_home.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="pay_details.php">Pay Slip</a>
        <a href="home.html" class="logout-button" onclick="logout()">Logout</a>
    </ul>
</div>
<div class="container">
    <h2>Salary / Pay Slip Details</h2>

<?php if ($result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Year</th>
            <th>Basic</th>
            <th>Working Days</th>
            <th>Present Days</th>
            <th>HRA</th>
            <th>Other Allowances</th>
            <th>Deduction/Day</th>
            <th>Tax</th>
            <th>PF</th>
            <th>Gross</th>
            <th>Net</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['month'] ?></td>
            <td><?= $row['year'] ?></td>
            <td><?= $row['basic'] ?></td>
            <td><?= $row['working_days'] ?></td>
            <td><?= $row['present_days'] ?></td>
            <td><?= $row['hra'] ?></td>
            <td><?= $row['other_allowances'] ?></td>
            <td><?= $row['deduction_per_day'] ?></td>
            <td><?= $row['tax'] ?></td>
            <td><?= $row['pf'] ?></td>
            <td><?= $row['gross'] ?></td>
            <td><?= $row['net'] ?></td>
            <td>
                <a class="btn" href="print_payslip.php?email=<?= urlencode($row['email']) ?>&month=<?= urlencode($row['month']) ?>&year=<?= urlencode($row['year']) ?>" target="_blank">View Pay Slip</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<?php else: ?>
    <p style="text-align:center;">No salary records found.</p>
<?php endif; ?>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
