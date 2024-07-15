<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Zlecenie - <?= $job_data->identificator; ?><?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Przeglądanie zlecenia<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/view.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/jobs/view.css">
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
    <div id="job">
        <div id="job-data">
            <div id="job-description">
                <h4>Opis zlecenia:</h4>
                <p>
                    <?= $job_data->description; ?>
                </p>
            </div>
            <div class="cell-2">
                <div id="job-status">
                    <h4>Status:</h4>
                    <span class="status">
                        <?php
                        $status_values = [
                            "ok" => '<span class="material-symbols-outlined ok-icon">check_circle</span>Zrealizowane',
                            "pending" => '<span class="material-symbols-outlined pending-icon">pending</span>W trakcie',
                            "payment" => '<span class="material-symbols-outlined payment-icon">error</span><b>Do opłacenia</b>'
                        ];

                        $status = $status_values[$job_data->status] ?? "-";

                        echo $status;
                        ?>
                    </span>
                </div>
                <div id="reports-data">
                    <h4>Informacje o raportach:</h4>
                    <p>
                        <b>Ilość raportów:</b> <?= $no_reports; ?>
                    </p>
                    <p>
                        <b>Ostatni raport:</b> <?= end($reports_data)["date"];?>
                    </p>
                </div>
            </div>
        </div>
        <table id="reports">
            <tbody>
            <?php
            foreach($reports_data as $report){
                $id = $report["id"];
                $preview = $report["preview"];
                $date = $report["date"];

                echo <<<ENDL
                <tr class="report-row">
                    <td>$preview</td>
                    <td>$date</td>
                    <td>
                        <a class="table-button" href="/panel/reports/view/$id"><span class="material-symbols-outlined view-icon">visibility</span></a>
                    </td>
                </tr>
                ENDL;
            }
            ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection(); ?>