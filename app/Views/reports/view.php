<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Raport do zlecenia - <?= $job_data->identificator; ?><?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Przeglądanie raportu<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/view.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" media="print" href="/css/panel/bill-print.css">
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
    <div id="job-info" class="heading">
        <p class="status">
            <?php
            $session_values = [
                "ok" => '<span class="material-symbols-outlined ok-icon">check_circle</span>Zrealizowane',
                "pending" => '<span class="material-symbols-outlined pending-icon">pending</span>W trakcie',
                "payment" => '<span class="material-symbols-outlined payment-icon">error</span><b>Do opłacenia</b>'
            ];

            $status = $session_values[$job_data->status];

            echo $status;
            ?>
        </p>
        <p>
            <b>Identyfikator zlecenia: </b><?= $job_data->identificator; ?>
        </p>
    </div>
    <div class="heading">
        <p>
            <b>Numer raportu: </b><?= $report_data->number; ?>
        </p>
        <p>
            <b>Data dodania raportu: </b><?= $report_data->created_at; ?>
        </p>
        <p>
            <b>Dodane przez: </b><?= $report_data->created_by; ?>
        </p>
    </div>
    <div id="report-data">
        <p id="report-content" class="text-content">
            <?= str_replace("\n", "<br>", $report_data->content); ?>
        </p>
        <div id="report-files">
            <?php
            $files = explode(",", $report_data->files);
            $file_counter = 0;
            $image_counter = 0;

            foreach($files as $file){
                $extension = explode(".", $file);

                if(in_array($extension[1], ["jpg", "png", "jpeg", "heic"])){
                    $image_counter++;

                    echo '<a href="/panel/reports/view/'.$report_data->id.'/file/'.$file.'">Zdjęcie '.$image_counter.'</a>';
                }
                else{
                    $file_counter += 1;
                    echo '<a href="/panel/reports/view/'.$report_data->id.'/file/'.$file.'">Dokument '.$file_counter.'</a>';
                }
            }
            ?>
        </div>
    </div>
<?= $this->endSection(); ?>