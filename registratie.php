<?php
// Connect to the SQLite3 database
$db = new SQLite3('/var/www/Go-pro/database.sqlite3');  // Update with the actual path to your .sqlite3 file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':gebruikersnaam', $gebruikersnaam, SQLITE3_TEXT);
    $stmt->bindValue(':wachtwoord', $wachtwoord, SQLITE3_TEXT);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['gebruiker_id'] = $db->lastInsertRowID();
        $_SESSION['gebruikersnaam'] = $gebruikersnaam;
        header("Location: account.php");
    } else {
        echo "Fout bij het registreren van de gebruiker. Probeer het later opnieuw.";
    }
}

$db->close();
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
            <button type="submit" class="btn btn-primary">Registreren</button>
        </form>
        <p class="mt-3">Heeft u al een account? <a href="login.php">Log hier in</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
