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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data</title>
    <link rel="stylesheet" href="style/create.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div id="main">
        <!-- PHP Form -->
        <div id="container">
            <h2>Add Data PHP</h2>
            <form action="" method="POST" enctype="">
                <table>
                    <tr>
                        <td><input type="number" name="nim" id="php_nim" placeholder="NIM"></td>
                        <td><input type="text" name="nama" id="php_nama" placeholder="Full Name"></td>
                        <td><input type="email" name="email" id="php_email" placeholder="name@example.com"></td>
                        <td><div class="select-wrapper">
                                <select name="prodi" id="php_prodi">
                                    <option value="" disabled selected hidden>Prodi</option>
                                    <option value="1">Informatika</option>
                                    <option value="2">Sistem Komputer</option>
                                    <option value="3">Bisnis</option>
                                </select>
                            </div>
                        </td>
                        <td><button type="submit" name="submit_php">Add Via PHP</button></td>
                    </tr>
                </table>
            </form>
            <div id="menu">
                <a href="index.php"><i class="fa-regular fa-circle-left"></i> Back</a>
            </div>
        </div>

        <!-- JavaScript Form -->
        <div id="box">
            <h2>Add Data JS</h2>
            <form onsubmit="submitForm(event)">
                <table>
                    <tr>
                        <td><input type="number" name="nim" id="js_nim" placeholder="NIM"></td>
                        <td><input type="text" name="nama" id="js_nama" placeholder="Full Name"></td>
                        <td><input type="email" name="email" id="js_email" placeholder="name@example.com"></td>
                        <td>
                            <div class="select-wrapper">
                                <select name="prodi" id="js_prodi">
                                    <option value="" disabled selected hidden>Prodi</option>
                                    <option value="1">Informatika</option>
                                    <option value="2">Sistem Komputer</option>
                                    <option value="3">Bisnis</option>
                                </select>
                            </div>
                        </td>
                        <td><button type="submit">Add Via JS</button></td>
                    </tr>
                </table>
            </form>
            <div id="menu">
                <a href="index.php"><i class="fa-regular fa-circle-left"></i> Back</a>
            </div>
        </div>
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