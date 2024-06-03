<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Panel administracyjny<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Panel administracyjny<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/admin/index.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/admin/user/add/" class="button">Dodaj użytkownika</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<form id="search-bar" method="get">
    <div class="form-floating">
        <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Login użytkownika">
        <label for="floatingInput">Login użytkownika</label>
    </div>
    <input type="submit" value="Szukaj">
</form>
<table id="users-table">
    <tbody>
        <tr>
            <th>ID</th>
            <th>Imię i nazwisko</th>
            <th>Login</th>
            <th>Rola</th>
            <th>Data utworzenia</th>
            <th>Data zmiany danych</th>
            <th>Data usunięcia</th>
            <th>Operacje</th>
        </tr>
        <?php
        foreach($users as $user){
            $deleted_at = $user->deleted_at ?? "-";

            echo <<<ENDL
            <tr class="data">
                <td>$user->id</td>
                <td>$user->name</td>
                <td>$user->login</td>
                <td>$user->role</td>
                <td>$user->created_at</td>
                <td>$user->updated_at</td>
                <td>$deleted_at</td>
                <td>
                    <a class="table-button" href="/admin/user/edit/$user->id"><span class="material-symbols-outlined edit-icon">edit</span></a>
                    <a class="table-button" href="/admin/user/delete/$user->id"><span class="material-symbols-outlined delete-icon">delete</span></a>
                </td>
            </tr>
            ENDL;
        }
        ?>
    </tbody>
</table>
<?= $this->endSection(); ?>