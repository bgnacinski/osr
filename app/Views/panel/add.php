<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel" class="button">Strona główna</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
    <form method="post">
        <div class="form-floating mb-3">
            <input name="name" type="text" class="form-control" id="floatingName" placeholder="Imię i nazwisko">
            <label for="floatingName">Imię i nazwisko</label>
        </div>
        <div class="form-floating mb-3">
            <input name="login" type="text" class="form-control" id="floatingLogin" placeholder="login">
            <label for="floatingLogin">Login</label>
        </div>
        <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Hasło">
            <label for="floatingPassword">Hasło</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="floatingSelect" name="role" aria-label="Rola">
                <option value="regular">Normalny</option>
                <option value="admin">Administrator</option>
                <option value="manager">Menadżer</option>
                <option value="viewer">Przeglądający</option>
            </select>
            <label for="floatingSelect">Rola</label>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj użytkownika</button>
    </form>
<?= $this->endSection(); ?>