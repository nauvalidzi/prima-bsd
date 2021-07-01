<?php

namespace PHPMaker2021\distributor;

// Table
$invoice = Container("invoice");
?>
<?php if ($invoice->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_invoicemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($invoice->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->kode->caption() ?></td>
            <td <?= $invoice->kode->cellAttributes() ?>>
<span id="el_invoice_kode">
<span<?= $invoice->kode->viewAttributes() ?>>
<?= $invoice->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->tglinvoice->Visible) { // tglinvoice ?>
        <tr id="r_tglinvoice">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->tglinvoice->caption() ?></td>
            <td <?= $invoice->tglinvoice->cellAttributes() ?>>
<span id="el_invoice_tglinvoice">
<span<?= $invoice->tglinvoice->viewAttributes() ?>>
<?= $invoice->tglinvoice->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->idcustomer->caption() ?></td>
            <td <?= $invoice->idcustomer->cellAttributes() ?>>
<span id="el_invoice_idcustomer">
<span<?= $invoice->idcustomer->viewAttributes() ?>>
<?= $invoice->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->idorder->Visible) { // idorder ?>
        <tr id="r_idorder">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->idorder->caption() ?></td>
            <td <?= $invoice->idorder->cellAttributes() ?>>
<span id="el_invoice_idorder">
<span<?= $invoice->idorder->viewAttributes() ?>>
<?= $invoice->idorder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->totaltagihan->Visible) { // totaltagihan ?>
        <tr id="r_totaltagihan">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->totaltagihan->caption() ?></td>
            <td <?= $invoice->totaltagihan->cellAttributes() ?>>
<span id="el_invoice_totaltagihan">
<span<?= $invoice->totaltagihan->viewAttributes() ?>>
<?= $invoice->totaltagihan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->sisabayar->Visible) { // sisabayar ?>
        <tr id="r_sisabayar">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->sisabayar->caption() ?></td>
            <td <?= $invoice->sisabayar->cellAttributes() ?>>
<span id="el_invoice_sisabayar">
<span<?= $invoice->sisabayar->viewAttributes() ?>>
<?= $invoice->sisabayar->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
