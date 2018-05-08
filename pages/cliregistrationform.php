


<?php

//-- DATA ENTRIES -----------------------------------------------------------------



$viewonly = false;
$user_mode="";
if ($viewonly) $user_mode = "disabled";


$res_branch = mysql_query("SELECT BRANCH_CODE, BRANCH_NAME, BRANCH_MANAGER FROM branch_details GROUP BY BRANCH_CODE;") or die(mysql_error());
$res_insurace = mysql_query("SELECT CODE AS INS_CODE, NAME AS INS_NAME FROM insurance ") or die(mysql_error());
$res_ao = mysql_query("SELECT INITIALS AS AO, AN AS 'AO_NAME' FROM aofullname GROUP BY AN, INITIALS;") or die(mysql_error());
$res_agent = mysql_query("SELECT     `An` AS `AGENT_NAME`     , `Initials` AS `AGENT_ID` FROM     `dmcsm`.`agentfullname` GROUP BY `AGENT_ID`, `AGENT_NAME`;") or die(mysql_error());
$res_plan = mysql_query("SELECT Plan_Code, plan_name FROM packages GROUP BY Plan_Code, plan_name;") or die(mysql_error());

$Member_Code='';
        $ddFname='';
        $ddMname='';
        $ddLname='';
        $ddFullname='';
        $ddNname='';
        $ddSex='';
        $ddcStatus='';
        $ddStreet='';
        $ddBarangay='';
        $ddCity='';
        $ddProvince='';
        $ddIDno='';
        $ddBdate='';
        $ddAge='';
        $ddBplace='';
        $ddOccupation='';
        $ddreligion='';
        $ddpname='';
        $ddpage='';
        $ddprelation='';
        $ddpcontactno='';
        $ddcstreet='';
        $ddcbarangay='';
        $ddccity='';
        $ddcprovince='';
        $ddmcontactno='';
        $ddbname='';
        $ddbbdate='';
        $ddbage='';
        $ddbrelation='';
        $ddbstatus='';
        $ddbcontactno='';
        $dddname1='';
        $dddbdate1='';
        $dddage1='';
        $dddrelation1='';
        $dddstatus1='';
        $dddname2='';
        $dddbdate2='';
        $dddage2='';
        $dddrelation2='';
        $dddstatus2='';
        $dddname3='';
        $dddbdate3='';
        $dddage3='';
        $dddrelation3='';
        $dddstatus3='';
        $dddname4='';
        $dddbdate4='';
        $dddage4='';
        $dddrelation4='';
        $dddstatus4='';
        $ddplan_code='';
        $ddno_of_units='';
        $ddagent='';
        $ddinsurance_type='';
        $dddate_of_membership='';
        $ddcurrent_term='';
        $ddaccount_status='';
        $ddremarks='';
        $ddAO='';
        $ddBM='';
        $ddPRdate='';
        $ddPRno='';
        $ddORdate='';
        $ddORno='';
        $ddamount='';
        $ddAgentName='';
        $ddAOname='';
        $ddplan_name='';
        $ddBranch_name='';



$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'none');
if ($Member_Code!='none'){
    $res_membership_form = mysql_query("SELECT * FROM membership_form WHERE Member_Code = '$Member_Code'") or die(mysql_error());
    $rr = mysql_fetch_array($res_membership_form,MYSQL_ASSOC);    
        

        $Member_Code=$rr['Member_Code'];
        $ddFname=$rr['Fname'];
        $ddMname=$rr['Mname'];
        $ddLname=$rr['Lname'];
        $ddFullname=$rr['Fullname'];
        $ddNname=$rr['Nname'];
        $ddSex=$rr['Sex'];
        $ddcStatus=$rr['Status'];
        $ddStreet=$rr['Street'];
        $ddBarangay=$rr['Barangay'];
        $ddCity=$rr['City'];
        $ddProvince=$rr['Province'];
        $ddIDno=$rr['IDno'];
        $ddBdate=$rr['Bdate'];
        $ddAge=$rr['Age'];
        $ddBplace=$rr['Bplace'];
        $ddOccupation=$rr['Occupation'];
        $ddreligion=$rr['religion'];
        $ddpname=$rr['pname'];
        $ddpage=$rr['page'];
        $ddprelation=$rr['prelation'];
        $ddpcontactno=$rr['pcontactno'];
        $ddcstreet=$rr['cstreet'];
        $ddcbarangay=$rr['cbarangay'];
        $ddccity=$rr['ccity'];
        $ddcprovince=$rr['cprovince'];
        $ddmcontactno=$rr['mcontactno'];
        $ddbname=$rr['bname'];
        $ddbbdate=$rr['bbdate'];
        $ddbage=$rr['bage'];
        $ddbrelation=$rr['brelation'];
        $ddbstatus=$rr['bstatus'];
        $ddbcontactno=$rr['bcontactno'];
        $dddname1=$rr['dname1'];
        $dddbdate1=$rr['dbdate1'];
        $dddage1=$rr['dage1'];
        $dddrelation1=$rr['drelation1'];
        $dddstatus1=$rr['dstatus1'];
        $dddname2=$rr['dname2'];
        $dddbdate2=$rr['dbdate2'];
        $dddage2=$rr['dage2'];
        $dddrelation2=$rr['drelation2'];
        $dddstatus2=$rr['dstatus2'];
        $dddname3=$rr['dname3'];
        $dddbdate3=$rr['dbdate3'];
        $dddage3=$rr['dage3'];
        $dddrelation3=$rr['drelation3'];
        $dddstatus3=$rr['dstatus3'];
        $dddname4=$rr['dname4'];
        $dddbdate4=$rr['dbdate4'];
        $dddage4=$rr['dage4'];
        $dddrelation4=$rr['drelation4'];
        $dddstatus4=$rr['dstatus4'];
        $ddplan_code=$rr['plan_code'];
        $ddno_of_units=$rr['no_of_units'];
        $ddagent=$rr['agent'];
        $ddinsurance_type=$rr['insurance_type'];
        $dddate_of_membership=$rr['date_of_membership'];
        $ddcurrent_term=$rr['current_term'];
        $ddaccount_status=$rr['account_status'];
        $ddremarks=$rr['remarks'];
        $ddAO=$rr['AO'];
        $ddBM=$rr['BM'];
        $ddPRdate=$rr['PRdate'];
        $ddPRno=$rr['PRno'];
        $ddORdate=$rr['ORdate'];
        $ddORno=$rr['ORno'];
        $ddamount=$rr['amount'];
        $ddAgentName=$rr['AgentName'];
        $ddAOname=$rr['AOname'];
        $ddplan_name=$rr['plan_name'];
        $ddBranch_name=$rr['Branch_name'];
  
    
}

        
?>

            <div class="content">
               <form id=cliregistrationformID >  

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h3 class="page-header">Member's Account Detail</h3>
                                </div>
                                <div class="col-lg-2">
                                   <BR><BR>
                                   
                                   <span class=" pull-right">
                                   <a href="javascript:history.back()" class="btn btn-danger btn-md" ><i class="glyphicon glyphicon-remove" ></i> CANCEL</a>
                                   <button class="btn btn-success btn-md" id=cliregistrationform_submit name="cliregistrationform_submit"><i class="fa fa-save" ></i> SAVE</button>
                                   </span>
                                    
                                </div>
 
                            </div>

                                <div class="card-content table-responsive">


                                <div class="panel panel-default">
                                  <div class="panel-heading">CLIENT'S INFORMATION </div>
                                  <div class="panel-body">
                                        <!-- Line 1 -->
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Surname <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aasurname value="<?=$ddLname ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">First Name <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aafirstname  value="<?=$ddFname ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Middle Name <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aamiddlename  value="<?=$ddMname ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>

                                        <?php
                                        $selMale = "";
                                        $selFemale = "";
                                        if ($ddSex == "Male") $selMale = " selected ";
                                        if ($ddSex == "Female") $selFemale = " selected ";
                                        ?>

                                        <div class="col-sm-1">
                                            <div class="form-group label-floating" >
                                                <label class="control-label">Sex <font color="red">*</font></label>
                                                <select class="form-control" id=aasex  <?=$user_mode?> required>
                                                  <option value="">Select</option>
                                                  <option value="Male" <?=$selMale ?>>Male</option>
                                                  <option value="Female" <?=$selFemale ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        $selSingle = "";
                                        $selMarried = "";
                                        $selWidow = "";

                                        if ($ddcStatus == "Single") $selSingle = " selected ";
                                        if ($ddcStatus == "Married") $selMarried = " selected ";
                                        if ($ddcStatus == "Widow") $selWidow = " selected ";
                                        ?>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Civil Status <font color="red">*</font></label>
                                                <select class="form-control" id=aacivilstatus  <?=$user_mode?> required>
                                                  <option value="">Select</option>
                                                  <option value="Single" <?=$selSingle ?>>Single</option>
                                                  <option value="Married" <?=$selMarried ?>>Married</option>
                                                  <option value="Widow" <?=$selWidow ?>>Widow</option>
                                                </select>

                                            </div>
                                        </div>


                                        <!-- Line 2 -->
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Purok/Street <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapurok value="<?=$ddStreet ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Barangay <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aabarangay value="<?=$ddBarangay ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Mun./City <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aamunicipality value="<?=$ddCity ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Province <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aaprovince value="<?=$ddProvince ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>                                
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Any Valid ID no. </label>
                                                <input type="text" class="form-control" id=aavalidid value="<?=$ddIDno ?>"  <?=$user_mode?> >
                                            </div>
                                        </div>   

                                         <!-- Line 3 -->
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating" >
                                                <label class="control-label">Birth Date <font color="red">*</font></label>
                                                <input type="date" class="form-control" id=aabirthdate value="<?=($ddBdate==''?'1900-01-01':$ddBdate) ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Age</label>
                                                <input type="text" class="form-control" id=aaage value="<?=$ddAge ?>"  <?=$user_mode?> disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Birth Place <font color="red">*</font></label>
                                                <input type="text" class="form-control"  id=aabithplace value="<?=$ddBplace ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Occupation </label>
                                                <input type="text" class="form-control" id=aaoccupation value="<?=$ddOccupation ?>"  <?=$user_mode?> >
                                            </div>
                                        </div>                                
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Religion <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aareligion value="<?=$ddreligion ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>   



                                  </div>
                                </div>

                                


                                <div class="panel panel-default">
                                  <div class="panel-heading">PAYOR'S INFORMATION</div>
                                  <div class="panel-body">


                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">NAME <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayorname value="<?=$ddpname ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>   
                                        <div class="col-sm-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">AGE <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayorage value="<?=$ddpage ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">RELATION <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayorrelation value="<?=$ddprelation ?>"  <?=$user_mode?> required>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CONTACT NO. </label>
                                                <input type="text" class="form-control" id=aapayorcontactno value="<?=$ddpcontactno ?>"  <?=$user_mode?> >
                                            </div>
                                        </div>   



                                       <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Purok/Street <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayorpurok  value="<?=$ddcstreet ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Barangay <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayorbarangay value="<?=$ddcbarangay ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Mun./City <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayormunicipality  value="<?=$ddccity ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Province <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aapayorprovince  value="<?=$ddcprovince ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>                                
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Member's Contact No. </label>
                                                <input type="text" class="form-control" id=aamembercontactno  value="<?=$ddmcontactno ?>" <?=$user_mode?> >
                                            </div>
                                        </div>  





                                  </div>
                                </div>


                       <div class="panel panel-default">
                                  <div class="panel-heading">BENEFICIARY</div>
                                  <div class="panel-body">
        

                                       <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Name <font color="red">*</font></label>
                                                <input type="text" class="form-control" id=aabenename  value="<?=$ddbname ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>


                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Birth Date <font color="red">*</font></label>
                                                <input type="date" class="form-control"  id=aabenebirthdate  value="<?=($ddbbdate==''?'1900-01-01':$ddbbdate) ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Age</label>
                                                <input type="text" class="form-control"  id=aabeneage value="<?=$ddbage ?>" <?=$user_mode?> required disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Relation <font color="red">*</font></label>
                                                <input type="text" class="form-control"  id=aabenerelation value="<?=$ddbrelation ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <?php
                                        $selbSingle = "";
                                        $selbMarried = "";
                                        $selbWidow = "";

                                        if ($ddbstatus == "Single") $selbSingle = " selected ";
                                        if ($ddbstatus == "Married") $selbMarried = " selected ";
                                        if ($ddbstatus == "Widow") $selbWidow = " selected ";
                                        ?>                                        
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Civil Status <font color="red">*</font></label>
                                                <select class="form-control"  id=aabenecivilstatus <?=$user_mode?> required>
                                                   <option value="">Select</option>
                                                  <option value="Single" <?=$selbSingle ?>>Single</option>
                                                  <option value="Married" <?=$selbMarried ?>>Married</option>
                                                  <option value="Widow" <?=$selbWidow ?>>Widow</option>
                                               </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contact No. </label>
                                                <input type="text" class="form-control"  id=aabenecontactno  value="<?=$ddbcontactno ?>" <?=$user_mode?> >
                                            </div>
                                        </div>  


                                  </div>



                                 <div class="panel-footer">DEPENDENTS (OPTIONAL)</div>
                                    <div class="panel-body">

                                            

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control" id=aadepname1  value="<?=$dddname1 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate1  value="<?=($dddbdate1==''?'1900-01-01':$dddbdate1) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage1  value="<?=$dddage1 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control"  id=aadeprelationship1  value="<?=$dddrelation1 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle1 = "";
                                        $seldMarried1 = "";
                                        $seldWidow1 = "";

                                        if ($dddstatus1 == "Single") $seldSingle1 = " selected ";
                                        if ($dddstatus1 == "Married") $seldMarried1 = " selected ";
                                        if ($dddstatus1 == "Widow") $seldWidow1 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus1 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle1 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried1 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow1 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div>                                


                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control" id=aadepname2  value="<?=$dddname2 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate2  value="<?=($dddbdate2==''?'1900-01-01':$dddbdate2) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage2  value="<?=$dddage2 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control"  id=aadeprelationship2  value="<?=$dddrelation2 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle2 = "";
                                        $seldMarried2 = "";
                                        $seldWidow2 = "";

                                        if ($dddstatus2 == "Single") $seldSingle2 = " selected ";
                                        if ($dddstatus2 == "Married") $seldMarried2 = " selected ";
                                        if ($dddstatus2 == "Widow") $seldWidow2 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus1 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle2 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried2 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow2 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div> 

                                                                 


                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control" id=aadepname3  value="<?=$dddname3 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate3  value="<?=($dddbdate3==''?'1900-01-01':$dddbdate3) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage3  value="<?=$dddage3 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control"  id=aadeprelationship3  value="<?=$dddrelation3 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle3 = "";
                                        $seldMarried3 = "";
                                        $seldWidow3 = "";

                                        if ($dddstatus3 == "Single") $seldSingle3 = " selected ";
                                        if ($dddstatus3 == "Married") $seldMarried3 = " selected ";
                                        if ($dddstatus3 == "Widow") $seldWidow3 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus1 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle3 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried3 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow3 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div>    

                                                                    
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control" id=aadepname4  value="<?=$dddname4 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate4  value="<?=($dddbdate4==''?'1900-01-01':$dddbdate4) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage4  value="<?=$dddage4 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control"  id=aadeprelationship4  value="<?=$dddrelation4 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle4 = "";
                                        $seldMarried4 = "";
                                        $seldWidow4 = "";

                                        if ($dddstatus4 == "Single") $seldSingle4 = " selected ";
                                        if ($dddstatus4 == "Married") $seldMarried4 = " selected ";
                                        if ($dddstatus4 == "Widow") $seldWidow4 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus1 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle4 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried4 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow4 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div> 
                                     

                                    </div>  

                                </div>


                                    <div class="panel panel-default">
                                      <div class="panel-heading">ACCOUNT DETAIL</div>
                                      <div class="panel-body">
                                        
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Member's Code</label>
                                                    <input type="text" class="form-control" id=aamembercode  value="<?=$Member_Code ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Plan Type <font color="red">*</font></label>
                                                    <select class="form-control" id=aaplantype <?=$user_mode?> required>
                                                      <option value="">None</option>
                                                    <?php
                                                    
                                                        while ($r=mysql_fetch_array($res_plan,MYSQL_ASSOC)) { 

                                                            $Plan_Code = $r['Plan_Code'];
                                                            $plan_name = $r['plan_name'];

                                                            $selplan = "";
                                                            if ($ddplan_code==$Plan_Code) $selplan = "Selected";

                                                            echo "<option value=\"$Plan_Code\"  $selplan >$plan_name</option>";
                                                        }
                                                        mysql_free_result($res_plan);
                                                    
                                                    ?>                                                        
                                                    </select>
                                                </div>
                                            </div>  
                                             <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" >Unit(s) <font color="red">*</font></label>
                                                    <input type="text" class="form-control" id=aaunits  value="<?=$ddno_of_units ?>" <?=$user_mode?> required numberonly>
                                                </div>
                                            </div>                                           
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Branch Manager <font color="red">*</font></label>
                                                    <select class="form-control" id=aabranchmanager <?=$user_mode?> required>
                                                      <option value="">None</option>
                                                    <?php
                                                         while ($r=mysql_fetch_array($res_branch,MYSQL_ASSOC)) { 
                                                            $value = $r["BRANCH_CODE"];
                                                            $name = $r["BRANCH_NAME"];
                                                            $branch_manager = $r["BRANCH_MANAGER"];
                                                            $selBM = "";
                                                            if (trim($value)==trim($ddBM)) $selBM = "Selected";

                                                            echo "<option value=\"$value\" $selBM >$branch_manager</option>";
                                                        }
                                                        mysql_free_result($res_branch);
                                                    ?>                                                        
                                                    </select>
                                                </div>
                                            </div>  


                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">AO <font color="red">*</font></label>
                                                    <select class="form-control" id=aaao <?=$user_mode?> required>
                                                      <option value="">None</option>
                                                     <?php
                                                     
                                                        while ($r=mysql_fetch_array($res_ao,MYSQL_ASSOC)) { 
                                                            $value = $r["AO"];
                                                            $name = $r["AO_NAME"];
                                                            $selAO="";
                                                            if ($ddAO==$value) $selAO = "selected";
                                                            echo "<option value=\"$value\" $selAO>$name</option>";
                                                        }
                                                     mysql_free_result($res_ao);
                                                     
                                                    ?>     

                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Agent <font color="red">*</font></label>
                                                    <select class="form-control" id=aaagent <?=$user_mode?> required>
                                                      <option value="">None</option>
                                                    <?php
                                                    
                                                        while ($r=mysql_fetch_array($res_agent,MYSQL_ASSOC)) { 
                                                            $value = $r["AGENT_ID"];
                                                            $name = $r["AGENT_NAME"];
                                                            $selAgent="";
                                                            if ($ddagent==$value) $selAgent = "selected";
                                                            echo "<option value=\"$value\" $selAgent>$name</option>";
                                                        }
                                                     mysql_free_result($res_agent);
                                                    
                                                    ?>                                                      
                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Ins. Type <font color="red">*</font></label>
                                                    <select class="form-control" id=aainsurance <?=$user_mode?> required>
                                                    <option value="">None</option>
                                                    <?php
                                                    
                                                        while ($r=mysql_fetch_array($res_insurace,MYSQL_ASSOC)) { 
                                                            $value = $r["INS_CODE"];
                                                            $name = $r["INS_NAME"];
                                                            $selIns = "";
                                                            if ($value == $ddinsurance_type) $selIns = "selected";
                                                            echo "<option value=\"$value\" $selIns>$name</option>";

                                                        }
                                                        mysql_free_result($res_insurace);
                                                    
                                                    ?>                                                   
                                                    </select>
                                                </div>
                                            </div>  


                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">P.R. Date <font color="red">*</font></label>
                                                    <input type="date" class="form-control"  id=aaprdate    value="<?=($ddPRdate==''?'1900-01-01':$ddPRdate) ?>" <?=$user_mode?> required>
                                                </div>
                                            </div>
                                             <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">P.R. # <font color="red">*</font></label>
                                                    <input type="text" class="form-control"  id=aaprno value="<?=$ddPRno ?>" <?=$user_mode?> required numberonly>
                                                </div>
                                            </div>  

                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">O.R. Date <font color="red">*</font></label>
                                                    <input type="date" class="form-control"  id=aaordate   value="<?=($ddORdate==''?'1900-01-01':$ddORdate) ?>" <?=$user_mode?> required>
                                                </div>
                                            </div>
                                             <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">O.R. # <font color="red">*</font></label>
                                                    <input type="text" class="form-control" id=aaornumber  value="<?=$ddORno ?>" <?=$user_mode?> required numberonly>
                                                </div>
                                            </div>  
                                             <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Amount <font color="red">*</font></label>
                                                    <input type="text" class="form-control" id=aaamount  value="<?=$ddamount ?>" <?=$user_mode?> required numberonly>
                                                </div>
                                            </div>  
                                             <div class="col-sm-2">
                                                <div class="form-group label-floating" >
                                                    <label class="control-label">Applied DAte <font color="red">*</font></label>
                                                    <input type="date" class="form-control" id=aamembershipdate   value="<?=($dddate_of_membership==''?'1900-01-01':$dddate_of_membership) ?>" <?=$user_mode?> required>
                                                </div>
                                            </div>  

                                      </div>
                                    </div>
         


                       </div>


                                </div>
                            </div>
                        </div>
      
                    </div>
                </div>
              </form>
            </div>



            <?php
            include './proc/cliregistrationform_controller.php';



            ?>

