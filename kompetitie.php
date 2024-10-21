<?php
// Een array met mensen en hun besparingen in procenten
$savers = [
    ["name" => "Jan", "savings" => 45],
    ["name" => "Piet", "savings" => 78],
    ["name" => "Klaas", "savings" => 33],
    ["name" => "Maria", "savings" => 92],
    ["name" => "Sara", "savings" => 84]
];

// Sorteer de array op basis van de besparingen (van hoog naar laag)
usort($savers, function($a, $b) {
    return $b['savings'] - $a['savings'];
});

// Haal de top 3 bespaarders op
$top3 = array_slice($savers, 0, 3);

// Kleuren voor de eerste drie posities
$medals = ["#FFD700", "#C0C0C0", "#CD7F32"]; // Goud, Zilver, Brons
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Bespaarders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #4CAF50, #8B4513); /* Groen naar bruin */
            margin: 0;
            min-height: 100vh;
            position: relative; /* Nodig voor absolute positionering van vakken */
        }

        h1 {
            margin-top: 20px;
            color: white;
            text-align: center;
        }

        /* Stijl voor elk individueel vakje */
        .box {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 150px;
            text-align: center;
            color: white; /* Witte tekstkleur voor contrast */
            position: absolute;
        }

        /* Grotere tekst voor de positie (1, 2, 3) */
        .position {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Stijl voor de naam van de persoon */
        .name {
            font-size: 20px;
            margin-bottom: 5px;
        }

        /* Stijl voor het besparingspercentage */
        .savings {
            font-size: 18px;
            color: white; /* Wit voor leesbaarheid */
        }

        /* Achtergrondkleuren voor goud, zilver en brons */
        .gold { background-color: #FFD700; }
        .silver { background-color: #C0C0C0; }
        .bronze { background-color: #CD7F32; }

        /* Posities op het scherm */
        .top-right { top: 10px; right: 10px; }   /* Helemaal rechtsboven */
        .middle { top: 50%; left: 50%; transform: translate(-50%, -50%); } /* Precies in het midden */
        .bottom-left { bottom: 10px; left: 10px; } /* Helemaal linksonder */
    </style>
</head>
<body>

    <h1>Top 3 Bespaarders</h1>

    <div class="container">
        <?php
        // Maak de top 3 vakjes en plaats ze op de juiste plek (top-right, middle, bottom-left)
        echo '<div class="box gold top-right">';
        echo '<div class="position">1</div>';
        echo '<div class="name">' . $top3[0]['name'] . '</div>';
        echo '<div class="savings">' . $top3[0]['savings'] . '% bespaard</div>';
        echo '</div>';

        echo '<div class="box silver middle">';
        echo '<div class="position">2</div>';
        echo '<div class="name">' . $top3[1]['name'] . '</div>';
        echo '<div class="savings">' . $top3[1]['savings'] . '% bespaard</div>';
        echo '</div>';

        echo '<div class="box bronze bottom-left">';
        echo '<div class="position">3</div>';
        echo '<div class="name">' . $top3[2]['name'] . '</div>';
        echo '<div class="savings">' . $top3[2]['savings'] . '% bespaard</div>';
        echo '</div>';
        ?>
    </div>

</body>
</html>
