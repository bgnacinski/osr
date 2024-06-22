<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Strona główna<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Strona główna<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/table.css">
<link rel="stylesheet" href="/css/icons.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
<a href="/panel/bills/add" class="button">Dodaj rachunek</a>
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
            <input type="text" name="identificator" class="form-control" id="floatingInput" placeholder="Identyfikator rachunku">
            <label for="floatingInput">Identyfikator rachunku</label>
        </div>
        <input type="submit" value="Szukaj">
    </form>
    <table id="bills-table">
        <tbody>
        <tr>
            <th>Identyfikator</th>
            <th>Status</th>
            <th>Data utworzenia</th>
            <th>Data zmiany danych</th>
            <th>Data usunięcia</th>
            <th>Operacje</th>
        </tr>
        <?php
        foreach($bills as $bill){
            $updated_at = $bill->updated_at ?? "-";
            $deleted_at = $bill->deleted_at ?? "-";

            $session_values = [
                "ok" => "Zrealizowane",
                "pending" => "W trakcie",
                "payment" => "Do opłacenia"
            ];

            $status = $session_values[$bill->status];

            echo <<<ENDL
                <tr class="data">
                    <td>$bill->identificator</td>
                    <td>$status</td>
                    <td>$bill->created_at</td>
                    <td>$updated_at</td>
                    <td>$deleted_at</td>
                    <td>
                        <a class="table-button" href="/panel/bills/view/$bill->id"><span class="material-symbols-outlined view-icon">visibility</span></a>
                    </td>
                </tr>
            ENDL;
        }
        ?>
        </tbody>
    </table>
<?= $this->endSection(); ?>