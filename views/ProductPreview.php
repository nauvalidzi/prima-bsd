<?php

namespace PHPMaker2021\distributor;

// Page object
$ProductPreview = &$Page;
?>
<script>
if (!ew.vars.tables.product) ew.vars.tables.product = <?= JsonEncode(GetClientVar("tables", "product")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid product"><!-- .card -->
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <?php if ($Page->SortUrl($Page->idbrand) == "") { ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><?= $Page->idbrand->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idbrand->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idbrand->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idbrand->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idbrand->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idbrand->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
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
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <?php if ($Page->SortUrl($Page->ukuran) == "") { ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><?= $Page->ukuran->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ukuran->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ukuran->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ukuran->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ukuran->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ukuran->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
    <?php if ($Page->SortUrl($Page->kemasanbarang) == "") { ?>
        <th class="<?= $Page->kemasanbarang->headerCellClass() ?>"><?= $Page->kemasanbarang->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kemasanbarang->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kemasanbarang->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kemasanbarang->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kemasanbarang->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kemasanbarang->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kemasanbarang->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <?php if ($Page->SortUrl($Page->harga) == "") { ?>
        <th class="<?= $Page->harga->headerCellClass() ?>"><?= $Page->harga->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->harga->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->harga->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->harga->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->harga->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->harga->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->harga->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <?php if ($Page->SortUrl($Page->updated_at) == "") { ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><?= $Page->updated_at->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->updated_at->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->updated_at->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->updated_at->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->updated_at->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->updated_at->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <!-- idbrand -->
        <td<?= $Page->idbrand->cellAttributes() ?>>
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</td>
<?php } ?>
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
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <!-- ukuran -->
        <td<?= $Page->ukuran->cellAttributes() ?>>
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
        <!-- kemasanbarang -->
        <td<?= $Page->kemasanbarang->cellAttributes() ?>>
<span<?= $Page->kemasanbarang->viewAttributes() ?>>
<?= $Page->kemasanbarang->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <!-- harga -->
        <td<?= $Page->harga->cellAttributes() ?>>
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <!-- updated_at -->
        <td<?= $Page->updated_at->cellAttributes() ?>>
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
