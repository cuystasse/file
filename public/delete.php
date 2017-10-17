<?php

if (!empty($_POST)) {

    $images = [];
    $files = new FilesystemIterator('images/');
    foreach ($files as $file) {
        $images[] = $file->getFilename();
    }

    $filename = $_POST['filename'];
    if (in_array($filename, $images)) {
        $file_path = 'images/';
        $file_path .= $filename;
        unlink($file_path);
        header('Location: index.php?message=delete&file_name=' . $filename);
        exit;
    }
}

header('Location: index.php?message=errordelete&file_name=' . $filename);
