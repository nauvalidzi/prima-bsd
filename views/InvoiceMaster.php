<?php

namespace PHPMaker2021\production2;

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
<?php if (!EmptyString($invoice->idorder->getViewValue()) && $invoice->idorder->linkAttributes() != "") { ?>
<a<?= $invoice->idorder->linkAttributes() ?>><?= $invoice->idorder->getViewValue() ?></a>
<?php } else { ?>
<?= $invoice->idorder->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->totalnonpajak->Visible) { // totalnonpajak ?>
        <tr id="r_totalnonpajak">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->totalnonpajak->caption() ?></td>
            <td <?= $invoice->totalnonpajak->cellAttributes() ?>>
<span id="el_invoice_totalnonpajak">
<span<?= $invoice->totalnonpajak->viewAttributes() ?>>
<?= $invoice->totalnonpajak->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->pajak->Visible) { // pajak ?>
        <tr id="r_pajak">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->pajak->caption() ?></td>
            <td <?= $invoice->pajak->cellAttributes() ?>>
<span id="el_invoice_pajak">
<span<?= $invoice->pajak->viewAttributes() ?>>
<?= $invoice->pajak->getViewValue() ?></span>
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
<?php if ($invoice->idtermpayment->Visible) { // idtermpayment ?>
        <tr id="r_idtermpayment">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->idtermpayment->caption() ?></td>
            <td <?= $invoice->idtermpayment->cellAttributes() ?>>
<span id="el_invoice_idtermpayment">
<span<?= $invoice->idtermpayment->viewAttributes() ?>>
<?= $invoice->idtermpayment->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->idtipepayment->Visible) { // idtipepayment ?>
        <tr id="r_idtipepayment">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->idtipepayment->caption() ?></td>
            <td <?= $invoice->idtipepayment->cellAttributes() ?>>
<span id="el_invoice_idtipepayment">
<span<?= $invoice->idtipepayment->viewAttributes() ?>>
<?= $invoice->idtipepayment->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($invoice->keterangan->Visible) { // keterangan ?>
        <tr id="r_keterangan">
            <td class="<?= $invoice->TableLeftColumnClass ?>"><?= $invoice->keterangan->caption() ?></td>
            <td <?= $invoice->keterangan->cellAttributes() ?>>
<span id="el_invoice_keterangan">
<span<?= $invoice->keterangan->viewAttributes() ?>>
<?= $invoice->keterangan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
