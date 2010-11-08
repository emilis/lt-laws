<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Lietuvos Respublikos įstatymai</title>
</head>
<body>
    <h1>Lietuvos Respublikos įstatymai:</h1>
    <ul><?php

$dir = dirname(__FILE__);
$laws = json_decode(file_get_contents("$dir/laws.json"));

foreach ($laws->data as $law) {
    echo '<li><a href="' . $law[1] . '">' . $law[2];
    if ($law[0])
        echo " ($law[0])";
    echo '</a>';
    echo ' <small><small><a href="compare.php?left=' . $law[1] . '">palyginti</a></small></small>';
    echo "</li>\n";
}

?>
</ul>
<hr>
<p>Viso: <?php echo count($laws->data); ?></p>
<p>Duomenys atnaujinti: <?php echo date('c', filemtime("$dir/laws.json")); ?><br>
Duomenų failai: <a href="laws.json">JSON</a>, <a href="laws.csv">CSV</a> (tinka Exceliui)<br>
Jokių garantijų dėl duomenų patikimumo neteikiame!</p>

<p><a href="http://manovalstybe.lt/">ManoValstybė.lt</a> projektas. Programos kodas: <a href="https://github.com/emilis/lt-laws">https://github.com/emilis/lt-laws</a></p>
</body>
</html>
