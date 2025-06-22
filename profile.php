
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
   


<?php
session_start();

// Debug: check session
// var_dump($_SESSION['email']);

$email = $_SESSION['e_mail'] ?? null;
if (!$email) {
    echo "Session expired. Please <a href='employee_login.html'>login again</a>.";
    exit;
}

$conn = new mysqli("localhost", "root", "", "wtl_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Employee not found for email: $email. Please contact support.";
    echo '<br><a href="employee_home.php">Go back to home</a>';
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Profile</title>
     <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
          
            background-color: #e0f7fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
    position: fixed;
    top: 0;
    width: 100%;
    display: flex;
    align-items: center;
    padding: 1px 15px;
    background-color: #a0c7ef; /* Updated to match Home page */
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


        .profile-container {
            margin-top: 100px;
            display: flex;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 90%;
        }

        .sidebar {
            background:rgb(93, 123, 154);
            padding: 30px;
            color: white;
            width: 250px;
            text-align: center;
        }

        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
            border: 3px solid white;
        }

        .sidebar h3 {
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar p {
            font-size: 14px;
            opacity: 0.9;
        }

        .profile-content {
            padding: 30px;
            width: 100%;
        }

        .profile-content h2 {
            font-size: 24px;
            color:rgb(54, 84, 117);
            margin-bottom: 20px;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info p {
            font-size: 16px;
            background: #eef3fa;
            padding: 10px;
            border-radius: 6px;
        }

        .info p strong {
            color:rgb(55, 84, 115);
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

<?php
$profileImage = !empty($row['profile']) ? 'uploads/' . $row['profile'] : 'logo.png';
?>

<div class="profile-container">
    <div class="sidebar">
        <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Employee Photo">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
      <p style="font-weight: bold; font-size: 22px;"><?php echo htmlspecialchars($row['designation']); ?></p>

    </div>
    <div class="profile-content">
        <h2>Profile Information</h2>
        <div class="info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($row['dob']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
            <p><strong>Join Date:</strong> <?php echo htmlspecialchars($row['join_date']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
            <p><strong>Designation:</strong> <?php echo htmlspecialchars($row['designation']); ?></p>
        </div>
    </div>
</div>

</body>
</html>
