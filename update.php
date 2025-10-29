<?php
include 'db.php';
include 'partials/header.php';

// Get user by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "User ID missing"; exit;
}

$result = $conn->query("SELECT * FROM testdb WHERE id = $id");
$user = $result->fetch_assoc();

// Handle form submission (Update)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("UPDATE testdb SET name=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $password, $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('User updated successfully'); window.location='index.php';</script>";
}
?>

<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-center">Update User</h1>

    <form method="POST" class="space-y-2">
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="w-full p-2 border rounded" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full p-2 border rounded" required>
        <input type="password" name="password" value="<?= htmlspecialchars($user['password']) ?>" class="w-full p-2 border rounded" required>
        <button type="submit" name="update" class="bg-green-500 text-white px-4 py-2 rounded w-full hover:bg-green-600">Update User</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
