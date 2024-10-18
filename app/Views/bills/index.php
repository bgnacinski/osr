<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Rachunki<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Rachunki<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/table.css">
<link rel="stylesheet" href="/css/icons.css">
<link rel="stylesheet" href="/css/form.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/panel" class="button">Strona główna</a>
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
    <form id="search-bar" method="get">
        <div class="form-floating">
            <input type="text" value="<?= $_GET["identificator"] ?? ""; ?>" name="identificator" class="form-control" id="floatingInput" placeholder="Identyfikator rachunku">
            <label for="floatingInput">Identyfikator rachunku</label>
        </div>
        <input type="submit" value="Szukaj">
    </form>
    <table id="bills-table">
        <thead>
            <th>Identyfikator</th>
            <th>Data utworzenia</th>
            <th>Data zmiany danych</th>
            <th>Data usunięcia</th>
            <th>Operacje</th>
        </thead>
        <tbody>
        <?php
        foreach($bills as $bill){
            $updated_at = $bill->updated_at ?? "-";
            $deleted_at = $bill->deleted_at ?? "-";

            echo <<<ENDL
                <tr class="data">
                    <td>$bill->identificator</td>
                    <td>$bill->created_at</td>
                    <td>$updated_at</td>
                    <td>$deleted_at</td>
                    <td>
                        <a class="table-button" href="/panel/bills/view/$bill->id"><span class="material-symbols-outlined view-icon">visibility</span></a>
                        <a class="table-button" href="/panel/jobs/view/$bill->identificator" title="Wyświetl zlecenie"><span class="material-symbols-outlined pending-icon">work</span></a>
                    </td>
                </tr>
            ENDL;
        }
        ?>
        </tbody>
    </table>
    <nav aria-label="pagination">
        <ul class="mt-3 pagination justify-content-center">
            <li class="page-item">
                <a class="page-link <?= $page_data["previous"]; ?>" href="/panel/bills/<?= $page_data["last_page"]; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="/panel/bills/<?= $page_data["current"];?>"><?= $page_data["current"];?>/<?= $page_data["available"];?></a></li>
            <li class="page-item <?= $page_data["next"]; ?>">
                <a class="page-link" href="/panel/bills/<?= $page_data["next_page"]; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?= $this->endSection(); ?>