<?php

namespace PHPMaker2021\distributor;

// Table
$po_limit_approval_detail = Container("po_limit_approval_detail");
?>
<?php if ($po_limit_approval_detail->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_po_limit_approval_detailmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($po_limit_approval_detail->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $po_limit_approval_detail->TableLeftColumnClass ?>"><?= $po_limit_approval_detail->id->caption() ?></td>
            <td <?= $po_limit_approval_detail->id->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_id">
<span<?= $po_limit_approval_detail->id->viewAttributes() ?>>
<?= $po_limit_approval_detail->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval_detail->idapproval->Visible) { // idapproval ?>
        <tr id="r_idapproval">
            <td class="<?= $po_limit_approval_detail->TableLeftColumnClass ?>"><?= $po_limit_approval_detail->idapproval->caption() ?></td>
            <td <?= $po_limit_approval_detail->idapproval->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_idapproval">
<span<?= $po_limit_approval_detail->idapproval->viewAttributes() ?>>
<?= $po_limit_approval_detail->idapproval->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval_detail->idorder->Visible) { // idorder ?>
        <tr id="r_idorder">
            <td class="<?= $po_limit_approval_detail->TableLeftColumnClass ?>"><?= $po_limit_approval_detail->idorder->caption() ?></td>
            <td <?= $po_limit_approval_detail->idorder->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_idorder">
<span<?= $po_limit_approval_detail->idorder->viewAttributes() ?>>
<?= $po_limit_approval_detail->idorder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval_detail->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <tr id="r_kredit_terpakai">
            <td class="<?= $po_limit_approval_detail->TableLeftColumnClass ?>"><?= $po_limit_approval_detail->kredit_terpakai->caption() ?></td>
            <td <?= $po_limit_approval_detail->kredit_terpakai->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_kredit_terpakai">
<span<?= $po_limit_approval_detail->kredit_terpakai->viewAttributes() ?>>
<?= $po_limit_approval_detail->kredit_terpakai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval_detail->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $po_limit_approval_detail->TableLeftColumnClass ?>"><?= $po_limit_approval_detail->created_at->caption() ?></td>
            <td <?= $po_limit_approval_detail->created_at->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_created_at">
<span<?= $po_limit_approval_detail->created_at->viewAttributes() ?>>
<?= $po_limit_approval_detail->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
