<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <h3>👋 Hello, <?= esc($username) ?>! Welcome to your dashboard.</h3>
        </div>

        <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>