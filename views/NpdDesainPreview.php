<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdDesainPreview = &$Page;
?>
<script>
if (!ew.vars.tables.npd_desain) ew.vars.tables.npd_desain = <?= JsonEncode(GetClientVar("tables", "npd_desain")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid npd_desain"><!-- .card -->
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <?php if ($Page->SortUrl($Page->idnpd) == "") { ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><?= $Page->idnpd->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idnpd->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idnpd->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idnpd->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idnpd->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idnpd->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <?php if ($Page->SortUrl($Page->idcustomer) == "") { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><?= $Page->idcustomer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idcustomer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idcustomer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idcustomer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idcustomer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idcustomer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
    <?php if ($Page->SortUrl($Page->tanggal_terima) == "") { ?>
        <th class="<?= $Page->tanggal_terima->headerCellClass() ?>"><?= $Page->tanggal_terima->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tanggal_terima->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tanggal_terima->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tanggal_terima->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tanggal_terima->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tanggal_terima->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tanggal_terima->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <?php if ($Page->SortUrl($Page->tanggal_submit) == "") { ?>
        <th class="<?= $Page->tanggal_submit->headerCellClass() ?>"><?= $Page->tanggal_submit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tanggal_submit->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tanggal_submit->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tanggal_submit->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tanggal_submit->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tanggal_submit->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tanggal_submit->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nama_produk->Visible) { // nama_produk ?>
    <?php if ($Page->SortUrl($Page->nama_produk) == "") { ?>
        <th class="<?= $Page->nama_produk->headerCellClass() ?>"><?= $Page->nama_produk->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama_produk->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama_produk->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama_produk->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama_produk->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama_produk->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama_produk->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->klaim_bahan->Visible) { // klaim_bahan ?>
    <?php if ($Page->SortUrl($Page->klaim_bahan) == "") { ?>
        <th class="<?= $Page->klaim_bahan->headerCellClass() ?>"><?= $Page->klaim_bahan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->klaim_bahan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->klaim_bahan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->klaim_bahan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->klaim_bahan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->klaim_bahan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->klaim_bahan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->campaign_produk->Visible) { // campaign_produk ?>
    <?php if ($Page->SortUrl($Page->campaign_produk) == "") { ?>
        <th class="<?= $Page->campaign_produk->headerCellClass() ?>"><?= $Page->campaign_produk->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->campaign_produk->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->campaign_produk->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->campaign_produk->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->campaign_produk->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->campaign_produk->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->campaign_produk->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
    <?php if ($Page->SortUrl($Page->konsep) == "") { ?>
        <th class="<?= $Page->konsep->headerCellClass() ?>"><?= $Page->konsep->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->konsep->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->konsep->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->konsep->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->konsep->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->konsep->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->konsep->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tema_warna->Visible) { // tema_warna ?>
    <?php if ($Page->SortUrl($Page->tema_warna) == "") { ?>
        <th class="<?= $Page->tema_warna->headerCellClass() ?>"><?= $Page->tema_warna->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tema_warna->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tema_warna->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tema_warna->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tema_warna->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tema_warna->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tema_warna->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->no_notifikasi->Visible) { // no_notifikasi ?>
    <?php if ($Page->SortUrl($Page->no_notifikasi) == "") { ?>
        <th class="<?= $Page->no_notifikasi->headerCellClass() ?>"><?= $Page->no_notifikasi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->no_notifikasi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->no_notifikasi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->no_notifikasi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->no_notifikasi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->no_notifikasi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->no_notifikasi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jenis_kemasan->Visible) { // jenis_kemasan ?>
    <?php if ($Page->SortUrl($Page->jenis_kemasan) == "") { ?>
        <th class="<?= $Page->jenis_kemasan->headerCellClass() ?>"><?= $Page->jenis_kemasan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jenis_kemasan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jenis_kemasan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jenis_kemasan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jenis_kemasan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jenis_kemasan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jenis_kemasan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->posisi_label->Visible) { // posisi_label ?>
    <?php if ($Page->SortUrl($Page->posisi_label) == "") { ?>
        <th class="<?= $Page->posisi_label->headerCellClass() ?>"><?= $Page->posisi_label->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->posisi_label->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->posisi_label->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->posisi_label->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->posisi_label->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->posisi_label->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->posisi_label->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bahan_label->Visible) { // bahan_label ?>
    <?php if ($Page->SortUrl($Page->bahan_label) == "") { ?>
        <th class="<?= $Page->bahan_label->headerCellClass() ?>"><?= $Page->bahan_label->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bahan_label->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bahan_label->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bahan_label->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bahan_label->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->bahan_label->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->bahan_label->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->draft_layout->Visible) { // draft_layout ?>
    <?php if ($Page->SortUrl($Page->draft_layout) == "") { ?>
        <th class="<?= $Page->draft_layout->headerCellClass() ?>"><?= $Page->draft_layout->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->draft_layout->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->draft_layout->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->draft_layout->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->draft_layout->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->draft_layout->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->draft_layout->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <!-- idnpd -->
        <td<?= $Page->idnpd->cellAttributes() ?>>
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <!-- idcustomer -->
        <td<?= $Page->idcustomer->cellAttributes() ?>>
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <!-- tanggal_terima -->
        <td<?= $Page->tanggal_terima->cellAttributes() ?>>
<span<?= $Page->tanggal_terima->viewAttributes() ?>>
<?= $Page->tanggal_terima->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <!-- tanggal_submit -->
        <td<?= $Page->tanggal_submit->cellAttributes() ?>>
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama_produk->Visible) { // nama_produk ?>
        <!-- nama_produk -->
        <td<?= $Page->nama_produk->cellAttributes() ?>>
<span<?= $Page->nama_produk->viewAttributes() ?>>
<?= $Page->nama_produk->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->klaim_bahan->Visible) { // klaim_bahan ?>
        <!-- klaim_bahan -->
        <td<?= $Page->klaim_bahan->cellAttributes() ?>>
<span<?= $Page->klaim_bahan->viewAttributes() ?>>
<?= $Page->klaim_bahan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->campaign_produk->Visible) { // campaign_produk ?>
        <!-- campaign_produk -->
        <td<?= $Page->campaign_produk->cellAttributes() ?>>
<span<?= $Page->campaign_produk->viewAttributes() ?>>
<?= $Page->campaign_produk->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <!-- konsep -->
        <td<?= $Page->konsep->cellAttributes() ?>>
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tema_warna->Visible) { // tema_warna ?>
        <!-- tema_warna -->
        <td<?= $Page->tema_warna->cellAttributes() ?>>
<span<?= $Page->tema_warna->viewAttributes() ?>>
<?= $Page->tema_warna->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->no_notifikasi->Visible) { // no_notifikasi ?>
        <!-- no_notifikasi -->
        <td<?= $Page->no_notifikasi->cellAttributes() ?>>
<span<?= $Page->no_notifikasi->viewAttributes() ?>>
<?= $Page->no_notifikasi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jenis_kemasan->Visible) { // jenis_kemasan ?>
        <!-- jenis_kemasan -->
        <td<?= $Page->jenis_kemasan->cellAttributes() ?>>
<span<?= $Page->jenis_kemasan->viewAttributes() ?>>
<?= $Page->jenis_kemasan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->posisi_label->Visible) { // posisi_label ?>
        <!-- posisi_label -->
        <td<?= $Page->posisi_label->cellAttributes() ?>>
<span<?= $Page->posisi_label->viewAttributes() ?>>
<?= $Page->posisi_label->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bahan_label->Visible) { // bahan_label ?>
        <!-- bahan_label -->
        <td<?= $Page->bahan_label->cellAttributes() ?>>
<span<?= $Page->bahan_label->viewAttributes() ?>>
<?= $Page->bahan_label->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->draft_layout->Visible) { // draft_layout ?>
        <!-- draft_layout -->
        <td<?= $Page->draft_layout->cellAttributes() ?>>
<span<?= $Page->draft_layout->viewAttributes() ?>>
<?= $Page->draft_layout->getViewValue() ?></span>
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
