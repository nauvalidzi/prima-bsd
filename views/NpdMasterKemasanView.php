<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdMasterKemasanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_master_kemasanview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_master_kemasanview = currentForm = new ew.Form("fnpd_master_kemasanview", "view");
    loadjs.done("fnpd_master_kemasanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_master_kemasan) ew.vars.tables.npd_master_kemasan = <?= JsonEncode(GetClientVar("tables", "npd_master_kemasan")) ?>;
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
<form name="fnpd_master_kemasanview" id="fnpd_master_kemasanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_master_kemasan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_master_kemasan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
    <tr id="r_grup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_grup"><?= $Page->grup->caption() ?></span></td>
        <td data-name="grup" <?= $Page->grup->cellAttributes() ?>>
<span id="el_npd_master_kemasan_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenis->Visible) { // jenis ?>
    <tr id="r_jenis">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_jenis"><?= $Page->jenis->caption() ?></span></td>
        <td data-name="jenis" <?= $Page->jenis->cellAttributes() ?>>
<span id="el_npd_master_kemasan_jenis">
<span<?= $Page->jenis->viewAttributes() ?>>
<?= $Page->jenis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subjenis->Visible) { // subjenis ?>
    <tr id="r_subjenis">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_subjenis"><?= $Page->subjenis->caption() ?></span></td>
        <td data-name="subjenis" <?= $Page->subjenis->cellAttributes() ?>>
<span id="el_npd_master_kemasan_subjenis">
<span<?= $Page->subjenis->viewAttributes() ?>>
<?= $Page->subjenis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_master_kemasan_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
    <tr id="r_nour">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_nour"><?= $Page->nour->caption() ?></span></td>
        <td data-name="nour" <?= $Page->nour->cellAttributes() ?>>
<span id="el_npd_master_kemasan_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
    <tr id="r_updated_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_updated_user"><?= $Page->updated_user->caption() ?></span></td>
        <td data-name="updated_user" <?= $Page->updated_user->cellAttributes() ?>>
<span id="el_npd_master_kemasan_updated_user">
<span<?= $Page->updated_user->viewAttributes() ?>>
<?= $Page->updated_user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_kemasan_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_master_kemasan_updated_at">
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
