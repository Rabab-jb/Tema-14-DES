<?php

$apiUrl = "https://api.open-meteo.com/v1/forecast?latitude=40.2902&longitude=-3.8035&daily=temperature_2m_max,temperature_2m_min,weathercode&timezone=Europe/Madrid";


$response = file_get_contents($apiUrl);

if ($response === FALSE) {
    die("Error al obtener los datos del tiempo.");
}


$data = json_decode($response, true);

if ($data === NULL) {
    die("Error al decodificar los datos del tiempo.");
}

$forecast = $data['daily'];

$weatherData = [];

for ($i = 0; $i < 4; $i++) {
    $weatherData[] = [
        "fecha" => $forecast['time'][$i],
        "temperatura_maxima" => $forecast['temperature_2m_max'][$i],
        "temperatura_minima" => $forecast['temperature_2m_min'][$i],
        "icono" => getWeatherEmoji($forecast['weathercode'][$i]),
    ];
}

function getWeatherEmoji($code) {
    $weatherIcons = [
        0 => "☀️",  // Despejado
        1 => "🌤️",  // Mayormente despejado
        2 => "⛅",  // Parcialmente nublado
        3 => "☁️",  // Nublado
        45 => "🌫️",  // Niebla
        48 => "🌁",  // Niebla con escarcha
        51 => "🌦️",  // Llovizna ligera
        53 => "🌧️",  // Llovizna moderada
        55 => "🌧️",  // Llovizna intensa
        61 => "🌦️",  // Lluvia ligera
        63 => "🌧️",  // Lluvia moderada
        65 => "⛈️",  // Lluvia fuerte
        80 => "🌦️",  // Chubascos ligeros
        81 => "🌧️",  // Chubascos moderados
        82 => "🌧️",  // Chubascos fuertes
        95 => "⛈️",  // Tormenta
        96 => "⛈️",  // Tormenta con granizo ligero
        99 => "⛈️",  // Tormenta con granizo fuerte
    ];

    return $weatherIcons[$code] ?? "❓"; // Si no se encuentra el código, muestra ❓
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima en Fuenlabrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            font-size: 20px;
        }
    </style>
</head>
<body>

<h2>🌤️ Pronóstico del Tiempo en Fuenlabrada (Próximos 4 días)</h2>
<table>
    <tr>
        <th>Fecha</th>
        <th>Temperatura Máx</th>
        <th>Temperatura Mín</th>
        <th>Clima</th>
    </tr>
    <?php foreach ($weatherData as $day): ?>
    <tr>
        <td><?= $day['fecha'] ?></td>
        <td><?= $day['temperatura_maxima'] ?>°C</td>
        <td><?= $day['temperatura_minima'] ?>°C</td>
        <td><?= $day['icono'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
