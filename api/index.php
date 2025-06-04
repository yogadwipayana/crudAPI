<?php 
    require_once 'connection.php';

    $sql = "SELECT m.id, m.nim, m.nama_mhs as nama, m.email, p.prodi FROM mahasiswa as m INNER JOIN prodi as p ON m.id_prodi = p.id WHERE m.status = 1";
    $result = $conn->query($sql);

    // if ($row = $result->num_rows > 0) {
    //     while($row = $result->fetch_assoc()) {
    //         echo "<pre>";
    //         print_r($row);
    //         echo "</pre>";
    //     }
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server</title>
</head>
<body>
    <h1>Wellcome Admin</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>EMail</th>
                <th>Prodi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nim'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['prodi'] . "</td>";
                        echo "<td>" . "<a href='update.php?id=" . $row['id'] . "'>Edit</a> <br>" . 
                            "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>" . "</td>";
                    }
                }
            ?>
            <tr>
                <td colspan="5"><a href="create.php">Add Data</a></td>
            </tr>
        </tbody>
    </table>
</body>
</html>