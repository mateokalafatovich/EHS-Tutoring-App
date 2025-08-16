<?php
require_once 'db_con.php';
session_start();

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    $photo = explode('.', $_FILES['photo']['name']);
    $photo = end($photo);
    $photo_name = $username . '.' . $photo;

    $input_error = array();
    if (empty($name)) {
        $input_error['name'] = "You must enter your name";
    }
    if (empty($email)) {
        $input_error['email'] = "You must enter your email";
    }
    if (empty($username)) {
        $input_error['username'] = "You must enter your username";
    }
    if (empty($password)) {
        $input_error['password'] = "You must enter a password";
    }
    if (empty($_FILES['photo']['name'])) {
        $input_error['photo'] = "You must upload a photo";
    }

    if (!empty($password)) {
        if ($c_password !== $password) {
            $input_error['notmatch'] = "Incorrect password!";
        }
    }

    if (count($input_error) == 0) {
        $check_email = mysqli_query($db_con, "SELECT * FROM `users` WHERE `email`='$email';");

        if (mysqli_num_rows($check_email) == 0) {
            $check_username = mysqli_query($db_con, "SELECT * FROM `users` WHERE `username`='$username';");
            if (mysqli_num_rows($check_username) == 0) {
                if (strlen($username) > 7) {
                    if (strlen($password) > 7) {
                        $password = sha1(md5($password));
                        $query = "INSERT INTO `users`(`name`, `email`, `username`, `password`, `photo`, `status`) VALUES ('$name', '$email', '$username', '$password', '$photo_name', 'inactivo');";
                        $result = mysqli_query($db_con, $query);
                        if ($result) {
                            move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $photo_name);
                            header('Location: register.php?insert=success');
                        } else {
                            header('Location: register.php?insert=error');
                        }
                    } else {
                        $passlan = "Your password must contain at least 8 characters";
                    }
                } else {
                    $usernamelan = "Your username must contain at least 8 characters";
                }
            } else {
                $username_error = "This username is taken. Try another one.";
            }
        } else {
            $email_error = "This email is already taken.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Registration - EHS Tutoring App</title>
    <link href="../css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Tutor Registration</h1>
        <?php if (isset($_GET['insert']) && $_GET['insert'] == 'success') { ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                You have been successfully registered.
            </div>
        <?php } elseif (isset($_GET['insert']) && $_GET['insert'] == 'error') { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                Error. Try again.
            </div>
        <?php } ?>
        <?php if (isset($email_error)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo $email_error; ?>
            </div>
        <?php } ?>
        <?php if (isset($username_error)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo $username_error; ?>
            </div>
        <?php } ?>
        <?php if (isset($usernamelan)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo $usernamelan; ?>
            </div>
        <?php } ?>
        <?php if (isset($passlan)) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
                <?php echo $passlan; ?>
            </div>
        <?php } ?>
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <form method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                        <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : ''; ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Name">
                        <?php if (isset($input_error['name'])) { ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo $input_error['name']; ?></p>
                        <?php } ?>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Email">
                        <?php if (isset($input_error['email'])) { ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo $input_error['email']; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                        <input type="text" id="username" name="username" value="<?= isset($username) ? htmlspecialchars($username) : ''; ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Username">
                        <?php if (isset($input_error['username'])) { ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo $input_error['username']; ?></p>
                        <?php } ?>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Password">
                        <?php if (isset($input_error['password'])) { ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo $input_error['password']; ?></p>
                        <?php } ?>
                    </div>
                    <div>
                        <label for="c_password" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                        <input type="password" id="c_password" name="c_password" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Confirm Password">
                        <?php if (isset($input_error['notmatch'])) { ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo $input_error['notmatch']; ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="photo" class="block text-gray-700 font-medium mb-2">Choose your profile picture</label>
                    <input type="file" id="photo" name="photo" class="w-full p-2 border rounded-md">
                    <?php if (isset($input_error['photo'])) { ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo $input_error['photo']; ?></p>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <button type="submit" name="register" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition">Register</button>
                </div>
                <p class="text-center mt-4">If you have an administrative account, you can <a href="login.php" class="text-blue-600 hover:underline">login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>