<?php

namespace PHPMaker2021\distributor;

// Table
$product = Container("product");
?>
<?php if ($product->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_productmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($product->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $product->TableLeftColumnClass ?>"><?= $product->idbrand->caption() ?></td>
            <td <?= $product->idbrand->cellAttributes() ?>>
<span id="el_product_idbrand">
<span<?= $product->idbrand->viewAttributes() ?>>
<?= $product->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($product->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $product->TableLeftColumnClass ?>"><?= $product->kode->caption() ?></td>
            <td <?= $product->kode->cellAttributes() ?>>
<span id="el_product_kode">
<span<?= $product->kode->viewAttributes() ?>>
<?= $product->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($product->nama->Visible) { // nama ?>
        <tr id="r_nama">
            <td class="<?= $product->TableLeftColumnClass ?>"><?= $product->nama->caption() ?></td>
            <td <?= $product->nama->cellAttributes() ?>>
<span id="el_product_nama">
<span<?= $product->nama->viewAttributes() ?>>
<?= $product->nama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($product->kemasanbarang->Visible) { // kemasanbarang ?>
        <tr id="r_kemasanbarang">
            <td class="<?= $product->TableLeftColumnClass ?>"><?= $product->kemasanbarang->caption() ?></td>
            <td <?= $product->kemasanbarang->cellAttributes() ?>>
<span id="el_product_kemasanbarang">
<span<?= $product->kemasanbarang->viewAttributes() ?>>
<?= $product->kemasanbarang->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($product->harga->Visible) { // harga ?>
        <tr id="r_harga">
            <td class="<?= $product->TableLeftColumnClass ?>"><?= $product->harga->caption() ?></td>
            <td <?= $product->harga->cellAttributes() ?>>
<span id="el_product_harga">
<span<?= $product->harga->viewAttributes() ?>>
<?= $product->harga->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($product->ukuran->Visible) { // ukuran ?>
        <tr id="r_ukuran">
            <td class="<?= $product->TableLeftColumnClass ?>"><?= $product->ukuran->caption() ?></td>
            <td <?= $product->ukuran->cellAttributes() ?>>
<span id="el_product_ukuran">
<span<?= $product->ukuran->viewAttributes() ?>>
<?= $product->ukuran->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
