<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_php'])) {
    $data = [
        'nim' => $_POST['nim'],
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'prodi' => $_POST['prodi']
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents('http://localhost/crudAPI/api/mahasiswa.php', false, $context);

    if ($response === FALSE) {
        echo "<script>alert('Failed to send data to API.');</script>";
    } else {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Student Data</title>
</head>
<body style="display: flex; justify-content: space-evenly; padding: 20px;">
    <!-- PHP Form -->
    <div id="container">
        <h1>Add Data (PHP)</h1>
        <form method="POST">
            <label for="php_nim">NIM:</label><br>
            <input type="text" name="nim" id="php_nim" required><br>

            <label for="php_nama">Name:</label><br>
            <input type="text" name="nama" id="php_nama" required><br>

            <label for="php_email">Email:</label><br>
            <input type="email" name="email" id="php_email" required><br>

            <label for="php_prodi">Program:</label><br>
            <select name="prodi" id="php_prodi">
                <option value="1">Informatika</option>
                <option value="2">Sistem Komputer</option>
                <option value="3">Bisnis</option>
            </select><br><br>

            <button type="submit" name="submit_php">Submit via PHP</button>
        </form>
        <br>
        <a href="index.php">Back to list</a>
    </div>

    <!-- JavaScript Form -->
    <div id="box">
        <h1>Add Data (JavaScript)</h1>
        <form onsubmit="submitForm(event)">
            <label for="js_nim">NIM:</label><br>
            <input type="text" id="js_nim" required><br>

            <label for="js_nama">Name:</label><br>
            <input type="text" id="js_nama" required><br>

            <label for="js_email">Email:</label><br>
            <input type="email" id="js_email" required><br>

            <label for="js_prodi">Program:</label><br>
            <select id="js_prodi">
                <option value="1">Informatika</option>
                <option value="2">Sistem Komputer</option>
                <option value="3">Bisnis</option>
            </select><br><br>

            <button type="submit">Submit via JS</button>
        </form>
        <br>
        <a href="index.php">Back to list</a>
    </div>

    <script>
        function submitForm(event) {
            event.preventDefault();

            const formData = {
                nim: document.getElementById('js_nim').value,
                nama: document.getElementById('js_nama').value,
                email: document.getElementById('js_email').value,
                prodi: document.getElementById('js_prodi').value
            };

            fetch('http://localhost/crudAPI/api/mahasiswa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message || 'Data sent successfully!');
                    window.location.href = 'index.php';
                } else {
                    alert(data.error || 'Failed to send data!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending data.');
            });
        }
    </script>
</body>
</html>
