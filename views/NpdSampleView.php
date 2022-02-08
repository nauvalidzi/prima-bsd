<?php

namespace PHPMaker2021\production2;

// Page object
$NpdSampleView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_sampleview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_sampleview = currentForm = new ew.Form("fnpd_sampleview", "view");
    loadjs.done("fnpd_sampleview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_sample) ew.vars.tables.npd_sample = <?= JsonEncode(GetClientVar("tables", "npd_sample")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_sampleview" id="fnpd_sampleview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_sample">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_sample_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_npd_sample_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_sample_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
    <tr id="r_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_sediaan"><?= $Page->sediaan->caption() ?></span></td>
        <td data-name="sediaan" <?= $Page->sediaan->cellAttributes() ?>>
<span id="el_npd_sample_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <tr id="r_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_ukuran"><?= $Page->ukuran->caption() ?></span></td>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_npd_sample_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_warna"><?= $Page->warna->caption() ?></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_sample_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bau->Visible) { // bau ?>
    <tr id="r_bau">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_bau"><?= $Page->bau->caption() ?></span></td>
        <td data-name="bau" <?= $Page->bau->cellAttributes() ?>>
<span id="el_npd_sample_bau">
<span<?= $Page->bau->viewAttributes() ?>>
<?= $Page->bau->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fungsi->Visible) { // fungsi ?>
    <tr id="r_fungsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_fungsi"><?= $Page->fungsi->caption() ?></span></td>
        <td data-name="fungsi" <?= $Page->fungsi->cellAttributes() ?>>
<span id="el_npd_sample_fungsi">
<span<?= $Page->fungsi->viewAttributes() ?>>
<?= $Page->fungsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <tr id="r_jumlah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_jumlah"><?= $Page->jumlah->caption() ?></span></td>
        <td data-name="jumlah" <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_npd_sample_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sample_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_sample_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
