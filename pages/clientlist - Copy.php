



            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Registered Clients</h1>
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
                                            
                                                $res_members_list = mysql_query('select * from dmcsm.members_list limit 1, 200') or die(mysql_error());
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
                                                                <a href=\"?page=clientpaymentinfo&Member_Code=$Member_Code\" class=\"btn btn-success btn-circle\"><i class=\"fa fa-money\"></i></a>
                                                                <!--a href=\"#\" class=\"btn btn-primary btn-circle\"><i class=\"fa fa-list\"></i></a-->

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

