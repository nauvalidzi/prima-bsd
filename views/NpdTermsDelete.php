<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdTermsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_termsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_termsdelete = currentForm = new ew.Form("fnpd_termsdelete", "delete");
    loadjs.done("fnpd_termsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_terms) ew.vars.tables.npd_terms = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_termsdelete" id="fnpd_termsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_terms_id" class="npd_terms_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_terms_idnpd" class="npd_terms_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_terms_status" class="npd_terms_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><span id="elh_npd_terms_tglsubmit" class="npd_terms_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
        <th class="<?= $Page->sifat_order->headerCellClass() ?>"><span id="elh_npd_terms_sifat_order" class="npd_terms_sifat_order"><?= $Page->sifat_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
        <th class="<?= $Page->ukuran_utama->headerCellClass() ?>"><span id="elh_npd_terms_ukuran_utama" class="npd_terms_ukuran_utama"><?= $Page->ukuran_utama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <th class="<?= $Page->utama_harga_isi->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_isi" class="npd_terms_utama_harga_isi"><?= $Page->utama_harga_isi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <th class="<?= $Page->utama_harga_isi_order->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_isi_order" class="npd_terms_utama_harga_isi_order"><?= $Page->utama_harga_isi_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <th class="<?= $Page->utama_harga_primer->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_primer" class="npd_terms_utama_harga_primer"><?= $Page->utama_harga_primer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <th class="<?= $Page->utama_harga_primer_order->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_primer_order" class="npd_terms_utama_harga_primer_order"><?= $Page->utama_harga_primer_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <th class="<?= $Page->utama_harga_sekunder->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_sekunder" class="npd_terms_utama_harga_sekunder"><?= $Page->utama_harga_sekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <th class="<?= $Page->utama_harga_sekunder_order->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_sekunder_order" class="npd_terms_utama_harga_sekunder_order"><?= $Page->utama_harga_sekunder_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
        <th class="<?= $Page->utama_harga_label->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_label" class="npd_terms_utama_harga_label"><?= $Page->utama_harga_label->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <th class="<?= $Page->utama_harga_label_order->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_label_order" class="npd_terms_utama_harga_label_order"><?= $Page->utama_harga_label_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
        <th class="<?= $Page->utama_harga_total->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_total" class="npd_terms_utama_harga_total"><?= $Page->utama_harga_total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <th class="<?= $Page->utama_harga_total_order->headerCellClass() ?>"><span id="elh_npd_terms_utama_harga_total_order" class="npd_terms_utama_harga_total_order"><?= $Page->utama_harga_total_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
        <th class="<?= $Page->ukuran_lain->headerCellClass() ?>"><span id="elh_npd_terms_ukuran_lain" class="npd_terms_ukuran_lain"><?= $Page->ukuran_lain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <th class="<?= $Page->lain_harga_isi->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_isi" class="npd_terms_lain_harga_isi"><?= $Page->lain_harga_isi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <th class="<?= $Page->lain_harga_isi_order->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_isi_order" class="npd_terms_lain_harga_isi_order"><?= $Page->lain_harga_isi_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <th class="<?= $Page->lain_harga_primer->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_primer" class="npd_terms_lain_harga_primer"><?= $Page->lain_harga_primer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <th class="<?= $Page->lain_harga_primer_order->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_primer_order" class="npd_terms_lain_harga_primer_order"><?= $Page->lain_harga_primer_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <th class="<?= $Page->lain_harga_sekunder->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_sekunder" class="npd_terms_lain_harga_sekunder"><?= $Page->lain_harga_sekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <th class="<?= $Page->lain_harga_sekunder_order->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_sekunder_order" class="npd_terms_lain_harga_sekunder_order"><?= $Page->lain_harga_sekunder_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
        <th class="<?= $Page->lain_harga_label->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_label" class="npd_terms_lain_harga_label"><?= $Page->lain_harga_label->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <th class="<?= $Page->lain_harga_label_order->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_label_order" class="npd_terms_lain_harga_label_order"><?= $Page->lain_harga_label_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
        <th class="<?= $Page->lain_harga_total->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_total" class="npd_terms_lain_harga_total"><?= $Page->lain_harga_total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <th class="<?= $Page->lain_harga_total_order->headerCellClass() ?>"><span id="elh_npd_terms_lain_harga_total_order" class="npd_terms_lain_harga_total_order"><?= $Page->lain_harga_total_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <th class="<?= $Page->isi_bahan_aktif->headerCellClass() ?>"><span id="elh_npd_terms_isi_bahan_aktif" class="npd_terms_isi_bahan_aktif"><?= $Page->isi_bahan_aktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <th class="<?= $Page->isi_bahan_lain->headerCellClass() ?>"><span id="elh_npd_terms_isi_bahan_lain" class="npd_terms_isi_bahan_lain"><?= $Page->isi_bahan_lain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
        <th class="<?= $Page->isi_parfum->headerCellClass() ?>"><span id="elh_npd_terms_isi_parfum" class="npd_terms_isi_parfum"><?= $Page->isi_parfum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
        <th class="<?= $Page->isi_estetika->headerCellClass() ?>"><span id="elh_npd_terms_isi_estetika" class="npd_terms_isi_estetika"><?= $Page->isi_estetika->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <th class="<?= $Page->kemasan_wadah->headerCellClass() ?>"><span id="elh_npd_terms_kemasan_wadah" class="npd_terms_kemasan_wadah"><?= $Page->kemasan_wadah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <th class="<?= $Page->kemasan_tutup->headerCellClass() ?>"><span id="elh_npd_terms_kemasan_tutup" class="npd_terms_kemasan_tutup"><?= $Page->kemasan_tutup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <th class="<?= $Page->kemasan_sekunder->headerCellClass() ?>"><span id="elh_npd_terms_kemasan_sekunder" class="npd_terms_kemasan_sekunder"><?= $Page->kemasan_sekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
        <th class="<?= $Page->label_desain->headerCellClass() ?>"><span id="elh_npd_terms_label_desain" class="npd_terms_label_desain"><?= $Page->label_desain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
        <th class="<?= $Page->label_cetak->headerCellClass() ?>"><span id="elh_npd_terms_label_cetak" class="npd_terms_label_cetak"><?= $Page->label_cetak->caption() ?></span></th>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
        <th class="<?= $Page->label_lainlain->headerCellClass() ?>"><span id="elh_npd_terms_label_lainlain" class="npd_terms_label_lainlain"><?= $Page->label_lainlain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
        <th class="<?= $Page->delivery_pickup->headerCellClass() ?>"><span id="elh_npd_terms_delivery_pickup" class="npd_terms_delivery_pickup"><?= $Page->delivery_pickup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <th class="<?= $Page->delivery_singlepoint->headerCellClass() ?>"><span id="elh_npd_terms_delivery_singlepoint" class="npd_terms_delivery_singlepoint"><?= $Page->delivery_singlepoint->caption() ?></span></th>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <th class="<?= $Page->delivery_multipoint->headerCellClass() ?>"><span id="elh_npd_terms_delivery_multipoint" class="npd_terms_delivery_multipoint"><?= $Page->delivery_multipoint->caption() ?></span></th>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <th class="<?= $Page->delivery_jumlahpoint->headerCellClass() ?>"><span id="elh_npd_terms_delivery_jumlahpoint" class="npd_terms_delivery_jumlahpoint"><?= $Page->delivery_jumlahpoint->caption() ?></span></th>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
        <th class="<?= $Page->delivery_termslain->headerCellClass() ?>"><span id="elh_npd_terms_delivery_termslain" class="npd_terms_delivery_termslain"><?= $Page->delivery_termslain->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <th class="<?= $Page->dibuatdi->headerCellClass() ?>"><span id="elh_npd_terms_dibuatdi" class="npd_terms_dibuatdi"><?= $Page->dibuatdi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_npd_terms_created_at" class="npd_terms_created_at"><?= $Page->created_at->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_id" class="npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_idnpd" class="npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_status" class="npd_terms_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_tglsubmit" class="npd_terms_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
        <td <?= $Page->sifat_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_sifat_order" class="npd_terms_sifat_order">
<span<?= $Page->sifat_order->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifat_order_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifat_order->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifat_order->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifat_order_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
        <td <?= $Page->ukuran_utama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuran_utama" class="npd_terms_ukuran_utama">
<span<?= $Page->ukuran_utama->viewAttributes() ?>>
<?= $Page->ukuran_utama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <td <?= $Page->utama_harga_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_isi" class="npd_terms_utama_harga_isi">
<span<?= $Page->utama_harga_isi->viewAttributes() ?>>
<?= $Page->utama_harga_isi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <td <?= $Page->utama_harga_isi_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_isi_order" class="npd_terms_utama_harga_isi_order">
<span<?= $Page->utama_harga_isi_order->viewAttributes() ?>>
<?= $Page->utama_harga_isi_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <td <?= $Page->utama_harga_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_primer" class="npd_terms_utama_harga_primer">
<span<?= $Page->utama_harga_primer->viewAttributes() ?>>
<?= $Page->utama_harga_primer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <td <?= $Page->utama_harga_primer_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_primer_order" class="npd_terms_utama_harga_primer_order">
<span<?= $Page->utama_harga_primer_order->viewAttributes() ?>>
<?= $Page->utama_harga_primer_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <td <?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_sekunder" class="npd_terms_utama_harga_sekunder">
<span<?= $Page->utama_harga_sekunder->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <td <?= $Page->utama_harga_sekunder_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_sekunder_order" class="npd_terms_utama_harga_sekunder_order">
<span<?= $Page->utama_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
        <td <?= $Page->utama_harga_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_label" class="npd_terms_utama_harga_label">
<span<?= $Page->utama_harga_label->viewAttributes() ?>>
<?= $Page->utama_harga_label->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <td <?= $Page->utama_harga_label_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_label_order" class="npd_terms_utama_harga_label_order">
<span<?= $Page->utama_harga_label_order->viewAttributes() ?>>
<?= $Page->utama_harga_label_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
        <td <?= $Page->utama_harga_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_total" class="npd_terms_utama_harga_total">
<span<?= $Page->utama_harga_total->viewAttributes() ?>>
<?= $Page->utama_harga_total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <td <?= $Page->utama_harga_total_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_total_order" class="npd_terms_utama_harga_total_order">
<span<?= $Page->utama_harga_total_order->viewAttributes() ?>>
<?= $Page->utama_harga_total_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
        <td <?= $Page->ukuran_lain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuran_lain" class="npd_terms_ukuran_lain">
<span<?= $Page->ukuran_lain->viewAttributes() ?>>
<?= $Page->ukuran_lain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <td <?= $Page->lain_harga_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_isi" class="npd_terms_lain_harga_isi">
<span<?= $Page->lain_harga_isi->viewAttributes() ?>>
<?= $Page->lain_harga_isi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <td <?= $Page->lain_harga_isi_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_isi_order" class="npd_terms_lain_harga_isi_order">
<span<?= $Page->lain_harga_isi_order->viewAttributes() ?>>
<?= $Page->lain_harga_isi_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <td <?= $Page->lain_harga_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_primer" class="npd_terms_lain_harga_primer">
<span<?= $Page->lain_harga_primer->viewAttributes() ?>>
<?= $Page->lain_harga_primer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <td <?= $Page->lain_harga_primer_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_primer_order" class="npd_terms_lain_harga_primer_order">
<span<?= $Page->lain_harga_primer_order->viewAttributes() ?>>
<?= $Page->lain_harga_primer_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <td <?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_sekunder" class="npd_terms_lain_harga_sekunder">
<span<?= $Page->lain_harga_sekunder->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <td <?= $Page->lain_harga_sekunder_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_sekunder_order" class="npd_terms_lain_harga_sekunder_order">
<span<?= $Page->lain_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
        <td <?= $Page->lain_harga_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_label" class="npd_terms_lain_harga_label">
<span<?= $Page->lain_harga_label->viewAttributes() ?>>
<?= $Page->lain_harga_label->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <td <?= $Page->lain_harga_label_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_label_order" class="npd_terms_lain_harga_label_order">
<span<?= $Page->lain_harga_label_order->viewAttributes() ?>>
<?= $Page->lain_harga_label_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
        <td <?= $Page->lain_harga_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_total" class="npd_terms_lain_harga_total">
<span<?= $Page->lain_harga_total->viewAttributes() ?>>
<?= $Page->lain_harga_total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <td <?= $Page->lain_harga_total_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_total_order" class="npd_terms_lain_harga_total_order">
<span<?= $Page->lain_harga_total_order->viewAttributes() ?>>
<?= $Page->lain_harga_total_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <td <?= $Page->isi_bahan_aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_bahan_aktif" class="npd_terms_isi_bahan_aktif">
<span<?= $Page->isi_bahan_aktif->viewAttributes() ?>>
<?= $Page->isi_bahan_aktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <td <?= $Page->isi_bahan_lain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_bahan_lain" class="npd_terms_isi_bahan_lain">
<span<?= $Page->isi_bahan_lain->viewAttributes() ?>>
<?= $Page->isi_bahan_lain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
        <td <?= $Page->isi_parfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_parfum" class="npd_terms_isi_parfum">
<span<?= $Page->isi_parfum->viewAttributes() ?>>
<?= $Page->isi_parfum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
        <td <?= $Page->isi_estetika->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_estetika" class="npd_terms_isi_estetika">
<span<?= $Page->isi_estetika->viewAttributes() ?>>
<?= $Page->isi_estetika->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <td <?= $Page->kemasan_wadah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasan_wadah" class="npd_terms_kemasan_wadah">
<span<?= $Page->kemasan_wadah->viewAttributes() ?>>
<?= $Page->kemasan_wadah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <td <?= $Page->kemasan_tutup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasan_tutup" class="npd_terms_kemasan_tutup">
<span<?= $Page->kemasan_tutup->viewAttributes() ?>>
<?= $Page->kemasan_tutup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <td <?= $Page->kemasan_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasan_sekunder" class="npd_terms_kemasan_sekunder">
<span<?= $Page->kemasan_sekunder->viewAttributes() ?>>
<?= $Page->kemasan_sekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
        <td <?= $Page->label_desain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_label_desain" class="npd_terms_label_desain">
<span<?= $Page->label_desain->viewAttributes() ?>>
<?= $Page->label_desain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
        <td <?= $Page->label_cetak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_label_cetak" class="npd_terms_label_cetak">
<span<?= $Page->label_cetak->viewAttributes() ?>>
<?= $Page->label_cetak->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
        <td <?= $Page->label_lainlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_label_lainlain" class="npd_terms_label_lainlain">
<span<?= $Page->label_lainlain->viewAttributes() ?>>
<?= $Page->label_lainlain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
        <td <?= $Page->delivery_pickup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_pickup" class="npd_terms_delivery_pickup">
<span<?= $Page->delivery_pickup->viewAttributes() ?>>
<?= $Page->delivery_pickup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <td <?= $Page->delivery_singlepoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_singlepoint" class="npd_terms_delivery_singlepoint">
<span<?= $Page->delivery_singlepoint->viewAttributes() ?>>
<?= $Page->delivery_singlepoint->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <td <?= $Page->delivery_multipoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_multipoint" class="npd_terms_delivery_multipoint">
<span<?= $Page->delivery_multipoint->viewAttributes() ?>>
<?= $Page->delivery_multipoint->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <td <?= $Page->delivery_jumlahpoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_jumlahpoint" class="npd_terms_delivery_jumlahpoint">
<span<?= $Page->delivery_jumlahpoint->viewAttributes() ?>>
<?= $Page->delivery_jumlahpoint->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
        <td <?= $Page->delivery_termslain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_termslain" class="npd_terms_delivery_termslain">
<span<?= $Page->delivery_termslain->viewAttributes() ?>>
<?= $Page->delivery_termslain->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <td <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_dibuatdi" class="npd_terms_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_created_at" class="npd_terms_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
