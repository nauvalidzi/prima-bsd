<?php

namespace PHPMaker2021\distributor;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    $app->get('/getMax/{table}/{column}', function ($request, $response, $args) {
      	$column = $args['column'] ?? null;
      	$table = $args['table'] ?? null;
      	if ($column !== null && $table !== null) {
           	return $response->withJson(ExecuteRow("SELECT MAX(".$column.") FROM `".$table."`"));
      	} else {
      		return;
      	}
    });
    $app->get('/nextKodeNpd/{idCustomer}', function ($request, $response, $args) {
    	$idCustomer = $args['idCustomer'];
    	if ($idCustomer == null) {
    		return;
    	}
    	return $response->withJson(getNextKodeNpd($idCustomer));;
    });

//    $app->get('/jumlahKirimInvoice/{idOrderDetail}', function ($request, $response, $args) {
//    	$idOrderDetail = $args['idOrderDetail'];
//    	if ($idOrderDetail == null) { return; }
//    	$total = ExecuteRow("SELECT s.idorder_detail, s.jumlah jumlahkirim, p.harga, (s.jumlah*p.harga) total FROM stock s, product p WHERE s.idproduct = p.id AND s.idorder_detail=".$idOrderDetail);
//    	return $response->withJson($total);
//    });
    $app->get('/nextKode/{tipe}/{id}', function ($request, $response, $args) {
    	$tipe = $args['tipe'];
    	$id = $args['id'];
    	$kode = getNextKode($tipe, $id);
        return $response->withJson($kode);
    });
    $app->get('/get/brandData/{idBrand}', function($request, $response, $args) {
    	$idBrand = $args['idBrand'];
    	$datas = ExecuteRow("SELECT b.logo, c.ktp, c.npwp, b.aktaperusahaan FROM customer c, brand b WHERE b.idcustomer = c.id AND b.id = ".$idBrand);
    	return $response->withJson($datas);
    });

    // dipanggil di npd_confirm
    $app->get('/get/dataReview/{idreview}', function($request, $response, $args) {
    	$idreview = $args['idreview'];
    	$datas = ExecuteRow("SELECT nama, ukuran from npd_review where id = ".$idreview);
    	return $response->withJson($datas);
    });

    // dipanggil di ijinbpom_detail
    $app->get('/get/finalKodeSample/{idnpd}', function($request, $response, $args) {
    	$idnpd = $args['idnpd'];
    	$kode = ExecuteRow("SELECT kode FROM npd_sample WHERE idnpd=".$idnpd." AND id IN (SELECT idnpd_sample FROM npd_harga WHERE idnpd=".$idnpd.")");
    	return $response->withJson($kode);
    });

    // dipanggil di ijinbpom
    $app->get('/ijinbpom/selesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$children = ExecuteQuery("select * from ijinbpom_detail where idijinbpom=".$id);
    	foreach ($children as $child) {
    		addNpdToProduct($child['idnpd']);
    	}
    	$update = ExecuteUpdate("UPDATE ijinbpom SET selesai=1, readonly=1, `status`='Selesai' WHERE id=".$id);
    	return $response->withJson(1);
    });
    $app->get('/ijinbpom/belumselesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$children = ExecuteQuery("select * from ijinbpom_detail where idijinbpom=".$id);
    	foreach ($children as $child) {
    		removeNpdFromProduct($child['idnpd']);
    	}
    	$update = ExecuteUpdate("UPDATE ijinbpom SET selesai=0 WHERE id=".$id);
    	updateStatus("ijinbpom", $id);
    	return $response->withJson(1);
    });

    // dipanggil di ijinbpom_detail
    $app->get('/ijinbpom_detail/selesai/{id}/{nama}', function($request, $response, $args) {
    	$id = $args['id'];
    	$nama = $args['nama'];
    	$idnpd = ExecuteScalar("SELECT idnpd FROM ijinbpom_detail WHERE id = ".$id);
    	addNpdToProduct2($idnpd, $nama);
    	$updatedetail = ExecuteUpdate("UPDATE ijinbpom_detail SET selesai = 1, namaalt = '".addslashes($nama)."' WHERE id = ".$id);
    	return $response->withJson(1);
    });
    $app->get('/ijinbpom_detail/belumselesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$idnpd = ExecuteScalar("SELECT idnpd FROM ijinbpom_detail WHERE id = ".$id);
    	removeNpdFromProduct($idnpd);
    	$updatedetail = ExecuteUpdate("UPDATE ijinbpom_detail SET selesai = 0 WHERE id = ".$id);
    	return $response->withJson(1);
    });

    // dipanggil di npd
    $app->get('/npd/selesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$npdharga = ExecuteScalar("SELECT COUNT(*) FROM npd_harga WHERE disetujui=1 AND idnpd=".$id);
    	if ($npdharga) {
    		$update = ExecuteUpdate("UPDATE npd SET selesai=1, `status`='Selesai' WHERE id=".$id);
    		return $response->withJson(1);
    	} else {
    		return $response->withJson("Belum ada permintaan harga yang disetujui.");
    	}
    });
    $app->get('/npd/belumselesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$update = ExecuteUpdate("UPDATE npd SET selesai=0 WHERE id=".$id);
    	updateStatus("npd", $id);
    	return $response->withJson(1);
    });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}
$API_ACTIONS["getTagihan"] = function(Request $request, Response &$response) {
	$vars = Param("idcustomer", Route(1));
    if ($vars !== NULL) {
        $idcustomer = AdjustSql($vars);
        $status = true;
        $message = null;
        $limitpoaktif_default = 2;
        $existing_tagihan = cek_po_aktif($idcustomer);
        if ($existing_tagihan > $limitpoaktif_default) {
            $approval = ExecuteRow("SELECT limit_kredit, limit_po_aktif FROM po_limit_approval WHERE idcustomer = {$idcustomer} AND aktif = 1");
            if ($approval) {
                if ($existing_tagihan > $approval['limit_po_aktif']) {
                    $message = "P.O. berikut melebihi P.O. aktif dari pengajuan approval.";
                    $status = false;
                } else {
                    $message = null;
                    return true;
                }
            }
            $message = "P.O. berikut melebihi jumlah P.O. aktif sebelumnya.<br />Silakan mengajukan approval ke atasan untuk proses khusus.";
            $status = false;
        }
        WriteJson(compact('status', 'message'));
    }
};

function get_po_id($cust_id) {
	return ExecuteRow("SELECT id FROM po_limit_approval WHERE aktif = 1 AND idcustomer = {$cust_id} ORDER BY id DESC LIMIT 1");
}

function domain() {
	return sprintf(
    	"%s://%s/bsd/",
    	isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    	$_SERVER['SERVER_NAME']
    );
}

// dipanggil di deliveryorder_detail, invoice_detail
function addStock($idorderdetail, $jumlah) {
	$idProduct = ExecuteScalar("SELECT idproduct FROM order_detail WHERE id = ".$idorderdetail);
    $id = ExecuteScalar("SELECT id FROM stock WHERE idorder_detail = ".$idorderdetail);
    if ($id != null) {
    	$myResult = ExecuteUpdate("UPDATE stock SET jumlah = IFNULL(jumlah,0)+(".$jumlah."), idproduct=".$idProduct." WHERE id = ".$id);
    } else {
    	$myResult = ExecuteUpdate("INSERT INTO stock (idorder_detail, idproduct, jumlah) VALUES (".$idorderdetail.", ".$idProduct.", ".$jumlah.")");
    }
}

// dipanggil di deliveryorder_detail
function checkCloseOrder($idOrderDetail) {
	$data = ExecuteRow("SELECT idorder, sisa FROM order_detail WHERE id=".$idOrderDetail);
	$update = ExecuteUpdate("UPDATE order_detail SET aktif=".($data['sisa'] > 0 ? 1 : 0)." WHERE id=".$idOrderDetail);
	$orderAktif = ExecuteScalar("SELECT COUNT(id) FROM order_detail WHERE aktif=1 and idorder=".$data['idorder']);
	$update = ExecuteUpdate("UPDATE `order` SET aktif=".($orderAktif > 0 ? 1 : 0)." WHERE id=".$data['idorder']);
}

// dipanggil di invoice_detail, redeem_bonus
function addBlackBonus($idCustomer, $jumlah) {
//	$update = ExecuteUpdate("UPDATE customer SET budget_bonus_rp=IFNULL(budget_bonus_rp,0)+(".$jumlah.") WHERE id=".$idCustomer);
}

// dipanggil di pembayaran
function checkCloseInvoice($idinvoice) {
	$sisaBayar = ExecuteScalar("SELECT sisabayar FROM invoice WHERE id=".$idinvoice);
	if ($sisaBayar <= 0) {
		$update = ExecuteUpdate("UPDATE invoice SET aktif=0 WHERE id=".$idinvoice);
	} else {
		$update = ExecuteUpdate("UPDATE invoice SET aktif=1 WHERE id=".$idinvoice);
	}
}

// dipanggil di invoice_detail
function updateInvoice($idInvoice) {
	$oldInvoice = ExecuteRow("SELECT * FROM invoice WHERE id=".$idInvoice);
	$updateInvoice = ExecuteUpdate("UPDATE invoice SET totalnonpajak=(SELECT IFNULL(SUM(totaltagihan), 0) FROM invoice_detail WHERE idinvoice=".$idInvoice."), totaltagihan=totalnonpajak+((pajak/100)*totalnonpajak), sisabayar=totaltagihan WHERE id=".$idInvoice);

//	$newInvoice = ExecuteRow("SELECT * FROM invoice WHERE id=".$idInvoice);
//	$selisih = $newInvoice['totaltagihan']-$oldInvoice['totaltagihan'];
//	$sisaBayar = $oldInvoice['sisabayar']
//	$updateSisaBayar = ExecuteUpdate("UPDATE invoice SET sisabayar=".." WHERE id=".$idInvoice);
}

// dipanggil di deliveryorder_detail
function checkReadOnly($table, $id) {
	$readOnly = 0;
	if ($table == "order") {
		$hasDelivery = ExecuteScalar("SELECT count(id) FROM deliveryorder_detail WHERE idorder=".$id);
		$readOnly = ($hasDelivery > 0 ? 1 : 0);
		$updateReadOnly = ExecuteUpdate("UPDATE `".$table."` SET readonly=".$readOnly." WHERE id=".$id);
	} elseif ($table == "order_detail") {
		$hasDelivery = ExecuteScalar("SELECT count(id) FROM deliveryorder_detail WHERE idorder_detail=".$id);
		$readOnly = ($hasDelivery > 0 ? 1 : 0);
		$updateReadOnly = ExecuteUpdate("UPDATE `".$table."` SET readonly=".$readOnly." WHERE id=".$id);
	} elseif ($table == "invoice") {
		$hasPayment = ExecuteScalar("SELECT count(id) FROM pembayaran WHERE idinvoice=".$id);
		$readOnly = ($hasPayment > 0 ? 1 : 0);
		$updateReadOnly = ExecuteUpdate("UPDATE `".$table."` SET readonly=".$readOnly." WHERE id=".$id);
	}
}

// dipanggil di npd_status, ijinhaki_status, ijinbpom_status
function updateStatus($table, $id) {
	if ($table = "npd") {
		updateStatusNpd($id);
		return;
	}
	$status = ExecuteScalar("SELECT COUNT(*) FROM ".$table."_status WHERE id".$table."=".$id);
	$updateReadOnly = ExecuteUpdate("UPDATE `".$table."` SET readonly=".($status > 0 ? 1 : 0)." WHERE id=".$id);
	if ($status > 0) {
		$updateStatus = ExecuteUpdate("update `".$table."` SET `status`=(SELECT `status` FROM ".$table."_status WHERE id".$table."=".$id." order BY created_at desc LIMIT 1) WHERE id=".$id);
	} else {
		$updateStatus = ExecuteUpdate("update `".$table."` SET `status`='Baru' WHERE id=".$id);
	}
}

function updateStatusNpd($id) {
	$status = ExecuteRow("SELECT * FROM (SELECT ns.`status`, ns.created_at FROM npd_status ns WHERE ns.idnpd=".$id." UNION SELECT if(nsa.`status`=1, 'Sample Diterima', if(nsa.`status`=-1, 'Sample Ditolak', 'Sample Belum Direview')) `status`, nsa.created_at FROM npd_sample nsa WHERE nsa.idnpd=".$id." UNION SELECT if(nr.`status`=1, 'Review Diterima', if(nr.`status`=-1, 'DROP NPD', 'Revisi Sample')) `status`, nr.created_at FROM npd_review nr WHERE nr.idnpd=".$id." UNION SELECT if(nc.idnpd_sample IS NOT NULL, 'Sample Dikonfirmasi', 'Sample Belum Dikonfirmasi') `status`, nc.created_at FROM npd_confirm nc WHERE nc.idnpd=".$id." UNION SELECT if(nh.disetujui=1, 'Harga Disetujui', 'Harga Ditolak') `status`, nh.created_at FROM npd_harga nh WHERE nh.idnpd=".$id.") npdstatusss order BY created_at DESC LIMIT 1");
	if (!empty($status['status'])) {
		$updateReadOnly = ExecuteUpdate("UPDATE `npd` SET readonly=1 WHERE id=".$id);
		$updateStatus = ExecuteUpdate("update `npd` SET `status`='".$status['status']."' WHERE id=".$id);
	} else {
		$updateReadOnly = ExecuteUpdate("UPDATE `npd` SET readonly=0 WHERE id=".$id);
		$updateStatus = ExecuteUpdate("update `npd` SET `status`='Baru' WHERE id=".$id);
	}
}

function addNpdToProduct($idNpd) {
	$npd = ExecuteRow("SELECT n.idpegawai, n.idproduct, n.idbrand, n.kodeorder kode, id.nama, NULL satuan, n.ukuran netto, n.idkategoribarang, n.idjenisbarang, n.idkualitasbarang, 1 aktif, 1 ijinbpom, n.idproduct_acuan, n.bahan, n.ukuran, nh.hargapcs harga, n.warna, n.parfum, n.tambahan, n.idkemasanbarang, n.label FROM npd n, npd_harga nh, ijinbpom_detail id WHERE n.id=nh.idnpd AND nh.disetujui=1 AND n.id=id.idnpd AND n.id=".$idNpd);
	if (empty($npd['idproduct'])) {
		$insert = ExecuteUpdate("INSERT INTO `product` (`idbrand`, `kode`, `nama`, `satuan`, `netto`, `idkategoribarang`, `idjenisbarang`, `idkualitasbarang`, `aktif`, `ijinbpom`, `idproduct_acuan`, `bahan`, `ukuran`, `harga`, `warna`, `parfum`, `tambahan`, `idkemasanbarang`, `label`, `created_by`) VALUES ('".$npd['idbrand']."', '".$npd['kode']."', '".addslashes($npd['nama'])."', '".$npd['satuan']."', '".$npd['netto']."', '".$npd['idkategoribarang']."', '".$npd['idjenisbarang']."', '".$npd['idkualitasbarang']."', '".$npd['aktif']."', '".$npd['ijinbpom']."', '".$npd['idproduct_acuan']."', '".$npd['bahan']."', '".$npd['ukuran']."', '".$npd['harga']."', '".$npd['warna']."', '".addslashes($npd['parfum'])."', '".$npd['tambahan']."', '".$npd['idkemasanbarang']."', '".$npd['label']."', '".$npd['idpegawai']."')");
		$update = ExecuteUpdate("UPDATE npd SET idproduct=(select id from product where kode='".$npd['kode']."' limit 1) WHERE id=".$idNpd);
	} else {
		$update = ExecuteUpdate("UPDATE product SET aktif=1, ijinbpom=1, nama='".addslashes($npd['nama'])."', harga='".$npd['harga']."', ukuran='".$npd['ukuran']."' WHERE id=".$npd['idproduct']);
	}
}

function addNpdToProduct2($idNpd, $nama) {
	$npd = ExecuteRow("SELECT n.idpegawai, n.idproduct, n.idbrand, n.kodeorder kode, id.nama, NULL satuan, n.ukuran netto, n.idkategoribarang, n.idjenisbarang, n.idkualitasbarang, 1 aktif, 1 ijinbpom, n.idproduct_acuan, n.bahan, n.ukuran, nh.hargapcs harga, n.warna, n.parfum, n.tambahan, n.kemasanbarang, n.label FROM npd n, npd_harga nh, ijinbpom_detail id WHERE n.id=nh.idnpd AND nh.disetujui=1 AND n.id=id.idnpd AND n.id=".$idNpd);
	if (empty($npd['idproduct'])) {
		$insert = ExecuteUpdate("INSERT INTO `product` (`idbrand`, `kode`, `nama`, `satuan`, `netto`, `idkategoribarang`, `idjenisbarang`, `idkualitasbarang`, `aktif`, `ijinbpom`, `idproduct_acuan`, `bahan`, `ukuran`, `harga`, `warna`, `parfum`, `tambahan`, `kemasanbarang`, `label`, `created_by`) VALUES ('".$npd['idbrand']."', '".$npd['kode']."', '".addslashes($nama)."', '".$npd['satuan']."', '".$npd['netto']."', '".$npd['idkategoribarang']."', '".$npd['idjenisbarang']."', '".$npd['idkualitasbarang']."', '".$npd['aktif']."', '".$npd['ijinbpom']."', '".$npd['idproduct_acuan']."', '".$npd['bahan']."', '".$npd['ukuran']."', '".$npd['harga']."', '".$npd['warna']."', '".addslashes($npd['parfum'])."', '".$npd['tambahan']."', '".$npd['kemasanbarang']."', '".$npd['label']."', '".$npd['idpegawai']."')");
		$update = ExecuteUpdate("UPDATE npd SET idproduct=(select id from product where kode='".$npd['kode']."' limit 1) WHERE id=".$idNpd);
	} else {
		$update = ExecuteUpdate("UPDATE product SET aktif=1, ijinbpom=1, nama='".addslashes($nama)."', harga='".$npd['harga']."', ukuran='".$npd['ukuran']."', kemasanbarang='".$npd['kemasanbarang']."' WHERE id=".$npd['idproduct']);
	}
}

function removeNpdFromProduct($idNpd) {
	$update = ExecuteUpdate("UPDATE product SET aktif=0, ijinbpom=0 WHERE id=(SELECT idproduct FROM npd WHERE id=".$idNpd.")");
}

// UNTUK API
function getNextKodeNpd($idCustomer) {
	$kode = ExecuteScalar("SELECT kodenpd FROM customer WHERE id = ".$idCustomer);
    $kode = "TM-".$kode."-";
   	$maxKode = ExecuteScalar("SELECT MAX(kodeorder) FROM npd WHERE kodeorder LIKE '".$kode."%'");
   	if ($maxKode == null) {
   		return $kode."001";
   	} else {
		$temp = explode("-", $maxKode);
   		$nominal = (intval(end($temp)))+1;
   		if($nominal <= 9) {
   			$kode = $kode."00".$nominal;
   		} else if ($nominal > 9 && $nominal <= 99) {
   			$kode = $kode."0".$nominal;
   		} else {
   			$kode = $kode.$nominal;
   		}
   	}
    return $kode;
}

function getNextKode($tipe, $id) {
    if ($tipe == null) { return; }
    $kode = $column = $table = "";
   	if ($tipe == "pegawai") {
   		$table = "pegawai";
   		$column = "kode";
   		$kode = "PEG-";
   	} elseif ($tipe == "customer") {
   		$table = "customer";
   		$column = "kode";
   		$kode = "LD. ";
   	} elseif ($tipe == "order") {
   		$table = "`order`";
   		$column = "kode";
   		$kode = "PO-";
   	} elseif ($tipe == "deliveryorder") {
   		$table = "deliveryorder";
   		$column = "kode";
   		$kode = "FD-";
   	} elseif ($tipe == "invoice") {
   		$table = "invoice";
   		$column = "kode";
   		$kode = "BSD-";
   	} elseif ($tipe == "suratjalan") {
   		$table = "suratjalan";
   		$column = "kode";
   		$kode = "SJ-";
   	} elseif ($tipe == "pembayaran") {
   		$table = "pembayaran";
   		$column = "kode";
   		$kode = "PB-";
   	}
   	$maxKode = ExecuteScalar("SELECT MAX(".$column.") FROM ".$table);
   	if ($maxKode == null) {
   		$kode = $kode."0001";
   	} else {
   		$pecah = explode("-", $maxKode);
   		if ($tipe == "customer") {
   			$pecah = explode(" ", $maxKode);
   		}
   		$nominal = intval(end($pecah))+1;
   		if($nominal <= 9) {
   			$kode = $kode."000".$nominal;
   		} else if ($nominal > 9 && $nominal <= 99) {
   			$kode = $kode."00".$nominal;
   		} else if ($nominal > 99 && $nominal <= 999) {
   			$kode = $kode."0".$nominal;
   		} else {
   			$kode = $kode.$nominal;
   		}
   	}
   	return $kode;
}

function check_count_brand($idcustomer) {
	$count = ExecuteScalar("SELECT COUNT(*) FROM brand_link WHERE idcustomer = {$idcustomer} AND idcustomer_brand = {$idcustomer}");
	if ($count < 1) {
		return true;
	}
	return false;
}

function tgl_indo($tanggal, $format='date'){
	$bulan = array (
		1 => 'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
	$pecahkan2 = explode(' ', $pecahkan[2]);
	if ($format == 'datetime'){
		return $pecahkan2[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0] .  ' ' . $pecahkan2[1];
	}
	return $pecahkan2[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function cek_po_aktif($idcustomer) {
    $tagihan_belumlunas = ExecuteRow("SELECT COUNT(*) AS jumlah FROM (SELECT totaltagihan, IFNULL(SUM(jumlahbayar),0) AS jumlahbayar FROM pembayaran WHERE idcustomer = {$idcustomer} GROUP BY idinvoice, totaltagihan) bayar WHERE jumlahbayar < totaltagihan");
    $tagihan_belumbayar = ExecuteRow("SELECT COUNT(*) AS jumlah FROM invoice WHERE idcustomer = {$idcustomer} AND aktif = 1 AND id NOT IN (SELECT idinvoice FROM pembayaran)");
    return $tagihan_belumlunas['jumlah'] + $tagihan_belumbayar['jumlah'];
}
