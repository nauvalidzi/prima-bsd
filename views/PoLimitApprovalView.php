<?php

namespace PHPMaker2021\production2;

// Page object
$PoLimitApprovalView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpo_limit_approvalview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpo_limit_approvalview = currentForm = new ew.Form("fpo_limit_approvalview", "view");
    loadjs.done("fpo_limit_approvalview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.po_limit_approval) ew.vars.tables.po_limit_approval = <?= JsonEncode(GetClientVar("tables", "po_limit_approval")) ?>;
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
<form name="fpo_limit_approvalview" id="fpo_limit_approvalview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="po_limit_approval">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_po_limit_approval_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_po_limit_approval_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
    <tr id="r_limit_kredit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_limit_kredit"><?= $Page->limit_kredit->caption() ?></span></td>
        <td data-name="limit_kredit" <?= $Page->limit_kredit->cellAttributes() ?>>
<span id="el_po_limit_approval_limit_kredit">
<span<?= $Page->limit_kredit->viewAttributes() ?>>
<?= $Page->limit_kredit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->limit_po_aktif->Visible) { // limit_po_aktif ?>
    <tr id="r_limit_po_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_limit_po_aktif"><?= $Page->limit_po_aktif->caption() ?></span></td>
        <td data-name="limit_po_aktif" <?= $Page->limit_po_aktif->cellAttributes() ?>>
<span id="el_po_limit_approval_limit_po_aktif">
<span<?= $Page->limit_po_aktif->viewAttributes() ?>>
<?= $Page->limit_po_aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <tr id="r_lampiran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_lampiran"><?= $Page->lampiran->caption() ?></span></td>
        <td data-name="lampiran" <?= $Page->lampiran->cellAttributes() ?>>
<span id="el_po_limit_approval_lampiran">
<span<?= $Page->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($Page->lampiran, $Page->lampiran->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif" <?= $Page->aktif->cellAttributes() ?>>
<span id="el_po_limit_approval_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_po_limit_approval_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_po_limit_approval_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisalimitkredit->Visible) { // sisalimitkredit ?>
    <tr id="r_sisalimitkredit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_sisalimitkredit"><?= $Page->sisalimitkredit->caption() ?></span></td>
        <td data-name="sisalimitkredit" <?= $Page->sisalimitkredit->cellAttributes() ?>>
<span id="el_po_limit_approval_sisalimitkredit">
<span<?= $Page->sisalimitkredit->viewAttributes() ?>>
<?= $Page->sisalimitkredit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisapoaktif->Visible) { // sisapoaktif ?>
    <tr id="r_sisapoaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_po_limit_approval_sisapoaktif"><?= $Page->sisapoaktif->caption() ?></span></td>
        <td data-name="sisapoaktif" <?= $Page->sisapoaktif->cellAttributes() ?>>
<span id="el_po_limit_approval_sisapoaktif">
<span<?= $Page->sisapoaktif->viewAttributes() ?>>
<?= $Page->sisapoaktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("po_limit_approval_detail", explode(",", $Page->getCurrentDetailTable())) && $po_limit_approval_detail->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("po_limit_approval_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PoLimitApprovalDetailGrid.php" ?>
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
