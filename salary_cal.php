<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salary Calculation</title>
    <style>
        * { margin: 0; padding: 0; }
        body {
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            background-color: #ffffff;
            margin-top: 520px;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            padding-top: 10px;
            margin-bottom: 20px;
            color: #00796b;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            margin-top: 15px;
        }
        input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-top: 3px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004d40;
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
            color: #00796b;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo"><img src="logo.png" alt="Company Logo"></div>
    <ul>
        <a href="admin_home.html">Home</a>
        <a href="employee_info.php">Employee Information</a>
        <a href="pending employee.php">Pending Employee</a>
        <a href="remove.php">Remove Employee</a>
        <a href="salary_cal.html">Salary Calculation</a>
        <a href="home.html" class="logout-button" onclick="logout()">Logout</a>
    </ul>
</div>

<div class="container">
    <h2>Salary Calculation</h2>
    <form onsubmit="calculateSalary(event)">
        <label for="email">Employee Email:</label>
        <select id="email" name="email" required>
            <?php
            $conn = new mysqli("localhost", "root", "", "wtl_project");
            if ($conn->connect_error) die("Connection failed");
            $result = $conn->query("SELECT email FROM employees WHERE status = 'approved'");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['email']}'>{$row['email']}</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="month">Month:</label>
        <select id="month" name="month">
            <?php
            $months = ["January", "February", "March", "April", "May", "June",
                       "July", "August", "September", "October", "November", "December"];
            foreach ($months as $m) echo "<option value=\"$m\">$m</option>";
            ?>
        </select>

        <label for="year">Year:</label>
        <select id="year" name="year" required>
            <?php
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= $currentYear - 20; $i--) echo "<option value='$i'>$i</option>";
            ?>
        </select>

        <label for="basicSalary">Basic Salary</label>
        <input type="number" id="basicSalary" required>
        <label for="workingDays">Total Working Days</label>
        <input type="number" id="workingDays" required>
        <label for="daysPresent">Days Present</label>
        <input type="number" id="daysPresent" required>
        <label for="hra">House Rent Allowance (HRA)</label>
        <input type="number" id="hra" required>
        <label for="otherAllowances">Other Allowances</label>
        <input type="number" id="otherAllowances">
        <label for="deductionPerDay">Deduction per Absent Day</label>
        <input type="number" id="deductionPerDay">
        <label for="tax">Tax Deduction</label>
        <input type="number" id="tax">
        <label for="pf">Provident Fund (PF)</label>
        <input type="number" id="pf">

        <button type="submit">Calculate Salary</button>
    </form>

    <div class="result" id="netSalary"></div>
</div>

<script>
function calculateSalary(e) {
    e.preventDefault();

    const data = {
        email: document.getElementById('email').value,
        month: document.getElementById('month').value,
        year: document.getElementById('year').value,
        basic: parseFloat(document.getElementById('basicSalary').value),
        working_days: parseFloat(document.getElementById('workingDays').value),
        present_days: parseFloat(document.getElementById('daysPresent').value),
        hra: parseFloat(document.getElementById('hra').value),
        other_allowances: parseFloat(document.getElementById('otherAllowances').value || 0),
        deduction_per_day: parseFloat(document.getElementById('deductionPerDay').value || 0),
        tax: parseFloat(document.getElementById('tax').value || 0),
        pf: parseFloat(document.getElementById('pf').value || 0),
    };

    // Validate inputs
    const today = new Date();
    const enteredDate = new Date(`${data.month} 1, ${data.year}`);
    if (enteredDate > today) {
        alert("You cannot enter salary data for a future month.");
        return;
    }

    if (data.present_days > data.working_days) {
        alert("Present days cannot be more than working days.");
        return;
    }

    const monthIndex = new Date(`${data.month} 1, ${data.year}`).getMonth() + 1;
    const daysInMonth = new Date(data.year, monthIndex, 0).getDate();
    if (data.working_days > daysInMonth) {
        alert(`Working days cannot be more than ${daysInMonth} days in ${data.month} ${data.year}.`);
        return;
    }

    const gross = data.basic + data.hra + data.other_allowances;
    const absent = data.working_days - data.present_days;
    const deductions = (absent * data.deduction_per_day) + data.tax + data.pf;
    const net = gross - deductions;

    document.getElementById('netSalary').innerText = `Net Salary: ₹ ${net.toFixed(2)}`;

    data.gross = gross;
    data.deductions = deductions;
    data.net = net;

    fetch('store_salary.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(data).toString()
    })
    .then(response => response.text())
    .then(msg => alert(msg))
    .catch(error => alert("Error: " + error));
}
</script>

</body>
</html>
