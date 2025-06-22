<?php
session_start(); // Start the session here

$host = "localhost";
$username = "root";
$password = "";
$dbname = "WTL_Project";

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email exists
    $sql = "SELECT * FROM employees WHERE email = ? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if email is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] == 'Approved') {
            $_SESSION['e_mail'] = htmlspecialchars($email); // Store email in session
            echo '<script>
            window.location.href = "employee_home.php";
            alert("You have logged in successfully...");
            </script>';
            exit();
        } else {
            echo '<script>
            window.location.href = "employee_login.html";
            alert("Login failed. Employee is not approved by the admin!!!");
            </script>';
        }
    } else {
        echo '<script>
        window.location.href = "employee_login.html";
        alert("Login failed. Invalid username or password!!!");
        </script>';
    }

    $stmt->close();
}

$conn->close();
?>
