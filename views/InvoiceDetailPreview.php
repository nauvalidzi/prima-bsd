<?php

namespace PHPMaker2021\production2;

// Page object
$InvoiceDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.invoice_detail) ew.vars.tables.invoice_detail = <?= JsonEncode(GetClientVar("tables", "invoice_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid invoice_detail"><!-- .card -->
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <?php if ($Page->SortUrl($Page->idorder_detail) == "") { ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><?= $Page->idorder_detail->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idorder_detail->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idorder_detail->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idorder_detail->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idorder_detail->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idorder_detail->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
    <?php if ($Page->SortUrl($Page->jumlahorder) == "") { ?>
        <th class="<?= $Page->jumlahorder->headerCellClass() ?>"><?= $Page->jumlahorder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlahorder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlahorder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlahorder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlahorder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlahorder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlahorder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
    <?php if ($Page->SortUrl($Page->bonus) == "") { ?>
        <th class="<?= $Page->bonus->headerCellClass() ?>"><?= $Page->bonus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bonus->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bonus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bonus->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bonus->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->bonus->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->bonus->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
    <?php if ($Page->SortUrl($Page->stockdo) == "") { ?>
        <th class="<?= $Page->stockdo->headerCellClass() ?>"><?= $Page->stockdo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->stockdo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->stockdo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->stockdo->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->stockdo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->stockdo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->stockdo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
    <?php if ($Page->SortUrl($Page->jumlahkirim) == "") { ?>
        <th class="<?= $Page->jumlahkirim->headerCellClass() ?>"><?= $Page->jumlahkirim->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlahkirim->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlahkirim->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlahkirim->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlahkirim->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlahkirim->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlahkirim->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
    <?php if ($Page->SortUrl($Page->jumlahbonus) == "") { ?>
        <th class="<?= $Page->jumlahbonus->headerCellClass() ?>"><?= $Page->jumlahbonus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlahbonus->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlahbonus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlahbonus->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlahbonus->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlahbonus->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlahbonus->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
    <?php if ($Page->SortUrl($Page->totalnondiskon) == "") { ?>
        <th class="<?= $Page->totalnondiskon->headerCellClass() ?>"><?= $Page->totalnondiskon->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->totalnondiskon->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->totalnondiskon->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->totalnondiskon->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->totalnondiskon->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->totalnondiskon->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->totalnondiskon->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
    <?php if ($Page->SortUrl($Page->diskonpayment) == "") { ?>
        <th class="<?= $Page->diskonpayment->headerCellClass() ?>"><?= $Page->diskonpayment->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->diskonpayment->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->diskonpayment->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->diskonpayment->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->diskonpayment->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->diskonpayment->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->diskonpayment->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
    <?php if ($Page->SortUrl($Page->bbpersen) == "") { ?>
        <th class="<?= $Page->bbpersen->headerCellClass() ?>"><?= $Page->bbpersen->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bbpersen->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bbpersen->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bbpersen->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bbpersen->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->bbpersen->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->bbpersen->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <?php if ($Page->SortUrl($Page->totaltagihan) == "") { ?>
        <th class="<?= $Page->totaltagihan->headerCellClass() ?>"><?= $Page->totaltagihan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->totaltagihan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->totaltagihan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->totaltagihan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->totaltagihan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->totaltagihan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->totaltagihan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
    <?php if ($Page->SortUrl($Page->blackbonus) == "") { ?>
        <th class="<?= $Page->blackbonus->headerCellClass() ?>"><?= $Page->blackbonus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->blackbonus->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->blackbonus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->blackbonus->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->blackbonus->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->blackbonus->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->blackbonus->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <!-- idorder_detail -->
        <td<?= $Page->idorder_detail->cellAttributes() ?>>
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
        <!-- jumlahorder -->
        <td<?= $Page->jumlahorder->cellAttributes() ?>>
<span<?= $Page->jumlahorder->viewAttributes() ?>>
<?= $Page->jumlahorder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
        <!-- bonus -->
        <td<?= $Page->bonus->cellAttributes() ?>>
<span<?= $Page->bonus->viewAttributes() ?>>
<?= $Page->bonus->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
        <!-- stockdo -->
        <td<?= $Page->stockdo->cellAttributes() ?>>
<span<?= $Page->stockdo->viewAttributes() ?>>
<?= $Page->stockdo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <!-- jumlahkirim -->
        <td<?= $Page->jumlahkirim->cellAttributes() ?>>
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
        <!-- jumlahbonus -->
        <td<?= $Page->jumlahbonus->cellAttributes() ?>>
<span<?= $Page->jumlahbonus->viewAttributes() ?>>
<?= $Page->jumlahbonus->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <!-- harga -->
        <td<?= $Page->harga->cellAttributes() ?>>
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
        <!-- totalnondiskon -->
        <td<?= $Page->totalnondiskon->cellAttributes() ?>>
<span<?= $Page->totalnondiskon->viewAttributes() ?>>
<?= $Page->totalnondiskon->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
        <!-- diskonpayment -->
        <td<?= $Page->diskonpayment->cellAttributes() ?>>
<span<?= $Page->diskonpayment->viewAttributes() ?>>
<?= $Page->diskonpayment->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
        <!-- bbpersen -->
        <td<?= $Page->bbpersen->cellAttributes() ?>>
<span<?= $Page->bbpersen->viewAttributes() ?>>
<?= $Page->bbpersen->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <!-- totaltagihan -->
        <td<?= $Page->totaltagihan->cellAttributes() ?>>
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
        <!-- blackbonus -->
        <td<?= $Page->blackbonus->cellAttributes() ?>>
<span<?= $Page->blackbonus->viewAttributes() ?>>
<?= $Page->blackbonus->getViewValue() ?></span>
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
