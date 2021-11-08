<?php

namespace PHPMaker2021\distributor;

// Page object
$Dashboard2 = &$Page;
?>
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

// ORDERS PENDING & UNCOMPLETE
$orders_unprocess = ExecuteRow("SELECT COUNT(DISTINCT idorder) AS total FROM order_detail WHERE sisa > 0")['total'];

// UNCOMPLETE / PENDING DELIVERY ORDER
$do_uncomplete = ExecuteRow("SELECT COUNT(DISTINCT dd.iddeliveryorder) as total FROM deliveryorder_detail dd JOIN order_detail od ON od.id = dd.idorder_detail WHERE od.sisa > 0")['total'];

// INVOICE UNPAID
$invoice_unpaid = ExecuteRow("SELECT COUNT(*) AS total FROM invoice WHERE sisabayar > 0")['total'];

// INVOICE UNSENT
$invoice_unsent = ExecuteRow("SELECT COUNT(*) AS total FROM invoice WHERE sent < 1")['total'];
?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?php echo $orders_unprocess ?></h3>
          <p>P.O. Unprocess</p>
        </div>
        <div class="icon">
          <i class="fa fa-cart-arrow-down"></i>
        </div>
        <a href="OrderList" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $do_uncomplete ?></h3>
          <p>Pending Delivery Orders</p>
        </div>
        <div class="icon">
          <i class="fas fa-dolly"></i>
        </div>
        <a href="DeliveryorderList" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $invoice_unpaid ?></h3>
          <p>Unpaid Invoices</p>
        </div>
        <div class="icon">
          <i class="fa fa-file-invoice"></i>
        </div>
        <a href="InvoiceList" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $invoice_unsent ?></h3>
          <p>Unsent Invoices</p>
        </div>
        <div class="icon">
          <i class="fa fa-truck-loading"></i>
        </div>
        <a href="InvoiceList" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <th class="text-center" width="40%">Marketing</th>
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


<?= GetDebugMessage() ?>
