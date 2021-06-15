<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinhakiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinhakiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fijinhakiview = currentForm = new ew.Form("fijinhakiview", "view");
    loadjs.done("fijinhakiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ijinhaki) ew.vars.tables.ijinhaki = <?= JsonEncode(GetClientVar("tables", "ijinhaki")) ?>;
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
<form name="fijinhakiview" id="fijinhakiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_ijinhaki_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_ijinhaki_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <tr id="r_idbrand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_idbrand"><?= $Page->idbrand->caption() ?></span></td>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<span id="el_ijinhaki_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktaperusahaan->Visible) { // aktaperusahaan ?>
    <tr id="r_aktaperusahaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_aktaperusahaan"><?= $Page->aktaperusahaan->caption() ?></span></td>
        <td data-name="aktaperusahaan" <?= $Page->aktaperusahaan->cellAttributes() ?>>
<span id="el_ijinhaki_aktaperusahaan">
<span<?= $Page->aktaperusahaan->viewAttributes() ?>>
<?= GetFileViewTag($Page->aktaperusahaan, $Page->aktaperusahaan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinhaki_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_selesai"><?= $Page->selesai->caption() ?></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<span id="el_ijinhaki_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("ijinhaki_status", explode(",", $Page->getCurrentDetailTable())) && $ijinhaki_status->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("ijinhaki_status", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("ijinhaki_status")->Count, $Language->phrase("DetailCount")) ?></h4>
<?php } ?>
<?php include_once "IjinhakiStatusGrid.php" ?>
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
