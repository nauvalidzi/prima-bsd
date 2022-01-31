<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdSerahterimaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_serahterimaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_serahterimaview = currentForm = new ew.Form("fnpd_serahterimaview", "view");
    loadjs.done("fnpd_serahterimaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_serahterima) ew.vars.tables.npd_serahterima = <?= JsonEncode(GetClientVar("tables", "npd_serahterima")) ?>;
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
<form name="fnpd_serahterimaview" id="fnpd_serahterimaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_serahterima">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_npd_serahterima_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_request->Visible) { // tgl_request ?>
    <tr id="r_tgl_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_tgl_request"><?= $Page->tgl_request->caption() ?></span></td>
        <td data-name="tgl_request" <?= $Page->tgl_request->cellAttributes() ?>>
<span id="el_npd_serahterima_tgl_request">
<span<?= $Page->tgl_request->viewAttributes() ?>>
<?= $Page->tgl_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_serahterima->Visible) { // tgl_serahterima ?>
    <tr id="r_tgl_serahterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_tgl_serahterima"><?= $Page->tgl_serahterima->caption() ?></span></td>
        <td data-name="tgl_serahterima" <?= $Page->tgl_serahterima->cellAttributes() ?>>
<span id="el_npd_serahterima_tgl_serahterima">
<span<?= $Page->tgl_serahterima->viewAttributes() ?>>
<?= $Page->tgl_serahterima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
    <tr id="r_readonly">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_readonly"><?= $Page->readonly->caption() ?></span></td>
        <td data-name="readonly" <?= $Page->readonly->cellAttributes() ?>>
<span id="el_npd_serahterima_readonly">
<span<?= $Page->readonly->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_readonly_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->readonly->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->readonly->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_readonly_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_serahterima_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <tr id="r_receipt_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_receipt_by"><?= $Page->receipt_by->caption() ?></span></td>
        <td data-name="receipt_by" <?= $Page->receipt_by->cellAttributes() ?>>
<span id="el_npd_serahterima_receipt_by">
<span<?= $Page->receipt_by->viewAttributes() ?>>
<?= $Page->receipt_by->getViewValue() ?></span>
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
