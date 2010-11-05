Scripts for getting a list of active laws in the Republic of Lithuania.

Requirements:

    PHP with SimpleXML and Tidy extensions.

Usage:

    php -f crawl.php
    php -f parse.php
    http://example.org/path/to/diff.php

Currently it downloads document index pages from the Parliament website, parses them and stores the list of laws into a JSON file.

After this you can open a diff.php script in your browser, select a law you want to see or enter url in each pane and compare the text.

