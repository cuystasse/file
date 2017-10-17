<?php

if (!empty($_FILES)) {
    $error = [];
    $_FILES = $_FILES['upload'];

    $available_types = ['image/png', 'image/jpg', 'image/gif'];

    $nb_files = count($_FILES['name']);

    for ($i = 0; $i < $nb_files; $i++) {
        if ($_FILES['error'][$i]) {
            $error[$_FILES['name'][$i]] = 'Upload error ' . $_FILES['error'][$i] . ' on the file ' . $_FILES['name'][$i];
        } elseif (!in_array($_FILES['type'][$i], $available_types)) {
            $error[$_FILES['name'][$i]] = 'Type error on the file ' . $_FILES['name'][$i] . ' must be png/gif or jpg';
        }


    }

    // move images on dir
    if (empty($error)) {
        $dir = 'images/';

        for ($i = 0; $i < $nb_files; $i++) {

            $uploadFile = $_FILES['type'][$i];

            //generate unik name
            $uploadFile = str_replace('/', date('ymdhis') . '_' . $i . '.', $uploadFile);

            move_uploaded_file($_FILES['tmp_name'][$i], $dir . $uploadFile);

        }
    } else {
        var_dump($error);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quest PHP File</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<div class="container-fluid">

    <?php
    if (!empty($_GET['message'])) : ?>
    <?php if ($_GET['message'] == 'delete') : ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Delete done</strong> The file <?= $_GET['file_name'] ?> has been sent to the void.
        <?php endif ?>
        <?php if ($_GET['message'] == 'errordelete') : ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Delete Error</strong> The file <?= $_GET['file_name'] ?> not found for deletion.
            <?php endif ?>
        </div>
        <?php endif ?>

        <h1>Uploading your files</h1>

        <form action="#" enctype="multipart/form-data" method="post">
            <div>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?= 1 * 10 ** 6 ?>"/>
                <label for='upload'>Add files (.jpg/.png/.gif only and size < 1Mb) :</label>
                <input id='upload' name="upload[]" type="file" multiple="multiple"/>
            </div>

            <button type="submit" class="btn btn-primary">Upload my images</button>
        </form>

        <hr>

        <h2>Images already uploaded</h2>

        <div class="row">
            <?php
            $images = [];
            $files = new FilesystemIterator('images/');
            foreach ($files as $file) {
                $images[] = $file->getFilename();
            }

            if (empty($images)) : ?>
            <strong>No image found in the basement... try harder bro'<strong/>
                <?php endif;

                foreach ($images as $image) : ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img src="images/<?= $image ?>" alt="...">
                            <div class="caption">
                                <h3><?= $image ?></h3>

                                <form action="delete.php" method="post" role="form">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="filename" value="<?= $image ?>">
                                    </div>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
        </div> <!-- end row -->

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</body>
</html>