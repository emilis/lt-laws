<?php

$left = array_key_exists("left", $_GET) ? $_GET["left"] : "";
$right = array_key_exists("right", $_GET) ? $_GET["right"] : "";

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Įstatymų palyginimas</title>
</head>
<frameset cols="50%,50%">
    <frameset rows="110,*">
        <frame src="doc-chooser.php?side=left&url=<?php echo urlencode($left); ?>"></frame>
        <frame name="doc-left" src="<?php echo htmlspecialchars($left); ?>"></frame>
    </frameset>
    <frameset rows="110,*">
        <frame src="doc-chooser.php?side=right&url=<?php echo urlencode($right); ?>"></frame>
        <frame name="doc-right" src="<?php echo htmlspecialchars($right); ?>"></frame>
    </frameset>
</frameset>      
