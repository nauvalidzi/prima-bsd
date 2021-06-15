<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdReviewDelete extends NpdReview
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_review';

    // Page object name
    public $PageObjName = "NpdReviewDelete";

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->idnpd->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->tglreview->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->wadah->Visible = false;
        $this->bentukok->Visible = false;
        $this->bentukrevisi->Visible = false;
        $this->viskositasok->Visible = false;
        $this->viskositasrevisi->Visible = false;
        $this->jeniswarnaok->Visible = false;
        $this->jeniswarnarevisi->Visible = false;
        $this->tonewarnaok->Visible = false;
        $this->tonewarnarevisi->Visible = false;
        $this->gradasiwarnaok->Visible = false;
        $this->gradasiwarnarevisi->Visible = false;
        $this->bauok->Visible = false;
        $this->baurevisi->Visible = false;
        $this->estetikaok->Visible = false;
        $this->estetikarevisi->Visible = false;
        $this->aplikasiawalok->Visible = false;
        $this->aplikasiawalrevisi->Visible = false;
        $this->aplikasilamaok->Visible = false;
        $this->aplikasilamarevisi->Visible = false;
        $this->efekpositifok->Visible = false;
        $this->efekpositifrevisi->Visible = false;
        $this->efeknegatifok->Visible = false;
        $this->efeknegatifrevisi->Visible = false;
        $this->kesimpulan->Visible = false;
        $this->status->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->Visible = false;
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

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("NpdReviewList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Check if valid User ID
        $conn = $this->getConnection();
        $sql = $this->getSql($this->CurrentFilter);
        $rows = $conn->fetchAll($sql);
        $res = true;
        foreach ($rows as $row) {
            $this->loadRowValues($row);
            if (!$this->showOptionLink("delete")) {
                $userIdMsg = $Language->phrase("NoDeletePermission");
                $this->setFailureMessage($userIdMsg);
                $res = false;
                break;
            }
        }
        if (!$res) {
            $this->terminate("NpdReviewList"); // Return to list
            return;
        }

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("NpdReviewList"); // Return to list
                return;
            }
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

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['idnpd_sample'] = null;
        $row['tglreview'] = null;
        $row['tglsubmit'] = null;
        $row['wadah'] = null;
        $row['bentukok'] = null;
        $row['bentukrevisi'] = null;
        $row['viskositasok'] = null;
        $row['viskositasrevisi'] = null;
        $row['jeniswarnaok'] = null;
        $row['jeniswarnarevisi'] = null;
        $row['tonewarnaok'] = null;
        $row['tonewarnarevisi'] = null;
        $row['gradasiwarnaok'] = null;
        $row['gradasiwarnarevisi'] = null;
        $row['bauok'] = null;
        $row['baurevisi'] = null;
        $row['estetikaok'] = null;
        $row['estetikarevisi'] = null;
        $row['aplikasiawalok'] = null;
        $row['aplikasiawalrevisi'] = null;
        $row['aplikasilamaok'] = null;
        $row['aplikasilamarevisi'] = null;
        $row['efekpositifok'] = null;
        $row['efekpositifrevisi'] = null;
        $row['efeknegatifok'] = null;
        $row['efeknegatifrevisi'] = null;
        $row['kesimpulan'] = null;
        $row['status'] = null;
        $row['created_at'] = null;
        $row['created_by'] = null;
        $row['readonly'] = null;
        return $row;
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

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        $conn->beginTransaction();

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }
}
