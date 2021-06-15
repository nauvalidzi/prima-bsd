<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdReviewAdd extends NpdReview
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_review';

    // Page object name
    public $PageObjName = "NpdReviewAdd";

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

        // Table object (npd_review)
        if (!isset($GLOBALS["npd_review"]) || get_class($GLOBALS["npd_review"]) == PROJECT_NAMESPACE . "npd_review") {
            $GLOBALS["npd_review"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_review');
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
                $doc = new $class(Container("npd_review"));
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
                    if ($pageName == "NpdReviewView") {
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
        $this->idnpd->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->tglreview->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->wadah->setVisibility();
        $this->bentukok->setVisibility();
        $this->bentukrevisi->setVisibility();
        $this->viskositasok->setVisibility();
        $this->viskositasrevisi->setVisibility();
        $this->jeniswarnaok->setVisibility();
        $this->jeniswarnarevisi->setVisibility();
        $this->tonewarnaok->setVisibility();
        $this->tonewarnarevisi->setVisibility();
        $this->gradasiwarnaok->setVisibility();
        $this->gradasiwarnarevisi->setVisibility();
        $this->bauok->setVisibility();
        $this->baurevisi->setVisibility();
        $this->estetikaok->setVisibility();
        $this->estetikarevisi->setVisibility();
        $this->aplikasiawalok->setVisibility();
        $this->aplikasiawalrevisi->setVisibility();
        $this->aplikasilamaok->setVisibility();
        $this->aplikasilamarevisi->setVisibility();
        $this->efekpositifok->setVisibility();
        $this->efekpositifrevisi->setVisibility();
        $this->efeknegatifok->setVisibility();
        $this->efeknegatifrevisi->setVisibility();
        $this->kesimpulan->setVisibility();
        $this->status->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->setVisibility();
        $this->readonly->Visible = false;
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
        $this->setupLookupOptions($this->idnpd);
        $this->setupLookupOptions($this->idnpd_sample);

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

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

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
                    $this->terminate("NpdReviewList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "NpdReviewList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdReviewView") {
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
        $this->idnpd->CurrentValue = null;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->idnpd_sample->CurrentValue = null;
        $this->idnpd_sample->OldValue = $this->idnpd_sample->CurrentValue;
        $this->tglreview->CurrentValue = null;
        $this->tglreview->OldValue = $this->tglreview->CurrentValue;
        $this->tglsubmit->CurrentValue = null;
        $this->tglsubmit->OldValue = $this->tglsubmit->CurrentValue;
        $this->wadah->CurrentValue = null;
        $this->wadah->OldValue = $this->wadah->CurrentValue;
        $this->bentukok->CurrentValue = 1;
        $this->bentukrevisi->CurrentValue = null;
        $this->bentukrevisi->OldValue = $this->bentukrevisi->CurrentValue;
        $this->viskositasok->CurrentValue = 1;
        $this->viskositasrevisi->CurrentValue = null;
        $this->viskositasrevisi->OldValue = $this->viskositasrevisi->CurrentValue;
        $this->jeniswarnaok->CurrentValue = 1;
        $this->jeniswarnarevisi->CurrentValue = null;
        $this->jeniswarnarevisi->OldValue = $this->jeniswarnarevisi->CurrentValue;
        $this->tonewarnaok->CurrentValue = 1;
        $this->tonewarnarevisi->CurrentValue = null;
        $this->tonewarnarevisi->OldValue = $this->tonewarnarevisi->CurrentValue;
        $this->gradasiwarnaok->CurrentValue = 1;
        $this->gradasiwarnarevisi->CurrentValue = null;
        $this->gradasiwarnarevisi->OldValue = $this->gradasiwarnarevisi->CurrentValue;
        $this->bauok->CurrentValue = 1;
        $this->baurevisi->CurrentValue = null;
        $this->baurevisi->OldValue = $this->baurevisi->CurrentValue;
        $this->estetikaok->CurrentValue = 1;
        $this->estetikarevisi->CurrentValue = null;
        $this->estetikarevisi->OldValue = $this->estetikarevisi->CurrentValue;
        $this->aplikasiawalok->CurrentValue = 1;
        $this->aplikasiawalrevisi->CurrentValue = null;
        $this->aplikasiawalrevisi->OldValue = $this->aplikasiawalrevisi->CurrentValue;
        $this->aplikasilamaok->CurrentValue = 1;
        $this->aplikasilamarevisi->CurrentValue = null;
        $this->aplikasilamarevisi->OldValue = $this->aplikasilamarevisi->CurrentValue;
        $this->efekpositifok->CurrentValue = 1;
        $this->efekpositifrevisi->CurrentValue = null;
        $this->efekpositifrevisi->OldValue = $this->efekpositifrevisi->CurrentValue;
        $this->efeknegatifok->CurrentValue = 1;
        $this->efeknegatifrevisi->CurrentValue = null;
        $this->efeknegatifrevisi->OldValue = $this->efeknegatifrevisi->CurrentValue;
        $this->kesimpulan->CurrentValue = null;
        $this->kesimpulan->OldValue = $this->kesimpulan->CurrentValue;
        $this->status->CurrentValue = 1;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
        $this->readonly->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
            }
        }

        // Check field name 'idnpd_sample' first before field var 'x_idnpd_sample'
        $val = $CurrentForm->hasValue("idnpd_sample") ? $CurrentForm->getValue("idnpd_sample") : $CurrentForm->getValue("x_idnpd_sample");
        if (!$this->idnpd_sample->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd_sample->Visible = false; // Disable update for API request
            } else {
                $this->idnpd_sample->setFormValue($val);
            }
        }

        // Check field name 'tglreview' first before field var 'x_tglreview'
        $val = $CurrentForm->hasValue("tglreview") ? $CurrentForm->getValue("tglreview") : $CurrentForm->getValue("x_tglreview");
        if (!$this->tglreview->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglreview->Visible = false; // Disable update for API request
            } else {
                $this->tglreview->setFormValue($val);
            }
            $this->tglreview->CurrentValue = UnFormatDateTime($this->tglreview->CurrentValue, 0);
        }

        // Check field name 'tglsubmit' first before field var 'x_tglsubmit'
        $val = $CurrentForm->hasValue("tglsubmit") ? $CurrentForm->getValue("tglsubmit") : $CurrentForm->getValue("x_tglsubmit");
        if (!$this->tglsubmit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglsubmit->Visible = false; // Disable update for API request
            } else {
                $this->tglsubmit->setFormValue($val);
            }
            $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        }

        // Check field name 'wadah' first before field var 'x_wadah'
        $val = $CurrentForm->hasValue("wadah") ? $CurrentForm->getValue("wadah") : $CurrentForm->getValue("x_wadah");
        if (!$this->wadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->wadah->Visible = false; // Disable update for API request
            } else {
                $this->wadah->setFormValue($val);
            }
        }

        // Check field name 'bentukok' first before field var 'x_bentukok'
        $val = $CurrentForm->hasValue("bentukok") ? $CurrentForm->getValue("bentukok") : $CurrentForm->getValue("x_bentukok");
        if (!$this->bentukok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentukok->Visible = false; // Disable update for API request
            } else {
                $this->bentukok->setFormValue($val);
            }
        }

        // Check field name 'bentukrevisi' first before field var 'x_bentukrevisi'
        $val = $CurrentForm->hasValue("bentukrevisi") ? $CurrentForm->getValue("bentukrevisi") : $CurrentForm->getValue("x_bentukrevisi");
        if (!$this->bentukrevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentukrevisi->Visible = false; // Disable update for API request
            } else {
                $this->bentukrevisi->setFormValue($val);
            }
        }

        // Check field name 'viskositasok' first before field var 'x_viskositasok'
        $val = $CurrentForm->hasValue("viskositasok") ? $CurrentForm->getValue("viskositasok") : $CurrentForm->getValue("x_viskositasok");
        if (!$this->viskositasok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositasok->Visible = false; // Disable update for API request
            } else {
                $this->viskositasok->setFormValue($val);
            }
        }

        // Check field name 'viskositasrevisi' first before field var 'x_viskositasrevisi'
        $val = $CurrentForm->hasValue("viskositasrevisi") ? $CurrentForm->getValue("viskositasrevisi") : $CurrentForm->getValue("x_viskositasrevisi");
        if (!$this->viskositasrevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositasrevisi->Visible = false; // Disable update for API request
            } else {
                $this->viskositasrevisi->setFormValue($val);
            }
        }

        // Check field name 'jeniswarnaok' first before field var 'x_jeniswarnaok'
        $val = $CurrentForm->hasValue("jeniswarnaok") ? $CurrentForm->getValue("jeniswarnaok") : $CurrentForm->getValue("x_jeniswarnaok");
        if (!$this->jeniswarnaok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jeniswarnaok->Visible = false; // Disable update for API request
            } else {
                $this->jeniswarnaok->setFormValue($val);
            }
        }

        // Check field name 'jeniswarnarevisi' first before field var 'x_jeniswarnarevisi'
        $val = $CurrentForm->hasValue("jeniswarnarevisi") ? $CurrentForm->getValue("jeniswarnarevisi") : $CurrentForm->getValue("x_jeniswarnarevisi");
        if (!$this->jeniswarnarevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jeniswarnarevisi->Visible = false; // Disable update for API request
            } else {
                $this->jeniswarnarevisi->setFormValue($val);
            }
        }

        // Check field name 'tonewarnaok' first before field var 'x_tonewarnaok'
        $val = $CurrentForm->hasValue("tonewarnaok") ? $CurrentForm->getValue("tonewarnaok") : $CurrentForm->getValue("x_tonewarnaok");
        if (!$this->tonewarnaok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tonewarnaok->Visible = false; // Disable update for API request
            } else {
                $this->tonewarnaok->setFormValue($val);
            }
        }

        // Check field name 'tonewarnarevisi' first before field var 'x_tonewarnarevisi'
        $val = $CurrentForm->hasValue("tonewarnarevisi") ? $CurrentForm->getValue("tonewarnarevisi") : $CurrentForm->getValue("x_tonewarnarevisi");
        if (!$this->tonewarnarevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tonewarnarevisi->Visible = false; // Disable update for API request
            } else {
                $this->tonewarnarevisi->setFormValue($val);
            }
        }

        // Check field name 'gradasiwarnaok' first before field var 'x_gradasiwarnaok'
        $val = $CurrentForm->hasValue("gradasiwarnaok") ? $CurrentForm->getValue("gradasiwarnaok") : $CurrentForm->getValue("x_gradasiwarnaok");
        if (!$this->gradasiwarnaok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gradasiwarnaok->Visible = false; // Disable update for API request
            } else {
                $this->gradasiwarnaok->setFormValue($val);
            }
        }

        // Check field name 'gradasiwarnarevisi' first before field var 'x_gradasiwarnarevisi'
        $val = $CurrentForm->hasValue("gradasiwarnarevisi") ? $CurrentForm->getValue("gradasiwarnarevisi") : $CurrentForm->getValue("x_gradasiwarnarevisi");
        if (!$this->gradasiwarnarevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gradasiwarnarevisi->Visible = false; // Disable update for API request
            } else {
                $this->gradasiwarnarevisi->setFormValue($val);
            }
        }

        // Check field name 'bauok' first before field var 'x_bauok'
        $val = $CurrentForm->hasValue("bauok") ? $CurrentForm->getValue("bauok") : $CurrentForm->getValue("x_bauok");
        if (!$this->bauok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bauok->Visible = false; // Disable update for API request
            } else {
                $this->bauok->setFormValue($val);
            }
        }

        // Check field name 'baurevisi' first before field var 'x_baurevisi'
        $val = $CurrentForm->hasValue("baurevisi") ? $CurrentForm->getValue("baurevisi") : $CurrentForm->getValue("x_baurevisi");
        if (!$this->baurevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->baurevisi->Visible = false; // Disable update for API request
            } else {
                $this->baurevisi->setFormValue($val);
            }
        }

        // Check field name 'estetikaok' first before field var 'x_estetikaok'
        $val = $CurrentForm->hasValue("estetikaok") ? $CurrentForm->getValue("estetikaok") : $CurrentForm->getValue("x_estetikaok");
        if (!$this->estetikaok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetikaok->Visible = false; // Disable update for API request
            } else {
                $this->estetikaok->setFormValue($val);
            }
        }

        // Check field name 'estetikarevisi' first before field var 'x_estetikarevisi'
        $val = $CurrentForm->hasValue("estetikarevisi") ? $CurrentForm->getValue("estetikarevisi") : $CurrentForm->getValue("x_estetikarevisi");
        if (!$this->estetikarevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetikarevisi->Visible = false; // Disable update for API request
            } else {
                $this->estetikarevisi->setFormValue($val);
            }
        }

        // Check field name 'aplikasiawalok' first before field var 'x_aplikasiawalok'
        $val = $CurrentForm->hasValue("aplikasiawalok") ? $CurrentForm->getValue("aplikasiawalok") : $CurrentForm->getValue("x_aplikasiawalok");
        if (!$this->aplikasiawalok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiawalok->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiawalok->setFormValue($val);
            }
        }

        // Check field name 'aplikasiawalrevisi' first before field var 'x_aplikasiawalrevisi'
        $val = $CurrentForm->hasValue("aplikasiawalrevisi") ? $CurrentForm->getValue("aplikasiawalrevisi") : $CurrentForm->getValue("x_aplikasiawalrevisi");
        if (!$this->aplikasiawalrevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiawalrevisi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiawalrevisi->setFormValue($val);
            }
        }

        // Check field name 'aplikasilamaok' first before field var 'x_aplikasilamaok'
        $val = $CurrentForm->hasValue("aplikasilamaok") ? $CurrentForm->getValue("aplikasilamaok") : $CurrentForm->getValue("x_aplikasilamaok");
        if (!$this->aplikasilamaok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasilamaok->Visible = false; // Disable update for API request
            } else {
                $this->aplikasilamaok->setFormValue($val);
            }
        }

        // Check field name 'aplikasilamarevisi' first before field var 'x_aplikasilamarevisi'
        $val = $CurrentForm->hasValue("aplikasilamarevisi") ? $CurrentForm->getValue("aplikasilamarevisi") : $CurrentForm->getValue("x_aplikasilamarevisi");
        if (!$this->aplikasilamarevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasilamarevisi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasilamarevisi->setFormValue($val);
            }
        }

        // Check field name 'efekpositifok' first before field var 'x_efekpositifok'
        $val = $CurrentForm->hasValue("efekpositifok") ? $CurrentForm->getValue("efekpositifok") : $CurrentForm->getValue("x_efekpositifok");
        if (!$this->efekpositifok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efekpositifok->Visible = false; // Disable update for API request
            } else {
                $this->efekpositifok->setFormValue($val);
            }
        }

        // Check field name 'efekpositifrevisi' first before field var 'x_efekpositifrevisi'
        $val = $CurrentForm->hasValue("efekpositifrevisi") ? $CurrentForm->getValue("efekpositifrevisi") : $CurrentForm->getValue("x_efekpositifrevisi");
        if (!$this->efekpositifrevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efekpositifrevisi->Visible = false; // Disable update for API request
            } else {
                $this->efekpositifrevisi->setFormValue($val);
            }
        }

        // Check field name 'efeknegatifok' first before field var 'x_efeknegatifok'
        $val = $CurrentForm->hasValue("efeknegatifok") ? $CurrentForm->getValue("efeknegatifok") : $CurrentForm->getValue("x_efeknegatifok");
        if (!$this->efeknegatifok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efeknegatifok->Visible = false; // Disable update for API request
            } else {
                $this->efeknegatifok->setFormValue($val);
            }
        }

        // Check field name 'efeknegatifrevisi' first before field var 'x_efeknegatifrevisi'
        $val = $CurrentForm->hasValue("efeknegatifrevisi") ? $CurrentForm->getValue("efeknegatifrevisi") : $CurrentForm->getValue("x_efeknegatifrevisi");
        if (!$this->efeknegatifrevisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efeknegatifrevisi->Visible = false; // Disable update for API request
            } else {
                $this->efeknegatifrevisi->setFormValue($val);
            }
        }

        // Check field name 'kesimpulan' first before field var 'x_kesimpulan'
        $val = $CurrentForm->hasValue("kesimpulan") ? $CurrentForm->getValue("kesimpulan") : $CurrentForm->getValue("x_kesimpulan");
        if (!$this->kesimpulan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kesimpulan->Visible = false; // Disable update for API request
            } else {
                $this->kesimpulan->setFormValue($val);
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

        // Check field name 'created_by' first before field var 'x_created_by'
        $val = $CurrentForm->hasValue("created_by") ? $CurrentForm->getValue("created_by") : $CurrentForm->getValue("x_created_by");
        if (!$this->created_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_by->Visible = false; // Disable update for API request
            } else {
                $this->created_by->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->idnpd_sample->CurrentValue = $this->idnpd_sample->FormValue;
        $this->tglreview->CurrentValue = $this->tglreview->FormValue;
        $this->tglreview->CurrentValue = UnFormatDateTime($this->tglreview->CurrentValue, 0);
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->wadah->CurrentValue = $this->wadah->FormValue;
        $this->bentukok->CurrentValue = $this->bentukok->FormValue;
        $this->bentukrevisi->CurrentValue = $this->bentukrevisi->FormValue;
        $this->viskositasok->CurrentValue = $this->viskositasok->FormValue;
        $this->viskositasrevisi->CurrentValue = $this->viskositasrevisi->FormValue;
        $this->jeniswarnaok->CurrentValue = $this->jeniswarnaok->FormValue;
        $this->jeniswarnarevisi->CurrentValue = $this->jeniswarnarevisi->FormValue;
        $this->tonewarnaok->CurrentValue = $this->tonewarnaok->FormValue;
        $this->tonewarnarevisi->CurrentValue = $this->tonewarnarevisi->FormValue;
        $this->gradasiwarnaok->CurrentValue = $this->gradasiwarnaok->FormValue;
        $this->gradasiwarnarevisi->CurrentValue = $this->gradasiwarnarevisi->FormValue;
        $this->bauok->CurrentValue = $this->bauok->FormValue;
        $this->baurevisi->CurrentValue = $this->baurevisi->FormValue;
        $this->estetikaok->CurrentValue = $this->estetikaok->FormValue;
        $this->estetikarevisi->CurrentValue = $this->estetikarevisi->FormValue;
        $this->aplikasiawalok->CurrentValue = $this->aplikasiawalok->FormValue;
        $this->aplikasiawalrevisi->CurrentValue = $this->aplikasiawalrevisi->FormValue;
        $this->aplikasilamaok->CurrentValue = $this->aplikasilamaok->FormValue;
        $this->aplikasilamarevisi->CurrentValue = $this->aplikasilamarevisi->FormValue;
        $this->efekpositifok->CurrentValue = $this->efekpositifok->FormValue;
        $this->efekpositifrevisi->CurrentValue = $this->efekpositifrevisi->FormValue;
        $this->efeknegatifok->CurrentValue = $this->efeknegatifok->FormValue;
        $this->efeknegatifrevisi->CurrentValue = $this->efeknegatifrevisi->FormValue;
        $this->kesimpulan->CurrentValue = $this->kesimpulan->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->created_by->CurrentValue = $this->created_by->FormValue;
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->tglreview->setDbValue($row['tglreview']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->wadah->setDbValue($row['wadah']);
        $this->bentukok->setDbValue($row['bentukok']);
        $this->bentukrevisi->setDbValue($row['bentukrevisi']);
        $this->viskositasok->setDbValue($row['viskositasok']);
        $this->viskositasrevisi->setDbValue($row['viskositasrevisi']);
        $this->jeniswarnaok->setDbValue($row['jeniswarnaok']);
        $this->jeniswarnarevisi->setDbValue($row['jeniswarnarevisi']);
        $this->tonewarnaok->setDbValue($row['tonewarnaok']);
        $this->tonewarnarevisi->setDbValue($row['tonewarnarevisi']);
        $this->gradasiwarnaok->setDbValue($row['gradasiwarnaok']);
        $this->gradasiwarnarevisi->setDbValue($row['gradasiwarnarevisi']);
        $this->bauok->setDbValue($row['bauok']);
        $this->baurevisi->setDbValue($row['baurevisi']);
        $this->estetikaok->setDbValue($row['estetikaok']);
        $this->estetikarevisi->setDbValue($row['estetikarevisi']);
        $this->aplikasiawalok->setDbValue($row['aplikasiawalok']);
        $this->aplikasiawalrevisi->setDbValue($row['aplikasiawalrevisi']);
        $this->aplikasilamaok->setDbValue($row['aplikasilamaok']);
        $this->aplikasilamarevisi->setDbValue($row['aplikasilamarevisi']);
        $this->efekpositifok->setDbValue($row['efekpositifok']);
        $this->efekpositifrevisi->setDbValue($row['efekpositifrevisi']);
        $this->efeknegatifok->setDbValue($row['efeknegatifok']);
        $this->efeknegatifrevisi->setDbValue($row['efeknegatifrevisi']);
        $this->kesimpulan->setDbValue($row['kesimpulan']);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['idnpd_sample'] = $this->idnpd_sample->CurrentValue;
        $row['tglreview'] = $this->tglreview->CurrentValue;
        $row['tglsubmit'] = $this->tglsubmit->CurrentValue;
        $row['wadah'] = $this->wadah->CurrentValue;
        $row['bentukok'] = $this->bentukok->CurrentValue;
        $row['bentukrevisi'] = $this->bentukrevisi->CurrentValue;
        $row['viskositasok'] = $this->viskositasok->CurrentValue;
        $row['viskositasrevisi'] = $this->viskositasrevisi->CurrentValue;
        $row['jeniswarnaok'] = $this->jeniswarnaok->CurrentValue;
        $row['jeniswarnarevisi'] = $this->jeniswarnarevisi->CurrentValue;
        $row['tonewarnaok'] = $this->tonewarnaok->CurrentValue;
        $row['tonewarnarevisi'] = $this->tonewarnarevisi->CurrentValue;
        $row['gradasiwarnaok'] = $this->gradasiwarnaok->CurrentValue;
        $row['gradasiwarnarevisi'] = $this->gradasiwarnarevisi->CurrentValue;
        $row['bauok'] = $this->bauok->CurrentValue;
        $row['baurevisi'] = $this->baurevisi->CurrentValue;
        $row['estetikaok'] = $this->estetikaok->CurrentValue;
        $row['estetikarevisi'] = $this->estetikarevisi->CurrentValue;
        $row['aplikasiawalok'] = $this->aplikasiawalok->CurrentValue;
        $row['aplikasiawalrevisi'] = $this->aplikasiawalrevisi->CurrentValue;
        $row['aplikasilamaok'] = $this->aplikasilamaok->CurrentValue;
        $row['aplikasilamarevisi'] = $this->aplikasilamarevisi->CurrentValue;
        $row['efekpositifok'] = $this->efekpositifok->CurrentValue;
        $row['efekpositifrevisi'] = $this->efekpositifrevisi->CurrentValue;
        $row['efeknegatifok'] = $this->efeknegatifok->CurrentValue;
        $row['efeknegatifrevisi'] = $this->efeknegatifrevisi->CurrentValue;
        $row['kesimpulan'] = $this->kesimpulan->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
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

        // idnpd

        // idnpd_sample

        // tglreview

        // tglsubmit

        // wadah

        // bentukok

        // bentukrevisi

        // viskositasok

        // viskositasrevisi

        // jeniswarnaok

        // jeniswarnarevisi

        // tonewarnaok

        // tonewarnarevisi

        // gradasiwarnaok

        // gradasiwarnarevisi

        // bauok

        // baurevisi

        // estetikaok

        // estetikarevisi

        // aplikasiawalok

        // aplikasiawalrevisi

        // aplikasilamaok

        // aplikasilamarevisi

        // efekpositifok

        // efekpositifrevisi

        // efeknegatifok

        // efeknegatifrevisi

        // kesimpulan

        // status

        // created_at

        // created_by

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $curVal = trim(strval($this->idnpd->CurrentValue));
            if ($curVal != "") {
                $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                if ($this->idnpd->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                    } else {
                        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                    }
                }
            } else {
                $this->idnpd->ViewValue = null;
            }
            $this->idnpd->ViewCustomAttributes = "";

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "`status`=0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->displayValue($arwrk);
                    } else {
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->CurrentValue;
                    }
                }
            } else {
                $this->idnpd_sample->ViewValue = null;
            }
            $this->idnpd_sample->ViewCustomAttributes = "";

            // tglreview
            $this->tglreview->ViewValue = $this->tglreview->CurrentValue;
            $this->tglreview->ViewValue = FormatDateTime($this->tglreview->ViewValue, 0);
            $this->tglreview->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // wadah
            $this->wadah->ViewValue = $this->wadah->CurrentValue;
            $this->wadah->ViewCustomAttributes = "";

            // bentukok
            if (strval($this->bentukok->CurrentValue) != "") {
                $this->bentukok->ViewValue = $this->bentukok->optionCaption($this->bentukok->CurrentValue);
            } else {
                $this->bentukok->ViewValue = null;
            }
            $this->bentukok->ViewCustomAttributes = "";

            // bentukrevisi
            $this->bentukrevisi->ViewValue = $this->bentukrevisi->CurrentValue;
            $this->bentukrevisi->ViewCustomAttributes = "";

            // viskositasok
            if (strval($this->viskositasok->CurrentValue) != "") {
                $this->viskositasok->ViewValue = $this->viskositasok->optionCaption($this->viskositasok->CurrentValue);
            } else {
                $this->viskositasok->ViewValue = null;
            }
            $this->viskositasok->ViewCustomAttributes = "";

            // viskositasrevisi
            $this->viskositasrevisi->ViewValue = $this->viskositasrevisi->CurrentValue;
            $this->viskositasrevisi->ViewCustomAttributes = "";

            // jeniswarnaok
            if (strval($this->jeniswarnaok->CurrentValue) != "") {
                $this->jeniswarnaok->ViewValue = $this->jeniswarnaok->optionCaption($this->jeniswarnaok->CurrentValue);
            } else {
                $this->jeniswarnaok->ViewValue = null;
            }
            $this->jeniswarnaok->ViewCustomAttributes = "";

            // jeniswarnarevisi
            $this->jeniswarnarevisi->ViewValue = $this->jeniswarnarevisi->CurrentValue;
            $this->jeniswarnarevisi->ViewCustomAttributes = "";

            // tonewarnaok
            if (strval($this->tonewarnaok->CurrentValue) != "") {
                $this->tonewarnaok->ViewValue = $this->tonewarnaok->optionCaption($this->tonewarnaok->CurrentValue);
            } else {
                $this->tonewarnaok->ViewValue = null;
            }
            $this->tonewarnaok->ViewCustomAttributes = "";

            // tonewarnarevisi
            $this->tonewarnarevisi->ViewValue = $this->tonewarnarevisi->CurrentValue;
            $this->tonewarnarevisi->ViewCustomAttributes = "";

            // gradasiwarnaok
            if (strval($this->gradasiwarnaok->CurrentValue) != "") {
                $this->gradasiwarnaok->ViewValue = $this->gradasiwarnaok->optionCaption($this->gradasiwarnaok->CurrentValue);
            } else {
                $this->gradasiwarnaok->ViewValue = null;
            }
            $this->gradasiwarnaok->ViewCustomAttributes = "";

            // gradasiwarnarevisi
            $this->gradasiwarnarevisi->ViewValue = $this->gradasiwarnarevisi->CurrentValue;
            $this->gradasiwarnarevisi->ViewCustomAttributes = "";

            // bauok
            if (strval($this->bauok->CurrentValue) != "") {
                $this->bauok->ViewValue = $this->bauok->optionCaption($this->bauok->CurrentValue);
            } else {
                $this->bauok->ViewValue = null;
            }
            $this->bauok->ViewCustomAttributes = "";

            // baurevisi
            $this->baurevisi->ViewValue = $this->baurevisi->CurrentValue;
            $this->baurevisi->ViewCustomAttributes = "";

            // estetikaok
            if (strval($this->estetikaok->CurrentValue) != "") {
                $this->estetikaok->ViewValue = $this->estetikaok->optionCaption($this->estetikaok->CurrentValue);
            } else {
                $this->estetikaok->ViewValue = null;
            }
            $this->estetikaok->ViewCustomAttributes = "";

            // estetikarevisi
            $this->estetikarevisi->ViewValue = $this->estetikarevisi->CurrentValue;
            $this->estetikarevisi->ViewCustomAttributes = "";

            // aplikasiawalok
            if (strval($this->aplikasiawalok->CurrentValue) != "") {
                $this->aplikasiawalok->ViewValue = $this->aplikasiawalok->optionCaption($this->aplikasiawalok->CurrentValue);
            } else {
                $this->aplikasiawalok->ViewValue = null;
            }
            $this->aplikasiawalok->ViewCustomAttributes = "";

            // aplikasiawalrevisi
            $this->aplikasiawalrevisi->ViewValue = $this->aplikasiawalrevisi->CurrentValue;
            $this->aplikasiawalrevisi->ViewCustomAttributes = "";

            // aplikasilamaok
            if (strval($this->aplikasilamaok->CurrentValue) != "") {
                $this->aplikasilamaok->ViewValue = $this->aplikasilamaok->optionCaption($this->aplikasilamaok->CurrentValue);
            } else {
                $this->aplikasilamaok->ViewValue = null;
            }
            $this->aplikasilamaok->ViewCustomAttributes = "";

            // aplikasilamarevisi
            $this->aplikasilamarevisi->ViewValue = $this->aplikasilamarevisi->CurrentValue;
            $this->aplikasilamarevisi->ViewCustomAttributes = "";

            // efekpositifok
            if (strval($this->efekpositifok->CurrentValue) != "") {
                $this->efekpositifok->ViewValue = $this->efekpositifok->optionCaption($this->efekpositifok->CurrentValue);
            } else {
                $this->efekpositifok->ViewValue = null;
            }
            $this->efekpositifok->ViewCustomAttributes = "";

            // efekpositifrevisi
            $this->efekpositifrevisi->ViewValue = $this->efekpositifrevisi->CurrentValue;
            $this->efekpositifrevisi->ViewCustomAttributes = "";

            // efeknegatifok
            if (strval($this->efeknegatifok->CurrentValue) != "") {
                $this->efeknegatifok->ViewValue = $this->efeknegatifok->optionCaption($this->efeknegatifok->CurrentValue);
            } else {
                $this->efeknegatifok->ViewValue = null;
            }
            $this->efeknegatifok->ViewCustomAttributes = "";

            // efeknegatifrevisi
            $this->efeknegatifrevisi->ViewValue = $this->efeknegatifrevisi->CurrentValue;
            $this->efeknegatifrevisi->ViewCustomAttributes = "";

            // kesimpulan
            $this->kesimpulan->ViewValue = $this->kesimpulan->CurrentValue;
            $this->kesimpulan->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // tglreview
            $this->tglreview->LinkCustomAttributes = "";
            $this->tglreview->HrefValue = "";
            $this->tglreview->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // wadah
            $this->wadah->LinkCustomAttributes = "";
            $this->wadah->HrefValue = "";
            $this->wadah->TooltipValue = "";

            // bentukok
            $this->bentukok->LinkCustomAttributes = "";
            $this->bentukok->HrefValue = "";
            $this->bentukok->TooltipValue = "";

            // bentukrevisi
            $this->bentukrevisi->LinkCustomAttributes = "";
            $this->bentukrevisi->HrefValue = "";
            $this->bentukrevisi->TooltipValue = "";

            // viskositasok
            $this->viskositasok->LinkCustomAttributes = "";
            $this->viskositasok->HrefValue = "";
            $this->viskositasok->TooltipValue = "";

            // viskositasrevisi
            $this->viskositasrevisi->LinkCustomAttributes = "";
            $this->viskositasrevisi->HrefValue = "";
            $this->viskositasrevisi->TooltipValue = "";

            // jeniswarnaok
            $this->jeniswarnaok->LinkCustomAttributes = "";
            $this->jeniswarnaok->HrefValue = "";
            $this->jeniswarnaok->TooltipValue = "";

            // jeniswarnarevisi
            $this->jeniswarnarevisi->LinkCustomAttributes = "";
            $this->jeniswarnarevisi->HrefValue = "";
            $this->jeniswarnarevisi->TooltipValue = "";

            // tonewarnaok
            $this->tonewarnaok->LinkCustomAttributes = "";
            $this->tonewarnaok->HrefValue = "";
            $this->tonewarnaok->TooltipValue = "";

            // tonewarnarevisi
            $this->tonewarnarevisi->LinkCustomAttributes = "";
            $this->tonewarnarevisi->HrefValue = "";
            $this->tonewarnarevisi->TooltipValue = "";

            // gradasiwarnaok
            $this->gradasiwarnaok->LinkCustomAttributes = "";
            $this->gradasiwarnaok->HrefValue = "";
            $this->gradasiwarnaok->TooltipValue = "";

            // gradasiwarnarevisi
            $this->gradasiwarnarevisi->LinkCustomAttributes = "";
            $this->gradasiwarnarevisi->HrefValue = "";
            $this->gradasiwarnarevisi->TooltipValue = "";

            // bauok
            $this->bauok->LinkCustomAttributes = "";
            $this->bauok->HrefValue = "";
            $this->bauok->TooltipValue = "";

            // baurevisi
            $this->baurevisi->LinkCustomAttributes = "";
            $this->baurevisi->HrefValue = "";
            $this->baurevisi->TooltipValue = "";

            // estetikaok
            $this->estetikaok->LinkCustomAttributes = "";
            $this->estetikaok->HrefValue = "";
            $this->estetikaok->TooltipValue = "";

            // estetikarevisi
            $this->estetikarevisi->LinkCustomAttributes = "";
            $this->estetikarevisi->HrefValue = "";
            $this->estetikarevisi->TooltipValue = "";

            // aplikasiawalok
            $this->aplikasiawalok->LinkCustomAttributes = "";
            $this->aplikasiawalok->HrefValue = "";
            $this->aplikasiawalok->TooltipValue = "";

            // aplikasiawalrevisi
            $this->aplikasiawalrevisi->LinkCustomAttributes = "";
            $this->aplikasiawalrevisi->HrefValue = "";
            $this->aplikasiawalrevisi->TooltipValue = "";

            // aplikasilamaok
            $this->aplikasilamaok->LinkCustomAttributes = "";
            $this->aplikasilamaok->HrefValue = "";
            $this->aplikasilamaok->TooltipValue = "";

            // aplikasilamarevisi
            $this->aplikasilamarevisi->LinkCustomAttributes = "";
            $this->aplikasilamarevisi->HrefValue = "";
            $this->aplikasilamarevisi->TooltipValue = "";

            // efekpositifok
            $this->efekpositifok->LinkCustomAttributes = "";
            $this->efekpositifok->HrefValue = "";
            $this->efekpositifok->TooltipValue = "";

            // efekpositifrevisi
            $this->efekpositifrevisi->LinkCustomAttributes = "";
            $this->efekpositifrevisi->HrefValue = "";
            $this->efekpositifrevisi->TooltipValue = "";

            // efeknegatifok
            $this->efeknegatifok->LinkCustomAttributes = "";
            $this->efeknegatifok->HrefValue = "";
            $this->efeknegatifok->TooltipValue = "";

            // efeknegatifrevisi
            $this->efeknegatifrevisi->LinkCustomAttributes = "";
            $this->efeknegatifrevisi->HrefValue = "";
            $this->efeknegatifrevisi->TooltipValue = "";

            // kesimpulan
            $this->kesimpulan->LinkCustomAttributes = "";
            $this->kesimpulan->HrefValue = "";
            $this->kesimpulan->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                    if ($this->idnpd->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                        };
                        $lookupFilter = $lookupFilter->bindTo($this);
                        $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                            $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                        } else {
                            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                        }
                    }
                } else {
                    $this->idnpd->ViewValue = null;
                }
                $this->idnpd->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->Lookup !== null && is_array($this->idnpd->Lookup->Options) ? $curVal : null;
                }
                if ($this->idnpd->ViewValue !== null) { // Load from cache
                    $this->idnpd->EditValue = array_values($this->idnpd->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idnpd->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idnpd->EditValue = $arwrk;
                }
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // idnpd_sample
            $this->idnpd_sample->EditAttrs["class"] = "form-control";
            $this->idnpd_sample->EditCustomAttributes = "";
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            } else {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->Lookup !== null && is_array($this->idnpd_sample->Lookup->Options) ? $curVal : null;
            }
            if ($this->idnpd_sample->ViewValue !== null) { // Load from cache
                $this->idnpd_sample->EditValue = array_values($this->idnpd_sample->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idnpd_sample->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "`status`=0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idnpd_sample->EditValue = $arwrk;
            }
            $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

            // tglreview
            $this->tglreview->EditAttrs["class"] = "form-control";
            $this->tglreview->EditCustomAttributes = "";
            $this->tglreview->EditValue = HtmlEncode(FormatDateTime($this->tglreview->CurrentValue, 8));
            $this->tglreview->PlaceHolder = RemoveHtml($this->tglreview->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
            $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

            // wadah
            $this->wadah->EditAttrs["class"] = "form-control";
            $this->wadah->EditCustomAttributes = "";
            if (!$this->wadah->Raw) {
                $this->wadah->CurrentValue = HtmlDecode($this->wadah->CurrentValue);
            }
            $this->wadah->EditValue = HtmlEncode($this->wadah->CurrentValue);
            $this->wadah->PlaceHolder = RemoveHtml($this->wadah->caption());

            // bentukok
            $this->bentukok->EditCustomAttributes = "";
            $this->bentukok->EditValue = $this->bentukok->options(false);
            $this->bentukok->PlaceHolder = RemoveHtml($this->bentukok->caption());

            // bentukrevisi
            $this->bentukrevisi->EditAttrs["class"] = "form-control";
            $this->bentukrevisi->EditCustomAttributes = "";
            if (!$this->bentukrevisi->Raw) {
                $this->bentukrevisi->CurrentValue = HtmlDecode($this->bentukrevisi->CurrentValue);
            }
            $this->bentukrevisi->EditValue = HtmlEncode($this->bentukrevisi->CurrentValue);
            $this->bentukrevisi->PlaceHolder = RemoveHtml($this->bentukrevisi->caption());

            // viskositasok
            $this->viskositasok->EditCustomAttributes = "";
            $this->viskositasok->EditValue = $this->viskositasok->options(false);
            $this->viskositasok->PlaceHolder = RemoveHtml($this->viskositasok->caption());

            // viskositasrevisi
            $this->viskositasrevisi->EditAttrs["class"] = "form-control";
            $this->viskositasrevisi->EditCustomAttributes = "";
            if (!$this->viskositasrevisi->Raw) {
                $this->viskositasrevisi->CurrentValue = HtmlDecode($this->viskositasrevisi->CurrentValue);
            }
            $this->viskositasrevisi->EditValue = HtmlEncode($this->viskositasrevisi->CurrentValue);
            $this->viskositasrevisi->PlaceHolder = RemoveHtml($this->viskositasrevisi->caption());

            // jeniswarnaok
            $this->jeniswarnaok->EditCustomAttributes = "";
            $this->jeniswarnaok->EditValue = $this->jeniswarnaok->options(false);
            $this->jeniswarnaok->PlaceHolder = RemoveHtml($this->jeniswarnaok->caption());

            // jeniswarnarevisi
            $this->jeniswarnarevisi->EditAttrs["class"] = "form-control";
            $this->jeniswarnarevisi->EditCustomAttributes = "";
            if (!$this->jeniswarnarevisi->Raw) {
                $this->jeniswarnarevisi->CurrentValue = HtmlDecode($this->jeniswarnarevisi->CurrentValue);
            }
            $this->jeniswarnarevisi->EditValue = HtmlEncode($this->jeniswarnarevisi->CurrentValue);
            $this->jeniswarnarevisi->PlaceHolder = RemoveHtml($this->jeniswarnarevisi->caption());

            // tonewarnaok
            $this->tonewarnaok->EditCustomAttributes = "";
            $this->tonewarnaok->EditValue = $this->tonewarnaok->options(false);
            $this->tonewarnaok->PlaceHolder = RemoveHtml($this->tonewarnaok->caption());

            // tonewarnarevisi
            $this->tonewarnarevisi->EditAttrs["class"] = "form-control";
            $this->tonewarnarevisi->EditCustomAttributes = "";
            if (!$this->tonewarnarevisi->Raw) {
                $this->tonewarnarevisi->CurrentValue = HtmlDecode($this->tonewarnarevisi->CurrentValue);
            }
            $this->tonewarnarevisi->EditValue = HtmlEncode($this->tonewarnarevisi->CurrentValue);
            $this->tonewarnarevisi->PlaceHolder = RemoveHtml($this->tonewarnarevisi->caption());

            // gradasiwarnaok
            $this->gradasiwarnaok->EditCustomAttributes = "";
            $this->gradasiwarnaok->EditValue = $this->gradasiwarnaok->options(false);
            $this->gradasiwarnaok->PlaceHolder = RemoveHtml($this->gradasiwarnaok->caption());

            // gradasiwarnarevisi
            $this->gradasiwarnarevisi->EditAttrs["class"] = "form-control";
            $this->gradasiwarnarevisi->EditCustomAttributes = "";
            if (!$this->gradasiwarnarevisi->Raw) {
                $this->gradasiwarnarevisi->CurrentValue = HtmlDecode($this->gradasiwarnarevisi->CurrentValue);
            }
            $this->gradasiwarnarevisi->EditValue = HtmlEncode($this->gradasiwarnarevisi->CurrentValue);
            $this->gradasiwarnarevisi->PlaceHolder = RemoveHtml($this->gradasiwarnarevisi->caption());

            // bauok
            $this->bauok->EditCustomAttributes = "";
            $this->bauok->EditValue = $this->bauok->options(false);
            $this->bauok->PlaceHolder = RemoveHtml($this->bauok->caption());

            // baurevisi
            $this->baurevisi->EditAttrs["class"] = "form-control";
            $this->baurevisi->EditCustomAttributes = "";
            if (!$this->baurevisi->Raw) {
                $this->baurevisi->CurrentValue = HtmlDecode($this->baurevisi->CurrentValue);
            }
            $this->baurevisi->EditValue = HtmlEncode($this->baurevisi->CurrentValue);
            $this->baurevisi->PlaceHolder = RemoveHtml($this->baurevisi->caption());

            // estetikaok
            $this->estetikaok->EditCustomAttributes = "";
            $this->estetikaok->EditValue = $this->estetikaok->options(false);
            $this->estetikaok->PlaceHolder = RemoveHtml($this->estetikaok->caption());

            // estetikarevisi
            $this->estetikarevisi->EditAttrs["class"] = "form-control";
            $this->estetikarevisi->EditCustomAttributes = "";
            if (!$this->estetikarevisi->Raw) {
                $this->estetikarevisi->CurrentValue = HtmlDecode($this->estetikarevisi->CurrentValue);
            }
            $this->estetikarevisi->EditValue = HtmlEncode($this->estetikarevisi->CurrentValue);
            $this->estetikarevisi->PlaceHolder = RemoveHtml($this->estetikarevisi->caption());

            // aplikasiawalok
            $this->aplikasiawalok->EditCustomAttributes = "";
            $this->aplikasiawalok->EditValue = $this->aplikasiawalok->options(false);
            $this->aplikasiawalok->PlaceHolder = RemoveHtml($this->aplikasiawalok->caption());

            // aplikasiawalrevisi
            $this->aplikasiawalrevisi->EditAttrs["class"] = "form-control";
            $this->aplikasiawalrevisi->EditCustomAttributes = "";
            if (!$this->aplikasiawalrevisi->Raw) {
                $this->aplikasiawalrevisi->CurrentValue = HtmlDecode($this->aplikasiawalrevisi->CurrentValue);
            }
            $this->aplikasiawalrevisi->EditValue = HtmlEncode($this->aplikasiawalrevisi->CurrentValue);
            $this->aplikasiawalrevisi->PlaceHolder = RemoveHtml($this->aplikasiawalrevisi->caption());

            // aplikasilamaok
            $this->aplikasilamaok->EditCustomAttributes = "";
            $this->aplikasilamaok->EditValue = $this->aplikasilamaok->options(false);
            $this->aplikasilamaok->PlaceHolder = RemoveHtml($this->aplikasilamaok->caption());

            // aplikasilamarevisi
            $this->aplikasilamarevisi->EditAttrs["class"] = "form-control";
            $this->aplikasilamarevisi->EditCustomAttributes = "";
            if (!$this->aplikasilamarevisi->Raw) {
                $this->aplikasilamarevisi->CurrentValue = HtmlDecode($this->aplikasilamarevisi->CurrentValue);
            }
            $this->aplikasilamarevisi->EditValue = HtmlEncode($this->aplikasilamarevisi->CurrentValue);
            $this->aplikasilamarevisi->PlaceHolder = RemoveHtml($this->aplikasilamarevisi->caption());

            // efekpositifok
            $this->efekpositifok->EditCustomAttributes = "";
            $this->efekpositifok->EditValue = $this->efekpositifok->options(false);
            $this->efekpositifok->PlaceHolder = RemoveHtml($this->efekpositifok->caption());

            // efekpositifrevisi
            $this->efekpositifrevisi->EditAttrs["class"] = "form-control";
            $this->efekpositifrevisi->EditCustomAttributes = "";
            if (!$this->efekpositifrevisi->Raw) {
                $this->efekpositifrevisi->CurrentValue = HtmlDecode($this->efekpositifrevisi->CurrentValue);
            }
            $this->efekpositifrevisi->EditValue = HtmlEncode($this->efekpositifrevisi->CurrentValue);
            $this->efekpositifrevisi->PlaceHolder = RemoveHtml($this->efekpositifrevisi->caption());

            // efeknegatifok
            $this->efeknegatifok->EditCustomAttributes = "";
            $this->efeknegatifok->EditValue = $this->efeknegatifok->options(false);
            $this->efeknegatifok->PlaceHolder = RemoveHtml($this->efeknegatifok->caption());

            // efeknegatifrevisi
            $this->efeknegatifrevisi->EditAttrs["class"] = "form-control";
            $this->efeknegatifrevisi->EditCustomAttributes = "";
            if (!$this->efeknegatifrevisi->Raw) {
                $this->efeknegatifrevisi->CurrentValue = HtmlDecode($this->efeknegatifrevisi->CurrentValue);
            }
            $this->efeknegatifrevisi->EditValue = HtmlEncode($this->efeknegatifrevisi->CurrentValue);
            $this->efeknegatifrevisi->PlaceHolder = RemoveHtml($this->efeknegatifrevisi->caption());

            // kesimpulan
            $this->kesimpulan->EditAttrs["class"] = "form-control";
            $this->kesimpulan->EditCustomAttributes = "";
            $this->kesimpulan->EditValue = HtmlEncode($this->kesimpulan->CurrentValue);
            $this->kesimpulan->PlaceHolder = RemoveHtml($this->kesimpulan->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";

            // tglreview
            $this->tglreview->LinkCustomAttributes = "";
            $this->tglreview->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // wadah
            $this->wadah->LinkCustomAttributes = "";
            $this->wadah->HrefValue = "";

            // bentukok
            $this->bentukok->LinkCustomAttributes = "";
            $this->bentukok->HrefValue = "";

            // bentukrevisi
            $this->bentukrevisi->LinkCustomAttributes = "";
            $this->bentukrevisi->HrefValue = "";

            // viskositasok
            $this->viskositasok->LinkCustomAttributes = "";
            $this->viskositasok->HrefValue = "";

            // viskositasrevisi
            $this->viskositasrevisi->LinkCustomAttributes = "";
            $this->viskositasrevisi->HrefValue = "";

            // jeniswarnaok
            $this->jeniswarnaok->LinkCustomAttributes = "";
            $this->jeniswarnaok->HrefValue = "";

            // jeniswarnarevisi
            $this->jeniswarnarevisi->LinkCustomAttributes = "";
            $this->jeniswarnarevisi->HrefValue = "";

            // tonewarnaok
            $this->tonewarnaok->LinkCustomAttributes = "";
            $this->tonewarnaok->HrefValue = "";

            // tonewarnarevisi
            $this->tonewarnarevisi->LinkCustomAttributes = "";
            $this->tonewarnarevisi->HrefValue = "";

            // gradasiwarnaok
            $this->gradasiwarnaok->LinkCustomAttributes = "";
            $this->gradasiwarnaok->HrefValue = "";

            // gradasiwarnarevisi
            $this->gradasiwarnarevisi->LinkCustomAttributes = "";
            $this->gradasiwarnarevisi->HrefValue = "";

            // bauok
            $this->bauok->LinkCustomAttributes = "";
            $this->bauok->HrefValue = "";

            // baurevisi
            $this->baurevisi->LinkCustomAttributes = "";
            $this->baurevisi->HrefValue = "";

            // estetikaok
            $this->estetikaok->LinkCustomAttributes = "";
            $this->estetikaok->HrefValue = "";

            // estetikarevisi
            $this->estetikarevisi->LinkCustomAttributes = "";
            $this->estetikarevisi->HrefValue = "";

            // aplikasiawalok
            $this->aplikasiawalok->LinkCustomAttributes = "";
            $this->aplikasiawalok->HrefValue = "";

            // aplikasiawalrevisi
            $this->aplikasiawalrevisi->LinkCustomAttributes = "";
            $this->aplikasiawalrevisi->HrefValue = "";

            // aplikasilamaok
            $this->aplikasilamaok->LinkCustomAttributes = "";
            $this->aplikasilamaok->HrefValue = "";

            // aplikasilamarevisi
            $this->aplikasilamarevisi->LinkCustomAttributes = "";
            $this->aplikasilamarevisi->HrefValue = "";

            // efekpositifok
            $this->efekpositifok->LinkCustomAttributes = "";
            $this->efekpositifok->HrefValue = "";

            // efekpositifrevisi
            $this->efekpositifrevisi->LinkCustomAttributes = "";
            $this->efekpositifrevisi->HrefValue = "";

            // efeknegatifok
            $this->efeknegatifok->LinkCustomAttributes = "";
            $this->efeknegatifok->HrefValue = "";

            // efeknegatifrevisi
            $this->efeknegatifrevisi->LinkCustomAttributes = "";
            $this->efeknegatifrevisi->HrefValue = "";

            // kesimpulan
            $this->kesimpulan->LinkCustomAttributes = "";
            $this->kesimpulan->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
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
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if ($this->idnpd_sample->Required) {
            if (!$this->idnpd_sample->IsDetailKey && EmptyValue($this->idnpd_sample->FormValue)) {
                $this->idnpd_sample->addErrorMessage(str_replace("%s", $this->idnpd_sample->caption(), $this->idnpd_sample->RequiredErrorMessage));
            }
        }
        if ($this->tglreview->Required) {
            if (!$this->tglreview->IsDetailKey && EmptyValue($this->tglreview->FormValue)) {
                $this->tglreview->addErrorMessage(str_replace("%s", $this->tglreview->caption(), $this->tglreview->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglreview->FormValue)) {
            $this->tglreview->addErrorMessage($this->tglreview->getErrorMessage(false));
        }
        if ($this->tglsubmit->Required) {
            if (!$this->tglsubmit->IsDetailKey && EmptyValue($this->tglsubmit->FormValue)) {
                $this->tglsubmit->addErrorMessage(str_replace("%s", $this->tglsubmit->caption(), $this->tglsubmit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglsubmit->FormValue)) {
            $this->tglsubmit->addErrorMessage($this->tglsubmit->getErrorMessage(false));
        }
        if ($this->wadah->Required) {
            if (!$this->wadah->IsDetailKey && EmptyValue($this->wadah->FormValue)) {
                $this->wadah->addErrorMessage(str_replace("%s", $this->wadah->caption(), $this->wadah->RequiredErrorMessage));
            }
        }
        if ($this->bentukok->Required) {
            if ($this->bentukok->FormValue == "") {
                $this->bentukok->addErrorMessage(str_replace("%s", $this->bentukok->caption(), $this->bentukok->RequiredErrorMessage));
            }
        }
        if ($this->bentukrevisi->Required) {
            if (!$this->bentukrevisi->IsDetailKey && EmptyValue($this->bentukrevisi->FormValue)) {
                $this->bentukrevisi->addErrorMessage(str_replace("%s", $this->bentukrevisi->caption(), $this->bentukrevisi->RequiredErrorMessage));
            }
        }
        if ($this->viskositasok->Required) {
            if ($this->viskositasok->FormValue == "") {
                $this->viskositasok->addErrorMessage(str_replace("%s", $this->viskositasok->caption(), $this->viskositasok->RequiredErrorMessage));
            }
        }
        if ($this->viskositasrevisi->Required) {
            if (!$this->viskositasrevisi->IsDetailKey && EmptyValue($this->viskositasrevisi->FormValue)) {
                $this->viskositasrevisi->addErrorMessage(str_replace("%s", $this->viskositasrevisi->caption(), $this->viskositasrevisi->RequiredErrorMessage));
            }
        }
        if ($this->jeniswarnaok->Required) {
            if ($this->jeniswarnaok->FormValue == "") {
                $this->jeniswarnaok->addErrorMessage(str_replace("%s", $this->jeniswarnaok->caption(), $this->jeniswarnaok->RequiredErrorMessage));
            }
        }
        if ($this->jeniswarnarevisi->Required) {
            if (!$this->jeniswarnarevisi->IsDetailKey && EmptyValue($this->jeniswarnarevisi->FormValue)) {
                $this->jeniswarnarevisi->addErrorMessage(str_replace("%s", $this->jeniswarnarevisi->caption(), $this->jeniswarnarevisi->RequiredErrorMessage));
            }
        }
        if ($this->tonewarnaok->Required) {
            if ($this->tonewarnaok->FormValue == "") {
                $this->tonewarnaok->addErrorMessage(str_replace("%s", $this->tonewarnaok->caption(), $this->tonewarnaok->RequiredErrorMessage));
            }
        }
        if ($this->tonewarnarevisi->Required) {
            if (!$this->tonewarnarevisi->IsDetailKey && EmptyValue($this->tonewarnarevisi->FormValue)) {
                $this->tonewarnarevisi->addErrorMessage(str_replace("%s", $this->tonewarnarevisi->caption(), $this->tonewarnarevisi->RequiredErrorMessage));
            }
        }
        if ($this->gradasiwarnaok->Required) {
            if ($this->gradasiwarnaok->FormValue == "") {
                $this->gradasiwarnaok->addErrorMessage(str_replace("%s", $this->gradasiwarnaok->caption(), $this->gradasiwarnaok->RequiredErrorMessage));
            }
        }
        if ($this->gradasiwarnarevisi->Required) {
            if (!$this->gradasiwarnarevisi->IsDetailKey && EmptyValue($this->gradasiwarnarevisi->FormValue)) {
                $this->gradasiwarnarevisi->addErrorMessage(str_replace("%s", $this->gradasiwarnarevisi->caption(), $this->gradasiwarnarevisi->RequiredErrorMessage));
            }
        }
        if ($this->bauok->Required) {
            if ($this->bauok->FormValue == "") {
                $this->bauok->addErrorMessage(str_replace("%s", $this->bauok->caption(), $this->bauok->RequiredErrorMessage));
            }
        }
        if ($this->baurevisi->Required) {
            if (!$this->baurevisi->IsDetailKey && EmptyValue($this->baurevisi->FormValue)) {
                $this->baurevisi->addErrorMessage(str_replace("%s", $this->baurevisi->caption(), $this->baurevisi->RequiredErrorMessage));
            }
        }
        if ($this->estetikaok->Required) {
            if ($this->estetikaok->FormValue == "") {
                $this->estetikaok->addErrorMessage(str_replace("%s", $this->estetikaok->caption(), $this->estetikaok->RequiredErrorMessage));
            }
        }
        if ($this->estetikarevisi->Required) {
            if (!$this->estetikarevisi->IsDetailKey && EmptyValue($this->estetikarevisi->FormValue)) {
                $this->estetikarevisi->addErrorMessage(str_replace("%s", $this->estetikarevisi->caption(), $this->estetikarevisi->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiawalok->Required) {
            if ($this->aplikasiawalok->FormValue == "") {
                $this->aplikasiawalok->addErrorMessage(str_replace("%s", $this->aplikasiawalok->caption(), $this->aplikasiawalok->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiawalrevisi->Required) {
            if (!$this->aplikasiawalrevisi->IsDetailKey && EmptyValue($this->aplikasiawalrevisi->FormValue)) {
                $this->aplikasiawalrevisi->addErrorMessage(str_replace("%s", $this->aplikasiawalrevisi->caption(), $this->aplikasiawalrevisi->RequiredErrorMessage));
            }
        }
        if ($this->aplikasilamaok->Required) {
            if ($this->aplikasilamaok->FormValue == "") {
                $this->aplikasilamaok->addErrorMessage(str_replace("%s", $this->aplikasilamaok->caption(), $this->aplikasilamaok->RequiredErrorMessage));
            }
        }
        if ($this->aplikasilamarevisi->Required) {
            if (!$this->aplikasilamarevisi->IsDetailKey && EmptyValue($this->aplikasilamarevisi->FormValue)) {
                $this->aplikasilamarevisi->addErrorMessage(str_replace("%s", $this->aplikasilamarevisi->caption(), $this->aplikasilamarevisi->RequiredErrorMessage));
            }
        }
        if ($this->efekpositifok->Required) {
            if ($this->efekpositifok->FormValue == "") {
                $this->efekpositifok->addErrorMessage(str_replace("%s", $this->efekpositifok->caption(), $this->efekpositifok->RequiredErrorMessage));
            }
        }
        if ($this->efekpositifrevisi->Required) {
            if (!$this->efekpositifrevisi->IsDetailKey && EmptyValue($this->efekpositifrevisi->FormValue)) {
                $this->efekpositifrevisi->addErrorMessage(str_replace("%s", $this->efekpositifrevisi->caption(), $this->efekpositifrevisi->RequiredErrorMessage));
            }
        }
        if ($this->efeknegatifok->Required) {
            if ($this->efeknegatifok->FormValue == "") {
                $this->efeknegatifok->addErrorMessage(str_replace("%s", $this->efeknegatifok->caption(), $this->efeknegatifok->RequiredErrorMessage));
            }
        }
        if ($this->efeknegatifrevisi->Required) {
            if (!$this->efeknegatifrevisi->IsDetailKey && EmptyValue($this->efeknegatifrevisi->FormValue)) {
                $this->efeknegatifrevisi->addErrorMessage(str_replace("%s", $this->efeknegatifrevisi->caption(), $this->efeknegatifrevisi->RequiredErrorMessage));
            }
        }
        if ($this->kesimpulan->Required) {
            if (!$this->kesimpulan->IsDetailKey && EmptyValue($this->kesimpulan->FormValue)) {
                $this->kesimpulan->addErrorMessage(str_replace("%s", $this->kesimpulan->caption(), $this->kesimpulan->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
            }
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

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $masterFilter = $this->sqlMasterFilter_npd();
            if (strval($this->idnpd->CurrentValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($this->idnpd->CurrentValue, "DB"), $masterFilter);
            } else {
                $masterFilter = "";
            }
            if ($masterFilter != "") {
                $rsmaster = Container("npd")->loadRs($masterFilter)->fetch(\PDO::FETCH_ASSOC);
                $masterRecordExists = $rsmaster !== false;
                $validMasterKey = true;
                if ($masterRecordExists) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['created_by']);
                } elseif ($this->getCurrentMasterTable() == "npd") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
        }

        // Check referential integrity for master table 'npd_review'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_npd();
        if (strval($this->idnpd->CurrentValue) != "") {
            $masterFilter = str_replace("@id@", AdjustSql($this->idnpd->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("npd")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "npd", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, false);

        // idnpd_sample
        $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, false);

        // tglreview
        $this->tglreview->setDbValueDef($rsnew, UnFormatDateTime($this->tglreview->CurrentValue, 0), CurrentDate(), false);

        // tglsubmit
        $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), CurrentDate(), false);

        // wadah
        $this->wadah->setDbValueDef($rsnew, $this->wadah->CurrentValue, null, false);

        // bentukok
        $this->bentukok->setDbValueDef($rsnew, $this->bentukok->CurrentValue, 0, false);

        // bentukrevisi
        $this->bentukrevisi->setDbValueDef($rsnew, $this->bentukrevisi->CurrentValue, null, false);

        // viskositasok
        $this->viskositasok->setDbValueDef($rsnew, $this->viskositasok->CurrentValue, 0, false);

        // viskositasrevisi
        $this->viskositasrevisi->setDbValueDef($rsnew, $this->viskositasrevisi->CurrentValue, null, false);

        // jeniswarnaok
        $this->jeniswarnaok->setDbValueDef($rsnew, $this->jeniswarnaok->CurrentValue, 0, false);

        // jeniswarnarevisi
        $this->jeniswarnarevisi->setDbValueDef($rsnew, $this->jeniswarnarevisi->CurrentValue, null, false);

        // tonewarnaok
        $this->tonewarnaok->setDbValueDef($rsnew, $this->tonewarnaok->CurrentValue, 0, false);

        // tonewarnarevisi
        $this->tonewarnarevisi->setDbValueDef($rsnew, $this->tonewarnarevisi->CurrentValue, null, false);

        // gradasiwarnaok
        $this->gradasiwarnaok->setDbValueDef($rsnew, $this->gradasiwarnaok->CurrentValue, 0, false);

        // gradasiwarnarevisi
        $this->gradasiwarnarevisi->setDbValueDef($rsnew, $this->gradasiwarnarevisi->CurrentValue, null, false);

        // bauok
        $this->bauok->setDbValueDef($rsnew, $this->bauok->CurrentValue, 0, false);

        // baurevisi
        $this->baurevisi->setDbValueDef($rsnew, $this->baurevisi->CurrentValue, null, false);

        // estetikaok
        $this->estetikaok->setDbValueDef($rsnew, $this->estetikaok->CurrentValue, 0, false);

        // estetikarevisi
        $this->estetikarevisi->setDbValueDef($rsnew, $this->estetikarevisi->CurrentValue, null, false);

        // aplikasiawalok
        $this->aplikasiawalok->setDbValueDef($rsnew, $this->aplikasiawalok->CurrentValue, 0, false);

        // aplikasiawalrevisi
        $this->aplikasiawalrevisi->setDbValueDef($rsnew, $this->aplikasiawalrevisi->CurrentValue, null, false);

        // aplikasilamaok
        $this->aplikasilamaok->setDbValueDef($rsnew, $this->aplikasilamaok->CurrentValue, 0, false);

        // aplikasilamarevisi
        $this->aplikasilamarevisi->setDbValueDef($rsnew, $this->aplikasilamarevisi->CurrentValue, null, false);

        // efekpositifok
        $this->efekpositifok->setDbValueDef($rsnew, $this->efekpositifok->CurrentValue, 0, false);

        // efekpositifrevisi
        $this->efekpositifrevisi->setDbValueDef($rsnew, $this->efekpositifrevisi->CurrentValue, null, false);

        // efeknegatifok
        $this->efeknegatifok->setDbValueDef($rsnew, $this->efeknegatifok->CurrentValue, 0, false);

        // efeknegatifrevisi
        $this->efeknegatifrevisi->setDbValueDef($rsnew, $this->efeknegatifrevisi->CurrentValue, null, false);

        // kesimpulan
        $this->kesimpulan->setDbValueDef($rsnew, $this->kesimpulan->CurrentValue, "", false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, 0, false);

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);

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

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->created_by->CurrentValue);
        }
        return true;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Get("fk_id", Get("idnpd"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idnpd->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idnpd->setSessionValue($this->idnpd->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Post("fk_id", Post("idnpd"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idnpd->setFormValue($masterTbl->id->FormValue);
                    $this->idnpd->setSessionValue($this->idnpd->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "npd") {
                if ($this->idnpd->CurrentValue == "") {
                    $this->idnpd->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdReviewList"), "", $this->TableVar, true);
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
                case "x_idnpd":
                    $lookupFilter = function () {
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "`status`=0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_bentukok":
                    break;
                case "x_viskositasok":
                    break;
                case "x_jeniswarnaok":
                    break;
                case "x_tonewarnaok":
                    break;
                case "x_gradasiwarnaok":
                    break;
                case "x_bauok":
                    break;
                case "x_estetikaok":
                    break;
                case "x_aplikasiawalok":
                    break;
                case "x_aplikasilamaok":
                    break;
                case "x_efekpositifok":
                    break;
                case "x_efeknegatifok":
                    break;
                case "x_status":
                    break;
                case "x_readonly":
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
        echo "
        <style>
        	#r_bentukrevisi, #r_viskositasrevisi, #r_jeniswarnarevisi, #r_tonewarnarevisi, #r_gradasiwarnarevisi, #r_baurevisi, #r_estetikarevisi, #r_aplikasiawalrevisi, #r_aplikasilamarevisi, #r_efekpositifrevisi, #r_efeknegatifrevisi {
    			display: none;
        	}
        </style>
        ";
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
