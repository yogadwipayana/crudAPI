<?php
    require_once 'connection.php';

    $id = $_GET['id'] ?? null;
    if ($id) {
        $sql = "update mahasiswa set status = 0 where id = $id";
        if ($conn->query($sql) === TRUE) {
            header("location: index.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Invalid ID.";
    }
?>