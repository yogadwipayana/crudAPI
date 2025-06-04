<?php
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "No ID provided.";
        header("Location: index.php");
        exit;
    }

    $deletedata = http_build_query([
        'id' => $_GET['id']
    ]);

    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'DELETE',
            'content' => $deletedata,
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents("http://localhost/crudAPI/api/mahasiswa.php", false, $context);

    if ($result === FALSE) {
        echo "<script>alert('Failed to delete data'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Data delete successfully'); window.location='index.php';</script>";
    }
    
?>
