<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Item List App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
<?php
include 'db.php';
include 'partials/header.php';

// Handle form submission (Create)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO testdb (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();
    $stmt->close();

    echo "
<script>
Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'User added successfully!',
  theme: 'auto',
  showConfirmButton: false,
  timer: 1500
});
</script>";

}

// Fetch all users (Read)
$result = $conn->query("SELECT * FROM testdb");
?>

<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h1 class="text-2xl font-bold mb-4 text-center">PHP CRUD Example</h1>

    <!-- Create Form -->
    <form method="POST" class="mb-6 space-y-2">
        <input type="text" name="name" placeholder="Name" class="w-full p-2 border rounded" required>
        <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
        <button type="submit" name="create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Add User</button>
    </form>

    <!-- Users Table -->
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">Name</th>
                <th class="border px-2 py-1">Email</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="text-center">
                <td class="border px-2 py-1"><?= $row['id'] ?></td>
                <td class="border px-2 py-1"><?= htmlspecialchars($row['name']) ?></td>
                <td class="border px-2 py-1"><?= htmlspecialchars($row['email']) ?></td>
                <td class="border px-2 py-1 space-x-2">
                    <a href="update.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
  </div>
</div>
<?php include 'partials/footer.php'; ?>
</body>
</html>
