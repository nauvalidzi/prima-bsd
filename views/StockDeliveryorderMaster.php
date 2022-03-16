<?php

namespace PHPMaker2021\production2;

// Table
$stock_deliveryorder = Container("stock_deliveryorder");
?>
<?php if ($stock_deliveryorder->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_stock_deliveryordermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($stock_deliveryorder->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $stock_deliveryorder->TableLeftColumnClass ?>"><?= $stock_deliveryorder->kode->caption() ?></td>
            <td <?= $stock_deliveryorder->kode->cellAttributes() ?>>
<span id="el_stock_deliveryorder_kode">
<span<?= $stock_deliveryorder->kode->viewAttributes() ?>>
<?= $stock_deliveryorder->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_deliveryorder->tanggal->Visible) { // tanggal ?>
        <tr id="r_tanggal">
            <td class="<?= $stock_deliveryorder->TableLeftColumnClass ?>"><?= $stock_deliveryorder->tanggal->caption() ?></td>
            <td <?= $stock_deliveryorder->tanggal->cellAttributes() ?>>
<span id="el_stock_deliveryorder_tanggal">
<span<?= $stock_deliveryorder->tanggal->viewAttributes() ?>>
<?= $stock_deliveryorder->tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_deliveryorder->receipt_by->Visible) { // receipt_by ?>
        <tr id="r_receipt_by">
            <td class="<?= $stock_deliveryorder->TableLeftColumnClass ?>"><?= $stock_deliveryorder->receipt_by->caption() ?></td>
            <td <?= $stock_deliveryorder->receipt_by->cellAttributes() ?>>
<span id="el_stock_deliveryorder_receipt_by">
<span<?= $stock_deliveryorder->receipt_by->viewAttributes() ?>>
<?= $stock_deliveryorder->receipt_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_deliveryorder->lampiran->Visible) { // lampiran ?>
        <tr id="r_lampiran">
            <td class="<?= $stock_deliveryorder->TableLeftColumnClass ?>"><?= $stock_deliveryorder->lampiran->caption() ?></td>
            <td <?= $stock_deliveryorder->lampiran->cellAttributes() ?>>
<span id="el_stock_deliveryorder_lampiran">
<span<?= $stock_deliveryorder->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($stock_deliveryorder->lampiran, $stock_deliveryorder->lampiran->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_deliveryorder->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $stock_deliveryorder->TableLeftColumnClass ?>"><?= $stock_deliveryorder->created_at->caption() ?></td>
            <td <?= $stock_deliveryorder->created_at->cellAttributes() ?>>
<span id="el_stock_deliveryorder_created_at">
<span<?= $stock_deliveryorder->created_at->viewAttributes() ?>>
<?= $stock_deliveryorder->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
