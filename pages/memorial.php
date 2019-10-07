<div class="row">
    <div class="col-lg-6">
        <h1 class="page-header">MEMORIAL</h1>
    </div>
    <div class="col-lg-6">
    <BR><BR>


    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id=row_count>
                All records
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th >Code</th>
                            <th >Name</th>
                            <th >Sex</th>
                            <th >Date of Birth</th>
                            <th >Age</th>

                            <th >Plan</th>
                            <th >Date of Death</th>
                            <th >Place of Death</th>
                            <th >Cause of Death</th>
                            <th >Preview</th>

                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $res_data = mysqli_query($con, "

                                SELECT
                                    `deceased_table`.`Member_Code`
                                    , UPPER(CONCAT(`members_profile`.`Lname`,', ',`members_profile`.`Fname`,', ',SUBSTR(`members_profile`.`Mname`,1,1),'.')) AS `Fullname`
                                    , `members_profile`.`Sex`
                                    , `members_profile`.`Bdate`
                                    ,  TIMESTAMPDIFF(YEAR, `members_profile`.`Bdate`, `deceased_table`.`Date_of_death`) AS AGE
                                    , `members_profile`.`Religion`
                                    , `insurance`.`Name` AS `Insurance`
                                    , `members_account`.`Date_of_membership`
                                    , `members_account`.`Account_Status`
                                    , `packages`.`Plan_Code` AS `Plan`
                                    , `deceased_table`.`Date_of_death`
                                    , `deceased_table`.`Place_of_death`
                                    , `deceased_table`.`Reason_of_death`
                                    , `deceased_table`.`ID`
                                    , `deceased_table`.`approved_by`
                                    , `deceased_table`.`date_approved`
                                FROM
                                    `dmcpi1_dmcsm`.`deceased_table`
                                    INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
                                        ON (`deceased_table`.`Member_Code` = `members_profile`.`Member_Code`)
                                    INNER JOIN `dmcpi1_dmcsm`.`members_account` 
                                        ON (`members_account`.`Member_Code` = `deceased_table`.`Member_Code`)
                                    INNER JOIN `dmcpi1_dmcsm`.`insurance` 
                                        ON (`members_account`.`Insurance_Type` = `insurance`.`Code`)
                                    INNER JOIN `dmcpi1_dmcsm`.`packages` 
                                        ON (`members_account`.`Plan_id` = `packages`.`Plan_id`);                             

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {

                                $Member_Code = $r['Member_Code']; 
                                $Fullname = strtoupper($r['Fullname']); 
                                $Sex = $r['Sex']; 
                                $Bdate = $r['Bdate']; 
                                $AGE = $r['AGE']; 
                                $deceased_id = $r['ID'];

                                $Plan = $r['Plan'];
                                $Date_of_death = $r['Date_of_death'];
                                $Place_of_death = $r['Place_of_death'];
                                $Reason_of_death = $r['Reason_of_death']; 
                                
                                $approved_by = $r['approved_by'];

                                $row_colorclass = "";  
                                $option_class = "";                              
                                if ($approved_by > 0){
                                    $row_colorclass = "success";
                                    $option_class = "hidden";
                                }

                                echo "
                                    <tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $Member_Code</td>
                                        <td>$Fullname</td>
                                        <td>$Sex</td>
                                        <td>$Bdate</td>
                                        <td>$AGE</td>
                                        <td>$Plan</td>
                                        <td>$Date_of_death</td>
                                        <td>$Place_of_death</td>
                                        <td>$Reason_of_death</td>
                                        <td>
                                        <div class=\"btn-group \" role=\"group\">
                                            <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                              Select
                                              <span class=\"caret\"></span>
                                            </button>
                                            <ul class=\"dropdown-menu\">
                                          
                                              <li><a href=\"#\" target=prev_pdf id=btnaction link=\"fpdf/reports/r_deceaseinfo.php\" data-toggle=\"modal\" data-target=\".preview_modal\" >Deceased information</a></li>
                                              <li><a href=\"#\" target=prev_pdf id=btnaction link=\"fpdf/reports/r_memorial_request.php\" data-toggle=\"modal\" data-target=\".preview_modal\" >Memorial request</a></li>
                                              <li><a href=\"#\" target=prev_pdf id=btnaction link=\"fpdf/reports/r_ms_acknowledgement.php\" data-toggle=\"modal\" data-target=\".preview_modal\" >Acknowledgement of Memorial Service Rendenred</a></li>
                                              <li><a href=\"#\" target=prev_pdf id=btnaction link=\"fpdf/reports/r_policy.php?Member_Code=$Member_Code#view=FitH\" data-toggle=\"modal\" data-target=\".preview_modal\" >Policy</a></li>

                                           </ul>
                                          </div>
                                        </td>
                                        <td>

                                        		<button type=\"button\" 
                                                id=btn_memorial_approval 
                                                deceased_id=$deceased_id 
                                                Member_Code=$Member_Code 

                                                class=\"btn btn-primary btn-sm btn-block $option_class \">APPROVE</button>

                                        </td>
                                    </tr>

                                ";


                            }
                            mysqli_free_result($res_data);
                            
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<!--script src="../vendor/jquery/jquery.min.js"></script-->
<div class="modal fade bs-example-modal-sm preview_modal" tabindex="-1" role="dialog" aria-labelledby="modal_update_deceased">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Preview</h4>


            </div>
            <div class="modal-body">
             <iframe id=prev_pdf name=prev_pdf width="100%" height="800"></iframe>
            </div>

    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).on("click","#btnaction",function(e){
        e.preventDefault();
  		var iframe = $('#prev_pdf');
  		var link = $(this).attr('link');
 		$(iframe).attr('src', link);      
    });

    $(document).on("click","#btn_memorial_approval",function(e){
        e.preventDefault();
        var id          = $(this).attr('deceased_id');
        var Member_Code = $(this).attr('Member_Code');
        if (confirm('I certify this client as eligible to receive memorial services')){
            $.ajax({  
                type: 'GET',
                url: './proc/memorial_proc.php', 
                data: { 
                    id:id,
                    action:"approve",
                    user_id:"<?=$user_id?>",
                    Member_Code:Member_Code
                },
                success: function(response) {
                     //prompt(response,response);return;
                     if (response.indexOf("**success**") > -1){
                        window.location = "index.php?page=memorial";
                     }else if (response.indexOf("**failed**") > -1){
                         alert('An error occured while processing transactions!');
                     }
                }
            });  
        }

    });

</script>
