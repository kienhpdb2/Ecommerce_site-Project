<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QRCode Generator</title>
    <style>
        body {
            background-image: linear-gradient(90deg, #a18cd1 0%, #fbc2eb 100%);
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: lightblue;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        form {
            max-width: 500px;
        }

        input[type="text"],
        textarea {
            width: 300px;
            padding: 10px;
            margin-bottom: 20px;
            margin-top: 10px;
            border-radius: 5px;
            border: none;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 1);
            cursor: pointer;
            width: 200px;
            margin-bottom: 10px;
            background-color: #3e8e41;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 0px;
        }

        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 0px;
        }

        label {
            display: block;
        }
       button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 1);
            cursor: pointer;
            width: 200px;
        }
        img {
            margin-top: 20px; 
            margin-bottom: 10px; 
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="page-header">QRCode Generator</h1>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?php
                $nameErr = $studentIdErr = "";
                $name = $studentId = "";
                $isValid = true;
            
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["fullname"]) || !preg_match("/^[a-zA-Z ]*$/", $_POST["fullname"]) || trim($_POST["fullname"]) === "") {
                        $nameErr = "Fullname is required and should only contain letters and white space.";
                        $isValid = false;
                    } else {
                        $name = test_input($_POST["fullname"]);
                        $isValid = true;
                    }
                    
                    if (empty($_POST["student_id"]) || !is_numeric($_POST["student_id"]) || strpos($_POST["student_id"], ' ') !== false) {
                        $studentIdErr = "Student ID (MSSV) is required and should only contain numbers without spaces.";
                        $isValid = false;
                    } else {
                        $studentId = test_input($_POST["student_id"]);
                        $isValid = true;
                    }
                }
            
                function test_input($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
            ?>
            <form method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                    <?php if ($nameErr) { echo "<p class='error'>$nameErr</p>"; } ?>
                </div>
                <div class="form-group">
                    <label for="student_id">Student ID (MSSV)</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" required>
                    <?php if ($studentIdErr) { echo "<p class='error'>$studentIdErr</p>"; } ?>
                </div>
                <button type="submit" class="btn btn-primary" name="generate" <?php if (!$isValid) { echo "disabled"; } ?>>Generate QRCode</button>
                <br>
            </form>
        </div>
        <div class="col-sm-3">
            <?php
            if(isset($_POST['generate']) && $isValid){
                $fullname = $_POST['fullname'];
                $student_id = $_POST['student_id'];
                $data = "Full Name: $fullname\nStudent ID (MSSV): $student_id";
                $encoded_data = urlencode($data);
                echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$encoded_data&choe=UTF-8'>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
