<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<form method="POST" action="go.php" target="doc-<?php echo $_GET["side"]; ?>">
<input name="user-url" style="width: 95%">
<select name="url">
<option value=""></option>
<?php

$laws = json_decode(file_get_contents(dirname(__FILE__) . "/docs.json"));

foreach ($laws as $law) {
    echo '<option value="' . $law->url . '">';
    echo htmlspecialchars($law->title);
    echo '</option>' . "\n";
}

?>
</select>
<input type="submit" value="show">
</form>
</body>
</html>
