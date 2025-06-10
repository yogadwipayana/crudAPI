<?php
try {
    $url = 'http://localhost/crudAPI/api/mahasiswa.php';
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        throw new Exception('Error fetching data from API');
    }
    $result = json_decode($response, true);
} catch (Exception $e) {
    echo '';
}
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div id="main">
        <div id="container">
            <h2>Data Mahasiswa PHP</h2>
            <div id="menu">
                <a href="#" style="border: 0px;"><i class="fa-solid fa-table-cells-large"></i> Table</a>
                <a href="create.php"><i class="fa-regular fa-user fa-sm"></i> Add Data</a>
            </div>
            <div class="data-php">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th><i class="fa-regular fa-envelope"></i> EMail</th>
                        <th>Prodi</th>
                        <th><i class="fa-regular fa-map"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'])) {
                        if ($result['status'] == 'success') {
                            foreach ($result['data'] as $row) {
                                static $no = 1;
                                echo "<tr>";
                                echo "<td>" . $no . "</td>";
                                echo "<td>" . $row['nim'] . "</td>";
                                echo "<td>" . $row['nama'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['prodi'] . "</td>";
                                echo "<td class='action'>" . "<a href='update.php?id=" . $row['id'] . "'><i class='fa-regular fa-pen-to-square'></i> Edit</a> " . 
                                    "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'><i class='fa-regular fa-trash-can'></i> Delete</a>" . "</td>";
                                echo "</tr>";
                                $no++;
                            }
                        }
                    } else {
                        echo "<tr><td colspan='6'>Error fetching data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
        <div id="box">
            <h2>Data Mahasiswa JS</h2>
            <div id="menu">
                <a href="#" style="border: 0px;"><i class="fa-solid fa-table-cells-large"></i> Table</a>
                <a href="create.php"><i class="fa-regular fa-user"></i> Add Data</a>
            </div>
            <div class="data-js">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>EMail</th>
                        <th>Prodi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="data">

                </tbody>
            </table>
            </div>
        </div>
    </div>
    <script>
        const url = 'http://localhost/crudAPI/api/mahasiswa.php';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const tbody = document.getElementById('data');
                    let no = 1;
                    data.data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${no++}</td>
                            <td>${row.nim}</td>
                            <td>${row.nama}</td>
                            <td>${row.email}</td>
                            <td>${row.prodi}</td>
                            <td class="action">
                                <a href='update.php?id=${row.id}'><i class='fa-regular fa-pen-to-square'></i> Edit</a>
                                <a href='delete-js.php?id=${row.id}' onclick='return confirm("Are you sure you want to delete this record?")'><i class='fa-regular fa-trash-can'></i> Delete</a>
                            </td>`;
                            tbody.appendChild(tr);
                    });
                }
            })
            .catch(error => {
                const tbody = document.getElementById('data');
                tbody.innerHTML = `<tr><td colspan="6">Error fetching data</td></tr>`;
            });
    </script>
</body>
</html>
