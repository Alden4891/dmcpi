



<div class="row">
    <div class="col-lg-6">
        <h1 class="page-header">MEMORIAL REQUESTS</h1>
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
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-memorial">
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

                            <th colspan="2">Options</th>
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
                                    , `packages`.`benefits_desc`
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
                                $benefits_desc = $r['benefits_desc'];
                                $approved_by = $r['approved_by'];

                                $row_colorclass = "";  
                                $option_class = "";                              
                                if ($approved_by > 0){
                                    $row_colorclass = "success";
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
                                                <a href=\"index.php?page=memo_details&member_code=$Member_Code\" 
                                                class=\"btn btn-primary btn-sm btn-block \">VIEW DETAILS</button>

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




<script>

    $(document).ready(function() {
        $('#dataTables-memorial').DataTable({
            responsive: true
        });
    });





</script>

