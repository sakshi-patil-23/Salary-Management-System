<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "wtl_project";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data safely
$name     = $_POST['name'];
$email    = $_POST['email'];
$gender   = $_POST['gender'];
$dob      = $_POST['dob'];
$phone    = $_POST['phone'];
$address  = $_POST['address'];
$password = $_POST['password'];

// Handle image upload
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Check if a file was uploaded
if (!empty($_FILES["profile"]["name"])) {
    $profile = $_FILES["profile"]["name"];
    $target_file = $target_dir . basename($profile);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow only specific formats
    $allowedTypes = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.'); window.history.back();</script>";
        exit;
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
        echo "<script>alert('Error uploading file.'); window.history.back();</script>";
        exit;
    }
} else {
    // Set default profile image based on gender
    if ($gender == "Male") {
        $profile = "male.jpg";
    } elseif ($gender == "Female") {
        $profile = "female.png";
    } else {
        $profile = "other.jpg";
    }
}

// Check if email already exists
$checkEmail = "SELECT email FROM employees WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($checkEmail);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    $stmt->close();

    // Insert new employee
    $insertSQL = "INSERT INTO employees (name, profile, email, gender, dob, phone, address, password)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSQL);
    $stmt->bind_param("ssssssss", $name, $profile, $email, $gender, $dob, $phone, $address, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='employee_login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "<script>alert('Email already registered. Try using a different one.'); window.location.href='employee_registeration.html';</script>";
    $stmt->close();
}

$conn->close();
?>
