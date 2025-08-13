<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $due = $_POST['due_date'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_SESSION['user_id'], $title, $desc, $due);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Task</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    form {
        background: white;
        padding: 25px;
        border-radius: 10px;
        width: 350px;
        box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    }
    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    input, textarea, button {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        font-size: 14px;
    }
    textarea {
        resize: none;
        height: 80px;
    }
    button {
        background-color: #2575fc;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #1a5edc;
    }
</style>
</head>
<body>

<form method="POST">
    <h2>Add New Task</h2>
    <input type="text" name="title" placeholder="Task Title" required>
    <textarea name="description" placeholder="Task Description"></textarea>
    <input type="date" name="due_date">
    <button type="submit">Add Task</button>
</form>

</body>
</html>
