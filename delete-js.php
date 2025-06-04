<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
    
    <script>
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');
        if (!id) {
            alert("Missing ID"); window.location = "index.php";
        }
        
        fetch('http://localhost/crudAPI/api/mahasiswa.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'id': id
            })
        })
        .then(response => {
            if (response.ok) {
                alert("Data deleted successfully");
                window.location.href = "index.php";
            } else {
                alert("Failed to delete data");
                window.location.href = "index.php";
            }
        });
    </script>
</body>
</html>
