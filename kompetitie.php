<?php
// Start de sessie om toegang te krijgen tot de ingevoerde gegevens
session_start();

// Haal de gebruikers en hun besparing op, indien aanwezig
$users = isset($_SESSION['users']) ? $_SESSION['users'] : [];

// Sorteer de gebruikers op basis van energiebesparing (van hoog naar laag)
usort($users, function($a, $b) {
    return $b['savings'] - $a['savings']; // hoogste percentage bovenaan
});

// Haal de top 3 bespaarders op
$top3 = array_slice($users, 0, 3);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competitie - Energiebesparing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #4CAF50, #8B4513); /* Groen naar bruin */
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Houdt inhoud bovenaan en footer onderaan */
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: white;
        }

        .box {
            background-color: rgba(0, 0, 0, 0.5); /* Zwarte transparante achtergrond */
            margin: 20px auto;
            padding: 15px;
            width: 300px;
            border-radius: 10px;
            color: white;
        }

        .name {
            font-size: 20px;
            font-weight: bold;
        }

        .savings {
            font-size: 18px;
            color: lightgreen;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.7); /* Donkere footer met transparantie */
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1>Energiebesparing Competitie - Top 3</h1>

    <?php if (!empty($top3)): ?>
        <?php foreach ($top3 as $index => $user): ?>
            <div class="box">
                <div class="name"><?= htmlspecialchars($user['name']) ?></div>
                <div class="savings"><?= htmlspecialchars($user['savings']) ?>% besparing</div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center;">Er zijn nog geen deelnemers toegevoegd.</p>
    <?php endif; ?>

    <a href="invoer.php" class="back-link">Voeg meer deelnemers toe</a>

    <footer>
        De gebruiker op nummer 1 krijgt aan het eind van de maand een besparingsbadge!
    </footer>

</body>
</html>


