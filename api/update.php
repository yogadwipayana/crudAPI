<?php
    require_once 'connection.php';

    $id = $_GET['id'] ?? null;
    if ($id) {
        $sql = "SELECT * FROM mahasiswa WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nim = $row['nim'];
            $nama = $row['nama_mhs'];
            $email = $row['email'];
            $prodi = $row['id_prodi'];
        } 
        else {
            echo "No record found.";
            exit;
        }
    } else {
        echo "Invalid ID.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $prodi = $_POST['prodi'];

        $sql = "UPDATE mahasiswa SET nim = $nim, nama_mhs = '$nama', email = '$email', id_prodi = $prodi where id = " . $_GET['id'];
        $result = $conn->query($sql);
        if ($result === TRUE) {
            header("location: index.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
    <h1>Update</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" value="<?php echo $nim; ?>" required><br>

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo $nama; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required><br>

        <label for="prodi">Prodi:</label>
        <select name="prodi" id="prodi">
            <?php
                $sqlP = "SELECT * FROM prodi";
                $resultP = $conn->query($sqlP);
                if ($resultP->num_rows > 0) {
                    while($rowP = $resultP->fetch_assoc()) {
                        $selected = ($rowP['id'] == $prodi) ? 'selected' : '';
                        echo "<option value='" . $rowP['id'] . "' $selected>" . $rowP['prodi'] . "</option>";
                    }
                }
            ?>
        </select><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>