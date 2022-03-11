<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdesignView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdesignview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmdesignview = currentForm = new ew.Form("fnpd_confirmdesignview", "view");
    loadjs.done("fnpd_confirmdesignview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmdesign) ew.vars.tables.npd_confirmdesign = <?= JsonEncode(GetClientVar("tables", "npd_confirmdesign")) ?>;
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
<form name="fnpd_confirmdesignview" id="fnpd_confirmdesignview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdesign">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_confirmdesign_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_confirmdesign_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desaindepan->Visible) { // desaindepan ?>
    <tr id="r_desaindepan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_desaindepan"><?= $Page->desaindepan->caption() ?></span></td>
        <td data-name="desaindepan" <?= $Page->desaindepan->cellAttributes() ?>>
<span id="el_npd_confirmdesign_desaindepan">
<span<?= $Page->desaindepan->viewAttributes() ?>>
<?= $Page->desaindepan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainbelakang->Visible) { // desainbelakang ?>
    <tr id="r_desainbelakang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_desainbelakang"><?= $Page->desainbelakang->caption() ?></span></td>
        <td data-name="desainbelakang" <?= $Page->desainbelakang->cellAttributes() ?>>
<span id="el_npd_confirmdesign_desainbelakang">
<span<?= $Page->desainbelakang->viewAttributes() ?>>
<?= $Page->desainbelakang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <tr id="r_catatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_catatan"><?= $Page->catatan->caption() ?></span></td>
        <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
<span id="el_npd_confirmdesign_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglprimer->Visible) { // tglprimer ?>
    <tr id="r_tglprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_tglprimer"><?= $Page->tglprimer->caption() ?></span></td>
        <td data-name="tglprimer" <?= $Page->tglprimer->cellAttributes() ?>>
<span id="el_npd_confirmdesign_tglprimer">
<span<?= $Page->tglprimer->viewAttributes() ?>>
<?= $Page->tglprimer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <tr id="r_desainsekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_desainsekunder"><?= $Page->desainsekunder->caption() ?></span></td>
        <td data-name="desainsekunder" <?= $Page->desainsekunder->cellAttributes() ?>>
<span id="el_npd_confirmdesign_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatansekunder->Visible) { // catatansekunder ?>
    <tr id="r_catatansekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_catatansekunder"><?= $Page->catatansekunder->caption() ?></span></td>
        <td data-name="catatansekunder" <?= $Page->catatansekunder->cellAttributes() ?>>
<span id="el_npd_confirmdesign_catatansekunder">
<span<?= $Page->catatansekunder->viewAttributes() ?>>
<?= $Page->catatansekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsekunder->Visible) { // tglsekunder ?>
    <tr id="r_tglsekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_tglsekunder"><?= $Page->tglsekunder->caption() ?></span></td>
        <td data-name="tglsekunder" <?= $Page->tglsekunder->cellAttributes() ?>>
<span id="el_npd_confirmdesign_tglsekunder">
<span<?= $Page->tglsekunder->viewAttributes() ?>>
<?= $Page->tglsekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_checked_by"><?= $Page->checked_by->caption() ?></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<span id="el_npd_confirmdesign_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_approved_by"><?= $Page->approved_by->caption() ?></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<span id="el_npd_confirmdesign_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_confirmdesign_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_confirmdesign_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
