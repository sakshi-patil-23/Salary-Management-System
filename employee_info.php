<?php
$servername = "localhost"; 
$username = "root"; 
$password = ''; 
$dbname = "WTL_Project";

$conn = new mysqli('localhost','root','','WTL_Project');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve emails of only approved employees from the database
$sql = "SELECT * FROM employees WHERE status = 'approved'";

$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
    <html>

    <head>
        <titel>Employee Information</titel>
        <style>
            * {
                margin: 0;
                padding: 0;
            }
            
            body {
                background: rgba(255, 255, 255, 0.503);
                  background-color: #e0f7fa;
            }
            
            .header {
                position: fixed;
                top: 0;
                width: 100%;
                display: flex;
                align-items: center;
                padding: 3px 15px;
                background-color: #a0c7ef;
            }
            
            .logo img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
            }
            
            .header ul {
                list-style: none;
                margin: 0%;
                padding-left: 45%;
                padding-right: 3%;
                gap: 10px;
                display: flex;
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
                text-align: center;
            }
            
            table {
                margin: 20px auto;
                border-collapse: collapse;
                background: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.355);
                border-radius: 10px;
                overflow: hidden;
            }
            
            th,
            td {
                padding: 15px;
                text-align: center;
                border: 1px solid #ddd;
            }
            
            th {
                background-color: #2c3e50;
                color: white;
            }
            
            tr:nth-child(even) {
                background-color: #f2f2f2;
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
            <h1>Employee Information</h1>
            <table border="1">
                <tr>
                    <th>Employee Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Designation</th>
                    <th>Date of Joining</th>
                </tr>     
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["gender"]."</td>";
                        echo "<td>".$row["dob"]."</td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["phone"]."</td>";
                        echo "<td>".$row["address"]."</td>";
                        echo "<td>".$row["designation"]."</td>";
                        echo "<td>".$row["join_date"]."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No results found</td></tr>";
                }
                ?>
            </table>
        </div>
    </body>

    </html>