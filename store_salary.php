<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "wtl_project";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect POST data
$email = $_POST['email'];
$month = $_POST['month'];
$year = $_POST['year'];
$basic = $_POST['basic'];
$working_days = $_POST['working_days'];
$present_days = $_POST['present_days'];
$hra = $_POST['hra'];
$other_allowances = $_POST['other_allowances'];
$deduction_per_day = $_POST['deduction_per_day'];
$tax = $_POST['tax'];
$pf = $_POST['pf'];
$gross = $_POST['gross'];
$deductions = $_POST['deductions'];
$net = $_POST['net'];

// --- Validation Checks ---

// Prevent future month entry
$currentMonth = date('n');
$currentYear = date('Y');
$enteredMonthNum = date('n', strtotime("1 $month"));

if (($year > $currentYear) || ($year == $currentYear && $enteredMonthNum > $currentMonth)) {
    echo "You cannot store salary for a future month.";
    exit;
}

// Prevent inserting if present_days > working_days
if ($present_days > $working_days) {
    echo "Present days cannot be more than working days.";
    exit;
}

// Prevent if working_days > days in month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $enteredMonthNum, $year);
if ($working_days > $daysInMonth) {
    echo "Working days cannot be more than total days in $month $year.";
    exit;
}

// Check for duplicate record
$check = $conn->prepare("SELECT * FROM salaries WHERE email = ? AND month = ? AND year = ?");
$check->bind_param("sss", $email, $month, $year);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    echo "Record already exists for this employee in $month $year.";
    exit;
}
$check->close();

// Insert new record
$sql = "INSERT INTO salaries (email, month, year, basic, working_days, present_days, hra, other_allowances, deduction_per_day, tax, pf, gross, deductions, net)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiiidddddddd", $email, $month, $year, $basic, $working_days, $present_days, $hra, $other_allowances, $deduction_per_day, $tax, $pf, $gross, $deductions, $net);

if ($stmt->execute()) {
    echo "Salary data stored successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
