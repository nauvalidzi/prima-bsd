<?php

namespace PHPMaker2021\distributor;

// Page object
$SerahterimaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fserahterimaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fserahterimaview = currentForm = new ew.Form("fserahterimaview", "view");
    loadjs.done("fserahterimaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.serahterima) ew.vars.tables.serahterima = <?= JsonEncode(GetClientVar("tables", "serahterima")) ?>;
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
<form name="fserahterimaview" id="fserahterimaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="serahterima">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_serahterima_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_serahterima_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_serahterima_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_serahterima_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggalrequest->Visible) { // tanggalrequest ?>
    <tr id="r_tanggalrequest">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_serahterima_tanggalrequest"><?= $Page->tanggalrequest->caption() ?></span></td>
        <td data-name="tanggalrequest" <?= $Page->tanggalrequest->cellAttributes() ?>>
<span id="el_serahterima_tanggalrequest">
<span<?= $Page->tanggalrequest->viewAttributes() ?>>
<?= $Page->tanggalrequest->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggalst->Visible) { // tanggalst ?>
    <tr id="r_tanggalst">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_serahterima_tanggalst"><?= $Page->tanggalst->caption() ?></span></td>
        <td data-name="tanggalst" <?= $Page->tanggalst->cellAttributes() ?>>
<span id="el_serahterima_tanggalst">
<span<?= $Page->tanggalst->viewAttributes() ?>>
<?= $Page->tanggalst->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_sample")->Count, $Language->phrase("DetailCount")) ?></h4>
<?php } ?>
<?php include_once "NpdSampleGrid.php" ?>
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
