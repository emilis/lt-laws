<?php

if (array_key_exists("REMOTE_ADDR", $_SERVER)) {
    die("Web access denied. Please use command line.");
}

$dir = dirname(__FILE__);
$url = "http://www3.lrs.lt/pls/inter3/dokpaieska.rezult_l?p_drus=102&p_gal=33&p_no=";

for ($i=1;$i<173;$i++) {
    echo "$i\n";
    $contents = file_get_contents("$url$i");
    file_put_contents("$dir/contents/$i.html", $contents);
    sleep(2);
}
