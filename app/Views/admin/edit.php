<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Edycja danych użytkownika<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Edycja danych użytkownika<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/admin/index.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/admin" class="button">Strona główna</a>
    <a href="/admin/user/add/" class="button">Dodaj użytkownika</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>

<?= $this->endSection(); ?>