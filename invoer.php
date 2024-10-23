<?php
// Start de sessie om ingevoerde gegevens op te slaan
session_start();

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['savings'])) {
    $name = htmlspecialchars($_POST['name']);
    $savings = floatval($_POST['savings']); // percentage besparing

    // Sla de invoer op in de sessie
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }

    // Voeg nieuwe gebruiker en hun besparing toe
    $_SESSION['users'][] = ["name" => $name, "savings" => $savings];

    // Redirect naar de competitiepagina
    header("Location: kompetitie.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energiebesparing Invoer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #4CAF50; /* Groene achtergrondkleur */
            color: white; /* Witte tekstkleur */
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5); /* Transparante zwarte achtergrond */
            padding: 20px;
            border-radius: 10px;
            width: 300px; /* Bredere form */
        }
        label {
            font-size: 18px;
            margin-bottom: 10px;
            color: white;
            text-align: left; /* Zorgt dat het label goed staat */
            width: 100%;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            width: 100%; /* Pas de breedte van de invoervelden aan */
            border: none;
            border-radius: 5px;
            margin-bottom: 20px; /* Meer ruimte tussen velden */
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF; /* Blauwe knopkleur */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3; /* Donkerder blauw bij hover */
        }
        .account-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007BFF; /* Blauwe knopkleur */
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none; /* Geen onderstreping */
            transition: background-color 0.3s;
        }
        .account-button:hover {
            background-color: #0056b3; /* Donkerder blauw bij hover */
        }
    </style>
</head>
<body>
    <a href="account.php" class="account-button">Account</a> <!-- Link naar accountpagina -->

    <h1>Voer jouw energiebesparing in (in procenten)</h1>

    <form method="POST" action="invoer.php">
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="savings">Energiebesparing (in %):</label>
        <input type="number" id="savings" name="savings" step="0.01" required>
        
        <input type="submit" value="Versturen">
    </form>
</body>
</html>
