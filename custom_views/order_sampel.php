<?php
    namespace PHPMaker2021\distributor;
    // include_once "autoload.php";
    if(isset($order_pengembangan_add)) $cs_produk_order_edit=$cs_produk_order_add;
    if(isset($order_pengembangan_view)) $cs_produk_order_edit=$cs_produk_order_view;
    $setDisposisi ='xxx';
    $sethide    = 'display:none;';
    $id         = $cs_produk_order_edit->id->CurrentValue;
    $status     = $cs_produk_order_edit->status_data->CurrentValue;
    $status_view = getRef('development',$status);
    
    $oLabel = FALSE;
    $oKemasprimer = FALSE;
    $oHargaRND = FALSE;
    $oTargetHarga = FALSE;
    $oBahanSendiri = FALSE;
    $oDelivery = FALSE;
    
    
    $target='';
    $htotal='display:none';
    $hrnd ='display:none';
    if(menuSet('set_harga_order')!=''){
        $hrnd='';
        $htotal ='';
        $oTargetHarga = TRUE;
        $oBahanSendiri = TRUE;
    }elseif(menuSet('set_rnd')!=''){
        $hrnd='';
        $oHargaRND = true;
        $oBahanSendiri = TRUE;
    }elseif(menuSet('set_pd_disposisi')!=''){
        $htotal='';
        $oTargetHarga = TRUE;
    }elseif(menuSet('set_pd_operator')!=''){
        
    }else{
         $htotal ='';
    }


?>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_aju_tgl")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_aju_oleh")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_proses_tgl")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_proses_oleh")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_revisi_tgl")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_revisi_oleh")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_rnd_tgl")/}}</span>
<span style="display:none;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_rnd_oleh")/}}</span>
<div class="card">
    <div class="card-body">
        <table class="table table-sm table-bordered">            
            <thead>                
                
            </thead>
            <tbody>
                <tr>
                    <td colspan="8">
                        <table style="" class="table table-sm  table-borderless">
                            <tr><td colspan="12"><strong>{{include tmpl=~getTemplate("#tpx_cs_produk_order_cpo_jenis")/}}</strong></td></tr>
                            <tr>
                                <td style="border-left:solid .1px;border-top:solid .1px; " width="2%"></td>
                                <td style="border-top:solid .1px; " width="12%">Kode Customer</td>
                                <td style="border-top:solid .1px; " width="1%">:</td>
                                <td style="border-top:solid .1px; " width="20%">{{include tmpl=~getTemplate("#tpx_cs_produk_order_custcode")/}}</td>
                                <td style="border-top:solid .1px; " width="2%"></td>
                                <td style="border-top:solid .1px; " width="12%">No. Order</td>
                                <td style="border-top:solid .1px; " width="1%">:</td>
                                <td style="border-top:solid .1px; " width="15%">{{include tmpl=~getTemplate("#tpx_cs_produk_order_ordernum")/}}</td>
                                <td style="border-top:solid .1px; " width="2%"></td>
                                <td style="border-top:solid .1px; " width="12%">Tanggal Order</td>
                                <td style="border-top:solid .1px; " width="1%">:</td>
                                <td style="border-top:solid .1px;border-right:solid .1px; ">{{include tmpl=~getTemplate("#tpx_cs_produk_order_ordertgl")/}}</td>
                            </tr>
                            <tr>
                                <td style="border-left:solid .1px;border-bottom: solid .1px; "></td>
                                <td style="border-bottom:solid .1px; ">Kode Order</td>
                                <td style="border-bottom:solid .1px; ">:</td>
                                <td style="border-bottom:solid .1px; "></td>
                                <td style="border-bottom:solid .1px; "></td>
                                <td style="border-bottom:solid .1px; ">Status</td>
                                <td style="border-bottom:solid .1px; ">:</td>
                                <td style="border-bottom:solid .1px; "><strong><?=$status_view?></strong></td>
                                <td style="border-bottom:solid .1px; "></td>
                                <td style="border-bottom:solid .1px; ">Target Selesai</td>
                                <td style="border-bottom:solid .1px; ">:</td>
                                <td style="border-bottom:solid .1px;border-right: solid .1px; "></td>
                            </tr>
                        </table>
                    </td>                     
                </tr>
                <tr>
                    <th colspan="8">A. KONSEP PRODUK</th>
                </tr>
                <tr>
                    <td width="2%" rowspan="6">&nbsp;</td>
                    <td width="20%"><?php echo $cs_produk_order_edit->bencmark->caption() ?></td>
                    <td width="1%">:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bencmark")/}}</td>                  
                </tr>
                <tr>
                    <td><?php echo $cs_produk_order_edit->kategoriproduk->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_kategoriproduk")/}}</td>
                </tr>
                <tr>
                    <td><?php echo $cs_produk_order_edit->jenisproduk->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_jenisproduk")/}}</td>
                </tr>
                <tr>
                    <td><?php echo $cs_produk_order_edit->produk_fungsi->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_produk_fungsi")/}}</td>
                </tr>
                <tr>
                    <td><?php echo $cs_produk_order_edit->produk_kualitas->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_produk_kualitas")/}}</td>
                </tr>
                 <tr>
                    <td><?php echo $cs_produk_order_edit->produk_campaign->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_produk_campaign")/}}</td>
                </tr>
                <tr>
                    <th colspan="8">B. BENTUK SEDIAAN</th>
                </tr>
                <tr>
                    <td rowspan="12"></td> 
                    <td style="text-align:right"><?php echo $cs_produk_order_edit->sediaan_ukuran->caption() ?></td>
                    <td>:</td>
                    <td>{{include tmpl=~getTemplate("#tpx_cs_produk_order_sediaan_ukuran")/}}</td>
                    <td colspan="4">{{include tmpl=~getTemplate("#tpx_cs_produk_order_sediaan_ukuran_satuan")/}}</td>
                </tr>
                <tr>
                    <td style="text-align:right">Bentuk</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bentuksediaan")/}}</td>
                </tr>
                <tr>
                    <td style="text-align:right"><?php echo $cs_produk_order_edit->produk_viskositas->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_produk_viskositas")/}}</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:right"><?php echo $cs_produk_order_edit->warna->caption() ?></td>
                    <td rowspan="2">:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_warna")/}}</td>
                </tr>
                <tr>                    
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_produk_warna_jenis")/}}</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:right"><?php echo $cs_produk_order_edit->fragrance->caption() ?></td>
                    <td rowspan="2">:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_fragrance")/}}</td>
                </tr>
                <tr>                    
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_aroma")/}}</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:right"><?php echo $cs_produk_order_edit->aplikasi_sediaan->caption() ?></td>
                    <td rowspan="2">:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_aplikasi_sediaan")/}}</td>
                </tr>
                <tr>                    
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" style="text-align:right"><?php echo $cs_produk_order_edit->aksesoris->caption() ?></td>
                    <td rowspan="2">:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_aksesoris")/}}</td>
                </tr>
                <tr>                    
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:right"><?php echo $cs_produk_order_edit->produk_lainlain->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_produk_lainlain")/}}</td>
                </tr>
<?php if($oHargaRND)     {           ?>
                <tr>
                    <td></td>
                    <td style="text-align:right"><?php echo $cs_produk_order_edit->harga_rnd->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_harga_rnd")/}}</td>
                </tr>
<?php    }           ?>
<!--Kemasan Primer-->
                <tr>
                    <th colspan="8">C. KEMASAN PRIMER</th>
                </tr>
                <tr>
                    <td rowspan="6"></td> 
                    <td style="text-align:right"><?php echo $cs_produk_order_edit->ukuran->caption() ?></td>
                    <td>:</td>
                    <td>{{include tmpl=~getTemplate("#tpx_cs_produk_order_ukuran")/}}</td>
                    <td colspan="4">{{include tmpl=~getTemplate("#tpx_cs_produk_order_kemasan_ukuran_satuan")/}}</td>
                </tr>
                <tr>
                    <td style="text-align:right"><u>Wadah/Tempat</u></td>
                    <td colspan="6">&nbsp;</td>                   
                </tr>
                <tr>
                    <td style="text-align:right">Bentuk</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_kemasan")/}}</td>
                </tr>
                <tr>
                    <td style="text-align:right"><u>Tutup</u></td>
                    <td colspan="6">&nbsp;</td>                   
                </tr>
                <tr>
                    <td style="text-align:right">Bentuk</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_jenistutup")/}}</td>
                </tr>
                <tr>
                    <td style="text-align:right">Catatan Lain</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_catatan")/}}</td>
                </tr>
<!--Label-->
                <tr>
                    <th colspan="8">D. LABEL</th>
                </tr>
                <tr>
                    <td rowspan="5"></td> 
                    <td style="text-align:right">Ukuran</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_label_ukuran")/}}</td>
                </tr>
                <tr>
                    <td style="text-align:right">Bahan</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_infolabel")/}}</td>                   
                </tr>
                 <tr>
                    <td style="text-align:right">Kualitas</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_labelkualitas")/}}</td>                   
                </tr>
                 <tr>
                    <td style="text-align:right">Posisi</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_labelposisi")/}}</td>                   
                </tr>
                 <tr>
                    <td style="text-align:right">Catatan Lain</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_labelcatatan")/}}</td>                   
                </tr>
<!--Sifat Order-->                
                <tr>
                    <th colspan="8">E. SIFAT ORDER</th>
                </tr>
                <tr>  
                    <td></td>                 
                    <td><?php echo $cs_produk_order_edit->statusproduk->caption() ?></td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_statusproduk")/}}</td>
                </tr>
                <tr>
                    <td colspan="8">
                        <table class="table table-sm">
                            <tr style="<?=$target?>">
                                <th colspan="8">F. TARGET HARGA & PROYEKSI</th>                                
                            </tr>
                            <tr>                                
                                <td width="50%">
                                    <table class="table table-sm">
                                        <tr tyle="<?=$target?>">                                            
                                            <td width="42%">Ukuran Utama</td>
                                            <td width="1%">:</td>
                                            <td width="20%"></td>
                                            <td>gram</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <table class="table table-sm table-bordered">
                                                    <tr>                                
                                                        <th width="45%">Target</th>
                                                        <th style="text-align: center;">Harga/pcs</th>
                                                        <th style="text-align: center;">Proyeksi</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga Isi</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_isi")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_isi_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                        <td>Harga Kemasan Primer</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_primer")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_primer_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                          <td>Harga Kemasan Sekunder</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_sekunder")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_sekunder_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                        <td>Harga Label</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_label")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_label_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                         <td>Harga Total</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_total")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_total_pro")/}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table class="table table-sm">
                                        <tr tyle="<?=$target?>">                                            
                                            <td width="42%">Ukuran Lain</td>
                                            <td width="1%">:</td>
                                            <td width="20%"></td>
                                            <td>gram</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <table class="table table-sm table-bordered">
                                                    <tr>                                
                                                        <th width="45%">Target</th>
                                                        <th style="text-align: center;">Harga/pcs</th>
                                                        <th style="text-align: center;">Proyeksi</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga Isi</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_isi")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_isi_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                        <td>Harga Kemasan Primer</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_primer")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_primer_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                          <td>Harga Kemasan Sekunder</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_sekunder")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_sekunder_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                        <td>Harga Label</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_label")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_label_pro")/}}</td>
                                                    </tr>
                                                     <tr>
                                                         <td>Harga Total</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_total")/}}</td>
                                                        <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_total_pro")/}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
<?php if($oTargetHarga){?>
                <tr style="<?=$target?>">
                    <th colspan="8">F. TARGET HARGA & PROYEKSI</th>
                </tr>
                <tr tyle="<?=$target?>">
                    <td rowspan="2"></td>
                    <td>Ukuran Utama</td>
                    <td>:</td>
                    <td width="25%">xxx</td>
                    <td width="2%"></td>
                    <td width="20%">Ukuran Lain</td>
                    <td width="1%">:</td>
                    <td>&nbsp;</td>
                </tr>
                <tr style="<?=$target?>">
                    <td colspan="3">
                        <table  class="table table-sm table-bordered">
                            <tr>                                
                                <td width="45%">Target</td>
                                <td style="text-align: center;">Harga/pcs</td>
                                <td style="text-align: center;">Proyeksi</td>
                            </tr>
                            <tr>
                                <td>Harga Isi</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_isi")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_isi_pro")/}}</td>
                            </tr>
                             <tr>
                                <td>Harga Kemasan Primer</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_primer")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_primer_pro")/}}</td>
                            </tr>
                             <tr>
                                  <td>Harga Kemasan Sekunder</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_sekunder")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_kms_sekunder_pro")/}}</td>
                            </tr>
                             <tr>
                                <td>Harga Label</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_label")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_label_pro")/}}</td>
                            </tr>
                             <tr>
                                 <td>Harga Total</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_total")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hu_hrg_total_pro")/}}</td>
                            </tr>
                        </table>
                    </td>                    
                    <td></td>

                    <td colspan="2">Target                        
                    </td>                    
                    <td>
                        <table class="table table-sm">
                            <tr>                                                                
                                <td style="text-align: center;">Harga/pcs</td>
                                <td style="text-align: center;">Proyeksi</td>
                            </tr>
                            <tr>                                
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_isi")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_isi_pro")/}}</td>
                            </tr>
                             <tr>                                
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_kms_primer")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_kms_primer_pro")/}}</td>
                            </tr>
                             <tr>                                  
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_kms_sekunder")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_kms_sekunder_pro")/}}</td>
                            </tr>
                             <tr>                                
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_label")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_label_pro")/}}</td>
                            </tr>
                             <tr>                                 
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_total")/}}</td>
                                <td style="text-align: right;">{{include tmpl=~getTemplate("#tpx_cs_produk_order_hl_hrg_total_pro")/}}</td>
                            </tr>
                        </table>                               
                    </td>
                </tr>
                <?php } ?>
<!--BAHAN SENDIRI--> 
<?php if($oBahanSendiri){?>
                <tr>
                    <th colspan="8">G. BAHAN-BAHAN SENDIRI</th>
                </tr>
                <tr>
                    <td rowspan="9"></td>
                    <td><u>ISI (SEDIAAN)</u></td>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td>Bahan Aktif</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_bahan_aktif")/}}</td>
                </tr>
                <tr>
                    <td>Bahan Lain-lain</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_bahan_lain")/}}</td>
                </tr>
                <tr>
                    <td>Parfum</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_parfum")/}}</td>
                </tr>
                <tr>
                    <td>Estetika</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_estetika")/}}</td>
                </tr>
                <tr>
                    <td><u>KEMASAN</u></td>                    
                    <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td>Wadah</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_kms_wadah")/}}</td>
                </tr>
                <tr>
                    <td>Tutup</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_kms_tutup")/}}</td>
                </tr>
                <tr>
                    <td>Kemasan Sekunder</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_bs_kms_sekunder")/}}</td>
                </tr>
<?php }?>               
<!--Delivery--> 
                <tr>
                    <td colspan="8">
                        <table class="table">
                            <tr>
                                <th colspan="8">H. DELIVERY</th>
                            </tr>
                            <tr>
                                <td width="2%" rowspan="4"></td>
                                <td width="20%">Pickup</td>
                                <td width="1%">:</td>
                                <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_dlv_pickup")/}}</td>
                            </tr>
                            <tr>                    
                                <td>Single Point</td>
                                <td>:</td>
                                <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_dlv_singlepoint")/}}</td>
                            </tr>
                            <tr>                    
                                <td>Multi Point</td>
                                <td>:</td>
                                <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_dlv_multipoint")/}}</td>
                            </tr>
                            <tr>                 
                                <td>Term Lain</td>
                                <td>:</td>
                                <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_dlv_term_lain")/}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>                
                
              <!--Catatan Lain-->
                <tr>
                    <th colspan="8">I. CATATAN KHUSUS</th>
                </tr>
                <tr>
                    <td rowspan="1"></td>
                    <td>Catatan</td>
                    <td>:</td>
                    <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_catatan_khusus")/}}</td>
                </tr>
            </tbody>
        </table>
        <?php if($setDisposisi!='') { ?>
        <table>
            <tr>
                <td>Tgl Penentuan</td>
                <td>:</td>
            </tr>
        </table>
        <?php } ?>
        <br>
        <table class="table table-sm">
            <tr>
                <td width="20%"><?php echo $cs_produk_order_edit->status_data->caption() ?></td>
                <td width="1%">:</td>
                <td colspan="5">{{include tmpl=~getTemplate("#tpx_cs_produk_order_status_data")/}}</td>
            </tr>
        </table>
    </div>
</div>