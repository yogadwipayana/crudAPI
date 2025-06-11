<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">
</head>
<body>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
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
                setTimeout(() => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "data has been deleted.",
                        icon: "success",
                    }, 3000);
                    setTimeout (() => {
                        window.location.href = "index.php";
                    }, 3000)
                });
            } else {
                setTimeout(() => {
                    Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    });
                    setTimeout (() => {
                        window.location.href = "index.php";
                    }, 3000)
                });
            }
        });
    </script>
</body>
</html>
