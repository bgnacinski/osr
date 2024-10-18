<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Potwierdź zmianę - zlecenie <?= $identificator; ?><?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Zmiana zlecenia<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/jobs/confirm.css">
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel/" class="button">Strona główna</a>
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
    <div id="message">
        <?php
        $status_values = [
            "ok" => 'Zakończone',
            "pending" => 'W trakcie',
            "payment" => '<b>Do opłacenia</b>',
            "done" => 'Wykonane'
        ];

        $status = $status_values[$status] ?? "-";
        ?>
        <p>Czy na pewno chcesz potwierdzić zmianę statusu zlecenia <?= $identificator; ?> na <b><?= $status;?></b>?</p>
        <div id="confirm-buttons">
            <div>
                <a class="btn btn-primary" href="/panel/jobs/view/<?= $identificator; ?>">Powrót</a>
            </div>
            <form method="post">
                <?= csrf_field(); ?>
                <input type="submit" class="btn btn-danger" value="Potwierdź">
            </form>
        </div>
    </div>
<?= $this->endSection(); ?>