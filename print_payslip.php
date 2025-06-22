<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wtl_project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'];
$month = $_GET['month'];
$year = $_GET['year'];

$sql = "SELECT * FROM salaries WHERE email=? AND month=? AND year=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $month, $year);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Slip - <?= htmlspecialchars($month) ?> <?= htmlspecialchars($year) ?></title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .header {
            border: 1px solid #9370DB;
            padding: 10px;
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 100px;
        }

        .header h1, .header h2 {
            text-align: center;
        }

        table {
            width: 60%;
            margin: auto;
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

        @media print {
            .no-print {
                display: none;
            }
        }

        .print-btn {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 15px;
            background-color: #9370DB;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #7a60b4;
        }
    </style>
</head>
<body onload="window.print()">

<div class="header">
    <div class="logo">
        <img src="logo.png" alt="Company Logo">
    </div>
    <h1>InnovaTech</h1>
    <h2>Pay Slip for <?= htmlspecialchars($month) ?> <?= htmlspecialchars($year) ?></h2>
</div>

<?php if ($row): ?>
<table>
    <tr><th>Email</th><td><?= $row['email'] ?></td></tr>
    <tr><th>Month</th><td><?= $row['month'] ?></td></tr>
    <tr><th>Year</th><td><?= $row['year'] ?></td></tr>
    <tr><th>Basic</th><td><?= $row['basic'] ?></td></tr>
    <tr><th>Working Days</th><td><?= $row['working_days'] ?></td></tr>
    <tr><th>Present Days</th><td><?= $row['present_days'] ?></td></tr>
    <tr><th>HRA</th><td><?= $row['hra'] ?></td></tr>
    <tr><th>Other Allowances</th><td><?= $row['other_allowances'] ?></td></tr>
    <tr><th>Deduction per Day</th><td><?= $row['deduction_per_day'] ?></td></tr>
    <tr><th>Tax</th><td><?= $row['tax'] ?></td></tr>
    <tr><th>PF</th><td><?= $row['pf'] ?></td></tr>
    <tr><th>Gross</th><td><?= $row['gross'] ?></td></tr>
    <tr><th>Deductions</th><td><?= $row['deductions'] ?></td></tr>
    <tr><th>Net</th><td><?= $row['net'] ?></td></tr>
</table>
<?php else: ?>
<p style="text-align:center; color: red;">No record found for this pay slip.</p>
<?php endif; ?>

<div class="print-btn no-print">
    <button class="btn" onclick="window.print()">Print Again</button>
</div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
