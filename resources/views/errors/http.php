<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$message ?? 'Requested page not found!'?> · Note App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        html{height: 100%;}
        body{display: flex;flex-direction: column;height: 100%;}
        header{flex: 0 0 auto;}
        .logo{padding: 0px 10px;font-size: 36px;color:deepskyblue;}
        .main-content{flex: 1 0 auto;}
        footer{flex: 0 0 auto;}
    </style>
</head>
<body class="bg-light text-center">
<header class="d-flex flex-row justify-content-center align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm">
    <i class="material-icons logo">library_books</i>
    <h5 class="my-0 font-weight-normal">Note Component</h5>
</header>
<div class="main-content container">
    <div class="row h-100 d-flex flex-row align-content-center">
        <div class="col-md-12">
            <h1 class="text-info font-weight-bold display-1 d-inline-block"><?= ($status ?? 404) ?></h1>
            <p class="text-muted font-weight-light h4 mb-5">
                Sorry, an error has occured, <?= ($message ?? 'Requested page not found!') ?>
            </p>
            <div>
                <a href="/" class="btn btn-info btn-lg">
                    <i class="material-icons align-middle">home</i>
                    <span class="align-middle">Take Me Home</span>
                </a>
                <a href="/" class="btn btn-secondary btn-lg">
                    <i class="material-icons align-middle">mail</i>
                    <span class="align-middle">Contact Support</span>
                </a>
            </div>
        </div>
    </div>
</div>
<footer class="bg-white pt-5 pb-5 text-muted">
    <span class="text-center">Note Component &copy; 2019.</span>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>