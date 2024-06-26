<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Mój profil<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Mój profil<?= $this->endSection(); ?>

<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/account.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel/" class="button">Strona główna</a>
    <a href="/panel/clients/" class="button">Klienci</a>
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
<div id="user-data">
    <p>
        <b>Imię i nazwisko:</b> <?= $user->name ?>
    </p>
    <p>
        <b>Login:</b> <?= $user->login ?>
    </p>
    <p>
        <b>Rola:</b>
        <?php
            $role_arr = [
                "admin" => "Administrator",
                "manager" => "Manager",
                "regular" => "Zwykły użytkownik",
                "viewer" => "Przeglądający"
            ];

            echo $role_arr[$user->role];
        ?>
    </p>
</div>
<div id="user-buttons">
    <div>
        <a class="btn btn-danger" href="/account/change-password">Zmień hasło</a>
    </div>
    <form method="post" action="/account/logout">
        <input type="submit" class="btn btn-primary" value="Wyloguj się">
    </form>
</div>
<?= $this->endSection(); ?>