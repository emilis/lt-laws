<?php

if (array_key_exists("REMOTE_ADDR", $_SERVER)) {
    die("Web access denied. Please use command line.");
}

$dir = dirname(__FILE__);

$docs = array();

// --- main ---

foreach (scandir("$dir/contents") as $line) {
    if ($line[0] != ".") {
        $xml = getXml(file_get_contents("$dir/contents/$line"));
        $docs = array_merge($docs, getRows($xml));
    }
}


// -- save laws: --
$laws = array();
foreach ($docs as $doc) {
    if ($doc["type"] != "dėl") {
        array_push($laws, array($doc["nr"], $doc["url"], $doc["title"]));
    }
}

function sort_laws($a, $b) {
    // compare titles:
    return ($a[2] < $b[2]) ? -1 : 1;
}

usort($laws, "sort_laws");
$laws = array(
    "fields" => array("nr", "url", "title"),
    "data" => $laws
);
file_put_contents("$dir/laws.json", json_encode($laws));


// -- get doc type stats: --
$types = array();
foreach ($docs as $doc) {
    @$types[$doc["type"]] = 1 + $types[$doc["type"]];

    if ($doc["type"] != "įstatymas" && $doc["type"] != "dėl") {
        echo "$doc[nr] | $doc[type] | $doc[url] | $doc[title]\n";
        //var_dump(explode(" " , $doc["title"]));
    }
}

foreach ($types as $type => $count) {
    echo "$type | $count\n";
}


// --- functions ---

function getXml($html) {
    $html = iconv("windows-1257", "utf-8", $html);

    $tidy = tidy_parse_string($html,
            array("clean" => true,
                "output-xhtml" => true,
                "wrap" => 0),
            "UTF8");
    $tidy->cleanRepair();

    $patterns = array(
        "&nbsp;",
        '<align="right">'
    );
    $replacements = array(
        " ",
        '<align>'
    );
    $tidy = str_replace($patterns, $replacements, $tidy);

    return new SimpleXMLElement($tidy);
}


function getRows($xml) {
    //$xpath = '/html/body/div/table/tr[3]/td/table/tr/td/align/table[2]/tr/td/span/a';
    $table = $xml->body->div->table->tr[2]->td->table->tr->td->align->table[1];

    $docs = array();
    foreach ($table->children() as $row) {
        if ($row->td[0]) {
            array_push($docs, parseRow($row));
        }
    }

    return $docs;
}

function parseRow($row) {
    $nr = strip_tags($row->td[0]->asXml());

    $dok = array();

    $link = $row->td[1]->span->a;
    $dok["title"] = trim(strip_tags($link->asXml()));
    $dok["url"] = fixUrl($link->attributes()->href);

    $parts = explode("<br/>", $row->td[1]->asXml());
    $dok["aktuali"] = trim(strip_tags($parts[1]));
    $dok["info"] = trim(strip_tags($parts[2]));

    $dok["data"] = trim(strip_tags($row->td[2]->asXml()));

    $dok["nr"] = trim(strip_tags($row->td[3]->asXml()));

    $dok["type"] = getDocType($dok["title"]);
    
    //echo "$dok[nr] | $dok[type] | $dok[url] | $dok[title]\n";

    return $dok;

}


function fixUrl($url) {
    $patterns = array(
        "http://www3.lrs.lt/pls/inter3/",
        "&p_query=&p_tr2="
    );
    $replacements = array(
        "http://www.lrs.lt/pls/inter/",
        ""
    );
    return str_replace($patterns, $replacements, $url);
}

function getDocType($title) {
    if (substr($title, 0, 4) == "Dėl" || substr($title, 0, 3) == "Del" || substr($title, 0, 3) == "del")
        return "dėl";
    else {
        $title = explode(" ", $title);
        switch (strtolower($title[0])) {
        case "įstatymas":
        case "Įstatymas":
            return "įstatymas";
            break;
        case "įsakymas":
        case "Įsakymas":
            return "įsakymas";
            break;
        case "nutarimas":
            return "dėl";
            break;
        default:
            //echo strtolower($title[0]) . " | $title\n";
        }
        $type =  strtolower(array_pop($title));
        if ($type == "Įstatymas")
            return "įstatymas";
        else
            return $type;
    }
}
