<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Permissions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #343a40;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .icon {
            font-size: 100px;
            color: #dc3545;
        }
        .btn-primary {
            margin-top: 20px;
        }
        .btn-secondary {
            margin-top: 10px;
        }
        .wrapper{
            background-color: red;
            height: 100vh;
            background-image: radial-gradient(circle, #6bb6d1, #70bad5, #75bdd9, #7ac1dd, #7fc5e1, #7fc9e5, #7ecce9, #7ed0ed, #77d5f1, #70d9f5, #68def8, #5fe3fb);
        }
    </style>
</head>
<body>

<div class="container-fluid wrapper">
<div class="container mt-5">
    <img src="{{asset('images/company/logo2.jpg')}}" alt="Logo" class="mb-4" style="width: 150px;">
    <h1 class="mb-4">Nemate pristup</h1>
    <div class="icon mb-4">
        <i class="fas fa-lock"></i>
    </div>
    <p class="lead">Nemate potrebne dozvole za pristup ovoj stranici.</p>
    <p>Kontaktirajte svog administratora ako smatrate da je ovo greška ili se vratite na početnu stranicu.</p>
    <a href="{{route('dashboard')}}" class="btn btn-primary btn-lg">Nazad</a>
</div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
