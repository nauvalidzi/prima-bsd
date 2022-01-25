<?php

namespace PHPMaker2021\distributor;

// Page object
$PembayaranView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpembayaranview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpembayaranview = currentForm = new ew.Form("fpembayaranview", "view");
    loadjs.done("fpembayaranview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pembayaran) ew.vars.tables.pembayaran = <?= JsonEncode(GetClientVar("tables", "pembayaran")) ?>;
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
<form name="fpembayaranview" id="fpembayaranview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembayaran">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_pembayaran_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal" <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_pembayaran_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_pembayaran_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
    <tr id="r_idinvoice">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_idinvoice"><?= $Page->idinvoice->caption() ?></span></td>
        <td data-name="idinvoice" <?= $Page->idinvoice->cellAttributes() ?>>
<span id="el_pembayaran_idinvoice">
<span<?= $Page->idinvoice->viewAttributes() ?>>
<?= $Page->idinvoice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <tr id="r_totaltagihan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_totaltagihan"><?= $Page->totaltagihan->caption() ?></span></td>
        <td data-name="totaltagihan" <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el_pembayaran_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisatagihan->Visible) { // sisatagihan ?>
    <tr id="r_sisatagihan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_sisatagihan"><?= $Page->sisatagihan->caption() ?></span></td>
        <td data-name="sisatagihan" <?= $Page->sisatagihan->cellAttributes() ?>>
<span id="el_pembayaran_sisatagihan">
<span<?= $Page->sisatagihan->viewAttributes() ?>>
<?= $Page->sisatagihan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahbayar->Visible) { // jumlahbayar ?>
    <tr id="r_jumlahbayar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_jumlahbayar"><?= $Page->jumlahbayar->caption() ?></span></td>
        <td data-name="jumlahbayar" <?= $Page->jumlahbayar->cellAttributes() ?>>
<span id="el_pembayaran_jumlahbayar">
<span<?= $Page->jumlahbayar->viewAttributes() ?>>
<?= $Page->jumlahbayar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idtipepayment->Visible) { // idtipepayment ?>
    <tr id="r_idtipepayment">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_idtipepayment"><?= $Page->idtipepayment->caption() ?></span></td>
        <td data-name="idtipepayment" <?= $Page->idtipepayment->cellAttributes() ?>>
<span id="el_pembayaran_idtipepayment">
<span<?= $Page->idtipepayment->viewAttributes() ?>>
<?= $Page->idtipepayment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bukti->Visible) { // bukti ?>
    <tr id="r_bukti">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_bukti"><?= $Page->bukti->caption() ?></span></td>
        <td data-name="bukti" <?= $Page->bukti->cellAttributes() ?>>
<span id="el_pembayaran_bukti">
<span<?= $Page->bukti->viewAttributes() ?>>
<?= GetFileViewTag($Page->bukti, $Page->bukti->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembayaran_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_pembayaran_created_at">
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
