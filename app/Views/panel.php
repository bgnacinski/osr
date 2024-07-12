<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Panel logowania<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Panel logowania<?= $this->endSection(); ?>

<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/login.css">
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('message')){
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
        echo <<<ENDL
            <div class="alert alert-danger">
                $message
            </div>
        ENDL;
    }
}
?>
    <a href="/panel/jobs">Zlecenia</a>
    <a href="/panel/bills">Rachunki</a>
    <a href="/panel/clients">Klienci</a>
<?= $this->endSection(); ?>