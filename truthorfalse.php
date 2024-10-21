<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>True or False - Spel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .question {
            font-size: 24px;
            margin: 20px 0;
        }
        button {
            font-size: 18px;
            padding: 10px 20px;
            margin: 10px;
        }
    </style>
</head>
<body>

    <h1>Welkom bij True or False!</h1>
    <div id="gameArea">
        <button onclick="startGame()">Start Spel</button>
    </div>

    <script>
        // Stellingen en antwoorden
        const statements = [
            { question: "Gas is niet iets wat je hoeft te besparen.", answer: false },
            { question: "Het is slim om veel water te gebruiken.", answer: false },
            { question: "Door maaltijden voor de hele week voor te bereiden, kun je geld besparen op boodschappen.", answer: true },
            { question: "Water besparen door korter te douchen kan je energierekening verlagen.", answer: true },
            { question: "Investeren in zonnepanelen is een dure investering die geen geld bespaart op de lange termijn.", answer: false },
            { question: "Het is goedkoper om elke dag uit eten te gaan dan thuis te koken.", answer: false }
        ];

        let currentStatement;
        let correctAnswer;

        // Functie om het spel te starten
        function startGame() {
            // Willekeurig een stelling kiezen
            let randomIndex = Math.floor(Math.random() * statements.length);
            currentStatement = statements[randomIndex].question;
            correctAnswer = statements[randomIndex].answer;

            // Vraag tonen
            document.getElementById('gameArea').innerHTML = `
                <div class="question">${currentStatement}</div>
                <button onclick="checkAnswer(true)">True</button>
                <button onclick="checkAnswer(false)">False</button>
            `;
        }

        // Functie om het antwoord te controleren
        function checkAnswer(userAnswer) {
            if (userAnswer === correctAnswer) {
                alert("Goed gedaan, dat is juist!");
            } else {
                alert("Sorry, dat is onjuist. (noob)");
            }
            startGame();  // Start een nieuw spel
        }
    </script>

</body>
</html>
