<?php
session_start();

//Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Database connectie
$servername = "localhost";
$username = "root";
$password = "8BF54eq$%gpXTBZ4";
$database = "project5";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

// Haal de gebruiker_id en gebruikersnaam uit de sessie
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$gebruiker_id = $_SESSION['gebruiker_id'];

// Sluit de database verbinding
$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Welkom, <?php echo htmlspecialchars($gebruikersnaam); ?>!</h1>
            <p class="lead">U bent succesvol ingelogd op uw account.</p>
            <hr class="my-4">
            <p>Gebruiker ID: <?php echo $gebruiker_id; ?></p>
            <a class="btn btn-primary btn-lg" href="uitloggen.php" role="button">Uitloggen</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
