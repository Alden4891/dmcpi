
<div class="row">
    <div class="col-lg-10">
        <h1 class="page-header">STATEMENT OF OPERATION</h1>
    </div>
    <div class="col-lg-2">
       <BR><BR>
       <span class=" pull-right">

       </span>
    </div>
</div>






<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-buttons">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>MONTH</th>                                        
                            <th>YEAR</th>
                            <th>GROSS</th>
                            <th>BASIC COM.</th>
                            <th>NET</th>
                            <th>NS GROSS</th>
                            <th>NS BASIC COM.</th>
                            <th>NS NET</th>
                            <th>OPTIONS</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $res_data = mysqli_query($con, "CALL sp_soo();") or die(mysqli_error());
                            $cnt=0;
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $cnt+=1;
                                $OR_MONTHNAME = $r['OR_MONTHNAME'];
                                $OR_MONTH = $r['OR_MONTH'];

                                $OR_YEAR = $r['OR_YEAR']; 
                                
                                $Gross = number_format($r['Gross'],2); 
                                $Basic_Com = number_format($r['Basic_Com'],2);
                                $Net_Amount = number_format($r['Net_Amount'],2);
                                
                                $NS_Gross = number_format($r['NS_Gross'],2);
                                $NS_Basic_Com = number_format($r['NS_Basic_Com'],2);
                                $NS_Net_Amount = number_format($r['NS_Net_Amount'],2);

                                $sub_totals = "$Gross|$Basic_Com|$Net_Amount|$NS_Gross|$NS_Basic_Com|$NS_Net_Amount";
                                echo "  
                                    <tr id=sharelistdata>
                                        <td class=\"even gradeC\"> $cnt</td>
                                        <td><div class='pull-right' >$OR_MONTHNAME</div></td>
                                        <td><div class='pull-right' >$OR_YEAR</div></td>
                                        
                                        <td><div class='pull-right' >$Gross</div></td>
                                        <td><div class='pull-right' >$Basic_Com</div></td>
                                        <td><div class='pull-right' >$Net_Amount</div></td>
                                        
                                        <td><div class='pull-right' >$NS_Gross</div></td>
                                        <td><div class='pull-right' >$NS_Basic_Com</div></td>
                                        <td><div class='pull-right' >$NS_Net_Amount</div></td>

                                        <td>
                                            <a href=\"#\" 
                                            link=\"fpdf/reports/soo_bybm_report.php?year=$OR_YEAR&month=$OR_MONTH&sub_totals=$sub_totals&user=$user_fullname#view=FitH\" 
                                            target=_blank 
                                            title=\"Statement of Operation\"
                                            id=btn_soo_bybm_preview
                                            data-toggle=\"modal\" 
                                            data-target=\".preview_modal\"                                           
                                            class=\"btn btn-info btn-circle  btn-xs\"
                                            \">
                                              <span class=\"glyphicon glyphicon-bold\" aria-hidden=\"true\"></span>
                                            </a>                               


                                            <a href=\"#\" 
                                            link=\"fpdf/reports/soo_byagent_report.php?year=$OR_YEAR&month=$OR_MONTH&sub_totals=$sub_totals&user=$user_fullname#view=FitH\" 
                                            target=_blank 
                                            title=\"Statement of Operation\"
                                            id=btn_soo_byagent_preview
                                            data-toggle=\"modal\" 
                                            data-target=\".preview_modal\"                                           
                                            class=\"btn btn-info btn-circle  btn-xs\"
                                            \">
                                              <span class=\"glyphicon glyphicon-font\" aria-hidden=\"true\"></span>
                                            </a>                               


                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_data);
                            
                        ?>
                    </tbody>
                </table>

            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>

<div class="modal fade bs-example-modal-sm preview_modal" tabindex="-1" role="dialog" aria-labelledby="modal_preview">
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

    $(document).on("click","#btn_soo_bybm_preview",function(e){
        e.preventDefault();
        var iframe = $('#prev_pdf');
        var link = $(this).attr('link');
        $(iframe).attr('src', link);      
    });

    $(document).on("click","#btn_soo_byagent_preview",function(e){
        e.preventDefault();
        var iframe = $('#prev_pdf');
        var link = $(this).attr('link');
        $(iframe).attr('src', link);      
    });

    </script>





