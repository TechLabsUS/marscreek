<?php

$path = "marscreek.com";

foreach (glob("$path/*", GLOB_ONLYDIR) as $dir) {
    // Move regular subdirectories
    foreach (glob("$dir/*", GLOB_ONLYDIR) as $subdir) {
        $target = __DIR__ . "/extracted/$subdir";
        
        if (!is_dir($target)) {
            mkdir($target, 0777, true);
        }
        
        $source = __DIR__ . "/$subdir";
        
        echo "Moving $source to $target\n";
        rename($source , $target);
    }
    
    // Move directories inside hidden subdirectories too
    foreach (glob("$dir/.*", GLOB_ONLYDIR) as $hiddendir) {
        if ($hiddendir == "$dir/." || $hiddendir == "$dir/..")
            continue;
        foreach (glob("$hiddendir/*", GLOB_ONLYDIR) as $subdir) {
            $target = __DIR__ . "/extracted/$subdir";
            
            if (!is_dir($target)) {
                mkdir($target, 0777, true);
            }
        
            $source = __DIR__ . "/$subdir";
            
            echo "Moving $source to $target\n";
            rename($source, $target);
        }
    }
}