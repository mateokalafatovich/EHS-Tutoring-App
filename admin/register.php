<?php
require_once 'db_con.php';
session_start();
error_log("Session ID: " . session_id());
if (isset($_SESSION['user_login'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $input_arr = array();
    if (empty($name)) {
        $input_arr['input_name_error'] = "Name Is Required!";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $input_arr['input_email_error'] = "Valid Email Is Required!";
    }
    if (empty($username)) {
        $input_arr['input_user_error'] = "Username Is Required!";
    }
    if (empty($password)) {
        $input_arr['input_pass_error'] = "Password Is Required!";
    }

    if (count($input_arr) == 0) {
        if (!$db_con) {
            error_log("Database Connection Failed: " . mysqli_connect_error());
            $error = "Database connection error. Please try again later.";
        } else {
            // Check if username or email already exists
            $stmt = $db_con->prepare("SELECT * FROM `users` WHERE `username` = ? OR `email` = ?");
            if ($stmt === false) {
                error_log("Prepare Error: " . $db_con->error);
                $error = "Database error occurred";
            } else {
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && mysqli_num_rows($result) > 0) {
                    $error = "Username or email already exists!";
                } else {
                    // Hash the password
                    $hashed_password = sha1(md5($password));
                    error_log("Registering user: $username, Hashed Password: $hashed_password");
                    $stmt = $db_con->prepare("INSERT INTO `users` (name, email, username, password, status) VALUES (?, ?, ?, ?, 'inactivo')");
                    if ($stmt === false) {
                        error_log("Prepare Error: " . $db_con->error);
                        $error = "Database error occurred";
                    } else {
                        $stmt->bind_param("ssss", $name, $email, $username, $hashed_password);
                        if ($stmt->execute()) {
                            $success = "Registration successful! Please wait for admin approval.";
                        } else {
                            error_log("Insert Error: " . $stmt->error);
                            $error = "Registration failed. Please try again.";
                        }
                        $stmt->close();
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - EHS Tutoring App</title>
    <link href="../css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Admin Registration</h1>
        <?php if (isset($error)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>
        <?php if (isset($success)) { ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php } ?>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : ''; ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Full Name">
                    <?php if (isset($input_arr['input_name_error'])) { ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo htmlspecialchars($input_arr['input_name_error']); ?></p>
                    <?php } ?>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Email">
                    <?php if (isset($input_arr['input_email_error'])) { ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo htmlspecialchars($input_arr['input_email_error']); ?></p>
                    <?php } ?>
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" value="<?= isset($username) ? htmlspecialchars($username) : ''; ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Username">
                    <?php if (isset($input_arr['input_user_error'])) { ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo htmlspecialchars($input_arr['input_user_error']); ?></p>
                    <?php } ?>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Password">
                    <?php if (isset($input_arr['input_pass_error'])) { ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo htmlspecialchars($input_arr['input_pass_error']); ?></p>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <button type="submit" name="register" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition">Register</button>
                    <a href="login.php" class="block mt-4 text-blue-600 hover:underline">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>