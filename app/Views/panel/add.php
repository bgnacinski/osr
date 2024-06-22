<?= $this->extend("templates/primary"); ?>
<?= $this->section("title"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("logo"); ?>Dodawanie rachunku<?= $this->endSection(); ?>
<?= $this->section("links"); ?>
    <link rel="stylesheet" href="/css/panel/add.css">
    <link rel="stylesheet" href="/css/table.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/form.css">
<script>
    var data = <?php echo json_encode($products, JSON_HEX_TAG); ?>;
</script>
<?= $this->endSection(); ?>

<?= $this->section("buttons"); ?>
    <a href="/panel" class="button">Strona główna</a>
    <a href="/panel/clients/" class="button">Klienci</a>
    <a href="/account/" class="button">Mój profil</a>
<?= $this->endSection(); ?>

<?= $this->section("main"); ?>
<?php
if (session()->has('success')){
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
        $errors = session("errors");

        echo '<div class="alert alert-danger"><ul>';
        foreach($errors as $error){
            echo "<li>".$error."</li>";
        }
        echo '</ul></div>';
    }
}
?>

    <form method="post">
        <div class="form-floating mb-3">
            <input required list="nip" name="nip" type="numeric" class="form-control" id="floatingName" placeholder="NIP klienta">
            <label for="floatingName">NIP klienta</label>
            <datalist id="nip">
                <?php
                foreach($clients as $client){
                    echo <<<ENDL
                        <option value="$client->nip">$client->nip - $client->name</option>
                    ENDL;
                }
                ?>
            </datalist>
        </div>
        <div class="form-floating mb-3">
            <select required id="currency" class="form-select" name="currency" aria-label="Waluta">
                <option value='AED'>AED - Dirham Zjednoczonych Emiratów Arabskich</option>
                <option value='AFN'>AFN - Afgani afgański</option>
                <option value='ALL'>ALL - Lek albański</option>
                <option value='AMD'>AMD - Dram armeński</option>
                <option value='ANG'>ANG - Gulden Antyli Holenderskich</option>
                <option value='AOA'>AOA - Kwanza angolski</option>
                <option value='ARS'>ARS - Peso argentyńskie</option>
                <option value='AUD'>AUD - Dolar australijski</option>
                <option value='AWG'>AWG - Gulden arubański</option>
                <option value='AZN'>AZN - Manat azerski</option>
                <option value='BAM'>BAM - Marka konwertybilna Bośni i Hercegowiny</option>
                <option value='BBD'>BBD - Dolar Barbadosu</option>
                <option value='BDT'>BDT - Taka bengalska</option>
                <option value='BGN'>BGN - Lew bułgarski</option>
                <option value='BHD'>BHD - Dinar bahrański</option>
                <option value='BIF'>BIF - Frank burundyjski</option>
                <option value='BMD'>BMD - Dolar bermudzki</option>
                <option value='BND'>BND - Dolar Brunei</option>
                <option value='BOB'>BOB - Boliviano boliwijskie</option>
                <option value='BRL'>BRL - Real brazylijski</option>
                <option value='BSD'>BSD - Dolar bahamski</option>
                <option value='BTN'>BTN - Ngultrum bhutański</option>
                <option value='BWP'>BWP - Pula botswańska</option>
                <option value='BYN'>BYN - Rubel białoruski</option>
                <option value='BZD'>BZD - Dolar belizeński</option>
                <option value='CAD'>CAD - Dolar kanadyjski</option>
                <option value='CDF'>CDF - Frank kongijski</option>
                <option value='CHF'>CHF - Frank szwajcarski</option>
                <option value='CLP'>CLP - Peso chilijskie</option>
                <option value='CNY'>CNY - Juan chiński</option>
                <option value='COP'>COP - Peso kolumbijskie</option>
                <option value='CRC'>CRC - Colón kostarykański</option>
                <option value='CUC'>CUC - Peso kubańskie wymienialne</option>
                <option value='CUP'>CUP - Peso kubańskie</option>
                <option value='CVE'>CVE - Escudo Zielonego Przylądka</option>
                <option value='CZK'>CZK - Korona czeska</option>
                <option value='DJF'>DJF - Frank Dżibuti</option>
                <option value='DKK'>DKK - Korona duńska</option>
                <option value='DOP'>DOP - Peso dominikańskie</option>
                <option value='DZD'>DZD - Dinar algierski</option>
                <option value='EGP'>EGP - Funt egipski</option>
                <option value='ERN'>ERN - Nakfa erytrejska</option>
                <option value='ETB'>ETB - Birr etiopski</option>
                <option value='EUR'>EUR - Euro</option>
                <option value='FJD'>FJD - Dolar Fidżi</option>
                <option value='FKP'>FKP - Funt Wysp Falklandzkich</option>
                <option value='FOK'>FOK - Korona Wysp Owczych</option>
                <option value='GBP'>GBP - Funt szterling</option>
                <option value='GEL'>GEL - Lari gruzińskie</option>
                <option value='GGP'>GGP - Funt Guernsey</option>
                <option value='GHS'>GHS - Cedzi ghańskie</option>
                <option value='GIP'>GIP - Funt gibraltarski</option>
                <option value='GMD'>GMD - Dalasi gambijski</option>
                <option value='GNF'>GNF - Frank gwinejski</option>
                <option value='GTQ'>GTQ - Quetzal gwatemalski</option>
                <option value='GYD'>GYD - Dolar gujański</option>
                <option value='HKD'>HKD - Dolar Hongkongu</option>
                <option value='HNL'>HNL - Lempira honduraska</option>
                <option value='HRK'>HRK - Kuna chorwacka</option>
                <option value='HTG'>HTG - Gourde haitański</option>
                <option value='HUF'>HUF - Forint węgierski</option>
                <option value='IDR'>IDR - Rupia indonezyjska</option>
                <option value='ILS'>ILS - Nowy szekel izraelski</option>
                <option value='IMP'>IMP - Funt Wyspy Man</option>
                <option value='INR'>INR - Rupia indyjska</option>
                <option value='IQD'>IQD - Dinar iracki</option>
                <option value='IRR'>IRR - Rial irański</option>
                <option value='ISK'>ISK - Korona islandzka</option>
                <option value='JEP'>JEP - Funt Jersey</option>
                <option value='JMD'>JMD - Dolar jamajski</option>
                <option value='JOD'>JOD - Dinar jordański</option>
                <option value='JPY'>JPY - Jen japoński</option>
                <option value='KES'>KES - Szyling kenijski</option>
                <option value='KGS'>KGS - Som kirgiski</option>
                <option value='KHR'>KHR - Riel kambodżański</option>
                <option value='KID'>KID - Dolar Kiribati</option>
                <option value='KMF'>KMF - Frank Komorów</option>
                <option value='KRW'>KRW - Won południowokoreański</option>
                <option value='KWD'>KWD - Dinar kuwejcki</option>
                <option value='KYD'>KYD - Dolar Kajmanów</option>
                <option value='KZT'>KZT - Tenge kazachskie</option>
                <option value='LAK'>LAK - Kip laotański</option>
                <option value='LBP'>LBP - Funt libański</option>
                <option value='LKR'>LKR - Rupia lankijska</option>
                <option value='LRD'>LRD - Dolar liberyjski</option>
                <option value='LSL'>LSL - Loti Lesoto</option>
                <option value='LYD'>LYD - Dinar libijski</option>
                <option value='MAD'>MAD - Dirham marokański</option>
                <option value='MDL'>MDL - Lej mołdawski</option>
                <option value='MGA'>MGA - Ariary malgaski</option>
                <option value='MKD'>MKD - Dinar macedoński</option>
                <option value='MMK'>MMK - Kyat birmański</option>
                <option value='MNT'>MNT - Tugrik mongolski</option>
                <option value='MOP'>MOP - Pataca Makau</option>
                <option value='MRU'>MRU - Ouguiya mauretańska</option>
                <option value='MUR'>MUR - Rupia Mauritiusu</option>
                <option value='MVR'>MVR - Rufiyaa malediwska</option>
                <option value='MWK'>MWK - Kwacha malawijska</option>
                <option value='MXN'>MXN - Peso meksykańskie</option>
                <option value='MYR'>MYR - Ringgit malezyjski</option>
                <option value='MZN'>MZN - Metical mozambicki</option>
                <option value='NAD'>NAD - Dolar namibijski</option>
                <option value='NGN'>NGN - Naira nigeryjska</option>
                <option value='NIO'>NIO - Córdoba nikaraguańska</option>
                <option value='NOK'>NOK - Korona norweska</option>
                <option value='NPR'>NPR - Rupia nepalska</option>
                <option value='NZD'>NZD - Dolar nowozelandzki</option>
                <option value='OMR'>OMR - Rial omański</option>
                <option value='PAB'>PAB - Balboa panamski</option>
                <option value='PEN'>PEN - Sol peruwiański</option>
                <option value='PGK'>PGK - Kina papuańska</option>
                <option value='PHP'>PHP - Peso filipińskie</option>
                <option value='PKR'>PKR - Rupia pakistańska</option>
                <option selected value='PLN'>PLN - Złoty polski</option>
                <option value='PYG'>PYG - Guarani paragwajskie</option>
                <option value='QAR'>QAR - Rial katarski</option>
                <option value='RON'>RON - Lej rumuński</option>
                <option value='RSD'>RSD - Dinar serbski</option>
                <option value='RUB'>RUB - Rubel rosyjski</option>
                <option value='RWF'>RWF - Frank rwandyjski</option>
                <option value='SAR'>SAR - Rial saudyjski</option>
                <option value='SBD'>SBD - Dolar Wysp Salomona</option>
                <option value='SCR'>SCR - Rupia seszelska</option>
                <option value='SDG'>SDG - Funt sudański</option>
                <option value='SEK'>SEK - Korona szwedzka</option>
                <option value='SGD'>SGD - Dolar singapurski</option>
                <option value='SHP'>SHP - Funt Świętej Heleny</option>
                <option value='SLL'>SLL - Leone sierraleoński</option>
                <option value='SOS'>SOS - Szyling somalijski</option>
                <option value='SRD'>SRD - Dolar surinamski</option>
                <option value='SSP'>SSP - Funt południowosudański</option>
                <option value='STN'>STN - Dobra Wysp Świętego Tomasza i Książęcej</option>
                <option value='SYP'>SYP - Funt syryjski</option>
                <option value='SZL'>SZL - Lilangeni Suazi</option>
                <option value='THB'>THB - Baht tajski</option>
                <option value='TJS'>TJS - Somoni tadżyckie</option>
                <option value='TMT'>TMT - Manat turkmeński</option>
                <option value='TND'>TND - Dinar tunezyjski</option>
                <option value='TOP'>TOP - Paʻanga tongijska</option>
                <option value='TRY'>TRY - Lira turecka</option>
                <option value='TTD'>TTD - Dolar Trynidadu i Tobago</option>
                <option value='TVD'>TVD - Dolar Tuvalu</option>
                <option value='TWD'>TWD - Nowy dolar tajwański</option>
                <option value='TZS'>TZS - Szyling tanzański</option>
                <option value='UAH'>UAH - Hrywna ukraińska</option>
                <option value='UGX'>UGX - Szyling ugandyjski</option>
                <option value='USD'>USD - Dolar amerykański</option>
                <option value='UYU'>UYU - Peso urugwajskie</option>
                <option value='UZS'>UZS - Som uzbecki</option>
                <option value='VED'>VED - Boliwar soberano (Wenezuela)</option>
                <option value='VES'>VES - Boliwar (Wenezuela)</option>
                <option value='VND'>VND - Đồng wietnamski</option>
                <option value='VUV'>VUV - Vatu Vanuatu</option>
                <option value='WST'>WST - Tala samoańska</option>
                <option value='XAF'>XAF - Frank CFA Środkowoafrykański</option>
                <option value='XCD'>XCD - Dolar wschodniokaraibski</option>
                <option value='XDR'>XDR - Specjalne Prawa Ciągnienia</option>
                <option value='XOF'>XOF - Frank CFA Zachodnioafrykański</option>
                <option value='XPF'>XPF - Frank CFP</option>
                <option value='YER'>YER - Rial jemeński</option>
                <option value='ZAR'>ZAR - Rand południowoafrykański</option>
                <option value='ZMW'>ZMW - Kwatcza zambijska</option>
                <option value='ZWL'>ZWL - Dolar Zimbabwe</option>
            </select>
            <label for="currency">Waluta</label>
        </div>
        <div class="form-floating mb-3">
            <select required id="status" class="form-select" name="status" aria-label="Status">
                <option value="ok">Zrealizowane</option>
                <option selected value="pending">W trakcie</option>
                <option value="payment">Do opłacenia</option>
            </select>
            <label for="tax_rate">Status</label>
        </div>

        <input type="text" required hidden id="bill_contents" name="bill_contents">

        <table class="mb-3">
            <tbody id="bill_contents_table">
                <tr>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Wartość netto</th>
                    <th>VAT</th>
                    <th>Wartość brutto</th>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Dodaj rachunek</button>
    </form>

    <div id="insert-form">
        <div class="form-floating mb-3">
            <select class="form-select" id="product_name" name="role" aria-label="Nazwa produktu">
                <?php
                foreach($products as $product){
                    echo <<<ENDL
                        <option value="$product->name">$product->name</option>
                    ENDL;
                }
                ?>
            </select>
            <label for="product_name">Nazwa produktu</label>
        </div>
        <div class="form-floating mb-3">
            <input type="numeric" class="form-control" id="quantity" placeholder="Ilość">
            <label for="quantity">Ilość</label>
        </div>

        <button class="btn btn-secondary" onclick="addEntry()">Dodaj do rachunku</button>
    </div>

<script src="/js/entry.js"></script>
<?= $this->endSection(); ?>