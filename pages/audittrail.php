
            <div class="row">
                <div class="col-lg-10">
                    <h2 class="page-header">AUDIT TRAILS</h2>
                </div>
                <!--div class="col-lg-2">
                   <BR><BR>
                   <span class=" pull-right">
                   <a href="#" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#share_generation_modal"><i class="fa fa-plus" ></i> Aidit Trails</a>
                   </span>

                </div-->
            </div>



           <!-- search section __________________________________________________________________________________________________________________________________ -->
            <!--div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            SEARCH
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">

                              <div class="col-lg-9">
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="Search for..." id=searchcriteria>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id=btnaudittrailsearch>Search!</button>
                                  </span>
                                </div>
                              </div>


                              <div class="col-lg-3">
                                <div class="input-group">
                                <select class="form-control" id=category>
                                  <option value="">All Category</option>
                                  <option value="CLIENTS">REGISTRATION</option>
                                  <option value="SHARE">SHARES</option>
                                  <option value="PAYMENT">PAYMENT</option>
                                  <option value="LOGIN">LOGIN</option>
                                </select>

                                </div>
                              </div>



                            </div>                        

                        </div>
                    </div>
                </div>
            </div-->



             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ACTIVITY LOG
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-buttons">
                                <thead>
                                    <tr>
                                        <th width="20px">ENTRY ID</th>
                                        <th width="60%">ACTIVITIES</th>
                                        <th>CATEGORY</th>
                                        <th>USER</th>
                                        <th>DATE MODIFIED</th>
                                    </tr>
                                </thead>
                                <tbody id=audittaillist>

                                            <?php 
                                            
                                            
                                                $res_audittrail = mysqli_query($con, '

                                                SELECT
                                                    `tbl_audittrail`.`ID`
                                                    , `tbl_audittrail`.`ACTIVITIES`
                                                    , `tbl_audittrail`.`CATEGORY`
                                                    , `users`.`fullname`
                                                    , `tbl_audittrail`.`DATE`
                                                FROM
                                                    `dmcpi1_dmcsm`.`users`
                                                    INNER JOIN `dmcpi1_dmcsm`.`tbl_audittrail` 
                                                    ON (`users`.`user_id` = `tbl_audittrail`.`USER_ID`)
                                                ORDER BY DATE DESC
                                                LIMIT 0, 100 
                                                 ;

                                                	') or die(mysqli_error());
                                                while ($r=mysqli_fetch_array($res_audittrail,MYSQLI_ASSOC)) {
                                                    $ID = $r['ID']; 
                                                    $ACTIVITIES = $r['ACTIVITIES']; 
                                                    $CATEGORY = $r['CATEGORY']; 
                                                    $USER = $r['fullname']; 
                                                    $DATE = $r['DATE']; 

                                                    echo "
                                                        <tr id=audittraildata>
                                                            <td class=\"even gradeC\"> $ID</td>
                                                            <td>$ACTIVITIES</td>
                                                            <td>$CATEGORY</td>
                                                            <td>$USER</td>
                                                            <td>$DATE</td>
                                                    </tr>

                                                    ";


                                                }
                                                mysqli_free_result($res_audittrail);
                                                
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

    $(document).on("click","#btnaudittrailsearch",function(){
        var criteria = $('#searchcriteria').val();
        var category= $('select[id="category"]').val();
        $('#audittaillist').html('');  
            $.ajax({  
                type: 'GET',
                url: './proc/audittrailsearch_proc.php', 
                data: { 
                    criteria:criteria,
                    category:category
                },
                success: function(response) {
                    // prompt(response,response);

                     if (response.indexOf("**success**") > -1){
                        //    0 - result status
                        //    1 - html table rows for detail section
                        var strarray=response.split('|');
                        //alert(strarray[5]);

                         
                         $('#audittaillist').append(strarray[1]).fadeIn('slow');;   

                     }else if (response.indexOf("**failed**") > -1){
                            alert('No record found');
                     }
                }
        });
    });



    </script>

