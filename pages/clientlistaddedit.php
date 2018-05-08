



            <div class="row">
                <div class="col-lg-10">
                    <h1 class="page-header">CLIENT'S BASIC INFORMATION</h1>
                </div>
                <div class="col-lg-2">
                   <BR><BR>
                   
                   <span class=" pull-right">
                   <a href="index.php?page=cliregistrationform&Member_Code=" type="button" class="btn btn-success btn-lg"><i class="fa fa-plus" ></i> New Client</a>
                   </span>
                    
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            1 record found
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Agent</th>
                                        <th>Plan type</th>
                                        <th>No. of Units</th>
                                        <th>Membership Date</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--tr class="odd gradeX">
                                        <td>Trident</td>
                                        <td>Internet Explorer 4.0</td>
                                        <td>Win 95+</td>
                                        <td class="center">4</td>
                                        <td class="center">X</td>
                                    </tr-->

                                            <?php 
                                            
                                                $res_members_list = mysql_query('select * from dmcsm.members_list limit 0, 50') or die(mysql_error());
                                                while ($r=mysql_fetch_array($res_members_list,MYSQL_ASSOC)) {
                                                    $Member_Code = $r['Member_Code']; 
                                                    $Fullname = $r['Fullname']; 
                                                    $Agent = $r['Agent']; 
                                                    $Plan_Code = $r['Plan_Code']; 
                                                    $No_of_Units = $r['No_of_Units']; 
                                                    $Date_of_Membership = $r['Date_of_Membership']; 
                                                    echo "
                                                        <tr>
                                                            <td class=\"even gradeC\"> $Member_Code</td>
                                                            <td>$Fullname</td>
                                                            <td>$Agent</td>
                                                            <td>$Plan_Code</td>
                                                            <td>$No_of_Units</td>
                                                            <td>$Date_of_Membership</td>

                                                            <td>
                                                                <a href=\"?page=cliregistrationform&Member_Code=$Member_Code\" class=\"btn btn-warning btn-circle\"><i class=\"glyphicon glyphicon-edit\"></i></a>
                                                                <a href=\"?page=deleteclient&Member_Code=$Member_Code\" class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-remove\"></i></a>
                                                                

                                                            </td>
                                                    </tr>

                                                    ";


                                                }
                                                mysql_free_result($res_members_list);
                                                
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
            

            

            


    <script src="../vendor/jquery/jquery.min.js"></script>



    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

