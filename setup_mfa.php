<?php
require_once '/var/www/vendor/autoload.php';
use RobThree\Auth\TwoFactorAuth;

session_start();

$_SESSION['user_logged_in'] = 1;

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    // echo "You must be logged in to set up MFA.";
    header("Location: login.php");
    exit;
}

// echo "Session started successfully.<br>";

$dotenv = \Dotenv\Dotenv::createImmutable('/var/www/');
$dotenv->load();

// Database connectie
$servername = "localhost";
$username = "root";
$password = $_ENV['DB_PASSWORD_ROOT'];
$database = "project5";

$conn = new mysqli($servername, $username, $password, $database);

// Enable error display for debugging (should be disabled in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$tfa = new TwoFactorAuth('project5');

// Retrieve user information from session
$gebruiker_id = $_SESSION['gebruiker_id'] ?? '';
$gebruikersnaam = $_SESSION['gebruikersnaam'] ?? '';

if ($gebruiker_id <= 0) {
    echo "Invalid User ID.";
    exit;
}

echo 'Gebruikersnaam: ' . htmlspecialchars($gebruikersnaam) . '<br>';

// Check if MFA secret already exists in the session
$secret = $_SESSION['mfa_secret'] ?? '';

// Debug: Check if secret is found in session
//if ($secret) {
//    echo "Secret already exists in session: " . htmlspecialchars($secret) . "<br>";
//} else {
//    echo "No secret in session. Creating new secret.<br>";
//}

// Generate a new secret if not already generated
if (!$secret) {
    $secret = $tfa->createSecret();

    // Debug: Check if secret generation is working
    //if ($secret) {
    //    echo "New secret generated: " . htmlspecialchars($secret) . "<br>";
    //} else {
    //    echo "Failed to generate secret.<br>";
    //}

    $_SESSION['mfa_secret'] = $secret;  // Temporarily store secret in session

    // Save secret to the database
    $stmt = $conn->prepare("UPDATE gebruikers SET mfa_secret=? WHERE gebruiker_id=?");
    if ($stmt) {
        $stmt->bind_param('si', $secret, $gebruiker_id);
        $stmt->execute();
        // echo "Secret saved to the database.<br>";
    } else {
        echo "Error preparing statement: " . $conn->error . "<br>";
    }

    // Generate QR code URL for the secret
    $qrCodeUrl = $tfa->getQRCodeImageAsDataUri('project5', $secret);

    // Debug: Check if QR code URL was generated
    //if ($qrCodeUrl) {
    //    echo "QR Code generated.<br>";
    //} else {
    //    echo "Failed to generate QR Code.<br>";
    //}
}

// Check if the verification code is submitted
$verificationCode = $_POST['verificationCode'] ?? '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($verificationCode)) {
    if ($tfa->verifyCode($secret, $verificationCode, 2)) {  // 2 = window for code verification
        // Verification success, clear the secret from the session
        //unset($_SESSION['mfa_secret']);
        header("Location: account.php");
        exit;
    } else {
        // Verification failed
        echo "<p>Verification failed. Please try again.</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup MFA</title>
</head>
<body>
    <h1>Setup Multi-Factor Authentication</h1>
    <?php if (!empty($qrCodeUrl)): ?>
        <p>Scan deze QR code met je MFA app authenticatie op te zetten:</p>
        <img src="<?= htmlspecialchars($qrCodeUrl) ?>" alt="MFA QR Code">
        <form method="post">
            <label for="verificationCode">Enter the code from the app:</label>
            <input type="text" id="verificationCode" name="verificationCode" required>
            <button type="submit">Verify</button>
        </form>
    <?php endif; ?>

    <p><a href="uitloggen.php">Uitloggen</a></p>
</body>
</html>
