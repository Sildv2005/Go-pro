<?php
require_once '/var/www/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable('/var/www/');
$dotenv->load();

session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id'])) {
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

use RobThree\Auth\TwoFactorAuth;

$gebruiker_id = $_SESSION['gebruiker_id']; // Haal gebruiker_id uit de sessie

// Functie om de MFA-token te verifiëren
function verifyMFAToken($gebruiker_id, $token) {
    global $conn; // Maak de databaseverbinding beschikbaar in de functie
    $stmt = $conn->prepare("SELECT mfa_secret FROM gebruikers WHERE gebruiker_id = ?");
    $stmt->bind_param("i", $gebruiker_id);
    $stmt->execute();
    $stmt->bind_result($secret);
    $stmt->fetch();
    $stmt->close();

    if ($secret) {
        $tfa = new TwoFactorAuth('project5');
        return $tfa->verifyCode($secret, $token, 2);  // 2-windows toegestaan voor tijdsdrift
    }
    return false;
}

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mfa_code'])) {
    $userToken = $_POST['mfa_code']; // Haal de MFA-code op van het formulier

    // Verifieer de MFA-code
    if (verifyMFAToken($gebruiker_id, $userToken)) {
        echo "<p style='color:green;'>MFA verificatie succesvol.</p>";
    } else {
        echo "<p style='color:red;'>MFA verificatie mislukt. Probeer opnieuw.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MFA Verificatie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>MFA Verificatie</h2>
        <p>Voer uw Multi-factor Authenticatie (MFA) code in:</p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="mfa_code">MFA Code</label>
                <input type="text" class="form-control" id="mfa_code" name="mfa_code" required>
            </div>
            <button type="submit" class="btn btn-primary">Verifiëren</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
