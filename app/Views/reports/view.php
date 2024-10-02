<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Raport do zlecenia - <?= $data->identificator; ?><?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Przeglądanie raportu<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/view.css">
    <link rel="stylesheet" href="/css/panel/bill-print.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel/" class="button">Strona główna</a>
    <a href="/panel/reports/add/<?= $data->id; ?>" class="button">Dodaj raport</a>
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
            $status_values = [
                "ok" => '<span class="material-symbols-outlined ok-icon">check_circle</span>Zakończone',
                "pending" => '<span class="material-symbols-outlined pending-icon">pending</span>W trakcie',
                "payment" => '<span class="material-symbols-outlined payment-icon">error</span><b>Do opłacenia</b>',
                "done" => '<span class="material-symbols-outlined pending-icon">apps</span>Wykonane'
            ];

            $status = $status_values[$data->status];

            echo $status;
            ?>
        </p>
        <p>
            <b>Identyfikator zlecenia: </b><?= $data->identificator; ?>
        </p>
    </div>
    <div class="heading">
        <p>
            <b>Numer raportu: </b><?= $data->number; ?>
        </p>
        <p>
            <b>Data dodania raportu: </b><?= $data->created_at; ?>
        </p>
        <p>
            <b>Dodane przez: </b><?= $data->created_by; ?>
        </p>
    </div>
    <div id="report-data">
        <p id="report-content" class="text-content">
            <?= str_replace("\n", "<br>", $data->content); ?>
        </p>
        <h6 class="hide-print" <?php if(is_null($data->files)){ echo "hidden"; }?>>Załączniki:</h6>
        <div id="report-files" class="file-list hide-print">
            <?php
            if(!is_null($data->files)){
                $files = explode(",", $data->files);
                $file_counter = 0;
                $image_counter = 0;

                foreach($files as $file){
                    $extension = explode(".", $file);

                    if(in_array($extension[1], ["jpg", "png", "jpeg", "heic"])){
                        $image_counter++;

                        echo '<a class="document-link image" href="/panel/reports/view/'.$data->id.'/file/'.$file.'">
                    <span class="material-symbols-outlined">photo_camera</span> Zdjęcie '.$image_counter.'
                    </a>';
                    }
                    else{
                        $file_counter += 1;
                        echo '<a class="document-link" href="/panel/reports/view/'.$data->id.'/file/'.$file.'">
                    <span class="material-symbols-outlined">description</span> Dokument '.$file_counter.'
                    </a>';
                    }
                }
            }
            ?>
        </div>
    </div>
<?= $this->endSection(); ?>