<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];

// Fetch tasks for the user
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name'])) {
    // Add a new task
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, task_name, task_description) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $task_name, $task_description]);
    header("Location: dashboard.php");
    exit();
}

// Handle delete or edit task
if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$task_id]);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, User</h2>
        <form action="dashboard.php" method="POST">
            <input type="text" name="task_name" placeholder="Task Name" required>
            <textarea name="task_description" placeholder="Task Description"></textarea>
            <button type="submit">Add Task</button>
        </form>
        <h3>Your Tasks</h3>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong><?php echo htmlspecialchars($task['task_name']); ?></strong><br>
                    <?php echo htmlspecialchars($task['task_description']); ?><br>
                    <a href="dashboard.php?delete=<?php echo $task['id']; ?>">Delete</a>
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>