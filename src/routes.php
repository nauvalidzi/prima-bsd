<?php

namespace PHPMaker2021\distributor;

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
    $app->any('/CustomerPreview', CustomerController::class . ':preview')->add(PermissionMiddleware::class)->setName('CustomerPreview-customer-preview'); // preview
    $app->group(
        '/customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', CustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('customer/list-customer-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', CustomerController::class . ':add')->add(PermissionMiddleware::class)->setName('customer/add-customer-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', CustomerController::class . ':view')->add(PermissionMiddleware::class)->setName('customer/view-customer-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', CustomerController::class . ':edit')->add(PermissionMiddleware::class)->setName('customer/edit-customer-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', CustomerController::class . ':delete')->add(PermissionMiddleware::class)->setName('customer/delete-customer-delete-2'); // delete
            $group->any('/' . Config("SEARCH_ACTION") . '', CustomerController::class . ':search')->add(PermissionMiddleware::class)->setName('customer/search-customer-search-2'); // search
            $group->any('/' . Config("PREVIEW_ACTION") . '', CustomerController::class . ':preview')->add(PermissionMiddleware::class)->setName('customer/preview-customer-preview-2'); // preview
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
    $app->any('/BrandPreview', BrandController::class . ':preview')->add(PermissionMiddleware::class)->setName('BrandPreview-brand-preview'); // preview
    $app->group(
        '/brand',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', BrandController::class . ':list')->add(PermissionMiddleware::class)->setName('brand/list-brand-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', BrandController::class . ':add')->add(PermissionMiddleware::class)->setName('brand/add-brand-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', BrandController::class . ':view')->add(PermissionMiddleware::class)->setName('brand/view-brand-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', BrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('brand/edit-brand-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', BrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('brand/delete-brand-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', BrandController::class . ':preview')->add(PermissionMiddleware::class)->setName('brand/preview-brand-preview-2'); // preview
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

    // jenisbarang
    $app->any('/JenisbarangList[/{id}]', JenisbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('JenisbarangList-jenisbarang-list'); // list
    $app->any('/JenisbarangAdd[/{id}]', JenisbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('JenisbarangAdd-jenisbarang-add'); // add
    $app->any('/JenisbarangView[/{id}]', JenisbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('JenisbarangView-jenisbarang-view'); // view
    $app->any('/JenisbarangEdit[/{id}]', JenisbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('JenisbarangEdit-jenisbarang-edit'); // edit
    $app->any('/JenisbarangDelete[/{id}]', JenisbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('JenisbarangDelete-jenisbarang-delete'); // delete
    $app->group(
        '/jenisbarang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', JenisbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('jenisbarang/list-jenisbarang-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', JenisbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('jenisbarang/add-jenisbarang-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', JenisbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('jenisbarang/view-jenisbarang-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', JenisbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('jenisbarang/edit-jenisbarang-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', JenisbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('jenisbarang/delete-jenisbarang-delete-2'); // delete
        }
    );

    // kategoribarang
    $app->any('/KategoribarangList[/{id}]', KategoribarangController::class . ':list')->add(PermissionMiddleware::class)->setName('KategoribarangList-kategoribarang-list'); // list
    $app->any('/KategoribarangAdd[/{id}]', KategoribarangController::class . ':add')->add(PermissionMiddleware::class)->setName('KategoribarangAdd-kategoribarang-add'); // add
    $app->any('/KategoribarangView[/{id}]', KategoribarangController::class . ':view')->add(PermissionMiddleware::class)->setName('KategoribarangView-kategoribarang-view'); // view
    $app->any('/KategoribarangEdit[/{id}]', KategoribarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('KategoribarangEdit-kategoribarang-edit'); // edit
    $app->any('/KategoribarangDelete[/{id}]', KategoribarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('KategoribarangDelete-kategoribarang-delete'); // delete
    $app->group(
        '/kategoribarang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KategoribarangController::class . ':list')->add(PermissionMiddleware::class)->setName('kategoribarang/list-kategoribarang-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KategoribarangController::class . ':add')->add(PermissionMiddleware::class)->setName('kategoribarang/add-kategoribarang-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KategoribarangController::class . ':view')->add(PermissionMiddleware::class)->setName('kategoribarang/view-kategoribarang-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KategoribarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('kategoribarang/edit-kategoribarang-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KategoribarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('kategoribarang/delete-kategoribarang-delete-2'); // delete
        }
    );

    // kualitasbarang
    $app->any('/KualitasbarangList[/{id}]', KualitasbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('KualitasbarangList-kualitasbarang-list'); // list
    $app->any('/KualitasbarangAdd[/{id}]', KualitasbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('KualitasbarangAdd-kualitasbarang-add'); // add
    $app->any('/KualitasbarangView[/{id}]', KualitasbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('KualitasbarangView-kualitasbarang-view'); // view
    $app->any('/KualitasbarangEdit[/{id}]', KualitasbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('KualitasbarangEdit-kualitasbarang-edit'); // edit
    $app->any('/KualitasbarangDelete[/{id}]', KualitasbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('KualitasbarangDelete-kualitasbarang-delete'); // delete
    $app->group(
        '/kualitasbarang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KualitasbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('kualitasbarang/list-kualitasbarang-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KualitasbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('kualitasbarang/add-kualitasbarang-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KualitasbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('kualitasbarang/view-kualitasbarang-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KualitasbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('kualitasbarang/edit-kualitasbarang-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KualitasbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('kualitasbarang/delete-kualitasbarang-delete-2'); // delete
        }
    );

    // kemasanbarang
    $app->any('/KemasanbarangList[/{id}]', KemasanbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('KemasanbarangList-kemasanbarang-list'); // list
    $app->any('/KemasanbarangAdd[/{id}]', KemasanbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('KemasanbarangAdd-kemasanbarang-add'); // add
    $app->any('/KemasanbarangView[/{id}]', KemasanbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('KemasanbarangView-kemasanbarang-view'); // view
    $app->any('/KemasanbarangEdit[/{id}]', KemasanbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('KemasanbarangEdit-kemasanbarang-edit'); // edit
    $app->any('/KemasanbarangDelete[/{id}]', KemasanbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('KemasanbarangDelete-kemasanbarang-delete'); // delete
    $app->group(
        '/kemasanbarang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KemasanbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('kemasanbarang/list-kemasanbarang-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KemasanbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('kemasanbarang/add-kemasanbarang-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KemasanbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('kemasanbarang/view-kemasanbarang-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KemasanbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('kemasanbarang/edit-kemasanbarang-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KemasanbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('kemasanbarang/delete-kemasanbarang-delete-2'); // delete
        }
    );

    // aplikasibarang
    $app->any('/AplikasibarangList[/{id}]', AplikasibarangController::class . ':list')->add(PermissionMiddleware::class)->setName('AplikasibarangList-aplikasibarang-list'); // list
    $app->any('/AplikasibarangAdd[/{id}]', AplikasibarangController::class . ':add')->add(PermissionMiddleware::class)->setName('AplikasibarangAdd-aplikasibarang-add'); // add
    $app->any('/AplikasibarangView[/{id}]', AplikasibarangController::class . ':view')->add(PermissionMiddleware::class)->setName('AplikasibarangView-aplikasibarang-view'); // view
    $app->any('/AplikasibarangEdit[/{id}]', AplikasibarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('AplikasibarangEdit-aplikasibarang-edit'); // edit
    $app->any('/AplikasibarangDelete[/{id}]', AplikasibarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('AplikasibarangDelete-aplikasibarang-delete'); // delete
    $app->group(
        '/aplikasibarang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', AplikasibarangController::class . ':list')->add(PermissionMiddleware::class)->setName('aplikasibarang/list-aplikasibarang-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', AplikasibarangController::class . ':add')->add(PermissionMiddleware::class)->setName('aplikasibarang/add-aplikasibarang-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', AplikasibarangController::class . ':view')->add(PermissionMiddleware::class)->setName('aplikasibarang/view-aplikasibarang-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', AplikasibarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('aplikasibarang/edit-aplikasibarang-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', AplikasibarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('aplikasibarang/delete-aplikasibarang-delete-2'); // delete
        }
    );

    // viskositasbarang
    $app->any('/ViskositasbarangList[/{id}]', ViskositasbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('ViskositasbarangList-viskositasbarang-list'); // list
    $app->any('/ViskositasbarangAdd[/{id}]', ViskositasbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('ViskositasbarangAdd-viskositasbarang-add'); // add
    $app->any('/ViskositasbarangView[/{id}]', ViskositasbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('ViskositasbarangView-viskositasbarang-view'); // view
    $app->any('/ViskositasbarangEdit[/{id}]', ViskositasbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('ViskositasbarangEdit-viskositasbarang-edit'); // edit
    $app->any('/ViskositasbarangDelete[/{id}]', ViskositasbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('ViskositasbarangDelete-viskositasbarang-delete'); // delete
    $app->group(
        '/viskositasbarang',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ViskositasbarangController::class . ':list')->add(PermissionMiddleware::class)->setName('viskositasbarang/list-viskositasbarang-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ViskositasbarangController::class . ':add')->add(PermissionMiddleware::class)->setName('viskositasbarang/add-viskositasbarang-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', ViskositasbarangController::class . ':view')->add(PermissionMiddleware::class)->setName('viskositasbarang/view-viskositasbarang-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', ViskositasbarangController::class . ':edit')->add(PermissionMiddleware::class)->setName('viskositasbarang/edit-viskositasbarang-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', ViskositasbarangController::class . ':delete')->add(PermissionMiddleware::class)->setName('viskositasbarang/delete-viskositasbarang-delete-2'); // delete
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

    // rekening
    $app->any('/RekeningList[/{id}]', RekeningController::class . ':list')->add(PermissionMiddleware::class)->setName('RekeningList-rekening-list'); // list
    $app->any('/RekeningAdd[/{id}]', RekeningController::class . ':add')->add(PermissionMiddleware::class)->setName('RekeningAdd-rekening-add'); // add
    $app->any('/RekeningView[/{id}]', RekeningController::class . ':view')->add(PermissionMiddleware::class)->setName('RekeningView-rekening-view'); // view
    $app->any('/RekeningEdit[/{id}]', RekeningController::class . ':edit')->add(PermissionMiddleware::class)->setName('RekeningEdit-rekening-edit'); // edit
    $app->any('/RekeningDelete[/{id}]', RekeningController::class . ':delete')->add(PermissionMiddleware::class)->setName('RekeningDelete-rekening-delete'); // delete
    $app->group(
        '/rekening',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', RekeningController::class . ':list')->add(PermissionMiddleware::class)->setName('rekening/list-rekening-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', RekeningController::class . ':add')->add(PermissionMiddleware::class)->setName('rekening/add-rekening-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', RekeningController::class . ':view')->add(PermissionMiddleware::class)->setName('rekening/view-rekening-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', RekeningController::class . ':edit')->add(PermissionMiddleware::class)->setName('rekening/edit-rekening-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', RekeningController::class . ':delete')->add(PermissionMiddleware::class)->setName('rekening/delete-rekening-delete-2'); // delete
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
    $app->any('/NpdView[/{id}]', NpdController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdView-npd-view'); // view
    $app->any('/NpdEdit[/{id}]', NpdController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdEdit-npd-edit'); // edit
    $app->any('/NpdDelete[/{id}]', NpdController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdDelete-npd-delete'); // delete
    $app->group(
        '/npd',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdController::class . ':list')->add(PermissionMiddleware::class)->setName('npd/list-npd-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdController::class . ':add')->add(PermissionMiddleware::class)->setName('npd/add-npd-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdController::class . ':view')->add(PermissionMiddleware::class)->setName('npd/view-npd-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd/edit-npd-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd/delete-npd-delete-2'); // delete
        }
    );

    // npd_status
    $app->any('/NpdStatusList[/{id}]', NpdStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('NpdStatusList-npd_status-list'); // list
    $app->any('/NpdStatusAdd[/{id}]', NpdStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('NpdStatusAdd-npd_status-add'); // add
    $app->any('/NpdStatusView[/{id}]', NpdStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('NpdStatusView-npd_status-view'); // view
    $app->any('/NpdStatusEdit[/{id}]', NpdStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('NpdStatusEdit-npd_status-edit'); // edit
    $app->any('/NpdStatusDelete[/{id}]', NpdStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('NpdStatusDelete-npd_status-delete'); // delete
    $app->any('/NpdStatusPreview', NpdStatusController::class . ':preview')->add(PermissionMiddleware::class)->setName('NpdStatusPreview-npd_status-preview'); // preview
    $app->group(
        '/npd_status',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NpdStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('npd_status/list-npd_status-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NpdStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('npd_status/add-npd_status-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NpdStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('npd_status/view-npd_status-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NpdStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('npd_status/edit-npd_status-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NpdStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('npd_status/delete-npd_status-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', NpdStatusController::class . ':preview')->add(PermissionMiddleware::class)->setName('npd_status/preview-npd_status-preview-2'); // preview
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

    // serahterima
    $app->any('/SerahterimaList[/{id}]', SerahterimaController::class . ':list')->add(PermissionMiddleware::class)->setName('SerahterimaList-serahterima-list'); // list
    $app->any('/SerahterimaAdd[/{id}]', SerahterimaController::class . ':add')->add(PermissionMiddleware::class)->setName('SerahterimaAdd-serahterima-add'); // add
    $app->any('/SerahterimaView[/{id}]', SerahterimaController::class . ':view')->add(PermissionMiddleware::class)->setName('SerahterimaView-serahterima-view'); // view
    $app->any('/SerahterimaEdit[/{id}]', SerahterimaController::class . ':edit')->add(PermissionMiddleware::class)->setName('SerahterimaEdit-serahterima-edit'); // edit
    $app->any('/SerahterimaDelete[/{id}]', SerahterimaController::class . ':delete')->add(PermissionMiddleware::class)->setName('SerahterimaDelete-serahterima-delete'); // delete
    $app->group(
        '/serahterima',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SerahterimaController::class . ':list')->add(PermissionMiddleware::class)->setName('serahterima/list-serahterima-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SerahterimaController::class . ':add')->add(PermissionMiddleware::class)->setName('serahterima/add-serahterima-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SerahterimaController::class . ':view')->add(PermissionMiddleware::class)->setName('serahterima/view-serahterima-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SerahterimaController::class . ':edit')->add(PermissionMiddleware::class)->setName('serahterima/edit-serahterima-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SerahterimaController::class . ':delete')->add(PermissionMiddleware::class)->setName('serahterima/delete-serahterima-delete-2'); // delete
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
    $app->any('/OrderEdit[/{id}]', OrderController::class . ':edit')->add(PermissionMiddleware::class)->setName('OrderEdit-order-edit'); // edit
    $app->any('/OrderDelete[/{id}]', OrderController::class . ':delete')->add(PermissionMiddleware::class)->setName('OrderDelete-order-delete'); // delete
    $app->any('/OrderPreview', OrderController::class . ':preview')->add(PermissionMiddleware::class)->setName('OrderPreview-order-preview'); // preview
    $app->group(
        '/order',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', OrderController::class . ':list')->add(PermissionMiddleware::class)->setName('order/list-order-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', OrderController::class . ':add')->add(PermissionMiddleware::class)->setName('order/add-order-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', OrderController::class . ':view')->add(PermissionMiddleware::class)->setName('order/view-order-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', OrderController::class . ':edit')->add(PermissionMiddleware::class)->setName('order/edit-order-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', OrderController::class . ':delete')->add(PermissionMiddleware::class)->setName('order/delete-order-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', OrderController::class . ':preview')->add(PermissionMiddleware::class)->setName('order/preview-order-preview-2'); // preview
        }
    );

    // order_detail
    $app->any('/OrderDetailList[/{id}]', OrderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('OrderDetailList-order_detail-list'); // list
    $app->any('/OrderDetailAdd[/{id}]', OrderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('OrderDetailAdd-order_detail-add'); // add
    $app->any('/OrderDetailView[/{id}]', OrderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('OrderDetailView-order_detail-view'); // view
    $app->any('/OrderDetailEdit[/{id}]', OrderDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('OrderDetailEdit-order_detail-edit'); // edit
    $app->any('/OrderDetailDelete[/{id}]', OrderDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('OrderDetailDelete-order_detail-delete'); // delete
    $app->any('/OrderDetailPreview', OrderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('OrderDetailPreview-order_detail-preview'); // preview
    $app->group(
        '/order_detail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', OrderDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('order_detail/list-order_detail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', OrderDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('order_detail/add-order_detail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', OrderDetailController::class . ':view')->add(PermissionMiddleware::class)->setName('order_detail/view-order_detail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', OrderDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('order_detail/edit-order_detail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', OrderDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('order_detail/delete-order_detail-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', OrderDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('order_detail/preview-order_detail-preview-2'); // preview
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

    // v_bonuscustomer
    $app->any('/VBonuscustomerList', VBonuscustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('VBonuscustomerList-v_bonuscustomer-list'); // list
    $app->group(
        '/v_bonuscustomer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VBonuscustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('v_bonuscustomer/list-v_bonuscustomer-list-2'); // list
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

    // print_suratjalan
    $app->any('/PrintSuratjalan[/{params:.*}]', PrintSuratjalanController::class)->add(PermissionMiddleware::class)->setName('PrintSuratjalan-print_suratjalan-custom'); // custom

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

    // v_npd_customer
    $app->any('/VNpdCustomerList[/{id}]', VNpdCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('VNpdCustomerList-v_npd_customer-list'); // list
    $app->group(
        '/v_npd_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', VNpdCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('v_npd_customer/list-v_npd_customer-list-2'); // list
        }
    );

    // brand_link
    $app->any('/BrandLinkList', BrandLinkController::class . ':list')->add(PermissionMiddleware::class)->setName('BrandLinkList-brand_link-list'); // list
    $app->group(
        '/brand_link',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', BrandLinkController::class . ':list')->add(PermissionMiddleware::class)->setName('brand_link/list-brand_link-list-2'); // list
        }
    );

    // v_brand_link
    $app->any('/VBrandLinkList[/{id}]', VBrandLinkController::class . ':list')->add(PermissionMiddleware::class)->setName('VBrandLinkList-v_brand_link-list'); // list
    $app->group(
        '/v_brand_link',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', VBrandLinkController::class . ':list')->add(PermissionMiddleware::class)->setName('v_brand_link/list-v_brand_link-list-2'); // list
        }
    );

    // v_order_customer
    $app->any('/VOrderCustomerList[/{idorder}/{idcustomer}]', VOrderCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('VOrderCustomerList-v_order_customer-list'); // list
    $app->group(
        '/v_order_customer',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{idorder}/{idcustomer}]', VOrderCustomerController::class . ':list')->add(PermissionMiddleware::class)->setName('v_order_customer/list-v_order_customer-list-2'); // list
        }
    );

    // laporan_purchase_order
    $app->any('/LaporanPurchaseOrder[/{params:.*}]', LaporanPurchaseOrderController::class)->add(PermissionMiddleware::class)->setName('LaporanPurchaseOrder-laporan_purchase_order-custom'); // custom

    // laporan_delivery_order
    $app->any('/LaporanDeliveryOrder[/{params:.*}]', LaporanDeliveryOrderController::class)->add(PermissionMiddleware::class)->setName('LaporanDeliveryOrder-laporan_delivery_order-custom'); // custom

    // laporan_invoice
    $app->any('/LaporanInvoice[/{params:.*}]', LaporanInvoiceController::class)->add(PermissionMiddleware::class)->setName('LaporanInvoice-laporan_invoice-custom'); // custom

    // laporan_surat_jalan
    $app->any('/LaporanSuratJalan[/{params:.*}]', LaporanSuratJalanController::class)->add(PermissionMiddleware::class)->setName('LaporanSuratJalan-laporan_surat_jalan-custom'); // custom

    // laporan_pembayaran
    $app->any('/LaporanPembayaran[/{params:.*}]', LaporanPembayaranController::class)->add(PermissionMiddleware::class)->setName('LaporanPembayaran-laporan_pembayaran-custom'); // custom

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

    // v_do_stock
    $app->any('/VDoStockList', VDoStockController::class . ':list')->add(PermissionMiddleware::class)->setName('VDoStockList-v_do_stock-list'); // list
    $app->group(
        '/v_do_stock',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VDoStockController::class . ':list')->add(PermissionMiddleware::class)->setName('v_do_stock/list-v_do_stock-list-2'); // list
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

    // laporan_kpi_marketing
    $app->any('/LaporanKpiMarketing[/{params:.*}]', LaporanKpiMarketingController::class)->add(PermissionMiddleware::class)->setName('LaporanKpiMarketing-laporan_kpi_marketing-custom'); // custom

    // laporan_kpi_marketing_detail
    $app->any('/LaporanKpiMarketingDetail[/{params:.*}]', LaporanKpiMarketingDetailController::class)->add(PermissionMiddleware::class)->setName('LaporanKpiMarketingDetail-laporan_kpi_marketing_detail-custom'); // custom

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

    // penomoran
    $app->any('/PenomoranList', PenomoranController::class . ':list')->add(PermissionMiddleware::class)->setName('PenomoranList-penomoran-list'); // list
    $app->group(
        '/penomoran',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', PenomoranController::class . ':list')->add(PermissionMiddleware::class)->setName('penomoran/list-penomoran-list-2'); // list
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

    // bot_history
    $app->any('/BotHistoryList', BotHistoryController::class . ':list')->add(PermissionMiddleware::class)->setName('BotHistoryList-bot_history-list'); // list
    $app->group(
        '/bot_history',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', BotHistoryController::class . ':list')->add(PermissionMiddleware::class)->setName('bot_history/list-bot_history-list-2'); // list
        }
    );

    // v_penagihan
    $app->any('/VPenagihanList', VPenagihanController::class . ':list')->add(PermissionMiddleware::class)->setName('VPenagihanList-v_penagihan-list'); // list
    $app->group(
        '/v_penagihan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', VPenagihanController::class . ':list')->add(PermissionMiddleware::class)->setName('v_penagihan/list-v_penagihan-list-2'); // list
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

    // laporan_order_customer
    $app->any('/LaporanOrderCustomer[/{params:.*}]', LaporanOrderCustomerController::class)->add(PermissionMiddleware::class)->setName('LaporanOrderCustomer-laporan_order_customer-custom'); // custom

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
