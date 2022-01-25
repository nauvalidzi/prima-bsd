<?php

namespace PHPMaker2021\distributor;

// Page object
$VBrandCustomerPreview = &$Page;
?>
<script>
if (!ew.vars.tables.v_brand_customer) ew.vars.tables.v_brand_customer = <?= JsonEncode(GetClientVar("tables", "v_brand_customer")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid v_brand_customer"><!-- .card -->
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
<?php if ($Page->kode_brand->Visible) { // kode_brand ?>
    <?php if ($Page->SortUrl($Page->kode_brand) == "") { ?>
        <th class="<?= $Page->kode_brand->headerCellClass() ?>"><?= $Page->kode_brand->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kode_brand->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kode_brand->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kode_brand->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kode_brand->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kode_brand->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kode_brand->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
    <?php if ($Page->SortUrl($Page->nama_brand) == "") { ?>
        <th class="<?= $Page->nama_brand->headerCellClass() ?>"><?= $Page->nama_brand->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama_brand->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama_brand->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama_brand->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama_brand->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama_brand->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama_brand->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->kode_customer->Visible) { // kode_customer ?>
    <?php if ($Page->SortUrl($Page->kode_customer) == "") { ?>
        <th class="<?= $Page->kode_customer->headerCellClass() ?>"><?= $Page->kode_customer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kode_customer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kode_customer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kode_customer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kode_customer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kode_customer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kode_customer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
    <?php if ($Page->SortUrl($Page->nama_customer) == "") { ?>
        <th class="<?= $Page->nama_customer->headerCellClass() ?>"><?= $Page->nama_customer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama_customer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama_customer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama_customer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama_customer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama_customer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama_customer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlah_produk->Visible) { // jumlah_produk ?>
    <?php if ($Page->SortUrl($Page->jumlah_produk) == "") { ?>
        <th class="<?= $Page->jumlah_produk->headerCellClass() ?>"><?= $Page->jumlah_produk->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlah_produk->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlah_produk->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlah_produk->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlah_produk->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlah_produk->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlah_produk->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->kode_brand->Visible) { // kode_brand ?>
        <!-- kode_brand -->
        <td<?= $Page->kode_brand->cellAttributes() ?>>
<span<?= $Page->kode_brand->viewAttributes() ?>>
<?= $Page->kode_brand->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
        <!-- nama_brand -->
        <td<?= $Page->nama_brand->cellAttributes() ?>>
<span<?= $Page->nama_brand->viewAttributes() ?>>
<?= $Page->nama_brand->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <!-- idcustomer -->
        <td<?= $Page->idcustomer->cellAttributes() ?>>
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kode_customer->Visible) { // kode_customer ?>
        <!-- kode_customer -->
        <td<?= $Page->kode_customer->cellAttributes() ?>>
<span<?= $Page->kode_customer->viewAttributes() ?>>
<?= $Page->kode_customer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <!-- nama_customer -->
        <td<?= $Page->nama_customer->cellAttributes() ?>>
<span<?= $Page->nama_customer->viewAttributes() ?>>
<?= $Page->nama_customer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlah_produk->Visible) { // jumlah_produk ?>
        <!-- jumlah_produk -->
        <td<?= $Page->jumlah_produk->cellAttributes() ?>>
<span<?= $Page->jumlah_produk->viewAttributes() ?>>
<?= $Page->jumlah_produk->getViewValue() ?></span>
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
