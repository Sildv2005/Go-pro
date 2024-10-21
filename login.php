<?php
session_start();

$gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
$wachtwoord = $_POST['wachtwoord'] ?? '';

// Connect to the SQLite3 database
$db = new SQLite3('database.sqlite3');  // Update with the actual path to your .sqlite3 file

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($gebruikersnaam) && !empty($wachtwoord)) {
    $sql = "SELECT gebruiker_id, wachtwoord FROM gebruikers WHERE gebruikersnaam = :gebruikersnaam";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':gebruikersnaam', $gebruikersnaam, SQLITE3_TEXT);
    
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user) {
        $hashedWachtwoord = $user['wachtwoord'];
        if (password_verify($wachtwoord, $hashedWachtwoord)) {
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            $_SESSION['gebruiker_id'] = $user['gebruiker_id'];
            $_SESSION['user_logged_in'] = 1;
            header("Location: homepagina.php");
            exit();
        } else {
            $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Inloggen</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" required>
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
            </div>
            <p class="text-danger"><?php echo isset($foutmelding) ? $foutmelding : ""; ?></p>
            <button type="submit" class="btn btn-primary">Inloggen</button>
        </form>
        <p class="mt-3">Heeft u nog geen account? <a href="registratie.php">Registreer hier</a></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
