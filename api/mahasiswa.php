<?php
    require_once 'connection.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

            if (stripos($accept, 'text/html') !== false && stripos($accept, 'application/json') === false) {
                http_response_code(400);
                echo json_encode([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Request directly from browser is not allowed, use application/json instead.'
                ]);
                exit;
            }

            $sql = "SELECT m.id, m.nim, m.nama_mhs as nama, m.email, p.prodi 
                    FROM mahasiswa as m 
                    INNER JOIN prodi as p ON m.id_prodi = p.id 
                    WHERE m.status = 1";

            $result = mysqli_query($conn, $sql);

            $mahasiswa = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $data = [];
            foreach ($mahasiswa as $row) {
                $data[] = [
                    'id' => $row['id'],
                    'nama' => $row['nama'],
                    'nim' => $row['nim'],
                    'email' => $row['email'],
                    'prodi' => $row['prodi']
                ];
            }

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => $data
            ];
            echo json_encode($response);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'code' => 500,
                'status' => 'error',
                'message' => 'Failed to retrieve data',
            ]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['nim'], $input['nama'], $input['email'], $input['prodi'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Data is incomplete']);
            exit;
        }

        $nim   = $input['nim'];
        $nama  = $input['nama'];
        $email = $input['email'];
        $prodi = $input['prodi'];

        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama_mhs, email, id_prodi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nim, $nama, $email, $prodi);
        $result = $stmt->execute();

        if ($result) {
            $response = [
                'code' => 201,
                'status' => 'success',
                'message' => 'Data created successfully'
            ];
            echo json_encode($response);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create data']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = $put_vars['id'] ?? '';
        $nim = $put_vars['nim'] ?? '';
        $nama = $put_vars['nama'] ?? '';
        $email = $put_vars['email'] ?? '';
        $prodi = $put_vars['prodi'] ?? '';

        if ($id) {
            $sql = "UPDATE mahasiswa SET nim = '$nim', nama_mhs = '$nama', email = '$email', id_prodi = '$prodi' WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Data updated successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update data']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID is required']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $delete_vars);
        $id = $delete_vars['id'] ?? '';

        if ($id) {
            $sql = "UPDATE mahasiswa SET status = 0 WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Data deleted successfully'
                ];
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to delete data']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID is required']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
?>