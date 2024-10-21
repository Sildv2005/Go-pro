<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
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
        .gamification-button {
            padding: 20px 40px;
            font-size: 24px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007BFF; /* Blauwe knopkleur */
            color: white;
            transition: background-color 0.3s;
        }
        .gamification-button:hover {
            background-color: #0056b3; /* Donkerder blauw bij hover */
        }
    </style>
</head>
<body>
    <a href="account.php" class="account-button">Account</a> <!-- Link naar accountpagina -->
    <h1>Welkom op de Homepage!</h1>
    <button class="gamification-button" onclick="location.href='gamification.php';">Gamification</button> <!-- Link naar gamification -->
</body>
</html>
