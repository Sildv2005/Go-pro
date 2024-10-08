<?php
require '/var/www/vendor/autoload.php';
use RobThree\Auth\TwoFactorAuth;

$dotenv = \Dotenv\Dotenv::createImmutable('/var/www/');
$dotenv->load();

session_start();

//Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Database connectie
$servername = "localhost";
$username = "root";
$password = $_ENV['DB_PASSWORD_ROOT'];
$database = "project5";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

// Haal de gebruiker_id en gebruikersnaam uit de sessie
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$gebruiker_id = $_SESSION['gebruiker_id'];
$mfaSecret = $_SESSION['mfa_secret'] ?? null; // Controleer of er een mfa_secret is

// Verwijder MFA indien aangevraagd
if (isset($_POST['remove_mfa']) && !empty($_POST['mfa_code'])) {
    $mfaCode = $_POST['mfa_code'];
    $tfa = new TwoFactorAuth('project5');
    
    // Verifieer de ingevoerde MFA-code
    if ($tfa->verifyCode($mfaSecret, $mfaCode, 2)) {
        // MFA-code is correct, verwijder MFA-secret uit de database
        $sql = "UPDATE gebruikers SET mfa_secret = NULL WHERE gebruiker_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Fout bij het voorbereiden van de statement: " . $conn->error);
        }
        $stmt->bind_param("i", $gebruiker_id);
        $stmt->execute();
        $stmt->close();
        
        // Verwijder MFA-secret uit de sessie
        unset($_SESSION['mfa_secret']);
        
        echo "<p>MFA is succesvol verwijderd.</p>";
    } else {
        echo "<p>Ongeldige MFA-code. Probeer opnieuw.</p>";
    }
}

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
            <?php if (empty($mfaSecret)): ?>
                <!-- Geen MFA ingesteld, toon setup knop -->
                <p><a href="setup_mfa.php">Setup Multi-factor Authentication</a></p>
            <?php else: ?>
                <!-- MFA is ingesteld, toon formulier om MFA te verwijderen -->
                <form method="post">
                    <label for="mfa_code">Voer uw MFA-code in om MFA te verwijderen:</label>
                    <input type="text" id="mfa_code" name="mfa_code" required>
                    <button type="submit" name="remove_mfa" class="btn btn-danger">Verwijder MFA</button>
                </form>
            <?php endif; ?>
            <p>Gebruiker ID: <?php echo $gebruiker_id; ?></p>
            <a class="btn btn-primary btn-lg" href="uitloggen.php" role="button">Uitloggen</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
