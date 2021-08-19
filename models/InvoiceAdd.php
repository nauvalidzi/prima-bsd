<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class InvoiceAdd extends Invoice
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'invoice';

    // Page object name
    public $PageObjName = "InvoiceAdd";

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

        // Table object (invoice)
        if (!isset($GLOBALS["invoice"]) || get_class($GLOBALS["invoice"]) == PROJECT_NAMESPACE . "invoice") {
            $GLOBALS["invoice"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'invoice');
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
                $doc = new $class(Container("invoice"));
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
                    if ($pageName == "InvoiceView") {
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
        $this->kode->setVisibility();
        $this->tglinvoice->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idorder->setVisibility();
        $this->totalnonpajak->setVisibility();
        $this->pajak->setVisibility();
        $this->totaltagihan->setVisibility();
        $this->sisabayar->Visible = false;
        $this->idtermpayment->setVisibility();
        $this->idtipepayment->setVisibility();
        $this->keterangan->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->setVisibility();
        $this->aktif->Visible = false;
        $this->readonly->setVisibility();
        $this->sent->Visible = false;
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
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idorder);
        $this->setupLookupOptions($this->idtipepayment);

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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("InvoiceList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "InvoiceList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "InvoiceView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->kode->CurrentValue = null;
        $this->kode->OldValue = $this->kode->CurrentValue;
        $this->tglinvoice->CurrentValue = null;
        $this->tglinvoice->OldValue = $this->tglinvoice->CurrentValue;
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->idorder->CurrentValue = null;
        $this->idorder->OldValue = $this->idorder->CurrentValue;
        $this->totalnonpajak->CurrentValue = 0;
        $this->pajak->CurrentValue = 0;
        $this->totaltagihan->CurrentValue = 0;
        $this->sisabayar->CurrentValue = 0;
        $this->idtermpayment->CurrentValue = null;
        $this->idtermpayment->OldValue = $this->idtermpayment->CurrentValue;
        $this->idtipepayment->CurrentValue = null;
        $this->idtipepayment->OldValue = $this->idtipepayment->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
        $this->aktif->CurrentValue = 1;
        $this->readonly->CurrentValue = 0;
        $this->sent->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
            }
        }

        // Check field name 'tglinvoice' first before field var 'x_tglinvoice'
        $val = $CurrentForm->hasValue("tglinvoice") ? $CurrentForm->getValue("tglinvoice") : $CurrentForm->getValue("x_tglinvoice");
        if (!$this->tglinvoice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglinvoice->Visible = false; // Disable update for API request
            } else {
                $this->tglinvoice->setFormValue($val);
            }
            $this->tglinvoice->CurrentValue = UnFormatDateTime($this->tglinvoice->CurrentValue, 0);
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

        // Check field name 'idorder' first before field var 'x_idorder'
        $val = $CurrentForm->hasValue("idorder") ? $CurrentForm->getValue("idorder") : $CurrentForm->getValue("x_idorder");
        if (!$this->idorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idorder->Visible = false; // Disable update for API request
            } else {
                $this->idorder->setFormValue($val);
            }
        }

        // Check field name 'totalnonpajak' first before field var 'x_totalnonpajak'
        $val = $CurrentForm->hasValue("totalnonpajak") ? $CurrentForm->getValue("totalnonpajak") : $CurrentForm->getValue("x_totalnonpajak");
        if (!$this->totalnonpajak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totalnonpajak->Visible = false; // Disable update for API request
            } else {
                $this->totalnonpajak->setFormValue($val);
            }
        }

        // Check field name 'pajak' first before field var 'x_pajak'
        $val = $CurrentForm->hasValue("pajak") ? $CurrentForm->getValue("pajak") : $CurrentForm->getValue("x_pajak");
        if (!$this->pajak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pajak->Visible = false; // Disable update for API request
            } else {
                $this->pajak->setFormValue($val);
            }
        }

        // Check field name 'totaltagihan' first before field var 'x_totaltagihan'
        $val = $CurrentForm->hasValue("totaltagihan") ? $CurrentForm->getValue("totaltagihan") : $CurrentForm->getValue("x_totaltagihan");
        if (!$this->totaltagihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totaltagihan->Visible = false; // Disable update for API request
            } else {
                $this->totaltagihan->setFormValue($val);
            }
        }

        // Check field name 'idtermpayment' first before field var 'x_idtermpayment'
        $val = $CurrentForm->hasValue("idtermpayment") ? $CurrentForm->getValue("idtermpayment") : $CurrentForm->getValue("x_idtermpayment");
        if (!$this->idtermpayment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idtermpayment->Visible = false; // Disable update for API request
            } else {
                $this->idtermpayment->setFormValue($val);
            }
        }

        // Check field name 'idtipepayment' first before field var 'x_idtipepayment'
        $val = $CurrentForm->hasValue("idtipepayment") ? $CurrentForm->getValue("idtipepayment") : $CurrentForm->getValue("x_idtipepayment");
        if (!$this->idtipepayment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idtipepayment->Visible = false; // Disable update for API request
            } else {
                $this->idtipepayment->setFormValue($val);
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

        // Check field name 'created_by' first before field var 'x_created_by'
        $val = $CurrentForm->hasValue("created_by") ? $CurrentForm->getValue("created_by") : $CurrentForm->getValue("x_created_by");
        if (!$this->created_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_by->Visible = false; // Disable update for API request
            } else {
                $this->created_by->setFormValue($val);
            }
        }

        // Check field name 'readonly' first before field var 'x_readonly'
        $val = $CurrentForm->hasValue("readonly") ? $CurrentForm->getValue("readonly") : $CurrentForm->getValue("x_readonly");
        if (!$this->readonly->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->readonly->Visible = false; // Disable update for API request
            } else {
                $this->readonly->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->tglinvoice->CurrentValue = $this->tglinvoice->FormValue;
        $this->tglinvoice->CurrentValue = UnFormatDateTime($this->tglinvoice->CurrentValue, 0);
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->idorder->CurrentValue = $this->idorder->FormValue;
        $this->totalnonpajak->CurrentValue = $this->totalnonpajak->FormValue;
        $this->pajak->CurrentValue = $this->pajak->FormValue;
        $this->totaltagihan->CurrentValue = $this->totaltagihan->FormValue;
        $this->idtermpayment->CurrentValue = $this->idtermpayment->FormValue;
        $this->idtipepayment->CurrentValue = $this->idtipepayment->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->created_by->CurrentValue = $this->created_by->FormValue;
        $this->readonly->CurrentValue = $this->readonly->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->kode->setDbValue($row['kode']);
        $this->tglinvoice->setDbValue($row['tglinvoice']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idorder->setDbValue($row['idorder']);
        $this->totalnonpajak->setDbValue($row['totalnonpajak']);
        $this->pajak->setDbValue($row['pajak']);
        $this->totaltagihan->setDbValue($row['totaltagihan']);
        $this->sisabayar->setDbValue($row['sisabayar']);
        $this->idtermpayment->setDbValue($row['idtermpayment']);
        $this->idtipepayment->setDbValue($row['idtipepayment']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->aktif->setDbValue($row['aktif']);
        $this->readonly->setDbValue($row['readonly']);
        $this->sent->setDbValue($row['sent']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['kode'] = $this->kode->CurrentValue;
        $row['tglinvoice'] = $this->tglinvoice->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['idorder'] = $this->idorder->CurrentValue;
        $row['totalnonpajak'] = $this->totalnonpajak->CurrentValue;
        $row['pajak'] = $this->pajak->CurrentValue;
        $row['totaltagihan'] = $this->totaltagihan->CurrentValue;
        $row['sisabayar'] = $this->sisabayar->CurrentValue;
        $row['idtermpayment'] = $this->idtermpayment->CurrentValue;
        $row['idtipepayment'] = $this->idtipepayment->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
        $row['aktif'] = $this->aktif->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
        $row['sent'] = $this->sent->CurrentValue;
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

        // Convert decimal values if posted back
        if ($this->pajak->FormValue == $this->pajak->CurrentValue && is_numeric(ConvertToFloatString($this->pajak->CurrentValue))) {
            $this->pajak->CurrentValue = ConvertToFloatString($this->pajak->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // kode

        // tglinvoice

        // idcustomer

        // idorder

        // totalnonpajak

        // pajak

        // totaltagihan

        // sisabayar

        // idtermpayment

        // idtipepayment

        // keterangan

        // created_at

        // created_by

        // aktif

        // readonly

        // sent
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // tglinvoice
            $this->tglinvoice->ViewValue = $this->tglinvoice->CurrentValue;
            $this->tglinvoice->ViewValue = FormatDateTime($this->tglinvoice->ViewValue, 0);
            $this->tglinvoice->ViewCustomAttributes = "";

            // idcustomer
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idcustomer`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // idorder
            $curVal = trim(strval($this->idorder->CurrentValue));
            if ($curVal != "") {
                $this->idorder->ViewValue = $this->idorder->lookupCacheOption($curVal);
                if ($this->idorder->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idorder`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idorder->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idorder->Lookup->renderViewRow($rswrk[0]);
                        $this->idorder->ViewValue = $this->idorder->displayValue($arwrk);
                    } else {
                        $this->idorder->ViewValue = $this->idorder->CurrentValue;
                    }
                }
            } else {
                $this->idorder->ViewValue = null;
            }
            $this->idorder->ViewCustomAttributes = "";

            // totalnonpajak
            $this->totalnonpajak->ViewValue = $this->totalnonpajak->CurrentValue;
            $this->totalnonpajak->ViewValue = FormatCurrency($this->totalnonpajak->ViewValue, 2, -2, -2, -2);
            $this->totalnonpajak->ViewCustomAttributes = "";

            // pajak
            $this->pajak->ViewValue = $this->pajak->CurrentValue;
            $this->pajak->ViewValue = FormatNumber($this->pajak->ViewValue, 2, -2, -2, -2);
            $this->pajak->ViewCustomAttributes = "";

            // totaltagihan
            $this->totaltagihan->ViewValue = $this->totaltagihan->CurrentValue;
            $this->totaltagihan->ViewValue = FormatCurrency($this->totaltagihan->ViewValue, 2, -2, -2, -2);
            $this->totaltagihan->ViewCustomAttributes = "";

            // sisabayar
            $this->sisabayar->ViewValue = $this->sisabayar->CurrentValue;
            $this->sisabayar->ViewValue = FormatCurrency($this->sisabayar->ViewValue, 2, -2, -2, -2);
            $this->sisabayar->ViewCustomAttributes = "";

            // idtermpayment
            $this->idtermpayment->ViewValue = $this->idtermpayment->CurrentValue;
            $this->idtermpayment->ViewValue = FormatNumber($this->idtermpayment->ViewValue, 0, -2, -2, -2);
            $this->idtermpayment->ViewCustomAttributes = "";

            // idtipepayment
            $curVal = trim(strval($this->idtipepayment->CurrentValue));
            if ($curVal != "") {
                $this->idtipepayment->ViewValue = $this->idtipepayment->lookupCacheOption($curVal);
                if ($this->idtipepayment->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idtipepayment->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idtipepayment->Lookup->renderViewRow($rswrk[0]);
                        $this->idtipepayment->ViewValue = $this->idtipepayment->displayValue($arwrk);
                    } else {
                        $this->idtipepayment->ViewValue = $this->idtipepayment->CurrentValue;
                    }
                }
            } else {
                $this->idtipepayment->ViewValue = null;
            }
            $this->idtipepayment->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // aktif
            if (ConvertToBool($this->aktif->CurrentValue)) {
                $this->aktif->ViewValue = $this->aktif->tagCaption(1) != "" ? $this->aktif->tagCaption(1) : "Yes";
            } else {
                $this->aktif->ViewValue = $this->aktif->tagCaption(2) != "" ? $this->aktif->tagCaption(2) : "No";
            }
            $this->aktif->ViewCustomAttributes = "";

            // readonly
            $this->readonly->ViewValue = $this->readonly->CurrentValue;
            $this->readonly->ViewCustomAttributes = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // tglinvoice
            $this->tglinvoice->LinkCustomAttributes = "";
            $this->tglinvoice->HrefValue = "";
            $this->tglinvoice->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idorder
            $this->idorder->LinkCustomAttributes = "";
            $this->idorder->HrefValue = "";
            $this->idorder->TooltipValue = "";

            // totalnonpajak
            $this->totalnonpajak->LinkCustomAttributes = "";
            $this->totalnonpajak->HrefValue = "";
            $this->totalnonpajak->TooltipValue = "";

            // pajak
            $this->pajak->LinkCustomAttributes = "";
            $this->pajak->HrefValue = "";
            $this->pajak->TooltipValue = "";

            // totaltagihan
            $this->totaltagihan->LinkCustomAttributes = "";
            $this->totaltagihan->HrefValue = "";
            $this->totaltagihan->TooltipValue = "";

            // idtermpayment
            $this->idtermpayment->LinkCustomAttributes = "";
            $this->idtermpayment->HrefValue = "";
            $this->idtermpayment->TooltipValue = "";

            // idtipepayment
            $this->idtipepayment->LinkCustomAttributes = "";
            $this->idtipepayment->HrefValue = "";
            $this->idtipepayment->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";

            // readonly
            $this->readonly->LinkCustomAttributes = "";
            $this->readonly->HrefValue = "";
            $this->readonly->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "readonly";
            if (!$this->kode->Raw) {
                $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->CurrentValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

            // tglinvoice
            $this->tglinvoice->EditAttrs["class"] = "form-control";
            $this->tglinvoice->EditCustomAttributes = "";
            $this->tglinvoice->EditValue = HtmlEncode(FormatDateTime($this->tglinvoice->CurrentValue, 8));
            $this->tglinvoice->PlaceHolder = RemoveHtml($this->tglinvoice->caption());

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            } else {
                $this->idcustomer->ViewValue = $this->idcustomer->Lookup !== null && is_array($this->idcustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idcustomer->ViewValue !== null) { // Load from cache
                $this->idcustomer->EditValue = array_values($this->idcustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`idcustomer`" . SearchString("=", $this->idcustomer->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add") ? "jumlah > 0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idcustomer->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idcustomer->EditValue = $arwrk;
            }
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // idorder
            $this->idorder->EditAttrs["class"] = "form-control";
            $this->idorder->EditCustomAttributes = "";
            $curVal = trim(strval($this->idorder->CurrentValue));
            if ($curVal != "") {
                $this->idorder->ViewValue = $this->idorder->lookupCacheOption($curVal);
            } else {
                $this->idorder->ViewValue = $this->idorder->Lookup !== null && is_array($this->idorder->Lookup->Options) ? $curVal : null;
            }
            if ($this->idorder->ViewValue !== null) { // Load from cache
                $this->idorder->EditValue = array_values($this->idorder->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`idorder`" . SearchString("=", $this->idorder->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idorder->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->idorder->Lookup->renderViewRow($row);
                $this->idorder->EditValue = $arwrk;
            }
            $this->idorder->PlaceHolder = RemoveHtml($this->idorder->caption());

            // totalnonpajak
            $this->totalnonpajak->EditAttrs["class"] = "form-control";
            $this->totalnonpajak->EditCustomAttributes = "readonly";
            $this->totalnonpajak->EditValue = HtmlEncode($this->totalnonpajak->CurrentValue);
            $this->totalnonpajak->PlaceHolder = RemoveHtml($this->totalnonpajak->caption());

            // pajak
            $this->pajak->EditAttrs["class"] = "form-control";
            $this->pajak->EditCustomAttributes = "";
            $this->pajak->EditValue = HtmlEncode($this->pajak->CurrentValue);
            $this->pajak->PlaceHolder = RemoveHtml($this->pajak->caption());
            if (strval($this->pajak->EditValue) != "" && is_numeric($this->pajak->EditValue)) {
                $this->pajak->EditValue = FormatNumber($this->pajak->EditValue, -2, -2, -2, -2);
            }

            // totaltagihan
            $this->totaltagihan->EditAttrs["class"] = "form-control";
            $this->totaltagihan->EditCustomAttributes = "readonly";
            $this->totaltagihan->EditValue = HtmlEncode($this->totaltagihan->CurrentValue);
            $this->totaltagihan->PlaceHolder = RemoveHtml($this->totaltagihan->caption());

            // idtermpayment
            $this->idtermpayment->EditAttrs["class"] = "form-control";
            $this->idtermpayment->EditCustomAttributes = "";
            $this->idtermpayment->EditValue = HtmlEncode($this->idtermpayment->CurrentValue);
            $this->idtermpayment->PlaceHolder = RemoveHtml($this->idtermpayment->caption());

            // idtipepayment
            $this->idtipepayment->EditAttrs["class"] = "form-control";
            $this->idtipepayment->EditCustomAttributes = "";
            $curVal = trim(strval($this->idtipepayment->CurrentValue));
            if ($curVal != "") {
                $this->idtipepayment->ViewValue = $this->idtipepayment->lookupCacheOption($curVal);
            } else {
                $this->idtipepayment->ViewValue = $this->idtipepayment->Lookup !== null && is_array($this->idtipepayment->Lookup->Options) ? $curVal : null;
            }
            if ($this->idtipepayment->ViewValue !== null) { // Load from cache
                $this->idtipepayment->EditValue = array_values($this->idtipepayment->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idtipepayment->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idtipepayment->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idtipepayment->EditValue = $arwrk;
            }
            $this->idtipepayment->PlaceHolder = RemoveHtml($this->idtipepayment->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

            // readonly
            $this->readonly->EditAttrs["class"] = "form-control";
            $this->readonly->EditCustomAttributes = "";
            $this->readonly->CurrentValue = 0;

            // Add refer script

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";

            // tglinvoice
            $this->tglinvoice->LinkCustomAttributes = "";
            $this->tglinvoice->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // idorder
            $this->idorder->LinkCustomAttributes = "";
            $this->idorder->HrefValue = "";

            // totalnonpajak
            $this->totalnonpajak->LinkCustomAttributes = "";
            $this->totalnonpajak->HrefValue = "";

            // pajak
            $this->pajak->LinkCustomAttributes = "";
            $this->pajak->HrefValue = "";

            // totaltagihan
            $this->totaltagihan->LinkCustomAttributes = "";
            $this->totaltagihan->HrefValue = "";

            // idtermpayment
            $this->idtermpayment->LinkCustomAttributes = "";
            $this->idtermpayment->HrefValue = "";

            // idtipepayment
            $this->idtipepayment->LinkCustomAttributes = "";
            $this->idtipepayment->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";

            // readonly
            $this->readonly->LinkCustomAttributes = "";
            $this->readonly->HrefValue = "";
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
        if ($this->kode->Required) {
            if (!$this->kode->IsDetailKey && EmptyValue($this->kode->FormValue)) {
                $this->kode->addErrorMessage(str_replace("%s", $this->kode->caption(), $this->kode->RequiredErrorMessage));
            }
        }
        if ($this->tglinvoice->Required) {
            if (!$this->tglinvoice->IsDetailKey && EmptyValue($this->tglinvoice->FormValue)) {
                $this->tglinvoice->addErrorMessage(str_replace("%s", $this->tglinvoice->caption(), $this->tglinvoice->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglinvoice->FormValue)) {
            $this->tglinvoice->addErrorMessage($this->tglinvoice->getErrorMessage(false));
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if ($this->idorder->Required) {
            if (!$this->idorder->IsDetailKey && EmptyValue($this->idorder->FormValue)) {
                $this->idorder->addErrorMessage(str_replace("%s", $this->idorder->caption(), $this->idorder->RequiredErrorMessage));
            }
        }
        if ($this->totalnonpajak->Required) {
            if (!$this->totalnonpajak->IsDetailKey && EmptyValue($this->totalnonpajak->FormValue)) {
                $this->totalnonpajak->addErrorMessage(str_replace("%s", $this->totalnonpajak->caption(), $this->totalnonpajak->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->totalnonpajak->FormValue)) {
            $this->totalnonpajak->addErrorMessage($this->totalnonpajak->getErrorMessage(false));
        }
        if ($this->pajak->Required) {
            if (!$this->pajak->IsDetailKey && EmptyValue($this->pajak->FormValue)) {
                $this->pajak->addErrorMessage(str_replace("%s", $this->pajak->caption(), $this->pajak->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->pajak->FormValue)) {
            $this->pajak->addErrorMessage($this->pajak->getErrorMessage(false));
        }
        if ($this->totaltagihan->Required) {
            if (!$this->totaltagihan->IsDetailKey && EmptyValue($this->totaltagihan->FormValue)) {
                $this->totaltagihan->addErrorMessage(str_replace("%s", $this->totaltagihan->caption(), $this->totaltagihan->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->totaltagihan->FormValue)) {
            $this->totaltagihan->addErrorMessage($this->totaltagihan->getErrorMessage(false));
        }
        if ($this->idtermpayment->Required) {
            if (!$this->idtermpayment->IsDetailKey && EmptyValue($this->idtermpayment->FormValue)) {
                $this->idtermpayment->addErrorMessage(str_replace("%s", $this->idtermpayment->caption(), $this->idtermpayment->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idtermpayment->FormValue)) {
            $this->idtermpayment->addErrorMessage($this->idtermpayment->getErrorMessage(false));
        }
        if ($this->idtipepayment->Required) {
            if (!$this->idtipepayment->IsDetailKey && EmptyValue($this->idtipepayment->FormValue)) {
                $this->idtipepayment->addErrorMessage(str_replace("%s", $this->idtipepayment->caption(), $this->idtipepayment->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
            }
        }
        if ($this->readonly->Required) {
            if (!$this->readonly->IsDetailKey && EmptyValue($this->readonly->FormValue)) {
                $this->readonly->addErrorMessage(str_replace("%s", $this->readonly->caption(), $this->readonly->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("InvoiceDetailGrid");
        if (in_array("invoice_detail", $detailTblVar) && $detailPage->DetailAdd) {
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->created_by->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->created_by->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->created_by->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // kode
        $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, "", false);

        // tglinvoice
        $this->tglinvoice->setDbValueDef($rsnew, UnFormatDateTime($this->tglinvoice->CurrentValue, 0), CurrentDate(), false);

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, 0, false);

        // idorder
        $this->idorder->setDbValueDef($rsnew, $this->idorder->CurrentValue, 0, false);

        // totalnonpajak
        $this->totalnonpajak->setDbValueDef($rsnew, $this->totalnonpajak->CurrentValue, 0, strval($this->totalnonpajak->CurrentValue) == "");

        // pajak
        $this->pajak->setDbValueDef($rsnew, $this->pajak->CurrentValue, 0, strval($this->pajak->CurrentValue) == "");

        // totaltagihan
        $this->totaltagihan->setDbValueDef($rsnew, $this->totaltagihan->CurrentValue, 0, strval($this->totaltagihan->CurrentValue) == "");

        // idtermpayment
        $this->idtermpayment->setDbValueDef($rsnew, $this->idtermpayment->CurrentValue, 0, false);

        // idtipepayment
        $this->idtipepayment->setDbValueDef($rsnew, $this->idtipepayment->CurrentValue, null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);

        // readonly
        $this->readonly->setDbValueDef($rsnew, $this->readonly->CurrentValue, 0, strval($this->readonly->CurrentValue) == "");

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("InvoiceDetailGrid");
            if (in_array("invoice_detail", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idinvoice->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "invoice_detail"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idinvoice->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
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

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->created_by->CurrentValue);
        }
        return true;
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
            if (in_array("invoice_detail", $detailTblVar)) {
                $detailPageObj = Container("InvoiceDetailGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idinvoice->IsDetailKey = true;
                    $detailPageObj->idinvoice->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idinvoice->setSessionValue($detailPageObj->idinvoice->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("InvoiceList"), "", $this->TableVar, true);
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
                case "x_idcustomer":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idorder":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idtipepayment":
                    break;
                case "x_aktif":
                    break;
                case "x_sent":
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
