<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Zlecenia<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Zlecenia<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/table.css">
<link rel="stylesheet" href="/css/icons.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/panel/" class="button">Strona główna</a>
<a href="/panel/jobs/add" class="button">Dodaj zlecenie</a>
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
        <input type="text" value="<?= $_GET["identificator"] ?? ""; ?>" name="identificator" class="form-control" id="floatingInput" placeholder="Identyfikator">
        <label for="floatingInput">Identyfikator</label>
    </div>
    <input type="submit" value="Szukaj">
</form>
<table id="clients-table">
    <tbody>
    <tr>
        <th>Identyfikator</th>
        <th>Status</th>
        <th>Data dodania</th>
        <th>Data zmiany danych</th>
        <th>Data usunięcia</th>
        <th>Operacje</th>
    </tr>
    <?php
    foreach($jobs as $job){
        $updated_at = $client->updated_at ?? "-";
        $deleted_at = $client->deleted_at ?? "-";

        $status_values = [
            "ok" => '<span class="material-symbols-outlined ok-icon">check_circle</span>Zakończone',
            "pending" => '<span class="material-symbols-outlined pending-icon">pending</span>W trakcie',
            "payment" => '<span class="material-symbols-outlined payment-icon">error</span><b>Do opłacenia</b>',
            "done" => '<span class="material-symbols-outlined pending-icon">apps</span>Wykonane'
        ];

        $status = $status_values[$job->status] ?? "-";

        echo <<<ENDL
                <tr class="data">
                    <td>$job->identificator</td>
                    <td class="status">$status</td>
                    <td>$job->created_at</td>
                    <td>$updated_at</td>
                    <td>$deleted_at</td>
                    <td>
                        <a class="table-button" href="/panel/jobs/view/$job->identificator"><span class="material-symbols-outlined view-icon">visibility</span></a>
            ENDL;

        if(isset($job->bill_id)){
            echo '<a class="table-button" href="/panel/bills/view/'.$job->bill_id.'" title="Wyświetl rachunek dla tego zlecenia"><span class="material-symbols-outlined ok-icon">payments</span></a>';
        }

        echo <<<ENDL
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
            <a class="page-link <?= $page_data["previous"]; ?>" href="/panel/jobs/<?= $page_data["last_page"]; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item active"><a class="page-link" href="/panel/jobs/<?= $page_data["current"];?>"><?= $page_data["current"];?>/<?= $page_data["available"];?></a></li>
        <li class="page-item <?= $page_data["next"]; ?>">
            <a class="page-link" href="/panel/<?= $page_data["next_page"]; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?= $this->endSection(); ?>
