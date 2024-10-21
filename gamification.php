<!DOCTYPE html>
<html lang="nl">
<head>
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
    <h1>Welkom op de gamification pagina!</h1>
    <a class="account-button" href="truthorfalse.php">Truth or false</a>
    <br>
    <a class="account-button" href="kompetitie.php">Kompetitie</a>
</body>
</html>
