<?php
require '/var/www/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable('/var/www/');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connectie
    $servername = "localhost";
    $username = "root";
    $password = $_ENV['DB_PASSWORD_ROOT'];
    $database = "project5";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connectie mislukt: " . $conn->connect_error);
    }

    // Haal de gegevens op uit het formulier
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);
    $mfa_choice = strtolower(trim($_POST['registreren_met_mfa'])); // Zet naar lowercase en trim spaties

    // Voeg de gebruiker toe aan de database
    $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $gebruikersnaam, $wachtwoord);

    if ($stmt->execute()) {
        // Zet gebruiker_id in sessie voor het MFA-proces
        session_start();
        $_SESSION['gebruiker_id'] = $stmt->insert_id;
        $_SESSION['gebruikersnaam'] = $gebruikersnaam;

        // Controleer de keuze voor MFA (j of n)
        if (isset($_POST['submit_mfa'])) {
            echo "<script>console.log('Keuze: *" . $mfa_choice . "*');</script>"; // Log de keuze naar de console
        } elseif ($mfa_choice === 'j') {
            $_SESSION['user_logged_in'] = 1;
            echo "<script>console.log('Keuze: *" . $mfa_choice . "*');</script>"; // Log de keuze naar de console
            header("Location: setup_mfa.php"); // Stuur door naar setup_mfa.php als 'j' is geselecteerd
            // exit();
        } else {
            echo "<script>console.log('Keuze: *n*');</script>"; // Log de keuze naar de console
            header("Location: login.php"); // Anders naar de loginpagina
            // exit();
        }
    } else {
        echo "Fout bij het registreren van de gebruiker. Probeer het later opnieuw.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Registreren</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" required>
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
            </div>
            <div class="form-group">
                <label for="registreren_met_mfa">[j/N] Registreren met MFA</label>
                <input type="text" class="form-control" id="registreren_met_mfa" name="registreren_met_mfa" maxlength="1" pattern="[jnJN]?" title="Voer j of n in" placeholder="j of n">
            </div>
            <button type="submit" name="submit_mfa" class="btn btn-secondary">Toon keuze in console</button>
            <button type="submit" class="btn btn-primary">Registreren</button>
        </form>
        <p class="mt-3">Heeft u al een account? <a href="login.php">Log hier in</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
