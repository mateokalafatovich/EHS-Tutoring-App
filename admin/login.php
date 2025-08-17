<?php
require_once 'db_con.php';
session_start();
error_log("Session ID: " . session_id());
if (isset($_SESSION['user_login'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $input_arr = array();
    if (empty($username)) {
        $input_arr['input_user_error'] = "Username Is Required!";
    }
    if (empty($password)) {
        $input_arr['input_pass_error'] = "Password Is Required!";
    }

    if (count($input_arr) == 0) {
        if (!$db_con) {
            error_log("Database Connection Failed: " . mysqli_connect_error());
            $usernameerr = "Database connection error. Please try again later.";
        } else {
            $stmt = $db_con->prepare("SELECT * FROM `admins` WHERE `username` = ?");
            if ($stmt === false) {
                error_log("Prepare Error: " . $db_con->error);
                $usernameerr = "Database error occurred";
            } else {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $hashed_password = sha1(md5($password));
                    error_log("Input Hash: $hashed_password, Stored Hash: " . $row['password']);
                    error_log("User Status: " . $row['status']);
                    if ($row['password'] == $hashed_password) {
                        if ($row['status'] == 'activo') {
                            $_SESSION['user_login'] = $username;
                            error_log("Session set for: $username");
                            header('Location: index.php');
                            exit;
                        } else {
                            $status_inactive = "Your status is inactive. Contact the administrator";
                        }
                    } else {
                        $wrongpass = "Incorrect username or password!";
                    }
                } else {
                    $usernameerr = "Username does not exist";
                }
                $stmt->close();
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
    <title>Admin Login - EHS Tutoring App</title>
    <link href="../css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Admin Login</h1>
        <?php if (isset($usernameerr)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo htmlspecialchars($usernameerr); ?>
            </div>
        <?php } ?>
        <?php if (isset($wrongpass)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo htmlspecialchars($wrongpass); ?>
            </div>
        <?php } ?>
        <?php if (isset($status_inactive)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo htmlspecialchars($status_inactive); ?>
            </div>
        <?php } ?>
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <form method="POST" action="">
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
                    <button type="submit" name="login" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition">Log In (Tutors)</button>
                    <a href="/EHS-Tutoring-App/index.php" class="block mt-4 text-blue-600 hover:underline">Back to Tutor Search</a>
                </div>
                <p class="text-center mt-4">If you do not have an account, you can <a href="register.php" class="text-blue-600 hover:underline">register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>