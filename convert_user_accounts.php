<?php

// The path to your shadow file, which contains the old password database
$path = "marscreek.com/shadow";

// The domain portion of your email accounts
$domain = "walkergunco.com";

$fp = fopen($path, "r");
if ($fp) {
    $rows = array();
    while (($line = fgets($fp)) !== false) {
        // columns in shadow file are (id, username, password_hash, some number, ...)
        $columns = explode(":", $line);
        // Columns in SQLite DB are (id, email, password, extra, privileges).  So, we need to do some conversion here.
        $rows[] = "\n(NULL, \"{$columns[0]}@$domain\", \"{SHA512-CRYPT}{$columns[1]}\", \"\", \"\")";
    }
    fclose($fp);
    $query = "INSERT INTO users (id, email, password, extra, privileges) VALUES " .
                implode(",", $rows) . ";";
    echo $query;
} else {
    echo "File '$path' not found.";
} 