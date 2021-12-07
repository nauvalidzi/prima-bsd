<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdView extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdView";

    // Rendering View
    public $RenderingView = false;

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->RecKey["id"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

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

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;
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
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->status->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idproduct_acuan->setVisibility();
        $this->idjenisproduk->setVisibility();
        $this->idkategoriproduk->setVisibility();
        $this->fungsiproduk->setVisibility();
        $this->kualitasproduk->setVisibility();
        $this->bahan_campaign->setVisibility();
        $this->ukuran_sediaan->setVisibility();
        $this->bentuk->setVisibility();
        $this->viskositas->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->aplikasi->setVisibility();
        $this->estetika->setVisibility();
        $this->tambahan->setVisibility();
        $this->ukurankemasan->setVisibility();
        $this->kemasanbentuk->setVisibility();
        $this->kemasantutup->setVisibility();
        $this->kemasancatatan->setVisibility();
        $this->labelbahan->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->setVisibility();
        $this->statusdokumen->setVisibility();
        $this->readonly->setVisibility();
        $this->selesai->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->hideFieldsForAddEdit();

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
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->idjenisproduk);
        $this->setupLookupOptions($this->idkategoriproduk);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->estetika);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->RecKey["id"] = $this->id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } else {
                $returnUrl = "NpdList"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "NpdList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "NpdList"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Set up detail parameters
        $this->setupDetailParms();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());
        $option = $options["detail"];
        $detailTableLink = "";
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_npd_sample"
        $item = &$option->add("detail_npd_sample");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("npd_sample", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("npd_sample")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("NpdSampleList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("NpdSampleGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "npd_sample";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "npd_sample";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_sample');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "npd_sample";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_npd_review"
        $item = &$option->add("detail_npd_review");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("npd_review", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("npd_review")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("NpdReviewList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("NpdReviewGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "npd_review";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "npd_review";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_review');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "npd_review";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_npd_confirm"
        $item = &$option->add("detail_npd_confirm");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("npd_confirm", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("npd_confirm")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("NpdConfirmList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("NpdConfirmGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "npd_confirm";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "npd_confirm";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_confirm');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "npd_confirm";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_npd_harga"
        $item = &$option->add("detail_npd_harga");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("npd_harga", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("npd_harga")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("NpdHargaList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("NpdHargaGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "npd_harga";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "npd_harga";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_harga');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "npd_harga";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_npd_desain"
        $item = &$option->add("detail_npd_desain");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("npd_desain", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("npd_desain")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("NpdDesainList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("NpdDesainGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "npd_desain";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "npd_desain";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_desain');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "npd_desain";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_npd_terms"
        $item = &$option->add("detail_npd_terms");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("npd_terms", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("npd_terms")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("NpdTermsList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("NpdTermsGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "npd_terms";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "npd_terms";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_terms');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "npd_terms";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailCopyLink")) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlTitle($Language->phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $item = &$option->add("details");
            $item->Body = $body;
        }

        // Set up detail default
        $option = $options["detail"];
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $ar = explode(",", $detailTableLink);
        $cnt = count($ar);
        $option->UseDropDownButton = ($cnt > 1);
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->status->setDbValue($row['status']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idjenisproduk->setDbValue($row['idjenisproduk']);
        $this->idkategoriproduk->setDbValue($row['idkategoriproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->estetika->setDbValue($row['estetika']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->statusdokumen->setDbValue($row['statusdokumen']);
        $this->readonly->setDbValue($row['readonly']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $detailTbl = Container("npd_sample");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_review");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_confirm");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_harga");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_desain");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_terms");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['tanggal_order'] = null;
        $row['target_selesai'] = null;
        $row['status'] = null;
        $row['kodeorder'] = null;
        $row['nomororder'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['idproduct_acuan'] = null;
        $row['idjenisproduk'] = null;
        $row['idkategoriproduk'] = null;
        $row['fungsiproduk'] = null;
        $row['kualitasproduk'] = null;
        $row['bahan_campaign'] = null;
        $row['ukuran_sediaan'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['aplikasi'] = null;
        $row['estetika'] = null;
        $row['tambahan'] = null;
        $row['ukurankemasan'] = null;
        $row['kemasanbentuk'] = null;
        $row['kemasantutup'] = null;
        $row['kemasancatatan'] = null;
        $row['labelbahan'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['statusdokumen'] = null;
        $row['readonly'] = null;
        $row['selesai'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // tanggal_order

        // target_selesai

        // status

        // kodeorder

        // nomororder

        // idpegawai

        // idcustomer

        // idproduct_acuan

        // idjenisproduk

        // idkategoriproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuran_sediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // estetika

        // tambahan

        // ukurankemasan

        // kemasanbentuk

        // kemasantutup

        // kemasancatatan

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // statusdokumen

        // readonly

        // selesai

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->ViewValue = $this->nomororder->CurrentValue;
            $this->nomororder->ViewCustomAttributes = "";

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
            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
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

            // idproduct_acuan
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
                if ($this->idproduct_acuan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idproduct_acuan->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idproduct_acuan->Lookup->renderViewRow($rswrk[0]);
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->displayValue($arwrk);
                    } else {
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
                    }
                }
            } else {
                $this->idproduct_acuan->ViewValue = null;
            }
            $this->idproduct_acuan->ViewCustomAttributes = "";

            // idjenisproduk
            $curVal = trim(strval($this->idjenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->idjenisproduk->ViewValue = $this->idjenisproduk->lookupCacheOption($curVal);
                if ($this->idjenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idjenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idjenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->idjenisproduk->ViewValue = $this->idjenisproduk->displayValue($arwrk);
                    } else {
                        $this->idjenisproduk->ViewValue = $this->idjenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->idjenisproduk->ViewValue = null;
            }
            $this->idjenisproduk->ViewCustomAttributes = "";

            // idkategoriproduk
            $curVal = trim(strval($this->idkategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->lookupCacheOption($curVal);
                if ($this->idkategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->displayValue($arwrk);
                    } else {
                        $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->idkategoriproduk->ViewValue = null;
            }
            $this->idkategoriproduk->ViewCustomAttributes = "";

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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->bentuk->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->bentuk->Lookup->renderViewRow($row);
                            $this->bentuk->ViewValue->add($this->bentuk->displayValue($arwrk));
                        }
                    } else {
                        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
                    }
                }
            } else {
                $this->bentuk->ViewValue = null;
            }
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
                if ($this->viskositas->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->viskositas->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->viskositas->Lookup->renderViewRow($row);
                            $this->viskositas->ViewValue->add($this->viskositas->displayValue($arwrk));
                        }
                    } else {
                        $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
                    }
                }
            } else {
                $this->viskositas->ViewValue = null;
            }
            $this->viskositas->ViewCustomAttributes = "";

            // warna
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
                if ($this->warna->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->warna->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->warna->Lookup->renderViewRow($row);
                            $this->warna->ViewValue->add($this->warna->displayValue($arwrk));
                        }
                    } else {
                        $this->warna->ViewValue = $this->warna->CurrentValue;
                    }
                }
            } else {
                $this->warna->ViewValue = null;
            }
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->parfum->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->parfum->Lookup->renderViewRow($row);
                            $this->parfum->ViewValue->add($this->parfum->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->aplikasi->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->aplikasi->Lookup->renderViewRow($row);
                            $this->aplikasi->ViewValue->add($this->aplikasi->displayValue($arwrk));
                        }
                    } else {
                        $this->aplikasi->ViewValue = $this->aplikasi->CurrentValue;
                    }
                }
            } else {
                $this->aplikasi->ViewValue = null;
            }
            $this->aplikasi->ViewCustomAttributes = "";

            // estetika
            $curVal = trim(strval($this->estetika->CurrentValue));
            if ($curVal != "") {
                $this->estetika->ViewValue = $this->estetika->lookupCacheOption($curVal);
                if ($this->estetika->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->estetika->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->estetika->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->estetika->Lookup->renderViewRow($row);
                            $this->estetika->ViewValue->add($this->estetika->displayValue($arwrk));
                        }
                    } else {
                        $this->estetika->ViewValue = $this->estetika->CurrentValue;
                    }
                }
            } else {
                $this->estetika->ViewValue = null;
            }
            $this->estetika->ViewCustomAttributes = "";

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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelbahan->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelbahan->Lookup->renderViewRow($row);
                            $this->labelbahan->ViewValue->add($this->labelbahan->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelkualitas->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelkualitas->Lookup->renderViewRow($row);
                            $this->labelkualitas->ViewValue->add($this->labelkualitas->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelposisi->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelposisi->Lookup->renderViewRow($row);
                            $this->labelposisi->ViewValue->add($this->labelposisi->displayValue($arwrk));
                        }
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

            // statusdokumen
            $this->statusdokumen->ViewValue = $this->statusdokumen->CurrentValue;
            $this->statusdokumen->ViewCustomAttributes = "";

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
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";
            $this->nomororder->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";
            $this->idproduct_acuan->TooltipValue = "";

            // idjenisproduk
            $this->idjenisproduk->LinkCustomAttributes = "";
            $this->idjenisproduk->HrefValue = "";
            $this->idjenisproduk->TooltipValue = "";

            // idkategoriproduk
            $this->idkategoriproduk->LinkCustomAttributes = "";
            $this->idkategoriproduk->HrefValue = "";
            $this->idkategoriproduk->TooltipValue = "";

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

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";
            $this->estetika->TooltipValue = "";

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

            // statusdokumen
            $this->statusdokumen->LinkCustomAttributes = "";
            $this->statusdokumen->HrefValue = "";
            $this->statusdokumen->TooltipValue = "";

            // selesai
            $this->selesai->LinkCustomAttributes = "";
            $this->selesai->HrefValue = "";
            $this->selesai->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idjenisproduk":
                    break;
                case "x_idkategoriproduk":
                    break;
                case "x_bentuk":
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_parfum":
                    break;
                case "x_aplikasi":
                    break;
                case "x_estetika":
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
        $this->OtherOptions["action"]->Items["add"]->Visible = false;
        if ($this->readonly->CurrentValue) {
        	$this->OtherOptions["action"]->Items["edit"]->Visible = false;
        	$this->OtherOptions["action"]->Items["delete"]->Visible = false;
        }
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

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }
}
