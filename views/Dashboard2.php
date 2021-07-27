<?php

namespace PHPMaker2021\distributor;

// Page object
$Dashboard2 = &$Page;
?>
<?php
$piutangs = ExecuteQuery("SELECT * FROM d_jatuhtempo WHERE (idpegawai=".CurrentUserID()." OR idpegawai IN (SELECT id FROM pegawai WHERE pid=".CurrentUserID().")) AND sisahari<7 ORDER BY sisahari")->fetchAll();

$customers = ExecuteScalar("SELECT count(id) FROM customer WHERE aktif = 1");
$product = ExecuteScalar("SELECT count(id) FROM product WHERE aktif = 1");
$npd = ExecuteScalar("SELECT count(id) FROM npd");
$do = ExecuteScalar("SELECT count(id) FROM deliveryorder");
?>
<div class="row">
	<div class="col-lg-3 col-xs-6">
	  <div class="small-box bg-blue">
	    <div class="inner">
	      <h3><?php echo $customers ?></h3>
	      <p>Pelanggan</p>
	    </div>
	    <div class="icon">
	      <i class="fa fa-users"></i>
	    </div>
	    <a href="CustomerList" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
	  </div>
	</div>
	<div class="col-lg-3 col-xs-6">
	  <div class="small-box bg-green">
	    <div class="inner">
	      <h3><?php echo $product ?></h3>
	      <p>Produk</p>
	    </div>
	    <div class="icon">
	      <i class="fa fa-cubes"></i>
	    </div>
	    <a href="ProductList" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
	  </div>
	</div>
	<div class="col-lg-3 col-xs-6">
	  <div class="small-box bg-yellow">
	    <div class="inner">
	      <h3><?php echo $npd ?></h3>
	      <p>Pengembangan Produk</p>
	    </div>
	    <div class="icon">
	      <i class="fa fa-dice"></i>
	    </div>
	    <a href="NpdList" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
	  </div>
	</div>
	<div class="col-lg-3 col-xs-6">
	  <div class="small-box bg-red">
	    <div class="inner">
	      <h3><?php echo $do ?></h3>
	      <p>Delivery Order</p>
	    </div>
	    <div class="icon">
	      <i class="fa fa-truck-loading"></i>
	    </div>
	    <a href="DeliveryorderList" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
	  </div>
	</div>
</div>
<hr>

<h4>Jatuh Tempo Minggu Ini & Lewat</h4>

<table class="table ew-table">
    <thead>
        <tr class="ew-table-header">
            <th>Marketing</th>
            <th>Customer</th>
            <th>Kode Invoice</th>
            <th>Sisa Bayar</th>
            <th>Jatuh Tempo</th>
        </tr>
    </thead>

    <tbody>
    	<?php
    	if (count($piutangs) > 0) {
    		foreach ($piutangs as $piutang) {
    	?>
    	<tr>
            <td><?= $piutang['namapegawai'] ?></td>
            <td><?= $piutang['namacustomer'] ?></td>
            <td><?= $piutang['kodeinvoice'] ?></td>
            <td>Rp. <?= number_format($piutang['sisabayar']) ?></td>
            <?php
            $tempo = "";
            switch($piutang['sisahari']) {
            	case -1: $tempo = "Kemarin"; break;
            	case 0: $tempo = "Hari ini"; break;
            	case 1: $tempo = "Besok"; break;
            	case 2: $tempo = "Lusa"; break;
            	default: $tempo = date("d M Y", strtotime($piutang['jatuhtempo']));;
            }
            ?>
            <td><?= $tempo ?></td>
        </tr>
    	<?php
    		}
    	} else {
    	?>
    		<tr>
    			<td colspan=5>Tidak ada data.</td>
    		</tr>
    	<?php
    	}
        ?>
    </tbody>

    <!-- <tfoot>
        <tr class="ew-table-footer">
            <# if (linkOnLeft) { #>
            {{{list_options}}}
            <# } #>
            <# for (let f of currentFields) { #>
            <td>{{{<#= f.FldParm #>}}}</td>
            <# } #>
            <# if (!linkOnLeft) { #>
            {{{list_options}}}
            <# } #>
        </tr>
    </tfoot> -->
</table>


<?= GetDebugMessage() ?>
