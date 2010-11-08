<?php

if (array_key_exists("url", $_GET))
    $url = $_GET["url"];
else
    $url = "";

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<form method="POST" action="go.php" target="doc-<?php echo $_GET["side"]; ?>">
<input id="user-url" name="user-url" style="width: 95%" value="<?php echo  $url; ?>">
<select name="url">
<option value="">Pasirinkite įstatymą...</option>
<?php

$laws = json_decode(file_get_contents(dirname(__FILE__) . "/laws.json"));

foreach ($laws->data as $law) {
    echo '<option value="' . $law[1] . '"';
    if ($url == $law[1])
        echo ' selected';
    echo '>';
    echo htmlspecialchars($law[2]);
    echo '</option>' . "\n";
}

?>
</select>
<input type="submit" value="rodyti">
</form>

<script type="text/javascript">
var url = document.getElementById("user-url");
if (!url.value) {
    url.value = "Įveskite adresą...";
    url.onfocus = function() {
        url.value = "";
        url.onfocus = undefined;
    }
}
</script>
</body>
</html>
