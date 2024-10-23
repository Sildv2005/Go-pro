<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij Go-pro!</title>
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
        h1 {
            margin-bottom: 20px;
        }
        .button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007BFF; /* Blauwe knopkleur */
            color: white;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3; /* Donkerder blauw bij hover */
        }
    </style>
</head>
<body>
    <h1>Welkom bij Go-pro!</h1>
    <p>Registreer of log in om verder te gaan.</p>
    <a href="registratie.php">
        <button class="button">Registreren</button>
    </a>
    <a href="login.php">
        <button class="button">Inloggen</button>
    </a>
</body>
</html>
