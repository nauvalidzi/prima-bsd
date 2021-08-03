<?php

namespace PHPMaker2021\distributor;

// Page object
$PoLimitApprovalDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpo_limit_approvaldelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpo_limit_approvaldelete = currentForm = new ew.Form("fpo_limit_approvaldelete", "delete");
    loadjs.done("fpo_limit_approvaldelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.po_limit_approval) ew.vars.tables.po_limit_approval = <?= JsonEncode(GetClientVar("tables", "po_limit_approval")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpo_limit_approvaldelete" id="fpo_limit_approvaldelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="po_limit_approval">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->idorder->Visible) { // idorder ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><span id="elh_po_limit_approval_idorder" class="po_limit_approval_idorder"><?= $Page->idorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_po_limit_approval_idpegawai" class="po_limit_approval_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_po_limit_approval_idcustomer" class="po_limit_approval_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
        <th class="<?= $Page->limit_kredit->headerCellClass() ?>"><span id="elh_po_limit_approval_limit_kredit" class="po_limit_approval_limit_kredit"><?= $Page->limit_kredit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <th class="<?= $Page->limit_po_aktif->headerCellClass() ?>"><span id="elh_po_limit_approval_limit_po_aktif" class="po_limit_approval_limit_po_aktif"><?= $Page->limit_po_aktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
        <th class="<?= $Page->lampiran->headerCellClass() ?>"><span id="elh_po_limit_approval_lampiran" class="po_limit_approval_lampiran"><?= $Page->lampiran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_po_limit_approval_created_at" class="po_limit_approval_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_po_limit_approval_updated_at" class="po_limit_approval_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <td <?= $Page->idorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_idorder" class="po_limit_approval_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_idpegawai" class="po_limit_approval_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_idcustomer" class="po_limit_approval_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
        <td <?= $Page->limit_kredit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_limit_kredit" class="po_limit_approval_limit_kredit">
<span<?= $Page->limit_kredit->viewAttributes() ?>>
<?= $Page->limit_kredit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <td <?= $Page->limit_po_aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_limit_po_aktif" class="po_limit_approval_limit_po_aktif">
<span<?= $Page->limit_po_aktif->viewAttributes() ?>>
<?= $Page->limit_po_aktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
        <td <?= $Page->lampiran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_lampiran" class="po_limit_approval_lampiran">
<span<?= $Page->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($Page->lampiran, $Page->lampiran->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_created_at" class="po_limit_approval_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_updated_at" class="po_limit_approval_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
