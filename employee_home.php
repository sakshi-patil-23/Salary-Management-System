<?php
session_start(); // Start the session here


if (!isset($_SESSION['e_mail'])) {
    header("Location: employee_login.php"); // Redirect to the login page if not logged in
    exit;
}
?>

<html>
<head>
    <title>Employee Home page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #e0f7fa;
            text-align: center;
            padding-top: 90px;
        }
        
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 1px 15px;
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
            padding-left: 65%;
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
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }
        
        h2 {
            color: #0056b3;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 10px;
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
        <h2>Welcome to Employee Management System</h2>
        <p>Success is not final, failure is not fatal: It is the courage to continue that counts. - Winston Churchill</p>
        <p>Believe you can and you're halfway there. - Theodore Roosevelt</p>
        <p>Your positive action combined with positive thinking results in success. - Shiv Khera</p>
        <p>Every accomplishment starts with the decision to try. - John F. Kennedy</p>
        <p>Hardships often prepare ordinary people for an extraordinary destiny. - C.S. Lewis</p>
        <p>Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful. - Albert Schweitzer</p>
        <p>Don't watch the clock; do what it does. Keep going. - Sam Levenson</p>
    </div>
</body>
</html>
