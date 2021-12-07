<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdTermsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_termsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_termsview = currentForm = new ew.Form("fnpd_termsview", "view");
    loadjs.done("fnpd_termsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_terms) ew.vars.tables.npd_terms = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>;
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
<form name="fnpd_termsview" id="fnpd_termsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_terms_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_npd_terms_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
    <tr id="r_sifat_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_sifat_order"><?= $Page->sifat_order->caption() ?></span></td>
        <td data-name="sifat_order" <?= $Page->sifat_order->cellAttributes() ?>>
<span id="el_npd_terms_sifat_order">
<span<?= $Page->sifat_order->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifat_order_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifat_order->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifat_order->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifat_order_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
    <tr id="r_ukuran_utama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_ukuran_utama"><?= $Page->ukuran_utama->caption() ?></span></td>
        <td data-name="ukuran_utama" <?= $Page->ukuran_utama->cellAttributes() ?>>
<span id="el_npd_terms_ukuran_utama">
<span<?= $Page->ukuran_utama->viewAttributes() ?>>
<?= $Page->ukuran_utama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
    <tr id="r_utama_harga_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_isi"><?= $Page->utama_harga_isi->caption() ?></span></td>
        <td data-name="utama_harga_isi" <?= $Page->utama_harga_isi->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_isi">
<span<?= $Page->utama_harga_isi->viewAttributes() ?>>
<?= $Page->utama_harga_isi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
    <tr id="r_utama_harga_isi_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_isi_order"><?= $Page->utama_harga_isi_order->caption() ?></span></td>
        <td data-name="utama_harga_isi_order" <?= $Page->utama_harga_isi_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_isi_order">
<span<?= $Page->utama_harga_isi_order->viewAttributes() ?>>
<?= $Page->utama_harga_isi_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
    <tr id="r_utama_harga_primer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_primer"><?= $Page->utama_harga_primer->caption() ?></span></td>
        <td data-name="utama_harga_primer" <?= $Page->utama_harga_primer->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_primer">
<span<?= $Page->utama_harga_primer->viewAttributes() ?>>
<?= $Page->utama_harga_primer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
    <tr id="r_utama_harga_primer_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_primer_order"><?= $Page->utama_harga_primer_order->caption() ?></span></td>
        <td data-name="utama_harga_primer_order" <?= $Page->utama_harga_primer_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_primer_order">
<span<?= $Page->utama_harga_primer_order->viewAttributes() ?>>
<?= $Page->utama_harga_primer_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
    <tr id="r_utama_harga_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_sekunder"><?= $Page->utama_harga_sekunder->caption() ?></span></td>
        <td data-name="utama_harga_sekunder" <?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_sekunder">
<span<?= $Page->utama_harga_sekunder->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
    <tr id="r_utama_harga_sekunder_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_sekunder_order"><?= $Page->utama_harga_sekunder_order->caption() ?></span></td>
        <td data-name="utama_harga_sekunder_order" <?= $Page->utama_harga_sekunder_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_sekunder_order">
<span<?= $Page->utama_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
    <tr id="r_utama_harga_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_label"><?= $Page->utama_harga_label->caption() ?></span></td>
        <td data-name="utama_harga_label" <?= $Page->utama_harga_label->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_label">
<span<?= $Page->utama_harga_label->viewAttributes() ?>>
<?= $Page->utama_harga_label->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
    <tr id="r_utama_harga_label_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_label_order"><?= $Page->utama_harga_label_order->caption() ?></span></td>
        <td data-name="utama_harga_label_order" <?= $Page->utama_harga_label_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_label_order">
<span<?= $Page->utama_harga_label_order->viewAttributes() ?>>
<?= $Page->utama_harga_label_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
    <tr id="r_utama_harga_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_total"><?= $Page->utama_harga_total->caption() ?></span></td>
        <td data-name="utama_harga_total" <?= $Page->utama_harga_total->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_total">
<span<?= $Page->utama_harga_total->viewAttributes() ?>>
<?= $Page->utama_harga_total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
    <tr id="r_utama_harga_total_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_utama_harga_total_order"><?= $Page->utama_harga_total_order->caption() ?></span></td>
        <td data-name="utama_harga_total_order" <?= $Page->utama_harga_total_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_total_order">
<span<?= $Page->utama_harga_total_order->viewAttributes() ?>>
<?= $Page->utama_harga_total_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
    <tr id="r_ukuran_lain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_ukuran_lain"><?= $Page->ukuran_lain->caption() ?></span></td>
        <td data-name="ukuran_lain" <?= $Page->ukuran_lain->cellAttributes() ?>>
<span id="el_npd_terms_ukuran_lain">
<span<?= $Page->ukuran_lain->viewAttributes() ?>>
<?= $Page->ukuran_lain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
    <tr id="r_lain_harga_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_isi"><?= $Page->lain_harga_isi->caption() ?></span></td>
        <td data-name="lain_harga_isi" <?= $Page->lain_harga_isi->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_isi">
<span<?= $Page->lain_harga_isi->viewAttributes() ?>>
<?= $Page->lain_harga_isi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
    <tr id="r_lain_harga_isi_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_isi_order"><?= $Page->lain_harga_isi_order->caption() ?></span></td>
        <td data-name="lain_harga_isi_order" <?= $Page->lain_harga_isi_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_isi_order">
<span<?= $Page->lain_harga_isi_order->viewAttributes() ?>>
<?= $Page->lain_harga_isi_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
    <tr id="r_lain_harga_primer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_primer"><?= $Page->lain_harga_primer->caption() ?></span></td>
        <td data-name="lain_harga_primer" <?= $Page->lain_harga_primer->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_primer">
<span<?= $Page->lain_harga_primer->viewAttributes() ?>>
<?= $Page->lain_harga_primer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
    <tr id="r_lain_harga_primer_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_primer_order"><?= $Page->lain_harga_primer_order->caption() ?></span></td>
        <td data-name="lain_harga_primer_order" <?= $Page->lain_harga_primer_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_primer_order">
<span<?= $Page->lain_harga_primer_order->viewAttributes() ?>>
<?= $Page->lain_harga_primer_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
    <tr id="r_lain_harga_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_sekunder"><?= $Page->lain_harga_sekunder->caption() ?></span></td>
        <td data-name="lain_harga_sekunder" <?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_sekunder">
<span<?= $Page->lain_harga_sekunder->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
    <tr id="r_lain_harga_sekunder_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_sekunder_order"><?= $Page->lain_harga_sekunder_order->caption() ?></span></td>
        <td data-name="lain_harga_sekunder_order" <?= $Page->lain_harga_sekunder_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_sekunder_order">
<span<?= $Page->lain_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
    <tr id="r_lain_harga_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_label"><?= $Page->lain_harga_label->caption() ?></span></td>
        <td data-name="lain_harga_label" <?= $Page->lain_harga_label->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_label">
<span<?= $Page->lain_harga_label->viewAttributes() ?>>
<?= $Page->lain_harga_label->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
    <tr id="r_lain_harga_label_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_label_order"><?= $Page->lain_harga_label_order->caption() ?></span></td>
        <td data-name="lain_harga_label_order" <?= $Page->lain_harga_label_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_label_order">
<span<?= $Page->lain_harga_label_order->viewAttributes() ?>>
<?= $Page->lain_harga_label_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
    <tr id="r_lain_harga_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_total"><?= $Page->lain_harga_total->caption() ?></span></td>
        <td data-name="lain_harga_total" <?= $Page->lain_harga_total->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_total">
<span<?= $Page->lain_harga_total->viewAttributes() ?>>
<?= $Page->lain_harga_total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
    <tr id="r_lain_harga_total_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_lain_harga_total_order"><?= $Page->lain_harga_total_order->caption() ?></span></td>
        <td data-name="lain_harga_total_order" <?= $Page->lain_harga_total_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_total_order">
<span<?= $Page->lain_harga_total_order->viewAttributes() ?>>
<?= $Page->lain_harga_total_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
    <tr id="r_isi_bahan_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isi_bahan_aktif"><?= $Page->isi_bahan_aktif->caption() ?></span></td>
        <td data-name="isi_bahan_aktif" <?= $Page->isi_bahan_aktif->cellAttributes() ?>>
<span id="el_npd_terms_isi_bahan_aktif">
<span<?= $Page->isi_bahan_aktif->viewAttributes() ?>>
<?= $Page->isi_bahan_aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
    <tr id="r_isi_bahan_lain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isi_bahan_lain"><?= $Page->isi_bahan_lain->caption() ?></span></td>
        <td data-name="isi_bahan_lain" <?= $Page->isi_bahan_lain->cellAttributes() ?>>
<span id="el_npd_terms_isi_bahan_lain">
<span<?= $Page->isi_bahan_lain->viewAttributes() ?>>
<?= $Page->isi_bahan_lain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
    <tr id="r_isi_parfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isi_parfum"><?= $Page->isi_parfum->caption() ?></span></td>
        <td data-name="isi_parfum" <?= $Page->isi_parfum->cellAttributes() ?>>
<span id="el_npd_terms_isi_parfum">
<span<?= $Page->isi_parfum->viewAttributes() ?>>
<?= $Page->isi_parfum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
    <tr id="r_isi_estetika">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_isi_estetika"><?= $Page->isi_estetika->caption() ?></span></td>
        <td data-name="isi_estetika" <?= $Page->isi_estetika->cellAttributes() ?>>
<span id="el_npd_terms_isi_estetika">
<span<?= $Page->isi_estetika->viewAttributes() ?>>
<?= $Page->isi_estetika->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
    <tr id="r_kemasan_wadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_kemasan_wadah"><?= $Page->kemasan_wadah->caption() ?></span></td>
        <td data-name="kemasan_wadah" <?= $Page->kemasan_wadah->cellAttributes() ?>>
<span id="el_npd_terms_kemasan_wadah">
<span<?= $Page->kemasan_wadah->viewAttributes() ?>>
<?= $Page->kemasan_wadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
    <tr id="r_kemasan_tutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_kemasan_tutup"><?= $Page->kemasan_tutup->caption() ?></span></td>
        <td data-name="kemasan_tutup" <?= $Page->kemasan_tutup->cellAttributes() ?>>
<span id="el_npd_terms_kemasan_tutup">
<span<?= $Page->kemasan_tutup->viewAttributes() ?>>
<?= $Page->kemasan_tutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
    <tr id="r_kemasan_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_kemasan_sekunder"><?= $Page->kemasan_sekunder->caption() ?></span></td>
        <td data-name="kemasan_sekunder" <?= $Page->kemasan_sekunder->cellAttributes() ?>>
<span id="el_npd_terms_kemasan_sekunder">
<span<?= $Page->kemasan_sekunder->viewAttributes() ?>>
<?= $Page->kemasan_sekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
    <tr id="r_label_desain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_label_desain"><?= $Page->label_desain->caption() ?></span></td>
        <td data-name="label_desain" <?= $Page->label_desain->cellAttributes() ?>>
<span id="el_npd_terms_label_desain">
<span<?= $Page->label_desain->viewAttributes() ?>>
<?= $Page->label_desain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
    <tr id="r_label_cetak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_label_cetak"><?= $Page->label_cetak->caption() ?></span></td>
        <td data-name="label_cetak" <?= $Page->label_cetak->cellAttributes() ?>>
<span id="el_npd_terms_label_cetak">
<span<?= $Page->label_cetak->viewAttributes() ?>>
<?= $Page->label_cetak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
    <tr id="r_label_lainlain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_label_lainlain"><?= $Page->label_lainlain->caption() ?></span></td>
        <td data-name="label_lainlain" <?= $Page->label_lainlain->cellAttributes() ?>>
<span id="el_npd_terms_label_lainlain">
<span<?= $Page->label_lainlain->viewAttributes() ?>>
<?= $Page->label_lainlain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
    <tr id="r_delivery_pickup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_delivery_pickup"><?= $Page->delivery_pickup->caption() ?></span></td>
        <td data-name="delivery_pickup" <?= $Page->delivery_pickup->cellAttributes() ?>>
<span id="el_npd_terms_delivery_pickup">
<span<?= $Page->delivery_pickup->viewAttributes() ?>>
<?= $Page->delivery_pickup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
    <tr id="r_delivery_singlepoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_delivery_singlepoint"><?= $Page->delivery_singlepoint->caption() ?></span></td>
        <td data-name="delivery_singlepoint" <?= $Page->delivery_singlepoint->cellAttributes() ?>>
<span id="el_npd_terms_delivery_singlepoint">
<span<?= $Page->delivery_singlepoint->viewAttributes() ?>>
<?= $Page->delivery_singlepoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
    <tr id="r_delivery_multipoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_delivery_multipoint"><?= $Page->delivery_multipoint->caption() ?></span></td>
        <td data-name="delivery_multipoint" <?= $Page->delivery_multipoint->cellAttributes() ?>>
<span id="el_npd_terms_delivery_multipoint">
<span<?= $Page->delivery_multipoint->viewAttributes() ?>>
<?= $Page->delivery_multipoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
    <tr id="r_delivery_jumlahpoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_delivery_jumlahpoint"><?= $Page->delivery_jumlahpoint->caption() ?></span></td>
        <td data-name="delivery_jumlahpoint" <?= $Page->delivery_jumlahpoint->cellAttributes() ?>>
<span id="el_npd_terms_delivery_jumlahpoint">
<span<?= $Page->delivery_jumlahpoint->viewAttributes() ?>>
<?= $Page->delivery_jumlahpoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
    <tr id="r_delivery_termslain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_delivery_termslain"><?= $Page->delivery_termslain->caption() ?></span></td>
        <td data-name="delivery_termslain" <?= $Page->delivery_termslain->cellAttributes() ?>>
<span id="el_npd_terms_delivery_termslain">
<span<?= $Page->delivery_termslain->viewAttributes() ?>>
<?= $Page->delivery_termslain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan_khusus->Visible) { // catatan_khusus ?>
    <tr id="r_catatan_khusus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_catatan_khusus"><?= $Page->catatan_khusus->caption() ?></span></td>
        <td data-name="catatan_khusus" <?= $Page->catatan_khusus->cellAttributes() ?>>
<span id="el_npd_terms_catatan_khusus">
<span<?= $Page->catatan_khusus->viewAttributes() ?>>
<?= $Page->catatan_khusus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <tr id="r_dibuatdi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_dibuatdi"><?= $Page->dibuatdi->caption() ?></span></td>
        <td data-name="dibuatdi" <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el_npd_terms_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_terms_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_terms_created_at">
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
