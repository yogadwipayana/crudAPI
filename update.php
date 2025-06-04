<?php
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "No ID provided.";
        header("Location: index.php");
        exit;
    }

    $response = file_get_contents("http://localhost/crudAPI/api/mahasiswa.php");
    $data = json_decode($response, true);
    $student = null;
    foreach ($data['data'] as $item) {
        if ($item['id'] == $id) {
            $student = $item;
            break;
        }
    }

    if (!$student) {
        echo "Student not found.";
        exit;
    }

    // Handle PUT request on submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_php'])) {
        $updateData = http_build_query([
            'id' => $_POST['id'],
            'nim' => $_POST['nim'],
            'nama' => $_POST['nama'],
            'email' => $_POST['email'],
            'prodi' => $_POST['prodi'],
        ]);

        $options = [
            'http' => [
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method'  => 'PUT',
                'content' => $updateData,
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents("http://localhost/crudAPI/api/mahasiswa.php", false, $context);

        if ($result === FALSE) {
            echo "<script>alert('Failed to update data'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Data updated successfully'); window.location='index.php';</script>";
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
<body style="display: flex; justify-content: space-evenly; padding: 20px;">
    <div id="container">
        <h1>Update Data PHP</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">

            <label>NIM:</label><br>
            <input type="text" name="nim" value="<?= $student['nim'] ?>" required><br>

            <label>Name:</label><br>
            <input type="text" name="nama" value="<?= $student['nama'] ?>" required><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?= $student['email'] ?>" required><br>

            <label>Program:</label><br>
            <select name="prodi">
                <option value="1" <?= $student['prodi'] == 'Informatika' ? 'selected' : '' ?>>Informatika</option>
                <option value="2" <?= $student['prodi'] == 'Sistem Komputer' ? 'selected' : '' ?>>Sistem Komputer</option>
                <option value="3" <?= $student['prodi'] == 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
            </select><br><br>

            <button type="submit" name="submit_php">Update via PHP</button>
        </form>
    </div>
    <div id="box">
        <h1>Update Data JS</h1>
        <form id="editFormJS" onsubmit="submitEditForm(event)">
            <input type="hidden" id="js_id">
            
            <label>NIM:</label><br>
            <input type="text" id="js_nim" required><br>

            <label>Name:</label><br>
            <input type="text" id="js_nama" required><br>

            <label>Email:</label><br>
            <input type="email" id="js_email" required><br>

            <label>Program:</label><br>
            <select id="js_prodi">
                <option value="1">Informatika</option>
                <option value="2">Sistem Kompurter</option>
                <option value="3">Bisnis</option>
            </select><br><br>

            <button type="submit">Update via JavaScript</button>
        </form>
    </div>
    <script>
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');
        if (!id) {
            alert("Missing ID"); window.location = "index.php";
        }

        fetch('http://localhost/crudAPI/api/mahasiswa.php')
            .then(res => res.json())
            .then(data => {
                const student = data.data.find(m => m.id == id);
                if (!student) {
                    alert("Student not found");
                    return;
                }

            document.getElementById('js_id').value = student.id;
            document.getElementById('js_nim').value = student.nim;
            document.getElementById('js_nama').value = student.nama;
            document.getElementById('js_email').value = student.email;

            const prodiMap = {
                "Informatika": 1,
                "Sistem Komputer": 2,
                "Bisnis": 3
            };
            document.getElementById('js_prodi').value = prodiMap[student.prodi] || 1;
        });

        function submitEditForm(event) {
            event.preventDefault();

            const formData = new URLSearchParams();
            formData.append("id", document.getElementById("js_id").value);
            formData.append("nim", document.getElementById("js_nim").value);
            formData.append("nama", document.getElementById("js_nama").value);
            formData.append("email", document.getElementById("js_email").value);
            formData.append("prodi", document.getElementById("js_prodi").value);

            fetch('http://localhost/crudAPI/api/mahasiswa.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData.toString()
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = 'index.php';
                } else {
                    alert(data.error || 'Failed to update data');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred');
            });
        }
    </script>
</body>
</html>
