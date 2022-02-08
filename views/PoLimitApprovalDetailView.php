<?php

namespace PHPMaker2021\production2;

// Page object
$PoLimitApprovalDetailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpo_limit_approval_detailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpo_limit_approval_detailview = currentForm = new ew.Form("fpo_limit_approval_detailview", "view");
    loadjs.done("fpo_limit_approval_detailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.po_limit_approval_detail) ew.vars.tables.po_limit_approval_detail = <?= JsonEncode(GetClientVar("tables", "po_limit_approval_detail")) ?>;
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
<form name="fpo_limit_approval_detailview" id="fpo_limit_approval_detailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="po_limit_approval_detail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idapproval->Visible) { // idapproval ?>
    <tr id="r_idapproval">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_detail_idapproval"><?= $Page->idapproval->caption() ?></span></td>
        <td data-name="idapproval" <?= $Page->idapproval->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_idapproval">
<span<?= $Page->idapproval->viewAttributes() ?>>
<?= $Page->idapproval->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
    <tr id="r_idorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_detail_idorder"><?= $Page->idorder->caption() ?></span></td>
        <td data-name="idorder" <?= $Page->idorder->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kredit_terpakai->Visible) { // kredit_terpakai ?>
    <tr id="r_kredit_terpakai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_detail_kredit_terpakai"><?= $Page->kredit_terpakai->caption() ?></span></td>
        <td data-name="kredit_terpakai" <?= $Page->kredit_terpakai->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_kredit_terpakai">
<span<?= $Page->kredit_terpakai->viewAttributes() ?>>
<?= $Page->kredit_terpakai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_detail_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
