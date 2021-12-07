<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdTermsPreview = &$Page;
?>
<script>
if (!ew.vars.tables.npd_terms) ew.vars.tables.npd_terms = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid npd_terms"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
    <?php if ($Page->SortUrl($Page->id) == "") { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><?= $Page->id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <?php if ($Page->SortUrl($Page->idnpd) == "") { ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><?= $Page->idnpd->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idnpd->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idnpd->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idnpd->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idnpd->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idnpd->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <?php if ($Page->SortUrl($Page->status) == "") { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><?= $Page->status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->status->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->status->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->status->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->status->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->status->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <?php if ($Page->SortUrl($Page->tglsubmit) == "") { ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><?= $Page->tglsubmit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglsubmit->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglsubmit->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglsubmit->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglsubmit->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglsubmit->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
    <?php if ($Page->SortUrl($Page->sifat_order) == "") { ?>
        <th class="<?= $Page->sifat_order->headerCellClass() ?>"><?= $Page->sifat_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sifat_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sifat_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sifat_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sifat_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sifat_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sifat_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
    <?php if ($Page->SortUrl($Page->ukuran_utama) == "") { ?>
        <th class="<?= $Page->ukuran_utama->headerCellClass() ?>"><?= $Page->ukuran_utama->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ukuran_utama->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ukuran_utama->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ukuran_utama->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ukuran_utama->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ukuran_utama->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ukuran_utama->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
    <?php if ($Page->SortUrl($Page->utama_harga_isi) == "") { ?>
        <th class="<?= $Page->utama_harga_isi->headerCellClass() ?>"><?= $Page->utama_harga_isi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_isi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_isi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_isi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_isi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_isi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_isi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
    <?php if ($Page->SortUrl($Page->utama_harga_isi_order) == "") { ?>
        <th class="<?= $Page->utama_harga_isi_order->headerCellClass() ?>"><?= $Page->utama_harga_isi_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_isi_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_isi_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_isi_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_isi_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_isi_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_isi_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
    <?php if ($Page->SortUrl($Page->utama_harga_primer) == "") { ?>
        <th class="<?= $Page->utama_harga_primer->headerCellClass() ?>"><?= $Page->utama_harga_primer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_primer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_primer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_primer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_primer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_primer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_primer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
    <?php if ($Page->SortUrl($Page->utama_harga_primer_order) == "") { ?>
        <th class="<?= $Page->utama_harga_primer_order->headerCellClass() ?>"><?= $Page->utama_harga_primer_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_primer_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_primer_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_primer_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_primer_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_primer_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_primer_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
    <?php if ($Page->SortUrl($Page->utama_harga_sekunder) == "") { ?>
        <th class="<?= $Page->utama_harga_sekunder->headerCellClass() ?>"><?= $Page->utama_harga_sekunder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_sekunder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_sekunder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_sekunder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_sekunder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_sekunder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_sekunder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
    <?php if ($Page->SortUrl($Page->utama_harga_sekunder_order) == "") { ?>
        <th class="<?= $Page->utama_harga_sekunder_order->headerCellClass() ?>"><?= $Page->utama_harga_sekunder_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_sekunder_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_sekunder_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_sekunder_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_sekunder_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_sekunder_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_sekunder_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
    <?php if ($Page->SortUrl($Page->utama_harga_label) == "") { ?>
        <th class="<?= $Page->utama_harga_label->headerCellClass() ?>"><?= $Page->utama_harga_label->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_label->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_label->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_label->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_label->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_label->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_label->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
    <?php if ($Page->SortUrl($Page->utama_harga_label_order) == "") { ?>
        <th class="<?= $Page->utama_harga_label_order->headerCellClass() ?>"><?= $Page->utama_harga_label_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_label_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_label_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_label_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_label_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_label_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_label_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
    <?php if ($Page->SortUrl($Page->utama_harga_total) == "") { ?>
        <th class="<?= $Page->utama_harga_total->headerCellClass() ?>"><?= $Page->utama_harga_total->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_total->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_total->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_total->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_total->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_total->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_total->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
    <?php if ($Page->SortUrl($Page->utama_harga_total_order) == "") { ?>
        <th class="<?= $Page->utama_harga_total_order->headerCellClass() ?>"><?= $Page->utama_harga_total_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->utama_harga_total_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->utama_harga_total_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->utama_harga_total_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->utama_harga_total_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->utama_harga_total_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->utama_harga_total_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
    <?php if ($Page->SortUrl($Page->ukuran_lain) == "") { ?>
        <th class="<?= $Page->ukuran_lain->headerCellClass() ?>"><?= $Page->ukuran_lain->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ukuran_lain->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ukuran_lain->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ukuran_lain->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ukuran_lain->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ukuran_lain->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ukuran_lain->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
    <?php if ($Page->SortUrl($Page->lain_harga_isi) == "") { ?>
        <th class="<?= $Page->lain_harga_isi->headerCellClass() ?>"><?= $Page->lain_harga_isi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_isi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_isi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_isi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_isi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_isi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_isi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
    <?php if ($Page->SortUrl($Page->lain_harga_isi_order) == "") { ?>
        <th class="<?= $Page->lain_harga_isi_order->headerCellClass() ?>"><?= $Page->lain_harga_isi_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_isi_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_isi_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_isi_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_isi_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_isi_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_isi_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
    <?php if ($Page->SortUrl($Page->lain_harga_primer) == "") { ?>
        <th class="<?= $Page->lain_harga_primer->headerCellClass() ?>"><?= $Page->lain_harga_primer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_primer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_primer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_primer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_primer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_primer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_primer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
    <?php if ($Page->SortUrl($Page->lain_harga_primer_order) == "") { ?>
        <th class="<?= $Page->lain_harga_primer_order->headerCellClass() ?>"><?= $Page->lain_harga_primer_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_primer_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_primer_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_primer_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_primer_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_primer_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_primer_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
    <?php if ($Page->SortUrl($Page->lain_harga_sekunder) == "") { ?>
        <th class="<?= $Page->lain_harga_sekunder->headerCellClass() ?>"><?= $Page->lain_harga_sekunder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_sekunder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_sekunder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_sekunder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_sekunder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_sekunder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_sekunder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
    <?php if ($Page->SortUrl($Page->lain_harga_sekunder_order) == "") { ?>
        <th class="<?= $Page->lain_harga_sekunder_order->headerCellClass() ?>"><?= $Page->lain_harga_sekunder_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_sekunder_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_sekunder_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_sekunder_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_sekunder_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_sekunder_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_sekunder_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
    <?php if ($Page->SortUrl($Page->lain_harga_label) == "") { ?>
        <th class="<?= $Page->lain_harga_label->headerCellClass() ?>"><?= $Page->lain_harga_label->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_label->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_label->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_label->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_label->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_label->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_label->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
    <?php if ($Page->SortUrl($Page->lain_harga_label_order) == "") { ?>
        <th class="<?= $Page->lain_harga_label_order->headerCellClass() ?>"><?= $Page->lain_harga_label_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_label_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_label_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_label_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_label_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_label_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_label_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
    <?php if ($Page->SortUrl($Page->lain_harga_total) == "") { ?>
        <th class="<?= $Page->lain_harga_total->headerCellClass() ?>"><?= $Page->lain_harga_total->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_total->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_total->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_total->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_total->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_total->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_total->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
    <?php if ($Page->SortUrl($Page->lain_harga_total_order) == "") { ?>
        <th class="<?= $Page->lain_harga_total_order->headerCellClass() ?>"><?= $Page->lain_harga_total_order->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lain_harga_total_order->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->lain_harga_total_order->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lain_harga_total_order->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->lain_harga_total_order->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->lain_harga_total_order->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->lain_harga_total_order->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
    <?php if ($Page->SortUrl($Page->isi_bahan_aktif) == "") { ?>
        <th class="<?= $Page->isi_bahan_aktif->headerCellClass() ?>"><?= $Page->isi_bahan_aktif->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->isi_bahan_aktif->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->isi_bahan_aktif->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->isi_bahan_aktif->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->isi_bahan_aktif->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->isi_bahan_aktif->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->isi_bahan_aktif->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
    <?php if ($Page->SortUrl($Page->isi_bahan_lain) == "") { ?>
        <th class="<?= $Page->isi_bahan_lain->headerCellClass() ?>"><?= $Page->isi_bahan_lain->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->isi_bahan_lain->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->isi_bahan_lain->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->isi_bahan_lain->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->isi_bahan_lain->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->isi_bahan_lain->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->isi_bahan_lain->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
    <?php if ($Page->SortUrl($Page->isi_parfum) == "") { ?>
        <th class="<?= $Page->isi_parfum->headerCellClass() ?>"><?= $Page->isi_parfum->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->isi_parfum->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->isi_parfum->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->isi_parfum->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->isi_parfum->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->isi_parfum->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->isi_parfum->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
    <?php if ($Page->SortUrl($Page->isi_estetika) == "") { ?>
        <th class="<?= $Page->isi_estetika->headerCellClass() ?>"><?= $Page->isi_estetika->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->isi_estetika->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->isi_estetika->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->isi_estetika->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->isi_estetika->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->isi_estetika->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->isi_estetika->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
    <?php if ($Page->SortUrl($Page->kemasan_wadah) == "") { ?>
        <th class="<?= $Page->kemasan_wadah->headerCellClass() ?>"><?= $Page->kemasan_wadah->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kemasan_wadah->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kemasan_wadah->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kemasan_wadah->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kemasan_wadah->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kemasan_wadah->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kemasan_wadah->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
    <?php if ($Page->SortUrl($Page->kemasan_tutup) == "") { ?>
        <th class="<?= $Page->kemasan_tutup->headerCellClass() ?>"><?= $Page->kemasan_tutup->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kemasan_tutup->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kemasan_tutup->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kemasan_tutup->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kemasan_tutup->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kemasan_tutup->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kemasan_tutup->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
    <?php if ($Page->SortUrl($Page->kemasan_sekunder) == "") { ?>
        <th class="<?= $Page->kemasan_sekunder->headerCellClass() ?>"><?= $Page->kemasan_sekunder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kemasan_sekunder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kemasan_sekunder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kemasan_sekunder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kemasan_sekunder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kemasan_sekunder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kemasan_sekunder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
    <?php if ($Page->SortUrl($Page->label_desain) == "") { ?>
        <th class="<?= $Page->label_desain->headerCellClass() ?>"><?= $Page->label_desain->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->label_desain->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->label_desain->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->label_desain->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->label_desain->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->label_desain->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->label_desain->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
    <?php if ($Page->SortUrl($Page->label_cetak) == "") { ?>
        <th class="<?= $Page->label_cetak->headerCellClass() ?>"><?= $Page->label_cetak->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->label_cetak->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->label_cetak->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->label_cetak->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->label_cetak->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->label_cetak->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->label_cetak->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
    <?php if ($Page->SortUrl($Page->label_lainlain) == "") { ?>
        <th class="<?= $Page->label_lainlain->headerCellClass() ?>"><?= $Page->label_lainlain->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->label_lainlain->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->label_lainlain->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->label_lainlain->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->label_lainlain->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->label_lainlain->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->label_lainlain->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
    <?php if ($Page->SortUrl($Page->delivery_pickup) == "") { ?>
        <th class="<?= $Page->delivery_pickup->headerCellClass() ?>"><?= $Page->delivery_pickup->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->delivery_pickup->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->delivery_pickup->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->delivery_pickup->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->delivery_pickup->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->delivery_pickup->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->delivery_pickup->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
    <?php if ($Page->SortUrl($Page->delivery_singlepoint) == "") { ?>
        <th class="<?= $Page->delivery_singlepoint->headerCellClass() ?>"><?= $Page->delivery_singlepoint->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->delivery_singlepoint->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->delivery_singlepoint->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->delivery_singlepoint->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->delivery_singlepoint->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->delivery_singlepoint->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->delivery_singlepoint->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
    <?php if ($Page->SortUrl($Page->delivery_multipoint) == "") { ?>
        <th class="<?= $Page->delivery_multipoint->headerCellClass() ?>"><?= $Page->delivery_multipoint->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->delivery_multipoint->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->delivery_multipoint->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->delivery_multipoint->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->delivery_multipoint->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->delivery_multipoint->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->delivery_multipoint->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
    <?php if ($Page->SortUrl($Page->delivery_jumlahpoint) == "") { ?>
        <th class="<?= $Page->delivery_jumlahpoint->headerCellClass() ?>"><?= $Page->delivery_jumlahpoint->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->delivery_jumlahpoint->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->delivery_jumlahpoint->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->delivery_jumlahpoint->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->delivery_jumlahpoint->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->delivery_jumlahpoint->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->delivery_jumlahpoint->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
    <?php if ($Page->SortUrl($Page->delivery_termslain) == "") { ?>
        <th class="<?= $Page->delivery_termslain->headerCellClass() ?>"><?= $Page->delivery_termslain->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->delivery_termslain->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->delivery_termslain->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->delivery_termslain->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->delivery_termslain->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->delivery_termslain->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->delivery_termslain->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <?php if ($Page->SortUrl($Page->dibuatdi) == "") { ?>
        <th class="<?= $Page->dibuatdi->headerCellClass() ?>"><?= $Page->dibuatdi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dibuatdi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->dibuatdi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dibuatdi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->dibuatdi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->dibuatdi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->dibuatdi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <?php if ($Page->SortUrl($Page->created_at) == "") { ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><?= $Page->created_at->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->created_at->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->created_at->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->created_at->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->created_at->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->created_at->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->id->Visible) { // id ?>
        <!-- id -->
        <td<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <!-- idnpd -->
        <td<?= $Page->idnpd->cellAttributes() ?>>
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <!-- tglsubmit -->
        <td<?= $Page->tglsubmit->cellAttributes() ?>>
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
        <!-- sifat_order -->
        <td<?= $Page->sifat_order->cellAttributes() ?>>
<span<?= $Page->sifat_order->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifat_order_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifat_order->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifat_order->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifat_order_<?= $Page->RowCount ?>"></label>
</div></span>
</td>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
        <!-- ukuran_utama -->
        <td<?= $Page->ukuran_utama->cellAttributes() ?>>
<span<?= $Page->ukuran_utama->viewAttributes() ?>>
<?= $Page->ukuran_utama->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <!-- utama_harga_isi -->
        <td<?= $Page->utama_harga_isi->cellAttributes() ?>>
<span<?= $Page->utama_harga_isi->viewAttributes() ?>>
<?= $Page->utama_harga_isi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <!-- utama_harga_isi_order -->
        <td<?= $Page->utama_harga_isi_order->cellAttributes() ?>>
<span<?= $Page->utama_harga_isi_order->viewAttributes() ?>>
<?= $Page->utama_harga_isi_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <!-- utama_harga_primer -->
        <td<?= $Page->utama_harga_primer->cellAttributes() ?>>
<span<?= $Page->utama_harga_primer->viewAttributes() ?>>
<?= $Page->utama_harga_primer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <!-- utama_harga_primer_order -->
        <td<?= $Page->utama_harga_primer_order->cellAttributes() ?>>
<span<?= $Page->utama_harga_primer_order->viewAttributes() ?>>
<?= $Page->utama_harga_primer_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <!-- utama_harga_sekunder -->
        <td<?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<span<?= $Page->utama_harga_sekunder->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <!-- utama_harga_sekunder_order -->
        <td<?= $Page->utama_harga_sekunder_order->cellAttributes() ?>>
<span<?= $Page->utama_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
        <!-- utama_harga_label -->
        <td<?= $Page->utama_harga_label->cellAttributes() ?>>
<span<?= $Page->utama_harga_label->viewAttributes() ?>>
<?= $Page->utama_harga_label->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <!-- utama_harga_label_order -->
        <td<?= $Page->utama_harga_label_order->cellAttributes() ?>>
<span<?= $Page->utama_harga_label_order->viewAttributes() ?>>
<?= $Page->utama_harga_label_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
        <!-- utama_harga_total -->
        <td<?= $Page->utama_harga_total->cellAttributes() ?>>
<span<?= $Page->utama_harga_total->viewAttributes() ?>>
<?= $Page->utama_harga_total->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <!-- utama_harga_total_order -->
        <td<?= $Page->utama_harga_total_order->cellAttributes() ?>>
<span<?= $Page->utama_harga_total_order->viewAttributes() ?>>
<?= $Page->utama_harga_total_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
        <!-- ukuran_lain -->
        <td<?= $Page->ukuran_lain->cellAttributes() ?>>
<span<?= $Page->ukuran_lain->viewAttributes() ?>>
<?= $Page->ukuran_lain->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <!-- lain_harga_isi -->
        <td<?= $Page->lain_harga_isi->cellAttributes() ?>>
<span<?= $Page->lain_harga_isi->viewAttributes() ?>>
<?= $Page->lain_harga_isi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <!-- lain_harga_isi_order -->
        <td<?= $Page->lain_harga_isi_order->cellAttributes() ?>>
<span<?= $Page->lain_harga_isi_order->viewAttributes() ?>>
<?= $Page->lain_harga_isi_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <!-- lain_harga_primer -->
        <td<?= $Page->lain_harga_primer->cellAttributes() ?>>
<span<?= $Page->lain_harga_primer->viewAttributes() ?>>
<?= $Page->lain_harga_primer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <!-- lain_harga_primer_order -->
        <td<?= $Page->lain_harga_primer_order->cellAttributes() ?>>
<span<?= $Page->lain_harga_primer_order->viewAttributes() ?>>
<?= $Page->lain_harga_primer_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <!-- lain_harga_sekunder -->
        <td<?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<span<?= $Page->lain_harga_sekunder->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <!-- lain_harga_sekunder_order -->
        <td<?= $Page->lain_harga_sekunder_order->cellAttributes() ?>>
<span<?= $Page->lain_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
        <!-- lain_harga_label -->
        <td<?= $Page->lain_harga_label->cellAttributes() ?>>
<span<?= $Page->lain_harga_label->viewAttributes() ?>>
<?= $Page->lain_harga_label->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <!-- lain_harga_label_order -->
        <td<?= $Page->lain_harga_label_order->cellAttributes() ?>>
<span<?= $Page->lain_harga_label_order->viewAttributes() ?>>
<?= $Page->lain_harga_label_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
        <!-- lain_harga_total -->
        <td<?= $Page->lain_harga_total->cellAttributes() ?>>
<span<?= $Page->lain_harga_total->viewAttributes() ?>>
<?= $Page->lain_harga_total->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <!-- lain_harga_total_order -->
        <td<?= $Page->lain_harga_total_order->cellAttributes() ?>>
<span<?= $Page->lain_harga_total_order->viewAttributes() ?>>
<?= $Page->lain_harga_total_order->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <!-- isi_bahan_aktif -->
        <td<?= $Page->isi_bahan_aktif->cellAttributes() ?>>
<span<?= $Page->isi_bahan_aktif->viewAttributes() ?>>
<?= $Page->isi_bahan_aktif->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <!-- isi_bahan_lain -->
        <td<?= $Page->isi_bahan_lain->cellAttributes() ?>>
<span<?= $Page->isi_bahan_lain->viewAttributes() ?>>
<?= $Page->isi_bahan_lain->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
        <!-- isi_parfum -->
        <td<?= $Page->isi_parfum->cellAttributes() ?>>
<span<?= $Page->isi_parfum->viewAttributes() ?>>
<?= $Page->isi_parfum->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
        <!-- isi_estetika -->
        <td<?= $Page->isi_estetika->cellAttributes() ?>>
<span<?= $Page->isi_estetika->viewAttributes() ?>>
<?= $Page->isi_estetika->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <!-- kemasan_wadah -->
        <td<?= $Page->kemasan_wadah->cellAttributes() ?>>
<span<?= $Page->kemasan_wadah->viewAttributes() ?>>
<?= $Page->kemasan_wadah->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <!-- kemasan_tutup -->
        <td<?= $Page->kemasan_tutup->cellAttributes() ?>>
<span<?= $Page->kemasan_tutup->viewAttributes() ?>>
<?= $Page->kemasan_tutup->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <!-- kemasan_sekunder -->
        <td<?= $Page->kemasan_sekunder->cellAttributes() ?>>
<span<?= $Page->kemasan_sekunder->viewAttributes() ?>>
<?= $Page->kemasan_sekunder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
        <!-- label_desain -->
        <td<?= $Page->label_desain->cellAttributes() ?>>
<span<?= $Page->label_desain->viewAttributes() ?>>
<?= $Page->label_desain->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
        <!-- label_cetak -->
        <td<?= $Page->label_cetak->cellAttributes() ?>>
<span<?= $Page->label_cetak->viewAttributes() ?>>
<?= $Page->label_cetak->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
        <!-- label_lainlain -->
        <td<?= $Page->label_lainlain->cellAttributes() ?>>
<span<?= $Page->label_lainlain->viewAttributes() ?>>
<?= $Page->label_lainlain->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
        <!-- delivery_pickup -->
        <td<?= $Page->delivery_pickup->cellAttributes() ?>>
<span<?= $Page->delivery_pickup->viewAttributes() ?>>
<?= $Page->delivery_pickup->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <!-- delivery_singlepoint -->
        <td<?= $Page->delivery_singlepoint->cellAttributes() ?>>
<span<?= $Page->delivery_singlepoint->viewAttributes() ?>>
<?= $Page->delivery_singlepoint->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <!-- delivery_multipoint -->
        <td<?= $Page->delivery_multipoint->cellAttributes() ?>>
<span<?= $Page->delivery_multipoint->viewAttributes() ?>>
<?= $Page->delivery_multipoint->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <!-- delivery_jumlahpoint -->
        <td<?= $Page->delivery_jumlahpoint->cellAttributes() ?>>
<span<?= $Page->delivery_jumlahpoint->viewAttributes() ?>>
<?= $Page->delivery_jumlahpoint->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
        <!-- delivery_termslain -->
        <td<?= $Page->delivery_termslain->cellAttributes() ?>>
<span<?= $Page->delivery_termslain->viewAttributes() ?>>
<?= $Page->delivery_termslain->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <!-- dibuatdi -->
        <td<?= $Page->dibuatdi->cellAttributes() ?>>
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <!-- created_at -->
        <td<?= $Page->created_at->cellAttributes() ?>>
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
