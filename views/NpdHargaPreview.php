<?php

namespace PHPMaker2021\production2;

// Page object
$NpdHargaPreview = &$Page;
?>
<script>
if (!ew.vars.tables.npd_harga) ew.vars.tables.npd_harga = <?= JsonEncode(GetClientVar("tables", "npd_harga")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid npd_harga"><!-- .card -->
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
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
    <?php if ($Page->SortUrl($Page->tglpengajuan) == "") { ?>
        <th class="<?= $Page->tglpengajuan->headerCellClass() ?>"><?= $Page->tglpengajuan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglpengajuan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglpengajuan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglpengajuan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglpengajuan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglpengajuan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglpengajuan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <?php if ($Page->SortUrl($Page->idnpd_sample) == "") { ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><?= $Page->idnpd_sample->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idnpd_sample->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idnpd_sample->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idnpd_sample->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idnpd_sample->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idnpd_sample->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->viskositasbarang->Visible) { // viskositasbarang ?>
    <?php if ($Page->SortUrl($Page->viskositasbarang) == "") { ?>
        <th class="<?= $Page->viskositasbarang->headerCellClass() ?>"><?= $Page->viskositasbarang->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->viskositasbarang->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->viskositasbarang->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->viskositasbarang->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->viskositasbarang->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->viskositasbarang->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->viskositasbarang->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idaplikasibarang->Visible) { // idaplikasibarang ?>
    <?php if ($Page->SortUrl($Page->idaplikasibarang) == "") { ?>
        <th class="<?= $Page->idaplikasibarang->headerCellClass() ?>"><?= $Page->idaplikasibarang->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idaplikasibarang->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idaplikasibarang->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idaplikasibarang->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idaplikasibarang->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idaplikasibarang->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idaplikasibarang->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->hargapcs->Visible) { // hargapcs ?>
    <?php if ($Page->SortUrl($Page->hargapcs) == "") { ?>
        <th class="<?= $Page->hargapcs->headerCellClass() ?>"><?= $Page->hargapcs->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->hargapcs->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->hargapcs->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->hargapcs->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->hargapcs->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->hargapcs->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->hargapcs->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
    <?php if ($Page->SortUrl($Page->disetujui) == "") { ?>
        <th class="<?= $Page->disetujui->headerCellClass() ?>"><?= $Page->disetujui->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->disetujui->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->disetujui->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->disetujui->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->disetujui->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->disetujui->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->disetujui->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
        <!-- tglpengajuan -->
        <td<?= $Page->tglpengajuan->cellAttributes() ?>>
<span<?= $Page->tglpengajuan->viewAttributes() ?>>
<?= $Page->tglpengajuan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <!-- idnpd_sample -->
        <td<?= $Page->idnpd_sample->cellAttributes() ?>>
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->viskositasbarang->Visible) { // viskositasbarang ?>
        <!-- viskositasbarang -->
        <td<?= $Page->viskositasbarang->cellAttributes() ?>>
<span<?= $Page->viskositasbarang->viewAttributes() ?>>
<?= $Page->viskositasbarang->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idaplikasibarang->Visible) { // idaplikasibarang ?>
        <!-- idaplikasibarang -->
        <td<?= $Page->idaplikasibarang->cellAttributes() ?>>
<span<?= $Page->idaplikasibarang->viewAttributes() ?>>
<?= $Page->idaplikasibarang->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->hargapcs->Visible) { // hargapcs ?>
        <!-- hargapcs -->
        <td<?= $Page->hargapcs->cellAttributes() ?>>
<span<?= $Page->hargapcs->viewAttributes() ?>>
<?= $Page->hargapcs->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
        <!-- disetujui -->
        <td<?= $Page->disetujui->cellAttributes() ?>>
<span<?= $Page->disetujui->viewAttributes() ?>>
<?= $Page->disetujui->getViewValue() ?></span>
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
