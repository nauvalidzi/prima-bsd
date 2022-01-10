<?php

namespace PHPMaker2021\distributor;

// Page object
$OrderPreview = &$Page;
?>
<script>
if (!ew.vars.tables.order) ew.vars.tables.order = <?= JsonEncode(GetClientVar("tables", "order")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid order"><!-- .card -->
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
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <?php if ($Page->SortUrl($Page->tanggal) == "") { ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><?= $Page->tanggal->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tanggal->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tanggal->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tanggal->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tanggal->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tanggal->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <?php if ($Page->SortUrl($Page->idcustomer) == "") { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><?= $Page->idcustomer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idcustomer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idcustomer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idcustomer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idcustomer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idcustomer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <?php if ($Page->SortUrl($Page->idbrand) == "") { ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><?= $Page->idbrand->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idbrand->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idbrand->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idbrand->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idbrand->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idbrand->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <!-- tanggal -->
        <td<?= $Page->tanggal->cellAttributes() ?>>
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <!-- idpegawai -->
        <td<?= $Page->idpegawai->cellAttributes() ?>>
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <!-- idcustomer -->
        <td<?= $Page->idcustomer->cellAttributes() ?>>
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <!-- idbrand -->
        <td<?= $Page->idbrand->cellAttributes() ?>>
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
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
