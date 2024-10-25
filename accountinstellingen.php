<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// SQLite3 Database connectie
$db = new SQLite3('database.sqlite3');  // Zorg ervoor dat dit pad naar de SQLite3 database correct is

// Haal de huidige gebruikersinformatie op uit de database
$gebruiker_id = $_SESSION['gebruiker_id'];

$sql_fetch = "SELECT voornaam, achternaam, email FROM gebruikers WHERE gebruiker_id = :gebruiker_id";
$stmt_fetch = $db->prepare($sql_fetch);
$stmt_fetch->bindValue(':gebruiker_id', $gebruiker_id, SQLITE3_INTEGER);
$result = $stmt_fetch->execute();
$userData = $result->fetchArray(SQLITE3_ASSOC);

if ($userData) {
    $voornaam = $userData['voornaam'];
    $achternaam = $userData['achternaam'];
    $email = $userData['email'];
}

// Als de gebruiker gegevens wil wijzigen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['wijzig_account'])) {
    $voornaam_nieuw = $_POST['voornaam'];
    $achternaam_nieuw = $_POST['achternaam'];
    $emailadres_nieuw = $_POST['emailadres'];
    $gebruikersnaam_nieuw = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Update de gegevens in de database
    if (!empty($wachtwoord)) {
        // Als er een nieuw wachtwoord is opgegeven, update het wachtwoord
        $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $update_sql = "UPDATE gebruikers SET voornaam = :voornaam, achternaam = :achternaam, email = :email, gebruikersnaam = :gebruikersnaam, wachtwoord = :wachtwoord WHERE gebruiker_id = :gebruiker_id";
        $stmt = $db->prepare($update_sql);
        $stmt->bindValue(':wachtwoord', $hashedWachtwoord, SQLITE3_TEXT);
    } else {
        // Update alleen de andere gegevens (geen wachtwoord)
        $update_sql = "UPDATE gebruikers SET voornaam = :voornaam, achternaam = :achternaam, email = :email, gebruikersnaam = :gebruikersnaam WHERE gebruiker_id = :gebruiker_id";
        $stmt = $db->prepare($update_sql);
    }

    // Bind de waarden aan de parameters
    $stmt->bindValue(':voornaam', $voornaam_nieuw, SQLITE3_TEXT);
    $stmt->bindValue(':achternaam', $achternaam_nieuw, SQLITE3_TEXT);
    $stmt->bindValue(':email', $emailadres_nieuw, SQLITE3_TEXT);
    $stmt->bindValue(':gebruikersnaam', $gebruikersnaam_nieuw, SQLITE3_TEXT);
    $stmt->bindValue(':gebruiker_id', $gebruiker_id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        $_SESSION['gebruikersnaam'] = $gebruikersnaam_nieuw; // Werk de sessiegebruikersnaam bij
        $gebruikersnaam = $gebruikersnaam_nieuw;
        $succesmelding = "Accountgegevens succesvol bijgewerkt!";
    } else {
        $foutmelding = "Er is een fout opgetreden bij het bijwerken van uw gegevens.";
    }
}

$db->close();
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
                <div class="form-group">
                    <label for="voornaam" class="form-label">Voornaam:</label>
                    <input type="text" class="form-control" id="voornaam" name="voornaam" value="<?php echo htmlspecialchars($voornaam); ?>" required>
                </div>
                <div class="form-group">
                    <label for="achternaam" class="form-label">Achternaam:</label>
                    <input type="text" class="form-control" id="achternaam" name="achternaam" value="<?php echo htmlspecialchars($achternaam); ?>" required>
                </div>
                <div class="form-group">
                    <label for="emailadres" class="form-label">E-mailadres:</label>
                    <input type="email" class="form-control" id="emailadres" name="emailadres" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
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

            <div class="mt-3">
                <a href="account.php" class="btn btn-secondary">Terug</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
