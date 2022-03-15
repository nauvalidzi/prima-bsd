<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdConfirmprintAdd extends NpdConfirmprint
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_confirmprint';

    // Page object name
    public $PageObjName = "NpdConfirmprintAdd";

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

        // Table object (npd_confirmprint)
        if (!isset($GLOBALS["npd_confirmprint"]) || get_class($GLOBALS["npd_confirmprint"]) == PROJECT_NAMESPACE . "npd_confirmprint") {
            $GLOBALS["npd_confirmprint"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_confirmprint');
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
                $doc = new $class(Container("npd_confirmprint"));
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
                    if ($pageName == "NpdConfirmprintView") {
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
        $this->brand->setVisibility();
        $this->tglkirim->setVisibility();
        $this->tgldisetujui->setVisibility();
        $this->desainprimer->setVisibility();
        $this->materialprimer->setVisibility();
        $this->aplikasiprimer->setVisibility();
        $this->jumlahcetakprimer->setVisibility();
        $this->desainsekunder->setVisibility();
        $this->materialinnerbox->setVisibility();
        $this->aplikasiinnerbox->setVisibility();
        $this->jumlahcetak->setVisibility();
        $this->checked_by->setVisibility();
        $this->approved_by->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
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
        $this->setupLookupOptions($this->checked_by);
        $this->setupLookupOptions($this->approved_by);

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
                    $this->terminate("NpdConfirmprintList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "NpdConfirmprintList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdConfirmprintView") {
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
        $this->brand->CurrentValue = null;
        $this->brand->OldValue = $this->brand->CurrentValue;
        $this->tglkirim->CurrentValue = null;
        $this->tglkirim->OldValue = $this->tglkirim->CurrentValue;
        $this->tgldisetujui->CurrentValue = null;
        $this->tgldisetujui->OldValue = $this->tgldisetujui->CurrentValue;
        $this->desainprimer->CurrentValue = null;
        $this->desainprimer->OldValue = $this->desainprimer->CurrentValue;
        $this->materialprimer->CurrentValue = null;
        $this->materialprimer->OldValue = $this->materialprimer->CurrentValue;
        $this->aplikasiprimer->CurrentValue = null;
        $this->aplikasiprimer->OldValue = $this->aplikasiprimer->CurrentValue;
        $this->jumlahcetakprimer->CurrentValue = null;
        $this->jumlahcetakprimer->OldValue = $this->jumlahcetakprimer->CurrentValue;
        $this->desainsekunder->CurrentValue = null;
        $this->desainsekunder->OldValue = $this->desainsekunder->CurrentValue;
        $this->materialinnerbox->CurrentValue = null;
        $this->materialinnerbox->OldValue = $this->materialinnerbox->CurrentValue;
        $this->aplikasiinnerbox->CurrentValue = null;
        $this->aplikasiinnerbox->OldValue = $this->aplikasiinnerbox->CurrentValue;
        $this->jumlahcetak->CurrentValue = null;
        $this->jumlahcetak->OldValue = $this->jumlahcetak->CurrentValue;
        $this->checked_by->CurrentValue = null;
        $this->checked_by->OldValue = $this->checked_by->CurrentValue;
        $this->approved_by->CurrentValue = null;
        $this->approved_by->OldValue = $this->approved_by->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'brand' first before field var 'x_brand'
        $val = $CurrentForm->hasValue("brand") ? $CurrentForm->getValue("brand") : $CurrentForm->getValue("x_brand");
        if (!$this->brand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->brand->Visible = false; // Disable update for API request
            } else {
                $this->brand->setFormValue($val);
            }
        }

        // Check field name 'tglkirim' first before field var 'x_tglkirim'
        $val = $CurrentForm->hasValue("tglkirim") ? $CurrentForm->getValue("tglkirim") : $CurrentForm->getValue("x_tglkirim");
        if (!$this->tglkirim->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglkirim->Visible = false; // Disable update for API request
            } else {
                $this->tglkirim->setFormValue($val);
            }
            $this->tglkirim->CurrentValue = UnFormatDateTime($this->tglkirim->CurrentValue, 0);
        }

        // Check field name 'tgldisetujui' first before field var 'x_tgldisetujui'
        $val = $CurrentForm->hasValue("tgldisetujui") ? $CurrentForm->getValue("tgldisetujui") : $CurrentForm->getValue("x_tgldisetujui");
        if (!$this->tgldisetujui->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgldisetujui->Visible = false; // Disable update for API request
            } else {
                $this->tgldisetujui->setFormValue($val);
            }
            $this->tgldisetujui->CurrentValue = UnFormatDateTime($this->tgldisetujui->CurrentValue, 0);
        }

        // Check field name 'desainprimer' first before field var 'x_desainprimer'
        $val = $CurrentForm->hasValue("desainprimer") ? $CurrentForm->getValue("desainprimer") : $CurrentForm->getValue("x_desainprimer");
        if (!$this->desainprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desainprimer->Visible = false; // Disable update for API request
            } else {
                $this->desainprimer->setFormValue($val);
            }
        }

        // Check field name 'materialprimer' first before field var 'x_materialprimer'
        $val = $CurrentForm->hasValue("materialprimer") ? $CurrentForm->getValue("materialprimer") : $CurrentForm->getValue("x_materialprimer");
        if (!$this->materialprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->materialprimer->Visible = false; // Disable update for API request
            } else {
                $this->materialprimer->setFormValue($val);
            }
        }

        // Check field name 'aplikasiprimer' first before field var 'x_aplikasiprimer'
        $val = $CurrentForm->hasValue("aplikasiprimer") ? $CurrentForm->getValue("aplikasiprimer") : $CurrentForm->getValue("x_aplikasiprimer");
        if (!$this->aplikasiprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiprimer->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiprimer->setFormValue($val);
            }
        }

        // Check field name 'jumlahcetakprimer' first before field var 'x_jumlahcetakprimer'
        $val = $CurrentForm->hasValue("jumlahcetakprimer") ? $CurrentForm->getValue("jumlahcetakprimer") : $CurrentForm->getValue("x_jumlahcetakprimer");
        if (!$this->jumlahcetakprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahcetakprimer->Visible = false; // Disable update for API request
            } else {
                $this->jumlahcetakprimer->setFormValue($val);
            }
        }

        // Check field name 'desainsekunder' first before field var 'x_desainsekunder'
        $val = $CurrentForm->hasValue("desainsekunder") ? $CurrentForm->getValue("desainsekunder") : $CurrentForm->getValue("x_desainsekunder");
        if (!$this->desainsekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desainsekunder->Visible = false; // Disable update for API request
            } else {
                $this->desainsekunder->setFormValue($val);
            }
        }

        // Check field name 'materialinnerbox' first before field var 'x_materialinnerbox'
        $val = $CurrentForm->hasValue("materialinnerbox") ? $CurrentForm->getValue("materialinnerbox") : $CurrentForm->getValue("x_materialinnerbox");
        if (!$this->materialinnerbox->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->materialinnerbox->Visible = false; // Disable update for API request
            } else {
                $this->materialinnerbox->setFormValue($val);
            }
        }

        // Check field name 'aplikasiinnerbox' first before field var 'x_aplikasiinnerbox'
        $val = $CurrentForm->hasValue("aplikasiinnerbox") ? $CurrentForm->getValue("aplikasiinnerbox") : $CurrentForm->getValue("x_aplikasiinnerbox");
        if (!$this->aplikasiinnerbox->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiinnerbox->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiinnerbox->setFormValue($val);
            }
        }

        // Check field name 'jumlahcetak' first before field var 'x_jumlahcetak'
        $val = $CurrentForm->hasValue("jumlahcetak") ? $CurrentForm->getValue("jumlahcetak") : $CurrentForm->getValue("x_jumlahcetak");
        if (!$this->jumlahcetak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahcetak->Visible = false; // Disable update for API request
            } else {
                $this->jumlahcetak->setFormValue($val);
            }
        }

        // Check field name 'checked_by' first before field var 'x_checked_by'
        $val = $CurrentForm->hasValue("checked_by") ? $CurrentForm->getValue("checked_by") : $CurrentForm->getValue("x_checked_by");
        if (!$this->checked_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->checked_by->Visible = false; // Disable update for API request
            } else {
                $this->checked_by->setFormValue($val);
            }
        }

        // Check field name 'approved_by' first before field var 'x_approved_by'
        $val = $CurrentForm->hasValue("approved_by") ? $CurrentForm->getValue("approved_by") : $CurrentForm->getValue("x_approved_by");
        if (!$this->approved_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->approved_by->Visible = false; // Disable update for API request
            } else {
                $this->approved_by->setFormValue($val);
            }
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        }

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->brand->CurrentValue = $this->brand->FormValue;
        $this->tglkirim->CurrentValue = $this->tglkirim->FormValue;
        $this->tglkirim->CurrentValue = UnFormatDateTime($this->tglkirim->CurrentValue, 0);
        $this->tgldisetujui->CurrentValue = $this->tgldisetujui->FormValue;
        $this->tgldisetujui->CurrentValue = UnFormatDateTime($this->tgldisetujui->CurrentValue, 0);
        $this->desainprimer->CurrentValue = $this->desainprimer->FormValue;
        $this->materialprimer->CurrentValue = $this->materialprimer->FormValue;
        $this->aplikasiprimer->CurrentValue = $this->aplikasiprimer->FormValue;
        $this->jumlahcetakprimer->CurrentValue = $this->jumlahcetakprimer->FormValue;
        $this->desainsekunder->CurrentValue = $this->desainsekunder->FormValue;
        $this->materialinnerbox->CurrentValue = $this->materialinnerbox->FormValue;
        $this->aplikasiinnerbox->CurrentValue = $this->aplikasiinnerbox->FormValue;
        $this->jumlahcetak->CurrentValue = $this->jumlahcetak->FormValue;
        $this->checked_by->CurrentValue = $this->checked_by->FormValue;
        $this->approved_by->CurrentValue = $this->approved_by->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
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
        $this->brand->setDbValue($row['brand']);
        $this->tglkirim->setDbValue($row['tglkirim']);
        $this->tgldisetujui->setDbValue($row['tgldisetujui']);
        $this->desainprimer->setDbValue($row['desainprimer']);
        $this->materialprimer->setDbValue($row['materialprimer']);
        $this->aplikasiprimer->setDbValue($row['aplikasiprimer']);
        $this->jumlahcetakprimer->setDbValue($row['jumlahcetakprimer']);
        $this->desainsekunder->setDbValue($row['desainsekunder']);
        $this->materialinnerbox->setDbValue($row['materialinnerbox']);
        $this->aplikasiinnerbox->setDbValue($row['aplikasiinnerbox']);
        $this->jumlahcetak->setDbValue($row['jumlahcetak']);
        $this->checked_by->setDbValue($row['checked_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['brand'] = $this->brand->CurrentValue;
        $row['tglkirim'] = $this->tglkirim->CurrentValue;
        $row['tgldisetujui'] = $this->tgldisetujui->CurrentValue;
        $row['desainprimer'] = $this->desainprimer->CurrentValue;
        $row['materialprimer'] = $this->materialprimer->CurrentValue;
        $row['aplikasiprimer'] = $this->aplikasiprimer->CurrentValue;
        $row['jumlahcetakprimer'] = $this->jumlahcetakprimer->CurrentValue;
        $row['desainsekunder'] = $this->desainsekunder->CurrentValue;
        $row['materialinnerbox'] = $this->materialinnerbox->CurrentValue;
        $row['aplikasiinnerbox'] = $this->aplikasiinnerbox->CurrentValue;
        $row['jumlahcetak'] = $this->jumlahcetak->CurrentValue;
        $row['checked_by'] = $this->checked_by->CurrentValue;
        $row['approved_by'] = $this->approved_by->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
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

        // brand

        // tglkirim

        // tgldisetujui

        // desainprimer

        // materialprimer

        // aplikasiprimer

        // jumlahcetakprimer

        // desainsekunder

        // materialinnerbox

        // aplikasiinnerbox

        // jumlahcetak

        // checked_by

        // approved_by

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // brand
            $this->brand->ViewValue = $this->brand->CurrentValue;
            $this->brand->ViewCustomAttributes = "";

            // tglkirim
            $this->tglkirim->ViewValue = $this->tglkirim->CurrentValue;
            $this->tglkirim->ViewValue = FormatDateTime($this->tglkirim->ViewValue, 0);
            $this->tglkirim->ViewCustomAttributes = "";

            // tgldisetujui
            $this->tgldisetujui->ViewValue = $this->tgldisetujui->CurrentValue;
            $this->tgldisetujui->ViewValue = FormatDateTime($this->tgldisetujui->ViewValue, 0);
            $this->tgldisetujui->ViewCustomAttributes = "";

            // desainprimer
            $this->desainprimer->ViewValue = $this->desainprimer->CurrentValue;
            $this->desainprimer->ViewCustomAttributes = "";

            // materialprimer
            $this->materialprimer->ViewValue = $this->materialprimer->CurrentValue;
            $this->materialprimer->ViewCustomAttributes = "";

            // aplikasiprimer
            $this->aplikasiprimer->ViewValue = $this->aplikasiprimer->CurrentValue;
            $this->aplikasiprimer->ViewCustomAttributes = "";

            // jumlahcetakprimer
            $this->jumlahcetakprimer->ViewValue = $this->jumlahcetakprimer->CurrentValue;
            $this->jumlahcetakprimer->ViewValue = FormatNumber($this->jumlahcetakprimer->ViewValue, 0, -2, -2, -2);
            $this->jumlahcetakprimer->ViewCustomAttributes = "";

            // desainsekunder
            $this->desainsekunder->ViewValue = $this->desainsekunder->CurrentValue;
            $this->desainsekunder->ViewCustomAttributes = "";

            // materialinnerbox
            $this->materialinnerbox->ViewValue = $this->materialinnerbox->CurrentValue;
            $this->materialinnerbox->ViewCustomAttributes = "";

            // aplikasiinnerbox
            $this->aplikasiinnerbox->ViewValue = $this->aplikasiinnerbox->CurrentValue;
            $this->aplikasiinnerbox->ViewCustomAttributes = "";

            // jumlahcetak
            $this->jumlahcetak->ViewValue = $this->jumlahcetak->CurrentValue;
            $this->jumlahcetak->ViewValue = FormatNumber($this->jumlahcetak->ViewValue, 0, -2, -2, -2);
            $this->jumlahcetak->ViewCustomAttributes = "";

            // checked_by
            $curVal = trim(strval($this->checked_by->CurrentValue));
            if ($curVal != "") {
                $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
                if ($this->checked_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->checked_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->checked_by->Lookup->renderViewRow($rswrk[0]);
                        $this->checked_by->ViewValue = $this->checked_by->displayValue($arwrk);
                    } else {
                        $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
                    }
                }
            } else {
                $this->checked_by->ViewValue = null;
            }
            $this->checked_by->ViewCustomAttributes = "";

            // approved_by
            $curVal = trim(strval($this->approved_by->CurrentValue));
            if ($curVal != "") {
                $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
                if ($this->approved_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->approved_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->approved_by->Lookup->renderViewRow($rswrk[0]);
                        $this->approved_by->ViewValue = $this->approved_by->displayValue($arwrk);
                    } else {
                        $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
                    }
                }
            } else {
                $this->approved_by->ViewValue = null;
            }
            $this->approved_by->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // brand
            $this->brand->LinkCustomAttributes = "";
            $this->brand->HrefValue = "";
            $this->brand->TooltipValue = "";

            // tglkirim
            $this->tglkirim->LinkCustomAttributes = "";
            $this->tglkirim->HrefValue = "";
            $this->tglkirim->TooltipValue = "";

            // tgldisetujui
            $this->tgldisetujui->LinkCustomAttributes = "";
            $this->tgldisetujui->HrefValue = "";
            $this->tgldisetujui->TooltipValue = "";

            // desainprimer
            $this->desainprimer->LinkCustomAttributes = "";
            $this->desainprimer->HrefValue = "";
            $this->desainprimer->TooltipValue = "";

            // materialprimer
            $this->materialprimer->LinkCustomAttributes = "";
            $this->materialprimer->HrefValue = "";
            $this->materialprimer->TooltipValue = "";

            // aplikasiprimer
            $this->aplikasiprimer->LinkCustomAttributes = "";
            $this->aplikasiprimer->HrefValue = "";
            $this->aplikasiprimer->TooltipValue = "";

            // jumlahcetakprimer
            $this->jumlahcetakprimer->LinkCustomAttributes = "";
            $this->jumlahcetakprimer->HrefValue = "";
            $this->jumlahcetakprimer->TooltipValue = "";

            // desainsekunder
            $this->desainsekunder->LinkCustomAttributes = "";
            $this->desainsekunder->HrefValue = "";
            $this->desainsekunder->TooltipValue = "";

            // materialinnerbox
            $this->materialinnerbox->LinkCustomAttributes = "";
            $this->materialinnerbox->HrefValue = "";
            $this->materialinnerbox->TooltipValue = "";

            // aplikasiinnerbox
            $this->aplikasiinnerbox->LinkCustomAttributes = "";
            $this->aplikasiinnerbox->HrefValue = "";
            $this->aplikasiinnerbox->TooltipValue = "";

            // jumlahcetak
            $this->jumlahcetak->LinkCustomAttributes = "";
            $this->jumlahcetak->HrefValue = "";
            $this->jumlahcetak->TooltipValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";
            $this->checked_by->TooltipValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";
            $this->approved_by->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // brand
            $this->brand->EditAttrs["class"] = "form-control";
            $this->brand->EditCustomAttributes = "";
            if (!$this->brand->Raw) {
                $this->brand->CurrentValue = HtmlDecode($this->brand->CurrentValue);
            }
            $this->brand->EditValue = HtmlEncode($this->brand->CurrentValue);
            $this->brand->PlaceHolder = RemoveHtml($this->brand->caption());

            // tglkirim
            $this->tglkirim->EditAttrs["class"] = "form-control";
            $this->tglkirim->EditCustomAttributes = "";
            $this->tglkirim->EditValue = HtmlEncode(FormatDateTime($this->tglkirim->CurrentValue, 8));
            $this->tglkirim->PlaceHolder = RemoveHtml($this->tglkirim->caption());

            // tgldisetujui
            $this->tgldisetujui->EditAttrs["class"] = "form-control";
            $this->tgldisetujui->EditCustomAttributes = "";
            $this->tgldisetujui->EditValue = HtmlEncode(FormatDateTime($this->tgldisetujui->CurrentValue, 8));
            $this->tgldisetujui->PlaceHolder = RemoveHtml($this->tgldisetujui->caption());

            // desainprimer
            $this->desainprimer->EditAttrs["class"] = "form-control";
            $this->desainprimer->EditCustomAttributes = "";
            if (!$this->desainprimer->Raw) {
                $this->desainprimer->CurrentValue = HtmlDecode($this->desainprimer->CurrentValue);
            }
            $this->desainprimer->EditValue = HtmlEncode($this->desainprimer->CurrentValue);
            $this->desainprimer->PlaceHolder = RemoveHtml($this->desainprimer->caption());

            // materialprimer
            $this->materialprimer->EditAttrs["class"] = "form-control";
            $this->materialprimer->EditCustomAttributes = "";
            if (!$this->materialprimer->Raw) {
                $this->materialprimer->CurrentValue = HtmlDecode($this->materialprimer->CurrentValue);
            }
            $this->materialprimer->EditValue = HtmlEncode($this->materialprimer->CurrentValue);
            $this->materialprimer->PlaceHolder = RemoveHtml($this->materialprimer->caption());

            // aplikasiprimer
            $this->aplikasiprimer->EditAttrs["class"] = "form-control";
            $this->aplikasiprimer->EditCustomAttributes = "";
            if (!$this->aplikasiprimer->Raw) {
                $this->aplikasiprimer->CurrentValue = HtmlDecode($this->aplikasiprimer->CurrentValue);
            }
            $this->aplikasiprimer->EditValue = HtmlEncode($this->aplikasiprimer->CurrentValue);
            $this->aplikasiprimer->PlaceHolder = RemoveHtml($this->aplikasiprimer->caption());

            // jumlahcetakprimer
            $this->jumlahcetakprimer->EditAttrs["class"] = "form-control";
            $this->jumlahcetakprimer->EditCustomAttributes = "";
            $this->jumlahcetakprimer->EditValue = HtmlEncode($this->jumlahcetakprimer->CurrentValue);
            $this->jumlahcetakprimer->PlaceHolder = RemoveHtml($this->jumlahcetakprimer->caption());

            // desainsekunder
            $this->desainsekunder->EditAttrs["class"] = "form-control";
            $this->desainsekunder->EditCustomAttributes = "";
            if (!$this->desainsekunder->Raw) {
                $this->desainsekunder->CurrentValue = HtmlDecode($this->desainsekunder->CurrentValue);
            }
            $this->desainsekunder->EditValue = HtmlEncode($this->desainsekunder->CurrentValue);
            $this->desainsekunder->PlaceHolder = RemoveHtml($this->desainsekunder->caption());

            // materialinnerbox
            $this->materialinnerbox->EditAttrs["class"] = "form-control";
            $this->materialinnerbox->EditCustomAttributes = "";
            if (!$this->materialinnerbox->Raw) {
                $this->materialinnerbox->CurrentValue = HtmlDecode($this->materialinnerbox->CurrentValue);
            }
            $this->materialinnerbox->EditValue = HtmlEncode($this->materialinnerbox->CurrentValue);
            $this->materialinnerbox->PlaceHolder = RemoveHtml($this->materialinnerbox->caption());

            // aplikasiinnerbox
            $this->aplikasiinnerbox->EditAttrs["class"] = "form-control";
            $this->aplikasiinnerbox->EditCustomAttributes = "";
            if (!$this->aplikasiinnerbox->Raw) {
                $this->aplikasiinnerbox->CurrentValue = HtmlDecode($this->aplikasiinnerbox->CurrentValue);
            }
            $this->aplikasiinnerbox->EditValue = HtmlEncode($this->aplikasiinnerbox->CurrentValue);
            $this->aplikasiinnerbox->PlaceHolder = RemoveHtml($this->aplikasiinnerbox->caption());

            // jumlahcetak
            $this->jumlahcetak->EditAttrs["class"] = "form-control";
            $this->jumlahcetak->EditCustomAttributes = "";
            $this->jumlahcetak->EditValue = HtmlEncode($this->jumlahcetak->CurrentValue);
            $this->jumlahcetak->PlaceHolder = RemoveHtml($this->jumlahcetak->caption());

            // checked_by
            $this->checked_by->EditAttrs["class"] = "form-control";
            $this->checked_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->checked_by->CurrentValue));
            if ($curVal != "") {
                $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
            } else {
                $this->checked_by->ViewValue = $this->checked_by->Lookup !== null && is_array($this->checked_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->checked_by->ViewValue !== null) { // Load from cache
                $this->checked_by->EditValue = array_values($this->checked_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->checked_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->checked_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->checked_by->EditValue = $arwrk;
            }
            $this->checked_by->PlaceHolder = RemoveHtml($this->checked_by->caption());

            // approved_by
            $this->approved_by->EditAttrs["class"] = "form-control";
            $this->approved_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->approved_by->CurrentValue));
            if ($curVal != "") {
                $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
            } else {
                $this->approved_by->ViewValue = $this->approved_by->Lookup !== null && is_array($this->approved_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->approved_by->ViewValue !== null) { // Load from cache
                $this->approved_by->EditValue = array_values($this->approved_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->approved_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->approved_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->approved_by->EditValue = $arwrk;
            }
            $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Add refer script

            // brand
            $this->brand->LinkCustomAttributes = "";
            $this->brand->HrefValue = "";

            // tglkirim
            $this->tglkirim->LinkCustomAttributes = "";
            $this->tglkirim->HrefValue = "";

            // tgldisetujui
            $this->tgldisetujui->LinkCustomAttributes = "";
            $this->tgldisetujui->HrefValue = "";

            // desainprimer
            $this->desainprimer->LinkCustomAttributes = "";
            $this->desainprimer->HrefValue = "";

            // materialprimer
            $this->materialprimer->LinkCustomAttributes = "";
            $this->materialprimer->HrefValue = "";

            // aplikasiprimer
            $this->aplikasiprimer->LinkCustomAttributes = "";
            $this->aplikasiprimer->HrefValue = "";

            // jumlahcetakprimer
            $this->jumlahcetakprimer->LinkCustomAttributes = "";
            $this->jumlahcetakprimer->HrefValue = "";

            // desainsekunder
            $this->desainsekunder->LinkCustomAttributes = "";
            $this->desainsekunder->HrefValue = "";

            // materialinnerbox
            $this->materialinnerbox->LinkCustomAttributes = "";
            $this->materialinnerbox->HrefValue = "";

            // aplikasiinnerbox
            $this->aplikasiinnerbox->LinkCustomAttributes = "";
            $this->aplikasiinnerbox->HrefValue = "";

            // jumlahcetak
            $this->jumlahcetak->LinkCustomAttributes = "";
            $this->jumlahcetak->HrefValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
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
        if ($this->brand->Required) {
            if (!$this->brand->IsDetailKey && EmptyValue($this->brand->FormValue)) {
                $this->brand->addErrorMessage(str_replace("%s", $this->brand->caption(), $this->brand->RequiredErrorMessage));
            }
        }
        if ($this->tglkirim->Required) {
            if (!$this->tglkirim->IsDetailKey && EmptyValue($this->tglkirim->FormValue)) {
                $this->tglkirim->addErrorMessage(str_replace("%s", $this->tglkirim->caption(), $this->tglkirim->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglkirim->FormValue)) {
            $this->tglkirim->addErrorMessage($this->tglkirim->getErrorMessage(false));
        }
        if ($this->tgldisetujui->Required) {
            if (!$this->tgldisetujui->IsDetailKey && EmptyValue($this->tgldisetujui->FormValue)) {
                $this->tgldisetujui->addErrorMessage(str_replace("%s", $this->tgldisetujui->caption(), $this->tgldisetujui->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgldisetujui->FormValue)) {
            $this->tgldisetujui->addErrorMessage($this->tgldisetujui->getErrorMessage(false));
        }
        if ($this->desainprimer->Required) {
            if (!$this->desainprimer->IsDetailKey && EmptyValue($this->desainprimer->FormValue)) {
                $this->desainprimer->addErrorMessage(str_replace("%s", $this->desainprimer->caption(), $this->desainprimer->RequiredErrorMessage));
            }
        }
        if ($this->materialprimer->Required) {
            if (!$this->materialprimer->IsDetailKey && EmptyValue($this->materialprimer->FormValue)) {
                $this->materialprimer->addErrorMessage(str_replace("%s", $this->materialprimer->caption(), $this->materialprimer->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiprimer->Required) {
            if (!$this->aplikasiprimer->IsDetailKey && EmptyValue($this->aplikasiprimer->FormValue)) {
                $this->aplikasiprimer->addErrorMessage(str_replace("%s", $this->aplikasiprimer->caption(), $this->aplikasiprimer->RequiredErrorMessage));
            }
        }
        if ($this->jumlahcetakprimer->Required) {
            if (!$this->jumlahcetakprimer->IsDetailKey && EmptyValue($this->jumlahcetakprimer->FormValue)) {
                $this->jumlahcetakprimer->addErrorMessage(str_replace("%s", $this->jumlahcetakprimer->caption(), $this->jumlahcetakprimer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahcetakprimer->FormValue)) {
            $this->jumlahcetakprimer->addErrorMessage($this->jumlahcetakprimer->getErrorMessage(false));
        }
        if ($this->desainsekunder->Required) {
            if (!$this->desainsekunder->IsDetailKey && EmptyValue($this->desainsekunder->FormValue)) {
                $this->desainsekunder->addErrorMessage(str_replace("%s", $this->desainsekunder->caption(), $this->desainsekunder->RequiredErrorMessage));
            }
        }
        if ($this->materialinnerbox->Required) {
            if (!$this->materialinnerbox->IsDetailKey && EmptyValue($this->materialinnerbox->FormValue)) {
                $this->materialinnerbox->addErrorMessage(str_replace("%s", $this->materialinnerbox->caption(), $this->materialinnerbox->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiinnerbox->Required) {
            if (!$this->aplikasiinnerbox->IsDetailKey && EmptyValue($this->aplikasiinnerbox->FormValue)) {
                $this->aplikasiinnerbox->addErrorMessage(str_replace("%s", $this->aplikasiinnerbox->caption(), $this->aplikasiinnerbox->RequiredErrorMessage));
            }
        }
        if ($this->jumlahcetak->Required) {
            if (!$this->jumlahcetak->IsDetailKey && EmptyValue($this->jumlahcetak->FormValue)) {
                $this->jumlahcetak->addErrorMessage(str_replace("%s", $this->jumlahcetak->caption(), $this->jumlahcetak->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahcetak->FormValue)) {
            $this->jumlahcetak->addErrorMessage($this->jumlahcetak->getErrorMessage(false));
        }
        if ($this->checked_by->Required) {
            if (!$this->checked_by->IsDetailKey && EmptyValue($this->checked_by->FormValue)) {
                $this->checked_by->addErrorMessage(str_replace("%s", $this->checked_by->caption(), $this->checked_by->RequiredErrorMessage));
            }
        }
        if ($this->approved_by->Required) {
            if (!$this->approved_by->IsDetailKey && EmptyValue($this->approved_by->FormValue)) {
                $this->approved_by->addErrorMessage(str_replace("%s", $this->approved_by->caption(), $this->approved_by->RequiredErrorMessage));
            }
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->updated_at->FormValue)) {
            $this->updated_at->addErrorMessage($this->updated_at->getErrorMessage(false));
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

        // brand
        $this->brand->setDbValueDef($rsnew, $this->brand->CurrentValue, "", false);

        // tglkirim
        $this->tglkirim->setDbValueDef($rsnew, UnFormatDateTime($this->tglkirim->CurrentValue, 0), null, false);

        // tgldisetujui
        $this->tgldisetujui->setDbValueDef($rsnew, UnFormatDateTime($this->tgldisetujui->CurrentValue, 0), null, false);

        // desainprimer
        $this->desainprimer->setDbValueDef($rsnew, $this->desainprimer->CurrentValue, null, false);

        // materialprimer
        $this->materialprimer->setDbValueDef($rsnew, $this->materialprimer->CurrentValue, null, false);

        // aplikasiprimer
        $this->aplikasiprimer->setDbValueDef($rsnew, $this->aplikasiprimer->CurrentValue, null, false);

        // jumlahcetakprimer
        $this->jumlahcetakprimer->setDbValueDef($rsnew, $this->jumlahcetakprimer->CurrentValue, null, false);

        // desainsekunder
        $this->desainsekunder->setDbValueDef($rsnew, $this->desainsekunder->CurrentValue, null, false);

        // materialinnerbox
        $this->materialinnerbox->setDbValueDef($rsnew, $this->materialinnerbox->CurrentValue, null, false);

        // aplikasiinnerbox
        $this->aplikasiinnerbox->setDbValueDef($rsnew, $this->aplikasiinnerbox->CurrentValue, null, false);

        // jumlahcetak
        $this->jumlahcetak->setDbValueDef($rsnew, $this->jumlahcetak->CurrentValue, null, false);

        // checked_by
        $this->checked_by->setDbValueDef($rsnew, $this->checked_by->CurrentValue, null, false);

        // approved_by
        $this->approved_by->setDbValueDef($rsnew, $this->approved_by->CurrentValue, null, false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, false);

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdConfirmprintList"), "", $this->TableVar, true);
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
                case "x_checked_by":
                    break;
                case "x_approved_by":
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