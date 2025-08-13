<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) exit;

$id = $_GET['id'];
$status = $_GET['status'];

$stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=? AND user_id=?");
$stmt->bind_param("sii", $status, $id, $_SESSION['user_id']);
$stmt->execute();
header("Location: dashboard.php");
