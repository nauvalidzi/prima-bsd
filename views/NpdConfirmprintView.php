<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmprintView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmprintview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmprintview = currentForm = new ew.Form("fnpd_confirmprintview", "view");
    loadjs.done("fnpd_confirmprintview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmprint) ew.vars.tables.npd_confirmprint = <?= JsonEncode(GetClientVar("tables", "npd_confirmprint")) ?>;
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
<form name="fnpd_confirmprintview" id="fnpd_confirmprintview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmprint">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_confirmprint_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
    <tr id="r_brand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_brand"><?= $Page->brand->caption() ?></span></td>
        <td data-name="brand" <?= $Page->brand->cellAttributes() ?>>
<span id="el_npd_confirmprint_brand">
<span<?= $Page->brand->viewAttributes() ?>>
<?= $Page->brand->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
    <tr id="r_tglkirim">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_tglkirim"><?= $Page->tglkirim->caption() ?></span></td>
        <td data-name="tglkirim" <?= $Page->tglkirim->cellAttributes() ?>>
<span id="el_npd_confirmprint_tglkirim">
<span<?= $Page->tglkirim->viewAttributes() ?>>
<?= $Page->tglkirim->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
    <tr id="r_tgldisetujui">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_tgldisetujui"><?= $Page->tgldisetujui->caption() ?></span></td>
        <td data-name="tgldisetujui" <?= $Page->tgldisetujui->cellAttributes() ?>>
<span id="el_npd_confirmprint_tgldisetujui">
<span<?= $Page->tgldisetujui->viewAttributes() ?>>
<?= $Page->tgldisetujui->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainprimer->Visible) { // desainprimer ?>
    <tr id="r_desainprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_desainprimer"><?= $Page->desainprimer->caption() ?></span></td>
        <td data-name="desainprimer" <?= $Page->desainprimer->cellAttributes() ?>>
<span id="el_npd_confirmprint_desainprimer">
<span<?= $Page->desainprimer->viewAttributes() ?>>
<?= $Page->desainprimer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->materialprimer->Visible) { // materialprimer ?>
    <tr id="r_materialprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_materialprimer"><?= $Page->materialprimer->caption() ?></span></td>
        <td data-name="materialprimer" <?= $Page->materialprimer->cellAttributes() ?>>
<span id="el_npd_confirmprint_materialprimer">
<span<?= $Page->materialprimer->viewAttributes() ?>>
<?= $Page->materialprimer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
    <tr id="r_aplikasiprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_aplikasiprimer"><?= $Page->aplikasiprimer->caption() ?></span></td>
        <td data-name="aplikasiprimer" <?= $Page->aplikasiprimer->cellAttributes() ?>>
<span id="el_npd_confirmprint_aplikasiprimer">
<span<?= $Page->aplikasiprimer->viewAttributes() ?>>
<?= $Page->aplikasiprimer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
    <tr id="r_jumlahcetakprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_jumlahcetakprimer"><?= $Page->jumlahcetakprimer->caption() ?></span></td>
        <td data-name="jumlahcetakprimer" <?= $Page->jumlahcetakprimer->cellAttributes() ?>>
<span id="el_npd_confirmprint_jumlahcetakprimer">
<span<?= $Page->jumlahcetakprimer->viewAttributes() ?>>
<?= $Page->jumlahcetakprimer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <tr id="r_desainsekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_desainsekunder"><?= $Page->desainsekunder->caption() ?></span></td>
        <td data-name="desainsekunder" <?= $Page->desainsekunder->cellAttributes() ?>>
<span id="el_npd_confirmprint_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
    <tr id="r_materialinnerbox">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_materialinnerbox"><?= $Page->materialinnerbox->caption() ?></span></td>
        <td data-name="materialinnerbox" <?= $Page->materialinnerbox->cellAttributes() ?>>
<span id="el_npd_confirmprint_materialinnerbox">
<span<?= $Page->materialinnerbox->viewAttributes() ?>>
<?= $Page->materialinnerbox->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
    <tr id="r_aplikasiinnerbox">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_aplikasiinnerbox"><?= $Page->aplikasiinnerbox->caption() ?></span></td>
        <td data-name="aplikasiinnerbox" <?= $Page->aplikasiinnerbox->cellAttributes() ?>>
<span id="el_npd_confirmprint_aplikasiinnerbox">
<span<?= $Page->aplikasiinnerbox->viewAttributes() ?>>
<?= $Page->aplikasiinnerbox->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
    <tr id="r_jumlahcetak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_jumlahcetak"><?= $Page->jumlahcetak->caption() ?></span></td>
        <td data-name="jumlahcetak" <?= $Page->jumlahcetak->cellAttributes() ?>>
<span id="el_npd_confirmprint_jumlahcetak">
<span<?= $Page->jumlahcetak->viewAttributes() ?>>
<?= $Page->jumlahcetak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_checked_by"><?= $Page->checked_by->caption() ?></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<span id="el_npd_confirmprint_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_approved_by"><?= $Page->approved_by->caption() ?></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<span id="el_npd_confirmprint_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_confirmprint_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_confirmprint_updated_at">
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
