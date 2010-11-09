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
<select id="url" name="url">
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
var user_url = document.getElementById("user-url");
if (!user_url.value) {
    user_url.value = "Įveskite adresą...";
    user_url.onfocus = function() {
        user_url.value = "";
        user_url.onfocus = undefined;
    }
}

var url = document.getElementById("url");
if (!url.onchange) {
    url.onchange = function() {
        user_url.value = "";
    }
}
</script>
</body>
</html>
