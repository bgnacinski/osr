<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Panel użytkownika<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Panel użytkownika<?= $this->endSection(); ?>

<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/panel/index.css">

    <script>
        function redirect(location) {
            window.location = location;
        }
    </script>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('message')) {
    $message = session("message");
    $success = (bool)session("success");

    if ($success) {
        echo <<<ENDL
            <div class="alert alert-success">
                $message
            </div>
        ENDL;
    } else {
        echo <<<ENDL
            <div class="alert alert-danger">
                $message
            </div>
        ENDL;
    }
}
?>
    <div id="container">
        <div class="cell" onclick="redirect('/panel/jobs')">
            <span class="material-symbols-outlined cell-icon">work</span>
            <h4 class="cell-heading">Zlecenia</h4>
            <div id="jobs-data">
                <h3 class="main-info"><?= $jobs["count"]; ?></h3>
                <p class="status">
                    <span class="material-symbols-outlined ok-icon">check_circle</span>
                    Zakończone: <?= $jobs["ok"]; ?>
                </p>
                <p class="status">
                    <span class="material-symbols-outlined pending-icon">apps</span>
                    Wykonane: <?= $jobs["done"]; ?>
                </p>
                <p class="status">
                    <span class="material-symbols-outlined payment-icon">error</span>
                    Do opłacenia: <?= $jobs["payment"]; ?>
                </p>
                <p class="pending-jobs status">
                    <span class="material-symbols-outlined pending-icon">pending</span>
                    W trakcie: <?= $jobs["pending"]; ?>
                </p>
            </div>
        </div>
        <div id="secondary-cell">
            <div class="cell" onclick="redirect('/panel/bills')">
                <span class="material-symbols-outlined cell-icon">receipt_long</span>
                <h4 class="cell-heading">Rachunki</h4>
                <div id="jobs-data">
                    <h3 class="main-info"><?= $bills["count"]; ?></h3>
                </div>
            </div>
            <div class="cell" onclick="redirect('/panel/clients')">
                <span class="material-symbols-outlined cell-icon">group</span>
                <h4 class="cell-heading">Klienci</h4>
                <div id="jobs-data">
                    <h3 class="main-info"><?= $clients["count"]; ?></h3>
                </div>
            </div>
        </div>
        <div class="cell" onclick="redirect('/account')">
            <p>
                <span class="material-symbols-outlined cell-icon">for_you</span>
                <br>
                <h4 class="cell-heading">Mój profil</h4>
            </p>
        </div>
    </div>
<?= $this->endSection(); ?>