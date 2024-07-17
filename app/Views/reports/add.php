<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Dodawanie raportu<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Dodawanie raportu<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/add.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/form.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel" class="button">Strona główna</a>
    <a href="/panel/clients/" class="button">Klienci</a>
    <a href="/account/" class="button">Mój profil</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('success')){
    $message = session("message");
    $success = (bool)session("success");

    if($success){
        echo <<<ENDL
            <div class="alert alert-success">
                $message
            </div>
        ENDL;
    }
    else{
        $errors = session("errors");

        echo '<div class="alert alert-danger"><ul>';
        foreach($errors as $error){
            echo "<li>".$error."</li>";
        }
        echo '</ul></div>';
    }
}
?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <textarea class="form-control" name="content" placeholder="Raport" id="floatingTextarea" style="height: 35vh"></textarea>
            <label for="floatingTextarea">Raport</label>
        </div>

        <div class="mb-3">
            <input class="form-control" type="file" id="formFile" name="files[]" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Dodaj raport</button>
    </form>
<?= $this->endSection(); ?>