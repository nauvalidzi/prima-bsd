<?php

namespace PHPMaker2021\distributor;

// Page object
$CustomerPreview = &$Page;
?>
<script>
if (!ew.vars.tables.customer) ew.vars.tables.customer = <?= JsonEncode(GetClientVar("tables", "customer")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid customer"><!-- .card -->
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
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
    <?php if ($Page->SortUrl($Page->idtipecustomer) == "") { ?>
        <th class="<?= $Page->idtipecustomer->headerCellClass() ?>"><?= $Page->idtipecustomer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idtipecustomer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idtipecustomer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idtipecustomer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idtipecustomer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idtipecustomer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idtipecustomer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <?php if ($Page->SortUrl($Page->idpegawai) == "") { ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><?= $Page->idpegawai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idpegawai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idpegawai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idpegawai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idpegawai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idpegawai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->jenis_usaha->Visible) { // jenis_usaha ?>
    <?php if ($Page->SortUrl($Page->jenis_usaha) == "") { ?>
        <th class="<?= $Page->jenis_usaha->headerCellClass() ?>"><?= $Page->jenis_usaha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jenis_usaha->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jenis_usaha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jenis_usaha->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jenis_usaha->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jenis_usaha->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jenis_usaha->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <?php if ($Page->SortUrl($Page->hp) == "") { ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><?= $Page->hp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->hp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->hp->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->hp->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->hp->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->hp->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->klinik->Visible) { // klinik ?>
    <?php if ($Page->SortUrl($Page->klinik) == "") { ?>
        <th class="<?= $Page->klinik->headerCellClass() ?>"><?= $Page->klinik->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->klinik->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->klinik->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->klinik->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->klinik->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->klinik->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->klinik->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
        <!-- idtipecustomer -->
        <td<?= $Page->idtipecustomer->cellAttributes() ?>>
<span<?= $Page->idtipecustomer->viewAttributes() ?>>
<?= $Page->idtipecustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <!-- idpegawai -->
        <td<?= $Page->idpegawai->cellAttributes() ?>>
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <!-- nama -->
        <td<?= $Page->nama->cellAttributes() ?>>
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jenis_usaha->Visible) { // jenis_usaha ?>
        <!-- jenis_usaha -->
        <td<?= $Page->jenis_usaha->cellAttributes() ?>>
<span<?= $Page->jenis_usaha->viewAttributes() ?>>
<?= $Page->jenis_usaha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <!-- hp -->
        <td<?= $Page->hp->cellAttributes() ?>>
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->klinik->Visible) { // klinik ?>
        <!-- klinik -->
        <td<?= $Page->klinik->cellAttributes() ?>>
<span<?= $Page->klinik->viewAttributes() ?>>
<?= $Page->klinik->getViewValue() ?></span>
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
