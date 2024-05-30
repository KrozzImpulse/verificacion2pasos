<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Dashboard</h2>
    <div class="alert alert-success">
        Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!
    </div>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>