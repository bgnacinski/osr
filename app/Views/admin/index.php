<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Panel administracyjny<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Panel administracyjny<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/icons.css">
<link rel="stylesheet" href="/css/table.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/admin/user/add/" class="button">Dodaj użytkownika</a>
<a href="/account/" class="button">Moje konto</a>
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

            if($deleted_at == "-"){
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
            else{
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
                        <a class="table-button" href="/admin/user/restore/$user->id"><span class="material-symbols-outlined restore-icon">replay</span></a>
                    </td>
                </tr>
                ENDL;
            }
        }
        ?>
    </tbody>
</table>
    <nav aria-label="pagination">
        <ul class="mt-3 pagination justify-content-center">
            <li class="page-item">
                <a class="page-link <?= $page_data["previous"]; ?>" href="/panel/<?= $page_data["last_page"]; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="/panel/<?= $page_data["current"];?>"><?= $page_data["current"];?>/<?= $page_data["available"];?></a></li>
            <li class="page-item <?= $page_data["next"]; ?>">
                <a class="page-link" href="/panel/<?= $page_data["next_page"]; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?= $this->endSection(); ?>