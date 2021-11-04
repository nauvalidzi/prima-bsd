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
        $limit_kredit = 5000000; // DEFAULT LIMA Juta;
        $limit_poaktif = 3; // DEFAULT PO Aktif MAKSIMAL DUA P.O (Belum DIBAYAR/Belum LUNAS);

        // CEK TOTAL EXISTING TAGIHAN
        // $existing_tagihan = cek_totaltagihan_po_aktif($idcustomer);

        // CEK KREDIT APPROVAL
        $approval = get_approval($idcustomer);
        if ($approval) {
        	// $limit_kredit = $approval['sisalimitkredit'];
        	$limit_poaktif = $approval['limit_po_aktif'];
        }

        // if ($existing_tagihan > $limit_kredit) {
        //     if ($limit_kredit != 5000000) {
        //         $message = "Transaksi melebihi limit kredit dari pengajuan approval.";
        //         $status = false;
        //     }
        //     $message = "Transaksi melebihi limit yang di approve.<br />Silakan mengajukan approval khusus ke atasan.";
        //     $status = false;
        // }

        // CEK TAGIHAN BELUM LUNAS / BELUM BAYAR
        $existing_count_tagihan = cek_po_aktif($idcustomer);
        if ($existing_count_tagihan >= $limit_poaktif) {
            if ($limit_poaktif > 3) {
                $message = "P.O. berikut melebihi P.O. aktif dari pengajuan approval.<br />Limit P.O. Aktif sebanyak {$limit_poaktif}";
                $status = false;
            }
            $message = "P.O. berikut melebihi jumlah P.O. aktif sebelumnya.<br />Silakan mengajukan approval ke atasan untuk proses khusus.<br />Limit P.O. Aktif sebanyak {$limit_poaktif}";
            $status = false;
        }
        WriteJson(compact('status', 'message'));
    }
};

function get_approval($cust_id) {
	return ExecuteRow("SELECT * FROM po_limit_approval WHERE aktif = 1 AND idcustomer = {$cust_id} ORDER BY id DESC");
}

function status_delivery($iddeliveryorder, $detail = "undetail") {
    $conditions = ($detail != "detail") ? " AND dd.iddeliveryorder = '{$iddeliveryorder}'" : " AND dd.id = '{$iddeliveryorder}'";
    $row = ExecuteRow("SELECT SUM(od.sisa) AS totalsisa FROM deliveryorder_detail dd JOIN order_detail od ON od.id = dd.idorder_detail WHERE 1=1 {$conditions}");
    if ($row['totalsisa'] > 0) {
        return 'Belum Lengkap';
    }
    return 'Lengkap';
}

function status_orders($idorder) {
    $row = ExecuteRow("SELECT SUM(od.jumlah) AS jumlah, SUM(od.bonus) AS bonus, SUM(od.sisa) AS sisa FROM `order` o JOIN order_detail od ON o.id = od.idorder WHERE o.id = '{$idorder}'");
    $totalorder = $row['jumlah'] + $row['bonus'];
    if ($row['sisa'] < 1) {
        return 'Sudah Proses DO';
    }
    if ($row['sisa'] == $totalorder) {
        return 'Belum Proses DO';
    }
    return 'Proses DO Sebagian';
}

function status_pembayaran($idinvoice) {
    $row = ExecuteRow("SELECT SUM(sisabayar) AS sisabayar, totaltagihan FROM invoice WHERE id = '{$idinvoice}' GROUP BY id");
    if ($row['sisabayar'] < 1) {
        return 'Lunas';
    }
    if ($row['sisabayar'] == $row['totaltagihan']) {
        return 'Belum Lunas';
    }
    return 'Lunas Sebagian';
}

function get_kodeorder($idorder) {
    return ExecuteRow("SELECT kode FROM `order` WHERE id = '{$idorder}'")['kode'];
}

//-- FUNGSI TERBILANG --//
function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil;
}
//!-- FUNGSI TERBILANG --//

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
    switch ($format) {
        case 'datetime':
            return date('d', strtotime($tanggal)) . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . date('Y', strtotime($tanggal)) .  ' ' . date('H:i:s', strtotime($tanggal));
            break;
        case 'month-year':
            return $bulan[ (int)$pecahkan[1] ] . ' ' . date('Y', strtotime($tanggal));
            break;
        default:
            return date('d', strtotime($tanggal)) . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . date('Y', strtotime($tanggal));
            break;
    }
}

function cek_po_aktif($idcustomer) {
    return ExecuteRow("SELECT COUNT(*) AS jumlah
                    FROM (
                    SELECT idorder AS idorder, idcustomer
                    FROM invoice
                    WHERE sisabayar > 0 
                    UNION
                    SELECT `order`.id AS idorder, idcustomer
                    FROM `order`
                    JOIN order_detail ON `order`.id = order_detail.idorder AND order_detail.sisa > 0
                    LEFT JOIN stock ON stock.idorder_detail = order_detail.id AND stock.jumlah > 0
                    GROUP BY `order`.id
                    ) po_aktif
                    WHERE idcustomer = {$idcustomer}
                ")['jumlah'];    
}

function cek_totaltagihan_po_aktif($idcustomer) {
    return ExecuteRow("SELECT tagihan AS totaltagihan
                    FROM (
                    SELECT idorder, idcustomer, sisabayar AS tagihan
                    FROM invoice
                    WHERE sisabayar > 0
                    UNION
                    SELECT `order`.id AS idorder, idcustomer, 
                     SUM(((ifnull(stock.jumlah,0) + order_detail.sisa) - bonus) * harga) AS tagihan
                    FROM `order` 
                    JOIN order_detail ON `order`.id = order_detail.idorder
                    LEFT JOIN stock ON stock.idorder_detail = order_detail.id
                    GROUP BY `order`.id
                    ) po_aktif WHERE idcustomer = {$idcustomer}
                ")['totaltagihan'];
}

/*
CATATAN TRANSAKSI PENJUALAN
order baru => order.aktif = 1 & order.readonly = 0
order masuk do, kirim sebagian => order.aktif = 1 & order.readonly = 1
order masuk do, dengan jumlah penuh => order.aktif = 0 & order.readonly = 1 & do.readonly = 0
order masuk invoice => do.readonly = 1 & invoice.aktif = 1 & invoice.readonly = 0 & invoice.sent = 0
order masuk surat jalan => invoice.sent = 1
order masuk bayar sebagian => invoice.aktif = 1 & invoice.readonly = 1 invoice.sent = 0
order masuk bayar lunas => invoice.aktif = 0
*/
function rupiah($number, $decimal='with-decimal') {
    if (!is_numeric($number)) {
        return "Bad Format!";
    }
    if ($number < 1000) {
        return $number;
    }
    switch ($decimal) {
        case 'without-decimal':
            return number_format($number, 0, ",", ".");
            break;
        default:
            return number_format($number, 2, ",", ".");
            break;
    }
}

function base_url() {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https://" : "http://";
    $script = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    return $protocol . $_SERVER['HTTP_HOST'] . $script;
}

function check_kpi_existing($idpegawai, $bulan) {
	$check = ExecuteRow("SELECT COUNT(*) as jumlah FROM kpi_marketing WHERE idpegawai = {$idpegawai} AND bulan = '".date('Y-m-01', strtotime($bulan))."'");
    if ($check['jumlah'] > 0) {
        return false;
    } 
    return true;
}

function penomoran($format)	{
	if (strpos($format, "%YEAR") !== false) {
		$format = str_replace("%YEAR", date('Y'), $format);
	}
	if (strpos($format, "%MONTH") !== false) {
		$format = str_replace("%MONTH", date('m'), $format);
	}
	if (strpos($format, "%DATE") !== false) {
		$format = str_replace("%DATE", date('d'), $format);
	}
	if (strpos($format, "%URUTAN") !== false) {
		$nomor = 1;
		if (empty($nomor)) $nomor = 0;
		$format = str_replace("%URUTAN", str_pad(ltrim($nomor, '0')+1, 5, '0', STR_PAD_LEFT), $format);
	}
	return $format;
}

function curl_post($url, $data, $url_auth=""){
    // Prepare new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Authentication PHPMAKER
    // $url_auth = 'http://localhost/pabrik/api/login?username=admin&password=admin123';
    $token = null;
    if (!empty($url_auth)) {
        $token = json_decode(curl_get($url_auth), true)['JWT'];
        $token = "X-Authorization: {$token}";
    }

    // Set HTTP Header for POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        $token
    ));

    // Submit the POST request
    $result = curl_exec($ch);

    // Close cURL session handle
    curl_close($ch);     
    return $result;
}

function curl_get($url){
    // persiapan curl
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    return $output;
}
$API_ACTIONS['goto-reminder'] = function(Request $request, Response &$response) {
    $items = Param("items", Route(2));
    if (empty($items)) {
        echo json_encode([]); die;
    }
    $status = true;
    $data = explode(',', urldecode($items));
    foreach ($data as $value) { 
        $row = ExecuteRow("SELECT * FROM v_penagihan WHERE idorder = '{$value}'");
        $totalumurfaktur = $row['umur_faktur'] - $row['term_payment'];
        if ($totalumurfaktur < 0) {
            $message = "Yth {$row['nama_customer']}, Selamat Siang kami dari CV.Beautie Surya Derma menyampaikan tentang adanya Faktur yang akan jatuh tempo dalam beberapa hari kedepan untuk mohon dapat dibantu pembayarannya.
                \nNo Faktur : {$row['kode_faktur']}
                \nNilai Faktur : Rp {$row['nilai_faktur']}
                \nJatuh Tempo : {$row['jatuhtempo']}
                \nMohon dapat diinformasikan kembali ke kami di Nomor ini apabila sudah ditransfer, dan mohon abaikan chat ini apabila sudah ditransfer.
                \nTerimakasih atas kesetiaan dan kepercayaannya kepada kami. Semoga {$row['nama_customer']} sehat selalu";
        }
        if ($totalumurfaktur => 0 && $totalumurfaktur <= 7) {
            $message = "Yth {$row['nama_customer']}, Selamat Siang kami dari CV.Beautie Surya Derma menginformasikan Tagihan Faktur sbb:
                \nNo Faktur : {$row['kode_faktur']}
                \nNilai Faktur : Rp {$row['nilai_faktur']}
                \nJatuh Tempo : {$row['jatuhtempo']}
                \nPembayaran bisa melalui transfer rekening BCA 8290977593 a/n. Suryo Sudibyo SE, dan utk memudahkan proses tracking serta menghindari penagihan kembali mohon pd saat transfer diberi keterangan “Nama_Klinik_Merek_Nomor Faktur”.
                \nApabila sudah ditransfer mohon dapat di informasikan ke nomor ini juga.
                \nTerimakasih atas kerjasama dan kepercayaannya kepada kami. Semoga {$row['nama_customer']} sehat selalu";
        }
        if ($totalumurfaktur > 7) {
            $message = "Yth {$row['nama_customer']}, Selamat Siang kami dari CV.Beautie Surya Derma mengingatkan kembali Tagihan Faktur sbb:
                \nNo Faktur : {$row['kode_faktur']}
                \nNilai Faktur : Rp {$row['nilai_faktur']}
                \nJatuh Tempo : {$row['jatuhtempo']}
                \nPembayaran bisa melalui transfer rekening BCA 8290977593 a/n. Suryo Sudibyo SE, dan utk memudahkan proses tracking serta menghindari penagihan kembali mohon pd saat transfer diberi keterangan “Nama_Klinik_Merek_Nomor Faktur”.
                \nApabila sudah ditransfer mohon dapat di informasikan ke nomor ini juga.
                \nTerimakasih atas kerjasama dan kepercayaannya kepada kami. Semoga {$row['nama_customer']} sehat selalu";
        }
        $insert = ExecuteUpdate("INSERT INTO penagihan (tgl_order, kode_order, nama_customer, nomor_handphone, nilai_po, tgl_faktur, nilai_faktur, piutang, umur_faktur, tgl_antrian, messages) VALUES ('{$row['tgl_order']}', '{$row['kode_order']}', '{$row['nama_customer']}', '{$row['nomor_handphone']}', '{$row['nilai_po']}', '{$row['tgl_faktur']}', '{$row['nilai_faktur']}', '{$row['piutang']}', '{$row['umur_faktur']}', '".date('Y-m-d H:i:s')."', '{$message}')");
        if (!$insert) $status = false;
    }
    WriteJson(['status' => $status]);
};
$API_ACTIONS['action-reminder'] = function(Request $request, Response &$response) {
    $id = urldecode(Param("id", Route(2)));
    $type = urldecode(Param("type", Route(1)));
    $process = true;
    if ($type == 'cancel') {
        $status = '-1';
        $date_cancel = ", tgl_cancel = '".date('Y-m-d H:i:s')."'";
    } else {
        $status = '0';
        $date_cancel = null;
    }
    $row = ExecuteUpdate("UPDATE penagihan SET status = '{$status}' {$date_cancel} WHERE id = {$id}");
    if (!$row) {
        $process = false;
    }
    WriteJson(['status' => $process]);
};
$API_ACTIONS['notif-pembayaran'] = function(Request $request, Response &$response) {
    $faktur = urldecode(Param("faktur", Route(1)));
    $status = 0;
    if (empty($faktur)) {
        echo json_encode([]); die;
    }
    $row = ExecuteRow("SELECT i.kode as no_faktur, c.nama as nama_customer, c.hp as nomor_handphone FROM invoice i JOIN customer c ON c.id = i.idcustomer WHERE i.kode = '{$faktur}'");
    if (!empty($row['nomor_handphone']) or strlen($row['nomor_handphone']) <= 10) {
        $send = json_encode([
            'to' => $row['nomor_handphone'],
            'message' => "Selamat siang {$row['nama_customer']}. Pembayaran Faktur No. {$row['no_faktur']} sudah kami terima. Terima kasih atas kerjasamanya. Semoga {$row['nama_customer']} sehat selalu.",
        ]);
        $status = 1;
    }
    ExecuteUpdate("INSERT INTO bot_history (tanggal, prop_code, prop_name, status, created_by) VALUES ('".date('Y-m-d H:i:s')."', '{$row['kodeorder']}', 'Notifikasi Pembayaran Faktur {$row['nomor_handphone']}', {$status}, ".CurrentUserID().")");
};
