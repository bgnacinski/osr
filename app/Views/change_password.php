<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Panel logowania<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Panel logowania<?= $this->endSection(); ?>

<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/login.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel/" class="button">Strona główna</a>
    <a href="/panel/clients/" class="button">Klienci</a>
    <a href="/account/" class="button">Mój profil</a>
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
    <h5>Zmiana hasła użytkownika: <?= $user->login; ?></h5>
    <form method="post">
        <div class="form-floating mb-3">
            <input required name="password_first" type="password" class="form-control" id="floatingInput" placeholder="">
            <label for="floatingInput">Hasło</label>
        </div>
        <div class="form-floating">
            <input required name="password_second" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Potwierdź hasło</label>
        </div>
        <button type="submit" class="mt-3 btn submit-button">Zmień hasło</button>
    </form>
<?= $this->endSection(); ?>