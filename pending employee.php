<?php
$conn = mysqli_connect("localhost", "root", "", "WTL_Project");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If modal form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['designation']) && isset($_POST['join_date'])) {
    $email = $_POST['email'];
    $designation = $_POST['designation'];
    $join_date = $_POST['join_date'];

    $updateQuery = "UPDATE employees SET designation='$designation', join_date='$join_date', status='Approved' WHERE email='$email'";
    mysqli_query($conn, $updateQuery);
    header("Location: ".$_SERVER['PHP_SELF']."?approved=1");
    exit;
}
?>

<html>
<head>
    <title>Pending Employee Registrations</title>
    <style>
        /* your original CSS code */
        * { margin: 0; padding: 0; }
        body {   background-color: #e0f7fa;; }
        .header { position: fixed; top: 0; width: 100%; display: flex; align-items: center; padding: 3px 15px; background-color: #a0c7ef; }
        .logo img { width: 50px; height: 50px; border-radius: 50%; }
        .header ul { list-style: none; margin: 0%; padding-left: 45%; padding-right: 3%; gap: 10px; display: flex; }
        .header a { text-decoration: none; font-size: 16px; color: black; border-radius: 8px; padding: 10px 15px; }
        .header a:hover { background-color: lightgray; }
        .container { margin-top: 100px; text-align: center; }
        table { margin: 20px auto; border-collapse: collapse; background: white; box-shadow: 0 0 10px rgba(0, 0, 0, 0.355); border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .status-options a { display: inline-block; padding: 8px 10px; margin-right: 10px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 6px; }
        .status-options a:last-child { margin-right: 0; }
        .status-options a:hover { background-color:rgb(34, 84, 40); }

        /* modal styles */
       /* modal styles - updated to match the rest of the design */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #ffffff;
    margin: 8% auto;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(9, 9, 9, 0.2);
    width: 30%;   
}

.close {
    float: right;
    font-size: 24px;
    font-weight: bold;
    color: #2c3e50;
    cursor: pointer;
}

.close:hover {
    color: #000;
}

.modal-content h3 {
    margin-bottom: 15px;
    color: #2c3e50;
    text-align: center;
}

.modal-content label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #333;
}

.modal-content input[type="text"],
.modal-content input[type="date"] {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 14px;
}

.modal-content input[type="submit"] {
    width: 100%;
    margin-top: 20px;
    padding: 10px;
    background-color:rgb(74, 100, 126);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
}

.modal-content input[type="submit"]:hover {
    background-color:rgb(17, 22, 27);
}

    </style>
</head>
<body>
<div class="header">
    <div class="logo">
        <img src="logo.png" alt="Company Logo" width="50" height="50">
    </div>
    <ul>
        <a href="admin_home.html">Home</a>
        <a href="employee_info.php">Employee Information</a>
        <a href="pending employee.php">Pending Employee</a>
        <a href="remove.php">Remove Employee</a>
        <a href="salary_cal.php">Salary Calculation</a>
        <a href="home.html" class="logout-button" onclick="logout()">Logout</a>
    </ul>
</div>

<div class="container">
<?php
$sql = "SELECT * FROM employees WHERE status='Pending'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    echo "<h1 style='text-align: center;'>Pending Employee Registrations</h1>";
    echo "<table>";
    echo "<tr><th>Name</th><th>Email</th><th>DOB</th><th>Gender</th><th>Status</th><th>Phone No</th><th>Address</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["dob"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td class='status-options'>";
        echo "<a href='#' onclick=\"openModal('{$row["email"]}')\">Approve</a>";
        echo "<a href='#' onclick=\"rejectEmployee('{$row["email"]}')\">Reject</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center;'>No pending registrations.</p>";
}
if (isset($_GET['approved']) && $_GET['approved'] == 1) {
    echo "<script>alert('Employee approved successfully!');</script>";
}
?>

<div id="approveModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Approve Employee</h3>
        <form method="post">
            <label for="designation">Designation:</label>
            <input type="text" name="designation" id="designation" required>

            <label for="join_date">Join Date:</label>
            <input type="date" name="join_date" id="join_date" required>

            <input type="hidden" name="email" id="emailInput">
            <input type="submit" value="Approve">
        </form>
    </div>
</div>

<script>
function openModal(email) {
    document.getElementById('emailInput').value = email;
    document.getElementById('approveModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('approveModal').style.display = 'none';
}

function rejectEmployee(email) {
    if (confirm("Are you sure you want to reject this employee?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("ajaxReject=1&email=" + encodeURIComponent(email));

        xhr.onload = function () {
            if (xhr.status === 200) {
                alert("Employee Rejected");
                location.reload();
            }
        };
    }
}
</script>

<?php
// Handle rejection via AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajaxReject"])) {
    $email = $_POST["email"];
    $query = "UPDATE employees SET status='Rejected' WHERE email='$email'";
    mysqli_query($conn, $query);
    exit;
}
?>
</div>
</body>
</html>
