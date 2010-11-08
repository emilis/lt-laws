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
</body>
</html>
