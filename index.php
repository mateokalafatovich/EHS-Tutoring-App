<?php
require_once 'admin/db_con.php';

// Handle form submission
$results = [];
$error_message = '';
if (isset($_POST['showinfo'])) {
    $gradenumber = isset($_POST['gradenumber']) ? mysqli_real_escape_string($db_con, $_POST['gradenumber']) : '';
    $subject = isset($_POST['subject']) ? mysqli_real_escape_string($db_con, $_POST['subject']) : '';

    if (!empty($gradenumber) && !empty($subject)) {
        $query = "SELECT * FROM `student_info` WHERE `subject`='$subject' AND `class`='$gradenumber'";
        $result = mysqli_query($db_con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $results[] = $row;
        }
        if (empty($results)) {
            $error_message = 'Tu información ingresada no coincide';
        }
    } else {
        $error_message = 'Datos no encontrados';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EHS Tutoring App</title>
    <link href="css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">EHS Tutoring App</h1>
            <a href="admin/login.php" class="bg-blue-800 text-white px-4 py-2 rounded-md hover:bg-blue-900 transition">Administrative Login</a>
        </div>
    </header>

    <main class="container mx-auto p-4">
        <section class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4 text-center">Find a Tutor</h2>
            <form id="tutor-search-form" method="POST" action="index.php" class="space-y-4 max-w-lg mx-auto">
                <div>
                    <label for="gradenumber" class="block text-sm font-medium text-gray-700">Grade Number</label>
                    <select id="gradenumber" name="gradenumber" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Grade</option>
                        <option value="Ninth">Ninth</option>
                        <option value="Tenth">Tenth</option>
                        <option value="Eleventh">Eleventh</option>
                        <option value="Twelfth">Twelfth</option>
                    </select>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select id="subject" name="subject" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Subject</option>
                        <option value="Math">Math</option>
                        <option value="Science">Science</option>
                        <option value="History">History</option>
                        <option value="English Language and Writing">English Language and Writing</option>
                    </select>
                </div>
                <button type="submit" name="showinfo" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition">Search</button>
            </form>
        </section>

        <?php if (isset($_POST['showinfo'])): ?>
            <?php if (!empty($results)): ?>
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($results as $tutor): ?>
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <img src="admin/images/<?php echo htmlspecialchars($tutor['photo'] ?? 'default.jpg'); ?>" alt="Tutor Photo" class="w-24 h-24 rounded-full mx-auto mb-4">
                            <h3 class="text-lg font-semibold text-center"><?php echo htmlspecialchars($tutor['name']); ?></h3>
                            <p class="text-gray-600">Subject: <?php echo htmlspecialchars($tutor['subject']); ?></p>
                            <p class="text-gray-600">Grade: <?php echo htmlspecialchars($tutor['class']); ?></p>
                            <p class="text-gray-600">City: <?php echo htmlspecialchars($tutor['city']); ?></p>
                            <p class="text-gray-600">Phone: <?php echo htmlspecialchars($tutor['pcontact']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php else: ?>
                <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer class="bg-blue-600 text-white p-4 mt-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 EHS Tutoring App</p>
        </div>
    </footer>

    <script src="js/form-persist.js"></script>
</body>
</html>