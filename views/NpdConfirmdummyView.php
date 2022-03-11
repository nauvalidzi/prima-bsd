<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdummyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdummyview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmdummyview = currentForm = new ew.Form("fnpd_confirmdummyview", "view");
    loadjs.done("fnpd_confirmdummyview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmdummy) ew.vars.tables.npd_confirmdummy = <?= JsonEncode(GetClientVar("tables", "npd_confirmdummy")) ?>;
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
<form name="fnpd_confirmdummyview" id="fnpd_confirmdummyview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdummy">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_confirmdummy_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_confirmdummy_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
    <tr id="r_dummydepan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummydepan"><?= $Page->dummydepan->caption() ?></span></td>
        <td data-name="dummydepan" <?= $Page->dummydepan->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummydepan">
<span<?= $Page->dummydepan->viewAttributes() ?>>
<?= $Page->dummydepan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
    <tr id="r_dummybelakang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummybelakang"><?= $Page->dummybelakang->caption() ?></span></td>
        <td data-name="dummybelakang" <?= $Page->dummybelakang->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummybelakang">
<span<?= $Page->dummybelakang->viewAttributes() ?>>
<?= $Page->dummybelakang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
    <tr id="r_dummyatas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummyatas"><?= $Page->dummyatas->caption() ?></span></td>
        <td data-name="dummyatas" <?= $Page->dummyatas->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummyatas">
<span<?= $Page->dummyatas->viewAttributes() ?>>
<?= $Page->dummyatas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
    <tr id="r_dummysamping">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummysamping"><?= $Page->dummysamping->caption() ?></span></td>
        <td data-name="dummysamping" <?= $Page->dummysamping->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummysamping">
<span<?= $Page->dummysamping->viewAttributes() ?>>
<?= $Page->dummysamping->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <tr id="r_catatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_catatan"><?= $Page->catatan->caption() ?></span></td>
        <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
<span id="el_npd_confirmdummy_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
    <tr id="r_ttd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_ttd"><?= $Page->ttd->caption() ?></span></td>
        <td data-name="ttd" <?= $Page->ttd->cellAttributes() ?>>
<span id="el_npd_confirmdummy_ttd">
<span<?= $Page->ttd->viewAttributes() ?>>
<?= $Page->ttd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_checked_by"><?= $Page->checked_by->caption() ?></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<span id="el_npd_confirmdummy_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_approved_by"><?= $Page->approved_by->caption() ?></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<span id="el_npd_confirmdummy_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_confirmdummy_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_confirmdummy_updated_at">
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
