<?php
session_start();

// Vernietig alle sessies
session_unset();
session_destroy();

// Stuur de gebruiker terug naar de loginpagina
header("Location: login.php");
exit;
?>