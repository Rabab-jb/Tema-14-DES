<?php
$rss_url = "https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/portada";

try {
    $rss_content = file_get_contents($rss_url);

    if ($rss_content === false) {
        throw new Exception("No se pudo obtener el contenido del RSS.");
    }

    $xml = simplexml_load_string($rss_content);

    if ($xml === false) {
        throw new Exception("Error al analizar el contenido del RSS.");
    }

    echo "<h2>{$xml->channel->title}</h2>";
    echo "<ul>";

    foreach ($xml->channel->item as $item) {
        echo "<li>{$item->title}</li>";
    }

    echo "</ul>";
} catch (Exception $e) {
    echo "Se produjo un error: " . $e->getMessage();
}
?>

