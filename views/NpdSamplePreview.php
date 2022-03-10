<?php

namespace PHPMaker2021\production2;

// Page object
$NpdSamplePreview = &$Page;
?>
<script>
if (!ew.vars.tables.npd_sample) ew.vars.tables.npd_sample = <?= JsonEncode(GetClientVar("tables", "npd_sample")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid npd_sample"><!-- .card -->
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
<?php if ($Page->kode->Visible) { // kode ?>
    <?php if ($Page->SortUrl($Page->kode) == "") { ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><?= $Page->kode->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kode->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kode->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kode->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <?php if ($Page->SortUrl($Page->nama) == "") { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><?= $Page->nama->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
    <?php if ($Page->SortUrl($Page->sediaan) == "") { ?>
        <th class="<?= $Page->sediaan->headerCellClass() ?>"><?= $Page->sediaan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sediaan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sediaan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sediaan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sediaan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sediaan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sediaan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <?php if ($Page->SortUrl($Page->warna) == "") { ?>
        <th class="<?= $Page->warna->headerCellClass() ?>"><?= $Page->warna->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->warna->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->warna->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->warna->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->warna->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->warna->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->warna->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fungsi->Visible) { // fungsi ?>
    <?php if ($Page->SortUrl($Page->fungsi) == "") { ?>
        <th class="<?= $Page->fungsi->headerCellClass() ?>"><?= $Page->fungsi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fungsi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fungsi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fungsi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fungsi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->fungsi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->fungsi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <?php if ($Page->SortUrl($Page->jumlah) == "") { ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><?= $Page->jumlah->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlah->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlah->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlah->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlah->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlah->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <?php if ($Page->SortUrl($Page->volume) == "") { ?>
        <th class="<?= $Page->volume->headerCellClass() ?>"><?= $Page->volume->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->volume->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->volume->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->volume->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->volume->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->volume->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->volume->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bau->Visible) { // bau ?>
    <?php if ($Page->SortUrl($Page->bau) == "") { ?>
        <th class="<?= $Page->bau->headerCellClass() ?>"><?= $Page->bau->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bau->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bau->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bau->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bau->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->bau->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->bau->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <!-- kode -->
        <td<?= $Page->kode->cellAttributes() ?>>
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <!-- nama -->
        <td<?= $Page->nama->cellAttributes() ?>>
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <!-- sediaan -->
        <td<?= $Page->sediaan->cellAttributes() ?>>
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <!-- warna -->
        <td<?= $Page->warna->cellAttributes() ?>>
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fungsi->Visible) { // fungsi ?>
        <!-- fungsi -->
        <td<?= $Page->fungsi->cellAttributes() ?>>
<span<?= $Page->fungsi->viewAttributes() ?>>
<?= $Page->fungsi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <!-- jumlah -->
        <td<?= $Page->jumlah->cellAttributes() ?>>
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
        <!-- volume -->
        <td<?= $Page->volume->cellAttributes() ?>>
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bau->Visible) { // bau ?>
        <!-- bau -->
        <td<?= $Page->bau->cellAttributes() ?>>
<span<?= $Page->bau->viewAttributes() ?>>
<?= $Page->bau->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
