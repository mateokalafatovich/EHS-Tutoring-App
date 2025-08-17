<?php
require_once 'db_con.php';
session_start();
if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EHS Tutoring App</title>
    <link href="../css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="../images/ehslogo.png" alt="EHS Logo" class="h-10 mr-4">
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            <nav class="flex items-center space-x-4">
                <?php
                $showuser = $_SESSION['user_login'];
                $stmt = $db_con->prepare("SELECT * FROM `admins` WHERE `username` = ?");
                $stmt->bind_param("s", $showuser);
                $stmt->execute();
                $result = $stmt->get_result();
                $showrow = $result->fetch_assoc();
                $stmt->close();
                ?>
                <span class="text-sm">Hi, <?php echo htmlspecialchars($showrow['name']); ?>!</span>
                <a href="index.php?page=user-profile" class="hover:text-gray-200"><i class="fas fa-user"></i> Profile</a>
                <a href="logout.php" class="bg-blue-800 text-white px-3 py-2 rounded-md hover:bg-blue-900 transition"><i class="fas fa-power-off"></i> Log Out</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4 flex-grow">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <aside class="md:col-span-3">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <a href="index.php?page=dashboard" class="block p-2 rounded-md hover:bg-blue-100 transition <?php echo (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'bg-blue-100 text-blue-600' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Control Panel
                    </a>
                    <a href="index.php?page=add-student" class="block p-2 rounded-md hover:bg-blue-100 transition <?php echo (isset($_GET['page']) && $_GET['page'] == 'add-student') ? 'bg-blue-100 text-blue-600' : ''; ?>">
                        <i class="fas fa-user-plus"></i> Add Tutor
                    </a>
                    <a href="index.php?page=all-student" class="block p-2 rounded-md hover:bg-blue-100 transition <?php echo (isset($_GET['page']) && $_GET['page'] == 'all-student') ? 'bg-blue-100 text-blue-600' : ''; ?>">
                        <i class="fas fa-users"></i> All Tutors
                    </a>
                    <a href="index.php?page=all-users" class="block p-2 rounded-md hover:bg-blue-100 transition <?php echo (isset($_GET['page']) && $_GET['page'] == 'all-users') ? 'bg-blue-100 text-blue-600' : ''; ?>">
                        <i class="fas fa-users"></i> All Users
                    </a>
                    <a href="index.php?page=user-profile" class="block p-2 rounded-md hover:bg-blue-100 transition <?php echo (isset($_GET['page']) && $_GET['page'] == 'user-profile') ? 'bg-blue-100 text-blue-600' : ''; ?>">
                        <i class="fas fa-user"></i> User Profile
                    </a>
                </div>
            </aside>
            <section class="md:col-span-9 bg-white rounded-lg shadow-md p-6">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'] . '.php';
                } else {
                    $page = 'dashboard.php';
                }
                if (file_exists($page)) {
                    require_once $page;
                } else {
                    error_log("Page not found: $page");
                    require_once '404.php';
                }
                ?>
            </section>
        </div>
    </main>

    <footer class="bg-blue-600 text-white p-4 mt-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 EHS Tutoring App</p>
        </div>
    </footer>
</body>
</html>