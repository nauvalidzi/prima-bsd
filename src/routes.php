<?php

namespace PHPMaker2021\production2;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // pegawai
    $app->any('/PegawaiList[/{id}]', PegawaiController::class . ':list')->add(PermissionMiddleware::class)->setName('PegawaiList-pegawai-list'); // list
    $app->any('/PegawaiAdd[/{id}]', PegawaiController::class . ':add')->add(PermissionMiddleware::class)->setName('PegawaiAdd-pegawai-add'); // add
    $app->any('/PegawaiView[/{id}]', PegawaiController::class . ':view')->add(PermissionMiddleware::class)->setName('PegawaiView-pegawai-view'); // view
    $app->any('/PegawaiEdit[/{id}]', PegawaiController::class . ':edit')->add(PermissionMiddleware::class)->setName('PegawaiEdit-pegawai-edit'); // edit
    $app->any('/PegawaiDelete[/{id}]', PegawaiController::class . ':delete')->add(PermissionMiddleware::class)->setName('PegawaiDelete-pegawai-delete'); // delete
    $app->group(
        '/pegawai',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PegawaiController::class . ':list')->add(PermissionMiddleware::class)->setName('pegawai/list-pegawai-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PegawaiController::class . ':add')->add(PermissionMiddleware::class)->setName('pegawai/add-pegawai-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PegawaiController::class . ':view')->add(PermissionMiddleware::class)->setName('pegawai/view-pegawai-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PegawaiController::class . ':edit')->add(PermissionMiddleware::class)->setName('pegawai/edit-pegawai-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PegawaiController::class . ':delete')->add(PermissionMiddleware::class)->setName('pegawai/delete-pegawai-delete-2'); // delete
        }
    );

    // userlevels
    $app->any('/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->any('/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->any('/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->any('/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->any('/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->any('/UserlevelpermissionsList[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->any('/UserlevelpermissionsAdd[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->any('/UserlevelpermissionsView[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->any('/UserlevelpermissionsEdit[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->any('/UserlevelpermissionsDelete[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // provinsi
    $app->any('/ProvinsiList[/{id}]', ProvinsiController::class . ':list')->add(PermissionMiddleware::class)->setName('ProvinsiList-provinsi-list'); // list
    $app->any('/ProvinsiAdd[/{id}]', ProvinsiController::class . ':add')->add(PermissionMiddleware::class)->setName('ProvinsiAdd-provinsi-add'); // add
    $app->any('/ProvinsiView[/{id}]', ProvinsiController::class . ':view')->add(PermissionMiddleware::class)->setName('ProvinsiView-provinsi-view'); // view
    $app->any('/ProvinsiEdit[/{id}]', ProvinsiController::class . ':edit')->add(PermissionMiddleware::class)->setName('ProvinsiEdit-provinsi-edit'); // edit
    $app->any('/ProvinsiDelete[/{id}]', ProvinsiController::class . ':delete')->add(PermissionMiddleware::class)->setName('ProvinsiDelete-provinsi-delete'); // delete
    $app->group(
        '/provinsi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ProvinsiController::class . ':list')->add(PermissionMiddleware::class)->setName('provinsi/list-provinsi-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ProvinsiController::class . ':add')->add(PermissionMiddleware::class)->setName('provinsi/add-provinsi-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ProvinsiController::class . ':view')->add(PermissionMiddleware::class)->setName('provinsi/view-provinsi-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ProvinsiController::class . ':edit')->add(PermissionMiddleware::class)->setName('provinsi/edit-provinsi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ProvinsiController::class . ':delete')->add(PermissionMiddleware::class)->setName('provinsi/delete-provinsi-delete-2'); // delete
        }
    );

    // kabupaten
    $app->any('/KabupatenList[/{id}]', KabupatenController::class . ':list')->add(PermissionMiddleware::class)->setName('KabupatenList-kabupaten-list'); // list
    $app->any('/KabupatenAdd[/{id}]', KabupatenController::class . ':add')->add(PermissionMiddleware::class)->setName('KabupatenAdd-kabupaten-add'); // add
    $app->any('/KabupatenView[/{id}]', KabupatenController::class . ':view')->add(PermissionMiddleware::class)->setName('KabupatenView-kabupaten-view'); // view
    $app->any('/KabupatenEdit[/{id}]', KabupatenController::class . ':edit')->add(PermissionMiddleware::class)->setName('KabupatenEdit-kabupaten-edit'); // edit
    $app->any('/KabupatenDelete[/{id}]', KabupatenController::class . ':delete')->add(PermissionMiddleware::class)->setName('KabupatenDelete-kabupaten-delete'); // delete
    $app->group(
        '/kabupaten',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KabupatenController::class . ':list')->add(PermissionMiddleware::class)->setName('kabupaten/list-kabupaten-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KabupatenController::class . ':add')->add(PermissionMiddleware::class)->setName('kabupaten/add-kabupaten-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KabupatenController::class . ':view')->add(PermissionMiddleware::class)->setName('kabupaten/view-kabupaten-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KabupatenController::class . ':edit')->add(PermissionMiddleware::class)->setName('kabupaten/edit-kabupaten-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KabupatenController::class . ':delete')->add(PermissionMiddleware::class)->setName('kabupaten/delete-kabupaten-delete-2'); // delete
        }
    );

    // kecamatan
    $app->any('/KecamatanList[/{id}]', KecamatanController::class . ':list')->add(PermissionMiddleware::class)->setName('KecamatanList-kecamatan-list'); // list
    $app->any('/KecamatanAdd[/{id}]', KecamatanController::class . ':add')->add(PermissionMiddleware::class)->setName('KecamatanAdd-kecamatan-add'); // add
    $app->any('/KecamatanView[/{id}]', KecamatanController::class . ':view')->add(PermissionMiddleware::class)->setName('KecamatanView-kecamatan-view'); // view
    $app->any('/KecamatanEdit[/{id}]', KecamatanController::class . ':edit')->add(PermissionMiddleware::class)->setName('KecamatanEdit-kecamatan-edit'); // edit
    $app->any('/KecamatanDelete[/{id}]', KecamatanController::class . ':delete')->add(PermissionMiddleware::class)->setName('KecamatanDelete-kecamatan-delete'); // delete
    $app->group(
        '/kecamatan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KecamatanController::class . ':list')->add(PermissionMiddleware::class)->setName('kecamatan/list-kecamatan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KecamatanController::class . ':add')->add(PermissionMiddleware::class)->setName('kecamatan/add-kecamatan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KecamatanController::class . ':view')->add(PermissionMiddleware::class)->setName('kecamatan/view-kecamatan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KecamatanController::class . ':edit')->add(PermissionMiddleware::class)->setName('kecamatan/edit-kecamatan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KecamatanController::class . ':delete')->add(PermissionMiddleware::class)->setName('kecamatan/delete-kecamatan-delete-2'); // delete
        }
    );

    // kelurahan
    $app->any('/KelurahanList[/{id}]', KelurahanController::class . ':list')->add(PermissionMiddleware::class)->setName('KelurahanList-kelurahan-list'); // list
    $app->any('/KelurahanAdd[/{id}]', KelurahanController::class . ':add')->add(PermissionMiddleware::class)->setName('KelurahanAdd-kelurahan-add'); // add
    $app->any('/KelurahanView[/{id}]', KelurahanController::class . ':view')->add(PermissionMiddleware::class)->setName('KelurahanView-kelurahan-view'); // view
    $app->any('/KelurahanEdit[/{id}]', KelurahanController::class . ':edit')->add(PermissionMiddleware::class)->setName('KelurahanEdit-kelurahan-edit'); // edit
    $app->any('/KelurahanDelete[/{id}]', KelurahanController::class . ':delete')->add(PermissionMiddleware::class)->setName('KelurahanDelete-kelurahan-delete'); // delete
    $app->group(
        '/kelurahan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KelurahanController::class . ':list')->add(PermissionMiddleware::class)->setName('kelurahan/list-kelurahan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KelurahanController::class . ':add')->add(PermissionMiddleware::class)->setName('kelurahan/add-kelurahan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KelurahanController::class . ':view')->add(PermissionMiddleware::class)->setName('kelurahan/view-kelurahan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KelurahanController::class . ':edit')->add(PermissionMiddleware::class)->setName('kelurahan/edit-kelurahan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KelurahanController::class . ':delete')->add(PermissionMiddleware::class)->setName('kelurahan/delete-kelurahan-delete-2'); // delete
        }
    );

    // ekspedisi
    $app->any('/EkspedisiList[/{id}]', EkspedisiController::class . ':list')->add(PermissionMiddleware::class)->setName('EkspedisiList-ekspedisi-list'); // list
    $app->any('/EkspedisiAdd[/{id}]', EkspedisiController::class . ':add')->add(PermissionMiddleware::class)->setName('EkspedisiAdd-ekspedisi-add'); // add
    $app->any('/EkspedisiView[/{id}]', EkspedisiController::class . ':view')->add(PermissionMiddleware::class)->setName('EkspedisiView-ekspedisi-view'); // view
    $app->any('/EkspedisiEdit[/{id}]', EkspedisiController::class . ':edit')->add(PermissionMiddleware::class)->setName('EkspedisiEdit-ekspedisi-edit'); // edit
    $app->any('/EkspedisiDelete[/{id}]', EkspedisiController::class . ':delete')->add(PermissionMiddleware::class)->setName('EkspedisiDelete-ekspedisi-delete'); // delete
    $app->group(
        '/ekspedisi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', EkspedisiController::class . ':list')->add(PermissionMiddleware::class)->setName('ekspedisi/list-ekspedisi-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', EkspedisiController::class . ':add')->add(PermissionMiddleware::class)->setName('ekspedisi/add-ekspedisi-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', EkspedisiController::class . ':view')->add(PermissionMiddleware::class)->setName('ekspedisi/view-ekspedisi-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', EkspedisiController::class . ':edit')->add(PermissionMiddleware::class)->setName('ekspedisi/edit-ekspedisi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', EkspedisiController::class . ':delete')->add(PermissionMiddleware::class)->setName('ekspedisi/delete-ekspedisi-delete-2'); // delete
        }
    );

    // customer
    $app->any('/CustomerList[/{id}]', CustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('CustomerList-customer-list'); // list
    $app->any('/CustomerAdd[/{id}]', CustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('CustomerAdd-customer-add'); // add
    $app->any('/CustomerView[/{id}]', CustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('CustomerView-customer-view'); // view
    $app->any('/CustomerEdit[/{id}]', CustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('CustomerEdit-customer-edit'); // edit
    $app->any('/CustomerDelete[/{id}]', CustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('CustomerDelete-customer-delete'); // delete
    $app->any('/CustomerSearch', CustomerController::class . ':search')->add(PermissionMiddleware::class)->setName('CustomerSearch-customer-search'); // search
    $app->group(
        '/customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', CustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('customer/list-customer-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', CustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('customer/add-customer-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', CustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('customer/view-customer-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', CustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('customer/edit-customer-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', CustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('customer/delete-customer-delete-2'); // delete
            $group->any('/' . Config("SEARCH_ACTION") . '', CustomerController::class . ':search')->add(PermissionMiddleware::class)->setName('customer/search-customer-search-2'); // search
        }
    );

    // alamat_customer
    $app->any('/AlamatCustomerList[/{id}]', AlamatCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('AlamatCustomerList-alamat_customer-list'); // list
    $app->any('/AlamatCustomerAdd[/{id}]', AlamatCustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('AlamatCustomerAdd-alamat_customer-add'); // add
    $app->any('/AlamatCustomerView[/{id}]', AlamatCustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('AlamatCustomerView-alamat_customer-view'); // view
    $app->any('/AlamatCustomerEdit[/{id}]', AlamatCustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('AlamatCustomerEdit-alamat_customer-edit'); // edit
    $app->any('/AlamatCustomerDelete[/{id}]', AlamatCustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('AlamatCustomerDelete-alamat_customer-delete'); // delete
    $app->any('/AlamatCustomerPreview', AlamatCustomerController::class . ':preview')->add(PermissionMiddleware::class)->setName('AlamatCustomerPreview-alamat_customer-preview'); // preview
    $app->group(
        '/alamat_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', AlamatCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('alamat_customer/list-alamat_customer-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', AlamatCustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('alamat_customer/add-alamat_customer-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', AlamatCustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('alamat_customer/view-alamat_customer-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', AlamatCustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('alamat_customer/edit-alamat_customer-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', AlamatCustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('alamat_customer/delete-alamat_customer-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', AlamatCustomerController::class . ':preview')->add(PermissionMiddleware::class)->setName('alamat_customer/preview-alamat_customer-preview-2'); // preview
        }
    );

    // tipecustomer
    $app->any('/TipecustomerList[/{id}]', TipecustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('TipecustomerList-tipecustomer-list'); // list
    $app->any('/TipecustomerAdd[/{id}]', TipecustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('TipecustomerAdd-tipecustomer-add'); // add
    $app->any('/TipecustomerView[/{id}]', TipecustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('TipecustomerView-tipecustomer-view'); // view
    $app->any('/TipecustomerEdit[/{id}]', TipecustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('TipecustomerEdit-tipecustomer-edit'); // edit
    $app->any('/TipecustomerDelete[/{id}]', TipecustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('TipecustomerDelete-tipecustomer-delete'); // delete
    $app->group(
        '/tipecustomer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TipecustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('tipecustomer/list-tipecustomer-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TipecustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('tipecustomer/add-tipecustomer-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TipecustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('tipecustomer/view-tipecustomer-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TipecustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('tipecustomer/edit-tipecustomer-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TipecustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('tipecustomer/delete-tipecustomer-delete-2'); // delete
        }
    );

    // brand
    $app->any('/BrandList[/{id}]', BrandController::class . ':list')->add(PermissionMiddleware::class)->setName('BrandList-brand-list'); // list
    $app->any('/BrandAdd[/{id}]', BrandController::class . ':add')->add(PermissionMiddleware::class)->setName('BrandAdd-brand-add'); // add
    $app->any('/BrandView[/{id}]', BrandController::class . ':view')->add(PermissionMiddleware::class)->setName('BrandView-brand-view'); // view
    $app->any('/BrandEdit[/{id}]', BrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('BrandEdit-brand-edit'); // edit
    $app->any('/BrandDelete[/{id}]', BrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('BrandDelete-brand-delete'); // delete
    $app->group(
        '/brand',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', BrandController::class . ':list')->add(PermissionMiddleware::class)->setName('brand/list-brand-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', BrandController::class . ':add')->add(PermissionMiddleware::class)->setName('brand/add-brand-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', BrandController::class . ':view')->add(PermissionMiddleware::class)->setName('brand/view-brand-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', BrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('brand/edit-brand-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', BrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('brand/delete-brand-delete-2'); // delete
        }
    );

    // product
    $app->any('/ProductList[/{id}]', ProductController::class . ':list')->add(PermissionMiddleware::class)->setName('ProductList-product-list'); // list
    $app->any('/ProductAdd[/{id}]', ProductController::class . ':add')->add(PermissionMiddleware::class)->setName('ProductAdd-product-add'); // add
    $app->any('/ProductView[/{id}]', ProductController::class . ':view')->add(PermissionMiddleware::class)->setName('ProductView-product-view'); // view
    $app->any('/ProductEdit[/{id}]', ProductController::class . ':edit')->add(PermissionMiddleware::class)->setName('ProductEdit-product-edit'); // edit
    $app->any('/ProductDelete[/{id}]', ProductController::class . ':delete')->add(PermissionMiddleware::class)->setName('ProductDelete-product-delete'); // delete
    $app->any('/ProductSearch', ProductController::class . ':search')->add(PermissionMiddleware::class)->setName('ProductSearch-product-search'); // search
    $app->any('/ProductPreview', ProductController::class . ':preview')->add(PermissionMiddleware::class)->setName('ProductPreview-product-preview'); // preview
    $app->group(
        '/product',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ProductController::class . ':list')->add(PermissionMiddleware::class)->setName('product/list-product-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ProductController::class . ':add')->add(PermissionMiddleware::class)->setName('product/add-product-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ProductController::class . ':view')->add(PermissionMiddleware::class)->setName('product/view-product-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ProductController::class . ':edit')->add(PermissionMiddleware::class)->setName('product/edit-product-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ProductController::class . ':delete')->add(PermissionMiddleware::class)->setName('product/delete-product-delete-2'); // delete
            $group->any('/' . Config("SEARCH_ACTION") . '', ProductController::class . ':search')->add(PermissionMiddleware::class)->setName('product/search-product-search-2'); // search
            $group->any('/' . Config("PREVIEW_ACTION") . '', ProductController::class . ':preview')->add(PermissionMiddleware::class)->setName('product/preview-product-preview-2'); // preview
        }
    );

    // brand_customer
    $app->any('/BrandCustomerList[/{idbrand}/{idcustomer}]', BrandCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('BrandCustomerList-brand_customer-list'); // list
    $app->any('/BrandCustomerAdd[/{idbrand}/{idcustomer}]', BrandCustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('BrandCustomerAdd-brand_customer-add'); // add
    $app->any('/BrandCustomerPreview', BrandCustomerController::class . ':preview')->add(PermissionMiddleware::class)->setName('BrandCustomerPreview-brand_customer-preview'); // preview
    $app->group(
        '/brand_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idbrand}/{idcustomer}]', BrandCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('brand_customer/list-brand_customer-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{idbrand}/{idcustomer}]', BrandCustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('brand_customer/add-brand_customer-add-2'); // add
            $group->any('/' . Config("PREVIEW_ACTION") . '', BrandCustomerController::class . ':preview')->add(PermissionMiddleware::class)->setName('brand_customer/preview-brand_customer-preview-2'); // preview
        }
    );

    // satuan
    $app->any('/SatuanList[/{id}]', SatuanController::class . ':list')->add(PermissionMiddleware::class)->setName('SatuanList-satuan-list'); // list
    $app->any('/SatuanAdd[/{id}]', SatuanController::class . ':add')->add(PermissionMiddleware::class)->setName('SatuanAdd-satuan-add'); // add
    $app->any('/SatuanView[/{id}]', SatuanController::class . ':view')->add(PermissionMiddleware::class)->setName('SatuanView-satuan-view'); // view
    $app->any('/SatuanEdit[/{id}]', SatuanController::class . ':edit')->add(PermissionMiddleware::class)->setName('SatuanEdit-satuan-edit'); // edit
    $app->any('/SatuanDelete[/{id}]', SatuanController::class . ':delete')->add(PermissionMiddleware::class)->setName('SatuanDelete-satuan-delete'); // delete
    $app->group(
        '/satuan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SatuanController::class . ':list')->add(PermissionMiddleware::class)->setName('satuan/list-satuan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SatuanController::class . ':add')->add(PermissionMiddleware::class)->setName('satuan/add-satuan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SatuanController::class . ':view')->add(PermissionMiddleware::class)->setName('satuan/view-satuan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SatuanController::class . ':edit')->add(PermissionMiddleware::class)->setName('satuan/edit-satuan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SatuanController::class . ':delete')->add(PermissionMiddleware::class)->setName('satuan/delete-satuan-delete-2'); // delete
        }
    );

    // tipepayment
    $app->any('/TipepaymentList[/{id}]', TipepaymentController::class . ':list')->add(PermissionMiddleware::class)->setName('TipepaymentList-tipepayment-list'); // list
    $app->any('/TipepaymentAdd[/{id}]', TipepaymentController::class . ':add')->add(PermissionMiddleware::class)->setName('TipepaymentAdd-tipepayment-add'); // add
    $app->any('/TipepaymentView[/{id}]', TipepaymentController::class . ':view')->add(PermissionMiddleware::class)->setName('TipepaymentView-tipepayment-view'); // view
    $app->any('/TipepaymentEdit[/{id}]', TipepaymentController::class . ':edit')->add(PermissionMiddleware::class)->setName('TipepaymentEdit-tipepayment-edit'); // edit
    $app->any('/TipepaymentDelete[/{id}]', TipepaymentController::class . ':delete')->add(PermissionMiddleware::class)->setName('TipepaymentDelete-tipepayment-delete'); // delete
    $app->group(
        '/tipepayment',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TipepaymentController::class . ':list')->add(PermissionMiddleware::class)->setName('tipepayment/list-tipepayment-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TipepaymentController::class . ':add')->add(PermissionMiddleware::class)->setName('tipepayment/add-tipepayment-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TipepaymentController::class . ':view')->add(PermissionMiddleware::class)->setName('tipepayment/view-tipepayment-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TipepaymentController::class . ':edit')->add(PermissionMiddleware::class)->setName('tipepayment/edit-tipepayment-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TipepaymentController::class . ':delete')->add(PermissionMiddleware::class)->setName('tipepayment/delete-tipepayment-delete-2'); // delete
        }
    );

    // npd
    $app->any('/NpdList[/{id}]', NpdController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdList-npd-list'); // list
    $app->any('/NpdAdd[/{id}]', NpdController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdAdd-npd-add'); // add
    $app->group(
        '/npd',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdController::class . ':list')->add(PermissionMiddleware::class)->setName('npd/list-npd-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdController::class . ':add')->add(PermissionMiddleware::class)->setName('npd/add-npd-add-2'); // add
        }
    );

    // npd_serahterima
    $app->any('/NpdSerahterimaList[/{id}]', NpdSerahterimaController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdSerahterimaList-npd_serahterima-list'); // list
    $app->any('/NpdSerahterimaAdd[/{id}]', NpdSerahterimaController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdSerahterimaAdd-npd_serahterima-add'); // add
    $app->any('/NpdSerahterimaView[/{id}]', NpdSerahterimaController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdSerahterimaView-npd_serahterima-view'); // view
    $app->any('/NpdSerahterimaEdit[/{id}]', NpdSerahterimaController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdSerahterimaEdit-npd_serahterima-edit'); // edit
    $app->any('/NpdSerahterimaDelete[/{id}]', NpdSerahterimaController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdSerahterimaDelete-npd_serahterima-delete'); // delete
    $app->group(
        '/npd_serahterima',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdSerahterimaController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_serahterima/list-npd_serahterima-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdSerahterimaController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_serahterima/add-npd_serahterima-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdSerahterimaController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_serahterima/view-npd_serahterima-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdSerahterimaController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_serahterima/edit-npd_serahterima-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdSerahterimaController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_serahterima/delete-npd_serahterima-delete-2'); // delete
        }
    );

    // npd_sample
    $app->any('/NpdSampleList[/{id}]', NpdSampleController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdSampleList-npd_sample-list'); // list
    $app->any('/NpdSampleAdd[/{id}]', NpdSampleController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdSampleAdd-npd_sample-add'); // add
    $app->any('/NpdSampleView[/{id}]', NpdSampleController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdSampleView-npd_sample-view'); // view
    $app->any('/NpdSampleEdit[/{id}]', NpdSampleController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdSampleEdit-npd_sample-edit'); // edit
    $app->any('/NpdSampleDelete[/{id}]', NpdSampleController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdSampleDelete-npd_sample-delete'); // delete
    $app->any('/NpdSamplePreview', NpdSampleController::class . ':preview')->add(PermissionMiddleware::class)->setName('NpdSamplePreview-npd_sample-preview'); // preview
    $app->group(
        '/npd_sample',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdSampleController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_sample/list-npd_sample-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdSampleController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_sample/add-npd_sample-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdSampleController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_sample/view-npd_sample-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdSampleController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_sample/edit-npd_sample-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdSampleController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_sample/delete-npd_sample-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', NpdSampleController::class . ':preview')->add(PermissionMiddleware::class)->setName('npd_sample/preview-npd_sample-preview-2'); // preview
        }
    );

    // npd_review
    $app->any('/NpdReviewList[/{id}]', NpdReviewController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdReviewList-npd_review-list'); // list
    $app->any('/NpdReviewAdd[/{id}]', NpdReviewController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdReviewAdd-npd_review-add'); // add
    $app->any('/NpdReviewView[/{id}]', NpdReviewController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdReviewView-npd_review-view'); // view
    $app->any('/NpdReviewEdit[/{id}]', NpdReviewController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdReviewEdit-npd_review-edit'); // edit
    $app->any('/NpdReviewDelete[/{id}]', NpdReviewController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdReviewDelete-npd_review-delete'); // delete
    $app->any('/NpdReviewPreview', NpdReviewController::class . ':preview')->add(PermissionMiddleware::class)->setName('NpdReviewPreview-npd_review-preview'); // preview
    $app->group(
        '/npd_review',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdReviewController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_review/list-npd_review-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdReviewController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_review/add-npd_review-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdReviewController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_review/view-npd_review-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdReviewController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_review/edit-npd_review-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdReviewController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_review/delete-npd_review-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', NpdReviewController::class . ':preview')->add(PermissionMiddleware::class)->setName('npd_review/preview-npd_review-preview-2'); // preview
        }
    );

    // npd_confirm
    $app->any('/NpdConfirmList[/{id}]', NpdConfirmController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdConfirmList-npd_confirm-list'); // list
    $app->any('/NpdConfirmAdd[/{id}]', NpdConfirmController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdConfirmAdd-npd_confirm-add'); // add
    $app->any('/NpdConfirmView[/{id}]', NpdConfirmController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdConfirmView-npd_confirm-view'); // view
    $app->any('/NpdConfirmEdit[/{id}]', NpdConfirmController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdConfirmEdit-npd_confirm-edit'); // edit
    $app->any('/NpdConfirmDelete[/{id}]', NpdConfirmController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdConfirmDelete-npd_confirm-delete'); // delete
    $app->any('/NpdConfirmPreview', NpdConfirmController::class . ':preview')->add(PermissionMiddleware::class)->setName('NpdConfirmPreview-npd_confirm-preview'); // preview
    $app->group(
        '/npd_confirm',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdConfirmController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_confirm/list-npd_confirm-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdConfirmController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_confirm/add-npd_confirm-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdConfirmController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_confirm/view-npd_confirm-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdConfirmController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_confirm/edit-npd_confirm-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdConfirmController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_confirm/delete-npd_confirm-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', NpdConfirmController::class . ':preview')->add(PermissionMiddleware::class)->setName('npd_confirm/preview-npd_confirm-preview-2'); // preview
        }
    );

    // npd_harga
    $app->any('/NpdHargaList[/{id}]', NpdHargaController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdHargaList-npd_harga-list'); // list
    $app->any('/NpdHargaAdd[/{id}]', NpdHargaController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdHargaAdd-npd_harga-add'); // add
    $app->any('/NpdHargaView[/{id}]', NpdHargaController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdHargaView-npd_harga-view'); // view
    $app->any('/NpdHargaEdit[/{id}]', NpdHargaController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdHargaEdit-npd_harga-edit'); // edit
    $app->any('/NpdHargaDelete[/{id}]', NpdHargaController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdHargaDelete-npd_harga-delete'); // delete
    $app->any('/NpdHargaPreview', NpdHargaController::class . ':preview')->add(PermissionMiddleware::class)->setName('NpdHargaPreview-npd_harga-preview'); // preview
    $app->group(
        '/npd_harga',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdHargaController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_harga/list-npd_harga-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdHargaController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_harga/add-npd_harga-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdHargaController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_harga/view-npd_harga-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdHargaController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_harga/edit-npd_harga-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdHargaController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_harga/delete-npd_harga-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', NpdHargaController::class . ':preview')->add(PermissionMiddleware::class)->setName('npd_harga/preview-npd_harga-preview-2'); // preview
        }
    );

    // npd_desain
    $app->any('/NpdDesainList[/{id}]', NpdDesainController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdDesainList-npd_desain-list'); // list
    $app->any('/NpdDesainPreview', NpdDesainController::class . ':preview')->add(PermissionMiddleware::class)->setName('NpdDesainPreview-npd_desain-preview'); // preview
    $app->group(
        '/npd_desain',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdDesainController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_desain/list-npd_desain-list-2'); // list
            $group->any('/' . Config("PREVIEW_ACTION") . '', NpdDesainController::class . ':preview')->add(PermissionMiddleware::class)->setName('npd_desain/preview-npd_desain-preview-2'); // preview
        }
    );

    // npd_masterdata
    $app->any('/NpdMasterdataList[/{id}]', NpdMasterdataController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdMasterdataList-npd_masterdata-list'); // list
    $app->any('/NpdMasterdataAdd[/{id}]', NpdMasterdataController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdMasterdataAdd-npd_masterdata-add'); // add
    $app->any('/NpdMasterdataView[/{id}]', NpdMasterdataController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdMasterdataView-npd_masterdata-view'); // view
    $app->any('/NpdMasterdataEdit[/{id}]', NpdMasterdataController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdMasterdataEdit-npd_masterdata-edit'); // edit
    $app->any('/NpdMasterdataDelete[/{id}]', NpdMasterdataController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdMasterdataDelete-npd_masterdata-delete'); // delete
    $app->group(
        '/npd_masterdata',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdMasterdataController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_masterdata/list-npd_masterdata-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdMasterdataController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_masterdata/add-npd_masterdata-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdMasterdataController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_masterdata/view-npd_masterdata-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdMasterdataController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_masterdata/edit-npd_masterdata-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdMasterdataController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_masterdata/delete-npd_masterdata-delete-2'); // delete
        }
    );

    // npd_status
    $app->any('/NpdStatusList[/{id}]', NpdStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdStatusList-npd_status-list'); // list
    $app->any('/NpdStatusAdd[/{id}]', NpdStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdStatusAdd-npd_status-add'); // add
    $app->any('/NpdStatusView[/{id}]', NpdStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdStatusView-npd_status-view'); // view
    $app->any('/NpdStatusEdit[/{id}]', NpdStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdStatusEdit-npd_status-edit'); // edit
    $app->any('/NpdStatusDelete[/{id}]', NpdStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdStatusDelete-npd_status-delete'); // delete
    $app->group(
        '/npd_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_status/list-npd_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_status/add-npd_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_status/view-npd_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_status/edit-npd_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_status/delete-npd_status-delete-2'); // delete
        }
    );

    // v_orderdetail
    $app->any('/VOrderdetailList[/{id}]', VOrderdetailController::class . ':list')->add(PermissionMiddleware::class)->setName('VOrderdetailList-v_orderdetail-list'); // list
    $app->any('/VOrderdetailView[/{id}]', VOrderdetailController::class . ':view')->add(PermissionMiddleware::class)->setName('VOrderdetailView-v_orderdetail-view'); // view
    $app->group(
        '/v_orderdetail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', VOrderdetailController::class . ':list')->add(PermissionMiddleware::class)->setName('v_orderdetail/list-v_orderdetail-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', VOrderdetailController::class . ':view')->add(PermissionMiddleware::class)->setName('v_orderdetail/view-v_orderdetail-view-2'); // view
        }
    );

    // v_stock
    $app->any('/VStockList[/{idorder_detail}]', VStockController::class . ':list')->add(PermissionMiddleware::class)->setName('VStockList-v_stock-list'); // list
    $app->group(
        '/v_stock',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idorder_detail}]', VStockController::class . ':list')->add(PermissionMiddleware::class)->setName('v_stock/list-v_stock-list-2'); // list
        }
    );

    // print_invoice
    $app->any('/PrintInvoice[/{params:.*}]', PrintInvoiceController::class)->add(PermissionMiddleware::class)->setName('PrintInvoice-print_invoice-custom'); // custom

    // v_piutang
    $app->any('/VPiutangList', VPiutangController::class . ':list')->add(PermissionMiddleware::class)->setName('VPiutangList-v_piutang-list'); // list
    $app->group(
        '/v_piutang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VPiutangController::class . ':list')->add(PermissionMiddleware::class)->setName('v_piutang/list-v_piutang-list-2'); // list
        }
    );

    // ijinhaki
    $app->any('/IjinhakiList[/{id}]', IjinhakiController::class . ':list')->add(PermissionMiddleware::class)->setName('IjinhakiList-ijinhaki-list'); // list
    $app->any('/IjinhakiAdd[/{id}]', IjinhakiController::class . ':add')->add(PermissionMiddleware::class)->setName('IjinhakiAdd-ijinhaki-add'); // add
    $app->any('/IjinhakiView[/{id}]', IjinhakiController::class . ':view')->add(PermissionMiddleware::class)->setName('IjinhakiView-ijinhaki-view'); // view
    $app->any('/IjinhakiEdit[/{id}]', IjinhakiController::class . ':edit')->add(PermissionMiddleware::class)->setName('IjinhakiEdit-ijinhaki-edit'); // edit
    $app->any('/IjinhakiDelete[/{id}]', IjinhakiController::class . ':delete')->add(PermissionMiddleware::class)->setName('IjinhakiDelete-ijinhaki-delete'); // delete
    $app->group(
        '/ijinhaki',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', IjinhakiController::class . ':list')->add(PermissionMiddleware::class)->setName('ijinhaki/list-ijinhaki-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', IjinhakiController::class . ':add')->add(PermissionMiddleware::class)->setName('ijinhaki/add-ijinhaki-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', IjinhakiController::class . ':view')->add(PermissionMiddleware::class)->setName('ijinhaki/view-ijinhaki-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', IjinhakiController::class . ':edit')->add(PermissionMiddleware::class)->setName('ijinhaki/edit-ijinhaki-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', IjinhakiController::class . ':delete')->add(PermissionMiddleware::class)->setName('ijinhaki/delete-ijinhaki-delete-2'); // delete
        }
    );

    // v_bonuscustomer
    $app->any('/VBonuscustomerList', VBonuscustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('VBonuscustomerList-v_bonuscustomer-list'); // list
    $app->group(
        '/v_bonuscustomer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VBonuscustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('v_bonuscustomer/list-v_bonuscustomer-list-2'); // list
        }
    );

    // ijinhaki_status
    $app->any('/IjinhakiStatusList[/{id}]', IjinhakiStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('IjinhakiStatusList-ijinhaki_status-list'); // list
    $app->any('/IjinhakiStatusAdd[/{id}]', IjinhakiStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('IjinhakiStatusAdd-ijinhaki_status-add'); // add
    $app->any('/IjinhakiStatusView[/{id}]', IjinhakiStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('IjinhakiStatusView-ijinhaki_status-view'); // view
    $app->any('/IjinhakiStatusEdit[/{id}]', IjinhakiStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('IjinhakiStatusEdit-ijinhaki_status-edit'); // edit
    $app->any('/IjinhakiStatusDelete[/{id}]', IjinhakiStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('IjinhakiStatusDelete-ijinhaki_status-delete'); // delete
    $app->any('/IjinhakiStatusPreview', IjinhakiStatusController::class . ':preview')->add(PermissionMiddleware::class)->setName('IjinhakiStatusPreview-ijinhaki_status-preview'); // preview
    $app->group(
        '/ijinhaki_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', IjinhakiStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('ijinhaki_status/list-ijinhaki_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', IjinhakiStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('ijinhaki_status/add-ijinhaki_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', IjinhakiStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('ijinhaki_status/view-ijinhaki_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', IjinhakiStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('ijinhaki_status/edit-ijinhaki_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', IjinhakiStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('ijinhaki_status/delete-ijinhaki_status-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', IjinhakiStatusController::class . ':preview')->add(PermissionMiddleware::class)->setName('ijinhaki_status/preview-ijinhaki_status-preview-2'); // preview
        }
    );

    // ijinbpom
    $app->any('/IjinbpomList[/{id}]', IjinbpomController::class . ':list')->add(PermissionMiddleware::class)->setName('IjinbpomList-ijinbpom-list'); // list
    $app->any('/IjinbpomAdd[/{id}]', IjinbpomController::class . ':add')->add(PermissionMiddleware::class)->setName('IjinbpomAdd-ijinbpom-add'); // add
    $app->any('/IjinbpomView[/{id}]', IjinbpomController::class . ':view')->add(PermissionMiddleware::class)->setName('IjinbpomView-ijinbpom-view'); // view
    $app->any('/IjinbpomEdit[/{id}]', IjinbpomController::class . ':edit')->add(PermissionMiddleware::class)->setName('IjinbpomEdit-ijinbpom-edit'); // edit
    $app->any('/IjinbpomDelete[/{id}]', IjinbpomController::class . ':delete')->add(PermissionMiddleware::class)->setName('IjinbpomDelete-ijinbpom-delete'); // delete
    $app->group(
        '/ijinbpom',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', IjinbpomController::class . ':list')->add(PermissionMiddleware::class)->setName('ijinbpom/list-ijinbpom-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', IjinbpomController::class . ':add')->add(PermissionMiddleware::class)->setName('ijinbpom/add-ijinbpom-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', IjinbpomController::class . ':view')->add(PermissionMiddleware::class)->setName('ijinbpom/view-ijinbpom-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', IjinbpomController::class . ':edit')->add(PermissionMiddleware::class)->setName('ijinbpom/edit-ijinbpom-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', IjinbpomController::class . ':delete')->add(PermissionMiddleware::class)->setName('ijinbpom/delete-ijinbpom-delete-2'); // delete
        }
    );

    // print_suratjalan
    $app->any('/PrintSuratjalan[/{params:.*}]', PrintSuratjalanController::class)->add(PermissionMiddleware::class)->setName('PrintSuratjalan-print_suratjalan-custom'); // custom

    // ijinbpom_detail
    $app->any('/IjinbpomDetailList[/{id}]', IjinbpomDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('IjinbpomDetailList-ijinbpom_detail-list'); // list
    $app->any('/IjinbpomDetailAdd[/{id}]', IjinbpomDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('IjinbpomDetailAdd-ijinbpom_detail-add'); // add
    $app->any('/IjinbpomDetailView[/{id}]', IjinbpomDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('IjinbpomDetailView-ijinbpom_detail-view'); // view
    $app->any('/IjinbpomDetailEdit[/{id}]', IjinbpomDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('IjinbpomDetailEdit-ijinbpom_detail-edit'); // edit
    $app->any('/IjinbpomDetailDelete[/{id}]', IjinbpomDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('IjinbpomDetailDelete-ijinbpom_detail-delete'); // delete
    $app->any('/IjinbpomDetailPreview', IjinbpomDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('IjinbpomDetailPreview-ijinbpom_detail-preview'); // preview
    $app->group(
        '/ijinbpom_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', IjinbpomDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('ijinbpom_detail/list-ijinbpom_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', IjinbpomDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('ijinbpom_detail/add-ijinbpom_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', IjinbpomDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('ijinbpom_detail/view-ijinbpom_detail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', IjinbpomDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('ijinbpom_detail/edit-ijinbpom_detail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', IjinbpomDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('ijinbpom_detail/delete-ijinbpom_detail-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', IjinbpomDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('ijinbpom_detail/preview-ijinbpom_detail-preview-2'); // preview
        }
    );

    // ijinbpom_status
    $app->any('/IjinbpomStatusList[/{id}]', IjinbpomStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('IjinbpomStatusList-ijinbpom_status-list'); // list
    $app->any('/IjinbpomStatusAdd[/{id}]', IjinbpomStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('IjinbpomStatusAdd-ijinbpom_status-add'); // add
    $app->any('/IjinbpomStatusView[/{id}]', IjinbpomStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('IjinbpomStatusView-ijinbpom_status-view'); // view
    $app->any('/IjinbpomStatusEdit[/{id}]', IjinbpomStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('IjinbpomStatusEdit-ijinbpom_status-edit'); // edit
    $app->any('/IjinbpomStatusDelete[/{id}]', IjinbpomStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('IjinbpomStatusDelete-ijinbpom_status-delete'); // delete
    $app->any('/IjinbpomStatusPreview', IjinbpomStatusController::class . ':preview')->add(PermissionMiddleware::class)->setName('IjinbpomStatusPreview-ijinbpom_status-preview'); // preview
    $app->group(
        '/ijinbpom_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', IjinbpomStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('ijinbpom_status/list-ijinbpom_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', IjinbpomStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('ijinbpom_status/add-ijinbpom_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', IjinbpomStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('ijinbpom_status/view-ijinbpom_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', IjinbpomStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('ijinbpom_status/edit-ijinbpom_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', IjinbpomStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('ijinbpom_status/delete-ijinbpom_status-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', IjinbpomStatusController::class . ':preview')->add(PermissionMiddleware::class)->setName('ijinbpom_status/preview-ijinbpom_status-preview-2'); // preview
        }
    );

    // titipmerk_validasi
    $app->any('/TitipmerkValidasiList[/{id}]', TitipmerkValidasiController::class . ':list')->add(PermissionMiddleware::class)->setName('TitipmerkValidasiList-titipmerk_validasi-list'); // list
    $app->any('/TitipmerkValidasiAdd[/{id}]', TitipmerkValidasiController::class . ':add')->add(PermissionMiddleware::class)->setName('TitipmerkValidasiAdd-titipmerk_validasi-add'); // add
    $app->any('/TitipmerkValidasiView[/{id}]', TitipmerkValidasiController::class . ':view')->add(PermissionMiddleware::class)->setName('TitipmerkValidasiView-titipmerk_validasi-view'); // view
    $app->any('/TitipmerkValidasiEdit[/{id}]', TitipmerkValidasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('TitipmerkValidasiEdit-titipmerk_validasi-edit'); // edit
    $app->any('/TitipmerkValidasiDelete[/{id}]', TitipmerkValidasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('TitipmerkValidasiDelete-titipmerk_validasi-delete'); // delete
    $app->group(
        '/titipmerk_validasi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TitipmerkValidasiController::class . ':list')->add(PermissionMiddleware::class)->setName('titipmerk_validasi/list-titipmerk_validasi-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TitipmerkValidasiController::class . ':add')->add(PermissionMiddleware::class)->setName('titipmerk_validasi/add-titipmerk_validasi-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TitipmerkValidasiController::class . ':view')->add(PermissionMiddleware::class)->setName('titipmerk_validasi/view-titipmerk_validasi-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TitipmerkValidasiController::class . ':edit')->add(PermissionMiddleware::class)->setName('titipmerk_validasi/edit-titipmerk_validasi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TitipmerkValidasiController::class . ':delete')->add(PermissionMiddleware::class)->setName('titipmerk_validasi/delete-titipmerk_validasi-delete-2'); // delete
        }
    );

    // order
    $app->any('/OrderList[/{id}]', OrderController::class . ':list')->add(PermissionMiddleware::class)->setName('OrderList-order-list'); // list
    $app->any('/OrderAdd[/{id}]', OrderController::class . ':add')->add(PermissionMiddleware::class)->setName('OrderAdd-order-add'); // add
    $app->any('/OrderView[/{id}]', OrderController::class . ':view')->add(PermissionMiddleware::class)->setName('OrderView-order-view'); // view
    $app->any('/OrderPreview', OrderController::class . ':preview')->add(PermissionMiddleware::class)->setName('OrderPreview-order-preview'); // preview
    $app->group(
        '/order',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', OrderController::class . ':list')->add(PermissionMiddleware::class)->setName('order/list-order-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', OrderController::class . ':add')->add(PermissionMiddleware::class)->setName('order/add-order-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', OrderController::class . ':view')->add(PermissionMiddleware::class)->setName('order/view-order-view-2'); // view
            $group->any('/' . Config("PREVIEW_ACTION") . '', OrderController::class . ':preview')->add(PermissionMiddleware::class)->setName('order/preview-order-preview-2'); // preview
        }
    );

    // order_detail
    $app->any('/OrderDetailList[/{id}]', OrderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('OrderDetailList-order_detail-list'); // list
    $app->any('/OrderDetailAdd[/{id}]', OrderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('OrderDetailAdd-order_detail-add'); // add
    $app->any('/OrderDetailView[/{id}]', OrderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('OrderDetailView-order_detail-view'); // view
    $app->any('/OrderDetailPreview', OrderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('OrderDetailPreview-order_detail-preview'); // preview
    $app->group(
        '/order_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', OrderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('order_detail/list-order_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', OrderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('order_detail/add-order_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', OrderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('order_detail/view-order_detail-view-2'); // view
            $group->any('/' . Config("PREVIEW_ACTION") . '', OrderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('order_detail/preview-order_detail-preview-2'); // preview
        }
    );

    // dashboard2
    $app->any('/Dashboard2[/{params:.*}]', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('Dashboard2-dashboard2-custom'); // custom

    // Jatuh_Tempo
    $app->any('/JatuhTempo', JatuhTempoController::class)->add(PermissionMiddleware::class)->setName('JatuhTempo-Jatuh_Tempo-summary'); // summary

    // Crosstab1
    $app->any('/Crosstab1', Crosstab1Controller::class)->add(PermissionMiddleware::class)->setName('Crosstab1-Crosstab1-crosstab'); // crosstab

    // v_bonuscustomer_detail
    $app->any('/VBonuscustomerDetailList[/{idinvoice}]', VBonuscustomerDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('VBonuscustomerDetailList-v_bonuscustomer_detail-list'); // list
    $app->any('/VBonuscustomerDetailPreview', VBonuscustomerDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('VBonuscustomerDetailPreview-v_bonuscustomer_detail-preview'); // preview
    $app->group(
        '/v_bonuscustomer_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idinvoice}]', VBonuscustomerDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('v_bonuscustomer_detail/list-v_bonuscustomer_detail-list-2'); // list
            $group->any('/' . Config("PREVIEW_ACTION") . '', VBonuscustomerDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('v_bonuscustomer_detail/preview-v_bonuscustomer_detail-preview-2'); // preview
        }
    );

    // laporansales
    $app->any('/Laporansales[/{params:.*}]', LaporansalesController::class)->add(PermissionMiddleware::class)->setName('Laporansales-laporansales-custom'); // custom

    // v_order_customer
    $app->any('/VOrderCustomerList[/{idorder}/{idcustomer}]', VOrderCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('VOrderCustomerList-v_order_customer-list'); // list
    $app->group(
        '/v_order_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idorder}/{idcustomer}]', VOrderCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('v_order_customer/list-v_order_customer-list-2'); // list
        }
    );

    // laporan_delivery_order
    $app->any('/LaporanDeliveryOrder[/{params:.*}]', LaporanDeliveryOrderController::class)->add(PermissionMiddleware::class)->setName('LaporanDeliveryOrder-laporan_delivery_order-custom'); // custom

    // laporan_invoice
    $app->any('/LaporanInvoice[/{params:.*}]', LaporanInvoiceController::class)->add(PermissionMiddleware::class)->setName('LaporanInvoice-laporan_invoice-custom'); // custom

    // laporan_surat_jalan
    $app->any('/LaporanSuratJalan[/{params:.*}]', LaporanSuratJalanController::class)->add(PermissionMiddleware::class)->setName('LaporanSuratJalan-laporan_surat_jalan-custom'); // custom

    // laporan_pembayaran
    $app->any('/LaporanPembayaran[/{params:.*}]', LaporanPembayaranController::class)->add(PermissionMiddleware::class)->setName('LaporanPembayaran-laporan_pembayaran-custom'); // custom

    // deliveryorder
    $app->any('/DeliveryorderList[/{id}]', DeliveryorderController::class . ':list')->add(PermissionMiddleware::class)->setName('DeliveryorderList-deliveryorder-list'); // list
    $app->any('/DeliveryorderAdd[/{id}]', DeliveryorderController::class . ':add')->add(PermissionMiddleware::class)->setName('DeliveryorderAdd-deliveryorder-add'); // add
    $app->any('/DeliveryorderView[/{id}]', DeliveryorderController::class . ':view')->add(PermissionMiddleware::class)->setName('DeliveryorderView-deliveryorder-view'); // view
    $app->any('/DeliveryorderEdit[/{id}]', DeliveryorderController::class . ':edit')->add(PermissionMiddleware::class)->setName('DeliveryorderEdit-deliveryorder-edit'); // edit
    $app->any('/DeliveryorderDelete[/{id}]', DeliveryorderController::class . ':delete')->add(PermissionMiddleware::class)->setName('DeliveryorderDelete-deliveryorder-delete'); // delete
    $app->group(
        '/deliveryorder',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', DeliveryorderController::class . ':list')->add(PermissionMiddleware::class)->setName('deliveryorder/list-deliveryorder-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', DeliveryorderController::class . ':add')->add(PermissionMiddleware::class)->setName('deliveryorder/add-deliveryorder-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', DeliveryorderController::class . ':view')->add(PermissionMiddleware::class)->setName('deliveryorder/view-deliveryorder-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', DeliveryorderController::class . ':edit')->add(PermissionMiddleware::class)->setName('deliveryorder/edit-deliveryorder-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', DeliveryorderController::class . ':delete')->add(PermissionMiddleware::class)->setName('deliveryorder/delete-deliveryorder-delete-2'); // delete
        }
    );

    // v_do_stock
    $app->any('/VDoStockList', VDoStockController::class . ':list')->add(PermissionMiddleware::class)->setName('VDoStockList-v_do_stock-list'); // list
    $app->group(
        '/v_do_stock',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VDoStockController::class . ':list')->add(PermissionMiddleware::class)->setName('v_do_stock/list-v_do_stock-list-2'); // list
        }
    );

    // deliveryorder_detail
    $app->any('/DeliveryorderDetailList[/{id}]', DeliveryorderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('DeliveryorderDetailList-deliveryorder_detail-list'); // list
    $app->any('/DeliveryorderDetailAdd[/{id}]', DeliveryorderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('DeliveryorderDetailAdd-deliveryorder_detail-add'); // add
    $app->any('/DeliveryorderDetailView[/{id}]', DeliveryorderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('DeliveryorderDetailView-deliveryorder_detail-view'); // view
    $app->any('/DeliveryorderDetailEdit[/{id}]', DeliveryorderDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('DeliveryorderDetailEdit-deliveryorder_detail-edit'); // edit
    $app->any('/DeliveryorderDetailDelete[/{id}]', DeliveryorderDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('DeliveryorderDetailDelete-deliveryorder_detail-delete'); // delete
    $app->any('/DeliveryorderDetailPreview', DeliveryorderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('DeliveryorderDetailPreview-deliveryorder_detail-preview'); // preview
    $app->group(
        '/deliveryorder_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', DeliveryorderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('deliveryorder_detail/list-deliveryorder_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', DeliveryorderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('deliveryorder_detail/add-deliveryorder_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', DeliveryorderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('deliveryorder_detail/view-deliveryorder_detail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', DeliveryorderDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('deliveryorder_detail/edit-deliveryorder_detail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', DeliveryorderDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('deliveryorder_detail/delete-deliveryorder_detail-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', DeliveryorderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('deliveryorder_detail/preview-deliveryorder_detail-preview-2'); // preview
        }
    );

    // invoice
    $app->any('/InvoiceList[/{id}]', InvoiceController::class . ':list')->add(PermissionMiddleware::class)->setName('InvoiceList-invoice-list'); // list
    $app->any('/InvoiceAdd[/{id}]', InvoiceController::class . ':add')->add(PermissionMiddleware::class)->setName('InvoiceAdd-invoice-add'); // add
    $app->any('/InvoiceView[/{id}]', InvoiceController::class . ':view')->add(PermissionMiddleware::class)->setName('InvoiceView-invoice-view'); // view
    $app->any('/InvoiceEdit[/{id}]', InvoiceController::class . ':edit')->add(PermissionMiddleware::class)->setName('InvoiceEdit-invoice-edit'); // edit
    $app->any('/InvoiceDelete[/{id}]', InvoiceController::class . ':delete')->add(PermissionMiddleware::class)->setName('InvoiceDelete-invoice-delete'); // delete
    $app->any('/InvoicePreview', InvoiceController::class . ':preview')->add(PermissionMiddleware::class)->setName('InvoicePreview-invoice-preview'); // preview
    $app->group(
        '/invoice',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', InvoiceController::class . ':list')->add(PermissionMiddleware::class)->setName('invoice/list-invoice-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', InvoiceController::class . ':add')->add(PermissionMiddleware::class)->setName('invoice/add-invoice-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', InvoiceController::class . ':view')->add(PermissionMiddleware::class)->setName('invoice/view-invoice-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', InvoiceController::class . ':edit')->add(PermissionMiddleware::class)->setName('invoice/edit-invoice-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', InvoiceController::class . ':delete')->add(PermissionMiddleware::class)->setName('invoice/delete-invoice-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', InvoiceController::class . ':preview')->add(PermissionMiddleware::class)->setName('invoice/preview-invoice-preview-2'); // preview
        }
    );

    // laporan_kpi_marketing
    $app->any('/LaporanKpiMarketing[/{params:.*}]', LaporanKpiMarketingController::class)->add(PermissionMiddleware::class)->setName('LaporanKpiMarketing-laporan_kpi_marketing-custom'); // custom

    // laporan_kpi_marketing_detail
    $app->any('/LaporanKpiMarketingDetail[/{params:.*}]', LaporanKpiMarketingDetailController::class)->add(PermissionMiddleware::class)->setName('LaporanKpiMarketingDetail-laporan_kpi_marketing_detail-custom'); // custom

    // invoice_detail
    $app->any('/InvoiceDetailList[/{id}]', InvoiceDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('InvoiceDetailList-invoice_detail-list'); // list
    $app->any('/InvoiceDetailAdd[/{id}]', InvoiceDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('InvoiceDetailAdd-invoice_detail-add'); // add
    $app->any('/InvoiceDetailView[/{id}]', InvoiceDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('InvoiceDetailView-invoice_detail-view'); // view
    $app->any('/InvoiceDetailEdit[/{id}]', InvoiceDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('InvoiceDetailEdit-invoice_detail-edit'); // edit
    $app->any('/InvoiceDetailDelete[/{id}]', InvoiceDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('InvoiceDetailDelete-invoice_detail-delete'); // delete
    $app->any('/InvoiceDetailPreview', InvoiceDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('InvoiceDetailPreview-invoice_detail-preview'); // preview
    $app->group(
        '/invoice_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', InvoiceDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('invoice_detail/list-invoice_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', InvoiceDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('invoice_detail/add-invoice_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', InvoiceDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('invoice_detail/view-invoice_detail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', InvoiceDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('invoice_detail/edit-invoice_detail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', InvoiceDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('invoice_detail/delete-invoice_detail-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', InvoiceDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('invoice_detail/preview-invoice_detail-preview-2'); // preview
        }
    );

    // d_jatuhtempo
    $app->any('/DJatuhtempoList[/{idpegawai}/{idcustomer}/{idinvoice}]', DJatuhtempoController::class . ':list')->add(PermissionMiddleware::class)->setName('DJatuhtempoList-d_jatuhtempo-list'); // list
    $app->group(
        '/d_jatuhtempo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idpegawai}/{idcustomer}/{idinvoice}]', DJatuhtempoController::class . ':list')->add(PermissionMiddleware::class)->setName('d_jatuhtempo/list-d_jatuhtempo-list-2'); // list
        }
    );

    // v_piutang_detail
    $app->any('/VPiutangDetailList[/{idinvoice}]', VPiutangDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('VPiutangDetailList-v_piutang_detail-list'); // list
    $app->any('/VPiutangDetailPreview', VPiutangDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('VPiutangDetailPreview-v_piutang_detail-preview'); // preview
    $app->group(
        '/v_piutang_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idinvoice}]', VPiutangDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('v_piutang_detail/list-v_piutang_detail-list-2'); // list
            $group->any('/' . Config("PREVIEW_ACTION") . '', VPiutangDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('v_piutang_detail/preview-v_piutang_detail-preview-2'); // preview
        }
    );

    // suratjalan
    $app->any('/SuratjalanList[/{id}]', SuratjalanController::class . ':list')->add(PermissionMiddleware::class)->setName('SuratjalanList-suratjalan-list'); // list
    $app->any('/SuratjalanAdd[/{id}]', SuratjalanController::class . ':add')->add(PermissionMiddleware::class)->setName('SuratjalanAdd-suratjalan-add'); // add
    $app->any('/SuratjalanView[/{id}]', SuratjalanController::class . ':view')->add(PermissionMiddleware::class)->setName('SuratjalanView-suratjalan-view'); // view
    $app->any('/SuratjalanEdit[/{id}]', SuratjalanController::class . ':edit')->add(PermissionMiddleware::class)->setName('SuratjalanEdit-suratjalan-edit'); // edit
    $app->any('/SuratjalanDelete[/{id}]', SuratjalanController::class . ':delete')->add(PermissionMiddleware::class)->setName('SuratjalanDelete-suratjalan-delete'); // delete
    $app->group(
        '/suratjalan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SuratjalanController::class . ':list')->add(PermissionMiddleware::class)->setName('suratjalan/list-suratjalan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SuratjalanController::class . ':add')->add(PermissionMiddleware::class)->setName('suratjalan/add-suratjalan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SuratjalanController::class . ':view')->add(PermissionMiddleware::class)->setName('suratjalan/view-suratjalan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SuratjalanController::class . ':edit')->add(PermissionMiddleware::class)->setName('suratjalan/edit-suratjalan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SuratjalanController::class . ':delete')->add(PermissionMiddleware::class)->setName('suratjalan/delete-suratjalan-delete-2'); // delete
        }
    );

    // suratjalan_detail
    $app->any('/SuratjalanDetailList[/{id}]', SuratjalanDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('SuratjalanDetailList-suratjalan_detail-list'); // list
    $app->any('/SuratjalanDetailAdd[/{id}]', SuratjalanDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('SuratjalanDetailAdd-suratjalan_detail-add'); // add
    $app->any('/SuratjalanDetailView[/{id}]', SuratjalanDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('SuratjalanDetailView-suratjalan_detail-view'); // view
    $app->any('/SuratjalanDetailEdit[/{id}]', SuratjalanDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('SuratjalanDetailEdit-suratjalan_detail-edit'); // edit
    $app->any('/SuratjalanDetailDelete[/{id}]', SuratjalanDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('SuratjalanDetailDelete-suratjalan_detail-delete'); // delete
    $app->any('/SuratjalanDetailPreview', SuratjalanDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('SuratjalanDetailPreview-suratjalan_detail-preview'); // preview
    $app->group(
        '/suratjalan_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SuratjalanDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('suratjalan_detail/list-suratjalan_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SuratjalanDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('suratjalan_detail/add-suratjalan_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SuratjalanDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('suratjalan_detail/view-suratjalan_detail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SuratjalanDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('suratjalan_detail/edit-suratjalan_detail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SuratjalanDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('suratjalan_detail/delete-suratjalan_detail-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', SuratjalanDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('suratjalan_detail/preview-suratjalan_detail-preview-2'); // preview
        }
    );

    // laporan_order_customer
    $app->any('/LaporanOrderCustomer[/{params:.*}]', LaporanOrderCustomerController::class)->add(PermissionMiddleware::class)->setName('LaporanOrderCustomer-laporan_order_customer-custom'); // custom

    // penagihan_customer
    $app->any('/PenagihanCustomer[/{params:.*}]', PenagihanCustomerController::class)->add(PermissionMiddleware::class)->setName('PenagihanCustomer-penagihan_customer-custom'); // custom

    // pembayaran
    $app->any('/PembayaranList[/{id}]', PembayaranController::class . ':list')->add(PermissionMiddleware::class)->setName('PembayaranList-pembayaran-list'); // list
    $app->any('/PembayaranAdd[/{id}]', PembayaranController::class . ':add')->add(PermissionMiddleware::class)->setName('PembayaranAdd-pembayaran-add'); // add
    $app->any('/PembayaranView[/{id}]', PembayaranController::class . ':view')->add(PermissionMiddleware::class)->setName('PembayaranView-pembayaran-view'); // view
    $app->any('/PembayaranEdit[/{id}]', PembayaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('PembayaranEdit-pembayaran-edit'); // edit
    $app->any('/PembayaranDelete[/{id}]', PembayaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('PembayaranDelete-pembayaran-delete'); // delete
    $app->group(
        '/pembayaran',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PembayaranController::class . ':list')->add(PermissionMiddleware::class)->setName('pembayaran/list-pembayaran-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PembayaranController::class . ':add')->add(PermissionMiddleware::class)->setName('pembayaran/add-pembayaran-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PembayaranController::class . ':view')->add(PermissionMiddleware::class)->setName('pembayaran/view-pembayaran-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PembayaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('pembayaran/edit-pembayaran-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PembayaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('pembayaran/delete-pembayaran-delete-2'); // delete
        }
    );

    // redeembonus
    $app->any('/RedeembonusList[/{id}]', RedeembonusController::class . ':list')->add(PermissionMiddleware::class)->setName('RedeembonusList-redeembonus-list'); // list
    $app->any('/RedeembonusAdd[/{id}]', RedeembonusController::class . ':add')->add(PermissionMiddleware::class)->setName('RedeembonusAdd-redeembonus-add'); // add
    $app->any('/RedeembonusView[/{id}]', RedeembonusController::class . ':view')->add(PermissionMiddleware::class)->setName('RedeembonusView-redeembonus-view'); // view
    $app->any('/RedeembonusEdit[/{id}]', RedeembonusController::class . ':edit')->add(PermissionMiddleware::class)->setName('RedeembonusEdit-redeembonus-edit'); // edit
    $app->any('/RedeembonusDelete[/{id}]', RedeembonusController::class . ':delete')->add(PermissionMiddleware::class)->setName('RedeembonusDelete-redeembonus-delete'); // delete
    $app->any('/RedeembonusPreview', RedeembonusController::class . ':preview')->add(PermissionMiddleware::class)->setName('RedeembonusPreview-redeembonus-preview'); // preview
    $app->group(
        '/redeembonus',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', RedeembonusController::class . ':list')->add(PermissionMiddleware::class)->setName('redeembonus/list-redeembonus-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', RedeembonusController::class . ':add')->add(PermissionMiddleware::class)->setName('redeembonus/add-redeembonus-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', RedeembonusController::class . ':view')->add(PermissionMiddleware::class)->setName('redeembonus/view-redeembonus-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', RedeembonusController::class . ':edit')->add(PermissionMiddleware::class)->setName('redeembonus/edit-redeembonus-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', RedeembonusController::class . ':delete')->add(PermissionMiddleware::class)->setName('redeembonus/delete-redeembonus-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', RedeembonusController::class . ':preview')->add(PermissionMiddleware::class)->setName('redeembonus/preview-redeembonus-preview-2'); // preview
        }
    );

    // stock
    $app->any('/StockList[/{id}]', StockController::class . ':list')->add(PermissionMiddleware::class)->setName('StockList-stock-list'); // list
    $app->any('/StockAdd[/{id}]', StockController::class . ':add')->add(PermissionMiddleware::class)->setName('StockAdd-stock-add'); // add
    $app->any('/StockView[/{id}]', StockController::class . ':view')->add(PermissionMiddleware::class)->setName('StockView-stock-view'); // view
    $app->any('/StockEdit[/{id}]', StockController::class . ':edit')->add(PermissionMiddleware::class)->setName('StockEdit-stock-edit'); // edit
    $app->any('/StockDelete[/{id}]', StockController::class . ':delete')->add(PermissionMiddleware::class)->setName('StockDelete-stock-delete'); // delete
    $app->group(
        '/stock',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StockController::class . ':list')->add(PermissionMiddleware::class)->setName('stock/list-stock-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', StockController::class . ':add')->add(PermissionMiddleware::class)->setName('stock/add-stock-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StockController::class . ':view')->add(PermissionMiddleware::class)->setName('stock/view-stock-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', StockController::class . ':edit')->add(PermissionMiddleware::class)->setName('stock/edit-stock-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', StockController::class . ':delete')->add(PermissionMiddleware::class)->setName('stock/delete-stock-delete-2'); // delete
        }
    );

    // v_brand_customer
    $app->any('/VBrandCustomerList[/{idbrand}/{idcustomer}]', VBrandCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('VBrandCustomerList-v_brand_customer-list'); // list
    $app->group(
        '/v_brand_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idbrand}/{idcustomer}]', VBrandCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('v_brand_customer/list-v_brand_customer-list-2'); // list
        }
    );

    // po_limit_approval
    $app->any('/PoLimitApprovalList[/{id}]', PoLimitApprovalController::class . ':list')->add(PermissionMiddleware::class)->setName('PoLimitApprovalList-po_limit_approval-list'); // list
    $app->any('/PoLimitApprovalAdd[/{id}]', PoLimitApprovalController::class . ':add')->add(PermissionMiddleware::class)->setName('PoLimitApprovalAdd-po_limit_approval-add'); // add
    $app->any('/PoLimitApprovalView[/{id}]', PoLimitApprovalController::class . ':view')->add(PermissionMiddleware::class)->setName('PoLimitApprovalView-po_limit_approval-view'); // view
    $app->any('/PoLimitApprovalEdit[/{id}]', PoLimitApprovalController::class . ':edit')->add(PermissionMiddleware::class)->setName('PoLimitApprovalEdit-po_limit_approval-edit'); // edit
    $app->group(
        '/po_limit_approval',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PoLimitApprovalController::class . ':list')->add(PermissionMiddleware::class)->setName('po_limit_approval/list-po_limit_approval-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PoLimitApprovalController::class . ':add')->add(PermissionMiddleware::class)->setName('po_limit_approval/add-po_limit_approval-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PoLimitApprovalController::class . ':view')->add(PermissionMiddleware::class)->setName('po_limit_approval/view-po_limit_approval-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PoLimitApprovalController::class . ':edit')->add(PermissionMiddleware::class)->setName('po_limit_approval/edit-po_limit_approval-edit-2'); // edit
        }
    );

    // po_limit_approval_detail
    $app->any('/PoLimitApprovalDetailList[/{id}]', PoLimitApprovalDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('PoLimitApprovalDetailList-po_limit_approval_detail-list'); // list
    $app->any('/PoLimitApprovalDetailView[/{id}]', PoLimitApprovalDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('PoLimitApprovalDetailView-po_limit_approval_detail-view'); // view
    $app->any('/PoLimitApprovalDetailPreview', PoLimitApprovalDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('PoLimitApprovalDetailPreview-po_limit_approval_detail-preview'); // preview
    $app->group(
        '/po_limit_approval_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PoLimitApprovalDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('po_limit_approval_detail/list-po_limit_approval_detail-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PoLimitApprovalDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('po_limit_approval_detail/view-po_limit_approval_detail-view-2'); // view
            $group->any('/' . Config("PREVIEW_ACTION") . '', PoLimitApprovalDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('po_limit_approval_detail/preview-po_limit_approval_detail-preview-2'); // preview
        }
    );

    // kpi_marketing
    $app->any('/KpiMarketingList[/{id}]', KpiMarketingController::class . ':list')->add(PermissionMiddleware::class)->setName('KpiMarketingList-kpi_marketing-list'); // list
    $app->any('/KpiMarketingAdd[/{id}]', KpiMarketingController::class . ':add')->add(PermissionMiddleware::class)->setName('KpiMarketingAdd-kpi_marketing-add'); // add
    $app->any('/KpiMarketingEdit[/{id}]', KpiMarketingController::class . ':edit')->add(PermissionMiddleware::class)->setName('KpiMarketingEdit-kpi_marketing-edit'); // edit
    $app->any('/KpiMarketingUpdate', KpiMarketingController::class . ':update')->add(PermissionMiddleware::class)->setName('KpiMarketingUpdate-kpi_marketing-update'); // update
    $app->any('/KpiMarketingDelete[/{id}]', KpiMarketingController::class . ':delete')->add(PermissionMiddleware::class)->setName('KpiMarketingDelete-kpi_marketing-delete'); // delete
    $app->group(
        '/kpi_marketing',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KpiMarketingController::class . ':list')->add(PermissionMiddleware::class)->setName('kpi_marketing/list-kpi_marketing-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KpiMarketingController::class . ':add')->add(PermissionMiddleware::class)->setName('kpi_marketing/add-kpi_marketing-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KpiMarketingController::class . ':edit')->add(PermissionMiddleware::class)->setName('kpi_marketing/edit-kpi_marketing-edit-2'); // edit
            $group->any('/' . Config("UPDATE_ACTION") . '', KpiMarketingController::class . ':update')->add(PermissionMiddleware::class)->setName('kpi_marketing/update-kpi_marketing-update-2'); // update
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KpiMarketingController::class . ':delete')->add(PermissionMiddleware::class)->setName('kpi_marketing/delete-kpi_marketing-delete-2'); // delete
        }
    );

    // level_customer
    $app->any('/LevelCustomerList[/{id}]', LevelCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('LevelCustomerList-level_customer-list'); // list
    $app->any('/LevelCustomerAdd[/{id}]', LevelCustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('LevelCustomerAdd-level_customer-add'); // add
    $app->any('/LevelCustomerView[/{id}]', LevelCustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('LevelCustomerView-level_customer-view'); // view
    $app->any('/LevelCustomerEdit[/{id}]', LevelCustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('LevelCustomerEdit-level_customer-edit'); // edit
    $app->any('/LevelCustomerDelete[/{id}]', LevelCustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('LevelCustomerDelete-level_customer-delete'); // delete
    $app->group(
        '/level_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', LevelCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('level_customer/list-level_customer-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', LevelCustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('level_customer/add-level_customer-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', LevelCustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('level_customer/view-level_customer-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', LevelCustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('level_customer/edit-level_customer-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', LevelCustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('level_customer/delete-level_customer-delete-2'); // delete
        }
    );

    // bot_history
    $app->any('/BotHistoryList[/{id}]', BotHistoryController::class . ':list')->add(PermissionMiddleware::class)->setName('BotHistoryList-bot_history-list'); // list
    $app->group(
        '/bot_history',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', BotHistoryController::class . ':list')->add(PermissionMiddleware::class)->setName('bot_history/list-bot_history-list-2'); // list
        }
    );

    // v_stockorder
    $app->any('/VStockorderList[/{idstockorder}]', VStockorderController::class . ':list')->add(PermissionMiddleware::class)->setName('VStockorderList-v_stockorder-list'); // list
    $app->group(
        '/v_stockorder',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idstockorder}]', VStockorderController::class . ':list')->add(PermissionMiddleware::class)->setName('v_stockorder/list-v_stockorder-list-2'); // list
        }
    );

    // v_stockorder_detail
    $app->any('/VStockorderDetailList[/{idstockorder_detail}]', VStockorderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('VStockorderDetailList-v_stockorder_detail-list'); // list
    $app->group(
        '/v_stockorder_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idstockorder_detail}]', VStockorderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('v_stockorder_detail/list-v_stockorder_detail-list-2'); // list
        }
    );

    // v_stock_produk
    $app->any('/VStockProdukList[/{idproduk}]', VStockProdukController::class . ':list')->add(PermissionMiddleware::class)->setName('VStockProdukList-v_stock_produk-list'); // list
    $app->group(
        '/v_stock_produk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idproduk}]', VStockProdukController::class . ':list')->add(PermissionMiddleware::class)->setName('v_stock_produk/list-v_stock_produk-list-2'); // list
        }
    );

    // npd_aplikasi_sediaan
    $app->any('/NpdAplikasiSediaanList[/{id}]', NpdAplikasiSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdAplikasiSediaanList-npd_aplikasi_sediaan-list'); // list
    $app->any('/NpdAplikasiSediaanAdd[/{id}]', NpdAplikasiSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdAplikasiSediaanAdd-npd_aplikasi_sediaan-add'); // add
    $app->any('/NpdAplikasiSediaanEdit[/{id}]', NpdAplikasiSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdAplikasiSediaanEdit-npd_aplikasi_sediaan-edit'); // edit
    $app->any('/NpdAplikasiSediaanDelete[/{id}]', NpdAplikasiSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdAplikasiSediaanDelete-npd_aplikasi_sediaan-delete'); // delete
    $app->group(
        '/npd_aplikasi_sediaan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdAplikasiSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_aplikasi_sediaan/list-npd_aplikasi_sediaan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdAplikasiSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_aplikasi_sediaan/add-npd_aplikasi_sediaan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdAplikasiSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_aplikasi_sediaan/edit-npd_aplikasi_sediaan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdAplikasiSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_aplikasi_sediaan/delete-npd_aplikasi_sediaan-delete-2'); // delete
        }
    );

    // npd_bentuk_sediaan
    $app->any('/NpdBentukSediaanList[/{id}]', NpdBentukSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdBentukSediaanList-npd_bentuk_sediaan-list'); // list
    $app->any('/NpdBentukSediaanAdd[/{id}]', NpdBentukSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdBentukSediaanAdd-npd_bentuk_sediaan-add'); // add
    $app->any('/NpdBentukSediaanEdit[/{id}]', NpdBentukSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdBentukSediaanEdit-npd_bentuk_sediaan-edit'); // edit
    $app->any('/NpdBentukSediaanDelete[/{id}]', NpdBentukSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdBentukSediaanDelete-npd_bentuk_sediaan-delete'); // delete
    $app->group(
        '/npd_bentuk_sediaan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdBentukSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_bentuk_sediaan/list-npd_bentuk_sediaan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdBentukSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_bentuk_sediaan/add-npd_bentuk_sediaan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdBentukSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_bentuk_sediaan/edit-npd_bentuk_sediaan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdBentukSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_bentuk_sediaan/delete-npd_bentuk_sediaan-delete-2'); // delete
        }
    );

    // npd_estetika_sediaan
    $app->any('/NpdEstetikaSediaanList[/{id}]', NpdEstetikaSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdEstetikaSediaanList-npd_estetika_sediaan-list'); // list
    $app->any('/NpdEstetikaSediaanAdd[/{id}]', NpdEstetikaSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdEstetikaSediaanAdd-npd_estetika_sediaan-add'); // add
    $app->any('/NpdEstetikaSediaanEdit[/{id}]', NpdEstetikaSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdEstetikaSediaanEdit-npd_estetika_sediaan-edit'); // edit
    $app->any('/NpdEstetikaSediaanDelete[/{id}]', NpdEstetikaSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdEstetikaSediaanDelete-npd_estetika_sediaan-delete'); // delete
    $app->group(
        '/npd_estetika_sediaan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdEstetikaSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_estetika_sediaan/list-npd_estetika_sediaan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdEstetikaSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_estetika_sediaan/add-npd_estetika_sediaan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdEstetikaSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_estetika_sediaan/edit-npd_estetika_sediaan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdEstetikaSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_estetika_sediaan/delete-npd_estetika_sediaan-delete-2'); // delete
        }
    );

    // npd_kemasan_tutup
    $app->any('/NpdKemasanTutupList[/{id}]', NpdKemasanTutupController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdKemasanTutupList-npd_kemasan_tutup-list'); // list
    $app->any('/NpdKemasanTutupAdd[/{id}]', NpdKemasanTutupController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdKemasanTutupAdd-npd_kemasan_tutup-add'); // add
    $app->any('/NpdKemasanTutupEdit[/{id}]', NpdKemasanTutupController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdKemasanTutupEdit-npd_kemasan_tutup-edit'); // edit
    $app->any('/NpdKemasanTutupDelete[/{id}]', NpdKemasanTutupController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdKemasanTutupDelete-npd_kemasan_tutup-delete'); // delete
    $app->group(
        '/npd_kemasan_tutup',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdKemasanTutupController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_kemasan_tutup/list-npd_kemasan_tutup-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdKemasanTutupController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_kemasan_tutup/add-npd_kemasan_tutup-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdKemasanTutupController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_kemasan_tutup/edit-npd_kemasan_tutup-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdKemasanTutupController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_kemasan_tutup/delete-npd_kemasan_tutup-delete-2'); // delete
        }
    );

    // termpayment
    $app->any('/TermpaymentList[/{id}]', TermpaymentController::class . ':list')->add(PermissionMiddleware::class)->setName('TermpaymentList-termpayment-list'); // list
    $app->any('/TermpaymentAdd[/{id}]', TermpaymentController::class . ':add')->add(PermissionMiddleware::class)->setName('TermpaymentAdd-termpayment-add'); // add
    $app->any('/TermpaymentView[/{id}]', TermpaymentController::class . ':view')->add(PermissionMiddleware::class)->setName('TermpaymentView-termpayment-view'); // view
    $app->any('/TermpaymentEdit[/{id}]', TermpaymentController::class . ':edit')->add(PermissionMiddleware::class)->setName('TermpaymentEdit-termpayment-edit'); // edit
    $app->any('/TermpaymentDelete[/{id}]', TermpaymentController::class . ':delete')->add(PermissionMiddleware::class)->setName('TermpaymentDelete-termpayment-delete'); // delete
    $app->group(
        '/termpayment',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TermpaymentController::class . ':list')->add(PermissionMiddleware::class)->setName('termpayment/list-termpayment-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TermpaymentController::class . ':add')->add(PermissionMiddleware::class)->setName('termpayment/add-termpayment-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TermpaymentController::class . ':view')->add(PermissionMiddleware::class)->setName('termpayment/view-termpayment-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TermpaymentController::class . ':edit')->add(PermissionMiddleware::class)->setName('termpayment/edit-termpayment-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TermpaymentController::class . ':delete')->add(PermissionMiddleware::class)->setName('termpayment/delete-termpayment-delete-2'); // delete
        }
    );

    // npd_kemasan_wadah
    $app->any('/NpdKemasanWadahList[/{id}]', NpdKemasanWadahController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdKemasanWadahList-npd_kemasan_wadah-list'); // list
    $app->any('/NpdKemasanWadahAdd[/{id}]', NpdKemasanWadahController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdKemasanWadahAdd-npd_kemasan_wadah-add'); // add
    $app->any('/NpdKemasanWadahEdit[/{id}]', NpdKemasanWadahController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdKemasanWadahEdit-npd_kemasan_wadah-edit'); // edit
    $app->any('/NpdKemasanWadahDelete[/{id}]', NpdKemasanWadahController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdKemasanWadahDelete-npd_kemasan_wadah-delete'); // delete
    $app->group(
        '/npd_kemasan_wadah',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdKemasanWadahController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_kemasan_wadah/list-npd_kemasan_wadah-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdKemasanWadahController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_kemasan_wadah/add-npd_kemasan_wadah-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdKemasanWadahController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_kemasan_wadah/edit-npd_kemasan_wadah-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdKemasanWadahController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_kemasan_wadah/delete-npd_kemasan_wadah-delete-2'); // delete
        }
    );

    // npd_label_bahan
    $app->any('/NpdLabelBahanList[/{id}]', NpdLabelBahanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdLabelBahanList-npd_label_bahan-list'); // list
    $app->any('/NpdLabelBahanAdd[/{id}]', NpdLabelBahanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdLabelBahanAdd-npd_label_bahan-add'); // add
    $app->any('/NpdLabelBahanEdit[/{id}]', NpdLabelBahanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdLabelBahanEdit-npd_label_bahan-edit'); // edit
    $app->any('/NpdLabelBahanDelete[/{id}]', NpdLabelBahanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdLabelBahanDelete-npd_label_bahan-delete'); // delete
    $app->group(
        '/npd_label_bahan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdLabelBahanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_label_bahan/list-npd_label_bahan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdLabelBahanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_label_bahan/add-npd_label_bahan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdLabelBahanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_label_bahan/edit-npd_label_bahan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdLabelBahanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_label_bahan/delete-npd_label_bahan-delete-2'); // delete
        }
    );

    // npd_label_posisi
    $app->any('/NpdLabelPosisiList[/{id}]', NpdLabelPosisiController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdLabelPosisiList-npd_label_posisi-list'); // list
    $app->any('/NpdLabelPosisiAdd[/{id}]', NpdLabelPosisiController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdLabelPosisiAdd-npd_label_posisi-add'); // add
    $app->any('/NpdLabelPosisiEdit[/{id}]', NpdLabelPosisiController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdLabelPosisiEdit-npd_label_posisi-edit'); // edit
    $app->any('/NpdLabelPosisiDelete[/{id}]', NpdLabelPosisiController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdLabelPosisiDelete-npd_label_posisi-delete'); // delete
    $app->group(
        '/npd_label_posisi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdLabelPosisiController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_label_posisi/list-npd_label_posisi-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdLabelPosisiController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_label_posisi/add-npd_label_posisi-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdLabelPosisiController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_label_posisi/edit-npd_label_posisi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdLabelPosisiController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_label_posisi/delete-npd_label_posisi-delete-2'); // delete
        }
    );

    // npd_parfum_sediaan
    $app->any('/NpdParfumSediaanList[/{id}]', NpdParfumSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdParfumSediaanList-npd_parfum_sediaan-list'); // list
    $app->any('/NpdParfumSediaanAdd[/{id}]', NpdParfumSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdParfumSediaanAdd-npd_parfum_sediaan-add'); // add
    $app->any('/NpdParfumSediaanEdit[/{id}]', NpdParfumSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdParfumSediaanEdit-npd_parfum_sediaan-edit'); // edit
    $app->any('/NpdParfumSediaanDelete[/{id}]', NpdParfumSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdParfumSediaanDelete-npd_parfum_sediaan-delete'); // delete
    $app->group(
        '/npd_parfum_sediaan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdParfumSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_parfum_sediaan/list-npd_parfum_sediaan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdParfumSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_parfum_sediaan/add-npd_parfum_sediaan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdParfumSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_parfum_sediaan/edit-npd_parfum_sediaan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdParfumSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_parfum_sediaan/delete-npd_parfum_sediaan-delete-2'); // delete
        }
    );

    // penagihan
    $app->any('/PenagihanList[/{id}]', PenagihanController::class . ':list')->add(PermissionMiddleware::class)->setName('PenagihanList-penagihan-list'); // list
    $app->any('/PenagihanAdd[/{id}]', PenagihanController::class . ':add')->add(PermissionMiddleware::class)->setName('PenagihanAdd-penagihan-add'); // add
    $app->any('/PenagihanView[/{id}]', PenagihanController::class . ':view')->add(PermissionMiddleware::class)->setName('PenagihanView-penagihan-view'); // view
    $app->any('/PenagihanEdit[/{id}]', PenagihanController::class . ':edit')->add(PermissionMiddleware::class)->setName('PenagihanEdit-penagihan-edit'); // edit
    $app->any('/PenagihanDelete[/{id}]', PenagihanController::class . ':delete')->add(PermissionMiddleware::class)->setName('PenagihanDelete-penagihan-delete'); // delete
    $app->group(
        '/penagihan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PenagihanController::class . ':list')->add(PermissionMiddleware::class)->setName('penagihan/list-penagihan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PenagihanController::class . ':add')->add(PermissionMiddleware::class)->setName('penagihan/add-penagihan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PenagihanController::class . ':view')->add(PermissionMiddleware::class)->setName('penagihan/view-penagihan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PenagihanController::class . ':edit')->add(PermissionMiddleware::class)->setName('penagihan/edit-penagihan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PenagihanController::class . ':delete')->add(PermissionMiddleware::class)->setName('penagihan/delete-penagihan-delete-2'); // delete
        }
    );

    // stocks
    $app->any('/StocksList[/{id}]', StocksController::class . ':list')->add(PermissionMiddleware::class)->setName('StocksList-stocks-list'); // list
    $app->any('/StocksView[/{id}]', StocksController::class . ':view')->add(PermissionMiddleware::class)->setName('StocksView-stocks-view'); // view
    $app->group(
        '/stocks',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StocksController::class . ':list')->add(PermissionMiddleware::class)->setName('stocks/list-stocks-list-2'); // list
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StocksController::class . ':view')->add(PermissionMiddleware::class)->setName('stocks/view-stocks-view-2'); // view
        }
    );

    // stock_order
    $app->any('/StockOrderList[/{id}]', StockOrderController::class . ':list')->add(PermissionMiddleware::class)->setName('StockOrderList-stock_order-list'); // list
    $app->any('/StockOrderAdd[/{id}]', StockOrderController::class . ':add')->add(PermissionMiddleware::class)->setName('StockOrderAdd-stock_order-add'); // add
    $app->any('/StockOrderView[/{id}]', StockOrderController::class . ':view')->add(PermissionMiddleware::class)->setName('StockOrderView-stock_order-view'); // view
    $app->any('/StockOrderEdit[/{id}]', StockOrderController::class . ':edit')->add(PermissionMiddleware::class)->setName('StockOrderEdit-stock_order-edit'); // edit
    $app->any('/StockOrderDelete[/{id}]', StockOrderController::class . ':delete')->add(PermissionMiddleware::class)->setName('StockOrderDelete-stock_order-delete'); // delete
    $app->group(
        '/stock_order',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StockOrderController::class . ':list')->add(PermissionMiddleware::class)->setName('stock_order/list-stock_order-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', StockOrderController::class . ':add')->add(PermissionMiddleware::class)->setName('stock_order/add-stock_order-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StockOrderController::class . ':view')->add(PermissionMiddleware::class)->setName('stock_order/view-stock_order-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', StockOrderController::class . ':edit')->add(PermissionMiddleware::class)->setName('stock_order/edit-stock_order-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', StockOrderController::class . ':delete')->add(PermissionMiddleware::class)->setName('stock_order/delete-stock_order-delete-2'); // delete
        }
    );

    // npd_label_kualitas
    $app->any('/NpdLabelKualitasList[/{id}]', NpdLabelKualitasController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdLabelKualitasList-npd_label_kualitas-list'); // list
    $app->any('/NpdLabelKualitasAdd[/{id}]', NpdLabelKualitasController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdLabelKualitasAdd-npd_label_kualitas-add'); // add
    $app->any('/NpdLabelKualitasEdit[/{id}]', NpdLabelKualitasController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdLabelKualitasEdit-npd_label_kualitas-edit'); // edit
    $app->any('/NpdLabelKualitasDelete[/{id}]', NpdLabelKualitasController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdLabelKualitasDelete-npd_label_kualitas-delete'); // delete
    $app->group(
        '/npd_label_kualitas',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdLabelKualitasController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_label_kualitas/list-npd_label_kualitas-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdLabelKualitasController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_label_kualitas/add-npd_label_kualitas-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdLabelKualitasController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_label_kualitas/edit-npd_label_kualitas-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdLabelKualitasController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_label_kualitas/delete-npd_label_kualitas-delete-2'); // delete
        }
    );

    // npd_viskositas_sediaan
    $app->any('/NpdViskositasSediaanList[/{id}]', NpdViskositasSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdViskositasSediaanList-npd_viskositas_sediaan-list'); // list
    $app->any('/NpdViskositasSediaanAdd[/{id}]', NpdViskositasSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdViskositasSediaanAdd-npd_viskositas_sediaan-add'); // add
    $app->any('/NpdViskositasSediaanEdit[/{id}]', NpdViskositasSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdViskositasSediaanEdit-npd_viskositas_sediaan-edit'); // edit
    $app->any('/NpdViskositasSediaanDelete[/{id}]', NpdViskositasSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdViskositasSediaanDelete-npd_viskositas_sediaan-delete'); // delete
    $app->group(
        '/npd_viskositas_sediaan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdViskositasSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_viskositas_sediaan/list-npd_viskositas_sediaan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdViskositasSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_viskositas_sediaan/add-npd_viskositas_sediaan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdViskositasSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_viskositas_sediaan/edit-npd_viskositas_sediaan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdViskositasSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_viskositas_sediaan/delete-npd_viskositas_sediaan-delete-2'); // delete
        }
    );

    // npd_warna_sediaan
    $app->any('/NpdWarnaSediaanList[/{id}]', NpdWarnaSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdWarnaSediaanList-npd_warna_sediaan-list'); // list
    $app->any('/NpdWarnaSediaanAdd[/{id}]', NpdWarnaSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdWarnaSediaanAdd-npd_warna_sediaan-add'); // add
    $app->any('/NpdWarnaSediaanEdit[/{id}]', NpdWarnaSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdWarnaSediaanEdit-npd_warna_sediaan-edit'); // edit
    $app->any('/NpdWarnaSediaanDelete[/{id}]', NpdWarnaSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdWarnaSediaanDelete-npd_warna_sediaan-delete'); // delete
    $app->group(
        '/npd_warna_sediaan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdWarnaSediaanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_warna_sediaan/list-npd_warna_sediaan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdWarnaSediaanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_warna_sediaan/add-npd_warna_sediaan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdWarnaSediaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_warna_sediaan/edit-npd_warna_sediaan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdWarnaSediaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_warna_sediaan/delete-npd_warna_sediaan-delete-2'); // delete
        }
    );

    // pengembangan_produk
    $app->any('/PengembanganProduk[/{params:.*}]', PengembanganProdukController::class)->add(PermissionMiddleware::class)->setName('PengembanganProduk-pengembangan_produk-custom'); // custom

    // stock_order_detail
    $app->any('/StockOrderDetailList[/{id}]', StockOrderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('StockOrderDetailList-stock_order_detail-list'); // list
    $app->any('/StockOrderDetailAdd[/{id}]', StockOrderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('StockOrderDetailAdd-stock_order_detail-add'); // add
    $app->any('/StockOrderDetailView[/{id}]', StockOrderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('StockOrderDetailView-stock_order_detail-view'); // view
    $app->any('/StockOrderDetailPreview', StockOrderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('StockOrderDetailPreview-stock_order_detail-preview'); // preview
    $app->group(
        '/stock_order_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StockOrderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('stock_order_detail/list-stock_order_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', StockOrderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('stock_order_detail/add-stock_order_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StockOrderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('stock_order_detail/view-stock_order_detail-view-2'); // view
            $group->any('/' . Config("PREVIEW_ACTION") . '', StockOrderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('stock_order_detail/preview-stock_order_detail-preview-2'); // preview
        }
    );

    // stock_deliveryorder
    $app->any('/StockDeliveryorderList[/{id}]', StockDeliveryorderController::class . ':list')->add(PermissionMiddleware::class)->setName('StockDeliveryorderList-stock_deliveryorder-list'); // list
    $app->any('/StockDeliveryorderAdd[/{id}]', StockDeliveryorderController::class . ':add')->add(PermissionMiddleware::class)->setName('StockDeliveryorderAdd-stock_deliveryorder-add'); // add
    $app->any('/StockDeliveryorderView[/{id}]', StockDeliveryorderController::class . ':view')->add(PermissionMiddleware::class)->setName('StockDeliveryorderView-stock_deliveryorder-view'); // view
    $app->any('/StockDeliveryorderEdit[/{id}]', StockDeliveryorderController::class . ':edit')->add(PermissionMiddleware::class)->setName('StockDeliveryorderEdit-stock_deliveryorder-edit'); // edit
    $app->any('/StockDeliveryorderDelete[/{id}]', StockDeliveryorderController::class . ':delete')->add(PermissionMiddleware::class)->setName('StockDeliveryorderDelete-stock_deliveryorder-delete'); // delete
    $app->group(
        '/stock_deliveryorder',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StockDeliveryorderController::class . ':list')->add(PermissionMiddleware::class)->setName('stock_deliveryorder/list-stock_deliveryorder-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', StockDeliveryorderController::class . ':add')->add(PermissionMiddleware::class)->setName('stock_deliveryorder/add-stock_deliveryorder-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StockDeliveryorderController::class . ':view')->add(PermissionMiddleware::class)->setName('stock_deliveryorder/view-stock_deliveryorder-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', StockDeliveryorderController::class . ':edit')->add(PermissionMiddleware::class)->setName('stock_deliveryorder/edit-stock_deliveryorder-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', StockDeliveryorderController::class . ':delete')->add(PermissionMiddleware::class)->setName('stock_deliveryorder/delete-stock_deliveryorder-delete-2'); // delete
        }
    );

    // stock_deliveryorder_detail
    $app->any('/StockDeliveryorderDetailList[/{id}]', StockDeliveryorderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('StockDeliveryorderDetailList-stock_deliveryorder_detail-list'); // list
    $app->any('/StockDeliveryorderDetailAdd[/{id}]', StockDeliveryorderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('StockDeliveryorderDetailAdd-stock_deliveryorder_detail-add'); // add
    $app->any('/StockDeliveryorderDetailView[/{id}]', StockDeliveryorderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('StockDeliveryorderDetailView-stock_deliveryorder_detail-view'); // view
    $app->any('/StockDeliveryorderDetailPreview', StockDeliveryorderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('StockDeliveryorderDetailPreview-stock_deliveryorder_detail-preview'); // preview
    $app->group(
        '/stock_deliveryorder_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', StockDeliveryorderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('stock_deliveryorder_detail/list-stock_deliveryorder_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', StockDeliveryorderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('stock_deliveryorder_detail/add-stock_deliveryorder_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', StockDeliveryorderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('stock_deliveryorder_detail/view-stock_deliveryorder_detail-view-2'); // view
            $group->any('/' . Config("PREVIEW_ACTION") . '', StockDeliveryorderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('stock_deliveryorder_detail/preview-stock_deliveryorder_detail-preview-2'); // preview
        }
    );

    // jenisproduk
    $app->any('/JenisprodukList[/{id}]', JenisprodukController::class . ':list')->add(PermissionMiddleware::class)->setName('JenisprodukList-jenisproduk-list'); // list
    $app->any('/JenisprodukAdd[/{id}]', JenisprodukController::class . ':add')->add(PermissionMiddleware::class)->setName('JenisprodukAdd-jenisproduk-add'); // add
    $app->any('/JenisprodukView[/{id}]', JenisprodukController::class . ':view')->add(PermissionMiddleware::class)->setName('JenisprodukView-jenisproduk-view'); // view
    $app->any('/JenisprodukEdit[/{id}]', JenisprodukController::class . ':edit')->add(PermissionMiddleware::class)->setName('JenisprodukEdit-jenisproduk-edit'); // edit
    $app->any('/JenisprodukDelete[/{id}]', JenisprodukController::class . ':delete')->add(PermissionMiddleware::class)->setName('JenisprodukDelete-jenisproduk-delete'); // delete
    $app->group(
        '/jenisproduk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', JenisprodukController::class . ':list')->add(PermissionMiddleware::class)->setName('jenisproduk/list-jenisproduk-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', JenisprodukController::class . ':add')->add(PermissionMiddleware::class)->setName('jenisproduk/add-jenisproduk-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', JenisprodukController::class . ':view')->add(PermissionMiddleware::class)->setName('jenisproduk/view-jenisproduk-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', JenisprodukController::class . ':edit')->add(PermissionMiddleware::class)->setName('jenisproduk/edit-jenisproduk-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', JenisprodukController::class . ':delete')->add(PermissionMiddleware::class)->setName('jenisproduk/delete-jenisproduk-delete-2'); // delete
        }
    );

    // kategoriproduk
    $app->any('/KategoriprodukList[/{id}]', KategoriprodukController::class . ':list')->add(PermissionMiddleware::class)->setName('KategoriprodukList-kategoriproduk-list'); // list
    $app->any('/KategoriprodukAdd[/{id}]', KategoriprodukController::class . ':add')->add(PermissionMiddleware::class)->setName('KategoriprodukAdd-kategoriproduk-add'); // add
    $app->any('/KategoriprodukView[/{id}]', KategoriprodukController::class . ':view')->add(PermissionMiddleware::class)->setName('KategoriprodukView-kategoriproduk-view'); // view
    $app->any('/KategoriprodukEdit[/{id}]', KategoriprodukController::class . ':edit')->add(PermissionMiddleware::class)->setName('KategoriprodukEdit-kategoriproduk-edit'); // edit
    $app->any('/KategoriprodukDelete[/{id}]', KategoriprodukController::class . ':delete')->add(PermissionMiddleware::class)->setName('KategoriprodukDelete-kategoriproduk-delete'); // delete
    $app->group(
        '/kategoriproduk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KategoriprodukController::class . ':list')->add(PermissionMiddleware::class)->setName('kategoriproduk/list-kategoriproduk-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KategoriprodukController::class . ':add')->add(PermissionMiddleware::class)->setName('kategoriproduk/add-kategoriproduk-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KategoriprodukController::class . ':view')->add(PermissionMiddleware::class)->setName('kategoriproduk/view-kategoriproduk-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KategoriprodukController::class . ':edit')->add(PermissionMiddleware::class)->setName('kategoriproduk/edit-kategoriproduk-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KategoriprodukController::class . ':delete')->add(PermissionMiddleware::class)->setName('kategoriproduk/delete-kategoriproduk-delete-2'); // delete
        }
    );

    // antrian_bot
    $app->any('/AntrianBot[/{params:.*}]', AntrianBotController::class)->add(PermissionMiddleware::class)->setName('AntrianBot-antrian_bot-custom'); // custom

    // tipe_sla
    $app->any('/TipeSlaList[/{id}]', TipeSlaController::class . ':list')->add(PermissionMiddleware::class)->setName('TipeSlaList-tipe_sla-list'); // list
    $app->any('/TipeSlaAdd[/{id}]', TipeSlaController::class . ':add')->add(PermissionMiddleware::class)->setName('TipeSlaAdd-tipe_sla-add'); // add
    $app->any('/TipeSlaView[/{id}]', TipeSlaController::class . ':view')->add(PermissionMiddleware::class)->setName('TipeSlaView-tipe_sla-view'); // view
    $app->any('/TipeSlaEdit[/{id}]', TipeSlaController::class . ':edit')->add(PermissionMiddleware::class)->setName('TipeSlaEdit-tipe_sla-edit'); // edit
    $app->group(
        '/tipe_sla',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TipeSlaController::class . ':list')->add(PermissionMiddleware::class)->setName('tipe_sla/list-tipe_sla-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TipeSlaController::class . ':add')->add(PermissionMiddleware::class)->setName('tipe_sla/add-tipe_sla-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TipeSlaController::class . ':view')->add(PermissionMiddleware::class)->setName('tipe_sla/view-tipe_sla-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TipeSlaController::class . ':edit')->add(PermissionMiddleware::class)->setName('tipe_sla/edit-tipe_sla-edit-2'); // edit
        }
    );

    // brandcustomer_edit2
    $app->any('/BrandcustomerEdit2[/{params:.*}]', BrandcustomerEdit2Controller::class)->add(PermissionMiddleware::class)->setName('BrandcustomerEdit2-brandcustomer_edit2-custom'); // custom

    // brandcustomer_delete2
    $app->any('/BrandcustomerDelete2[/{params:.*}]', BrandcustomerDelete2Controller::class)->add(PermissionMiddleware::class)->setName('BrandcustomerDelete2-brandcustomer_delete2-custom'); // custom

    // npd_kemasan_bahan
    $app->any('/NpdKemasanBahanList[/{id}]', NpdKemasanBahanController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdKemasanBahanList-npd_kemasan_bahan-list'); // list
    $app->any('/NpdKemasanBahanAdd[/{id}]', NpdKemasanBahanController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdKemasanBahanAdd-npd_kemasan_bahan-add'); // add
    $app->any('/NpdKemasanBahanEdit[/{id}]', NpdKemasanBahanController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdKemasanBahanEdit-npd_kemasan_bahan-edit'); // edit
    $app->any('/NpdKemasanBahanDelete[/{id}]', NpdKemasanBahanController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdKemasanBahanDelete-npd_kemasan_bahan-delete'); // delete
    $app->group(
        '/npd_kemasan_bahan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdKemasanBahanController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_kemasan_bahan/list-npd_kemasan_bahan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdKemasanBahanController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_kemasan_bahan/add-npd_kemasan_bahan-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdKemasanBahanController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_kemasan_bahan/edit-npd_kemasan_bahan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdKemasanBahanController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_kemasan_bahan/delete-npd_kemasan_bahan-delete-2'); // delete
        }
    );

    // npd_kemasan_bentuk
    $app->any('/NpdKemasanBentukList[/{id}]', NpdKemasanBentukController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdKemasanBentukList-npd_kemasan_bentuk-list'); // list
    $app->any('/NpdKemasanBentukAdd[/{id}]', NpdKemasanBentukController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdKemasanBentukAdd-npd_kemasan_bentuk-add'); // add
    $app->any('/NpdKemasanBentukEdit[/{id}]', NpdKemasanBentukController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdKemasanBentukEdit-npd_kemasan_bentuk-edit'); // edit
    $app->any('/NpdKemasanBentukDelete[/{id}]', NpdKemasanBentukController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdKemasanBentukDelete-npd_kemasan_bentuk-delete'); // delete
    $app->group(
        '/npd_kemasan_bentuk',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdKemasanBentukController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_kemasan_bentuk/list-npd_kemasan_bentuk-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdKemasanBentukController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_kemasan_bentuk/add-npd_kemasan_bentuk-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdKemasanBentukController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_kemasan_bentuk/edit-npd_kemasan_bentuk-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdKemasanBentukController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_kemasan_bentuk/delete-npd_kemasan_bentuk-delete-2'); // delete
        }
    );

    // npd_kemasan_komposisi
    $app->any('/NpdKemasanKomposisiList[/{id}]', NpdKemasanKomposisiController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdKemasanKomposisiList-npd_kemasan_komposisi-list'); // list
    $app->any('/NpdKemasanKomposisiAdd[/{id}]', NpdKemasanKomposisiController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdKemasanKomposisiAdd-npd_kemasan_komposisi-add'); // add
    $app->any('/NpdKemasanKomposisiEdit[/{id}]', NpdKemasanKomposisiController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdKemasanKomposisiEdit-npd_kemasan_komposisi-edit'); // edit
    $app->any('/NpdKemasanKomposisiDelete[/{id}]', NpdKemasanKomposisiController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdKemasanKomposisiDelete-npd_kemasan_komposisi-delete'); // delete
    $app->group(
        '/npd_kemasan_komposisi',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdKemasanKomposisiController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_kemasan_komposisi/list-npd_kemasan_komposisi-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdKemasanKomposisiController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_kemasan_komposisi/add-npd_kemasan_komposisi-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdKemasanKomposisiController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_kemasan_komposisi/edit-npd_kemasan_komposisi-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdKemasanKomposisiController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_kemasan_komposisi/delete-npd_kemasan_komposisi-delete-2'); // delete
        }
    );

    // npd_label_print
    $app->any('/NpdLabelPrintList[/{id}]', NpdLabelPrintController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdLabelPrintList-npd_label_print-list'); // list
    $app->any('/NpdLabelPrintAdd[/{id}]', NpdLabelPrintController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdLabelPrintAdd-npd_label_print-add'); // add
    $app->any('/NpdLabelPrintEdit[/{id}]', NpdLabelPrintController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdLabelPrintEdit-npd_label_print-edit'); // edit
    $app->any('/NpdLabelPrintDelete[/{id}]', NpdLabelPrintController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdLabelPrintDelete-npd_label_print-delete'); // delete
    $app->group(
        '/npd_label_print',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdLabelPrintController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_label_print/list-npd_label_print-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdLabelPrintController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_label_print/add-npd_label_print-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdLabelPrintController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_label_print/edit-npd_label_print-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdLabelPrintController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_label_print/delete-npd_label_print-delete-2'); // delete
        }
    );

    // npd_label_tekstur
    $app->any('/NpdLabelTeksturList[/{id}]', NpdLabelTeksturController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdLabelTeksturList-npd_label_tekstur-list'); // list
    $app->any('/NpdLabelTeksturAdd[/{id}]', NpdLabelTeksturController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdLabelTeksturAdd-npd_label_tekstur-add'); // add
    $app->any('/NpdLabelTeksturEdit[/{id}]', NpdLabelTeksturController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdLabelTeksturEdit-npd_label_tekstur-edit'); // edit
    $app->any('/NpdLabelTeksturDelete[/{id}]', NpdLabelTeksturController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdLabelTeksturDelete-npd_label_tekstur-delete'); // delete
    $app->group(
        '/npd_label_tekstur',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdLabelTeksturController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_label_tekstur/list-npd_label_tekstur-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdLabelTeksturController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_label_tekstur/add-npd_label_tekstur-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdLabelTeksturController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_label_tekstur/edit-npd_label_tekstur-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdLabelTeksturController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_label_tekstur/delete-npd_label_tekstur-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // reset_password
    $app->any('/resetpassword', OthersController::class . ':resetpassword')->add(PermissionMiddleware::class)->setName('resetpassword');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // captcha
    $app->any('/captcha[/{page}]', OthersController::class . ':captcha')->add(PermissionMiddleware::class)->setName('captcha');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
