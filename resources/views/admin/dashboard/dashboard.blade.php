<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Cariin</title>
</head>
<body>
    <center>
        <h1>INI Home</h1>
        <li><form action="/auth/logout" method="POST">
            @csrf
            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-in-right"></i>Logout</button>
        </form></li>
    </center>
</body>
</html>