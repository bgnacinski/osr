<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
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
    <form method="post">
        <div class="form-floating mb-3">
            <input required name="name" type="text" class="form-control" id="client_name" placeholder="Nazwa firmy">
            <label for="client_name">Nazwa firmy</label>
        </div>
        <div class="form-floating mb-3">
            <input required name="nip" type="numeric" class="form-control" id="nip_input" placeholder="NIP klienta">
            <label for="nip_input">NIP klienta</label>
        </div>
        <div class="form-floating mb-3">
            <input required name="email" type="email" class="form-control" id="email_input" placeholder="Adres e-mail">
            <label for="email_input">Adres e-mail</label>
        </div>
        <div class="input-group mb-3">
            <input required name="first_address" class="form-control" id="first_input" placeholder="Pierwsza linia adresowa">
            <input required name="second_address" class="form-control" id="second_input" placeholder="Druga linia adresowa">
        </div>

        <button type="submit" class="btn btn-primary">Dodaj klienta</button>
    </form>
<?= $this->endSection(); ?>