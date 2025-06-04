<?php
    require_once 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $prodi = $_POST['prodi'];

        $sql = "INSERT INTO mahasiswa (nim, nama_mhs, email, id_prodi) VALUES ($nim, '$nama', '$email', $prodi)";
        if ($conn->query($sql) === TRUE) {
            header("location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
    <h1>Add Data</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" required><br>

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="prodi">Prodi:</label>
        <select name="prodi" id="prodi">
            <?php
                $sqlP = "SELECT * FROM prodi";
                $resultP = $conn->query($sqlP);
                if ($resultP->num_rows > 0) {
                    while($rowP = $resultP->fetch_assoc()) {
                        echo "<option value='" . $rowP['id'] . "'>" . $rowP['prodi'] . "</option>";
                    }
                }
            ?>
        </select><br>

        <button type="submit">Submit</button>
    </form>
    <br>
    <a href="index.php">Back to list</a>
</body>
</html>