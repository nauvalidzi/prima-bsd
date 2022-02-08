<?php

namespace PHPMaker2021\production2;

// Page object
$IjinbpomStatusPreview = &$Page;
?>
<script>
if (!ew.vars.tables.ijinbpom_status) ew.vars.tables.ijinbpom_status = <?= JsonEncode(GetClientVar("tables", "ijinbpom_status")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid ijinbpom_status"><!-- .card -->
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <?php if ($Page->SortUrl($Page->idpegawai) == "") { ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><?= $Page->idpegawai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idpegawai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idpegawai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idpegawai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idpegawai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idpegawai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->targetmulai->Visible) { // targetmulai ?>
    <?php if ($Page->SortUrl($Page->targetmulai) == "") { ?>
        <th class="<?= $Page->targetmulai->headerCellClass() ?>"><?= $Page->targetmulai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->targetmulai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->targetmulai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->targetmulai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->targetmulai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->targetmulai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->targetmulai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglmulai->Visible) { // tglmulai ?>
    <?php if ($Page->SortUrl($Page->tglmulai) == "") { ?>
        <th class="<?= $Page->tglmulai->headerCellClass() ?>"><?= $Page->tglmulai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglmulai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglmulai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglmulai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglmulai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglmulai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglmulai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->targetselesai->Visible) { // targetselesai ?>
    <?php if ($Page->SortUrl($Page->targetselesai) == "") { ?>
        <th class="<?= $Page->targetselesai->headerCellClass() ?>"><?= $Page->targetselesai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->targetselesai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->targetselesai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->targetselesai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->targetselesai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->targetselesai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->targetselesai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglselesai->Visible) { // tglselesai ?>
    <?php if ($Page->SortUrl($Page->tglselesai) == "") { ?>
        <th class="<?= $Page->tglselesai->headerCellClass() ?>"><?= $Page->tglselesai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglselesai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglselesai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglselesai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglselesai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglselesai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglselesai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <?php if ($Page->SortUrl($Page->keterangan) == "") { ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><?= $Page->keterangan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->keterangan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->keterangan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->keterangan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->keterangan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->keterangan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <!-- idpegawai -->
        <td<?= $Page->idpegawai->cellAttributes() ?>>
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->targetmulai->Visible) { // targetmulai ?>
        <!-- targetmulai -->
        <td<?= $Page->targetmulai->cellAttributes() ?>>
<span<?= $Page->targetmulai->viewAttributes() ?>>
<?= $Page->targetmulai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglmulai->Visible) { // tglmulai ?>
        <!-- tglmulai -->
        <td<?= $Page->tglmulai->cellAttributes() ?>>
<span<?= $Page->tglmulai->viewAttributes() ?>>
<?= $Page->tglmulai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->targetselesai->Visible) { // targetselesai ?>
        <!-- targetselesai -->
        <td<?= $Page->targetselesai->cellAttributes() ?>>
<span<?= $Page->targetselesai->viewAttributes() ?>>
<?= $Page->targetselesai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglselesai->Visible) { // tglselesai ?>
        <!-- tglselesai -->
        <td<?= $Page->tglselesai->cellAttributes() ?>>
<span<?= $Page->tglselesai->viewAttributes() ?>>
<?= $Page->tglselesai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <!-- keterangan -->
        <td<?= $Page->keterangan->cellAttributes() ?>>
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
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
