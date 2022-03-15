<?php

namespace PHPMaker2021\production2;

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
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <?php if ($Page->SortUrl($Page->tglterima) == "") { ?>
        <th class="<?= $Page->tglterima->headerCellClass() ?>"><?= $Page->tglterima->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglterima->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglterima->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglterima->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglterima->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglterima->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglterima->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->nama_produk->Visible) { // nama_produk ?>
    <?php if ($Page->SortUrl($Page->nama_produk) == "") { ?>
        <th class="<?= $Page->nama_produk->headerCellClass() ?>"><?= $Page->nama_produk->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama_produk->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama_produk->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama_produk->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama_produk->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama_produk->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama_produk->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->konsepwarna->Visible) { // konsepwarna ?>
    <?php if ($Page->SortUrl($Page->konsepwarna) == "") { ?>
        <th class="<?= $Page->konsepwarna->headerCellClass() ?>"><?= $Page->konsepwarna->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->konsepwarna->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->konsepwarna->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->konsepwarna->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->konsepwarna->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->konsepwarna->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->konsepwarna->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <!-- tglterima -->
        <td<?= $Page->tglterima->cellAttributes() ?>>
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <!-- tglsubmit -->
        <td<?= $Page->tglsubmit->cellAttributes() ?>>
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama_produk->Visible) { // nama_produk ?>
        <!-- nama_produk -->
        <td<?= $Page->nama_produk->cellAttributes() ?>>
<span<?= $Page->nama_produk->viewAttributes() ?>>
<?= $Page->nama_produk->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->konsepwarna->Visible) { // konsepwarna ?>
        <!-- konsepwarna -->
        <td<?= $Page->konsepwarna->cellAttributes() ?>>
<span<?= $Page->konsepwarna->viewAttributes() ?>>
<?= $Page->konsepwarna->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->no_notifikasi->Visible) { // no_notifikasi ?>
        <!-- no_notifikasi -->
        <td<?= $Page->no_notifikasi->cellAttributes() ?>>
<span<?= $Page->no_notifikasi->viewAttributes() ?>>
<?= $Page->no_notifikasi->getViewValue() ?></span>
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
