<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinbpomDetailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinbpom_detailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fijinbpom_detailview = currentForm = new ew.Form("fijinbpom_detailview", "view");
    loadjs.done("fijinbpom_detailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ijinbpom_detail) ew.vars.tables.ijinbpom_detail = <?= JsonEncode(GetClientVar("tables", "ijinbpom_detail")) ?>;
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
<form name="fijinbpom_detailview" id="fijinbpom_detailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom_detail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_ijinbpom_detail_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_ijinbpom_detail_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namaalt->Visible) { // namaalt ?>
    <tr id="r_namaalt">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_namaalt"><?= $Page->namaalt->caption() ?></span></td>
        <td data-name="namaalt" <?= $Page->namaalt->cellAttributes() ?>>
<span id="el_ijinbpom_detail_namaalt">
<span<?= $Page->namaalt->viewAttributes() ?>>
<?= $Page->namaalt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <tr id="r_idproduct_acuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></span></td>
        <td data-name="idproduct_acuan" <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_ijinbpom_detail_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <tr id="r_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_ukuran"><?= $Page->ukuran->caption() ?></span></td>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_ijinbpom_detail_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodesample->Visible) { // kodesample ?>
    <tr id="r_kodesample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_kodesample"><?= $Page->kodesample->caption() ?></span></td>
        <td data-name="kodesample" <?= $Page->kodesample->cellAttributes() ?>>
<span id="el_ijinbpom_detail_kodesample">
<span<?= $Page->kodesample->viewAttributes() ?>>
<?= $Page->kodesample->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_detail_selesai"><?= $Page->selesai->caption() ?></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<span id="el_ijinbpom_detail_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
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
