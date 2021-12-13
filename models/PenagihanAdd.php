<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PenagihanAdd extends Penagihan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'penagihan';

    // Page object name
    public $PageObjName = "PenagihanAdd";

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

        // Table object (penagihan)
        if (!isset($GLOBALS["penagihan"]) || get_class($GLOBALS["penagihan"]) == PROJECT_NAMESPACE . "penagihan") {
            $GLOBALS["penagihan"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'penagihan');
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
                $doc = new $class(Container("penagihan"));
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
                    if ($pageName == "PenagihanView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->messages->setVisibility();
        $this->tgl_order->setVisibility();
        $this->kode_order->setVisibility();
        $this->nama_customer->setVisibility();
        $this->nomor_handphone->setVisibility();
        $this->nilai_po->setVisibility();
        $this->tgl_faktur->setVisibility();
        $this->nilai_faktur->setVisibility();
        $this->piutang->setVisibility();
        $this->umur_faktur->setVisibility();
        $this->tgl_antrian->setVisibility();
        $this->status->setVisibility();
        $this->tgl_penagihan->setVisibility();
        $this->tgl_return->setVisibility();
        $this->tgl_cancel->setVisibility();
        $this->messagets->setVisibility();
        $this->statusts->setVisibility();
        $this->statusbayar->setVisibility();
        $this->nomorfaktur->setVisibility();
        $this->pembayaran->setVisibility();
        $this->keterangan->setVisibility();
        $this->saldo->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PenagihanList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "PenagihanList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "PenagihanView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->messages->CurrentValue = null;
        $this->messages->OldValue = $this->messages->CurrentValue;
        $this->tgl_order->CurrentValue = null;
        $this->tgl_order->OldValue = $this->tgl_order->CurrentValue;
        $this->kode_order->CurrentValue = null;
        $this->kode_order->OldValue = $this->kode_order->CurrentValue;
        $this->nama_customer->CurrentValue = null;
        $this->nama_customer->OldValue = $this->nama_customer->CurrentValue;
        $this->nomor_handphone->CurrentValue = null;
        $this->nomor_handphone->OldValue = $this->nomor_handphone->CurrentValue;
        $this->nilai_po->CurrentValue = null;
        $this->nilai_po->OldValue = $this->nilai_po->CurrentValue;
        $this->tgl_faktur->CurrentValue = null;
        $this->tgl_faktur->OldValue = $this->tgl_faktur->CurrentValue;
        $this->nilai_faktur->CurrentValue = null;
        $this->nilai_faktur->OldValue = $this->nilai_faktur->CurrentValue;
        $this->piutang->CurrentValue = null;
        $this->piutang->OldValue = $this->piutang->CurrentValue;
        $this->umur_faktur->CurrentValue = null;
        $this->umur_faktur->OldValue = $this->umur_faktur->CurrentValue;
        $this->tgl_antrian->CurrentValue = null;
        $this->tgl_antrian->OldValue = $this->tgl_antrian->CurrentValue;
        $this->status->CurrentValue = 0;
        $this->tgl_penagihan->CurrentValue = null;
        $this->tgl_penagihan->OldValue = $this->tgl_penagihan->CurrentValue;
        $this->tgl_return->CurrentValue = null;
        $this->tgl_return->OldValue = $this->tgl_return->CurrentValue;
        $this->tgl_cancel->CurrentValue = null;
        $this->tgl_cancel->OldValue = $this->tgl_cancel->CurrentValue;
        $this->messagets->CurrentValue = null;
        $this->messagets->OldValue = $this->messagets->CurrentValue;
        $this->statusts->CurrentValue = null;
        $this->statusts->OldValue = $this->statusts->CurrentValue;
        $this->statusbayar->CurrentValue = null;
        $this->statusbayar->OldValue = $this->statusbayar->CurrentValue;
        $this->nomorfaktur->CurrentValue = null;
        $this->nomorfaktur->OldValue = $this->nomorfaktur->CurrentValue;
        $this->pembayaran->CurrentValue = null;
        $this->pembayaran->OldValue = $this->pembayaran->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->saldo->CurrentValue = null;
        $this->saldo->OldValue = $this->saldo->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'messages' first before field var 'x_messages'
        $val = $CurrentForm->hasValue("messages") ? $CurrentForm->getValue("messages") : $CurrentForm->getValue("x_messages");
        if (!$this->messages->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->messages->Visible = false; // Disable update for API request
            } else {
                $this->messages->setFormValue($val);
            }
        }

        // Check field name 'tgl_order' first before field var 'x_tgl_order'
        $val = $CurrentForm->hasValue("tgl_order") ? $CurrentForm->getValue("tgl_order") : $CurrentForm->getValue("x_tgl_order");
        if (!$this->tgl_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_order->Visible = false; // Disable update for API request
            } else {
                $this->tgl_order->setFormValue($val);
            }
            $this->tgl_order->CurrentValue = UnFormatDateTime($this->tgl_order->CurrentValue, 0);
        }

        // Check field name 'kode_order' first before field var 'x_kode_order'
        $val = $CurrentForm->hasValue("kode_order") ? $CurrentForm->getValue("kode_order") : $CurrentForm->getValue("x_kode_order");
        if (!$this->kode_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode_order->Visible = false; // Disable update for API request
            } else {
                $this->kode_order->setFormValue($val);
            }
        }

        // Check field name 'nama_customer' first before field var 'x_nama_customer'
        $val = $CurrentForm->hasValue("nama_customer") ? $CurrentForm->getValue("nama_customer") : $CurrentForm->getValue("x_nama_customer");
        if (!$this->nama_customer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_customer->Visible = false; // Disable update for API request
            } else {
                $this->nama_customer->setFormValue($val);
            }
        }

        // Check field name 'nomor_handphone' first before field var 'x_nomor_handphone'
        $val = $CurrentForm->hasValue("nomor_handphone") ? $CurrentForm->getValue("nomor_handphone") : $CurrentForm->getValue("x_nomor_handphone");
        if (!$this->nomor_handphone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomor_handphone->Visible = false; // Disable update for API request
            } else {
                $this->nomor_handphone->setFormValue($val);
            }
        }

        // Check field name 'nilai_po' first before field var 'x_nilai_po'
        $val = $CurrentForm->hasValue("nilai_po") ? $CurrentForm->getValue("nilai_po") : $CurrentForm->getValue("x_nilai_po");
        if (!$this->nilai_po->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nilai_po->Visible = false; // Disable update for API request
            } else {
                $this->nilai_po->setFormValue($val);
            }
        }

        // Check field name 'tgl_faktur' first before field var 'x_tgl_faktur'
        $val = $CurrentForm->hasValue("tgl_faktur") ? $CurrentForm->getValue("tgl_faktur") : $CurrentForm->getValue("x_tgl_faktur");
        if (!$this->tgl_faktur->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_faktur->Visible = false; // Disable update for API request
            } else {
                $this->tgl_faktur->setFormValue($val);
            }
            $this->tgl_faktur->CurrentValue = UnFormatDateTime($this->tgl_faktur->CurrentValue, 0);
        }

        // Check field name 'nilai_faktur' first before field var 'x_nilai_faktur'
        $val = $CurrentForm->hasValue("nilai_faktur") ? $CurrentForm->getValue("nilai_faktur") : $CurrentForm->getValue("x_nilai_faktur");
        if (!$this->nilai_faktur->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nilai_faktur->Visible = false; // Disable update for API request
            } else {
                $this->nilai_faktur->setFormValue($val);
            }
        }

        // Check field name 'piutang' first before field var 'x_piutang'
        $val = $CurrentForm->hasValue("piutang") ? $CurrentForm->getValue("piutang") : $CurrentForm->getValue("x_piutang");
        if (!$this->piutang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->piutang->Visible = false; // Disable update for API request
            } else {
                $this->piutang->setFormValue($val);
            }
        }

        // Check field name 'umur_faktur' first before field var 'x_umur_faktur'
        $val = $CurrentForm->hasValue("umur_faktur") ? $CurrentForm->getValue("umur_faktur") : $CurrentForm->getValue("x_umur_faktur");
        if (!$this->umur_faktur->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->umur_faktur->Visible = false; // Disable update for API request
            } else {
                $this->umur_faktur->setFormValue($val);
            }
        }

        // Check field name 'tgl_antrian' first before field var 'x_tgl_antrian'
        $val = $CurrentForm->hasValue("tgl_antrian") ? $CurrentForm->getValue("tgl_antrian") : $CurrentForm->getValue("x_tgl_antrian");
        if (!$this->tgl_antrian->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_antrian->Visible = false; // Disable update for API request
            } else {
                $this->tgl_antrian->setFormValue($val);
            }
            $this->tgl_antrian->CurrentValue = UnFormatDateTime($this->tgl_antrian->CurrentValue, 0);
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

        // Check field name 'tgl_penagihan' first before field var 'x_tgl_penagihan'
        $val = $CurrentForm->hasValue("tgl_penagihan") ? $CurrentForm->getValue("tgl_penagihan") : $CurrentForm->getValue("x_tgl_penagihan");
        if (!$this->tgl_penagihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_penagihan->Visible = false; // Disable update for API request
            } else {
                $this->tgl_penagihan->setFormValue($val);
            }
            $this->tgl_penagihan->CurrentValue = UnFormatDateTime($this->tgl_penagihan->CurrentValue, 0);
        }

        // Check field name 'tgl_return' first before field var 'x_tgl_return'
        $val = $CurrentForm->hasValue("tgl_return") ? $CurrentForm->getValue("tgl_return") : $CurrentForm->getValue("x_tgl_return");
        if (!$this->tgl_return->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_return->Visible = false; // Disable update for API request
            } else {
                $this->tgl_return->setFormValue($val);
            }
            $this->tgl_return->CurrentValue = UnFormatDateTime($this->tgl_return->CurrentValue, 0);
        }

        // Check field name 'tgl_cancel' first before field var 'x_tgl_cancel'
        $val = $CurrentForm->hasValue("tgl_cancel") ? $CurrentForm->getValue("tgl_cancel") : $CurrentForm->getValue("x_tgl_cancel");
        if (!$this->tgl_cancel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgl_cancel->Visible = false; // Disable update for API request
            } else {
                $this->tgl_cancel->setFormValue($val);
            }
            $this->tgl_cancel->CurrentValue = UnFormatDateTime($this->tgl_cancel->CurrentValue, 0);
        }

        // Check field name 'messagets' first before field var 'x_messagets'
        $val = $CurrentForm->hasValue("messagets") ? $CurrentForm->getValue("messagets") : $CurrentForm->getValue("x_messagets");
        if (!$this->messagets->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->messagets->Visible = false; // Disable update for API request
            } else {
                $this->messagets->setFormValue($val);
            }
        }

        // Check field name 'statusts' first before field var 'x_statusts'
        $val = $CurrentForm->hasValue("statusts") ? $CurrentForm->getValue("statusts") : $CurrentForm->getValue("x_statusts");
        if (!$this->statusts->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->statusts->Visible = false; // Disable update for API request
            } else {
                $this->statusts->setFormValue($val);
            }
        }

        // Check field name 'statusbayar' first before field var 'x_statusbayar'
        $val = $CurrentForm->hasValue("statusbayar") ? $CurrentForm->getValue("statusbayar") : $CurrentForm->getValue("x_statusbayar");
        if (!$this->statusbayar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->statusbayar->Visible = false; // Disable update for API request
            } else {
                $this->statusbayar->setFormValue($val);
            }
        }

        // Check field name 'nomorfaktur' first before field var 'x_nomorfaktur'
        $val = $CurrentForm->hasValue("nomorfaktur") ? $CurrentForm->getValue("nomorfaktur") : $CurrentForm->getValue("x_nomorfaktur");
        if (!$this->nomorfaktur->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomorfaktur->Visible = false; // Disable update for API request
            } else {
                $this->nomorfaktur->setFormValue($val);
            }
        }

        // Check field name 'pembayaran' first before field var 'x_pembayaran'
        $val = $CurrentForm->hasValue("pembayaran") ? $CurrentForm->getValue("pembayaran") : $CurrentForm->getValue("x_pembayaran");
        if (!$this->pembayaran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pembayaran->Visible = false; // Disable update for API request
            } else {
                $this->pembayaran->setFormValue($val);
            }
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
        }

        // Check field name 'saldo' first before field var 'x_saldo'
        $val = $CurrentForm->hasValue("saldo") ? $CurrentForm->getValue("saldo") : $CurrentForm->getValue("x_saldo");
        if (!$this->saldo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->saldo->Visible = false; // Disable update for API request
            } else {
                $this->saldo->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->messages->CurrentValue = $this->messages->FormValue;
        $this->tgl_order->CurrentValue = $this->tgl_order->FormValue;
        $this->tgl_order->CurrentValue = UnFormatDateTime($this->tgl_order->CurrentValue, 0);
        $this->kode_order->CurrentValue = $this->kode_order->FormValue;
        $this->nama_customer->CurrentValue = $this->nama_customer->FormValue;
        $this->nomor_handphone->CurrentValue = $this->nomor_handphone->FormValue;
        $this->nilai_po->CurrentValue = $this->nilai_po->FormValue;
        $this->tgl_faktur->CurrentValue = $this->tgl_faktur->FormValue;
        $this->tgl_faktur->CurrentValue = UnFormatDateTime($this->tgl_faktur->CurrentValue, 0);
        $this->nilai_faktur->CurrentValue = $this->nilai_faktur->FormValue;
        $this->piutang->CurrentValue = $this->piutang->FormValue;
        $this->umur_faktur->CurrentValue = $this->umur_faktur->FormValue;
        $this->tgl_antrian->CurrentValue = $this->tgl_antrian->FormValue;
        $this->tgl_antrian->CurrentValue = UnFormatDateTime($this->tgl_antrian->CurrentValue, 0);
        $this->status->CurrentValue = $this->status->FormValue;
        $this->tgl_penagihan->CurrentValue = $this->tgl_penagihan->FormValue;
        $this->tgl_penagihan->CurrentValue = UnFormatDateTime($this->tgl_penagihan->CurrentValue, 0);
        $this->tgl_return->CurrentValue = $this->tgl_return->FormValue;
        $this->tgl_return->CurrentValue = UnFormatDateTime($this->tgl_return->CurrentValue, 0);
        $this->tgl_cancel->CurrentValue = $this->tgl_cancel->FormValue;
        $this->tgl_cancel->CurrentValue = UnFormatDateTime($this->tgl_cancel->CurrentValue, 0);
        $this->messagets->CurrentValue = $this->messagets->FormValue;
        $this->statusts->CurrentValue = $this->statusts->FormValue;
        $this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
        $this->nomorfaktur->CurrentValue = $this->nomorfaktur->FormValue;
        $this->pembayaran->CurrentValue = $this->pembayaran->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->saldo->CurrentValue = $this->saldo->FormValue;
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
        $this->messages->setDbValue($row['messages']);
        $this->tgl_order->setDbValue($row['tgl_order']);
        $this->kode_order->setDbValue($row['kode_order']);
        $this->nama_customer->setDbValue($row['nama_customer']);
        $this->nomor_handphone->setDbValue($row['nomor_handphone']);
        $this->nilai_po->setDbValue($row['nilai_po']);
        $this->tgl_faktur->setDbValue($row['tgl_faktur']);
        $this->nilai_faktur->setDbValue($row['nilai_faktur']);
        $this->piutang->setDbValue($row['piutang']);
        $this->umur_faktur->setDbValue($row['umur_faktur']);
        $this->tgl_antrian->setDbValue($row['tgl_antrian']);
        $this->status->setDbValue($row['status']);
        $this->tgl_penagihan->setDbValue($row['tgl_penagihan']);
        $this->tgl_return->setDbValue($row['tgl_return']);
        $this->tgl_cancel->setDbValue($row['tgl_cancel']);
        $this->messagets->setDbValue($row['messagets']);
        $this->statusts->setDbValue($row['statusts']);
        $this->statusbayar->setDbValue($row['statusbayar']);
        $this->nomorfaktur->setDbValue($row['nomorfaktur']);
        $this->pembayaran->setDbValue($row['pembayaran']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->saldo->setDbValue($row['saldo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['messages'] = $this->messages->CurrentValue;
        $row['tgl_order'] = $this->tgl_order->CurrentValue;
        $row['kode_order'] = $this->kode_order->CurrentValue;
        $row['nama_customer'] = $this->nama_customer->CurrentValue;
        $row['nomor_handphone'] = $this->nomor_handphone->CurrentValue;
        $row['nilai_po'] = $this->nilai_po->CurrentValue;
        $row['tgl_faktur'] = $this->tgl_faktur->CurrentValue;
        $row['nilai_faktur'] = $this->nilai_faktur->CurrentValue;
        $row['piutang'] = $this->piutang->CurrentValue;
        $row['umur_faktur'] = $this->umur_faktur->CurrentValue;
        $row['tgl_antrian'] = $this->tgl_antrian->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['tgl_penagihan'] = $this->tgl_penagihan->CurrentValue;
        $row['tgl_return'] = $this->tgl_return->CurrentValue;
        $row['tgl_cancel'] = $this->tgl_cancel->CurrentValue;
        $row['messagets'] = $this->messagets->CurrentValue;
        $row['statusts'] = $this->statusts->CurrentValue;
        $row['statusbayar'] = $this->statusbayar->CurrentValue;
        $row['nomorfaktur'] = $this->nomorfaktur->CurrentValue;
        $row['pembayaran'] = $this->pembayaran->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['saldo'] = $this->saldo->CurrentValue;
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

        // messages

        // tgl_order

        // kode_order

        // nama_customer

        // nomor_handphone

        // nilai_po

        // tgl_faktur

        // nilai_faktur

        // piutang

        // umur_faktur

        // tgl_antrian

        // status

        // tgl_penagihan

        // tgl_return

        // tgl_cancel

        // messagets

        // statusts

        // statusbayar

        // nomorfaktur

        // pembayaran

        // keterangan

        // saldo
        if ($this->RowType == ROWTYPE_VIEW) {
            // messages
            $this->messages->ViewValue = $this->messages->CurrentValue;
            $this->messages->ViewCustomAttributes = "";

            // tgl_order
            $this->tgl_order->ViewValue = $this->tgl_order->CurrentValue;
            $this->tgl_order->ViewValue = FormatDateTime($this->tgl_order->ViewValue, 0);
            $this->tgl_order->ViewCustomAttributes = "";

            // kode_order
            $this->kode_order->ViewValue = $this->kode_order->CurrentValue;
            $this->kode_order->ViewCustomAttributes = "";

            // nama_customer
            $this->nama_customer->ViewValue = $this->nama_customer->CurrentValue;
            $this->nama_customer->ViewCustomAttributes = "";

            // nomor_handphone
            $this->nomor_handphone->ViewValue = $this->nomor_handphone->CurrentValue;
            $this->nomor_handphone->ViewCustomAttributes = "";

            // nilai_po
            $this->nilai_po->ViewValue = $this->nilai_po->CurrentValue;
            $this->nilai_po->ViewValue = FormatNumber($this->nilai_po->ViewValue, 0, -2, -2, -2);
            $this->nilai_po->ViewCustomAttributes = "";

            // tgl_faktur
            $this->tgl_faktur->ViewValue = $this->tgl_faktur->CurrentValue;
            $this->tgl_faktur->ViewValue = FormatDateTime($this->tgl_faktur->ViewValue, 0);
            $this->tgl_faktur->ViewCustomAttributes = "";

            // nilai_faktur
            $this->nilai_faktur->ViewValue = $this->nilai_faktur->CurrentValue;
            $this->nilai_faktur->ViewValue = FormatNumber($this->nilai_faktur->ViewValue, 0, -2, -2, -2);
            $this->nilai_faktur->ViewCustomAttributes = "";

            // piutang
            $this->piutang->ViewValue = $this->piutang->CurrentValue;
            $this->piutang->ViewValue = FormatNumber($this->piutang->ViewValue, 0, -2, -2, -2);
            $this->piutang->ViewCustomAttributes = "";

            // umur_faktur
            $this->umur_faktur->ViewValue = $this->umur_faktur->CurrentValue;
            $this->umur_faktur->ViewValue = FormatNumber($this->umur_faktur->ViewValue, 0, -2, -2, -2);
            $this->umur_faktur->ViewCustomAttributes = "";

            // tgl_antrian
            $this->tgl_antrian->ViewValue = $this->tgl_antrian->CurrentValue;
            $this->tgl_antrian->ViewValue = FormatDateTime($this->tgl_antrian->ViewValue, 0);
            $this->tgl_antrian->ViewCustomAttributes = "";

            // status
            if (ConvertToBool($this->status->CurrentValue)) {
                $this->status->ViewValue = $this->status->tagCaption(1) != "" ? $this->status->tagCaption(1) : "Yes";
            } else {
                $this->status->ViewValue = $this->status->tagCaption(2) != "" ? $this->status->tagCaption(2) : "No";
            }
            $this->status->ViewCustomAttributes = "";

            // tgl_penagihan
            $this->tgl_penagihan->ViewValue = $this->tgl_penagihan->CurrentValue;
            $this->tgl_penagihan->ViewValue = FormatDateTime($this->tgl_penagihan->ViewValue, 0);
            $this->tgl_penagihan->ViewCustomAttributes = "";

            // tgl_return
            $this->tgl_return->ViewValue = $this->tgl_return->CurrentValue;
            $this->tgl_return->ViewValue = FormatDateTime($this->tgl_return->ViewValue, 0);
            $this->tgl_return->ViewCustomAttributes = "";

            // tgl_cancel
            $this->tgl_cancel->ViewValue = $this->tgl_cancel->CurrentValue;
            $this->tgl_cancel->ViewValue = FormatDateTime($this->tgl_cancel->ViewValue, 0);
            $this->tgl_cancel->ViewCustomAttributes = "";

            // messagets
            $this->messagets->ViewValue = $this->messagets->CurrentValue;
            $this->messagets->ViewCustomAttributes = "";

            // statusts
            $this->statusts->ViewValue = $this->statusts->CurrentValue;
            $this->statusts->ViewValue = FormatNumber($this->statusts->ViewValue, 0, -2, -2, -2);
            $this->statusts->ViewCustomAttributes = "";

            // statusbayar
            $this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
            $this->statusbayar->ViewCustomAttributes = "";

            // nomorfaktur
            $this->nomorfaktur->ViewValue = $this->nomorfaktur->CurrentValue;
            $this->nomorfaktur->ViewCustomAttributes = "";

            // pembayaran
            $this->pembayaran->ViewValue = $this->pembayaran->CurrentValue;
            $this->pembayaran->ViewValue = FormatNumber($this->pembayaran->ViewValue, 0, -2, -2, -2);
            $this->pembayaran->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // saldo
            $this->saldo->ViewValue = $this->saldo->CurrentValue;
            $this->saldo->ViewValue = FormatNumber($this->saldo->ViewValue, 0, -2, -2, -2);
            $this->saldo->ViewCustomAttributes = "";

            // messages
            $this->messages->LinkCustomAttributes = "";
            $this->messages->HrefValue = "";
            $this->messages->TooltipValue = "";

            // tgl_order
            $this->tgl_order->LinkCustomAttributes = "";
            $this->tgl_order->HrefValue = "";
            $this->tgl_order->TooltipValue = "";

            // kode_order
            $this->kode_order->LinkCustomAttributes = "";
            $this->kode_order->HrefValue = "";
            $this->kode_order->TooltipValue = "";

            // nama_customer
            $this->nama_customer->LinkCustomAttributes = "";
            $this->nama_customer->HrefValue = "";
            $this->nama_customer->TooltipValue = "";

            // nomor_handphone
            $this->nomor_handphone->LinkCustomAttributes = "";
            $this->nomor_handphone->HrefValue = "";
            $this->nomor_handphone->TooltipValue = "";

            // nilai_po
            $this->nilai_po->LinkCustomAttributes = "";
            $this->nilai_po->HrefValue = "";
            $this->nilai_po->TooltipValue = "";

            // tgl_faktur
            $this->tgl_faktur->LinkCustomAttributes = "";
            $this->tgl_faktur->HrefValue = "";
            $this->tgl_faktur->TooltipValue = "";

            // nilai_faktur
            $this->nilai_faktur->LinkCustomAttributes = "";
            $this->nilai_faktur->HrefValue = "";
            $this->nilai_faktur->TooltipValue = "";

            // piutang
            $this->piutang->LinkCustomAttributes = "";
            $this->piutang->HrefValue = "";
            $this->piutang->TooltipValue = "";

            // umur_faktur
            $this->umur_faktur->LinkCustomAttributes = "";
            $this->umur_faktur->HrefValue = "";
            $this->umur_faktur->TooltipValue = "";

            // tgl_antrian
            $this->tgl_antrian->LinkCustomAttributes = "";
            $this->tgl_antrian->HrefValue = "";
            $this->tgl_antrian->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // tgl_penagihan
            $this->tgl_penagihan->LinkCustomAttributes = "";
            $this->tgl_penagihan->HrefValue = "";
            $this->tgl_penagihan->TooltipValue = "";

            // tgl_return
            $this->tgl_return->LinkCustomAttributes = "";
            $this->tgl_return->HrefValue = "";
            $this->tgl_return->TooltipValue = "";

            // tgl_cancel
            $this->tgl_cancel->LinkCustomAttributes = "";
            $this->tgl_cancel->HrefValue = "";
            $this->tgl_cancel->TooltipValue = "";

            // messagets
            $this->messagets->LinkCustomAttributes = "";
            $this->messagets->HrefValue = "";
            $this->messagets->TooltipValue = "";

            // statusts
            $this->statusts->LinkCustomAttributes = "";
            $this->statusts->HrefValue = "";
            $this->statusts->TooltipValue = "";

            // statusbayar
            $this->statusbayar->LinkCustomAttributes = "";
            $this->statusbayar->HrefValue = "";
            $this->statusbayar->TooltipValue = "";

            // nomorfaktur
            $this->nomorfaktur->LinkCustomAttributes = "";
            $this->nomorfaktur->HrefValue = "";
            $this->nomorfaktur->TooltipValue = "";

            // pembayaran
            $this->pembayaran->LinkCustomAttributes = "";
            $this->pembayaran->HrefValue = "";
            $this->pembayaran->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // saldo
            $this->saldo->LinkCustomAttributes = "";
            $this->saldo->HrefValue = "";
            $this->saldo->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // messages
            $this->messages->EditAttrs["class"] = "form-control";
            $this->messages->EditCustomAttributes = "";
            $this->messages->EditValue = HtmlEncode($this->messages->CurrentValue);
            $this->messages->PlaceHolder = RemoveHtml($this->messages->caption());

            // tgl_order
            $this->tgl_order->EditAttrs["class"] = "form-control";
            $this->tgl_order->EditCustomAttributes = "";
            $this->tgl_order->EditValue = HtmlEncode(FormatDateTime($this->tgl_order->CurrentValue, 8));
            $this->tgl_order->PlaceHolder = RemoveHtml($this->tgl_order->caption());

            // kode_order
            $this->kode_order->EditAttrs["class"] = "form-control";
            $this->kode_order->EditCustomAttributes = "";
            if (!$this->kode_order->Raw) {
                $this->kode_order->CurrentValue = HtmlDecode($this->kode_order->CurrentValue);
            }
            $this->kode_order->EditValue = HtmlEncode($this->kode_order->CurrentValue);
            $this->kode_order->PlaceHolder = RemoveHtml($this->kode_order->caption());

            // nama_customer
            $this->nama_customer->EditAttrs["class"] = "form-control";
            $this->nama_customer->EditCustomAttributes = "";
            if (!$this->nama_customer->Raw) {
                $this->nama_customer->CurrentValue = HtmlDecode($this->nama_customer->CurrentValue);
            }
            $this->nama_customer->EditValue = HtmlEncode($this->nama_customer->CurrentValue);
            $this->nama_customer->PlaceHolder = RemoveHtml($this->nama_customer->caption());

            // nomor_handphone
            $this->nomor_handphone->EditAttrs["class"] = "form-control";
            $this->nomor_handphone->EditCustomAttributes = "";
            if (!$this->nomor_handphone->Raw) {
                $this->nomor_handphone->CurrentValue = HtmlDecode($this->nomor_handphone->CurrentValue);
            }
            $this->nomor_handphone->EditValue = HtmlEncode($this->nomor_handphone->CurrentValue);
            $this->nomor_handphone->PlaceHolder = RemoveHtml($this->nomor_handphone->caption());

            // nilai_po
            $this->nilai_po->EditAttrs["class"] = "form-control";
            $this->nilai_po->EditCustomAttributes = "";
            $this->nilai_po->EditValue = HtmlEncode($this->nilai_po->CurrentValue);
            $this->nilai_po->PlaceHolder = RemoveHtml($this->nilai_po->caption());

            // tgl_faktur
            $this->tgl_faktur->EditAttrs["class"] = "form-control";
            $this->tgl_faktur->EditCustomAttributes = "";
            $this->tgl_faktur->EditValue = HtmlEncode(FormatDateTime($this->tgl_faktur->CurrentValue, 8));
            $this->tgl_faktur->PlaceHolder = RemoveHtml($this->tgl_faktur->caption());

            // nilai_faktur
            $this->nilai_faktur->EditAttrs["class"] = "form-control";
            $this->nilai_faktur->EditCustomAttributes = "";
            $this->nilai_faktur->EditValue = HtmlEncode($this->nilai_faktur->CurrentValue);
            $this->nilai_faktur->PlaceHolder = RemoveHtml($this->nilai_faktur->caption());

            // piutang
            $this->piutang->EditAttrs["class"] = "form-control";
            $this->piutang->EditCustomAttributes = "";
            $this->piutang->EditValue = HtmlEncode($this->piutang->CurrentValue);
            $this->piutang->PlaceHolder = RemoveHtml($this->piutang->caption());

            // umur_faktur
            $this->umur_faktur->EditAttrs["class"] = "form-control";
            $this->umur_faktur->EditCustomAttributes = "";
            $this->umur_faktur->EditValue = HtmlEncode($this->umur_faktur->CurrentValue);
            $this->umur_faktur->PlaceHolder = RemoveHtml($this->umur_faktur->caption());

            // tgl_antrian
            $this->tgl_antrian->EditAttrs["class"] = "form-control";
            $this->tgl_antrian->EditCustomAttributes = "";
            $this->tgl_antrian->EditValue = HtmlEncode(FormatDateTime($this->tgl_antrian->CurrentValue, 8));
            $this->tgl_antrian->PlaceHolder = RemoveHtml($this->tgl_antrian->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tgl_penagihan
            $this->tgl_penagihan->EditAttrs["class"] = "form-control";
            $this->tgl_penagihan->EditCustomAttributes = "";
            $this->tgl_penagihan->EditValue = HtmlEncode(FormatDateTime($this->tgl_penagihan->CurrentValue, 8));
            $this->tgl_penagihan->PlaceHolder = RemoveHtml($this->tgl_penagihan->caption());

            // tgl_return
            $this->tgl_return->EditAttrs["class"] = "form-control";
            $this->tgl_return->EditCustomAttributes = "";
            $this->tgl_return->EditValue = HtmlEncode(FormatDateTime($this->tgl_return->CurrentValue, 8));
            $this->tgl_return->PlaceHolder = RemoveHtml($this->tgl_return->caption());

            // tgl_cancel
            $this->tgl_cancel->EditAttrs["class"] = "form-control";
            $this->tgl_cancel->EditCustomAttributes = "";
            $this->tgl_cancel->EditValue = HtmlEncode(FormatDateTime($this->tgl_cancel->CurrentValue, 8));
            $this->tgl_cancel->PlaceHolder = RemoveHtml($this->tgl_cancel->caption());

            // messagets
            $this->messagets->EditAttrs["class"] = "form-control";
            $this->messagets->EditCustomAttributes = "";
            $this->messagets->EditValue = HtmlEncode($this->messagets->CurrentValue);
            $this->messagets->PlaceHolder = RemoveHtml($this->messagets->caption());

            // statusts
            $this->statusts->EditAttrs["class"] = "form-control";
            $this->statusts->EditCustomAttributes = "";
            $this->statusts->EditValue = HtmlEncode($this->statusts->CurrentValue);
            $this->statusts->PlaceHolder = RemoveHtml($this->statusts->caption());

            // statusbayar
            $this->statusbayar->EditAttrs["class"] = "form-control";
            $this->statusbayar->EditCustomAttributes = "";
            if (!$this->statusbayar->Raw) {
                $this->statusbayar->CurrentValue = HtmlDecode($this->statusbayar->CurrentValue);
            }
            $this->statusbayar->EditValue = HtmlEncode($this->statusbayar->CurrentValue);
            $this->statusbayar->PlaceHolder = RemoveHtml($this->statusbayar->caption());

            // nomorfaktur
            $this->nomorfaktur->EditAttrs["class"] = "form-control";
            $this->nomorfaktur->EditCustomAttributes = "";
            if (!$this->nomorfaktur->Raw) {
                $this->nomorfaktur->CurrentValue = HtmlDecode($this->nomorfaktur->CurrentValue);
            }
            $this->nomorfaktur->EditValue = HtmlEncode($this->nomorfaktur->CurrentValue);
            $this->nomorfaktur->PlaceHolder = RemoveHtml($this->nomorfaktur->caption());

            // pembayaran
            $this->pembayaran->EditAttrs["class"] = "form-control";
            $this->pembayaran->EditCustomAttributes = "";
            $this->pembayaran->EditValue = HtmlEncode($this->pembayaran->CurrentValue);
            $this->pembayaran->PlaceHolder = RemoveHtml($this->pembayaran->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            if (!$this->keterangan->Raw) {
                $this->keterangan->CurrentValue = HtmlDecode($this->keterangan->CurrentValue);
            }
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // saldo
            $this->saldo->EditAttrs["class"] = "form-control";
            $this->saldo->EditCustomAttributes = "";
            $this->saldo->EditValue = HtmlEncode($this->saldo->CurrentValue);
            $this->saldo->PlaceHolder = RemoveHtml($this->saldo->caption());

            // Add refer script

            // messages
            $this->messages->LinkCustomAttributes = "";
            $this->messages->HrefValue = "";

            // tgl_order
            $this->tgl_order->LinkCustomAttributes = "";
            $this->tgl_order->HrefValue = "";

            // kode_order
            $this->kode_order->LinkCustomAttributes = "";
            $this->kode_order->HrefValue = "";

            // nama_customer
            $this->nama_customer->LinkCustomAttributes = "";
            $this->nama_customer->HrefValue = "";

            // nomor_handphone
            $this->nomor_handphone->LinkCustomAttributes = "";
            $this->nomor_handphone->HrefValue = "";

            // nilai_po
            $this->nilai_po->LinkCustomAttributes = "";
            $this->nilai_po->HrefValue = "";

            // tgl_faktur
            $this->tgl_faktur->LinkCustomAttributes = "";
            $this->tgl_faktur->HrefValue = "";

            // nilai_faktur
            $this->nilai_faktur->LinkCustomAttributes = "";
            $this->nilai_faktur->HrefValue = "";

            // piutang
            $this->piutang->LinkCustomAttributes = "";
            $this->piutang->HrefValue = "";

            // umur_faktur
            $this->umur_faktur->LinkCustomAttributes = "";
            $this->umur_faktur->HrefValue = "";

            // tgl_antrian
            $this->tgl_antrian->LinkCustomAttributes = "";
            $this->tgl_antrian->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tgl_penagihan
            $this->tgl_penagihan->LinkCustomAttributes = "";
            $this->tgl_penagihan->HrefValue = "";

            // tgl_return
            $this->tgl_return->LinkCustomAttributes = "";
            $this->tgl_return->HrefValue = "";

            // tgl_cancel
            $this->tgl_cancel->LinkCustomAttributes = "";
            $this->tgl_cancel->HrefValue = "";

            // messagets
            $this->messagets->LinkCustomAttributes = "";
            $this->messagets->HrefValue = "";

            // statusts
            $this->statusts->LinkCustomAttributes = "";
            $this->statusts->HrefValue = "";

            // statusbayar
            $this->statusbayar->LinkCustomAttributes = "";
            $this->statusbayar->HrefValue = "";

            // nomorfaktur
            $this->nomorfaktur->LinkCustomAttributes = "";
            $this->nomorfaktur->HrefValue = "";

            // pembayaran
            $this->pembayaran->LinkCustomAttributes = "";
            $this->pembayaran->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

            // saldo
            $this->saldo->LinkCustomAttributes = "";
            $this->saldo->HrefValue = "";
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
        if ($this->messages->Required) {
            if (!$this->messages->IsDetailKey && EmptyValue($this->messages->FormValue)) {
                $this->messages->addErrorMessage(str_replace("%s", $this->messages->caption(), $this->messages->RequiredErrorMessage));
            }
        }
        if ($this->tgl_order->Required) {
            if (!$this->tgl_order->IsDetailKey && EmptyValue($this->tgl_order->FormValue)) {
                $this->tgl_order->addErrorMessage(str_replace("%s", $this->tgl_order->caption(), $this->tgl_order->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_order->FormValue)) {
            $this->tgl_order->addErrorMessage($this->tgl_order->getErrorMessage(false));
        }
        if ($this->kode_order->Required) {
            if (!$this->kode_order->IsDetailKey && EmptyValue($this->kode_order->FormValue)) {
                $this->kode_order->addErrorMessage(str_replace("%s", $this->kode_order->caption(), $this->kode_order->RequiredErrorMessage));
            }
        }
        if ($this->nama_customer->Required) {
            if (!$this->nama_customer->IsDetailKey && EmptyValue($this->nama_customer->FormValue)) {
                $this->nama_customer->addErrorMessage(str_replace("%s", $this->nama_customer->caption(), $this->nama_customer->RequiredErrorMessage));
            }
        }
        if ($this->nomor_handphone->Required) {
            if (!$this->nomor_handphone->IsDetailKey && EmptyValue($this->nomor_handphone->FormValue)) {
                $this->nomor_handphone->addErrorMessage(str_replace("%s", $this->nomor_handphone->caption(), $this->nomor_handphone->RequiredErrorMessage));
            }
        }
        if ($this->nilai_po->Required) {
            if (!$this->nilai_po->IsDetailKey && EmptyValue($this->nilai_po->FormValue)) {
                $this->nilai_po->addErrorMessage(str_replace("%s", $this->nilai_po->caption(), $this->nilai_po->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->nilai_po->FormValue)) {
            $this->nilai_po->addErrorMessage($this->nilai_po->getErrorMessage(false));
        }
        if ($this->tgl_faktur->Required) {
            if (!$this->tgl_faktur->IsDetailKey && EmptyValue($this->tgl_faktur->FormValue)) {
                $this->tgl_faktur->addErrorMessage(str_replace("%s", $this->tgl_faktur->caption(), $this->tgl_faktur->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_faktur->FormValue)) {
            $this->tgl_faktur->addErrorMessage($this->tgl_faktur->getErrorMessage(false));
        }
        if ($this->nilai_faktur->Required) {
            if (!$this->nilai_faktur->IsDetailKey && EmptyValue($this->nilai_faktur->FormValue)) {
                $this->nilai_faktur->addErrorMessage(str_replace("%s", $this->nilai_faktur->caption(), $this->nilai_faktur->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->nilai_faktur->FormValue)) {
            $this->nilai_faktur->addErrorMessage($this->nilai_faktur->getErrorMessage(false));
        }
        if ($this->piutang->Required) {
            if (!$this->piutang->IsDetailKey && EmptyValue($this->piutang->FormValue)) {
                $this->piutang->addErrorMessage(str_replace("%s", $this->piutang->caption(), $this->piutang->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->piutang->FormValue)) {
            $this->piutang->addErrorMessage($this->piutang->getErrorMessage(false));
        }
        if ($this->umur_faktur->Required) {
            if (!$this->umur_faktur->IsDetailKey && EmptyValue($this->umur_faktur->FormValue)) {
                $this->umur_faktur->addErrorMessage(str_replace("%s", $this->umur_faktur->caption(), $this->umur_faktur->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->umur_faktur->FormValue)) {
            $this->umur_faktur->addErrorMessage($this->umur_faktur->getErrorMessage(false));
        }
        if ($this->tgl_antrian->Required) {
            if (!$this->tgl_antrian->IsDetailKey && EmptyValue($this->tgl_antrian->FormValue)) {
                $this->tgl_antrian->addErrorMessage(str_replace("%s", $this->tgl_antrian->caption(), $this->tgl_antrian->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_antrian->FormValue)) {
            $this->tgl_antrian->addErrorMessage($this->tgl_antrian->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->tgl_penagihan->Required) {
            if (!$this->tgl_penagihan->IsDetailKey && EmptyValue($this->tgl_penagihan->FormValue)) {
                $this->tgl_penagihan->addErrorMessage(str_replace("%s", $this->tgl_penagihan->caption(), $this->tgl_penagihan->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_penagihan->FormValue)) {
            $this->tgl_penagihan->addErrorMessage($this->tgl_penagihan->getErrorMessage(false));
        }
        if ($this->tgl_return->Required) {
            if (!$this->tgl_return->IsDetailKey && EmptyValue($this->tgl_return->FormValue)) {
                $this->tgl_return->addErrorMessage(str_replace("%s", $this->tgl_return->caption(), $this->tgl_return->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_return->FormValue)) {
            $this->tgl_return->addErrorMessage($this->tgl_return->getErrorMessage(false));
        }
        if ($this->tgl_cancel->Required) {
            if (!$this->tgl_cancel->IsDetailKey && EmptyValue($this->tgl_cancel->FormValue)) {
                $this->tgl_cancel->addErrorMessage(str_replace("%s", $this->tgl_cancel->caption(), $this->tgl_cancel->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgl_cancel->FormValue)) {
            $this->tgl_cancel->addErrorMessage($this->tgl_cancel->getErrorMessage(false));
        }
        if ($this->messagets->Required) {
            if (!$this->messagets->IsDetailKey && EmptyValue($this->messagets->FormValue)) {
                $this->messagets->addErrorMessage(str_replace("%s", $this->messagets->caption(), $this->messagets->RequiredErrorMessage));
            }
        }
        if ($this->statusts->Required) {
            if (!$this->statusts->IsDetailKey && EmptyValue($this->statusts->FormValue)) {
                $this->statusts->addErrorMessage(str_replace("%s", $this->statusts->caption(), $this->statusts->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->statusts->FormValue)) {
            $this->statusts->addErrorMessage($this->statusts->getErrorMessage(false));
        }
        if ($this->statusbayar->Required) {
            if (!$this->statusbayar->IsDetailKey && EmptyValue($this->statusbayar->FormValue)) {
                $this->statusbayar->addErrorMessage(str_replace("%s", $this->statusbayar->caption(), $this->statusbayar->RequiredErrorMessage));
            }
        }
        if ($this->nomorfaktur->Required) {
            if (!$this->nomorfaktur->IsDetailKey && EmptyValue($this->nomorfaktur->FormValue)) {
                $this->nomorfaktur->addErrorMessage(str_replace("%s", $this->nomorfaktur->caption(), $this->nomorfaktur->RequiredErrorMessage));
            }
        }
        if ($this->pembayaran->Required) {
            if (!$this->pembayaran->IsDetailKey && EmptyValue($this->pembayaran->FormValue)) {
                $this->pembayaran->addErrorMessage(str_replace("%s", $this->pembayaran->caption(), $this->pembayaran->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->pembayaran->FormValue)) {
            $this->pembayaran->addErrorMessage($this->pembayaran->getErrorMessage(false));
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->saldo->Required) {
            if (!$this->saldo->IsDetailKey && EmptyValue($this->saldo->FormValue)) {
                $this->saldo->addErrorMessage(str_replace("%s", $this->saldo->caption(), $this->saldo->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->saldo->FormValue)) {
            $this->saldo->addErrorMessage($this->saldo->getErrorMessage(false));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // messages
        $this->messages->setDbValueDef($rsnew, $this->messages->CurrentValue, "", false);

        // tgl_order
        $this->tgl_order->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_order->CurrentValue, 0), null, false);

        // kode_order
        $this->kode_order->setDbValueDef($rsnew, $this->kode_order->CurrentValue, null, false);

        // nama_customer
        $this->nama_customer->setDbValueDef($rsnew, $this->nama_customer->CurrentValue, null, false);

        // nomor_handphone
        $this->nomor_handphone->setDbValueDef($rsnew, $this->nomor_handphone->CurrentValue, "", false);

        // nilai_po
        $this->nilai_po->setDbValueDef($rsnew, $this->nilai_po->CurrentValue, null, false);

        // tgl_faktur
        $this->tgl_faktur->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_faktur->CurrentValue, 0), null, false);

        // nilai_faktur
        $this->nilai_faktur->setDbValueDef($rsnew, $this->nilai_faktur->CurrentValue, null, false);

        // piutang
        $this->piutang->setDbValueDef($rsnew, $this->piutang->CurrentValue, null, false);

        // umur_faktur
        $this->umur_faktur->setDbValueDef($rsnew, $this->umur_faktur->CurrentValue, null, false);

        // tgl_antrian
        $this->tgl_antrian->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_antrian->CurrentValue, 0), null, false);

        // status
        $tmpBool = $this->status->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->status->setDbValueDef($rsnew, $tmpBool, null, strval($this->status->CurrentValue) == "");

        // tgl_penagihan
        $this->tgl_penagihan->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_penagihan->CurrentValue, 0), null, false);

        // tgl_return
        $this->tgl_return->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_return->CurrentValue, 0), null, false);

        // tgl_cancel
        $this->tgl_cancel->setDbValueDef($rsnew, UnFormatDateTime($this->tgl_cancel->CurrentValue, 0), null, false);

        // messagets
        $this->messagets->setDbValueDef($rsnew, $this->messagets->CurrentValue, null, false);

        // statusts
        $this->statusts->setDbValueDef($rsnew, $this->statusts->CurrentValue, null, false);

        // statusbayar
        $this->statusbayar->setDbValueDef($rsnew, $this->statusbayar->CurrentValue, null, false);

        // nomorfaktur
        $this->nomorfaktur->setDbValueDef($rsnew, $this->nomorfaktur->CurrentValue, null, false);

        // pembayaran
        $this->pembayaran->setDbValueDef($rsnew, $this->pembayaran->CurrentValue, null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);

        // saldo
        $this->saldo->setDbValueDef($rsnew, $this->saldo->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PenagihanList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_status":
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
