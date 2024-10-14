// Beginwaarden voor liters en wattage
let maxGebruik = 3000;  // Maximaal waterverbruik (bijv. 100 liter)
let huidigGebruik = 0;  // Huidig waterverbruik in liters
let maxWattage = 300;  // Maximaal wattage (bijv. 500 watt)
let huidigWattage = 0;  // Huidig wattage

// Canvas elementen
let canvasGebruik = document.getElementById('cirkelGrafiekGebruik');
let ctxGebruik = canvasGebruik.getContext('2d');

let canvasWattage = document.getElementById('cirkelGrafiekWattage');
let ctxWattage = canvasWattage.getContext('2d');

// Functie om de cirkelgrafiek voor waterverbruik te tekenen
function tekenGrafiekGebruik() {
    ctxGebruik.clearRect(0, 0, canvasGebruik.width, canvasGebruik.height);

    // Teken buitenste cirkel voor literverbruik
    ctxGebruik.beginPath();
    ctxGebruik.arc(canvasGebruik.width / 2, canvasGebruik.height / 2, 90, 0, 2 * Math.PI);
    ctxGebruik.strokeStyle = '#ccc';
    ctxGebruik.lineWidth = 10;
    ctxGebruik.stroke();

    // Teken gevulde cirkel voor literverbruik
    let percentageGebruik = huidigGebruik / maxGebruik;
    let eindHoekGebruik = percentageGebruik * 2 * Math.PI;

    ctxGebruik.beginPath();
    ctxGebruik.arc(canvasGebruik.width / 2, canvasGebruik.height / 2, 90, -Math.PI / 2, eindHoekGebruik - Math.PI / 2);
    ctxGebruik.strokeStyle = '#00bfff';
    ctxGebruik.lineWidth = 10;
    ctxGebruik.stroke();

    // Tekst in het midden van de cirkel
    ctxGebruik.font = '20px Arial';
    ctxGebruik.fillStyle = '#000';
    ctxGebruik.textAlign = 'center';
    ctxGebruik.textBaseline = 'middle';
    ctxGebruik.fillText(`${huidigGebruik}L / ${maxGebruik}L`, canvasGebruik.width / 2, canvasGebruik.height / 2);
}

// Functie om de cirkelgrafiek voor wattage te tekenen
function tekenGrafiekWattage() {
    ctxWattage.clearRect(0, 0, canvasWattage.width, canvasWattage.height);

    // Teken buitenste cirkel voor wattage
    ctxWattage.beginPath();
    ctxWattage.arc(canvasWattage.width / 2, canvasWattage.height / 2, 90, 0, 2 * Math.PI);
    ctxWattage.strokeStyle = '#ccc';
    ctxWattage.lineWidth = 10;
    ctxWattage.stroke();

    // Teken gevulde cirkel voor wattage
    let percentageWattage = huidigWattage / maxWattage;
    let eindHoekWattage = percentageWattage * 2 * Math.PI;

    ctxWattage.beginPath();
    ctxWattage.arc(canvasWattage.width / 2, canvasWattage.height / 2, 90, -Math.PI / 2, eindHoekWattage - Math.PI / 2);
    ctxWattage.strokeStyle = '#ffbf00';
    ctxWattage.lineWidth = 10;
    ctxWattage.stroke();

    // Tekst in het midden van de cirkel
    ctxWattage.font = '20px Arial';
    ctxWattage.fillStyle = '#000';
    ctxWattage.textAlign = 'center';
    ctxWattage.textBaseline = 'middle';
    ctxWattage.fillText(`${huidigWattage}kWh / ${maxWattage}kWh`, canvasWattage.width / 2, canvasWattage.height / 2);
}

// Functies om het waterverbruik te verhogen/verlagen
function gebruikVerhogen() {
    if (huidigGebruik < maxGebruik) {
        huidigGebruik += 10;
        tekenGrafiekGebruik();
    }
}

function gebruikVerlagen() {
    if (huidigGebruik > 0) {
        huidigGebruik -= 1;
        tekenGrafiekGebruik();
    }
}

// Functies om het wattage te verhogen/verlagen
function wattageVerhogen() {
    if (huidigWattage < maxWattage) {
        huidigWattage += 10;  // Verhoog wattage met 50
        tekenGrafiekWattage();
    }
}

function wattageVerlagen() {
    if (huidigWattage > 0) {
        huidigWattage -= 1;  // Verlaag wattage met 50
        tekenGrafiekWattage();
    }
}

// Teken de initiële grafieken
tekenGrafiekGebruik();
tekenGrafiekWattage();
