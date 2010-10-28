<?php

$url = "http://www3.lrs.lt/pls/inter3/dokpaieska.rezult_l?p_drus=102&p_gal=33&p_no=";

for ($i=1;$i<173;$i++) {
    $contents = file_get_contents("$url$i");

    sleep(2);
}
