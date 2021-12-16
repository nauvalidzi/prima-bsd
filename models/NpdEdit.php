<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdEdit extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdEdit";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (npd)
        if (!isset($GLOBALS["npd"]) || get_class($GLOBALS["npd"]) == PROJECT_NAMESPACE . "npd") {
            $GLOBALS["npd"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("npd"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NpdView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;
    public $DetailPages; // Detail pages object

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idbrand->setVisibility();
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->sifatorder->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->setVisibility();
        $this->idproduct_acuan->Visible = false;
        $this->kategoriproduk->setVisibility();
        $this->jenisproduk->setVisibility();
        $this->fungsiproduk->setVisibility();
        $this->kualitasproduk->setVisibility();
        $this->bahan_campaign->setVisibility();
        $this->ukuran_sediaan->setVisibility();
        $this->bentuk->setVisibility();
        $this->viskositas->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->aplikasi->setVisibility();
        $this->tambahan->setVisibility();
        $this->ukurankemasan->setVisibility();
        $this->kemasanbentuk->setVisibility();
        $this->kemasantutup->setVisibility();
        $this->kemasancatatan->setVisibility();
        $this->labelbahan->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->setVisibility();
        $this->status->setVisibility();
        $this->readonly->Visible = false;
        $this->selesai->Visible = false;
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->estetika->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->idpegawai->Required = false;
        $this->idcustomer->Required = false;
        $this->kodeorder->Required = false;

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idbrand);
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->kategoriproduk);
        $this->setupLookupOptions($this->jenisproduk);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("NpdList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "NpdList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idpegawai' first before field var 'x_idpegawai'
        $val = $CurrentForm->hasValue("idpegawai") ? $CurrentForm->getValue("idpegawai") : $CurrentForm->getValue("x_idpegawai");
        if (!$this->idpegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idpegawai->Visible = false; // Disable update for API request
            } else {
                $this->idpegawai->setFormValue($val);
            }
        }

        // Check field name 'idcustomer' first before field var 'x_idcustomer'
        $val = $CurrentForm->hasValue("idcustomer") ? $CurrentForm->getValue("idcustomer") : $CurrentForm->getValue("x_idcustomer");
        if (!$this->idcustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idcustomer->Visible = false; // Disable update for API request
            } else {
                $this->idcustomer->setFormValue($val);
            }
        }

        // Check field name 'idbrand' first before field var 'x_idbrand'
        $val = $CurrentForm->hasValue("idbrand") ? $CurrentForm->getValue("idbrand") : $CurrentForm->getValue("x_idbrand");
        if (!$this->idbrand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idbrand->Visible = false; // Disable update for API request
            } else {
                $this->idbrand->setFormValue($val);
            }
        }

        // Check field name 'tanggal_order' first before field var 'x_tanggal_order'
        $val = $CurrentForm->hasValue("tanggal_order") ? $CurrentForm->getValue("tanggal_order") : $CurrentForm->getValue("x_tanggal_order");
        if (!$this->tanggal_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_order->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_order->setFormValue($val);
            }
            $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        }

        // Check field name 'target_selesai' first before field var 'x_target_selesai'
        $val = $CurrentForm->hasValue("target_selesai") ? $CurrentForm->getValue("target_selesai") : $CurrentForm->getValue("x_target_selesai");
        if (!$this->target_selesai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->target_selesai->Visible = false; // Disable update for API request
            } else {
                $this->target_selesai->setFormValue($val);
            }
            $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        }

        // Check field name 'sifatorder' first before field var 'x_sifatorder'
        $val = $CurrentForm->hasValue("sifatorder") ? $CurrentForm->getValue("sifatorder") : $CurrentForm->getValue("x_sifatorder");
        if (!$this->sifatorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sifatorder->Visible = false; // Disable update for API request
            } else {
                $this->sifatorder->setFormValue($val);
            }
        }

        // Check field name 'kodeorder' first before field var 'x_kodeorder'
        $val = $CurrentForm->hasValue("kodeorder") ? $CurrentForm->getValue("kodeorder") : $CurrentForm->getValue("x_kodeorder");
        if (!$this->kodeorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodeorder->Visible = false; // Disable update for API request
            } else {
                $this->kodeorder->setFormValue($val);
            }
        }

        // Check field name 'nomororder' first before field var 'x_nomororder'
        $val = $CurrentForm->hasValue("nomororder") ? $CurrentForm->getValue("nomororder") : $CurrentForm->getValue("x_nomororder");
        if (!$this->nomororder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomororder->Visible = false; // Disable update for API request
            } else {
                $this->nomororder->setFormValue($val);
            }
        }

        // Check field name 'kategoriproduk' first before field var 'x_kategoriproduk'
        $val = $CurrentForm->hasValue("kategoriproduk") ? $CurrentForm->getValue("kategoriproduk") : $CurrentForm->getValue("x_kategoriproduk");
        if (!$this->kategoriproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategoriproduk->Visible = false; // Disable update for API request
            } else {
                $this->kategoriproduk->setFormValue($val);
            }
        }

        // Check field name 'jenisproduk' first before field var 'x_jenisproduk'
        $val = $CurrentForm->hasValue("jenisproduk") ? $CurrentForm->getValue("jenisproduk") : $CurrentForm->getValue("x_jenisproduk");
        if (!$this->jenisproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenisproduk->Visible = false; // Disable update for API request
            } else {
                $this->jenisproduk->setFormValue($val);
            }
        }

        // Check field name 'fungsiproduk' first before field var 'x_fungsiproduk'
        $val = $CurrentForm->hasValue("fungsiproduk") ? $CurrentForm->getValue("fungsiproduk") : $CurrentForm->getValue("x_fungsiproduk");
        if (!$this->fungsiproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fungsiproduk->Visible = false; // Disable update for API request
            } else {
                $this->fungsiproduk->setFormValue($val);
            }
        }

        // Check field name 'kualitasproduk' first before field var 'x_kualitasproduk'
        $val = $CurrentForm->hasValue("kualitasproduk") ? $CurrentForm->getValue("kualitasproduk") : $CurrentForm->getValue("x_kualitasproduk");
        if (!$this->kualitasproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kualitasproduk->Visible = false; // Disable update for API request
            } else {
                $this->kualitasproduk->setFormValue($val);
            }
        }

        // Check field name 'bahan_campaign' first before field var 'x_bahan_campaign'
        $val = $CurrentForm->hasValue("bahan_campaign") ? $CurrentForm->getValue("bahan_campaign") : $CurrentForm->getValue("x_bahan_campaign");
        if (!$this->bahan_campaign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahan_campaign->Visible = false; // Disable update for API request
            } else {
                $this->bahan_campaign->setFormValue($val);
            }
        }

        // Check field name 'ukuran_sediaan' first before field var 'x_ukuran_sediaan'
        $val = $CurrentForm->hasValue("ukuran_sediaan") ? $CurrentForm->getValue("ukuran_sediaan") : $CurrentForm->getValue("x_ukuran_sediaan");
        if (!$this->ukuran_sediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran_sediaan->Visible = false; // Disable update for API request
            } else {
                $this->ukuran_sediaan->setFormValue($val);
            }
        }

        // Check field name 'bentuk' first before field var 'x_bentuk'
        $val = $CurrentForm->hasValue("bentuk") ? $CurrentForm->getValue("bentuk") : $CurrentForm->getValue("x_bentuk");
        if (!$this->bentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk->Visible = false; // Disable update for API request
            } else {
                $this->bentuk->setFormValue($val);
            }
        }

        // Check field name 'viskositas' first before field var 'x_viskositas'
        $val = $CurrentForm->hasValue("viskositas") ? $CurrentForm->getValue("viskositas") : $CurrentForm->getValue("x_viskositas");
        if (!$this->viskositas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositas->Visible = false; // Disable update for API request
            } else {
                $this->viskositas->setFormValue($val);
            }
        }

        // Check field name 'warna' first before field var 'x_warna'
        $val = $CurrentForm->hasValue("warna") ? $CurrentForm->getValue("warna") : $CurrentForm->getValue("x_warna");
        if (!$this->warna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->warna->Visible = false; // Disable update for API request
            } else {
                $this->warna->setFormValue($val);
            }
        }

        // Check field name 'parfum' first before field var 'x_parfum'
        $val = $CurrentForm->hasValue("parfum") ? $CurrentForm->getValue("parfum") : $CurrentForm->getValue("x_parfum");
        if (!$this->parfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parfum->Visible = false; // Disable update for API request
            } else {
                $this->parfum->setFormValue($val);
            }
        }

        // Check field name 'aplikasi' first before field var 'x_aplikasi'
        $val = $CurrentForm->hasValue("aplikasi") ? $CurrentForm->getValue("aplikasi") : $CurrentForm->getValue("x_aplikasi");
        if (!$this->aplikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasi->setFormValue($val);
            }
        }

        // Check field name 'tambahan' first before field var 'x_tambahan'
        $val = $CurrentForm->hasValue("tambahan") ? $CurrentForm->getValue("tambahan") : $CurrentForm->getValue("x_tambahan");
        if (!$this->tambahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tambahan->Visible = false; // Disable update for API request
            } else {
                $this->tambahan->setFormValue($val);
            }
        }

        // Check field name 'ukurankemasan' first before field var 'x_ukurankemasan'
        $val = $CurrentForm->hasValue("ukurankemasan") ? $CurrentForm->getValue("ukurankemasan") : $CurrentForm->getValue("x_ukurankemasan");
        if (!$this->ukurankemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukurankemasan->Visible = false; // Disable update for API request
            } else {
                $this->ukurankemasan->setFormValue($val);
            }
        }

        // Check field name 'kemasanbentuk' first before field var 'x_kemasanbentuk'
        $val = $CurrentForm->hasValue("kemasanbentuk") ? $CurrentForm->getValue("kemasanbentuk") : $CurrentForm->getValue("x_kemasanbentuk");
        if (!$this->kemasanbentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanbentuk->Visible = false; // Disable update for API request
            } else {
                $this->kemasanbentuk->setFormValue($val);
            }
        }

        // Check field name 'kemasantutup' first before field var 'x_kemasantutup'
        $val = $CurrentForm->hasValue("kemasantutup") ? $CurrentForm->getValue("kemasantutup") : $CurrentForm->getValue("x_kemasantutup");
        if (!$this->kemasantutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasantutup->Visible = false; // Disable update for API request
            } else {
                $this->kemasantutup->setFormValue($val);
            }
        }

        // Check field name 'kemasancatatan' first before field var 'x_kemasancatatan'
        $val = $CurrentForm->hasValue("kemasancatatan") ? $CurrentForm->getValue("kemasancatatan") : $CurrentForm->getValue("x_kemasancatatan");
        if (!$this->kemasancatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasancatatan->Visible = false; // Disable update for API request
            } else {
                $this->kemasancatatan->setFormValue($val);
            }
        }

        // Check field name 'labelbahan' first before field var 'x_labelbahan'
        $val = $CurrentForm->hasValue("labelbahan") ? $CurrentForm->getValue("labelbahan") : $CurrentForm->getValue("x_labelbahan");
        if (!$this->labelbahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelbahan->Visible = false; // Disable update for API request
            } else {
                $this->labelbahan->setFormValue($val);
            }
        }

        // Check field name 'labelkualitas' first before field var 'x_labelkualitas'
        $val = $CurrentForm->hasValue("labelkualitas") ? $CurrentForm->getValue("labelkualitas") : $CurrentForm->getValue("x_labelkualitas");
        if (!$this->labelkualitas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelkualitas->Visible = false; // Disable update for API request
            } else {
                $this->labelkualitas->setFormValue($val);
            }
        }

        // Check field name 'labelposisi' first before field var 'x_labelposisi'
        $val = $CurrentForm->hasValue("labelposisi") ? $CurrentForm->getValue("labelposisi") : $CurrentForm->getValue("x_labelposisi");
        if (!$this->labelposisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelposisi->Visible = false; // Disable update for API request
            } else {
                $this->labelposisi->setFormValue($val);
            }
        }

        // Check field name 'labelcatatan' first before field var 'x_labelcatatan'
        $val = $CurrentForm->hasValue("labelcatatan") ? $CurrentForm->getValue("labelcatatan") : $CurrentForm->getValue("x_labelcatatan");
        if (!$this->labelcatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelcatatan->Visible = false; // Disable update for API request
            } else {
                $this->labelcatatan->setFormValue($val);
            }
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'estetika' first before field var 'x_estetika'
        $val = $CurrentForm->hasValue("estetika") ? $CurrentForm->getValue("estetika") : $CurrentForm->getValue("x_estetika");
        if (!$this->estetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetika->Visible = false; // Disable update for API request
            } else {
                $this->estetika->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->idbrand->CurrentValue = $this->idbrand->FormValue;
        $this->tanggal_order->CurrentValue = $this->tanggal_order->FormValue;
        $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        $this->target_selesai->CurrentValue = $this->target_selesai->FormValue;
        $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        $this->sifatorder->CurrentValue = $this->sifatorder->FormValue;
        $this->kodeorder->CurrentValue = $this->kodeorder->FormValue;
        $this->nomororder->CurrentValue = $this->nomororder->FormValue;
        $this->kategoriproduk->CurrentValue = $this->kategoriproduk->FormValue;
        $this->jenisproduk->CurrentValue = $this->jenisproduk->FormValue;
        $this->fungsiproduk->CurrentValue = $this->fungsiproduk->FormValue;
        $this->kualitasproduk->CurrentValue = $this->kualitasproduk->FormValue;
        $this->bahan_campaign->CurrentValue = $this->bahan_campaign->FormValue;
        $this->ukuran_sediaan->CurrentValue = $this->ukuran_sediaan->FormValue;
        $this->bentuk->CurrentValue = $this->bentuk->FormValue;
        $this->viskositas->CurrentValue = $this->viskositas->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->aplikasi->CurrentValue = $this->aplikasi->FormValue;
        $this->tambahan->CurrentValue = $this->tambahan->FormValue;
        $this->ukurankemasan->CurrentValue = $this->ukurankemasan->FormValue;
        $this->kemasanbentuk->CurrentValue = $this->kemasanbentuk->FormValue;
        $this->kemasantutup->CurrentValue = $this->kemasantutup->FormValue;
        $this->kemasancatatan->CurrentValue = $this->kemasancatatan->FormValue;
        $this->labelbahan->CurrentValue = $this->labelbahan->FormValue;
        $this->labelkualitas->CurrentValue = $this->labelkualitas->FormValue;
        $this->labelposisi->CurrentValue = $this->labelposisi->FormValue;
        $this->labelcatatan->CurrentValue = $this->labelcatatan->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->estetika->CurrentValue = $this->estetika->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->status->setDbValue($row['status']);
        $this->readonly->setDbValue($row['readonly']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->estetika->setDbValue($row['estetika']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['idbrand'] = null;
        $row['tanggal_order'] = null;
        $row['target_selesai'] = null;
        $row['sifatorder'] = null;
        $row['kodeorder'] = null;
        $row['nomororder'] = null;
        $row['idproduct_acuan'] = null;
        $row['kategoriproduk'] = null;
        $row['jenisproduk'] = null;
        $row['fungsiproduk'] = null;
        $row['kualitasproduk'] = null;
        $row['bahan_campaign'] = null;
        $row['ukuran_sediaan'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['aplikasi'] = null;
        $row['tambahan'] = null;
        $row['ukurankemasan'] = null;
        $row['kemasanbentuk'] = null;
        $row['kemasantutup'] = null;
        $row['kemasancatatan'] = null;
        $row['labelbahan'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['status'] = null;
        $row['readonly'] = null;
        $row['selesai'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['estetika'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // idpegawai

        // idcustomer

        // idbrand

        // tanggal_order

        // target_selesai

        // sifatorder

        // kodeorder

        // nomororder

        // idproduct_acuan

        // kategoriproduk

        // jenisproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuran_sediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // tambahan

        // ukurankemasan

        // kemasanbentuk

        // kemasantutup

        // kemasancatatan

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // status

        // readonly

        // selesai

        // created_at

        // updated_at

        // estetika
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idpegawai
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
                if ($this->idpegawai->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                        $this->idpegawai->ViewValue = $this->idpegawai->displayValue($arwrk);
                    } else {
                        $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
                    }
                }
            } else {
                $this->idpegawai->ViewValue = null;
            }
            $this->idpegawai->ViewCustomAttributes = "";

            // idcustomer
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idcustomer->ViewValue = $this->idcustomer->displayValue($arwrk);
                    } else {
                        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
                    }
                }
            } else {
                $this->idcustomer->ViewValue = null;
            }
            $this->idcustomer->ViewCustomAttributes = "";

            // idbrand
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
                if ($this->idbrand->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idbrand`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idbrand->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idbrand->Lookup->renderViewRow($rswrk[0]);
                        $this->idbrand->ViewValue = $this->idbrand->displayValue($arwrk);
                    } else {
                        $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
                    }
                }
            } else {
                $this->idbrand->ViewValue = null;
            }
            $this->idbrand->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // sifatorder
            if (strval($this->sifatorder->CurrentValue) != "") {
                $this->sifatorder->ViewValue = $this->sifatorder->optionCaption($this->sifatorder->CurrentValue);
            } else {
                $this->sifatorder->ViewValue = null;
            }
            $this->sifatorder->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->ViewValue = $this->nomororder->CurrentValue;
            $this->nomororder->ViewCustomAttributes = "";

            // kategoriproduk
            $curVal = trim(strval($this->kategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->lookupCacheOption($curVal);
                if ($this->kategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`grup`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->displayValue($arwrk);
                    } else {
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->kategoriproduk->ViewValue = null;
            }
            $this->kategoriproduk->ViewCustomAttributes = "";

            // jenisproduk
            $curVal = trim(strval($this->jenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->jenisproduk->ViewValue = $this->jenisproduk->lookupCacheOption($curVal);
                if ($this->jenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`kategori`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->jenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->jenisproduk->ViewValue = $this->jenisproduk->displayValue($arwrk);
                    } else {
                        $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->jenisproduk->ViewValue = null;
            }
            $this->jenisproduk->ViewCustomAttributes = "";

            // fungsiproduk
            $this->fungsiproduk->ViewValue = $this->fungsiproduk->CurrentValue;
            $this->fungsiproduk->ViewCustomAttributes = "";

            // kualitasproduk
            $this->kualitasproduk->ViewValue = $this->kualitasproduk->CurrentValue;
            $this->kualitasproduk->ViewCustomAttributes = "";

            // bahan_campaign
            $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
            $this->bahan_campaign->ViewCustomAttributes = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->ViewValue = $this->ukuran_sediaan->CurrentValue;
            $this->ukuran_sediaan->ViewCustomAttributes = "";

            // bentuk
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
                if ($this->bentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`sediaan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->bentuk->ViewValue = $this->bentuk->displayValue($arwrk);
                    } else {
                        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
                    }
                }
            } else {
                $this->bentuk->ViewValue = null;
            }
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
            $this->viskositas->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $filterWrk = "`fragrance`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parfum->Lookup->renderViewRow($rswrk[0]);
                        $this->parfum->ViewValue = $this->parfum->displayValue($arwrk);
                    } else {
                        $this->parfum->ViewValue = $this->parfum->CurrentValue;
                    }
                }
            } else {
                $this->parfum->ViewValue = null;
            }
            $this->parfum->ViewCustomAttributes = "";

            // aplikasi
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
                if ($this->aplikasi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`aplikasi_sediaan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->aplikasi->Lookup->renderViewRow($rswrk[0]);
                        $this->aplikasi->ViewValue = $this->aplikasi->displayValue($arwrk);
                    } else {
                        $this->aplikasi->ViewValue = $this->aplikasi->CurrentValue;
                    }
                }
            } else {
                $this->aplikasi->ViewValue = null;
            }
            $this->aplikasi->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // ukurankemasan
            $this->ukurankemasan->ViewValue = $this->ukurankemasan->CurrentValue;
            $this->ukurankemasan->ViewCustomAttributes = "";

            // kemasanbentuk
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
                if ($this->kemasanbentuk->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kemasanbentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kemasanbentuk->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kemasanbentuk->Lookup->renderViewRow($row);
                            $this->kemasanbentuk->ViewValue->add($this->kemasanbentuk->displayValue($arwrk));
                        }
                    } else {
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbentuk->ViewValue = null;
            }
            $this->kemasanbentuk->ViewCustomAttributes = "";

            // kemasantutup
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
                if ($this->kemasantutup->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kemasantutup->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kemasantutup->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kemasantutup->Lookup->renderViewRow($row);
                            $this->kemasantutup->ViewValue->add($this->kemasantutup->displayValue($arwrk));
                        }
                    } else {
                        $this->kemasantutup->ViewValue = $this->kemasantutup->CurrentValue;
                    }
                }
            } else {
                $this->kemasantutup->ViewValue = null;
            }
            $this->kemasantutup->ViewCustomAttributes = "";

            // kemasancatatan
            $this->kemasancatatan->ViewValue = $this->kemasancatatan->CurrentValue;
            $this->kemasancatatan->ViewCustomAttributes = "";

            // labelbahan
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
                if ($this->labelbahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelbahan->Lookup->renderViewRow($rswrk[0]);
                        $this->labelbahan->ViewValue = $this->labelbahan->displayValue($arwrk);
                    } else {
                        $this->labelbahan->ViewValue = $this->labelbahan->CurrentValue;
                    }
                }
            } else {
                $this->labelbahan->ViewValue = null;
            }
            $this->labelbahan->ViewCustomAttributes = "";

            // labelkualitas
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
                if ($this->labelkualitas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelkualitas->Lookup->renderViewRow($rswrk[0]);
                        $this->labelkualitas->ViewValue = $this->labelkualitas->displayValue($arwrk);
                    } else {
                        $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
                    }
                }
            } else {
                $this->labelkualitas->ViewValue = null;
            }
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
                if ($this->labelposisi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelposisi->Lookup->renderViewRow($rswrk[0]);
                        $this->labelposisi->ViewValue = $this->labelposisi->displayValue($arwrk);
                    } else {
                        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
                    }
                }
            } else {
                $this->labelposisi->ViewValue = null;
            }
            $this->labelposisi->ViewCustomAttributes = "";

            // labelcatatan
            $this->labelcatatan->ViewValue = $this->labelcatatan->CurrentValue;
            $this->labelcatatan->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 11);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 17);
            $this->updated_at->ViewCustomAttributes = "";

            // estetika
            $this->estetika->ViewValue = $this->estetika->CurrentValue;
            $this->estetika->ViewCustomAttributes = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";
            $this->sifatorder->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";
            $this->nomororder->TooltipValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";
            $this->kategoriproduk->TooltipValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";
            $this->jenisproduk->TooltipValue = "";

            // fungsiproduk
            $this->fungsiproduk->LinkCustomAttributes = "";
            $this->fungsiproduk->HrefValue = "";
            $this->fungsiproduk->TooltipValue = "";

            // kualitasproduk
            $this->kualitasproduk->LinkCustomAttributes = "";
            $this->kualitasproduk->HrefValue = "";
            $this->kualitasproduk->TooltipValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";
            $this->bahan_campaign->TooltipValue = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->LinkCustomAttributes = "";
            $this->ukuran_sediaan->HrefValue = "";
            $this->ukuran_sediaan->TooltipValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";
            $this->bentuk->TooltipValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";
            $this->viskositas->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // aplikasi
            $this->aplikasi->LinkCustomAttributes = "";
            $this->aplikasi->HrefValue = "";
            $this->aplikasi->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // ukurankemasan
            $this->ukurankemasan->LinkCustomAttributes = "";
            $this->ukurankemasan->HrefValue = "";
            $this->ukurankemasan->TooltipValue = "";

            // kemasanbentuk
            $this->kemasanbentuk->LinkCustomAttributes = "";
            $this->kemasanbentuk->HrefValue = "";
            $this->kemasanbentuk->TooltipValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";
            $this->kemasantutup->TooltipValue = "";

            // kemasancatatan
            $this->kemasancatatan->LinkCustomAttributes = "";
            $this->kemasancatatan->HrefValue = "";
            $this->kemasancatatan->TooltipValue = "";

            // labelbahan
            $this->labelbahan->LinkCustomAttributes = "";
            $this->labelbahan->HrefValue = "";
            $this->labelbahan->TooltipValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";
            $this->labelkualitas->TooltipValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";
            $this->labelposisi->TooltipValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";
            $this->labelcatatan->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";
            $this->estetika->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->EditValue = $this->idpegawai->lookupCacheOption($curVal);
                if ($this->idpegawai->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                        $this->idpegawai->EditValue = $this->idpegawai->displayValue($arwrk);
                    } else {
                        $this->idpegawai->EditValue = $this->idpegawai->CurrentValue;
                    }
                }
            } else {
                $this->idpegawai->EditValue = null;
            }
            $this->idpegawai->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->EditValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idcustomer->EditValue = $this->idcustomer->displayValue($arwrk);
                    } else {
                        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
                    }
                }
            } else {
                $this->idcustomer->EditValue = null;
            }
            $this->idcustomer->ViewCustomAttributes = "";

            // idbrand
            $this->idbrand->EditAttrs["class"] = "form-control";
            $this->idbrand->EditCustomAttributes = "";
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
            } else {
                $this->idbrand->ViewValue = $this->idbrand->Lookup !== null && is_array($this->idbrand->Lookup->Options) ? $curVal : null;
            }
            if ($this->idbrand->ViewValue !== null) { // Load from cache
                $this->idbrand->EditValue = array_values($this->idbrand->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`idbrand`" . SearchString("=", $this->idbrand->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idbrand->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idbrand->EditValue = $arwrk;
            }
            $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

            // tanggal_order
            $this->tanggal_order->EditAttrs["class"] = "form-control";
            $this->tanggal_order->EditCustomAttributes = "";
            $this->tanggal_order->EditValue = HtmlEncode(FormatDateTime($this->tanggal_order->CurrentValue, 8));
            $this->tanggal_order->PlaceHolder = RemoveHtml($this->tanggal_order->caption());

            // target_selesai
            $this->target_selesai->EditAttrs["class"] = "form-control";
            $this->target_selesai->EditCustomAttributes = "";
            $this->target_selesai->EditValue = HtmlEncode(FormatDateTime($this->target_selesai->CurrentValue, 8));
            $this->target_selesai->PlaceHolder = RemoveHtml($this->target_selesai->caption());

            // sifatorder
            $this->sifatorder->EditCustomAttributes = "";
            $this->sifatorder->EditValue = $this->sifatorder->options(false);
            $this->sifatorder->PlaceHolder = RemoveHtml($this->sifatorder->caption());

            // kodeorder
            $this->kodeorder->EditAttrs["class"] = "form-control";
            $this->kodeorder->EditCustomAttributes = "";
            $this->kodeorder->EditValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->EditAttrs["class"] = "form-control";
            $this->nomororder->EditCustomAttributes = "";
            if (!$this->nomororder->Raw) {
                $this->nomororder->CurrentValue = HtmlDecode($this->nomororder->CurrentValue);
            }
            $this->nomororder->EditValue = HtmlEncode($this->nomororder->CurrentValue);
            $this->nomororder->PlaceHolder = RemoveHtml($this->nomororder->caption());

            // kategoriproduk
            $this->kategoriproduk->EditAttrs["class"] = "form-control";
            $this->kategoriproduk->EditCustomAttributes = "";
            $curVal = trim(strval($this->kategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->lookupCacheOption($curVal);
            } else {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->Lookup !== null && is_array($this->kategoriproduk->Lookup->Options) ? $curVal : null;
            }
            if ($this->kategoriproduk->ViewValue !== null) { // Load from cache
                $this->kategoriproduk->EditValue = array_values($this->kategoriproduk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`grup`" . SearchString("=", $this->kategoriproduk->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kategoriproduk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kategoriproduk->EditValue = $arwrk;
            }
            $this->kategoriproduk->PlaceHolder = RemoveHtml($this->kategoriproduk->caption());

            // jenisproduk
            $this->jenisproduk->EditAttrs["class"] = "form-control";
            $this->jenisproduk->EditCustomAttributes = "";
            $curVal = trim(strval($this->jenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->jenisproduk->ViewValue = $this->jenisproduk->lookupCacheOption($curVal);
            } else {
                $this->jenisproduk->ViewValue = $this->jenisproduk->Lookup !== null && is_array($this->jenisproduk->Lookup->Options) ? $curVal : null;
            }
            if ($this->jenisproduk->ViewValue !== null) { // Load from cache
                $this->jenisproduk->EditValue = array_values($this->jenisproduk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`kategori`" . SearchString("=", $this->jenisproduk->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->jenisproduk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->jenisproduk->EditValue = $arwrk;
            }
            $this->jenisproduk->PlaceHolder = RemoveHtml($this->jenisproduk->caption());

            // fungsiproduk
            $this->fungsiproduk->EditAttrs["class"] = "form-control";
            $this->fungsiproduk->EditCustomAttributes = "";
            if (!$this->fungsiproduk->Raw) {
                $this->fungsiproduk->CurrentValue = HtmlDecode($this->fungsiproduk->CurrentValue);
            }
            $this->fungsiproduk->EditValue = HtmlEncode($this->fungsiproduk->CurrentValue);
            $this->fungsiproduk->PlaceHolder = RemoveHtml($this->fungsiproduk->caption());

            // kualitasproduk
            $this->kualitasproduk->EditAttrs["class"] = "form-control";
            $this->kualitasproduk->EditCustomAttributes = "";
            if (!$this->kualitasproduk->Raw) {
                $this->kualitasproduk->CurrentValue = HtmlDecode($this->kualitasproduk->CurrentValue);
            }
            $this->kualitasproduk->EditValue = HtmlEncode($this->kualitasproduk->CurrentValue);
            $this->kualitasproduk->PlaceHolder = RemoveHtml($this->kualitasproduk->caption());

            // bahan_campaign
            $this->bahan_campaign->EditAttrs["class"] = "form-control";
            $this->bahan_campaign->EditCustomAttributes = "";
            $this->bahan_campaign->EditValue = HtmlEncode($this->bahan_campaign->CurrentValue);
            $this->bahan_campaign->PlaceHolder = RemoveHtml($this->bahan_campaign->caption());

            // ukuran_sediaan
            $this->ukuran_sediaan->EditAttrs["class"] = "form-control";
            $this->ukuran_sediaan->EditCustomAttributes = "";
            if (!$this->ukuran_sediaan->Raw) {
                $this->ukuran_sediaan->CurrentValue = HtmlDecode($this->ukuran_sediaan->CurrentValue);
            }
            $this->ukuran_sediaan->EditValue = HtmlEncode($this->ukuran_sediaan->CurrentValue);
            $this->ukuran_sediaan->PlaceHolder = RemoveHtml($this->ukuran_sediaan->caption());

            // bentuk
            $this->bentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
            } else {
                $this->bentuk->ViewValue = $this->bentuk->Lookup !== null && is_array($this->bentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->bentuk->ViewValue !== null) { // Load from cache
                $this->bentuk->EditValue = array_values($this->bentuk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`sediaan`" . SearchString("=", $this->bentuk->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->bentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->bentuk->EditValue = $arwrk;
            }
            $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

            // viskositas
            $this->viskositas->EditAttrs["class"] = "form-control";
            $this->viskositas->EditCustomAttributes = "";
            if (!$this->viskositas->Raw) {
                $this->viskositas->CurrentValue = HtmlDecode($this->viskositas->CurrentValue);
            }
            $this->viskositas->EditValue = HtmlEncode($this->viskositas->CurrentValue);
            $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

            // warna
            $this->warna->EditAttrs["class"] = "form-control";
            $this->warna->EditCustomAttributes = "";
            if (!$this->warna->Raw) {
                $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
            }
            $this->warna->EditValue = HtmlEncode($this->warna->CurrentValue);
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // parfum
            $this->parfum->EditAttrs["class"] = "form-control";
            $this->parfum->EditCustomAttributes = "";
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
            } else {
                $this->parfum->ViewValue = $this->parfum->Lookup !== null && is_array($this->parfum->Lookup->Options) ? $curVal : null;
            }
            if ($this->parfum->ViewValue !== null) { // Load from cache
                $this->parfum->EditValue = array_values($this->parfum->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`fragrance`" . SearchString("=", $this->parfum->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->parfum->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->parfum->EditValue = $arwrk;
            }
            $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

            // aplikasi
            $this->aplikasi->EditAttrs["class"] = "form-control";
            $this->aplikasi->EditCustomAttributes = "";
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
            } else {
                $this->aplikasi->ViewValue = $this->aplikasi->Lookup !== null && is_array($this->aplikasi->Lookup->Options) ? $curVal : null;
            }
            if ($this->aplikasi->ViewValue !== null) { // Load from cache
                $this->aplikasi->EditValue = array_values($this->aplikasi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`aplikasi_sediaan`" . SearchString("=", $this->aplikasi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->aplikasi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->aplikasi->EditValue = $arwrk;
            }
            $this->aplikasi->PlaceHolder = RemoveHtml($this->aplikasi->caption());

            // tambahan
            $this->tambahan->EditAttrs["class"] = "form-control";
            $this->tambahan->EditCustomAttributes = "";
            $this->tambahan->EditValue = HtmlEncode($this->tambahan->CurrentValue);
            $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

            // ukurankemasan
            $this->ukurankemasan->EditAttrs["class"] = "form-control";
            $this->ukurankemasan->EditCustomAttributes = "";
            if (!$this->ukurankemasan->Raw) {
                $this->ukurankemasan->CurrentValue = HtmlDecode($this->ukurankemasan->CurrentValue);
            }
            $this->ukurankemasan->EditValue = HtmlEncode($this->ukurankemasan->CurrentValue);
            $this->ukurankemasan->PlaceHolder = RemoveHtml($this->ukurankemasan->caption());

            // kemasanbentuk
            $this->kemasanbentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
            } else {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->Lookup !== null && is_array($this->kemasanbentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasanbentuk->ViewValue !== null) { // Load from cache
                $this->kemasanbentuk->EditValue = array_values($this->kemasanbentuk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->kemasanbentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasanbentuk->EditValue = $arwrk;
            }
            $this->kemasanbentuk->PlaceHolder = RemoveHtml($this->kemasanbentuk->caption());

            // kemasantutup
            $this->kemasantutup->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
            } else {
                $this->kemasantutup->ViewValue = $this->kemasantutup->Lookup !== null && is_array($this->kemasantutup->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasantutup->ViewValue !== null) { // Load from cache
                $this->kemasantutup->EditValue = array_values($this->kemasantutup->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->kemasantutup->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasantutup->EditValue = $arwrk;
            }
            $this->kemasantutup->PlaceHolder = RemoveHtml($this->kemasantutup->caption());

            // kemasancatatan
            $this->kemasancatatan->EditAttrs["class"] = "form-control";
            $this->kemasancatatan->EditCustomAttributes = "";
            $this->kemasancatatan->EditValue = HtmlEncode($this->kemasancatatan->CurrentValue);
            $this->kemasancatatan->PlaceHolder = RemoveHtml($this->kemasancatatan->caption());

            // labelbahan
            $this->labelbahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
            } else {
                $this->labelbahan->ViewValue = $this->labelbahan->Lookup !== null && is_array($this->labelbahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelbahan->ViewValue !== null) { // Load from cache
                $this->labelbahan->EditValue = array_values($this->labelbahan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`nama`" . SearchString("=", $this->labelbahan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelbahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelbahan->EditValue = $arwrk;
            }
            $this->labelbahan->PlaceHolder = RemoveHtml($this->labelbahan->caption());

            // labelkualitas
            $this->labelkualitas->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
            } else {
                $this->labelkualitas->ViewValue = $this->labelkualitas->Lookup !== null && is_array($this->labelkualitas->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelkualitas->ViewValue !== null) { // Load from cache
                $this->labelkualitas->EditValue = array_values($this->labelkualitas->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`nama`" . SearchString("=", $this->labelkualitas->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelkualitas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelkualitas->EditValue = $arwrk;
            }
            $this->labelkualitas->PlaceHolder = RemoveHtml($this->labelkualitas->caption());

            // labelposisi
            $this->labelposisi->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
            } else {
                $this->labelposisi->ViewValue = $this->labelposisi->Lookup !== null && is_array($this->labelposisi->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelposisi->ViewValue !== null) { // Load from cache
                $this->labelposisi->EditValue = array_values($this->labelposisi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`nama`" . SearchString("=", $this->labelposisi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelposisi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelposisi->EditValue = $arwrk;
            }
            $this->labelposisi->PlaceHolder = RemoveHtml($this->labelposisi->caption());

            // labelcatatan
            $this->labelcatatan->EditAttrs["class"] = "form-control";
            $this->labelcatatan->EditCustomAttributes = "";
            $this->labelcatatan->EditValue = HtmlEncode($this->labelcatatan->CurrentValue);
            $this->labelcatatan->PlaceHolder = RemoveHtml($this->labelcatatan->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // estetika
            $this->estetika->EditAttrs["class"] = "form-control";
            $this->estetika->EditCustomAttributes = "";
            if (!$this->estetika->Raw) {
                $this->estetika->CurrentValue = HtmlDecode($this->estetika->CurrentValue);
            }
            $this->estetika->EditValue = HtmlEncode($this->estetika->CurrentValue);
            $this->estetika->PlaceHolder = RemoveHtml($this->estetika->caption());

            // Edit refer script

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";

            // fungsiproduk
            $this->fungsiproduk->LinkCustomAttributes = "";
            $this->fungsiproduk->HrefValue = "";

            // kualitasproduk
            $this->kualitasproduk->LinkCustomAttributes = "";
            $this->kualitasproduk->HrefValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->LinkCustomAttributes = "";
            $this->ukuran_sediaan->HrefValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // aplikasi
            $this->aplikasi->LinkCustomAttributes = "";
            $this->aplikasi->HrefValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";

            // ukurankemasan
            $this->ukurankemasan->LinkCustomAttributes = "";
            $this->ukurankemasan->HrefValue = "";

            // kemasanbentuk
            $this->kemasanbentuk->LinkCustomAttributes = "";
            $this->kemasanbentuk->HrefValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";

            // kemasancatatan
            $this->kemasancatatan->LinkCustomAttributes = "";
            $this->kemasancatatan->HrefValue = "";

            // labelbahan
            $this->labelbahan->LinkCustomAttributes = "";
            $this->labelbahan->HrefValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if ($this->idbrand->Required) {
            if (!$this->idbrand->IsDetailKey && EmptyValue($this->idbrand->FormValue)) {
                $this->idbrand->addErrorMessage(str_replace("%s", $this->idbrand->caption(), $this->idbrand->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_order->Required) {
            if (!$this->tanggal_order->IsDetailKey && EmptyValue($this->tanggal_order->FormValue)) {
                $this->tanggal_order->addErrorMessage(str_replace("%s", $this->tanggal_order->caption(), $this->tanggal_order->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_order->FormValue)) {
            $this->tanggal_order->addErrorMessage($this->tanggal_order->getErrorMessage(false));
        }
        if ($this->target_selesai->Required) {
            if (!$this->target_selesai->IsDetailKey && EmptyValue($this->target_selesai->FormValue)) {
                $this->target_selesai->addErrorMessage(str_replace("%s", $this->target_selesai->caption(), $this->target_selesai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->target_selesai->FormValue)) {
            $this->target_selesai->addErrorMessage($this->target_selesai->getErrorMessage(false));
        }
        if ($this->sifatorder->Required) {
            if ($this->sifatorder->FormValue == "") {
                $this->sifatorder->addErrorMessage(str_replace("%s", $this->sifatorder->caption(), $this->sifatorder->RequiredErrorMessage));
            }
        }
        if ($this->kodeorder->Required) {
            if (!$this->kodeorder->IsDetailKey && EmptyValue($this->kodeorder->FormValue)) {
                $this->kodeorder->addErrorMessage(str_replace("%s", $this->kodeorder->caption(), $this->kodeorder->RequiredErrorMessage));
            }
        }
        if ($this->nomororder->Required) {
            if (!$this->nomororder->IsDetailKey && EmptyValue($this->nomororder->FormValue)) {
                $this->nomororder->addErrorMessage(str_replace("%s", $this->nomororder->caption(), $this->nomororder->RequiredErrorMessage));
            }
        }
        if ($this->kategoriproduk->Required) {
            if (!$this->kategoriproduk->IsDetailKey && EmptyValue($this->kategoriproduk->FormValue)) {
                $this->kategoriproduk->addErrorMessage(str_replace("%s", $this->kategoriproduk->caption(), $this->kategoriproduk->RequiredErrorMessage));
            }
        }
        if ($this->jenisproduk->Required) {
            if (!$this->jenisproduk->IsDetailKey && EmptyValue($this->jenisproduk->FormValue)) {
                $this->jenisproduk->addErrorMessage(str_replace("%s", $this->jenisproduk->caption(), $this->jenisproduk->RequiredErrorMessage));
            }
        }
        if ($this->fungsiproduk->Required) {
            if (!$this->fungsiproduk->IsDetailKey && EmptyValue($this->fungsiproduk->FormValue)) {
                $this->fungsiproduk->addErrorMessage(str_replace("%s", $this->fungsiproduk->caption(), $this->fungsiproduk->RequiredErrorMessage));
            }
        }
        if ($this->kualitasproduk->Required) {
            if (!$this->kualitasproduk->IsDetailKey && EmptyValue($this->kualitasproduk->FormValue)) {
                $this->kualitasproduk->addErrorMessage(str_replace("%s", $this->kualitasproduk->caption(), $this->kualitasproduk->RequiredErrorMessage));
            }
        }
        if ($this->bahan_campaign->Required) {
            if (!$this->bahan_campaign->IsDetailKey && EmptyValue($this->bahan_campaign->FormValue)) {
                $this->bahan_campaign->addErrorMessage(str_replace("%s", $this->bahan_campaign->caption(), $this->bahan_campaign->RequiredErrorMessage));
            }
        }
        if ($this->ukuran_sediaan->Required) {
            if (!$this->ukuran_sediaan->IsDetailKey && EmptyValue($this->ukuran_sediaan->FormValue)) {
                $this->ukuran_sediaan->addErrorMessage(str_replace("%s", $this->ukuran_sediaan->caption(), $this->ukuran_sediaan->RequiredErrorMessage));
            }
        }
        if ($this->bentuk->Required) {
            if ($this->bentuk->FormValue == "") {
                $this->bentuk->addErrorMessage(str_replace("%s", $this->bentuk->caption(), $this->bentuk->RequiredErrorMessage));
            }
        }
        if ($this->viskositas->Required) {
            if (!$this->viskositas->IsDetailKey && EmptyValue($this->viskositas->FormValue)) {
                $this->viskositas->addErrorMessage(str_replace("%s", $this->viskositas->caption(), $this->viskositas->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if (!$this->warna->IsDetailKey && EmptyValue($this->warna->FormValue)) {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->parfum->Required) {
            if (!$this->parfum->IsDetailKey && EmptyValue($this->parfum->FormValue)) {
                $this->parfum->addErrorMessage(str_replace("%s", $this->parfum->caption(), $this->parfum->RequiredErrorMessage));
            }
        }
        if ($this->aplikasi->Required) {
            if (!$this->aplikasi->IsDetailKey && EmptyValue($this->aplikasi->FormValue)) {
                $this->aplikasi->addErrorMessage(str_replace("%s", $this->aplikasi->caption(), $this->aplikasi->RequiredErrorMessage));
            }
        }
        if ($this->tambahan->Required) {
            if (!$this->tambahan->IsDetailKey && EmptyValue($this->tambahan->FormValue)) {
                $this->tambahan->addErrorMessage(str_replace("%s", $this->tambahan->caption(), $this->tambahan->RequiredErrorMessage));
            }
        }
        if ($this->ukurankemasan->Required) {
            if (!$this->ukurankemasan->IsDetailKey && EmptyValue($this->ukurankemasan->FormValue)) {
                $this->ukurankemasan->addErrorMessage(str_replace("%s", $this->ukurankemasan->caption(), $this->ukurankemasan->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbentuk->Required) {
            if ($this->kemasanbentuk->FormValue == "") {
                $this->kemasanbentuk->addErrorMessage(str_replace("%s", $this->kemasanbentuk->caption(), $this->kemasanbentuk->RequiredErrorMessage));
            }
        }
        if ($this->kemasantutup->Required) {
            if ($this->kemasantutup->FormValue == "") {
                $this->kemasantutup->addErrorMessage(str_replace("%s", $this->kemasantutup->caption(), $this->kemasantutup->RequiredErrorMessage));
            }
        }
        if ($this->kemasancatatan->Required) {
            if (!$this->kemasancatatan->IsDetailKey && EmptyValue($this->kemasancatatan->FormValue)) {
                $this->kemasancatatan->addErrorMessage(str_replace("%s", $this->kemasancatatan->caption(), $this->kemasancatatan->RequiredErrorMessage));
            }
        }
        if ($this->labelbahan->Required) {
            if ($this->labelbahan->FormValue == "") {
                $this->labelbahan->addErrorMessage(str_replace("%s", $this->labelbahan->caption(), $this->labelbahan->RequiredErrorMessage));
            }
        }
        if ($this->labelkualitas->Required) {
            if ($this->labelkualitas->FormValue == "") {
                $this->labelkualitas->addErrorMessage(str_replace("%s", $this->labelkualitas->caption(), $this->labelkualitas->RequiredErrorMessage));
            }
        }
        if ($this->labelposisi->Required) {
            if ($this->labelposisi->FormValue == "") {
                $this->labelposisi->addErrorMessage(str_replace("%s", $this->labelposisi->caption(), $this->labelposisi->RequiredErrorMessage));
            }
        }
        if ($this->labelcatatan->Required) {
            if (!$this->labelcatatan->IsDetailKey && EmptyValue($this->labelcatatan->FormValue)) {
                $this->labelcatatan->addErrorMessage(str_replace("%s", $this->labelcatatan->caption(), $this->labelcatatan->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->estetika->Required) {
            if (!$this->estetika->IsDetailKey && EmptyValue($this->estetika->FormValue)) {
                $this->estetika->addErrorMessage(str_replace("%s", $this->estetika->caption(), $this->estetika->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("NpdSampleGrid");
        if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdReviewGrid");
        if (in_array("npd_review", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdConfirmGrid");
        if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdHargaGrid");
        if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdDesainGrid");
        if (in_array("npd_desain", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdTermsGrid");
        if (in_array("npd_terms", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        if ($this->kodeorder->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`kodeorder` = '" . AdjustSql($this->kodeorder->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->kodeorder->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kodeorder->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // idbrand
            $this->idbrand->setDbValueDef($rsnew, $this->idbrand->CurrentValue, null, $this->idbrand->ReadOnly);

            // tanggal_order
            $this->tanggal_order->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_order->CurrentValue, 0), null, $this->tanggal_order->ReadOnly);

            // target_selesai
            $this->target_selesai->setDbValueDef($rsnew, UnFormatDateTime($this->target_selesai->CurrentValue, 0), null, $this->target_selesai->ReadOnly);

            // sifatorder
            $this->sifatorder->setDbValueDef($rsnew, $this->sifatorder->CurrentValue, "", $this->sifatorder->ReadOnly);

            // nomororder
            $this->nomororder->setDbValueDef($rsnew, $this->nomororder->CurrentValue, null, $this->nomororder->ReadOnly);

            // kategoriproduk
            $this->kategoriproduk->setDbValueDef($rsnew, $this->kategoriproduk->CurrentValue, null, $this->kategoriproduk->ReadOnly);

            // jenisproduk
            $this->jenisproduk->setDbValueDef($rsnew, $this->jenisproduk->CurrentValue, null, $this->jenisproduk->ReadOnly);

            // fungsiproduk
            $this->fungsiproduk->setDbValueDef($rsnew, $this->fungsiproduk->CurrentValue, null, $this->fungsiproduk->ReadOnly);

            // kualitasproduk
            $this->kualitasproduk->setDbValueDef($rsnew, $this->kualitasproduk->CurrentValue, null, $this->kualitasproduk->ReadOnly);

            // bahan_campaign
            $this->bahan_campaign->setDbValueDef($rsnew, $this->bahan_campaign->CurrentValue, null, $this->bahan_campaign->ReadOnly);

            // ukuran_sediaan
            $this->ukuran_sediaan->setDbValueDef($rsnew, $this->ukuran_sediaan->CurrentValue, null, $this->ukuran_sediaan->ReadOnly);

            // bentuk
            $this->bentuk->setDbValueDef($rsnew, $this->bentuk->CurrentValue, null, $this->bentuk->ReadOnly);

            // viskositas
            $this->viskositas->setDbValueDef($rsnew, $this->viskositas->CurrentValue, null, $this->viskositas->ReadOnly);

            // warna
            $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, null, $this->warna->ReadOnly);

            // parfum
            $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, null, $this->parfum->ReadOnly);

            // aplikasi
            $this->aplikasi->setDbValueDef($rsnew, $this->aplikasi->CurrentValue, null, $this->aplikasi->ReadOnly);

            // tambahan
            $this->tambahan->setDbValueDef($rsnew, $this->tambahan->CurrentValue, null, $this->tambahan->ReadOnly);

            // ukurankemasan
            $this->ukurankemasan->setDbValueDef($rsnew, $this->ukurankemasan->CurrentValue, null, $this->ukurankemasan->ReadOnly);

            // kemasanbentuk
            $this->kemasanbentuk->setDbValueDef($rsnew, $this->kemasanbentuk->CurrentValue, null, $this->kemasanbentuk->ReadOnly);

            // kemasantutup
            $this->kemasantutup->setDbValueDef($rsnew, $this->kemasantutup->CurrentValue, null, $this->kemasantutup->ReadOnly);

            // kemasancatatan
            $this->kemasancatatan->setDbValueDef($rsnew, $this->kemasancatatan->CurrentValue, null, $this->kemasancatatan->ReadOnly);

            // labelbahan
            $this->labelbahan->setDbValueDef($rsnew, $this->labelbahan->CurrentValue, null, $this->labelbahan->ReadOnly);

            // labelkualitas
            $this->labelkualitas->setDbValueDef($rsnew, $this->labelkualitas->CurrentValue, null, $this->labelkualitas->ReadOnly);

            // labelposisi
            $this->labelposisi->setDbValueDef($rsnew, $this->labelposisi->CurrentValue, null, $this->labelposisi->ReadOnly);

            // labelcatatan
            $this->labelcatatan->setDbValueDef($rsnew, $this->labelcatatan->CurrentValue, null, $this->labelcatatan->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

            // estetika
            $this->estetika->setDbValueDef($rsnew, $this->estetika->CurrentValue, null, $this->estetika->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("NpdSampleGrid");
                    if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_sample"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdReviewGrid");
                    if (in_array("npd_review", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_review"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdConfirmGrid");
                    if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_confirm"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdHargaGrid");
                    if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_harga"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdDesainGrid");
                    if (in_array("npd_desain", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_desain"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdTermsGrid");
                    if (in_array("npd_terms", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_terms"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("npd_sample", $detailTblVar)) {
                $detailPageObj = Container("NpdSampleGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                    $detailPageObj->idserahterima->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("npd_review", $detailTblVar)) {
                $detailPageObj = Container("NpdReviewGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_confirm", $detailTblVar)) {
                $detailPageObj = Container("NpdConfirmGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_harga", $detailTblVar)) {
                $detailPageObj = Container("NpdHargaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_desain", $detailTblVar)) {
                $detailPageObj = Container("NpdDesainGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_terms", $detailTblVar)) {
                $detailPageObj = Container("NpdTermsGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('npd_sample');
        $pages->add('npd_review');
        $pages->add('npd_confirm');
        $pages->add('npd_harga');
        $pages->add('npd_desain');
        $pages->add('npd_terms');
        $this->DetailPages = $pages;
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idbrand":
                    break;
                case "x_sifatorder":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_kategoriproduk":
                    break;
                case "x_jenisproduk":
                    break;
                case "x_bentuk":
                    break;
                case "x_parfum":
                    break;
                case "x_aplikasi":
                    break;
                case "x_kemasanbentuk":
                    break;
                case "x_kemasantutup":
                    break;
                case "x_labelbahan":
                    break;
                case "x_labelkualitas":
                    break;
                case "x_labelposisi":
                    break;
                case "x_readonly":
                    break;
                case "x_selesai":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
