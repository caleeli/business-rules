<?php

//use => php rename-project.php string_search string_to_replace

if (isset($argc)) {
    for ($i = 0; $i < $argc; $i++) {
        echo 'Argument #' . $i . ' - ' . $argv[$i] . "\n";
    }
} else {
    echo "argc and argv disabled\n";
    return;
}

if (!isset($argv[1])) {
    echo 'You need a parameter to perform the search...';
    return;
}

if (!isset($argv[2])) {
    echo 'You need a parameter to perform the replacement...';
    return;
}

function replaceStringInFile($filename, $stringToReplace, $replaceWith)
{
    $content = file_get_contents($filename);
    $content_chunks = explode($stringToReplace, $content);
    $content = implode($replaceWith, $content_chunks);
    file_put_contents($filename, $content);
}

function searchDirectoryFiles($path, $stringToReplace, $replaceWith)
{
    if (is_dir($path)) {
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if (is_dir($path . $file) && $file != "." && $file != ".." && strpos($file, 'node_modules') === false && strpos($file, '.git') === false) {
                    searchDirectoryFiles($path . $file . '/', $stringToReplace, $replaceWith);
                } else if (!is_dir($path . $file)) {
                    echo "\n Replacing: $path$file";

                    replaceStringInFile($path . $file, $stringToReplace, $replaceWith);
                }
            }
            closedir($dh);
        }
    } else {
        echo "\n Invalid path...";
    }
}

searchDirectoryFiles(getcwd() . '/', $argv[1], $argv[2]);

if (is_dir(getcwd() . '/')) {
    echo "\n Rename Directory...";
   rename(getcwd(), getcwd() . '/../' . $argv[2]);
}





