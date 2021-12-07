<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsEdit extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsEdit";

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

        // Table object (npd_terms)
        if (!isset($GLOBALS["npd_terms"]) || get_class($GLOBALS["npd_terms"]) == PROJECT_NAMESPACE . "npd_terms") {
            $GLOBALS["npd_terms"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_terms');
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
                $doc = new $class(Container("npd_terms"));
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
                    if ($pageName == "NpdTermsView") {
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
        $this->id->setVisibility();
        $this->idnpd->setVisibility();
        $this->status->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->sifat_order->setVisibility();
        $this->ukuran_utama->setVisibility();
        $this->utama_harga_isi->setVisibility();
        $this->utama_harga_isi_order->setVisibility();
        $this->utama_harga_primer->setVisibility();
        $this->utama_harga_primer_order->setVisibility();
        $this->utama_harga_sekunder->setVisibility();
        $this->utama_harga_sekunder_order->setVisibility();
        $this->utama_harga_label->setVisibility();
        $this->utama_harga_label_order->setVisibility();
        $this->utama_harga_total->setVisibility();
        $this->utama_harga_total_order->setVisibility();
        $this->ukuran_lain->setVisibility();
        $this->lain_harga_isi->setVisibility();
        $this->lain_harga_isi_order->setVisibility();
        $this->lain_harga_primer->setVisibility();
        $this->lain_harga_primer_order->setVisibility();
        $this->lain_harga_sekunder->setVisibility();
        $this->lain_harga_sekunder_order->setVisibility();
        $this->lain_harga_label->setVisibility();
        $this->lain_harga_label_order->setVisibility();
        $this->lain_harga_total->setVisibility();
        $this->lain_harga_total_order->setVisibility();
        $this->isi_bahan_aktif->setVisibility();
        $this->isi_bahan_lain->setVisibility();
        $this->isi_parfum->setVisibility();
        $this->isi_estetika->setVisibility();
        $this->kemasan_wadah->setVisibility();
        $this->kemasan_tutup->setVisibility();
        $this->kemasan_sekunder->setVisibility();
        $this->label_desain->setVisibility();
        $this->label_cetak->setVisibility();
        $this->label_lainlain->setVisibility();
        $this->delivery_pickup->setVisibility();
        $this->delivery_singlepoint->setVisibility();
        $this->delivery_multipoint->setVisibility();
        $this->delivery_jumlahpoint->setVisibility();
        $this->delivery_termslain->setVisibility();
        $this->catatan_khusus->setVisibility();
        $this->dibuatdi->setVisibility();
        $this->created_at->setVisibility();
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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                    $this->terminate("NpdTermsList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "NpdTermsList") {
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
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

        // Check field name 'sifat_order' first before field var 'x_sifat_order'
        $val = $CurrentForm->hasValue("sifat_order") ? $CurrentForm->getValue("sifat_order") : $CurrentForm->getValue("x_sifat_order");
        if (!$this->sifat_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sifat_order->Visible = false; // Disable update for API request
            } else {
                $this->sifat_order->setFormValue($val);
            }
        }

        // Check field name 'ukuran_utama' first before field var 'x_ukuran_utama'
        $val = $CurrentForm->hasValue("ukuran_utama") ? $CurrentForm->getValue("ukuran_utama") : $CurrentForm->getValue("x_ukuran_utama");
        if (!$this->ukuran_utama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran_utama->Visible = false; // Disable update for API request
            } else {
                $this->ukuran_utama->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_isi' first before field var 'x_utama_harga_isi'
        $val = $CurrentForm->hasValue("utama_harga_isi") ? $CurrentForm->getValue("utama_harga_isi") : $CurrentForm->getValue("x_utama_harga_isi");
        if (!$this->utama_harga_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_isi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_isi->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_isi_order' first before field var 'x_utama_harga_isi_order'
        $val = $CurrentForm->hasValue("utama_harga_isi_order") ? $CurrentForm->getValue("utama_harga_isi_order") : $CurrentForm->getValue("x_utama_harga_isi_order");
        if (!$this->utama_harga_isi_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_isi_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_isi_order->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_primer' first before field var 'x_utama_harga_primer'
        $val = $CurrentForm->hasValue("utama_harga_primer") ? $CurrentForm->getValue("utama_harga_primer") : $CurrentForm->getValue("x_utama_harga_primer");
        if (!$this->utama_harga_primer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_primer->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_primer->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_primer_order' first before field var 'x_utama_harga_primer_order'
        $val = $CurrentForm->hasValue("utama_harga_primer_order") ? $CurrentForm->getValue("utama_harga_primer_order") : $CurrentForm->getValue("x_utama_harga_primer_order");
        if (!$this->utama_harga_primer_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_primer_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_primer_order->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_sekunder' first before field var 'x_utama_harga_sekunder'
        $val = $CurrentForm->hasValue("utama_harga_sekunder") ? $CurrentForm->getValue("utama_harga_sekunder") : $CurrentForm->getValue("x_utama_harga_sekunder");
        if (!$this->utama_harga_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_sekunder->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_sekunder_order' first before field var 'x_utama_harga_sekunder_order'
        $val = $CurrentForm->hasValue("utama_harga_sekunder_order") ? $CurrentForm->getValue("utama_harga_sekunder_order") : $CurrentForm->getValue("x_utama_harga_sekunder_order");
        if (!$this->utama_harga_sekunder_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_sekunder_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_sekunder_order->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_label' first before field var 'x_utama_harga_label'
        $val = $CurrentForm->hasValue("utama_harga_label") ? $CurrentForm->getValue("utama_harga_label") : $CurrentForm->getValue("x_utama_harga_label");
        if (!$this->utama_harga_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_label->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_label->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_label_order' first before field var 'x_utama_harga_label_order'
        $val = $CurrentForm->hasValue("utama_harga_label_order") ? $CurrentForm->getValue("utama_harga_label_order") : $CurrentForm->getValue("x_utama_harga_label_order");
        if (!$this->utama_harga_label_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_label_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_label_order->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_total' first before field var 'x_utama_harga_total'
        $val = $CurrentForm->hasValue("utama_harga_total") ? $CurrentForm->getValue("utama_harga_total") : $CurrentForm->getValue("x_utama_harga_total");
        if (!$this->utama_harga_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_total->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_total->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_total_order' first before field var 'x_utama_harga_total_order'
        $val = $CurrentForm->hasValue("utama_harga_total_order") ? $CurrentForm->getValue("utama_harga_total_order") : $CurrentForm->getValue("x_utama_harga_total_order");
        if (!$this->utama_harga_total_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_total_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_total_order->setFormValue($val);
            }
        }

        // Check field name 'ukuran_lain' first before field var 'x_ukuran_lain'
        $val = $CurrentForm->hasValue("ukuran_lain") ? $CurrentForm->getValue("ukuran_lain") : $CurrentForm->getValue("x_ukuran_lain");
        if (!$this->ukuran_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran_lain->Visible = false; // Disable update for API request
            } else {
                $this->ukuran_lain->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_isi' first before field var 'x_lain_harga_isi'
        $val = $CurrentForm->hasValue("lain_harga_isi") ? $CurrentForm->getValue("lain_harga_isi") : $CurrentForm->getValue("x_lain_harga_isi");
        if (!$this->lain_harga_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_isi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_isi->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_isi_order' first before field var 'x_lain_harga_isi_order'
        $val = $CurrentForm->hasValue("lain_harga_isi_order") ? $CurrentForm->getValue("lain_harga_isi_order") : $CurrentForm->getValue("x_lain_harga_isi_order");
        if (!$this->lain_harga_isi_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_isi_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_isi_order->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_primer' first before field var 'x_lain_harga_primer'
        $val = $CurrentForm->hasValue("lain_harga_primer") ? $CurrentForm->getValue("lain_harga_primer") : $CurrentForm->getValue("x_lain_harga_primer");
        if (!$this->lain_harga_primer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_primer->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_primer->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_primer_order' first before field var 'x_lain_harga_primer_order'
        $val = $CurrentForm->hasValue("lain_harga_primer_order") ? $CurrentForm->getValue("lain_harga_primer_order") : $CurrentForm->getValue("x_lain_harga_primer_order");
        if (!$this->lain_harga_primer_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_primer_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_primer_order->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_sekunder' first before field var 'x_lain_harga_sekunder'
        $val = $CurrentForm->hasValue("lain_harga_sekunder") ? $CurrentForm->getValue("lain_harga_sekunder") : $CurrentForm->getValue("x_lain_harga_sekunder");
        if (!$this->lain_harga_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_sekunder->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_sekunder_order' first before field var 'x_lain_harga_sekunder_order'
        $val = $CurrentForm->hasValue("lain_harga_sekunder_order") ? $CurrentForm->getValue("lain_harga_sekunder_order") : $CurrentForm->getValue("x_lain_harga_sekunder_order");
        if (!$this->lain_harga_sekunder_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_sekunder_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_sekunder_order->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_label' first before field var 'x_lain_harga_label'
        $val = $CurrentForm->hasValue("lain_harga_label") ? $CurrentForm->getValue("lain_harga_label") : $CurrentForm->getValue("x_lain_harga_label");
        if (!$this->lain_harga_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_label->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_label->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_label_order' first before field var 'x_lain_harga_label_order'
        $val = $CurrentForm->hasValue("lain_harga_label_order") ? $CurrentForm->getValue("lain_harga_label_order") : $CurrentForm->getValue("x_lain_harga_label_order");
        if (!$this->lain_harga_label_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_label_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_label_order->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_total' first before field var 'x_lain_harga_total'
        $val = $CurrentForm->hasValue("lain_harga_total") ? $CurrentForm->getValue("lain_harga_total") : $CurrentForm->getValue("x_lain_harga_total");
        if (!$this->lain_harga_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_total->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_total->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_total_order' first before field var 'x_lain_harga_total_order'
        $val = $CurrentForm->hasValue("lain_harga_total_order") ? $CurrentForm->getValue("lain_harga_total_order") : $CurrentForm->getValue("x_lain_harga_total_order");
        if (!$this->lain_harga_total_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_total_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_total_order->setFormValue($val);
            }
        }

        // Check field name 'isi_bahan_aktif' first before field var 'x_isi_bahan_aktif'
        $val = $CurrentForm->hasValue("isi_bahan_aktif") ? $CurrentForm->getValue("isi_bahan_aktif") : $CurrentForm->getValue("x_isi_bahan_aktif");
        if (!$this->isi_bahan_aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_bahan_aktif->Visible = false; // Disable update for API request
            } else {
                $this->isi_bahan_aktif->setFormValue($val);
            }
        }

        // Check field name 'isi_bahan_lain' first before field var 'x_isi_bahan_lain'
        $val = $CurrentForm->hasValue("isi_bahan_lain") ? $CurrentForm->getValue("isi_bahan_lain") : $CurrentForm->getValue("x_isi_bahan_lain");
        if (!$this->isi_bahan_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_bahan_lain->Visible = false; // Disable update for API request
            } else {
                $this->isi_bahan_lain->setFormValue($val);
            }
        }

        // Check field name 'isi_parfum' first before field var 'x_isi_parfum'
        $val = $CurrentForm->hasValue("isi_parfum") ? $CurrentForm->getValue("isi_parfum") : $CurrentForm->getValue("x_isi_parfum");
        if (!$this->isi_parfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_parfum->Visible = false; // Disable update for API request
            } else {
                $this->isi_parfum->setFormValue($val);
            }
        }

        // Check field name 'isi_estetika' first before field var 'x_isi_estetika'
        $val = $CurrentForm->hasValue("isi_estetika") ? $CurrentForm->getValue("isi_estetika") : $CurrentForm->getValue("x_isi_estetika");
        if (!$this->isi_estetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_estetika->Visible = false; // Disable update for API request
            } else {
                $this->isi_estetika->setFormValue($val);
            }
        }

        // Check field name 'kemasan_wadah' first before field var 'x_kemasan_wadah'
        $val = $CurrentForm->hasValue("kemasan_wadah") ? $CurrentForm->getValue("kemasan_wadah") : $CurrentForm->getValue("x_kemasan_wadah");
        if (!$this->kemasan_wadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_wadah->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_wadah->setFormValue($val);
            }
        }

        // Check field name 'kemasan_tutup' first before field var 'x_kemasan_tutup'
        $val = $CurrentForm->hasValue("kemasan_tutup") ? $CurrentForm->getValue("kemasan_tutup") : $CurrentForm->getValue("x_kemasan_tutup");
        if (!$this->kemasan_tutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_tutup->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_tutup->setFormValue($val);
            }
        }

        // Check field name 'kemasan_sekunder' first before field var 'x_kemasan_sekunder'
        $val = $CurrentForm->hasValue("kemasan_sekunder") ? $CurrentForm->getValue("kemasan_sekunder") : $CurrentForm->getValue("x_kemasan_sekunder");
        if (!$this->kemasan_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_sekunder->setFormValue($val);
            }
        }

        // Check field name 'label_desain' first before field var 'x_label_desain'
        $val = $CurrentForm->hasValue("label_desain") ? $CurrentForm->getValue("label_desain") : $CurrentForm->getValue("x_label_desain");
        if (!$this->label_desain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_desain->Visible = false; // Disable update for API request
            } else {
                $this->label_desain->setFormValue($val);
            }
        }

        // Check field name 'label_cetak' first before field var 'x_label_cetak'
        $val = $CurrentForm->hasValue("label_cetak") ? $CurrentForm->getValue("label_cetak") : $CurrentForm->getValue("x_label_cetak");
        if (!$this->label_cetak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_cetak->Visible = false; // Disable update for API request
            } else {
                $this->label_cetak->setFormValue($val);
            }
        }

        // Check field name 'label_lainlain' first before field var 'x_label_lainlain'
        $val = $CurrentForm->hasValue("label_lainlain") ? $CurrentForm->getValue("label_lainlain") : $CurrentForm->getValue("x_label_lainlain");
        if (!$this->label_lainlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_lainlain->Visible = false; // Disable update for API request
            } else {
                $this->label_lainlain->setFormValue($val);
            }
        }

        // Check field name 'delivery_pickup' first before field var 'x_delivery_pickup'
        $val = $CurrentForm->hasValue("delivery_pickup") ? $CurrentForm->getValue("delivery_pickup") : $CurrentForm->getValue("x_delivery_pickup");
        if (!$this->delivery_pickup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_pickup->Visible = false; // Disable update for API request
            } else {
                $this->delivery_pickup->setFormValue($val);
            }
        }

        // Check field name 'delivery_singlepoint' first before field var 'x_delivery_singlepoint'
        $val = $CurrentForm->hasValue("delivery_singlepoint") ? $CurrentForm->getValue("delivery_singlepoint") : $CurrentForm->getValue("x_delivery_singlepoint");
        if (!$this->delivery_singlepoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_singlepoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_singlepoint->setFormValue($val);
            }
        }

        // Check field name 'delivery_multipoint' first before field var 'x_delivery_multipoint'
        $val = $CurrentForm->hasValue("delivery_multipoint") ? $CurrentForm->getValue("delivery_multipoint") : $CurrentForm->getValue("x_delivery_multipoint");
        if (!$this->delivery_multipoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_multipoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_multipoint->setFormValue($val);
            }
        }

        // Check field name 'delivery_jumlahpoint' first before field var 'x_delivery_jumlahpoint'
        $val = $CurrentForm->hasValue("delivery_jumlahpoint") ? $CurrentForm->getValue("delivery_jumlahpoint") : $CurrentForm->getValue("x_delivery_jumlahpoint");
        if (!$this->delivery_jumlahpoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_jumlahpoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_jumlahpoint->setFormValue($val);
            }
        }

        // Check field name 'delivery_termslain' first before field var 'x_delivery_termslain'
        $val = $CurrentForm->hasValue("delivery_termslain") ? $CurrentForm->getValue("delivery_termslain") : $CurrentForm->getValue("x_delivery_termslain");
        if (!$this->delivery_termslain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_termslain->Visible = false; // Disable update for API request
            } else {
                $this->delivery_termslain->setFormValue($val);
            }
        }

        // Check field name 'catatan_khusus' first before field var 'x_catatan_khusus'
        $val = $CurrentForm->hasValue("catatan_khusus") ? $CurrentForm->getValue("catatan_khusus") : $CurrentForm->getValue("x_catatan_khusus");
        if (!$this->catatan_khusus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatan_khusus->Visible = false; // Disable update for API request
            } else {
                $this->catatan_khusus->setFormValue($val);
            }
        }

        // Check field name 'dibuatdi' first before field var 'x_dibuatdi'
        $val = $CurrentForm->hasValue("dibuatdi") ? $CurrentForm->getValue("dibuatdi") : $CurrentForm->getValue("x_dibuatdi");
        if (!$this->dibuatdi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dibuatdi->Visible = false; // Disable update for API request
            } else {
                $this->dibuatdi->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->sifat_order->CurrentValue = $this->sifat_order->FormValue;
        $this->ukuran_utama->CurrentValue = $this->ukuran_utama->FormValue;
        $this->utama_harga_isi->CurrentValue = $this->utama_harga_isi->FormValue;
        $this->utama_harga_isi_order->CurrentValue = $this->utama_harga_isi_order->FormValue;
        $this->utama_harga_primer->CurrentValue = $this->utama_harga_primer->FormValue;
        $this->utama_harga_primer_order->CurrentValue = $this->utama_harga_primer_order->FormValue;
        $this->utama_harga_sekunder->CurrentValue = $this->utama_harga_sekunder->FormValue;
        $this->utama_harga_sekunder_order->CurrentValue = $this->utama_harga_sekunder_order->FormValue;
        $this->utama_harga_label->CurrentValue = $this->utama_harga_label->FormValue;
        $this->utama_harga_label_order->CurrentValue = $this->utama_harga_label_order->FormValue;
        $this->utama_harga_total->CurrentValue = $this->utama_harga_total->FormValue;
        $this->utama_harga_total_order->CurrentValue = $this->utama_harga_total_order->FormValue;
        $this->ukuran_lain->CurrentValue = $this->ukuran_lain->FormValue;
        $this->lain_harga_isi->CurrentValue = $this->lain_harga_isi->FormValue;
        $this->lain_harga_isi_order->CurrentValue = $this->lain_harga_isi_order->FormValue;
        $this->lain_harga_primer->CurrentValue = $this->lain_harga_primer->FormValue;
        $this->lain_harga_primer_order->CurrentValue = $this->lain_harga_primer_order->FormValue;
        $this->lain_harga_sekunder->CurrentValue = $this->lain_harga_sekunder->FormValue;
        $this->lain_harga_sekunder_order->CurrentValue = $this->lain_harga_sekunder_order->FormValue;
        $this->lain_harga_label->CurrentValue = $this->lain_harga_label->FormValue;
        $this->lain_harga_label_order->CurrentValue = $this->lain_harga_label_order->FormValue;
        $this->lain_harga_total->CurrentValue = $this->lain_harga_total->FormValue;
        $this->lain_harga_total_order->CurrentValue = $this->lain_harga_total_order->FormValue;
        $this->isi_bahan_aktif->CurrentValue = $this->isi_bahan_aktif->FormValue;
        $this->isi_bahan_lain->CurrentValue = $this->isi_bahan_lain->FormValue;
        $this->isi_parfum->CurrentValue = $this->isi_parfum->FormValue;
        $this->isi_estetika->CurrentValue = $this->isi_estetika->FormValue;
        $this->kemasan_wadah->CurrentValue = $this->kemasan_wadah->FormValue;
        $this->kemasan_tutup->CurrentValue = $this->kemasan_tutup->FormValue;
        $this->kemasan_sekunder->CurrentValue = $this->kemasan_sekunder->FormValue;
        $this->label_desain->CurrentValue = $this->label_desain->FormValue;
        $this->label_cetak->CurrentValue = $this->label_cetak->FormValue;
        $this->label_lainlain->CurrentValue = $this->label_lainlain->FormValue;
        $this->delivery_pickup->CurrentValue = $this->delivery_pickup->FormValue;
        $this->delivery_singlepoint->CurrentValue = $this->delivery_singlepoint->FormValue;
        $this->delivery_multipoint->CurrentValue = $this->delivery_multipoint->FormValue;
        $this->delivery_jumlahpoint->CurrentValue = $this->delivery_jumlahpoint->FormValue;
        $this->delivery_termslain->CurrentValue = $this->delivery_termslain->FormValue;
        $this->catatan_khusus->CurrentValue = $this->catatan_khusus->FormValue;
        $this->dibuatdi->CurrentValue = $this->dibuatdi->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
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
        $this->status->setDbValue($row['status']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->sifat_order->setDbValue($row['sifat_order']);
        $this->ukuran_utama->setDbValue($row['ukuran_utama']);
        $this->utama_harga_isi->setDbValue($row['utama_harga_isi']);
        $this->utama_harga_isi_order->setDbValue($row['utama_harga_isi_order']);
        $this->utama_harga_primer->setDbValue($row['utama_harga_primer']);
        $this->utama_harga_primer_order->setDbValue($row['utama_harga_primer_order']);
        $this->utama_harga_sekunder->setDbValue($row['utama_harga_sekunder']);
        $this->utama_harga_sekunder_order->setDbValue($row['utama_harga_sekunder_order']);
        $this->utama_harga_label->setDbValue($row['utama_harga_label']);
        $this->utama_harga_label_order->setDbValue($row['utama_harga_label_order']);
        $this->utama_harga_total->setDbValue($row['utama_harga_total']);
        $this->utama_harga_total_order->setDbValue($row['utama_harga_total_order']);
        $this->ukuran_lain->setDbValue($row['ukuran_lain']);
        $this->lain_harga_isi->setDbValue($row['lain_harga_isi']);
        $this->lain_harga_isi_order->setDbValue($row['lain_harga_isi_order']);
        $this->lain_harga_primer->setDbValue($row['lain_harga_primer']);
        $this->lain_harga_primer_order->setDbValue($row['lain_harga_primer_order']);
        $this->lain_harga_sekunder->setDbValue($row['lain_harga_sekunder']);
        $this->lain_harga_sekunder_order->setDbValue($row['lain_harga_sekunder_order']);
        $this->lain_harga_label->setDbValue($row['lain_harga_label']);
        $this->lain_harga_label_order->setDbValue($row['lain_harga_label_order']);
        $this->lain_harga_total->setDbValue($row['lain_harga_total']);
        $this->lain_harga_total_order->setDbValue($row['lain_harga_total_order']);
        $this->isi_bahan_aktif->setDbValue($row['isi_bahan_aktif']);
        $this->isi_bahan_lain->setDbValue($row['isi_bahan_lain']);
        $this->isi_parfum->setDbValue($row['isi_parfum']);
        $this->isi_estetika->setDbValue($row['isi_estetika']);
        $this->kemasan_wadah->setDbValue($row['kemasan_wadah']);
        $this->kemasan_tutup->setDbValue($row['kemasan_tutup']);
        $this->kemasan_sekunder->setDbValue($row['kemasan_sekunder']);
        $this->label_desain->setDbValue($row['label_desain']);
        $this->label_cetak->setDbValue($row['label_cetak']);
        $this->label_lainlain->setDbValue($row['label_lainlain']);
        $this->delivery_pickup->setDbValue($row['delivery_pickup']);
        $this->delivery_singlepoint->setDbValue($row['delivery_singlepoint']);
        $this->delivery_multipoint->setDbValue($row['delivery_multipoint']);
        $this->delivery_jumlahpoint->setDbValue($row['delivery_jumlahpoint']);
        $this->delivery_termslain->setDbValue($row['delivery_termslain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['status'] = null;
        $row['tglsubmit'] = null;
        $row['sifat_order'] = null;
        $row['ukuran_utama'] = null;
        $row['utama_harga_isi'] = null;
        $row['utama_harga_isi_order'] = null;
        $row['utama_harga_primer'] = null;
        $row['utama_harga_primer_order'] = null;
        $row['utama_harga_sekunder'] = null;
        $row['utama_harga_sekunder_order'] = null;
        $row['utama_harga_label'] = null;
        $row['utama_harga_label_order'] = null;
        $row['utama_harga_total'] = null;
        $row['utama_harga_total_order'] = null;
        $row['ukuran_lain'] = null;
        $row['lain_harga_isi'] = null;
        $row['lain_harga_isi_order'] = null;
        $row['lain_harga_primer'] = null;
        $row['lain_harga_primer_order'] = null;
        $row['lain_harga_sekunder'] = null;
        $row['lain_harga_sekunder_order'] = null;
        $row['lain_harga_label'] = null;
        $row['lain_harga_label_order'] = null;
        $row['lain_harga_total'] = null;
        $row['lain_harga_total_order'] = null;
        $row['isi_bahan_aktif'] = null;
        $row['isi_bahan_lain'] = null;
        $row['isi_parfum'] = null;
        $row['isi_estetika'] = null;
        $row['kemasan_wadah'] = null;
        $row['kemasan_tutup'] = null;
        $row['kemasan_sekunder'] = null;
        $row['label_desain'] = null;
        $row['label_cetak'] = null;
        $row['label_lainlain'] = null;
        $row['delivery_pickup'] = null;
        $row['delivery_singlepoint'] = null;
        $row['delivery_multipoint'] = null;
        $row['delivery_jumlahpoint'] = null;
        $row['delivery_termslain'] = null;
        $row['catatan_khusus'] = null;
        $row['dibuatdi'] = null;
        $row['created_at'] = null;
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

        // status

        // tglsubmit

        // sifat_order

        // ukuran_utama

        // utama_harga_isi

        // utama_harga_isi_order

        // utama_harga_primer

        // utama_harga_primer_order

        // utama_harga_sekunder

        // utama_harga_sekunder_order

        // utama_harga_label

        // utama_harga_label_order

        // utama_harga_total

        // utama_harga_total_order

        // ukuran_lain

        // lain_harga_isi

        // lain_harga_isi_order

        // lain_harga_primer

        // lain_harga_primer_order

        // lain_harga_sekunder

        // lain_harga_sekunder_order

        // lain_harga_label

        // lain_harga_label_order

        // lain_harga_total

        // lain_harga_total_order

        // isi_bahan_aktif

        // isi_bahan_lain

        // isi_parfum

        // isi_estetika

        // kemasan_wadah

        // kemasan_tutup

        // kemasan_sekunder

        // label_desain

        // label_cetak

        // label_lainlain

        // delivery_pickup

        // delivery_singlepoint

        // delivery_multipoint

        // delivery_jumlahpoint

        // delivery_termslain

        // catatan_khusus

        // dibuatdi

        // created_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // sifat_order
            if (ConvertToBool($this->sifat_order->CurrentValue)) {
                $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(1) != "" ? $this->sifat_order->tagCaption(1) : "Yes";
            } else {
                $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(2) != "" ? $this->sifat_order->tagCaption(2) : "No";
            }
            $this->sifat_order->ViewCustomAttributes = "";

            // ukuran_utama
            $this->ukuran_utama->ViewValue = $this->ukuran_utama->CurrentValue;
            $this->ukuran_utama->ViewCustomAttributes = "";

            // utama_harga_isi
            $this->utama_harga_isi->ViewValue = $this->utama_harga_isi->CurrentValue;
            $this->utama_harga_isi->ViewValue = FormatNumber($this->utama_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi->ViewCustomAttributes = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->ViewValue = $this->utama_harga_isi_order->CurrentValue;
            $this->utama_harga_isi_order->ViewValue = FormatNumber($this->utama_harga_isi_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi_order->ViewCustomAttributes = "";

            // utama_harga_primer
            $this->utama_harga_primer->ViewValue = $this->utama_harga_primer->CurrentValue;
            $this->utama_harga_primer->ViewValue = FormatNumber($this->utama_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer->ViewCustomAttributes = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->ViewValue = $this->utama_harga_primer_order->CurrentValue;
            $this->utama_harga_primer_order->ViewValue = FormatNumber($this->utama_harga_primer_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer_order->ViewCustomAttributes = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->ViewValue = $this->utama_harga_sekunder->CurrentValue;
            $this->utama_harga_sekunder->ViewValue = FormatNumber($this->utama_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder->ViewCustomAttributes = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->ViewValue = $this->utama_harga_sekunder_order->CurrentValue;
            $this->utama_harga_sekunder_order->ViewValue = FormatNumber($this->utama_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder_order->ViewCustomAttributes = "";

            // utama_harga_label
            $this->utama_harga_label->ViewValue = $this->utama_harga_label->CurrentValue;
            $this->utama_harga_label->ViewValue = FormatNumber($this->utama_harga_label->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label->ViewCustomAttributes = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->ViewValue = $this->utama_harga_label_order->CurrentValue;
            $this->utama_harga_label_order->ViewValue = FormatNumber($this->utama_harga_label_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label_order->ViewCustomAttributes = "";

            // utama_harga_total
            $this->utama_harga_total->ViewValue = $this->utama_harga_total->CurrentValue;
            $this->utama_harga_total->ViewValue = FormatNumber($this->utama_harga_total->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total->ViewCustomAttributes = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->ViewValue = $this->utama_harga_total_order->CurrentValue;
            $this->utama_harga_total_order->ViewValue = FormatNumber($this->utama_harga_total_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total_order->ViewCustomAttributes = "";

            // ukuran_lain
            $this->ukuran_lain->ViewValue = $this->ukuran_lain->CurrentValue;
            $this->ukuran_lain->ViewCustomAttributes = "";

            // lain_harga_isi
            $this->lain_harga_isi->ViewValue = $this->lain_harga_isi->CurrentValue;
            $this->lain_harga_isi->ViewValue = FormatNumber($this->lain_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi->ViewCustomAttributes = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->ViewValue = $this->lain_harga_isi_order->CurrentValue;
            $this->lain_harga_isi_order->ViewValue = FormatNumber($this->lain_harga_isi_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi_order->ViewCustomAttributes = "";

            // lain_harga_primer
            $this->lain_harga_primer->ViewValue = $this->lain_harga_primer->CurrentValue;
            $this->lain_harga_primer->ViewValue = FormatNumber($this->lain_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer->ViewCustomAttributes = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->ViewValue = $this->lain_harga_primer_order->CurrentValue;
            $this->lain_harga_primer_order->ViewValue = FormatNumber($this->lain_harga_primer_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer_order->ViewCustomAttributes = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->ViewValue = $this->lain_harga_sekunder->CurrentValue;
            $this->lain_harga_sekunder->ViewValue = FormatNumber($this->lain_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder->ViewCustomAttributes = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->ViewValue = $this->lain_harga_sekunder_order->CurrentValue;
            $this->lain_harga_sekunder_order->ViewValue = FormatNumber($this->lain_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder_order->ViewCustomAttributes = "";

            // lain_harga_label
            $this->lain_harga_label->ViewValue = $this->lain_harga_label->CurrentValue;
            $this->lain_harga_label->ViewValue = FormatNumber($this->lain_harga_label->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label->ViewCustomAttributes = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->ViewValue = $this->lain_harga_label_order->CurrentValue;
            $this->lain_harga_label_order->ViewValue = FormatNumber($this->lain_harga_label_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label_order->ViewCustomAttributes = "";

            // lain_harga_total
            $this->lain_harga_total->ViewValue = $this->lain_harga_total->CurrentValue;
            $this->lain_harga_total->ViewValue = FormatNumber($this->lain_harga_total->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total->ViewCustomAttributes = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->ViewValue = $this->lain_harga_total_order->CurrentValue;
            $this->lain_harga_total_order->ViewValue = FormatNumber($this->lain_harga_total_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total_order->ViewCustomAttributes = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->ViewValue = $this->isi_bahan_aktif->CurrentValue;
            $this->isi_bahan_aktif->ViewCustomAttributes = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->ViewValue = $this->isi_bahan_lain->CurrentValue;
            $this->isi_bahan_lain->ViewCustomAttributes = "";

            // isi_parfum
            $this->isi_parfum->ViewValue = $this->isi_parfum->CurrentValue;
            $this->isi_parfum->ViewCustomAttributes = "";

            // isi_estetika
            $this->isi_estetika->ViewValue = $this->isi_estetika->CurrentValue;
            $this->isi_estetika->ViewCustomAttributes = "";

            // kemasan_wadah
            $this->kemasan_wadah->ViewValue = $this->kemasan_wadah->CurrentValue;
            $this->kemasan_wadah->ViewValue = FormatNumber($this->kemasan_wadah->ViewValue, 0, -2, -2, -2);
            $this->kemasan_wadah->ViewCustomAttributes = "";

            // kemasan_tutup
            $this->kemasan_tutup->ViewValue = $this->kemasan_tutup->CurrentValue;
            $this->kemasan_tutup->ViewValue = FormatNumber($this->kemasan_tutup->ViewValue, 0, -2, -2, -2);
            $this->kemasan_tutup->ViewCustomAttributes = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->ViewValue = $this->kemasan_sekunder->CurrentValue;
            $this->kemasan_sekunder->ViewCustomAttributes = "";

            // label_desain
            $this->label_desain->ViewValue = $this->label_desain->CurrentValue;
            $this->label_desain->ViewCustomAttributes = "";

            // label_cetak
            $this->label_cetak->ViewValue = $this->label_cetak->CurrentValue;
            $this->label_cetak->ViewCustomAttributes = "";

            // label_lainlain
            $this->label_lainlain->ViewValue = $this->label_lainlain->CurrentValue;
            $this->label_lainlain->ViewCustomAttributes = "";

            // delivery_pickup
            $this->delivery_pickup->ViewValue = $this->delivery_pickup->CurrentValue;
            $this->delivery_pickup->ViewCustomAttributes = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->ViewValue = $this->delivery_singlepoint->CurrentValue;
            $this->delivery_singlepoint->ViewCustomAttributes = "";

            // delivery_multipoint
            $this->delivery_multipoint->ViewValue = $this->delivery_multipoint->CurrentValue;
            $this->delivery_multipoint->ViewCustomAttributes = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->ViewValue = $this->delivery_jumlahpoint->CurrentValue;
            $this->delivery_jumlahpoint->ViewCustomAttributes = "";

            // delivery_termslain
            $this->delivery_termslain->ViewValue = $this->delivery_termslain->CurrentValue;
            $this->delivery_termslain->ViewCustomAttributes = "";

            // catatan_khusus
            $this->catatan_khusus->ViewValue = $this->catatan_khusus->CurrentValue;
            $this->catatan_khusus->ViewCustomAttributes = "";

            // dibuatdi
            $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
            $this->dibuatdi->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // sifat_order
            $this->sifat_order->LinkCustomAttributes = "";
            $this->sifat_order->HrefValue = "";
            $this->sifat_order->TooltipValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";
            $this->ukuran_utama->TooltipValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";
            $this->utama_harga_isi->TooltipValue = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->LinkCustomAttributes = "";
            $this->utama_harga_isi_order->HrefValue = "";
            $this->utama_harga_isi_order->TooltipValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";
            $this->utama_harga_primer->TooltipValue = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->LinkCustomAttributes = "";
            $this->utama_harga_primer_order->HrefValue = "";
            $this->utama_harga_primer_order->TooltipValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";
            $this->utama_harga_sekunder->TooltipValue = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_order->HrefValue = "";
            $this->utama_harga_sekunder_order->TooltipValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";
            $this->utama_harga_label->TooltipValue = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->LinkCustomAttributes = "";
            $this->utama_harga_label_order->HrefValue = "";
            $this->utama_harga_label_order->TooltipValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";
            $this->utama_harga_total->TooltipValue = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->LinkCustomAttributes = "";
            $this->utama_harga_total_order->HrefValue = "";
            $this->utama_harga_total_order->TooltipValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";
            $this->ukuran_lain->TooltipValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";
            $this->lain_harga_isi->TooltipValue = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->LinkCustomAttributes = "";
            $this->lain_harga_isi_order->HrefValue = "";
            $this->lain_harga_isi_order->TooltipValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";
            $this->lain_harga_primer->TooltipValue = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->LinkCustomAttributes = "";
            $this->lain_harga_primer_order->HrefValue = "";
            $this->lain_harga_primer_order->TooltipValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";
            $this->lain_harga_sekunder->TooltipValue = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_order->HrefValue = "";
            $this->lain_harga_sekunder_order->TooltipValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";
            $this->lain_harga_label->TooltipValue = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->LinkCustomAttributes = "";
            $this->lain_harga_label_order->HrefValue = "";
            $this->lain_harga_label_order->TooltipValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";
            $this->lain_harga_total->TooltipValue = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->LinkCustomAttributes = "";
            $this->lain_harga_total_order->HrefValue = "";
            $this->lain_harga_total_order->TooltipValue = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->LinkCustomAttributes = "";
            $this->isi_bahan_aktif->HrefValue = "";
            $this->isi_bahan_aktif->TooltipValue = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->LinkCustomAttributes = "";
            $this->isi_bahan_lain->HrefValue = "";
            $this->isi_bahan_lain->TooltipValue = "";

            // isi_parfum
            $this->isi_parfum->LinkCustomAttributes = "";
            $this->isi_parfum->HrefValue = "";
            $this->isi_parfum->TooltipValue = "";

            // isi_estetika
            $this->isi_estetika->LinkCustomAttributes = "";
            $this->isi_estetika->HrefValue = "";
            $this->isi_estetika->TooltipValue = "";

            // kemasan_wadah
            $this->kemasan_wadah->LinkCustomAttributes = "";
            $this->kemasan_wadah->HrefValue = "";
            $this->kemasan_wadah->TooltipValue = "";

            // kemasan_tutup
            $this->kemasan_tutup->LinkCustomAttributes = "";
            $this->kemasan_tutup->HrefValue = "";
            $this->kemasan_tutup->TooltipValue = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->LinkCustomAttributes = "";
            $this->kemasan_sekunder->HrefValue = "";
            $this->kemasan_sekunder->TooltipValue = "";

            // label_desain
            $this->label_desain->LinkCustomAttributes = "";
            $this->label_desain->HrefValue = "";
            $this->label_desain->TooltipValue = "";

            // label_cetak
            $this->label_cetak->LinkCustomAttributes = "";
            $this->label_cetak->HrefValue = "";
            $this->label_cetak->TooltipValue = "";

            // label_lainlain
            $this->label_lainlain->LinkCustomAttributes = "";
            $this->label_lainlain->HrefValue = "";
            $this->label_lainlain->TooltipValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";
            $this->delivery_pickup->TooltipValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";
            $this->delivery_singlepoint->TooltipValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";
            $this->delivery_multipoint->TooltipValue = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->LinkCustomAttributes = "";
            $this->delivery_jumlahpoint->HrefValue = "";
            $this->delivery_jumlahpoint->TooltipValue = "";

            // delivery_termslain
            $this->delivery_termslain->LinkCustomAttributes = "";
            $this->delivery_termslain->HrefValue = "";
            $this->delivery_termslain->TooltipValue = "";

            // catatan_khusus
            $this->catatan_khusus->LinkCustomAttributes = "";
            $this->catatan_khusus->HrefValue = "";
            $this->catatan_khusus->TooltipValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";
            $this->dibuatdi->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
                $this->idnpd->ViewCustomAttributes = "";
            } else {
                $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
            $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

            // sifat_order
            $this->sifat_order->EditCustomAttributes = "";
            $this->sifat_order->EditValue = $this->sifat_order->options(false);
            $this->sifat_order->PlaceHolder = RemoveHtml($this->sifat_order->caption());

            // ukuran_utama
            $this->ukuran_utama->EditAttrs["class"] = "form-control";
            $this->ukuran_utama->EditCustomAttributes = "";
            if (!$this->ukuran_utama->Raw) {
                $this->ukuran_utama->CurrentValue = HtmlDecode($this->ukuran_utama->CurrentValue);
            }
            $this->ukuran_utama->EditValue = HtmlEncode($this->ukuran_utama->CurrentValue);
            $this->ukuran_utama->PlaceHolder = RemoveHtml($this->ukuran_utama->caption());

            // utama_harga_isi
            $this->utama_harga_isi->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi->EditCustomAttributes = "";
            $this->utama_harga_isi->EditValue = HtmlEncode($this->utama_harga_isi->CurrentValue);
            $this->utama_harga_isi->PlaceHolder = RemoveHtml($this->utama_harga_isi->caption());

            // utama_harga_isi_order
            $this->utama_harga_isi_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi_order->EditCustomAttributes = "";
            $this->utama_harga_isi_order->EditValue = HtmlEncode($this->utama_harga_isi_order->CurrentValue);
            $this->utama_harga_isi_order->PlaceHolder = RemoveHtml($this->utama_harga_isi_order->caption());

            // utama_harga_primer
            $this->utama_harga_primer->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer->EditCustomAttributes = "";
            $this->utama_harga_primer->EditValue = HtmlEncode($this->utama_harga_primer->CurrentValue);
            $this->utama_harga_primer->PlaceHolder = RemoveHtml($this->utama_harga_primer->caption());

            // utama_harga_primer_order
            $this->utama_harga_primer_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer_order->EditCustomAttributes = "";
            $this->utama_harga_primer_order->EditValue = HtmlEncode($this->utama_harga_primer_order->CurrentValue);
            $this->utama_harga_primer_order->PlaceHolder = RemoveHtml($this->utama_harga_primer_order->caption());

            // utama_harga_sekunder
            $this->utama_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder->EditCustomAttributes = "";
            $this->utama_harga_sekunder->EditValue = HtmlEncode($this->utama_harga_sekunder->CurrentValue);
            $this->utama_harga_sekunder->PlaceHolder = RemoveHtml($this->utama_harga_sekunder->caption());

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder_order->EditCustomAttributes = "";
            $this->utama_harga_sekunder_order->EditValue = HtmlEncode($this->utama_harga_sekunder_order->CurrentValue);
            $this->utama_harga_sekunder_order->PlaceHolder = RemoveHtml($this->utama_harga_sekunder_order->caption());

            // utama_harga_label
            $this->utama_harga_label->EditAttrs["class"] = "form-control";
            $this->utama_harga_label->EditCustomAttributes = "";
            $this->utama_harga_label->EditValue = HtmlEncode($this->utama_harga_label->CurrentValue);
            $this->utama_harga_label->PlaceHolder = RemoveHtml($this->utama_harga_label->caption());

            // utama_harga_label_order
            $this->utama_harga_label_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_label_order->EditCustomAttributes = "";
            $this->utama_harga_label_order->EditValue = HtmlEncode($this->utama_harga_label_order->CurrentValue);
            $this->utama_harga_label_order->PlaceHolder = RemoveHtml($this->utama_harga_label_order->caption());

            // utama_harga_total
            $this->utama_harga_total->EditAttrs["class"] = "form-control";
            $this->utama_harga_total->EditCustomAttributes = "";
            $this->utama_harga_total->EditValue = HtmlEncode($this->utama_harga_total->CurrentValue);
            $this->utama_harga_total->PlaceHolder = RemoveHtml($this->utama_harga_total->caption());

            // utama_harga_total_order
            $this->utama_harga_total_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_total_order->EditCustomAttributes = "";
            $this->utama_harga_total_order->EditValue = HtmlEncode($this->utama_harga_total_order->CurrentValue);
            $this->utama_harga_total_order->PlaceHolder = RemoveHtml($this->utama_harga_total_order->caption());

            // ukuran_lain
            $this->ukuran_lain->EditAttrs["class"] = "form-control";
            $this->ukuran_lain->EditCustomAttributes = "";
            if (!$this->ukuran_lain->Raw) {
                $this->ukuran_lain->CurrentValue = HtmlDecode($this->ukuran_lain->CurrentValue);
            }
            $this->ukuran_lain->EditValue = HtmlEncode($this->ukuran_lain->CurrentValue);
            $this->ukuran_lain->PlaceHolder = RemoveHtml($this->ukuran_lain->caption());

            // lain_harga_isi
            $this->lain_harga_isi->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi->EditCustomAttributes = "";
            $this->lain_harga_isi->EditValue = HtmlEncode($this->lain_harga_isi->CurrentValue);
            $this->lain_harga_isi->PlaceHolder = RemoveHtml($this->lain_harga_isi->caption());

            // lain_harga_isi_order
            $this->lain_harga_isi_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi_order->EditCustomAttributes = "";
            $this->lain_harga_isi_order->EditValue = HtmlEncode($this->lain_harga_isi_order->CurrentValue);
            $this->lain_harga_isi_order->PlaceHolder = RemoveHtml($this->lain_harga_isi_order->caption());

            // lain_harga_primer
            $this->lain_harga_primer->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer->EditCustomAttributes = "";
            $this->lain_harga_primer->EditValue = HtmlEncode($this->lain_harga_primer->CurrentValue);
            $this->lain_harga_primer->PlaceHolder = RemoveHtml($this->lain_harga_primer->caption());

            // lain_harga_primer_order
            $this->lain_harga_primer_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer_order->EditCustomAttributes = "";
            $this->lain_harga_primer_order->EditValue = HtmlEncode($this->lain_harga_primer_order->CurrentValue);
            $this->lain_harga_primer_order->PlaceHolder = RemoveHtml($this->lain_harga_primer_order->caption());

            // lain_harga_sekunder
            $this->lain_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder->EditCustomAttributes = "";
            $this->lain_harga_sekunder->EditValue = HtmlEncode($this->lain_harga_sekunder->CurrentValue);
            $this->lain_harga_sekunder->PlaceHolder = RemoveHtml($this->lain_harga_sekunder->caption());

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder_order->EditCustomAttributes = "";
            $this->lain_harga_sekunder_order->EditValue = HtmlEncode($this->lain_harga_sekunder_order->CurrentValue);
            $this->lain_harga_sekunder_order->PlaceHolder = RemoveHtml($this->lain_harga_sekunder_order->caption());

            // lain_harga_label
            $this->lain_harga_label->EditAttrs["class"] = "form-control";
            $this->lain_harga_label->EditCustomAttributes = "";
            $this->lain_harga_label->EditValue = HtmlEncode($this->lain_harga_label->CurrentValue);
            $this->lain_harga_label->PlaceHolder = RemoveHtml($this->lain_harga_label->caption());

            // lain_harga_label_order
            $this->lain_harga_label_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_label_order->EditCustomAttributes = "";
            $this->lain_harga_label_order->EditValue = HtmlEncode($this->lain_harga_label_order->CurrentValue);
            $this->lain_harga_label_order->PlaceHolder = RemoveHtml($this->lain_harga_label_order->caption());

            // lain_harga_total
            $this->lain_harga_total->EditAttrs["class"] = "form-control";
            $this->lain_harga_total->EditCustomAttributes = "";
            $this->lain_harga_total->EditValue = HtmlEncode($this->lain_harga_total->CurrentValue);
            $this->lain_harga_total->PlaceHolder = RemoveHtml($this->lain_harga_total->caption());

            // lain_harga_total_order
            $this->lain_harga_total_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_total_order->EditCustomAttributes = "";
            $this->lain_harga_total_order->EditValue = HtmlEncode($this->lain_harga_total_order->CurrentValue);
            $this->lain_harga_total_order->PlaceHolder = RemoveHtml($this->lain_harga_total_order->caption());

            // isi_bahan_aktif
            $this->isi_bahan_aktif->EditAttrs["class"] = "form-control";
            $this->isi_bahan_aktif->EditCustomAttributes = "";
            if (!$this->isi_bahan_aktif->Raw) {
                $this->isi_bahan_aktif->CurrentValue = HtmlDecode($this->isi_bahan_aktif->CurrentValue);
            }
            $this->isi_bahan_aktif->EditValue = HtmlEncode($this->isi_bahan_aktif->CurrentValue);
            $this->isi_bahan_aktif->PlaceHolder = RemoveHtml($this->isi_bahan_aktif->caption());

            // isi_bahan_lain
            $this->isi_bahan_lain->EditAttrs["class"] = "form-control";
            $this->isi_bahan_lain->EditCustomAttributes = "";
            if (!$this->isi_bahan_lain->Raw) {
                $this->isi_bahan_lain->CurrentValue = HtmlDecode($this->isi_bahan_lain->CurrentValue);
            }
            $this->isi_bahan_lain->EditValue = HtmlEncode($this->isi_bahan_lain->CurrentValue);
            $this->isi_bahan_lain->PlaceHolder = RemoveHtml($this->isi_bahan_lain->caption());

            // isi_parfum
            $this->isi_parfum->EditAttrs["class"] = "form-control";
            $this->isi_parfum->EditCustomAttributes = "";
            if (!$this->isi_parfum->Raw) {
                $this->isi_parfum->CurrentValue = HtmlDecode($this->isi_parfum->CurrentValue);
            }
            $this->isi_parfum->EditValue = HtmlEncode($this->isi_parfum->CurrentValue);
            $this->isi_parfum->PlaceHolder = RemoveHtml($this->isi_parfum->caption());

            // isi_estetika
            $this->isi_estetika->EditAttrs["class"] = "form-control";
            $this->isi_estetika->EditCustomAttributes = "";
            if (!$this->isi_estetika->Raw) {
                $this->isi_estetika->CurrentValue = HtmlDecode($this->isi_estetika->CurrentValue);
            }
            $this->isi_estetika->EditValue = HtmlEncode($this->isi_estetika->CurrentValue);
            $this->isi_estetika->PlaceHolder = RemoveHtml($this->isi_estetika->caption());

            // kemasan_wadah
            $this->kemasan_wadah->EditAttrs["class"] = "form-control";
            $this->kemasan_wadah->EditCustomAttributes = "";
            $this->kemasan_wadah->EditValue = HtmlEncode($this->kemasan_wadah->CurrentValue);
            $this->kemasan_wadah->PlaceHolder = RemoveHtml($this->kemasan_wadah->caption());

            // kemasan_tutup
            $this->kemasan_tutup->EditAttrs["class"] = "form-control";
            $this->kemasan_tutup->EditCustomAttributes = "";
            $this->kemasan_tutup->EditValue = HtmlEncode($this->kemasan_tutup->CurrentValue);
            $this->kemasan_tutup->PlaceHolder = RemoveHtml($this->kemasan_tutup->caption());

            // kemasan_sekunder
            $this->kemasan_sekunder->EditAttrs["class"] = "form-control";
            $this->kemasan_sekunder->EditCustomAttributes = "";
            if (!$this->kemasan_sekunder->Raw) {
                $this->kemasan_sekunder->CurrentValue = HtmlDecode($this->kemasan_sekunder->CurrentValue);
            }
            $this->kemasan_sekunder->EditValue = HtmlEncode($this->kemasan_sekunder->CurrentValue);
            $this->kemasan_sekunder->PlaceHolder = RemoveHtml($this->kemasan_sekunder->caption());

            // label_desain
            $this->label_desain->EditAttrs["class"] = "form-control";
            $this->label_desain->EditCustomAttributes = "";
            if (!$this->label_desain->Raw) {
                $this->label_desain->CurrentValue = HtmlDecode($this->label_desain->CurrentValue);
            }
            $this->label_desain->EditValue = HtmlEncode($this->label_desain->CurrentValue);
            $this->label_desain->PlaceHolder = RemoveHtml($this->label_desain->caption());

            // label_cetak
            $this->label_cetak->EditAttrs["class"] = "form-control";
            $this->label_cetak->EditCustomAttributes = "";
            if (!$this->label_cetak->Raw) {
                $this->label_cetak->CurrentValue = HtmlDecode($this->label_cetak->CurrentValue);
            }
            $this->label_cetak->EditValue = HtmlEncode($this->label_cetak->CurrentValue);
            $this->label_cetak->PlaceHolder = RemoveHtml($this->label_cetak->caption());

            // label_lainlain
            $this->label_lainlain->EditAttrs["class"] = "form-control";
            $this->label_lainlain->EditCustomAttributes = "";
            if (!$this->label_lainlain->Raw) {
                $this->label_lainlain->CurrentValue = HtmlDecode($this->label_lainlain->CurrentValue);
            }
            $this->label_lainlain->EditValue = HtmlEncode($this->label_lainlain->CurrentValue);
            $this->label_lainlain->PlaceHolder = RemoveHtml($this->label_lainlain->caption());

            // delivery_pickup
            $this->delivery_pickup->EditAttrs["class"] = "form-control";
            $this->delivery_pickup->EditCustomAttributes = "";
            if (!$this->delivery_pickup->Raw) {
                $this->delivery_pickup->CurrentValue = HtmlDecode($this->delivery_pickup->CurrentValue);
            }
            $this->delivery_pickup->EditValue = HtmlEncode($this->delivery_pickup->CurrentValue);
            $this->delivery_pickup->PlaceHolder = RemoveHtml($this->delivery_pickup->caption());

            // delivery_singlepoint
            $this->delivery_singlepoint->EditAttrs["class"] = "form-control";
            $this->delivery_singlepoint->EditCustomAttributes = "";
            if (!$this->delivery_singlepoint->Raw) {
                $this->delivery_singlepoint->CurrentValue = HtmlDecode($this->delivery_singlepoint->CurrentValue);
            }
            $this->delivery_singlepoint->EditValue = HtmlEncode($this->delivery_singlepoint->CurrentValue);
            $this->delivery_singlepoint->PlaceHolder = RemoveHtml($this->delivery_singlepoint->caption());

            // delivery_multipoint
            $this->delivery_multipoint->EditAttrs["class"] = "form-control";
            $this->delivery_multipoint->EditCustomAttributes = "";
            if (!$this->delivery_multipoint->Raw) {
                $this->delivery_multipoint->CurrentValue = HtmlDecode($this->delivery_multipoint->CurrentValue);
            }
            $this->delivery_multipoint->EditValue = HtmlEncode($this->delivery_multipoint->CurrentValue);
            $this->delivery_multipoint->PlaceHolder = RemoveHtml($this->delivery_multipoint->caption());

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->EditAttrs["class"] = "form-control";
            $this->delivery_jumlahpoint->EditCustomAttributes = "";
            if (!$this->delivery_jumlahpoint->Raw) {
                $this->delivery_jumlahpoint->CurrentValue = HtmlDecode($this->delivery_jumlahpoint->CurrentValue);
            }
            $this->delivery_jumlahpoint->EditValue = HtmlEncode($this->delivery_jumlahpoint->CurrentValue);
            $this->delivery_jumlahpoint->PlaceHolder = RemoveHtml($this->delivery_jumlahpoint->caption());

            // delivery_termslain
            $this->delivery_termslain->EditAttrs["class"] = "form-control";
            $this->delivery_termslain->EditCustomAttributes = "";
            if (!$this->delivery_termslain->Raw) {
                $this->delivery_termslain->CurrentValue = HtmlDecode($this->delivery_termslain->CurrentValue);
            }
            $this->delivery_termslain->EditValue = HtmlEncode($this->delivery_termslain->CurrentValue);
            $this->delivery_termslain->PlaceHolder = RemoveHtml($this->delivery_termslain->caption());

            // catatan_khusus
            $this->catatan_khusus->EditAttrs["class"] = "form-control";
            $this->catatan_khusus->EditCustomAttributes = "";
            $this->catatan_khusus->EditValue = HtmlEncode($this->catatan_khusus->CurrentValue);
            $this->catatan_khusus->PlaceHolder = RemoveHtml($this->catatan_khusus->caption());

            // dibuatdi
            $this->dibuatdi->EditAttrs["class"] = "form-control";
            $this->dibuatdi->EditCustomAttributes = "";
            if (!$this->dibuatdi->Raw) {
                $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
            }
            $this->dibuatdi->EditValue = HtmlEncode($this->dibuatdi->CurrentValue);
            $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // sifat_order
            $this->sifat_order->LinkCustomAttributes = "";
            $this->sifat_order->HrefValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->LinkCustomAttributes = "";
            $this->utama_harga_isi_order->HrefValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->LinkCustomAttributes = "";
            $this->utama_harga_primer_order->HrefValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_order->HrefValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->LinkCustomAttributes = "";
            $this->utama_harga_label_order->HrefValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->LinkCustomAttributes = "";
            $this->utama_harga_total_order->HrefValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->LinkCustomAttributes = "";
            $this->lain_harga_isi_order->HrefValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->LinkCustomAttributes = "";
            $this->lain_harga_primer_order->HrefValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_order->HrefValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->LinkCustomAttributes = "";
            $this->lain_harga_label_order->HrefValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->LinkCustomAttributes = "";
            $this->lain_harga_total_order->HrefValue = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->LinkCustomAttributes = "";
            $this->isi_bahan_aktif->HrefValue = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->LinkCustomAttributes = "";
            $this->isi_bahan_lain->HrefValue = "";

            // isi_parfum
            $this->isi_parfum->LinkCustomAttributes = "";
            $this->isi_parfum->HrefValue = "";

            // isi_estetika
            $this->isi_estetika->LinkCustomAttributes = "";
            $this->isi_estetika->HrefValue = "";

            // kemasan_wadah
            $this->kemasan_wadah->LinkCustomAttributes = "";
            $this->kemasan_wadah->HrefValue = "";

            // kemasan_tutup
            $this->kemasan_tutup->LinkCustomAttributes = "";
            $this->kemasan_tutup->HrefValue = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->LinkCustomAttributes = "";
            $this->kemasan_sekunder->HrefValue = "";

            // label_desain
            $this->label_desain->LinkCustomAttributes = "";
            $this->label_desain->HrefValue = "";

            // label_cetak
            $this->label_cetak->LinkCustomAttributes = "";
            $this->label_cetak->HrefValue = "";

            // label_lainlain
            $this->label_lainlain->LinkCustomAttributes = "";
            $this->label_lainlain->HrefValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->LinkCustomAttributes = "";
            $this->delivery_jumlahpoint->HrefValue = "";

            // delivery_termslain
            $this->delivery_termslain->LinkCustomAttributes = "";
            $this->delivery_termslain->HrefValue = "";

            // catatan_khusus
            $this->catatan_khusus->LinkCustomAttributes = "";
            $this->catatan_khusus->HrefValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->tglsubmit->Required) {
            if (!$this->tglsubmit->IsDetailKey && EmptyValue($this->tglsubmit->FormValue)) {
                $this->tglsubmit->addErrorMessage(str_replace("%s", $this->tglsubmit->caption(), $this->tglsubmit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglsubmit->FormValue)) {
            $this->tglsubmit->addErrorMessage($this->tglsubmit->getErrorMessage(false));
        }
        if ($this->sifat_order->Required) {
            if ($this->sifat_order->FormValue == "") {
                $this->sifat_order->addErrorMessage(str_replace("%s", $this->sifat_order->caption(), $this->sifat_order->RequiredErrorMessage));
            }
        }
        if ($this->ukuran_utama->Required) {
            if (!$this->ukuran_utama->IsDetailKey && EmptyValue($this->ukuran_utama->FormValue)) {
                $this->ukuran_utama->addErrorMessage(str_replace("%s", $this->ukuran_utama->caption(), $this->ukuran_utama->RequiredErrorMessage));
            }
        }
        if ($this->utama_harga_isi->Required) {
            if (!$this->utama_harga_isi->IsDetailKey && EmptyValue($this->utama_harga_isi->FormValue)) {
                $this->utama_harga_isi->addErrorMessage(str_replace("%s", $this->utama_harga_isi->caption(), $this->utama_harga_isi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_isi->FormValue)) {
            $this->utama_harga_isi->addErrorMessage($this->utama_harga_isi->getErrorMessage(false));
        }
        if ($this->utama_harga_isi_order->Required) {
            if (!$this->utama_harga_isi_order->IsDetailKey && EmptyValue($this->utama_harga_isi_order->FormValue)) {
                $this->utama_harga_isi_order->addErrorMessage(str_replace("%s", $this->utama_harga_isi_order->caption(), $this->utama_harga_isi_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_isi_order->FormValue)) {
            $this->utama_harga_isi_order->addErrorMessage($this->utama_harga_isi_order->getErrorMessage(false));
        }
        if ($this->utama_harga_primer->Required) {
            if (!$this->utama_harga_primer->IsDetailKey && EmptyValue($this->utama_harga_primer->FormValue)) {
                $this->utama_harga_primer->addErrorMessage(str_replace("%s", $this->utama_harga_primer->caption(), $this->utama_harga_primer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_primer->FormValue)) {
            $this->utama_harga_primer->addErrorMessage($this->utama_harga_primer->getErrorMessage(false));
        }
        if ($this->utama_harga_primer_order->Required) {
            if (!$this->utama_harga_primer_order->IsDetailKey && EmptyValue($this->utama_harga_primer_order->FormValue)) {
                $this->utama_harga_primer_order->addErrorMessage(str_replace("%s", $this->utama_harga_primer_order->caption(), $this->utama_harga_primer_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_primer_order->FormValue)) {
            $this->utama_harga_primer_order->addErrorMessage($this->utama_harga_primer_order->getErrorMessage(false));
        }
        if ($this->utama_harga_sekunder->Required) {
            if (!$this->utama_harga_sekunder->IsDetailKey && EmptyValue($this->utama_harga_sekunder->FormValue)) {
                $this->utama_harga_sekunder->addErrorMessage(str_replace("%s", $this->utama_harga_sekunder->caption(), $this->utama_harga_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_sekunder->FormValue)) {
            $this->utama_harga_sekunder->addErrorMessage($this->utama_harga_sekunder->getErrorMessage(false));
        }
        if ($this->utama_harga_sekunder_order->Required) {
            if (!$this->utama_harga_sekunder_order->IsDetailKey && EmptyValue($this->utama_harga_sekunder_order->FormValue)) {
                $this->utama_harga_sekunder_order->addErrorMessage(str_replace("%s", $this->utama_harga_sekunder_order->caption(), $this->utama_harga_sekunder_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_sekunder_order->FormValue)) {
            $this->utama_harga_sekunder_order->addErrorMessage($this->utama_harga_sekunder_order->getErrorMessage(false));
        }
        if ($this->utama_harga_label->Required) {
            if (!$this->utama_harga_label->IsDetailKey && EmptyValue($this->utama_harga_label->FormValue)) {
                $this->utama_harga_label->addErrorMessage(str_replace("%s", $this->utama_harga_label->caption(), $this->utama_harga_label->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_label->FormValue)) {
            $this->utama_harga_label->addErrorMessage($this->utama_harga_label->getErrorMessage(false));
        }
        if ($this->utama_harga_label_order->Required) {
            if (!$this->utama_harga_label_order->IsDetailKey && EmptyValue($this->utama_harga_label_order->FormValue)) {
                $this->utama_harga_label_order->addErrorMessage(str_replace("%s", $this->utama_harga_label_order->caption(), $this->utama_harga_label_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_label_order->FormValue)) {
            $this->utama_harga_label_order->addErrorMessage($this->utama_harga_label_order->getErrorMessage(false));
        }
        if ($this->utama_harga_total->Required) {
            if (!$this->utama_harga_total->IsDetailKey && EmptyValue($this->utama_harga_total->FormValue)) {
                $this->utama_harga_total->addErrorMessage(str_replace("%s", $this->utama_harga_total->caption(), $this->utama_harga_total->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_total->FormValue)) {
            $this->utama_harga_total->addErrorMessage($this->utama_harga_total->getErrorMessage(false));
        }
        if ($this->utama_harga_total_order->Required) {
            if (!$this->utama_harga_total_order->IsDetailKey && EmptyValue($this->utama_harga_total_order->FormValue)) {
                $this->utama_harga_total_order->addErrorMessage(str_replace("%s", $this->utama_harga_total_order->caption(), $this->utama_harga_total_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_total_order->FormValue)) {
            $this->utama_harga_total_order->addErrorMessage($this->utama_harga_total_order->getErrorMessage(false));
        }
        if ($this->ukuran_lain->Required) {
            if (!$this->ukuran_lain->IsDetailKey && EmptyValue($this->ukuran_lain->FormValue)) {
                $this->ukuran_lain->addErrorMessage(str_replace("%s", $this->ukuran_lain->caption(), $this->ukuran_lain->RequiredErrorMessage));
            }
        }
        if ($this->lain_harga_isi->Required) {
            if (!$this->lain_harga_isi->IsDetailKey && EmptyValue($this->lain_harga_isi->FormValue)) {
                $this->lain_harga_isi->addErrorMessage(str_replace("%s", $this->lain_harga_isi->caption(), $this->lain_harga_isi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_isi->FormValue)) {
            $this->lain_harga_isi->addErrorMessage($this->lain_harga_isi->getErrorMessage(false));
        }
        if ($this->lain_harga_isi_order->Required) {
            if (!$this->lain_harga_isi_order->IsDetailKey && EmptyValue($this->lain_harga_isi_order->FormValue)) {
                $this->lain_harga_isi_order->addErrorMessage(str_replace("%s", $this->lain_harga_isi_order->caption(), $this->lain_harga_isi_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_isi_order->FormValue)) {
            $this->lain_harga_isi_order->addErrorMessage($this->lain_harga_isi_order->getErrorMessage(false));
        }
        if ($this->lain_harga_primer->Required) {
            if (!$this->lain_harga_primer->IsDetailKey && EmptyValue($this->lain_harga_primer->FormValue)) {
                $this->lain_harga_primer->addErrorMessage(str_replace("%s", $this->lain_harga_primer->caption(), $this->lain_harga_primer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_primer->FormValue)) {
            $this->lain_harga_primer->addErrorMessage($this->lain_harga_primer->getErrorMessage(false));
        }
        if ($this->lain_harga_primer_order->Required) {
            if (!$this->lain_harga_primer_order->IsDetailKey && EmptyValue($this->lain_harga_primer_order->FormValue)) {
                $this->lain_harga_primer_order->addErrorMessage(str_replace("%s", $this->lain_harga_primer_order->caption(), $this->lain_harga_primer_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_primer_order->FormValue)) {
            $this->lain_harga_primer_order->addErrorMessage($this->lain_harga_primer_order->getErrorMessage(false));
        }
        if ($this->lain_harga_sekunder->Required) {
            if (!$this->lain_harga_sekunder->IsDetailKey && EmptyValue($this->lain_harga_sekunder->FormValue)) {
                $this->lain_harga_sekunder->addErrorMessage(str_replace("%s", $this->lain_harga_sekunder->caption(), $this->lain_harga_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_sekunder->FormValue)) {
            $this->lain_harga_sekunder->addErrorMessage($this->lain_harga_sekunder->getErrorMessage(false));
        }
        if ($this->lain_harga_sekunder_order->Required) {
            if (!$this->lain_harga_sekunder_order->IsDetailKey && EmptyValue($this->lain_harga_sekunder_order->FormValue)) {
                $this->lain_harga_sekunder_order->addErrorMessage(str_replace("%s", $this->lain_harga_sekunder_order->caption(), $this->lain_harga_sekunder_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_sekunder_order->FormValue)) {
            $this->lain_harga_sekunder_order->addErrorMessage($this->lain_harga_sekunder_order->getErrorMessage(false));
        }
        if ($this->lain_harga_label->Required) {
            if (!$this->lain_harga_label->IsDetailKey && EmptyValue($this->lain_harga_label->FormValue)) {
                $this->lain_harga_label->addErrorMessage(str_replace("%s", $this->lain_harga_label->caption(), $this->lain_harga_label->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_label->FormValue)) {
            $this->lain_harga_label->addErrorMessage($this->lain_harga_label->getErrorMessage(false));
        }
        if ($this->lain_harga_label_order->Required) {
            if (!$this->lain_harga_label_order->IsDetailKey && EmptyValue($this->lain_harga_label_order->FormValue)) {
                $this->lain_harga_label_order->addErrorMessage(str_replace("%s", $this->lain_harga_label_order->caption(), $this->lain_harga_label_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_label_order->FormValue)) {
            $this->lain_harga_label_order->addErrorMessage($this->lain_harga_label_order->getErrorMessage(false));
        }
        if ($this->lain_harga_total->Required) {
            if (!$this->lain_harga_total->IsDetailKey && EmptyValue($this->lain_harga_total->FormValue)) {
                $this->lain_harga_total->addErrorMessage(str_replace("%s", $this->lain_harga_total->caption(), $this->lain_harga_total->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_total->FormValue)) {
            $this->lain_harga_total->addErrorMessage($this->lain_harga_total->getErrorMessage(false));
        }
        if ($this->lain_harga_total_order->Required) {
            if (!$this->lain_harga_total_order->IsDetailKey && EmptyValue($this->lain_harga_total_order->FormValue)) {
                $this->lain_harga_total_order->addErrorMessage(str_replace("%s", $this->lain_harga_total_order->caption(), $this->lain_harga_total_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_total_order->FormValue)) {
            $this->lain_harga_total_order->addErrorMessage($this->lain_harga_total_order->getErrorMessage(false));
        }
        if ($this->isi_bahan_aktif->Required) {
            if (!$this->isi_bahan_aktif->IsDetailKey && EmptyValue($this->isi_bahan_aktif->FormValue)) {
                $this->isi_bahan_aktif->addErrorMessage(str_replace("%s", $this->isi_bahan_aktif->caption(), $this->isi_bahan_aktif->RequiredErrorMessage));
            }
        }
        if ($this->isi_bahan_lain->Required) {
            if (!$this->isi_bahan_lain->IsDetailKey && EmptyValue($this->isi_bahan_lain->FormValue)) {
                $this->isi_bahan_lain->addErrorMessage(str_replace("%s", $this->isi_bahan_lain->caption(), $this->isi_bahan_lain->RequiredErrorMessage));
            }
        }
        if ($this->isi_parfum->Required) {
            if (!$this->isi_parfum->IsDetailKey && EmptyValue($this->isi_parfum->FormValue)) {
                $this->isi_parfum->addErrorMessage(str_replace("%s", $this->isi_parfum->caption(), $this->isi_parfum->RequiredErrorMessage));
            }
        }
        if ($this->isi_estetika->Required) {
            if (!$this->isi_estetika->IsDetailKey && EmptyValue($this->isi_estetika->FormValue)) {
                $this->isi_estetika->addErrorMessage(str_replace("%s", $this->isi_estetika->caption(), $this->isi_estetika->RequiredErrorMessage));
            }
        }
        if ($this->kemasan_wadah->Required) {
            if (!$this->kemasan_wadah->IsDetailKey && EmptyValue($this->kemasan_wadah->FormValue)) {
                $this->kemasan_wadah->addErrorMessage(str_replace("%s", $this->kemasan_wadah->caption(), $this->kemasan_wadah->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kemasan_wadah->FormValue)) {
            $this->kemasan_wadah->addErrorMessage($this->kemasan_wadah->getErrorMessage(false));
        }
        if ($this->kemasan_tutup->Required) {
            if (!$this->kemasan_tutup->IsDetailKey && EmptyValue($this->kemasan_tutup->FormValue)) {
                $this->kemasan_tutup->addErrorMessage(str_replace("%s", $this->kemasan_tutup->caption(), $this->kemasan_tutup->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kemasan_tutup->FormValue)) {
            $this->kemasan_tutup->addErrorMessage($this->kemasan_tutup->getErrorMessage(false));
        }
        if ($this->kemasan_sekunder->Required) {
            if (!$this->kemasan_sekunder->IsDetailKey && EmptyValue($this->kemasan_sekunder->FormValue)) {
                $this->kemasan_sekunder->addErrorMessage(str_replace("%s", $this->kemasan_sekunder->caption(), $this->kemasan_sekunder->RequiredErrorMessage));
            }
        }
        if ($this->label_desain->Required) {
            if (!$this->label_desain->IsDetailKey && EmptyValue($this->label_desain->FormValue)) {
                $this->label_desain->addErrorMessage(str_replace("%s", $this->label_desain->caption(), $this->label_desain->RequiredErrorMessage));
            }
        }
        if ($this->label_cetak->Required) {
            if (!$this->label_cetak->IsDetailKey && EmptyValue($this->label_cetak->FormValue)) {
                $this->label_cetak->addErrorMessage(str_replace("%s", $this->label_cetak->caption(), $this->label_cetak->RequiredErrorMessage));
            }
        }
        if ($this->label_lainlain->Required) {
            if (!$this->label_lainlain->IsDetailKey && EmptyValue($this->label_lainlain->FormValue)) {
                $this->label_lainlain->addErrorMessage(str_replace("%s", $this->label_lainlain->caption(), $this->label_lainlain->RequiredErrorMessage));
            }
        }
        if ($this->delivery_pickup->Required) {
            if (!$this->delivery_pickup->IsDetailKey && EmptyValue($this->delivery_pickup->FormValue)) {
                $this->delivery_pickup->addErrorMessage(str_replace("%s", $this->delivery_pickup->caption(), $this->delivery_pickup->RequiredErrorMessage));
            }
        }
        if ($this->delivery_singlepoint->Required) {
            if (!$this->delivery_singlepoint->IsDetailKey && EmptyValue($this->delivery_singlepoint->FormValue)) {
                $this->delivery_singlepoint->addErrorMessage(str_replace("%s", $this->delivery_singlepoint->caption(), $this->delivery_singlepoint->RequiredErrorMessage));
            }
        }
        if ($this->delivery_multipoint->Required) {
            if (!$this->delivery_multipoint->IsDetailKey && EmptyValue($this->delivery_multipoint->FormValue)) {
                $this->delivery_multipoint->addErrorMessage(str_replace("%s", $this->delivery_multipoint->caption(), $this->delivery_multipoint->RequiredErrorMessage));
            }
        }
        if ($this->delivery_jumlahpoint->Required) {
            if (!$this->delivery_jumlahpoint->IsDetailKey && EmptyValue($this->delivery_jumlahpoint->FormValue)) {
                $this->delivery_jumlahpoint->addErrorMessage(str_replace("%s", $this->delivery_jumlahpoint->caption(), $this->delivery_jumlahpoint->RequiredErrorMessage));
            }
        }
        if ($this->delivery_termslain->Required) {
            if (!$this->delivery_termslain->IsDetailKey && EmptyValue($this->delivery_termslain->FormValue)) {
                $this->delivery_termslain->addErrorMessage(str_replace("%s", $this->delivery_termslain->caption(), $this->delivery_termslain->RequiredErrorMessage));
            }
        }
        if ($this->catatan_khusus->Required) {
            if (!$this->catatan_khusus->IsDetailKey && EmptyValue($this->catatan_khusus->FormValue)) {
                $this->catatan_khusus->addErrorMessage(str_replace("%s", $this->catatan_khusus->caption(), $this->catatan_khusus->RequiredErrorMessage));
            }
        }
        if ($this->dibuatdi->Required) {
            if (!$this->dibuatdi->IsDetailKey && EmptyValue($this->dibuatdi->FormValue)) {
                $this->dibuatdi->addErrorMessage(str_replace("%s", $this->dibuatdi->caption(), $this->dibuatdi->RequiredErrorMessage));
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
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // idnpd
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->ReadOnly = true;
            }
            $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, $this->idnpd->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // tglsubmit
            $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, $this->tglsubmit->ReadOnly);

            // sifat_order
            $tmpBool = $this->sifat_order->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->sifat_order->setDbValueDef($rsnew, $tmpBool, 0, $this->sifat_order->ReadOnly);

            // ukuran_utama
            $this->ukuran_utama->setDbValueDef($rsnew, $this->ukuran_utama->CurrentValue, null, $this->ukuran_utama->ReadOnly);

            // utama_harga_isi
            $this->utama_harga_isi->setDbValueDef($rsnew, $this->utama_harga_isi->CurrentValue, null, $this->utama_harga_isi->ReadOnly);

            // utama_harga_isi_order
            $this->utama_harga_isi_order->setDbValueDef($rsnew, $this->utama_harga_isi_order->CurrentValue, null, $this->utama_harga_isi_order->ReadOnly);

            // utama_harga_primer
            $this->utama_harga_primer->setDbValueDef($rsnew, $this->utama_harga_primer->CurrentValue, null, $this->utama_harga_primer->ReadOnly);

            // utama_harga_primer_order
            $this->utama_harga_primer_order->setDbValueDef($rsnew, $this->utama_harga_primer_order->CurrentValue, null, $this->utama_harga_primer_order->ReadOnly);

            // utama_harga_sekunder
            $this->utama_harga_sekunder->setDbValueDef($rsnew, $this->utama_harga_sekunder->CurrentValue, null, $this->utama_harga_sekunder->ReadOnly);

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->setDbValueDef($rsnew, $this->utama_harga_sekunder_order->CurrentValue, null, $this->utama_harga_sekunder_order->ReadOnly);

            // utama_harga_label
            $this->utama_harga_label->setDbValueDef($rsnew, $this->utama_harga_label->CurrentValue, null, $this->utama_harga_label->ReadOnly);

            // utama_harga_label_order
            $this->utama_harga_label_order->setDbValueDef($rsnew, $this->utama_harga_label_order->CurrentValue, null, $this->utama_harga_label_order->ReadOnly);

            // utama_harga_total
            $this->utama_harga_total->setDbValueDef($rsnew, $this->utama_harga_total->CurrentValue, null, $this->utama_harga_total->ReadOnly);

            // utama_harga_total_order
            $this->utama_harga_total_order->setDbValueDef($rsnew, $this->utama_harga_total_order->CurrentValue, null, $this->utama_harga_total_order->ReadOnly);

            // ukuran_lain
            $this->ukuran_lain->setDbValueDef($rsnew, $this->ukuran_lain->CurrentValue, null, $this->ukuran_lain->ReadOnly);

            // lain_harga_isi
            $this->lain_harga_isi->setDbValueDef($rsnew, $this->lain_harga_isi->CurrentValue, null, $this->lain_harga_isi->ReadOnly);

            // lain_harga_isi_order
            $this->lain_harga_isi_order->setDbValueDef($rsnew, $this->lain_harga_isi_order->CurrentValue, null, $this->lain_harga_isi_order->ReadOnly);

            // lain_harga_primer
            $this->lain_harga_primer->setDbValueDef($rsnew, $this->lain_harga_primer->CurrentValue, null, $this->lain_harga_primer->ReadOnly);

            // lain_harga_primer_order
            $this->lain_harga_primer_order->setDbValueDef($rsnew, $this->lain_harga_primer_order->CurrentValue, null, $this->lain_harga_primer_order->ReadOnly);

            // lain_harga_sekunder
            $this->lain_harga_sekunder->setDbValueDef($rsnew, $this->lain_harga_sekunder->CurrentValue, null, $this->lain_harga_sekunder->ReadOnly);

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->setDbValueDef($rsnew, $this->lain_harga_sekunder_order->CurrentValue, null, $this->lain_harga_sekunder_order->ReadOnly);

            // lain_harga_label
            $this->lain_harga_label->setDbValueDef($rsnew, $this->lain_harga_label->CurrentValue, null, $this->lain_harga_label->ReadOnly);

            // lain_harga_label_order
            $this->lain_harga_label_order->setDbValueDef($rsnew, $this->lain_harga_label_order->CurrentValue, null, $this->lain_harga_label_order->ReadOnly);

            // lain_harga_total
            $this->lain_harga_total->setDbValueDef($rsnew, $this->lain_harga_total->CurrentValue, null, $this->lain_harga_total->ReadOnly);

            // lain_harga_total_order
            $this->lain_harga_total_order->setDbValueDef($rsnew, $this->lain_harga_total_order->CurrentValue, null, $this->lain_harga_total_order->ReadOnly);

            // isi_bahan_aktif
            $this->isi_bahan_aktif->setDbValueDef($rsnew, $this->isi_bahan_aktif->CurrentValue, null, $this->isi_bahan_aktif->ReadOnly);

            // isi_bahan_lain
            $this->isi_bahan_lain->setDbValueDef($rsnew, $this->isi_bahan_lain->CurrentValue, null, $this->isi_bahan_lain->ReadOnly);

            // isi_parfum
            $this->isi_parfum->setDbValueDef($rsnew, $this->isi_parfum->CurrentValue, null, $this->isi_parfum->ReadOnly);

            // isi_estetika
            $this->isi_estetika->setDbValueDef($rsnew, $this->isi_estetika->CurrentValue, null, $this->isi_estetika->ReadOnly);

            // kemasan_wadah
            $this->kemasan_wadah->setDbValueDef($rsnew, $this->kemasan_wadah->CurrentValue, null, $this->kemasan_wadah->ReadOnly);

            // kemasan_tutup
            $this->kemasan_tutup->setDbValueDef($rsnew, $this->kemasan_tutup->CurrentValue, null, $this->kemasan_tutup->ReadOnly);

            // kemasan_sekunder
            $this->kemasan_sekunder->setDbValueDef($rsnew, $this->kemasan_sekunder->CurrentValue, null, $this->kemasan_sekunder->ReadOnly);

            // label_desain
            $this->label_desain->setDbValueDef($rsnew, $this->label_desain->CurrentValue, null, $this->label_desain->ReadOnly);

            // label_cetak
            $this->label_cetak->setDbValueDef($rsnew, $this->label_cetak->CurrentValue, null, $this->label_cetak->ReadOnly);

            // label_lainlain
            $this->label_lainlain->setDbValueDef($rsnew, $this->label_lainlain->CurrentValue, null, $this->label_lainlain->ReadOnly);

            // delivery_pickup
            $this->delivery_pickup->setDbValueDef($rsnew, $this->delivery_pickup->CurrentValue, null, $this->delivery_pickup->ReadOnly);

            // delivery_singlepoint
            $this->delivery_singlepoint->setDbValueDef($rsnew, $this->delivery_singlepoint->CurrentValue, null, $this->delivery_singlepoint->ReadOnly);

            // delivery_multipoint
            $this->delivery_multipoint->setDbValueDef($rsnew, $this->delivery_multipoint->CurrentValue, null, $this->delivery_multipoint->ReadOnly);

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->setDbValueDef($rsnew, $this->delivery_jumlahpoint->CurrentValue, null, $this->delivery_jumlahpoint->ReadOnly);

            // delivery_termslain
            $this->delivery_termslain->setDbValueDef($rsnew, $this->delivery_termslain->CurrentValue, null, $this->delivery_termslain->ReadOnly);

            // catatan_khusus
            $this->catatan_khusus->setDbValueDef($rsnew, $this->catatan_khusus->CurrentValue, null, $this->catatan_khusus->ReadOnly);

            // dibuatdi
            $this->dibuatdi->setDbValueDef($rsnew, $this->dibuatdi->CurrentValue, null, $this->dibuatdi->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), $this->created_at->ReadOnly);

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
            $this->setSessionWhere($this->getDetailFilter());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdTermsList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_sifat_order":
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
