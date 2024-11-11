<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Ausencias</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calendar">
        <header>
            <button id="prevMonth" onclick="moveMonth(-1)">&#10094;</button>
            <span id="monthYear"></span>
            <button id="nextMonth" onclick="moveMonth(1)">&#10095;</button>
        </header>
        <table id="calendarTable">
            <thead>
                <tr>
                    <th>Lun</th>
                    <th>Mar</th>
                    <th>Mié</th>
                    <th>Jue</th>
                    <th>Vie</th>
                    <th>Sáb</th>
                    <th>Dom</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script src="calendar.js"></script>
</body>
</html>