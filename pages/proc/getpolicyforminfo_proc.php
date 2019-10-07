<?php
    $Plan_id = $_REQUEST['Plan_id'];
    
    include '../dbconnect.php';
    $res_data = mysqli_query($con,"
        SELECT
        `id`
        , `field`
        , `font`
        , `font_size`
        , `font_style`
        , `x`
        , `y`
        FROM
        `dmcpi1_dmcsm`.`form_details`
        WHERE (`Plan_id` = $Plan_id);
    ");

    $rows = "";
    while ($r = mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
        
        $id = $r['id'];
        $field = $r['field'];
        $font = $r['font'];
        $font_size = $r['font_size'];
        $font_style = $r['font_style'];
        $x = $r['x'];
        $y = $r['y'];

        $row = "
            <td>        
                <div class=\"form-group\">
                <select class=\"form-control\" id=\"field\" name=\"field[]\"  field-obj >
                    <option value=\"\"  ".($field==''?'selected':'')." >Please select</option>
                    <option value=\"Lname\" ".($field=='Lname'?'selected':'')." >Last Name</option>
                    <option value=\"Fname\" ".($field=='Fname'?'selected':'')." >First Name</option>
                    <option value=\"Mname\" ".($field=='Mname'?'selected':'')." >Middle Name</option>
                    <option value=\"Nname\"  ".($field=='Nname'?'selected':'')." >Nick Name</option>
                    <option value=\"Sex\" ".($field=='Sex'?'selected':'')." >Sex</option>
                    <option value=\"Status\" ".($field=='Status'?'selected':'')." >Marital Status</option>
                    <option value=\"Member_Address\" ".($field=='Member_Address'?'selected':'')." >Address</option>
                    <option value=\"IDno\" ".($field=='IDno'?'selected':'IDno')." >ID Number</option>
                    <option value=\"Bdate\" ".($field=='Bdate'?'selected':'Bdate')." >Date of Birth</option>
                    <option value=\"Age\" ".($field=='Age'?'selected':'Age')." >Age</option>
                    <option value=\"Bplace\" ".($field=='Bplace'?'selected':'')." >Place of Birth</option>
                    <option value=\"Occupation\" ".($field=='Occupation'?'selected':'')." >Occupation</option>
                    <option value=\"religion\" ".($field=='religion'?'selected':'')." >Religion</option>
                    <option value=\"pname\" ".($field=='pname'?'selected':'')." >Payor's Name</option>
                    <option value=\"page\" ".($field=='page'?'selected':'')." >Payor's Age</option>
                    <option value=\"prelation\" ".($field=='prelation'?'selected':'')." >Payor's Relation to Member</option>
                    <option value=\"pcontactno\" ".($field=='pcontactno'?'selected':'')." >Payor's Contact Number</option>
                    <option value=\"CollectionAddress\" ".($field=='CollectionAddress'?'selected':'')." >Collection Address</option>
                    <option value=\"mcontactno\" ".($field=='mcontactno'?'selected':'')." >Member's Contact Number</option>
                    <option value=\"bcontactno\" ".($field=='bcontactno'?'selected':'')." >Beneficiary's Contact Number</option>
                    <option value=\"bbdate\" ".($field=='bbdate'?'selected':'')." >Beneficiary's Date of Birth</option>
                    <option value=\"bage\" ".($field=='bage'?'selected':'')." >Beneficiary's Age</option>
                    <option value=\"brelation\" ".($field=='brelation'?'selected':'')." >Beneficiary's Relation</option>
                    <option value=\"religion\" ".($field=='religion'?'selected':'')." >Beneficiary's Religion</option>
                    <option value=\"agent_fullname\" ".($field=='agent_fullname'?'selected':'')." >Agent's Name</option>
                    <option value=\"agent_id\" ".($field=='agent_id'?'selected':'')." >Agent's No</option>
                    <option value=\"agent\" ".($field=='agent'?'selected':'')." >Agent's Initial</option>
                    <option value=\"branch_manager\" ".($field=='branch_manager'?'selected':'')." >Branch Manager</option>
                    <option value=\"BManager_Initials\" ".($field=='BManager_Initials'?'selected':'')." >Branch Initial</option>
                    <option value=\"ORdate\" ".($field=='ORdate'?'selected':'')." >OR Date</option>
                    <option value=\"ORno\" ".($field=='ORno'?'selected':'')." >OR Number</option>
                    <option value=\"ORdate\" ".($field=='ORdate'?'selected':'')." >PR Date</option>
                    <option value=\"ORno\" ".($field=='ORno'?'selected':'')." >PR Number</option>
                    <option value=\"amount\" ".($field=='amount'?'selected':'')." >Initial Amount Paid</option>
                    <option value=\"ORdate\" ".($field=='ORdate'?'selected':'')." >Collection Date</option>
                    <option value=\"CollectionAddress\" ".($field=='CollectionAddress'?'selected':'')." >Collection Address</option>
                </select>
            </div>

            </td>
            <td>  
            <div class=\"form-group\">          
                <select class=\"form-control\" id=\"font\"  name=\"font[]\" >
                    <option value=\"Arial\"  ".($font=='Arial'?'selected':'')." >Arial</option>
                    <option value=\"Times New Roman\" ".($font=='Times New Roman'?'selected':'')." >Time New Roman</option>
                </select>
                </div>
            </td>
            <td>      
            <div class=\"form-group\">      
                <input class=\"form-control\" id=\"fsize\" name=\"fsize[]\" min=8 max=16 size=\"30\" type=\"number\" value=\"$font_size\" />
            </div>
            </td>
            <td>
            <div class=\"form-group\">
                <select class=\"form-control\" id=\"style\" name=\"style[]\" >
                    <option value=\"\"  ".($font_style==''?'selected':'')." >Regular</option>
                    <option value=\"U\" ".($font_style=='U'?'selected':'')." >Underline</option>
                    <option value=\"B\" ".($font_style=='B'?'selected':'')." >Bold</option>
                    <option value=\"I\" ".($font_style=='I'?'selected':'')." >Italisize</option>
                    <option value=\"BI\" ".($font_style=='BI'?'selected':'')." >Bold+Italisize</option>
                    <option value=\"BU\" ".($font_style=='BU'?'selected':'')." >Bold+Underline</option>
                    <option value=\"UI\" ".($font_style=='UI'?'selected':'')." >Underline+Italisize</option>
                </select>
            </div>
            </td>
            <td>
                <div class=\"form-group\">
                <input class=\"form-control\" min=\"1\" max=\"1000\" id=\"xcoor\" name=\"xcoor[]\" size=\"30\" type=\"number\" step=\".1\" min=1 max=500  value=\"$x\"/>
                </div>
            </td>
            <td>
                <div class=\"form-group\">
                <input class=\"form-control\" min=\"1\" max=\"1000\" id=\"ycoor\" name=\"ycoor[]\" size=\"30\" type=\"number\" step=\".1\" min=1 max=500  value=\"$y\" />
                </div>
            </td>
            <td>
                <a href=\"#\" 
                id=btnremovefield 
                class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>
            </td>
        ";
        $rows.="<tr class=\"deletable_row\" id=row$Plan_id>$row</tr>";
    }
    echo "$rows"; 

    mysqli_free_result($res_data);
    include '../dbclose.php';
?>