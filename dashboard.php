<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// Fetch tasks
$tasks = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
$tasks->bind_param("i", $_SESSION['user_id']);
$tasks->execute();
$result = $tasks->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #83a4d4, #b6fbff);
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #333;
    }
    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #4CAF50;
        color: white;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
    .btn {
        padding: 5px 10px;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 4px;
        text-decoration: none;
    }
    .edit { background-color: #2196F3; }
    .delete { background-color: #f44336; }
    .status { background-color: #ff9800; }
    .add-task {
        display: block;
        width: 200px;
        margin: 20px auto;
        padding: 10px;
        text-align: center;
        background: #4CAF50;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }
    .add-task:hover {
        background: #45a049;
    }
</style>
</head>
<body>
    <h2>Welcome to Your Task Dashboard</h2>
    <a href="add_task.php" class="add-task">+ Add New Task</a>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['due_date']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <a class="btn edit" href="edit_task.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="btn delete" href="delete_task.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this task?')">Delete</a>
                <a class="btn status" href="update_status.php?id=<?= $row['id'] ?>">Update Status</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
