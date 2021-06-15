<?php

namespace PHPMaker2021\distributor;

// Page object
$RekeningView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var frekeningview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    frekeningview = currentForm = new ew.Form("frekeningview", "view");
    loadjs.done("frekeningview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.rekening) ew.vars.tables.rekening = <?= JsonEncode(GetClientVar("tables", "rekening")) ?>;
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
<form name="frekeningview" id="frekeningview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="rekening">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rekening_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_rekening_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_bank->Visible) { // nama_bank ?>
    <tr id="r_nama_bank">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rekening_nama_bank"><?= $Page->nama_bank->caption() ?></span></td>
        <td data-name="nama_bank" <?= $Page->nama_bank->cellAttributes() ?>>
<span id="el_rekening_nama_bank">
<span<?= $Page->nama_bank->viewAttributes() ?>>
<?= $Page->nama_bank->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_account->Visible) { // nama_account ?>
    <tr id="r_nama_account">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rekening_nama_account"><?= $Page->nama_account->caption() ?></span></td>
        <td data-name="nama_account" <?= $Page->nama_account->cellAttributes() ?>>
<span id="el_rekening_nama_account">
<span<?= $Page->nama_account->viewAttributes() ?>>
<?= $Page->nama_account->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_rek->Visible) { // no_rek ?>
    <tr id="r_no_rek">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rekening_no_rek"><?= $Page->no_rek->caption() ?></span></td>
        <td data-name="no_rek" <?= $Page->no_rek->cellAttributes() ?>>
<span id="el_rekening_no_rek">
<span<?= $Page->no_rek->viewAttributes() ?>>
<?= $Page->no_rek->getViewValue() ?></span>
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
