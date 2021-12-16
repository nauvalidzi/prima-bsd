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
        $this->tanggal_review->setVisibility();
        $this->tanggal_submit->setVisibility();
        $this->wadah->setVisibility();
        $this->bentuk_opsi->setVisibility();
        $this->bentuk_revisi->setVisibility();
        $this->viskositas_opsi->setVisibility();
        $this->viskositas_revisi->setVisibility();
        $this->jeniswarna_opsi->setVisibility();
        $this->jeniswarna_revisi->setVisibility();
        $this->tonewarna_opsi->setVisibility();
        $this->tonewarna_revisi->setVisibility();
        $this->gradasiwarna_opsi->setVisibility();
        $this->gradasiwarna_revisi->setVisibility();
        $this->bauparfum_opsi->setVisibility();
        $this->bauparfum_revisi->setVisibility();
        $this->estetika_opsi->setVisibility();
        $this->estetika_revisi->setVisibility();
        $this->aplikasiawal_opsi->setVisibility();
        $this->aplikasiawal_revisi->setVisibility();
        $this->aplikasilama_opsi->setVisibility();
        $this->aplikasilama_revisi->setVisibility();
        $this->efekpositif_opsi->setVisibility();
        $this->efekpositif_revisi->setVisibility();
        $this->efeknegatif_opsi->setVisibility();
        $this->efeknegatif_revisi->setVisibility();
        $this->kesimpulan->setVisibility();
        $this->status->setVisibility();
        $this->created_at->Visible = false;
        $this->readonly->Visible = false;
        $this->ukuran->setVisibility();
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
        $this->tanggal_review->CurrentValue = null;
        $this->tanggal_review->OldValue = $this->tanggal_review->CurrentValue;
        $this->tanggal_submit->CurrentValue = null;
        $this->tanggal_submit->OldValue = $this->tanggal_submit->CurrentValue;
        $this->wadah->CurrentValue = null;
        $this->wadah->OldValue = $this->wadah->CurrentValue;
        $this->bentuk_opsi->CurrentValue = 1;
        $this->bentuk_revisi->CurrentValue = null;
        $this->bentuk_revisi->OldValue = $this->bentuk_revisi->CurrentValue;
        $this->viskositas_opsi->CurrentValue = 1;
        $this->viskositas_revisi->CurrentValue = null;
        $this->viskositas_revisi->OldValue = $this->viskositas_revisi->CurrentValue;
        $this->jeniswarna_opsi->CurrentValue = 1;
        $this->jeniswarna_revisi->CurrentValue = null;
        $this->jeniswarna_revisi->OldValue = $this->jeniswarna_revisi->CurrentValue;
        $this->tonewarna_opsi->CurrentValue = 1;
        $this->tonewarna_revisi->CurrentValue = null;
        $this->tonewarna_revisi->OldValue = $this->tonewarna_revisi->CurrentValue;
        $this->gradasiwarna_opsi->CurrentValue = 1;
        $this->gradasiwarna_revisi->CurrentValue = null;
        $this->gradasiwarna_revisi->OldValue = $this->gradasiwarna_revisi->CurrentValue;
        $this->bauparfum_opsi->CurrentValue = 1;
        $this->bauparfum_revisi->CurrentValue = null;
        $this->bauparfum_revisi->OldValue = $this->bauparfum_revisi->CurrentValue;
        $this->estetika_opsi->CurrentValue = 1;
        $this->estetika_revisi->CurrentValue = null;
        $this->estetika_revisi->OldValue = $this->estetika_revisi->CurrentValue;
        $this->aplikasiawal_opsi->CurrentValue = 1;
        $this->aplikasiawal_revisi->CurrentValue = null;
        $this->aplikasiawal_revisi->OldValue = $this->aplikasiawal_revisi->CurrentValue;
        $this->aplikasilama_opsi->CurrentValue = 1;
        $this->aplikasilama_revisi->CurrentValue = null;
        $this->aplikasilama_revisi->OldValue = $this->aplikasilama_revisi->CurrentValue;
        $this->efekpositif_opsi->CurrentValue = 1;
        $this->efekpositif_revisi->CurrentValue = null;
        $this->efekpositif_revisi->OldValue = $this->efekpositif_revisi->CurrentValue;
        $this->efeknegatif_opsi->CurrentValue = 1;
        $this->efeknegatif_revisi->CurrentValue = null;
        $this->efeknegatif_revisi->OldValue = $this->efeknegatif_revisi->CurrentValue;
        $this->kesimpulan->CurrentValue = null;
        $this->kesimpulan->OldValue = $this->kesimpulan->CurrentValue;
        $this->status->CurrentValue = 1;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->readonly->CurrentValue = 0;
        $this->ukuran->CurrentValue = null;
        $this->ukuran->OldValue = $this->ukuran->CurrentValue;
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

        // Check field name 'tanggal_review' first before field var 'x_tanggal_review'
        $val = $CurrentForm->hasValue("tanggal_review") ? $CurrentForm->getValue("tanggal_review") : $CurrentForm->getValue("x_tanggal_review");
        if (!$this->tanggal_review->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_review->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_review->setFormValue($val);
            }
            $this->tanggal_review->CurrentValue = UnFormatDateTime($this->tanggal_review->CurrentValue, 0);
        }

        // Check field name 'tanggal_submit' first before field var 'x_tanggal_submit'
        $val = $CurrentForm->hasValue("tanggal_submit") ? $CurrentForm->getValue("tanggal_submit") : $CurrentForm->getValue("x_tanggal_submit");
        if (!$this->tanggal_submit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_submit->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_submit->setFormValue($val);
            }
            $this->tanggal_submit->CurrentValue = UnFormatDateTime($this->tanggal_submit->CurrentValue, 0);
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

        // Check field name 'bentuk_opsi' first before field var 'x_bentuk_opsi'
        $val = $CurrentForm->hasValue("bentuk_opsi") ? $CurrentForm->getValue("bentuk_opsi") : $CurrentForm->getValue("x_bentuk_opsi");
        if (!$this->bentuk_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk_opsi->Visible = false; // Disable update for API request
            } else {
                $this->bentuk_opsi->setFormValue($val);
            }
        }

        // Check field name 'bentuk_revisi' first before field var 'x_bentuk_revisi'
        $val = $CurrentForm->hasValue("bentuk_revisi") ? $CurrentForm->getValue("bentuk_revisi") : $CurrentForm->getValue("x_bentuk_revisi");
        if (!$this->bentuk_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk_revisi->Visible = false; // Disable update for API request
            } else {
                $this->bentuk_revisi->setFormValue($val);
            }
        }

        // Check field name 'viskositas_opsi' first before field var 'x_viskositas_opsi'
        $val = $CurrentForm->hasValue("viskositas_opsi") ? $CurrentForm->getValue("viskositas_opsi") : $CurrentForm->getValue("x_viskositas_opsi");
        if (!$this->viskositas_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositas_opsi->Visible = false; // Disable update for API request
            } else {
                $this->viskositas_opsi->setFormValue($val);
            }
        }

        // Check field name 'viskositas_revisi' first before field var 'x_viskositas_revisi'
        $val = $CurrentForm->hasValue("viskositas_revisi") ? $CurrentForm->getValue("viskositas_revisi") : $CurrentForm->getValue("x_viskositas_revisi");
        if (!$this->viskositas_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositas_revisi->Visible = false; // Disable update for API request
            } else {
                $this->viskositas_revisi->setFormValue($val);
            }
        }

        // Check field name 'jeniswarna_opsi' first before field var 'x_jeniswarna_opsi'
        $val = $CurrentForm->hasValue("jeniswarna_opsi") ? $CurrentForm->getValue("jeniswarna_opsi") : $CurrentForm->getValue("x_jeniswarna_opsi");
        if (!$this->jeniswarna_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jeniswarna_opsi->Visible = false; // Disable update for API request
            } else {
                $this->jeniswarna_opsi->setFormValue($val);
            }
        }

        // Check field name 'jeniswarna_revisi' first before field var 'x_jeniswarna_revisi'
        $val = $CurrentForm->hasValue("jeniswarna_revisi") ? $CurrentForm->getValue("jeniswarna_revisi") : $CurrentForm->getValue("x_jeniswarna_revisi");
        if (!$this->jeniswarna_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jeniswarna_revisi->Visible = false; // Disable update for API request
            } else {
                $this->jeniswarna_revisi->setFormValue($val);
            }
        }

        // Check field name 'tonewarna_opsi' first before field var 'x_tonewarna_opsi'
        $val = $CurrentForm->hasValue("tonewarna_opsi") ? $CurrentForm->getValue("tonewarna_opsi") : $CurrentForm->getValue("x_tonewarna_opsi");
        if (!$this->tonewarna_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tonewarna_opsi->Visible = false; // Disable update for API request
            } else {
                $this->tonewarna_opsi->setFormValue($val);
            }
        }

        // Check field name 'tonewarna_revisi' first before field var 'x_tonewarna_revisi'
        $val = $CurrentForm->hasValue("tonewarna_revisi") ? $CurrentForm->getValue("tonewarna_revisi") : $CurrentForm->getValue("x_tonewarna_revisi");
        if (!$this->tonewarna_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tonewarna_revisi->Visible = false; // Disable update for API request
            } else {
                $this->tonewarna_revisi->setFormValue($val);
            }
        }

        // Check field name 'gradasiwarna_opsi' first before field var 'x_gradasiwarna_opsi'
        $val = $CurrentForm->hasValue("gradasiwarna_opsi") ? $CurrentForm->getValue("gradasiwarna_opsi") : $CurrentForm->getValue("x_gradasiwarna_opsi");
        if (!$this->gradasiwarna_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gradasiwarna_opsi->Visible = false; // Disable update for API request
            } else {
                $this->gradasiwarna_opsi->setFormValue($val);
            }
        }

        // Check field name 'gradasiwarna_revisi' first before field var 'x_gradasiwarna_revisi'
        $val = $CurrentForm->hasValue("gradasiwarna_revisi") ? $CurrentForm->getValue("gradasiwarna_revisi") : $CurrentForm->getValue("x_gradasiwarna_revisi");
        if (!$this->gradasiwarna_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gradasiwarna_revisi->Visible = false; // Disable update for API request
            } else {
                $this->gradasiwarna_revisi->setFormValue($val);
            }
        }

        // Check field name 'bauparfum_opsi' first before field var 'x_bauparfum_opsi'
        $val = $CurrentForm->hasValue("bauparfum_opsi") ? $CurrentForm->getValue("bauparfum_opsi") : $CurrentForm->getValue("x_bauparfum_opsi");
        if (!$this->bauparfum_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bauparfum_opsi->Visible = false; // Disable update for API request
            } else {
                $this->bauparfum_opsi->setFormValue($val);
            }
        }

        // Check field name 'bauparfum_revisi' first before field var 'x_bauparfum_revisi'
        $val = $CurrentForm->hasValue("bauparfum_revisi") ? $CurrentForm->getValue("bauparfum_revisi") : $CurrentForm->getValue("x_bauparfum_revisi");
        if (!$this->bauparfum_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bauparfum_revisi->Visible = false; // Disable update for API request
            } else {
                $this->bauparfum_revisi->setFormValue($val);
            }
        }

        // Check field name 'estetika_opsi' first before field var 'x_estetika_opsi'
        $val = $CurrentForm->hasValue("estetika_opsi") ? $CurrentForm->getValue("estetika_opsi") : $CurrentForm->getValue("x_estetika_opsi");
        if (!$this->estetika_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetika_opsi->Visible = false; // Disable update for API request
            } else {
                $this->estetika_opsi->setFormValue($val);
            }
        }

        // Check field name 'estetika_revisi' first before field var 'x_estetika_revisi'
        $val = $CurrentForm->hasValue("estetika_revisi") ? $CurrentForm->getValue("estetika_revisi") : $CurrentForm->getValue("x_estetika_revisi");
        if (!$this->estetika_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetika_revisi->Visible = false; // Disable update for API request
            } else {
                $this->estetika_revisi->setFormValue($val);
            }
        }

        // Check field name 'aplikasiawal_opsi' first before field var 'x_aplikasiawal_opsi'
        $val = $CurrentForm->hasValue("aplikasiawal_opsi") ? $CurrentForm->getValue("aplikasiawal_opsi") : $CurrentForm->getValue("x_aplikasiawal_opsi");
        if (!$this->aplikasiawal_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiawal_opsi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiawal_opsi->setFormValue($val);
            }
        }

        // Check field name 'aplikasiawal_revisi' first before field var 'x_aplikasiawal_revisi'
        $val = $CurrentForm->hasValue("aplikasiawal_revisi") ? $CurrentForm->getValue("aplikasiawal_revisi") : $CurrentForm->getValue("x_aplikasiawal_revisi");
        if (!$this->aplikasiawal_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiawal_revisi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiawal_revisi->setFormValue($val);
            }
        }

        // Check field name 'aplikasilama_opsi' first before field var 'x_aplikasilama_opsi'
        $val = $CurrentForm->hasValue("aplikasilama_opsi") ? $CurrentForm->getValue("aplikasilama_opsi") : $CurrentForm->getValue("x_aplikasilama_opsi");
        if (!$this->aplikasilama_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasilama_opsi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasilama_opsi->setFormValue($val);
            }
        }

        // Check field name 'aplikasilama_revisi' first before field var 'x_aplikasilama_revisi'
        $val = $CurrentForm->hasValue("aplikasilama_revisi") ? $CurrentForm->getValue("aplikasilama_revisi") : $CurrentForm->getValue("x_aplikasilama_revisi");
        if (!$this->aplikasilama_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasilama_revisi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasilama_revisi->setFormValue($val);
            }
        }

        // Check field name 'efekpositif_opsi' first before field var 'x_efekpositif_opsi'
        $val = $CurrentForm->hasValue("efekpositif_opsi") ? $CurrentForm->getValue("efekpositif_opsi") : $CurrentForm->getValue("x_efekpositif_opsi");
        if (!$this->efekpositif_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efekpositif_opsi->Visible = false; // Disable update for API request
            } else {
                $this->efekpositif_opsi->setFormValue($val);
            }
        }

        // Check field name 'efekpositif_revisi' first before field var 'x_efekpositif_revisi'
        $val = $CurrentForm->hasValue("efekpositif_revisi") ? $CurrentForm->getValue("efekpositif_revisi") : $CurrentForm->getValue("x_efekpositif_revisi");
        if (!$this->efekpositif_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efekpositif_revisi->Visible = false; // Disable update for API request
            } else {
                $this->efekpositif_revisi->setFormValue($val);
            }
        }

        // Check field name 'efeknegatif_opsi' first before field var 'x_efeknegatif_opsi'
        $val = $CurrentForm->hasValue("efeknegatif_opsi") ? $CurrentForm->getValue("efeknegatif_opsi") : $CurrentForm->getValue("x_efeknegatif_opsi");
        if (!$this->efeknegatif_opsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efeknegatif_opsi->Visible = false; // Disable update for API request
            } else {
                $this->efeknegatif_opsi->setFormValue($val);
            }
        }

        // Check field name 'efeknegatif_revisi' first before field var 'x_efeknegatif_revisi'
        $val = $CurrentForm->hasValue("efeknegatif_revisi") ? $CurrentForm->getValue("efeknegatif_revisi") : $CurrentForm->getValue("x_efeknegatif_revisi");
        if (!$this->efeknegatif_revisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->efeknegatif_revisi->Visible = false; // Disable update for API request
            } else {
                $this->efeknegatif_revisi->setFormValue($val);
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

        // Check field name 'ukuran' first before field var 'x_ukuran'
        $val = $CurrentForm->hasValue("ukuran") ? $CurrentForm->getValue("ukuran") : $CurrentForm->getValue("x_ukuran");
        if (!$this->ukuran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran->Visible = false; // Disable update for API request
            } else {
                $this->ukuran->setFormValue($val);
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
        $this->tanggal_review->CurrentValue = $this->tanggal_review->FormValue;
        $this->tanggal_review->CurrentValue = UnFormatDateTime($this->tanggal_review->CurrentValue, 0);
        $this->tanggal_submit->CurrentValue = $this->tanggal_submit->FormValue;
        $this->tanggal_submit->CurrentValue = UnFormatDateTime($this->tanggal_submit->CurrentValue, 0);
        $this->wadah->CurrentValue = $this->wadah->FormValue;
        $this->bentuk_opsi->CurrentValue = $this->bentuk_opsi->FormValue;
        $this->bentuk_revisi->CurrentValue = $this->bentuk_revisi->FormValue;
        $this->viskositas_opsi->CurrentValue = $this->viskositas_opsi->FormValue;
        $this->viskositas_revisi->CurrentValue = $this->viskositas_revisi->FormValue;
        $this->jeniswarna_opsi->CurrentValue = $this->jeniswarna_opsi->FormValue;
        $this->jeniswarna_revisi->CurrentValue = $this->jeniswarna_revisi->FormValue;
        $this->tonewarna_opsi->CurrentValue = $this->tonewarna_opsi->FormValue;
        $this->tonewarna_revisi->CurrentValue = $this->tonewarna_revisi->FormValue;
        $this->gradasiwarna_opsi->CurrentValue = $this->gradasiwarna_opsi->FormValue;
        $this->gradasiwarna_revisi->CurrentValue = $this->gradasiwarna_revisi->FormValue;
        $this->bauparfum_opsi->CurrentValue = $this->bauparfum_opsi->FormValue;
        $this->bauparfum_revisi->CurrentValue = $this->bauparfum_revisi->FormValue;
        $this->estetika_opsi->CurrentValue = $this->estetika_opsi->FormValue;
        $this->estetika_revisi->CurrentValue = $this->estetika_revisi->FormValue;
        $this->aplikasiawal_opsi->CurrentValue = $this->aplikasiawal_opsi->FormValue;
        $this->aplikasiawal_revisi->CurrentValue = $this->aplikasiawal_revisi->FormValue;
        $this->aplikasilama_opsi->CurrentValue = $this->aplikasilama_opsi->FormValue;
        $this->aplikasilama_revisi->CurrentValue = $this->aplikasilama_revisi->FormValue;
        $this->efekpositif_opsi->CurrentValue = $this->efekpositif_opsi->FormValue;
        $this->efekpositif_revisi->CurrentValue = $this->efekpositif_revisi->FormValue;
        $this->efeknegatif_opsi->CurrentValue = $this->efeknegatif_opsi->FormValue;
        $this->efeknegatif_revisi->CurrentValue = $this->efeknegatif_revisi->FormValue;
        $this->kesimpulan->CurrentValue = $this->kesimpulan->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->ukuran->CurrentValue = $this->ukuran->FormValue;
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->tanggal_review->setDbValue($row['tanggal_review']);
        $this->tanggal_submit->setDbValue($row['tanggal_submit']);
        $this->wadah->setDbValue($row['wadah']);
        $this->bentuk_opsi->setDbValue($row['bentuk_opsi']);
        $this->bentuk_revisi->setDbValue($row['bentuk_revisi']);
        $this->viskositas_opsi->setDbValue($row['viskositas_opsi']);
        $this->viskositas_revisi->setDbValue($row['viskositas_revisi']);
        $this->jeniswarna_opsi->setDbValue($row['jeniswarna_opsi']);
        $this->jeniswarna_revisi->setDbValue($row['jeniswarna_revisi']);
        $this->tonewarna_opsi->setDbValue($row['tonewarna_opsi']);
        $this->tonewarna_revisi->setDbValue($row['tonewarna_revisi']);
        $this->gradasiwarna_opsi->setDbValue($row['gradasiwarna_opsi']);
        $this->gradasiwarna_revisi->setDbValue($row['gradasiwarna_revisi']);
        $this->bauparfum_opsi->setDbValue($row['bauparfum_opsi']);
        $this->bauparfum_revisi->setDbValue($row['bauparfum_revisi']);
        $this->estetika_opsi->setDbValue($row['estetika_opsi']);
        $this->estetika_revisi->setDbValue($row['estetika_revisi']);
        $this->aplikasiawal_opsi->setDbValue($row['aplikasiawal_opsi']);
        $this->aplikasiawal_revisi->setDbValue($row['aplikasiawal_revisi']);
        $this->aplikasilama_opsi->setDbValue($row['aplikasilama_opsi']);
        $this->aplikasilama_revisi->setDbValue($row['aplikasilama_revisi']);
        $this->efekpositif_opsi->setDbValue($row['efekpositif_opsi']);
        $this->efekpositif_revisi->setDbValue($row['efekpositif_revisi']);
        $this->efeknegatif_opsi->setDbValue($row['efeknegatif_opsi']);
        $this->efeknegatif_revisi->setDbValue($row['efeknegatif_revisi']);
        $this->kesimpulan->setDbValue($row['kesimpulan']);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->ukuran->setDbValue($row['ukuran']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['idnpd_sample'] = $this->idnpd_sample->CurrentValue;
        $row['tanggal_review'] = $this->tanggal_review->CurrentValue;
        $row['tanggal_submit'] = $this->tanggal_submit->CurrentValue;
        $row['wadah'] = $this->wadah->CurrentValue;
        $row['bentuk_opsi'] = $this->bentuk_opsi->CurrentValue;
        $row['bentuk_revisi'] = $this->bentuk_revisi->CurrentValue;
        $row['viskositas_opsi'] = $this->viskositas_opsi->CurrentValue;
        $row['viskositas_revisi'] = $this->viskositas_revisi->CurrentValue;
        $row['jeniswarna_opsi'] = $this->jeniswarna_opsi->CurrentValue;
        $row['jeniswarna_revisi'] = $this->jeniswarna_revisi->CurrentValue;
        $row['tonewarna_opsi'] = $this->tonewarna_opsi->CurrentValue;
        $row['tonewarna_revisi'] = $this->tonewarna_revisi->CurrentValue;
        $row['gradasiwarna_opsi'] = $this->gradasiwarna_opsi->CurrentValue;
        $row['gradasiwarna_revisi'] = $this->gradasiwarna_revisi->CurrentValue;
        $row['bauparfum_opsi'] = $this->bauparfum_opsi->CurrentValue;
        $row['bauparfum_revisi'] = $this->bauparfum_revisi->CurrentValue;
        $row['estetika_opsi'] = $this->estetika_opsi->CurrentValue;
        $row['estetika_revisi'] = $this->estetika_revisi->CurrentValue;
        $row['aplikasiawal_opsi'] = $this->aplikasiawal_opsi->CurrentValue;
        $row['aplikasiawal_revisi'] = $this->aplikasiawal_revisi->CurrentValue;
        $row['aplikasilama_opsi'] = $this->aplikasilama_opsi->CurrentValue;
        $row['aplikasilama_revisi'] = $this->aplikasilama_revisi->CurrentValue;
        $row['efekpositif_opsi'] = $this->efekpositif_opsi->CurrentValue;
        $row['efekpositif_revisi'] = $this->efekpositif_revisi->CurrentValue;
        $row['efeknegatif_opsi'] = $this->efeknegatif_opsi->CurrentValue;
        $row['efeknegatif_revisi'] = $this->efeknegatif_revisi->CurrentValue;
        $row['kesimpulan'] = $this->kesimpulan->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
        $row['ukuran'] = $this->ukuran->CurrentValue;
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

        // tanggal_review

        // tanggal_submit

        // wadah

        // bentuk_opsi

        // bentuk_revisi

        // viskositas_opsi

        // viskositas_revisi

        // jeniswarna_opsi

        // jeniswarna_revisi

        // tonewarna_opsi

        // tonewarna_revisi

        // gradasiwarna_opsi

        // gradasiwarna_revisi

        // bauparfum_opsi

        // bauparfum_revisi

        // estetika_opsi

        // estetika_revisi

        // aplikasiawal_opsi

        // aplikasiawal_revisi

        // aplikasilama_opsi

        // aplikasilama_revisi

        // efekpositif_opsi

        // efekpositif_revisi

        // efeknegatif_opsi

        // efeknegatif_revisi

        // kesimpulan

        // status

        // created_at

        // readonly

        // ukuran
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

            // tanggal_review
            $this->tanggal_review->ViewValue = $this->tanggal_review->CurrentValue;
            $this->tanggal_review->ViewValue = FormatDateTime($this->tanggal_review->ViewValue, 0);
            $this->tanggal_review->ViewCustomAttributes = "";

            // tanggal_submit
            $this->tanggal_submit->ViewValue = $this->tanggal_submit->CurrentValue;
            $this->tanggal_submit->ViewValue = FormatDateTime($this->tanggal_submit->ViewValue, 0);
            $this->tanggal_submit->ViewCustomAttributes = "";

            // wadah
            $this->wadah->ViewValue = $this->wadah->CurrentValue;
            $this->wadah->ViewCustomAttributes = "";

            // bentuk_opsi
            if (strval($this->bentuk_opsi->CurrentValue) != "") {
                $this->bentuk_opsi->ViewValue = $this->bentuk_opsi->optionCaption($this->bentuk_opsi->CurrentValue);
            } else {
                $this->bentuk_opsi->ViewValue = null;
            }
            $this->bentuk_opsi->ViewCustomAttributes = "";

            // bentuk_revisi
            $this->bentuk_revisi->ViewValue = $this->bentuk_revisi->CurrentValue;
            $this->bentuk_revisi->ViewCustomAttributes = "";

            // viskositas_opsi
            if (strval($this->viskositas_opsi->CurrentValue) != "") {
                $this->viskositas_opsi->ViewValue = $this->viskositas_opsi->optionCaption($this->viskositas_opsi->CurrentValue);
            } else {
                $this->viskositas_opsi->ViewValue = null;
            }
            $this->viskositas_opsi->ViewCustomAttributes = "";

            // viskositas_revisi
            $this->viskositas_revisi->ViewValue = $this->viskositas_revisi->CurrentValue;
            $this->viskositas_revisi->ViewCustomAttributes = "";

            // jeniswarna_opsi
            if (strval($this->jeniswarna_opsi->CurrentValue) != "") {
                $this->jeniswarna_opsi->ViewValue = $this->jeniswarna_opsi->optionCaption($this->jeniswarna_opsi->CurrentValue);
            } else {
                $this->jeniswarna_opsi->ViewValue = null;
            }
            $this->jeniswarna_opsi->ViewCustomAttributes = "";

            // jeniswarna_revisi
            $this->jeniswarna_revisi->ViewValue = $this->jeniswarna_revisi->CurrentValue;
            $this->jeniswarna_revisi->ViewCustomAttributes = "";

            // tonewarna_opsi
            if (strval($this->tonewarna_opsi->CurrentValue) != "") {
                $this->tonewarna_opsi->ViewValue = $this->tonewarna_opsi->optionCaption($this->tonewarna_opsi->CurrentValue);
            } else {
                $this->tonewarna_opsi->ViewValue = null;
            }
            $this->tonewarna_opsi->ViewCustomAttributes = "";

            // tonewarna_revisi
            $this->tonewarna_revisi->ViewValue = $this->tonewarna_revisi->CurrentValue;
            $this->tonewarna_revisi->ViewCustomAttributes = "";

            // gradasiwarna_opsi
            if (strval($this->gradasiwarna_opsi->CurrentValue) != "") {
                $this->gradasiwarna_opsi->ViewValue = $this->gradasiwarna_opsi->optionCaption($this->gradasiwarna_opsi->CurrentValue);
            } else {
                $this->gradasiwarna_opsi->ViewValue = null;
            }
            $this->gradasiwarna_opsi->ViewCustomAttributes = "";

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->ViewValue = $this->gradasiwarna_revisi->CurrentValue;
            $this->gradasiwarna_revisi->ViewCustomAttributes = "";

            // bauparfum_opsi
            if (strval($this->bauparfum_opsi->CurrentValue) != "") {
                $this->bauparfum_opsi->ViewValue = $this->bauparfum_opsi->optionCaption($this->bauparfum_opsi->CurrentValue);
            } else {
                $this->bauparfum_opsi->ViewValue = null;
            }
            $this->bauparfum_opsi->ViewCustomAttributes = "";

            // bauparfum_revisi
            $this->bauparfum_revisi->ViewValue = $this->bauparfum_revisi->CurrentValue;
            $this->bauparfum_revisi->ViewCustomAttributes = "";

            // estetika_opsi
            if (strval($this->estetika_opsi->CurrentValue) != "") {
                $this->estetika_opsi->ViewValue = $this->estetika_opsi->optionCaption($this->estetika_opsi->CurrentValue);
            } else {
                $this->estetika_opsi->ViewValue = null;
            }
            $this->estetika_opsi->ViewCustomAttributes = "";

            // estetika_revisi
            $this->estetika_revisi->ViewValue = $this->estetika_revisi->CurrentValue;
            $this->estetika_revisi->ViewCustomAttributes = "";

            // aplikasiawal_opsi
            if (strval($this->aplikasiawal_opsi->CurrentValue) != "") {
                $this->aplikasiawal_opsi->ViewValue = $this->aplikasiawal_opsi->optionCaption($this->aplikasiawal_opsi->CurrentValue);
            } else {
                $this->aplikasiawal_opsi->ViewValue = null;
            }
            $this->aplikasiawal_opsi->ViewCustomAttributes = "";

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->ViewValue = $this->aplikasiawal_revisi->CurrentValue;
            $this->aplikasiawal_revisi->ViewCustomAttributes = "";

            // aplikasilama_opsi
            if (strval($this->aplikasilama_opsi->CurrentValue) != "") {
                $this->aplikasilama_opsi->ViewValue = $this->aplikasilama_opsi->optionCaption($this->aplikasilama_opsi->CurrentValue);
            } else {
                $this->aplikasilama_opsi->ViewValue = null;
            }
            $this->aplikasilama_opsi->ViewCustomAttributes = "";

            // aplikasilama_revisi
            $this->aplikasilama_revisi->ViewValue = $this->aplikasilama_revisi->CurrentValue;
            $this->aplikasilama_revisi->ViewCustomAttributes = "";

            // efekpositif_opsi
            if (strval($this->efekpositif_opsi->CurrentValue) != "") {
                $this->efekpositif_opsi->ViewValue = $this->efekpositif_opsi->optionCaption($this->efekpositif_opsi->CurrentValue);
            } else {
                $this->efekpositif_opsi->ViewValue = null;
            }
            $this->efekpositif_opsi->ViewCustomAttributes = "";

            // efekpositif_revisi
            $this->efekpositif_revisi->ViewValue = $this->efekpositif_revisi->CurrentValue;
            $this->efekpositif_revisi->ViewCustomAttributes = "";

            // efeknegatif_opsi
            if (strval($this->efeknegatif_opsi->CurrentValue) != "") {
                $this->efeknegatif_opsi->ViewValue = $this->efeknegatif_opsi->optionCaption($this->efeknegatif_opsi->CurrentValue);
            } else {
                $this->efeknegatif_opsi->ViewValue = null;
            }
            $this->efeknegatif_opsi->ViewCustomAttributes = "";

            // efeknegatif_revisi
            $this->efeknegatif_revisi->ViewValue = $this->efeknegatif_revisi->CurrentValue;
            $this->efeknegatif_revisi->ViewCustomAttributes = "";

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

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // tanggal_review
            $this->tanggal_review->LinkCustomAttributes = "";
            $this->tanggal_review->HrefValue = "";
            $this->tanggal_review->TooltipValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";
            $this->tanggal_submit->TooltipValue = "";

            // wadah
            $this->wadah->LinkCustomAttributes = "";
            $this->wadah->HrefValue = "";
            $this->wadah->TooltipValue = "";

            // bentuk_opsi
            $this->bentuk_opsi->LinkCustomAttributes = "";
            $this->bentuk_opsi->HrefValue = "";
            $this->bentuk_opsi->TooltipValue = "";

            // bentuk_revisi
            $this->bentuk_revisi->LinkCustomAttributes = "";
            $this->bentuk_revisi->HrefValue = "";
            $this->bentuk_revisi->TooltipValue = "";

            // viskositas_opsi
            $this->viskositas_opsi->LinkCustomAttributes = "";
            $this->viskositas_opsi->HrefValue = "";
            $this->viskositas_opsi->TooltipValue = "";

            // viskositas_revisi
            $this->viskositas_revisi->LinkCustomAttributes = "";
            $this->viskositas_revisi->HrefValue = "";
            $this->viskositas_revisi->TooltipValue = "";

            // jeniswarna_opsi
            $this->jeniswarna_opsi->LinkCustomAttributes = "";
            $this->jeniswarna_opsi->HrefValue = "";
            $this->jeniswarna_opsi->TooltipValue = "";

            // jeniswarna_revisi
            $this->jeniswarna_revisi->LinkCustomAttributes = "";
            $this->jeniswarna_revisi->HrefValue = "";
            $this->jeniswarna_revisi->TooltipValue = "";

            // tonewarna_opsi
            $this->tonewarna_opsi->LinkCustomAttributes = "";
            $this->tonewarna_opsi->HrefValue = "";
            $this->tonewarna_opsi->TooltipValue = "";

            // tonewarna_revisi
            $this->tonewarna_revisi->LinkCustomAttributes = "";
            $this->tonewarna_revisi->HrefValue = "";
            $this->tonewarna_revisi->TooltipValue = "";

            // gradasiwarna_opsi
            $this->gradasiwarna_opsi->LinkCustomAttributes = "";
            $this->gradasiwarna_opsi->HrefValue = "";
            $this->gradasiwarna_opsi->TooltipValue = "";

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->LinkCustomAttributes = "";
            $this->gradasiwarna_revisi->HrefValue = "";
            $this->gradasiwarna_revisi->TooltipValue = "";

            // bauparfum_opsi
            $this->bauparfum_opsi->LinkCustomAttributes = "";
            $this->bauparfum_opsi->HrefValue = "";
            $this->bauparfum_opsi->TooltipValue = "";

            // bauparfum_revisi
            $this->bauparfum_revisi->LinkCustomAttributes = "";
            $this->bauparfum_revisi->HrefValue = "";
            $this->bauparfum_revisi->TooltipValue = "";

            // estetika_opsi
            $this->estetika_opsi->LinkCustomAttributes = "";
            $this->estetika_opsi->HrefValue = "";
            $this->estetika_opsi->TooltipValue = "";

            // estetika_revisi
            $this->estetika_revisi->LinkCustomAttributes = "";
            $this->estetika_revisi->HrefValue = "";
            $this->estetika_revisi->TooltipValue = "";

            // aplikasiawal_opsi
            $this->aplikasiawal_opsi->LinkCustomAttributes = "";
            $this->aplikasiawal_opsi->HrefValue = "";
            $this->aplikasiawal_opsi->TooltipValue = "";

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->LinkCustomAttributes = "";
            $this->aplikasiawal_revisi->HrefValue = "";
            $this->aplikasiawal_revisi->TooltipValue = "";

            // aplikasilama_opsi
            $this->aplikasilama_opsi->LinkCustomAttributes = "";
            $this->aplikasilama_opsi->HrefValue = "";
            $this->aplikasilama_opsi->TooltipValue = "";

            // aplikasilama_revisi
            $this->aplikasilama_revisi->LinkCustomAttributes = "";
            $this->aplikasilama_revisi->HrefValue = "";
            $this->aplikasilama_revisi->TooltipValue = "";

            // efekpositif_opsi
            $this->efekpositif_opsi->LinkCustomAttributes = "";
            $this->efekpositif_opsi->HrefValue = "";
            $this->efekpositif_opsi->TooltipValue = "";

            // efekpositif_revisi
            $this->efekpositif_revisi->LinkCustomAttributes = "";
            $this->efekpositif_revisi->HrefValue = "";
            $this->efekpositif_revisi->TooltipValue = "";

            // efeknegatif_opsi
            $this->efeknegatif_opsi->LinkCustomAttributes = "";
            $this->efeknegatif_opsi->HrefValue = "";
            $this->efeknegatif_opsi->TooltipValue = "";

            // efeknegatif_revisi
            $this->efeknegatif_revisi->LinkCustomAttributes = "";
            $this->efeknegatif_revisi->HrefValue = "";
            $this->efeknegatif_revisi->TooltipValue = "";

            // kesimpulan
            $this->kesimpulan->LinkCustomAttributes = "";
            $this->kesimpulan->HrefValue = "";
            $this->kesimpulan->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";
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

            // tanggal_review
            $this->tanggal_review->EditAttrs["class"] = "form-control";
            $this->tanggal_review->EditCustomAttributes = "";
            $this->tanggal_review->EditValue = HtmlEncode(FormatDateTime($this->tanggal_review->CurrentValue, 8));
            $this->tanggal_review->PlaceHolder = RemoveHtml($this->tanggal_review->caption());

            // tanggal_submit
            $this->tanggal_submit->EditAttrs["class"] = "form-control";
            $this->tanggal_submit->EditCustomAttributes = "";
            $this->tanggal_submit->EditValue = HtmlEncode(FormatDateTime($this->tanggal_submit->CurrentValue, 8));
            $this->tanggal_submit->PlaceHolder = RemoveHtml($this->tanggal_submit->caption());

            // wadah
            $this->wadah->EditAttrs["class"] = "form-control";
            $this->wadah->EditCustomAttributes = "";
            if (!$this->wadah->Raw) {
                $this->wadah->CurrentValue = HtmlDecode($this->wadah->CurrentValue);
            }
            $this->wadah->EditValue = HtmlEncode($this->wadah->CurrentValue);
            $this->wadah->PlaceHolder = RemoveHtml($this->wadah->caption());

            // bentuk_opsi
            $this->bentuk_opsi->EditCustomAttributes = "";
            $this->bentuk_opsi->EditValue = $this->bentuk_opsi->options(false);
            $this->bentuk_opsi->PlaceHolder = RemoveHtml($this->bentuk_opsi->caption());

            // bentuk_revisi
            $this->bentuk_revisi->EditAttrs["class"] = "form-control";
            $this->bentuk_revisi->EditCustomAttributes = "";
            if (!$this->bentuk_revisi->Raw) {
                $this->bentuk_revisi->CurrentValue = HtmlDecode($this->bentuk_revisi->CurrentValue);
            }
            $this->bentuk_revisi->EditValue = HtmlEncode($this->bentuk_revisi->CurrentValue);
            $this->bentuk_revisi->PlaceHolder = RemoveHtml($this->bentuk_revisi->caption());

            // viskositas_opsi
            $this->viskositas_opsi->EditCustomAttributes = "";
            $this->viskositas_opsi->EditValue = $this->viskositas_opsi->options(false);
            $this->viskositas_opsi->PlaceHolder = RemoveHtml($this->viskositas_opsi->caption());

            // viskositas_revisi
            $this->viskositas_revisi->EditAttrs["class"] = "form-control";
            $this->viskositas_revisi->EditCustomAttributes = "";
            if (!$this->viskositas_revisi->Raw) {
                $this->viskositas_revisi->CurrentValue = HtmlDecode($this->viskositas_revisi->CurrentValue);
            }
            $this->viskositas_revisi->EditValue = HtmlEncode($this->viskositas_revisi->CurrentValue);
            $this->viskositas_revisi->PlaceHolder = RemoveHtml($this->viskositas_revisi->caption());

            // jeniswarna_opsi
            $this->jeniswarna_opsi->EditCustomAttributes = "";
            $this->jeniswarna_opsi->EditValue = $this->jeniswarna_opsi->options(false);
            $this->jeniswarna_opsi->PlaceHolder = RemoveHtml($this->jeniswarna_opsi->caption());

            // jeniswarna_revisi
            $this->jeniswarna_revisi->EditAttrs["class"] = "form-control";
            $this->jeniswarna_revisi->EditCustomAttributes = "";
            if (!$this->jeniswarna_revisi->Raw) {
                $this->jeniswarna_revisi->CurrentValue = HtmlDecode($this->jeniswarna_revisi->CurrentValue);
            }
            $this->jeniswarna_revisi->EditValue = HtmlEncode($this->jeniswarna_revisi->CurrentValue);
            $this->jeniswarna_revisi->PlaceHolder = RemoveHtml($this->jeniswarna_revisi->caption());

            // tonewarna_opsi
            $this->tonewarna_opsi->EditCustomAttributes = "";
            $this->tonewarna_opsi->EditValue = $this->tonewarna_opsi->options(false);
            $this->tonewarna_opsi->PlaceHolder = RemoveHtml($this->tonewarna_opsi->caption());

            // tonewarna_revisi
            $this->tonewarna_revisi->EditAttrs["class"] = "form-control";
            $this->tonewarna_revisi->EditCustomAttributes = "";
            if (!$this->tonewarna_revisi->Raw) {
                $this->tonewarna_revisi->CurrentValue = HtmlDecode($this->tonewarna_revisi->CurrentValue);
            }
            $this->tonewarna_revisi->EditValue = HtmlEncode($this->tonewarna_revisi->CurrentValue);
            $this->tonewarna_revisi->PlaceHolder = RemoveHtml($this->tonewarna_revisi->caption());

            // gradasiwarna_opsi
            $this->gradasiwarna_opsi->EditCustomAttributes = "";
            $this->gradasiwarna_opsi->EditValue = $this->gradasiwarna_opsi->options(false);
            $this->gradasiwarna_opsi->PlaceHolder = RemoveHtml($this->gradasiwarna_opsi->caption());

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->EditAttrs["class"] = "form-control";
            $this->gradasiwarna_revisi->EditCustomAttributes = "";
            if (!$this->gradasiwarna_revisi->Raw) {
                $this->gradasiwarna_revisi->CurrentValue = HtmlDecode($this->gradasiwarna_revisi->CurrentValue);
            }
            $this->gradasiwarna_revisi->EditValue = HtmlEncode($this->gradasiwarna_revisi->CurrentValue);
            $this->gradasiwarna_revisi->PlaceHolder = RemoveHtml($this->gradasiwarna_revisi->caption());

            // bauparfum_opsi
            $this->bauparfum_opsi->EditCustomAttributes = "";
            $this->bauparfum_opsi->EditValue = $this->bauparfum_opsi->options(false);
            $this->bauparfum_opsi->PlaceHolder = RemoveHtml($this->bauparfum_opsi->caption());

            // bauparfum_revisi
            $this->bauparfum_revisi->EditAttrs["class"] = "form-control";
            $this->bauparfum_revisi->EditCustomAttributes = "";
            if (!$this->bauparfum_revisi->Raw) {
                $this->bauparfum_revisi->CurrentValue = HtmlDecode($this->bauparfum_revisi->CurrentValue);
            }
            $this->bauparfum_revisi->EditValue = HtmlEncode($this->bauparfum_revisi->CurrentValue);
            $this->bauparfum_revisi->PlaceHolder = RemoveHtml($this->bauparfum_revisi->caption());

            // estetika_opsi
            $this->estetika_opsi->EditCustomAttributes = "";
            $this->estetika_opsi->EditValue = $this->estetika_opsi->options(false);
            $this->estetika_opsi->PlaceHolder = RemoveHtml($this->estetika_opsi->caption());

            // estetika_revisi
            $this->estetika_revisi->EditAttrs["class"] = "form-control";
            $this->estetika_revisi->EditCustomAttributes = "";
            if (!$this->estetika_revisi->Raw) {
                $this->estetika_revisi->CurrentValue = HtmlDecode($this->estetika_revisi->CurrentValue);
            }
            $this->estetika_revisi->EditValue = HtmlEncode($this->estetika_revisi->CurrentValue);
            $this->estetika_revisi->PlaceHolder = RemoveHtml($this->estetika_revisi->caption());

            // aplikasiawal_opsi
            $this->aplikasiawal_opsi->EditCustomAttributes = "";
            $this->aplikasiawal_opsi->EditValue = $this->aplikasiawal_opsi->options(false);
            $this->aplikasiawal_opsi->PlaceHolder = RemoveHtml($this->aplikasiawal_opsi->caption());

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->EditAttrs["class"] = "form-control";
            $this->aplikasiawal_revisi->EditCustomAttributes = "";
            if (!$this->aplikasiawal_revisi->Raw) {
                $this->aplikasiawal_revisi->CurrentValue = HtmlDecode($this->aplikasiawal_revisi->CurrentValue);
            }
            $this->aplikasiawal_revisi->EditValue = HtmlEncode($this->aplikasiawal_revisi->CurrentValue);
            $this->aplikasiawal_revisi->PlaceHolder = RemoveHtml($this->aplikasiawal_revisi->caption());

            // aplikasilama_opsi
            $this->aplikasilama_opsi->EditCustomAttributes = "";
            $this->aplikasilama_opsi->EditValue = $this->aplikasilama_opsi->options(false);
            $this->aplikasilama_opsi->PlaceHolder = RemoveHtml($this->aplikasilama_opsi->caption());

            // aplikasilama_revisi
            $this->aplikasilama_revisi->EditAttrs["class"] = "form-control";
            $this->aplikasilama_revisi->EditCustomAttributes = "";
            if (!$this->aplikasilama_revisi->Raw) {
                $this->aplikasilama_revisi->CurrentValue = HtmlDecode($this->aplikasilama_revisi->CurrentValue);
            }
            $this->aplikasilama_revisi->EditValue = HtmlEncode($this->aplikasilama_revisi->CurrentValue);
            $this->aplikasilama_revisi->PlaceHolder = RemoveHtml($this->aplikasilama_revisi->caption());

            // efekpositif_opsi
            $this->efekpositif_opsi->EditCustomAttributes = "";
            $this->efekpositif_opsi->EditValue = $this->efekpositif_opsi->options(false);
            $this->efekpositif_opsi->PlaceHolder = RemoveHtml($this->efekpositif_opsi->caption());

            // efekpositif_revisi
            $this->efekpositif_revisi->EditAttrs["class"] = "form-control";
            $this->efekpositif_revisi->EditCustomAttributes = "";
            if (!$this->efekpositif_revisi->Raw) {
                $this->efekpositif_revisi->CurrentValue = HtmlDecode($this->efekpositif_revisi->CurrentValue);
            }
            $this->efekpositif_revisi->EditValue = HtmlEncode($this->efekpositif_revisi->CurrentValue);
            $this->efekpositif_revisi->PlaceHolder = RemoveHtml($this->efekpositif_revisi->caption());

            // efeknegatif_opsi
            $this->efeknegatif_opsi->EditCustomAttributes = "";
            $this->efeknegatif_opsi->EditValue = $this->efeknegatif_opsi->options(false);
            $this->efeknegatif_opsi->PlaceHolder = RemoveHtml($this->efeknegatif_opsi->caption());

            // efeknegatif_revisi
            $this->efeknegatif_revisi->EditAttrs["class"] = "form-control";
            $this->efeknegatif_revisi->EditCustomAttributes = "";
            if (!$this->efeknegatif_revisi->Raw) {
                $this->efeknegatif_revisi->CurrentValue = HtmlDecode($this->efeknegatif_revisi->CurrentValue);
            }
            $this->efeknegatif_revisi->EditValue = HtmlEncode($this->efeknegatif_revisi->CurrentValue);
            $this->efeknegatif_revisi->PlaceHolder = RemoveHtml($this->efeknegatif_revisi->caption());

            // kesimpulan
            $this->kesimpulan->EditAttrs["class"] = "form-control";
            $this->kesimpulan->EditCustomAttributes = "";
            $this->kesimpulan->EditValue = HtmlEncode($this->kesimpulan->CurrentValue);
            $this->kesimpulan->PlaceHolder = RemoveHtml($this->kesimpulan->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // ukuran
            $this->ukuran->EditAttrs["class"] = "form-control";
            $this->ukuran->EditCustomAttributes = "";
            if (!$this->ukuran->Raw) {
                $this->ukuran->CurrentValue = HtmlDecode($this->ukuran->CurrentValue);
            }
            $this->ukuran->EditValue = HtmlEncode($this->ukuran->CurrentValue);
            $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";

            // tanggal_review
            $this->tanggal_review->LinkCustomAttributes = "";
            $this->tanggal_review->HrefValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";

            // wadah
            $this->wadah->LinkCustomAttributes = "";
            $this->wadah->HrefValue = "";

            // bentuk_opsi
            $this->bentuk_opsi->LinkCustomAttributes = "";
            $this->bentuk_opsi->HrefValue = "";

            // bentuk_revisi
            $this->bentuk_revisi->LinkCustomAttributes = "";
            $this->bentuk_revisi->HrefValue = "";

            // viskositas_opsi
            $this->viskositas_opsi->LinkCustomAttributes = "";
            $this->viskositas_opsi->HrefValue = "";

            // viskositas_revisi
            $this->viskositas_revisi->LinkCustomAttributes = "";
            $this->viskositas_revisi->HrefValue = "";

            // jeniswarna_opsi
            $this->jeniswarna_opsi->LinkCustomAttributes = "";
            $this->jeniswarna_opsi->HrefValue = "";

            // jeniswarna_revisi
            $this->jeniswarna_revisi->LinkCustomAttributes = "";
            $this->jeniswarna_revisi->HrefValue = "";

            // tonewarna_opsi
            $this->tonewarna_opsi->LinkCustomAttributes = "";
            $this->tonewarna_opsi->HrefValue = "";

            // tonewarna_revisi
            $this->tonewarna_revisi->LinkCustomAttributes = "";
            $this->tonewarna_revisi->HrefValue = "";

            // gradasiwarna_opsi
            $this->gradasiwarna_opsi->LinkCustomAttributes = "";
            $this->gradasiwarna_opsi->HrefValue = "";

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->LinkCustomAttributes = "";
            $this->gradasiwarna_revisi->HrefValue = "";

            // bauparfum_opsi
            $this->bauparfum_opsi->LinkCustomAttributes = "";
            $this->bauparfum_opsi->HrefValue = "";

            // bauparfum_revisi
            $this->bauparfum_revisi->LinkCustomAttributes = "";
            $this->bauparfum_revisi->HrefValue = "";

            // estetika_opsi
            $this->estetika_opsi->LinkCustomAttributes = "";
            $this->estetika_opsi->HrefValue = "";

            // estetika_revisi
            $this->estetika_revisi->LinkCustomAttributes = "";
            $this->estetika_revisi->HrefValue = "";

            // aplikasiawal_opsi
            $this->aplikasiawal_opsi->LinkCustomAttributes = "";
            $this->aplikasiawal_opsi->HrefValue = "";

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->LinkCustomAttributes = "";
            $this->aplikasiawal_revisi->HrefValue = "";

            // aplikasilama_opsi
            $this->aplikasilama_opsi->LinkCustomAttributes = "";
            $this->aplikasilama_opsi->HrefValue = "";

            // aplikasilama_revisi
            $this->aplikasilama_revisi->LinkCustomAttributes = "";
            $this->aplikasilama_revisi->HrefValue = "";

            // efekpositif_opsi
            $this->efekpositif_opsi->LinkCustomAttributes = "";
            $this->efekpositif_opsi->HrefValue = "";

            // efekpositif_revisi
            $this->efekpositif_revisi->LinkCustomAttributes = "";
            $this->efekpositif_revisi->HrefValue = "";

            // efeknegatif_opsi
            $this->efeknegatif_opsi->LinkCustomAttributes = "";
            $this->efeknegatif_opsi->HrefValue = "";

            // efeknegatif_revisi
            $this->efeknegatif_revisi->LinkCustomAttributes = "";
            $this->efeknegatif_revisi->HrefValue = "";

            // kesimpulan
            $this->kesimpulan->LinkCustomAttributes = "";
            $this->kesimpulan->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
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
        if ($this->tanggal_review->Required) {
            if (!$this->tanggal_review->IsDetailKey && EmptyValue($this->tanggal_review->FormValue)) {
                $this->tanggal_review->addErrorMessage(str_replace("%s", $this->tanggal_review->caption(), $this->tanggal_review->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_review->FormValue)) {
            $this->tanggal_review->addErrorMessage($this->tanggal_review->getErrorMessage(false));
        }
        if ($this->tanggal_submit->Required) {
            if (!$this->tanggal_submit->IsDetailKey && EmptyValue($this->tanggal_submit->FormValue)) {
                $this->tanggal_submit->addErrorMessage(str_replace("%s", $this->tanggal_submit->caption(), $this->tanggal_submit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_submit->FormValue)) {
            $this->tanggal_submit->addErrorMessage($this->tanggal_submit->getErrorMessage(false));
        }
        if ($this->wadah->Required) {
            if (!$this->wadah->IsDetailKey && EmptyValue($this->wadah->FormValue)) {
                $this->wadah->addErrorMessage(str_replace("%s", $this->wadah->caption(), $this->wadah->RequiredErrorMessage));
            }
        }
        if ($this->bentuk_opsi->Required) {
            if ($this->bentuk_opsi->FormValue == "") {
                $this->bentuk_opsi->addErrorMessage(str_replace("%s", $this->bentuk_opsi->caption(), $this->bentuk_opsi->RequiredErrorMessage));
            }
        }
        if ($this->bentuk_revisi->Required) {
            if (!$this->bentuk_revisi->IsDetailKey && EmptyValue($this->bentuk_revisi->FormValue)) {
                $this->bentuk_revisi->addErrorMessage(str_replace("%s", $this->bentuk_revisi->caption(), $this->bentuk_revisi->RequiredErrorMessage));
            }
        }
        if ($this->viskositas_opsi->Required) {
            if ($this->viskositas_opsi->FormValue == "") {
                $this->viskositas_opsi->addErrorMessage(str_replace("%s", $this->viskositas_opsi->caption(), $this->viskositas_opsi->RequiredErrorMessage));
            }
        }
        if ($this->viskositas_revisi->Required) {
            if (!$this->viskositas_revisi->IsDetailKey && EmptyValue($this->viskositas_revisi->FormValue)) {
                $this->viskositas_revisi->addErrorMessage(str_replace("%s", $this->viskositas_revisi->caption(), $this->viskositas_revisi->RequiredErrorMessage));
            }
        }
        if ($this->jeniswarna_opsi->Required) {
            if ($this->jeniswarna_opsi->FormValue == "") {
                $this->jeniswarna_opsi->addErrorMessage(str_replace("%s", $this->jeniswarna_opsi->caption(), $this->jeniswarna_opsi->RequiredErrorMessage));
            }
        }
        if ($this->jeniswarna_revisi->Required) {
            if (!$this->jeniswarna_revisi->IsDetailKey && EmptyValue($this->jeniswarna_revisi->FormValue)) {
                $this->jeniswarna_revisi->addErrorMessage(str_replace("%s", $this->jeniswarna_revisi->caption(), $this->jeniswarna_revisi->RequiredErrorMessage));
            }
        }
        if ($this->tonewarna_opsi->Required) {
            if ($this->tonewarna_opsi->FormValue == "") {
                $this->tonewarna_opsi->addErrorMessage(str_replace("%s", $this->tonewarna_opsi->caption(), $this->tonewarna_opsi->RequiredErrorMessage));
            }
        }
        if ($this->tonewarna_revisi->Required) {
            if (!$this->tonewarna_revisi->IsDetailKey && EmptyValue($this->tonewarna_revisi->FormValue)) {
                $this->tonewarna_revisi->addErrorMessage(str_replace("%s", $this->tonewarna_revisi->caption(), $this->tonewarna_revisi->RequiredErrorMessage));
            }
        }
        if ($this->gradasiwarna_opsi->Required) {
            if ($this->gradasiwarna_opsi->FormValue == "") {
                $this->gradasiwarna_opsi->addErrorMessage(str_replace("%s", $this->gradasiwarna_opsi->caption(), $this->gradasiwarna_opsi->RequiredErrorMessage));
            }
        }
        if ($this->gradasiwarna_revisi->Required) {
            if (!$this->gradasiwarna_revisi->IsDetailKey && EmptyValue($this->gradasiwarna_revisi->FormValue)) {
                $this->gradasiwarna_revisi->addErrorMessage(str_replace("%s", $this->gradasiwarna_revisi->caption(), $this->gradasiwarna_revisi->RequiredErrorMessage));
            }
        }
        if ($this->bauparfum_opsi->Required) {
            if ($this->bauparfum_opsi->FormValue == "") {
                $this->bauparfum_opsi->addErrorMessage(str_replace("%s", $this->bauparfum_opsi->caption(), $this->bauparfum_opsi->RequiredErrorMessage));
            }
        }
        if ($this->bauparfum_revisi->Required) {
            if (!$this->bauparfum_revisi->IsDetailKey && EmptyValue($this->bauparfum_revisi->FormValue)) {
                $this->bauparfum_revisi->addErrorMessage(str_replace("%s", $this->bauparfum_revisi->caption(), $this->bauparfum_revisi->RequiredErrorMessage));
            }
        }
        if ($this->estetika_opsi->Required) {
            if ($this->estetika_opsi->FormValue == "") {
                $this->estetika_opsi->addErrorMessage(str_replace("%s", $this->estetika_opsi->caption(), $this->estetika_opsi->RequiredErrorMessage));
            }
        }
        if ($this->estetika_revisi->Required) {
            if (!$this->estetika_revisi->IsDetailKey && EmptyValue($this->estetika_revisi->FormValue)) {
                $this->estetika_revisi->addErrorMessage(str_replace("%s", $this->estetika_revisi->caption(), $this->estetika_revisi->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiawal_opsi->Required) {
            if ($this->aplikasiawal_opsi->FormValue == "") {
                $this->aplikasiawal_opsi->addErrorMessage(str_replace("%s", $this->aplikasiawal_opsi->caption(), $this->aplikasiawal_opsi->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiawal_revisi->Required) {
            if (!$this->aplikasiawal_revisi->IsDetailKey && EmptyValue($this->aplikasiawal_revisi->FormValue)) {
                $this->aplikasiawal_revisi->addErrorMessage(str_replace("%s", $this->aplikasiawal_revisi->caption(), $this->aplikasiawal_revisi->RequiredErrorMessage));
            }
        }
        if ($this->aplikasilama_opsi->Required) {
            if ($this->aplikasilama_opsi->FormValue == "") {
                $this->aplikasilama_opsi->addErrorMessage(str_replace("%s", $this->aplikasilama_opsi->caption(), $this->aplikasilama_opsi->RequiredErrorMessage));
            }
        }
        if ($this->aplikasilama_revisi->Required) {
            if (!$this->aplikasilama_revisi->IsDetailKey && EmptyValue($this->aplikasilama_revisi->FormValue)) {
                $this->aplikasilama_revisi->addErrorMessage(str_replace("%s", $this->aplikasilama_revisi->caption(), $this->aplikasilama_revisi->RequiredErrorMessage));
            }
        }
        if ($this->efekpositif_opsi->Required) {
            if ($this->efekpositif_opsi->FormValue == "") {
                $this->efekpositif_opsi->addErrorMessage(str_replace("%s", $this->efekpositif_opsi->caption(), $this->efekpositif_opsi->RequiredErrorMessage));
            }
        }
        if ($this->efekpositif_revisi->Required) {
            if (!$this->efekpositif_revisi->IsDetailKey && EmptyValue($this->efekpositif_revisi->FormValue)) {
                $this->efekpositif_revisi->addErrorMessage(str_replace("%s", $this->efekpositif_revisi->caption(), $this->efekpositif_revisi->RequiredErrorMessage));
            }
        }
        if ($this->efeknegatif_opsi->Required) {
            if ($this->efeknegatif_opsi->FormValue == "") {
                $this->efeknegatif_opsi->addErrorMessage(str_replace("%s", $this->efeknegatif_opsi->caption(), $this->efeknegatif_opsi->RequiredErrorMessage));
            }
        }
        if ($this->efeknegatif_revisi->Required) {
            if (!$this->efeknegatif_revisi->IsDetailKey && EmptyValue($this->efeknegatif_revisi->FormValue)) {
                $this->efeknegatif_revisi->addErrorMessage(str_replace("%s", $this->efeknegatif_revisi->caption(), $this->efeknegatif_revisi->RequiredErrorMessage));
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
        if ($this->ukuran->Required) {
            if (!$this->ukuran->IsDetailKey && EmptyValue($this->ukuran->FormValue)) {
                $this->ukuran->addErrorMessage(str_replace("%s", $this->ukuran->caption(), $this->ukuran->RequiredErrorMessage));
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
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, strval($this->idnpd->CurrentValue) == "");

        // idnpd_sample
        $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, strval($this->idnpd_sample->CurrentValue) == "");

        // tanggal_review
        $this->tanggal_review->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_review->CurrentValue, 0), CurrentDate(), false);

        // tanggal_submit
        $this->tanggal_submit->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_submit->CurrentValue, 0), CurrentDate(), false);

        // wadah
        $this->wadah->setDbValueDef($rsnew, $this->wadah->CurrentValue, null, false);

        // bentuk_opsi
        $this->bentuk_opsi->setDbValueDef($rsnew, $this->bentuk_opsi->CurrentValue, 0, false);

        // bentuk_revisi
        $this->bentuk_revisi->setDbValueDef($rsnew, $this->bentuk_revisi->CurrentValue, null, false);

        // viskositas_opsi
        $this->viskositas_opsi->setDbValueDef($rsnew, $this->viskositas_opsi->CurrentValue, 0, false);

        // viskositas_revisi
        $this->viskositas_revisi->setDbValueDef($rsnew, $this->viskositas_revisi->CurrentValue, null, false);

        // jeniswarna_opsi
        $this->jeniswarna_opsi->setDbValueDef($rsnew, $this->jeniswarna_opsi->CurrentValue, 0, false);

        // jeniswarna_revisi
        $this->jeniswarna_revisi->setDbValueDef($rsnew, $this->jeniswarna_revisi->CurrentValue, null, false);

        // tonewarna_opsi
        $this->tonewarna_opsi->setDbValueDef($rsnew, $this->tonewarna_opsi->CurrentValue, 0, false);

        // tonewarna_revisi
        $this->tonewarna_revisi->setDbValueDef($rsnew, $this->tonewarna_revisi->CurrentValue, null, false);

        // gradasiwarna_opsi
        $this->gradasiwarna_opsi->setDbValueDef($rsnew, $this->gradasiwarna_opsi->CurrentValue, 0, false);

        // gradasiwarna_revisi
        $this->gradasiwarna_revisi->setDbValueDef($rsnew, $this->gradasiwarna_revisi->CurrentValue, null, false);

        // bauparfum_opsi
        $this->bauparfum_opsi->setDbValueDef($rsnew, $this->bauparfum_opsi->CurrentValue, 0, false);

        // bauparfum_revisi
        $this->bauparfum_revisi->setDbValueDef($rsnew, $this->bauparfum_revisi->CurrentValue, null, false);

        // estetika_opsi
        $this->estetika_opsi->setDbValueDef($rsnew, $this->estetika_opsi->CurrentValue, 0, false);

        // estetika_revisi
        $this->estetika_revisi->setDbValueDef($rsnew, $this->estetika_revisi->CurrentValue, null, false);

        // aplikasiawal_opsi
        $this->aplikasiawal_opsi->setDbValueDef($rsnew, $this->aplikasiawal_opsi->CurrentValue, 0, false);

        // aplikasiawal_revisi
        $this->aplikasiawal_revisi->setDbValueDef($rsnew, $this->aplikasiawal_revisi->CurrentValue, null, false);

        // aplikasilama_opsi
        $this->aplikasilama_opsi->setDbValueDef($rsnew, $this->aplikasilama_opsi->CurrentValue, 0, false);

        // aplikasilama_revisi
        $this->aplikasilama_revisi->setDbValueDef($rsnew, $this->aplikasilama_revisi->CurrentValue, null, false);

        // efekpositif_opsi
        $this->efekpositif_opsi->setDbValueDef($rsnew, $this->efekpositif_opsi->CurrentValue, 0, false);

        // efekpositif_revisi
        $this->efekpositif_revisi->setDbValueDef($rsnew, $this->efekpositif_revisi->CurrentValue, null, false);

        // efeknegatif_opsi
        $this->efeknegatif_opsi->setDbValueDef($rsnew, $this->efeknegatif_opsi->CurrentValue, 0, false);

        // efeknegatif_revisi
        $this->efeknegatif_revisi->setDbValueDef($rsnew, $this->efeknegatif_revisi->CurrentValue, null, false);

        // kesimpulan
        $this->kesimpulan->setDbValueDef($rsnew, $this->kesimpulan->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, 0, false);

        // ukuran
        $this->ukuran->setDbValueDef($rsnew, $this->ukuran->CurrentValue, null, false);

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
                case "x_bentuk_opsi":
                    break;
                case "x_viskositas_opsi":
                    break;
                case "x_jeniswarna_opsi":
                    break;
                case "x_tonewarna_opsi":
                    break;
                case "x_gradasiwarna_opsi":
                    break;
                case "x_bauparfum_opsi":
                    break;
                case "x_estetika_opsi":
                    break;
                case "x_aplikasiawal_opsi":
                    break;
                case "x_aplikasilama_opsi":
                    break;
                case "x_efekpositif_opsi":
                    break;
                case "x_efeknegatif_opsi":
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
