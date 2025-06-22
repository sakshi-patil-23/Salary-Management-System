<!DOCTYPE html>
<html>

<head>
    <title>Delete Employee Information</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
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
            margin: 0;
            padding-left: 45%;
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
            margin-top: 140px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #004d40;
        }

        select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        select:focus {
            border-color: #2196f3;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(21, 101, 192, 0.3);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #004d40;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 10px;
            }

            .header ul {
                flex-wrap: wrap;
                justify-content: center;
                padding: 10px 0;
                gap: 10px;
            }

            .container {
                width: 90%;
                margin-top: 160px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="logo.png" alt="Company Logo">
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
        <h2>Remove Employee</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <select id="email" name="email" required>
                <option value="" disabled selected>Select Employee Email</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "wtl_project");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT email FROM employees WHERE status = 'approved'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['email']) . "'>" . htmlspecialchars($row['email']) . "</option>";
                    }
                } else {
                    echo "<option disabled>No approved employees found</option>";
                }

                $conn->close();
                ?>
            </select>
            <button type="submit" name="submit">Remove Employee</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $conn = new mysqli('localhost', 'root', '', 'wtl_project');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $email = $conn->real_escape_string($_POST['email']);
            $sql = "DELETE FROM employees WHERE email='$email'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Record deleted successfully'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
            } else {
                echo "<p style='color: red;'>Error deleting record: " . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>

</html>
