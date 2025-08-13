<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) exit;

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$task = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $due = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=?, status=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssssii", $title, $desc, $due, $status, $id, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Task</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f7fa;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    form {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        width: 350px;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    input[type="text"], input[type="date"], textarea, select {
        width: 100%;
        padding: 10px;
        margin: 8px 0 15px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }
    textarea {
        height: 80px;
        resize: none;
    }
    button {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    }
    button:hover {
        background: #45a049;
    }
</style>
</head>
<body>
    <form method="POST">
        <h2>Edit Task</h2>
        Title: <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>">
        Description: <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>
        Due Date: <input type="date" name="due_date" value="<?= $task['due_date'] ?>">
        Status:
        <select name="status">
            <option <?= $task['status']=='Pending'?'selected':'' ?>>Pending</option>
            <option <?= $task['status']=='In Progress'?'selected':'' ?>>In Progress</option>
            <option <?= $task['status']=='Completed'?'selected':'' ?>>Completed</option>
        </select>
        <button type="submit">Update</button>
    </form>
</body>
</html>
