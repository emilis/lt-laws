<?php

if ($_POST["user-url"]) {
    $location = $_POST["user-url"];
} else {
    $location = $_POST["url"];
}

header("Location: " . $location);
