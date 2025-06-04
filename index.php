<?php
    $url = 'http://localhost/crudAPI/api/mahasiswa.php';
    $response = file_get_contents($url);
    $result = json_decode($response, true);

    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="display: flex; justify-content: space-evenly; padding: 20px;">
    <div id="container">
        <h1>Data Mahasiswa PHP</h1>
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
                    if ($result['status'] == 'success') {
                        foreach ($result['data'] as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['nim'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['prodi'] . "</td>";
                            echo "<td>" . "<a href='update.php?id=" . $row['id'] . "'>Edit</a> <br>" . 
                                "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>" . "</td>";
                            echo "</tr>";
                        }
                    }
                ?>
                <tr>
                    <td colspan="5"><a href="create.php">Add Data</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="box">
        <h1>Data Mahasiswa JS</h1>
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
            <tbody id="data">

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><a href="create.php">Add Data</a></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script>
        const url = 'http://localhost/crudAPI/api/mahasiswa.php';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const tbody = document.getElementById('data');
                    data.data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.nim}</td>
                            <td>${row.nama}</td>
                            <td>${row.email}</td>
                            <td>${row.prodi}</td>
                            <td>
                                <a href='update.php?id=${row.id}'>Edit</a> <br>
                                <a href='delete-js.php?id=${row.id}' onclick='return confirm("Are you sure you want to delete this record?")'>Delete</a>
                            </td>`;
                        tbody.appendChild(tr);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    </script>
</body>
</html>
