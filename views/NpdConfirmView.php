<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmview = currentForm = new ew.Form("fnpd_confirmview", "view");
    loadjs.done("fnpd_confirmview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirm) ew.vars.tables.npd_confirm = <?= JsonEncode(GetClientVar("tables", "npd_confirm")) ?>;
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
<form name="fnpd_confirmview" id="fnpd_confirmview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirm">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_confirm_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
    <tr id="r_tglkonfirmasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_tglkonfirmasi"><?= $Page->tglkonfirmasi->caption() ?></span></td>
        <td data-name="tglkonfirmasi" <?= $Page->tglkonfirmasi->cellAttributes() ?>>
<span id="el_npd_confirm_tglkonfirmasi">
<span<?= $Page->tglkonfirmasi->viewAttributes() ?>>
<?= $Page->tglkonfirmasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <tr id="r_idnpd_sample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></td>
        <td data-name="idnpd_sample" <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el_npd_confirm_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_npd_confirm_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
    <tr id="r_namapemesan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_namapemesan"><?= $Page->namapemesan->caption() ?></span></td>
        <td data-name="namapemesan" <?= $Page->namapemesan->cellAttributes() ?>>
<span id="el_npd_confirm_namapemesan">
<span<?= $Page->namapemesan->viewAttributes() ?>>
<?= $Page->namapemesan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamatpemesan->Visible) { // alamatpemesan ?>
    <tr id="r_alamatpemesan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_alamatpemesan"><?= $Page->alamatpemesan->caption() ?></span></td>
        <td data-name="alamatpemesan" <?= $Page->alamatpemesan->cellAttributes() ?>>
<span id="el_npd_confirm_alamatpemesan">
<span<?= $Page->alamatpemesan->viewAttributes() ?>>
<?= $Page->alamatpemesan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
    <tr id="r_personincharge">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_personincharge"><?= $Page->personincharge->caption() ?></span></td>
        <td data-name="personincharge" <?= $Page->personincharge->cellAttributes() ?>>
<span id="el_npd_confirm_personincharge">
<span<?= $Page->personincharge->viewAttributes() ?>>
<?= $Page->personincharge->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <tr id="r_jabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_jabatan"><?= $Page->jabatan->caption() ?></span></td>
        <td data-name="jabatan" <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_npd_confirm_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
    <tr id="r_notelp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirm_notelp"><?= $Page->notelp->caption() ?></span></td>
        <td data-name="notelp" <?= $Page->notelp->cellAttributes() ?>>
<span id="el_npd_confirm_notelp">
<span<?= $Page->notelp->viewAttributes() ?>>
<?= $Page->notelp->getViewValue() ?></span>
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
    // Startup script
    loadjs.ready("jquery",(function(){$("#r_namapemesan").before('<h5 class="form-group">Data Pemesan</h5>')}));
});
</script>
<?php } ?>
