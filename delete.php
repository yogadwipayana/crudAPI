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
        echo "<script>
            setTimeout(() => {
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                });
                setTimeout (() => {
                    window.location.href = 'index.html';
                }, 3000)
            });
            </script>";
    } else {
        echo "<script>
        setTimeout(() => {
            Swal.fire({
                title: 'Deleted!',
                text: 'data has been deleted.',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        }, 100);

        setTimeout(() => {
            window.location.href = 'index.php';
        }, 3000);</script>";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">
</head>
<body>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
</body>
</html>
