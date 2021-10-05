// User event handlers
ew.events = {
    "order": {
        "x_idcustomer": { // keys = event types, values = handler functions
                "change": function(e) {
                    var kodecust = e.target.value;
                    if (kodecust) {
                        $(document).Toasts('remove');
                        $.get("api/getTagihan?idcustomer="+kodecust, function(res) {
                            if (res.status == false) {
                                $(document).Toasts('create', {
                                     class: 'ew-toast bg-danger',
                                     title: 'Error',
                                     delay: 7500,
                                     autohide: true,
                                     body: res.message,
                                 });
                            }
                        });
                    }
                }
            }
    },
    "order_detail": {
        "x_jumlah": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var jumlah = parseInt($('#'+prefix+'_jumlah').val()) || 0;
                    var bonus = parseInt($('#'+prefix+'_bonus').val()) || 0;
                    $('#'+prefix+'_sisa').val(jumlah+bonus);
                    var harga = parseInt($('#'+prefix+'_harga').val()) || 0;
                    $('#'+prefix+'_total').val(harga*jumlah);
                }
            },
        "x_bonus": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var jumlah = parseInt($('#'+prefix+'_jumlah').val()) || 0;
                    var bonus = parseInt($('#'+prefix+'_bonus').val()) || 0;
                    $('#'+prefix+'_sisa').val(jumlah+bonus);
                }
            },
        "x_harga": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var jumlah = parseInt($('#'+prefix+'_jumlah').val()) || 0;
                    var harga = parseInt($('#'+prefix+'_harga').val()) || 0;
                    $('#'+prefix+'_total').val(harga*jumlah);
                }
            }
    },
    "deliveryorder_detail": {
        "x_jumlahkirim": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var jumlahkirim = parseInt($('#'+prefix+'_jumlahkirim').val()) || 0;
                    var sisa = parseInt($('#'+prefix+'_sisa').val()) || 0;
                    if (jumlahkirim > sisa) {
                        $('#'+prefix+'_jumlahkirim').val(sisa);
                    }
                }
            }
    },
    "invoice_detail": {
        "x_idorder_detail": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
            //        var prefix = this.id.split('_')[0];
            //        setTimeout(function() {
            //            $('#'+prefix+'_totalnondiskon').change();
            //        }, 500);
                }
            },
        "x_jumlahkirim": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var jumlahorder = parseInt($('#'+prefix+'_jumlahorder').val()) || 0;
                    var stockdo = parseInt($('#'+prefix+'_stockdo').val()) || 0;
                    var jumlahkirim = parseInt($('#'+prefix+'_jumlahkirim').val()) || 0;
                    var harga = parseInt($('#'+prefix+'_harga').val()) || 0;
                    if (jumlahkirim < 0 || jumlahkirim > stockdo) {
                        jumlahkirim = stockdo;
                        $('#'+prefix+'_jumlahkirim').val(stockdo);
                    }
                    if (jumlahkirim > jumlahorder) {
                        jumlahkirim = jumlahorder;
                        $('#'+prefix+'_jumlahkirim').val(jumlahorder);
                    }
                    $('#'+prefix+'_totalnondiskon').val(harga*jumlahkirim).change();
                    $('#'+prefix+'_jumlahbonus').val(stockdo-jumlahkirim).change();
                }
            },
        "x_harga": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var jumlahkirim = parseInt($('#'+prefix+'_jumlahkirim').val()) || 0;
                    var harga = parseInt($('#'+prefix+'_harga').val()) || 0;
                    var bonus = parseFloat($('#'+prefix+'_bonus').val()) || 0;
                    $('#'+prefix+'_totalnondiskon').val(harga*jumlahkirim).change();
                }
            },
        "x_totalnondiskon": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var totalnondiskon = parseInt($('#'+prefix+'_totalnondiskon').val()) || 0;
                    var diskonpayment = parseFloat($('#'+prefix+'_diskonpayment').val()) || 0;
                    var bbpersen = parseFloat($('#'+prefix+'_bbpersen').val()) || 0;
                    var totaltagihan = totalnondiskon - (totalnondiskon*(diskonpayment/100));
                    var blackbonus = (totalnondiskon*(bbpersen/100));
                    $('#'+prefix+'_totaltagihan').val(totaltagihan).change();
                    $('#'+prefix+'_blackbonus').val(blackbonus).change();
                }
            },
        "x_diskonpayment": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var totalnondiskon = parseInt($('#'+prefix+'_totalnondiskon').val()) || 0;
                    var diskonpayment = parseFloat($('#'+prefix+'_diskonpayment').val()) || 0;
                    var bbpersen = parseFloat($('#'+prefix+'_bbpersen').val()) || 0;
                    var totaltagihan = totalnondiskon - (totalnondiskon*(diskonpayment/100));
                    var blackbonus = (totalnondiskon*(bbpersen/100));
                    $('#'+prefix+'_totaltagihan').val(totaltagihan).change();
                    $('#'+prefix+'_blackbonus').val(blackbonus).change();
                }
            },
        "x_bbpersen": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    var prefix = this.id.split('_')[0];
                    var totalnondiskon = parseInt($('#'+prefix+'_totalnondiskon').val()) || 0;
                    var bbpersen = parseFloat($('#'+prefix+'_bbpersen').val()) || 0;
                    var blackbonus = (totalnondiskon*(bbpersen/100));
                    $('#'+prefix+'_blackbonus').val(blackbonus).change();
                }
            }
    },
    "pembayaran": {
        "x_jumlahbayar": { // keys = event types, values = handler functions
                "change": function(e) {
                    var sisatagihan = parseInt($('#x_sisatagihan').val()) || 0;
                    var jumlahbayar = parseInt($('#x_jumlahbayar').val()) || 0;
                    if (jumlahbayar > sisatagihan) {
                        $('#x_jumlahbayar').val(sisatagihan);
                    }
                }
            }
    },
    "kpi_marketing": {
        "x_target": { // keys = event types, values = handler functions
                "change": function(e) {
                    // Your code
                    $(this).toLocaleString('id-ID', { timeZone: 'UTC' }));
                }
            }
    }
};

// Chart user configurations
ew.charts = {
};

// Global client script
ew.clientScript = function() {
    // Write your global client script here, no need to add script tags.
};

// Global startup script
ew.startupScript = function() {
    loadjs.ready("jquery",(function(){$(".ew-add-form").on("keydown","input, select",(function(e){var t,n;if("Enter"===e.key)return(n=(t=$(this).parents("form:eq(0)").find("input,select,textarea").filter(":visible")).eq(t.index(this)+1)).length?n.focus():e.preventDefault(),!1}))}));
};