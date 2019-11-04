<?php

$Member_Code = isset($_REQUEST['member_code'])?$_REQUEST['member_code']:'0';

// prevent from a PHP configuration problem when using mktime() and date()
if (version_compare(PHP_VERSION,'5.1.0')>=0) {
    if (ini_get('date.timezone')=='') {
        date_default_timezone_set('UTC');
    }
}

$sql = "
SELECT DISTINCT
  `members_profile`.`Member_Code`        AS `Member_Code`,
  `members_profile`.`Fname`              AS `Fname`,
  `members_profile`.`Mname`              AS `Mname`,
  `members_profile`.`Lname`              AS `Lname`,
  ((((`members_profile`.`Lname` + ',  ') + `members_profile`.`Fname`) + ' ') + `members_profile`.`Mname`) AS `Fullname`,
  `members_profile`.`Nname`              AS `Nname`,
  `members_profile`.`Sex`                AS `Sex`,
  `members_profile`.`Status`             AS `Status`,
  `members_profile`.`Address`            AS `Address`,
  `members_profile`.`IDno`               AS `IDno`,
  `members_profile`.`Bdate`              AS `Bdate`,
  `members_profile`.`Age`                AS `Age`,
  `members_profile`.`Bplace`             AS `Bplace`,
  `members_profile`.`Occupation`         AS `Occupation`,
  `members_profile`.`Religion`           AS `religion`,
  `members_profile`.`Pname`              AS `pname`,
  `members_profile`.`Page`               AS `page`,
  `members_profile`.`Prelation`          AS `prelation`,
  `members_profile`.`Pcontactno`         AS `pcontactno`,
  `members_profile`.`CAddress`           AS `CollectionAddress`,
  `members_profile`.`Mcontactno`         AS `mcontactno`,
  `members_profile`.`Bname`              AS `bname`,
  `members_profile`.`Bbdate`             AS `bbdate`,
  `members_profile`.`Bage`               AS `bage`,
  `members_profile`.`Brelation`          AS `brelation`,
  `members_profile`.`Bstatus`            AS `bstatus`,
  `members_profile`.`Bcontactno`         AS `bcontactno`,
  `members_profile`.`Dname1`             AS `dname1`,
  `members_profile`.`Dbdate1`            AS `dbdate1`,
  `members_profile`.`Dage1`              AS `dage1`,
  `members_profile`.`Drelation1`         AS `drelation1`,
  `members_profile`.`Dstatus1`           AS `dstatus1`,
  `members_profile`.`Dname2`             AS `dname2`,
  `members_profile`.`Dbdate2`            AS `dbdate2`,
  `members_profile`.`Dage2`              AS `dage2`,
  `members_profile`.`Drelation2`         AS `drelation2`,
  `members_profile`.`Dstatus2`           AS `dstatus2`,
  `members_profile`.`Dname3`             AS `dname3`,
  `members_profile`.`Dbdate3`            AS `dbdate3`,
  `members_profile`.`Dage3`              AS `dage3`,
  `members_profile`.`Drelation3`         AS `drelation3`,
  `members_profile`.`Dstatus3`           AS `dstatus3`,
  `members_profile`.`Dname4`             AS `dname4`,
  `members_profile`.`Dbdate4`            AS `dbdate4`,
  `members_profile`.`Dage4`              AS `dage4`,
  `members_profile`.`Drelation4`         AS `drelation4`,
  `members_profile`.`Dstatus4`           AS `dstatus4`,
  `packages`.`Plan_Code`                 AS `plan_code`,
  `packages`.`form_number`               AS `form_number`,
  `members_account`.`No_of_units`        AS `no_of_units`,
  `agent_profile`.`Initials`             AS `agent`,
  `agent_profile`.`AgentID`              AS `agent_id`,
  CONCAT(`agent_profile`.`First_name`,' ',LEFT(`agent_profile`.`Middle_Name`,1),'. ',`agent_profile`.`Last_name`) AS `agent_fullname`,
  `members_account`.`Insurance_Type`     AS `insurance_type`,
  `members_account`.`Date_of_membership` AS `date_of_membership`,
  `members_account`.`Current_term`       AS `current_term`,
  `members_account`.`Account_Status`     AS `account_status`,
  `members_account`.`Remarks`            AS `remarks`,
  `agent_profile_ao`.`Initials`          AS `AO`,
  `bd`.`Branch_Manager`                  AS `branch_manager`,
  `bd`.`BManager_Initials`               AS `BManager_Initials`,
  `members_account`.`PRdate`             AS `PRdate`,
  `members_account`.`PRno`               AS `PRno`,
  `members_account`.`ORdate`             AS `ORdate`,
  `members_account`.`ORno`               AS `ORno`,
  `members_account`.`Amount`             AS `amount`,
  `agentfullname`.`An`                   AS `AgentName`,
  `aofullname`.`An`                      AS `AOname`,
  `planname`.`Plan_name`                 AS `plan_name`,
  `bd`.`Branch_Name`                     AS `Branch_name`,
  `packages`.`Plan_id`                   AS `Plan_id`
FROM `branch_details`
JOIN `members_account`
JOIN `branch_details` `bd`
ON `members_account`.`BranchManager` = `bd`.`Branch_ID`
JOIN `agent_profile`
ON `members_account`.`AO` = `agent_profile`.`AgentID`
JOIN `agent_profile` `agent_profile_ao`
ON `members_account`.`AgentID` = `agent_profile_ao`.`AgentID`
JOIN `packages`
ON `members_account`.`Plan_id` = `packages`.`Plan_id`
JOIN `members_profile`
ON `members_account`.`Member_Code` = `members_profile`.`Member_Code`
JOIN `agentfullname`
ON `members_account`.`Member_Code` = `agentfullname`.`Member_Code`
JOIN `aofullname`
ON `members_account`.`Member_Code` = `aofullname`.`Member_Code`
JOIN `planname`
ON `members_account`.`Member_Code` = `planname`.`Member_Code`
WHERE `members_account`.Member_Code = '$Member_Code';
";

include '../dbconnect.php';

// prepare data to display
$res_data = mysqli_query($con,$sql) or die(mysqli_error());

if (mysqli_num_rows($res_data) > 0) {

    $r=mysqli_fetch_array($res_data,MYSQLI_ASSOC);

    // Include classes
    include_once('tbs_class.php'); // Load the TinyButStrong template engine
    include_once('tbs_plugin_opentbs.php'); // Load the OpenTBS plugin


    // Initialize the TBS instance
    $TBS = new clsTinyButStrong; // new instance of TBS
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

    $form_number = $r['form_number'];

    //member data
    $fname = $r['Fname'];
    $mname = $r['Mname'];
    $lname = $r['Lname'];
    $nick =  $r['Nname'];
    $sex = $r['Sex'];
    $cstatus = $r['Status'];


    //todo: convert to address
    //$purok = "";
    //$brgy = "zone iii";
    //$city = "koronadal city";
    //$prov = "south cotabato";
    $address = $r['Address'];
    
    $valid_id = $r['IDno'];

    $dob=$r['Bdate'];
    $age=$r['Age'];
    $pob=$r['Bplace'];
    $occupation=$r['Occupation'];
    $religion=$r["religion"];

    //payor
    $p_name = $r["pname"];
    $p_age = $r["page"];
    $p_relation = $r["prelation"];
    $p_cont = $r["pcontactno"];

    //todo: same with mem address
    //$p_prk = "bumanaag";
    //$p_brgy = "zone iii";
    //$p_city = "koronadal city";
    //$p_prov = "south cotabato";
    $p_address = $r['Address'];

    //member
    $m_cont = $r["mcontactno"];

    //beneficiary
    $b_cont = $r["bcontactno"];
    $b_name = $r["bname"];
    $b_dob = $r["bbdate"];
    $b_age = $r["bage"];
    $b_relation = $r["brelation"];
    $b_cstatus = $r["bstatus"];

    //agent
    $a_name=$r["AgentName"];
    $a_id="";
    $a_code="";
    $a_branch=$r["Branch_name"];
    $a_branchcode="";

    //payment
    $prdate=$r["PRdate"];
    $prno=$r["PRno"];
    $ordate=$r["ORdate"];
    $orno=$r["ORno"];
    $amount=$r["amount"];
    $cdate=$r["ORdate"];
    $caddress=$r["CollectionAddress"];

    // -----------------
    // Load the template
    // -----------------

    $template = "./templates/$form_number.docx";
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

    // Delete comments
    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

    // -----------------
    // Output the result
    // -----------------

// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = "./rendered/$Member_Code"."_policy.docx";
    //$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
    $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
    exit("**success**");


}else{
    echo "**not_found**";
}




include '../dbclose.php';
