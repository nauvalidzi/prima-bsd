<?php

namespace PHPMaker2021\distributor;

// Page object
$AlamatCustomerPreview = &$Page;
?>
<script>
if (!ew.vars.tables.alamat_customer) ew.vars.tables.alamat_customer = <?= JsonEncode(GetClientVar("tables", "alamat_customer")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid alamat_customer"><!-- .card -->
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
<?php if ($Page->alias->Visible) { // alias ?>
    <?php if ($Page->SortUrl($Page->alias) == "") { ?>
        <th class="<?= $Page->alias->headerCellClass() ?>"><?= $Page->alias->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->alias->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->alias->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->alias->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->alias->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->alias->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->alias->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
    <?php if ($Page->SortUrl($Page->idprovinsi) == "") { ?>
        <th class="<?= $Page->idprovinsi->headerCellClass() ?>"><?= $Page->idprovinsi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idprovinsi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idprovinsi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idprovinsi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idprovinsi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idprovinsi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idprovinsi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
    <?php if ($Page->SortUrl($Page->idkabupaten) == "") { ?>
        <th class="<?= $Page->idkabupaten->headerCellClass() ?>"><?= $Page->idkabupaten->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idkabupaten->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idkabupaten->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idkabupaten->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idkabupaten->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idkabupaten->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idkabupaten->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
    <?php if ($Page->SortUrl($Page->idkecamatan) == "") { ?>
        <th class="<?= $Page->idkecamatan->headerCellClass() ?>"><?= $Page->idkecamatan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idkecamatan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idkecamatan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idkecamatan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idkecamatan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idkecamatan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idkecamatan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idkelurahan->Visible) { // idkelurahan ?>
    <?php if ($Page->SortUrl($Page->idkelurahan) == "") { ?>
        <th class="<?= $Page->idkelurahan->headerCellClass() ?>"><?= $Page->idkelurahan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idkelurahan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idkelurahan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idkelurahan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idkelurahan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idkelurahan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idkelurahan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <?php if ($Page->SortUrl($Page->alamat) == "") { ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><?= $Page->alamat->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->alamat->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->alamat->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->alamat->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->alamat->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->alamat->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
    <?php if ($Page->SortUrl($Page->penerima) == "") { ?>
        <th class="<?= $Page->penerima->headerCellClass() ?>"><?= $Page->penerima->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->penerima->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->penerima->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->penerima->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->penerima->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->penerima->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->penerima->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->alias->Visible) { // alias ?>
        <!-- alias -->
        <td<?= $Page->alias->cellAttributes() ?>>
<span<?= $Page->alias->viewAttributes() ?>>
<?= $Page->alias->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
        <!-- idprovinsi -->
        <td<?= $Page->idprovinsi->cellAttributes() ?>>
<span<?= $Page->idprovinsi->viewAttributes() ?>>
<?= $Page->idprovinsi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
        <!-- idkabupaten -->
        <td<?= $Page->idkabupaten->cellAttributes() ?>>
<span<?= $Page->idkabupaten->viewAttributes() ?>>
<?= $Page->idkabupaten->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
        <!-- idkecamatan -->
        <td<?= $Page->idkecamatan->cellAttributes() ?>>
<span<?= $Page->idkecamatan->viewAttributes() ?>>
<?= $Page->idkecamatan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idkelurahan->Visible) { // idkelurahan ?>
        <!-- idkelurahan -->
        <td<?= $Page->idkelurahan->cellAttributes() ?>>
<span<?= $Page->idkelurahan->viewAttributes() ?>>
<?= $Page->idkelurahan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <!-- alamat -->
        <td<?= $Page->alamat->cellAttributes() ?>>
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
        <!-- penerima -->
        <td<?= $Page->penerima->cellAttributes() ?>>
<span<?= $Page->penerima->viewAttributes() ?>>
<?= $Page->penerima->getViewValue() ?></span>
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
