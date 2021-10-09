<?php

namespace PHPMaker2021\distributor;

// Page object
$Dashboard2 = &$Page;
?>
<?php
$curr_year = date('Y');
$curr_month = date('m');
$query_kpi = "SELECT p.id as idpegawai, p.nama AS namapegawai, 
                IFNULL(kpi_marketing.target,0) AS target,
                SUM(IFNULL(po.totalpenjualan,0)) AS totalpenjualan
              FROM pegawai p
              LEFT JOIN (
                SELECT idpegawai, SUM(order_detail.total) AS totalpenjualan, `order`.tanggal
                FROM `order`
                JOIN order_detail ON order_detail.idorder = `order`.id
                WHERE YEAR(`order`.tanggal ) = '{$curr_year}' AND MONTH(`order`.tanggal ) = '{$curr_month}'
                GROUP BY `order`.id
              ) po ON p.id = po.idpegawai
              LEFT JOIN kpi_marketing ON kpi_marketing.idpegawai = p.id 
              AND YEAR(kpi_marketing.bulan) = '{$curr_year}' AND MONTH(kpi_marketing.bulan) = '{$curr_month}'
              GROUP BY p.id, kpi_marketing.target";

$query_kpi = ExecuteQuery($query_kpi)->fetchAll();

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

<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="10">Bulan <?php echo date('F Y') ?></th>
        </tr>
        <tr>
            <th class="text-center" width="5%">No. </th>
            <th class="text-center" width="40%%">Marketing</th>
            <th class="text-center" width="20%">Target</th>
            <th class="text-center" width="20%">Penjualan</th>
            <th class="text-center" width="15%">&#37;</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($query_kpi) > 0) : ?>
        <?php $i=0; ?>
        <?php foreach ($query_kpi as $kpi) : ?>
        <tr>
            <td class="text-center"><?php echo $i+1; ?></td>
            <td><?php echo $kpi['namapegawai']; ?></td>
            <td>Rp. <span class="float-right"><?php echo rupiah($kpi['target']); ?></span></td>
            <td>Rp. <span class="float-right"><?php echo rupiah($kpi['totalpenjualan']); ?></span></td>
            <td class="text-center"><?php echo ($kpi['totalpenjualan'] > 0 && $kpi['target'] > 0) ? round(($kpi['totalpenjualan'] / $kpi['target']) * 100 ) : 0; ?>&#37;</td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= GetDebugMessage() ?>
