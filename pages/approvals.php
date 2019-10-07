



<div class="row">
    <div class="col-lg-6">
        <h1 class="page-header">Request for Approvals</h1>
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
                            <th width="10%">Req. ID</th>
                            <th >Description</th>
                            <th >Class</th>
                            <th >Requestor</th>
                            <th >Date Requested</th>
                            <th >Action by</th>
                            <th >Action Date</th>
                            <th >Status</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $res_data = mysqli_query($con, "

                                SELECT
                                     `approvals`.`id`
                                    , `approvals`.`description`
                                    , `approvals`.`type` AS `CLASS` 
                                    ,`user`.`fullname` AS `Requested_by`
                                    , `approvals`.`date_requested`
                                    , `admin`.`fullname` AS `Action_by`
                                    , `approvals`.`action_date`
                                    , `approvals`.`status`
                                FROM
                                    `dmcpi1_dmcsm`.`approvals`
                                    INNER JOIN `dmcpi1_dmcsm`.`users` AS `user`
                                        ON (`approvals`.`requested_by` = `user`.`user_id`)
                                    LEFT JOIN `dmcpi1_dmcsm`.`users` AS `admin`
                                        ON (`approvals`.`action_by` = `admin`.`user_id`)
                                ORDER BY `approvals`.`date_requested`
                                 ;

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $id = $r['id']; 
                                $description = strtoupper($r['description']); 
                                $CLASS = $r['CLASS']; 
                                $Requested_by = $r['Requested_by']; 
                                $date_requested = $r['date_requested']; 
                                $Action_by = $r['Action_by'];
                                $action_date = $r['action_date'];
                                $status = $r['status'];
                                

                                $row_colorclass = "";     
                                $action_class = "";                           
                                if ($status == "Rejected"){
                                    $row_colorclass = "danger";
                                    $action_class = "hidden";
                                }elseif ($status == "Approved"){
                                    $action_class = "hidden";
                                    $row_colorclass  = "success";
                                }else {
                                    $action_class = "";
                                    $row_colorclass = "";
                                }




                                echo "
                                    <tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $id</td>
                                        <td>$description</td>
                                        <td>$CLASS</td>
                                        <td>$Requested_by</td>
                                        <td>$date_requested</td>
                                        <td>$Action_by</td>
                                        <td>$action_date</td>
                                        <td>$status</td>
                                        <td>

                                        <div class=\"btn-group $action_class\" role=\"group\">
                                            <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                              Select
                                              <span class=\"caret\"></span>
                                            </button>
                                            <ul class=\"dropdown-menu\">
                                          
                                              <li><a href=\"#\" id=btnaction action=approve req_id=$id>Approve</a></li>
                                              <li><a href=\"#\" id=btnaction action=reject  req_id=$id>Reject</a></li>

                                            </ul>
                                          </div>

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
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



    $(document).on("click","#btnaction",function(){
        var action = $(this).attr('action');
        var req_id = $(this).attr('req_id');
        
        if (confirm('You are about to '+action+' this request. Do you want to continue?')){

                 $.ajax({  
                    type: 'GET',
                    url: './proc/approvals_proc.php', 
                    data: { 
                        action:action,
                        req_id:req_id,
                        user_id:"<?=$user_id?>"
                    },
                    success: function(response) {
                      //  prompt(response,response);
                         if (response.indexOf("**success**") > -1){
                            //$("#clientlist #row"+role_id).remove();   
                            window.location = "index.php?page=approvals";     
                         }else if (response.indexOf("**failed**") > -1){
                            alert("An error has occured!");
                           
                         }
                         
                    }
                }); 

        }



    });



</script>

