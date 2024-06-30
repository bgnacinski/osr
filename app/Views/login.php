<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Panel logowania<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Panel logowania<?= $this->endSection(); ?>

<?= $this->section("links"); ?>
<link rel="stylesheet" href="/css/login.css">
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
<form method="post">
    <div class="form-floating mb-3">
        <input name="login" type="login" class="form-control" id="floatingInput" placeholder="nazwa użytkownika">
        <label for="floatingInput">Login</label>
    </div>
    <div class="form-floating">
        <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Hasło</label>
    </div>
  <button type="submit" class="mt-3 btn submit-button">Zaloguj</button>
</form>
<?= $this->endSection(); ?>