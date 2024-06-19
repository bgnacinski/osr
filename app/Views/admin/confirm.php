<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Usuwanie danych użytkownika<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Usuwanie danych użytkownika<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/notify.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/admin" class="button">Strona główna</a>
    <a href="/admin/user/add/" class="button">Dodaj użytkownika</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if($action == "delete"){
    $text = "Czy na pewno chcesz usunąć konto użytkownika";
    $btn_text = "Usuń";
}
else{
    $text = "Czy na pewno chcesz przywrócić konto użytkownika";
    $btn_text = "Przywróć";
}
?>
<div id="confirmation" class="<?= $action ?>">
    <h1>Uwaga!</h1>
    <h6><?= $text ?> '<?= $user->name; ?>'</h6>

    <div id="confirm-buttons">
        <a class="<?= $action ?>" href="/admin">Powrót</a>
        <form method="post">
            <input type="text" name="user_id" hidden value="<?= $user->id ?>">
            <input class="<?= $action ?>" type="submit" value="<?= $btn_text ?>">
        </form>
    </div>
</div>
<?= $this->endSection(); ?>