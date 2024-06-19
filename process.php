<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, dob, gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $dob, $gender);
        $stmt->execute();
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, dob=?, gender=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $dob, $gender, $id);
        $stmt->execute();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
?>
