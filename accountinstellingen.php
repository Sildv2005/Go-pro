<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Database connectie
$servername = "localhost";
$username = "root";
$password = "root";
$database = "project5";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

// Haal de huidige gebruikersinformatie op uit de database
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$gebruiker_id = $_SESSION['gebruiker_id'];

$sql_fetch = "SELECT voornaam, achternaam, email FROM gebruikers WHERE gebruiker_id = ?";
$stmt_fetch = $conn->prepare($sql_fetch);
$stmt_fetch->bind_param("i", $gebruiker_id);
$stmt_fetch->execute();
$stmt_fetch->bind_result($voornaam, $achternaam, $email);
$stmt_fetch->fetch();
$stmt_fetch->close();

// Als de gebruiker gegevens wil wijzigen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['wijzig_account'])) {
    $naam = $_POST['naam'];
    $emailadres = $_POST['emailadres'];
    $gebruikersnaam_nieuw = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Update de gegevens in de database
    if (!empty($wachtwoord)) {
        // Als er een nieuw wachtwoord is opgegeven, update het wachtwoord
        $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $update_sql = "UPDATE gebruikers SET voornaam = ?, achternaam = ?, email = ?, gebruikersnaam = ?, wachtwoord = ? WHERE gebruiker_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssi", $naam, $achternaam, $emailadres, $gebruikersnaam_nieuw, $hashedWachtwoord, $gebruiker_id);
    } else {
        // Update alleen de andere gegevens (geen wachtwoord)
        $update_sql = "UPDATE gebruikers SET voornaam = ?, achternaam = ?, email = ?, gebruikersnaam = ? WHERE gebruiker_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $naam, $achternaam, $emailadres, $gebruikersnaam_nieuw, $gebruiker_id);
    }

    if ($stmt->execute()) {
        $_SESSION['gebruikersnaam'] = $gebruikersnaam_nieuw; // Werk de sessiegebruikersnaam bij
        $gebruikersnaam = $gebruikersnaam_nieuw;
        $succesmelding = "Accountgegevens succesvol bijgewerkt!";
    } else {
        $foutmelding = "Er is een fout opgetreden bij het bijwerken van uw gegevens.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountinstellingen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .account-container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Accountinstellingen</h2>

        <!-- Meldingen voor succes of fout -->
        <?php if (isset($succesmelding)) echo "<p class='text-success'>$succesmelding</p>"; ?>
        <?php if (isset($foutmelding)) echo "<p class='text-danger'>$foutmelding</p>"; ?>

        <div class="account-container">
            <!-- Formulier voor het bijwerken van accountgegevens -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Gebruikersgegevens -->
                <div class="form-group">
                    <label for="naam" class="form-label">Naam:</label>
                    <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($voornaam . ' ' . $achternaam); ?>" required>
                </div>
                <div class="form-group">
                    <label for="emailadres" class="form-label">E-mailadres:</label>
                    <input type="email" class="form-control" id="emailadres" name="emailadres" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <!-- Aanmeldingsgegevens -->
                <div class="form-group">
                    <label for="gebruikersnaam" class="form-label">Gebruikersnaam:</label>
                    <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" value="<?php echo htmlspecialchars($gebruikersnaam); ?>" required>
                </div>
                <div class="form-group">
                    <label for="wachtwoord" class="form-label">Wachtwoord (laat leeg om het wachtwoord niet te wijzigen):</label>
                    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord">
                </div>

                <button type="submit" class="btn btn-primary" name="wijzig_account">Gegevens bijwerken</button>
            </form>

            <!-- Meer instellingen knop -->
            <div class="mt-3">
                <a href="meer_instellingen.php" class="btn btn-secondary">Meer instellingen...</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
