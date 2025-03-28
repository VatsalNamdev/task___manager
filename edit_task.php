<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';
$task_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $_SESSION['user_id']]);
$task = $stmt->fetch();

if (!$task) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'] ?? '';
    $stmt = $pdo->prepare("UPDATE tasks SET task_name = ?, task_description = ? WHERE id = ?");
    $stmt->execute([$task_name, $task_description, $task_id]);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="edit-task-container">
        <h2>Edit Task</h2>
        <form action="edit_task.php?id=<?php echo $task['id']; ?>" method="POST">
            <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
            <textarea name="task_description"><?php echo htmlspecialchars($task['task_description']); ?></textarea>
            <button type="submit">Update Task</button>
        </form>
        <a href="dashboard.php">Cancel</a>
    </div>
</body>
</html>