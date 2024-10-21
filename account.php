<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Get the username and user ID from the session
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$gebruiker_id = $_SESSION['gebruiker_id'];
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
            <a class="btn btn-secondary btn-lg" href="accountinstellingen.php" role="button">Account instellingen</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
