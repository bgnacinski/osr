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
        <div class="input-group mb-3">
            <input required list="nip" name="client" type="text" class="form-control" placeholder="NIP klienta">
            <datalist id="nip">
                <?php
                foreach($clients as $client){
                    echo <<<ENDL
                        <option value="$client->nip">$client->nip - $client->name</option>
                    ENDL;
                }
                ?>
            </datalist>
        </div>

        <div class="input-group mb-3">
            <textarea required name="description" class="form-control" placeholder="Opis zlecenia" rows="10" aria-label="Opis zlecenia"></textarea>
        </div>

        <div class="input-group mb-3">
            <textarea name="comment" class="form-control" placeholder="Komentarz" rows="5" aria-label="Komentarz"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Dodaj zlecenie</button>
    </form>
<?= $this->endSection(); ?>