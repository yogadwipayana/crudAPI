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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">
</head>
<body>
    <div id="main">
        <div id="container">
            <h2>Data Mahasiswa PHP</h2>
            <div id="menu">
                <a href="#" style="border: 0px;"><i class="fa-solid fa-table-cells-large"></i> Table</a>
                <a href="create.php" style="background-color: var(--white);"><i class="fa-regular fa-user fa-sm"></i> Add Data</a>
            </div>
            <div class="data data-php">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th><i class="fa-regular fa-envelope"></i> Email</th>
                        <th>Prodi</th>
                        <th><i class="fa-regular fa-map"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'])) {
                        if ($result['status'] == 'success' && count($result['data']) > 0) {
                            foreach ($result['data'] as $row) {
                                static $no = 1;
                                echo "<tr>";
                                echo "<td>" . $no . "</td>";
                                echo "<td>" . $row['nim'] . "</td>";
                                echo "<td>" . $row['nama'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['prodi'] . "</td>";
                                echo "<td class='action'>" . "<a href='update.php?id=" . $row['id'] . "'><i class='fa-regular fa-pen-to-square'></i> Update</a> " . 
                                    "<a href='' onclick='confirmDeletePHP(event, " . $row['id'] . ")'><i class='fa-regular fa-trash-can'></i> Delete</a>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>Data Empty</td></tr>";
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
                <a href="create.php" style="background-color: var(--white);"><i class="fa-regular fa-user"></i> Add Data</a>
            </div>
            <div class="data data-js">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th><i class="fa-regular fa-envelope"></i> Email</th>
                        <th>Prodi</th>
                        <th><i class="fa-regular fa-map"></i> Action</th>
                    </tr>
                </thead>
                <tbody id="data">

                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmDeleteJS(event, id) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                window.location.href = `delete-js.php?id=${id}`;
                }
            });
        }
        function confirmDeletePHP(event, id) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                window.location.href = `delete.php?id=${id}`;
                }
            });
        }
        const url = 'http://localhost/crudAPI/api/mahasiswa.php';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
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
                                <a href='update.php?id=${row.id}' ><i class='fa-regular fa-pen-to-square'></i> Update</a>
                                <a href='#' onclick='confirmDeleteJS(event, ${row.id})'><i class='fa-regular fa-trash-can'></i> Delete</a>
                            </td>`;
                            tbody.appendChild(tr);
                    });
                } else {
                    const tbody = document.getElementById('data');
                    tbody.innerHTML = `<tr><td colspan="6">Data Empty</td></tr>`;
                }
            })
            .catch(error => {
                const tbody = document.getElementById('data');
                tbody.innerHTML = `<tr><td colspan="6">Error fetching data</td></tr>`;
            });
    </script>
</body>
</html>
