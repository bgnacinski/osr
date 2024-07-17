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
    <a href="/panel/reports/add/<?= $job_data->id; ?>" class="button">Dodaj raport</a>
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
    <div id="job" class="mb-3">
        <div id="job-data">
            <div id="job-description">
                <h4>Opis zlecenia:</h4>
                <p>
                    <?= str_replace("\n", "<br>", $job_data->description); ?>
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
                            "payment" => '<span class="material-symbols-outlined payment-icon">error</span><b>Do opłacenia</b>',
                            "done" => '<span class="material-symbols-outlined pending-icon">apps</span>Wykonano'
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
                        <b>Ostatni raport:</b> <?= end($reports_data)["date"] ?? "Brak raportów"; ?>
                    </p>
                </div>
                <div id="comment">
                    <h4>Komentarz:</h4>
                    <form method="post" action="/panel/jobs/update-comment/<?= $job_data->id; ?>">
                        <div class="mb-3">
                            <div class="col-auto">
                                <span id="commentHelpInline" class="form-text">
                                  Komentarz nie jest widoczny dla klienta.
                                </span>
                            </div>
                            <textarea class="form-control" id="comment-input" name="comment" rows="5"><?= $job_data->comment; ?></textarea>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-secondary mb-3">Zaktualizuj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="action-buttons" class="heading mb-3">
            <a class="btn btn-primary" href="/panel/reports/add/<?= $job_data->id; ?>">Dodaj raport</a>
            <?php

            $job_id = $job_data->identificator;

            if($job_data->status == "done"){
                echo '<a class="btn btn-success" target="_blank" href="/panel/bills/add/'.$job_id.'">Wystaw rachunek</a>';
            }
            else{
                echo '<a class="btn btn-danger" href="/panel/jobs/confirm/'.$job_id.'">Oznacz jako wykonane</a>';
            }
            ?>
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