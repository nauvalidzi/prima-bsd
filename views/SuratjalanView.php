<?php

namespace PHPMaker2021\production2;

// Page object
$SuratjalanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsuratjalanview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fsuratjalanview = currentForm = new ew.Form("fsuratjalanview", "view");
    loadjs.done("fsuratjalanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.suratjalan) ew.vars.tables.suratjalan = <?= JsonEncode(GetClientVar("tables", "suratjalan")) ?>;
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
<form name="fsuratjalanview" id="fsuratjalanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="suratjalan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_suratjalan_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_suratjalan_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsurat->Visible) { // tglsurat ?>
    <tr id="r_tglsurat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_suratjalan_tglsurat"><?= $Page->tglsurat->caption() ?></span></td>
        <td data-name="tglsurat" <?= $Page->tglsurat->cellAttributes() ?>>
<span id="el_suratjalan_tglsurat">
<span<?= $Page->tglsurat->viewAttributes() ?>>
<?= $Page->tglsurat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
    <tr id="r_tglkirim">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_suratjalan_tglkirim"><?= $Page->tglkirim->caption() ?></span></td>
        <td data-name="tglkirim" <?= $Page->tglkirim->cellAttributes() ?>>
<span id="el_suratjalan_tglkirim">
<span<?= $Page->tglkirim->viewAttributes() ?>>
<?= $Page->tglkirim->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_suratjalan_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_suratjalan_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idalamat_customer->Visible) { // idalamat_customer ?>
    <tr id="r_idalamat_customer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_suratjalan_idalamat_customer"><?= $Page->idalamat_customer->caption() ?></span></td>
        <td data-name="idalamat_customer" <?= $Page->idalamat_customer->cellAttributes() ?>>
<span id="el_suratjalan_idalamat_customer">
<span<?= $Page->idalamat_customer->viewAttributes() ?>>
<?= $Page->idalamat_customer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_suratjalan_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_suratjalan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("suratjalan_detail", explode(",", $Page->getCurrentDetailTable())) && $suratjalan_detail->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("suratjalan_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SuratjalanDetailGrid.php" ?>
<?php } ?>
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
