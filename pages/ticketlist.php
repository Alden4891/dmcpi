





<div class="row">
    <div class="col-lg-6">
        <h1 class="page-header">TICKET LIST</h1>
    </div>
    <div class="col-lg-6">
    <BR><BR>
<?php

    if (!isset($status_tags)){
        $status_tags = "0,1,2";
    }


    echo "
        <span class=\" pull-right\">
        <a href=\"#\" type=\"button\" 
           class=\"btn btn-success btn-md\"
           data-toggle=\"modal\" 
           data-target=\"#ticket_editor\"
           uid     =0  
           id=btn_new_ticket                       
           ><i class=\"fa fa-plus\" ></i> OPEN NEW TICKET</a>
        </span>
    ";

?>


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



                <table width="100%" class="table table-striped table-bordered table-bordered" id="datatable-buttons">
                    <thead>
                        <tr>
                            <th>TICKETNO</th>
                            <th>ISSUE/CONCERN</th>
                            <th>CATEGORY</th>
                            <th>DATE RAISED</th>
                            <th>PRIORITY</th>
                            <th>STATUS</th>
                            <th>DATE UPDATED</th>
                            <th>OPTIONS</th>

                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $cnt=0;

                            $sql  = "

                                SELECT
                                      `tickets`.`TICKETNO`
                                    , `users`.`user_id`
                                    , `users`.`fullname`
                                    , `libcategory`.`CATEGORY`
                                    , `libcategory`.RESP
                                    , CONCAT(`libcategory`.RESP,',',`users`.`user_id`) AS GRANTED_USER
                                    , `tickets`.`PRIORITY`
                                    , `tickets`.`SUBJECT`
                                    , `tickets`.`DESCRIPTION`
                                    , `tickets`.`DATE_RAISED`
                                    , `tickets`.`DATE_UPDATED`
                                    , `libstatus`.`STATUS`
                                    , `libstatus`.`ID` AS `STATUS_ID`
                                FROM
                                    `tickets`
                                    INNER JOIN `users` 
                                        ON (`tickets`.`USER_ID` = `users`.`user_id`)
                                    INNER JOIN `libstatus` 
                                        ON (`tickets`.`STATUS` = `libstatus`.`ID`)
                                    INNER JOIN `libcategory` 
                                        ON (`tickets`.`CATEGORY` = `libcategory`.`ID`)
                                       
                                WHERE `libstatus`.`ID` IN ($status_tags)
                                ORDER BY  `tickets`.`DATE_UPDATED` DESC
                                 ;
                                 
                            ";
                            //echo "$sql";

                            $res_tickets = mysqli_query($con, $sql) or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_tickets,MYSQLI_ASSOC)) {


                                $cnt++;
                                $TICKETNO = sprintf('%06d', $r['TICKETNO']); 
                                $USER_ID = $r['user_id']; 
                                $FULLNAME = strtoupper($r['fullname']); 
                                $CATEGORY = $r['CATEGORY'];
                                $PRIORITY = $r['PRIORITY']; 
                                $SUBJECT = $r['SUBJECT']; 
                                $DESCRIPTION = $r['DESCRIPTION']; 
                                $DATE_RAISED = $r['DATE_RAISED']; 
                                $DATE_UPDATED = $r['DATE_UPDATED']; 
                                $STATUS = $r['STATUS']; 
                                $STATUS_ID = $r['STATUS_ID']; 
                                $RESP = $r['RESP']; 
                                $GRANTED_USER = explode(",", $r['GRANTED_USER']);
                                $btn_detail_class = "";



                                if (!in_array($user_id, $GRANTED_USER)){
                                    $btn_detail_class = "disabled";    
                                }



                                $row_colorclass = "";                                
                                if ($STATUS_ID == 3){
                                    $row_colorclass = "success";
                                }else if ($STATUS_ID == 4 || $STATUS_ID == 5) {
                                    $row_colorclass = "danger";
                                }else if ($STATUS_ID == 1 || $STATUS_ID == 2) {
                                    $row_colorclass = "warning";

                                }

                              if ($PRIORITY == 1) {
                                $PRIORITY = '<span class="label label-info">LOW</span>';
                              }else if ($PRIORITY == 2){
                                $PRIORITY = '<span class="label label-warning">AVERAGE</span>';
                              }else if ($PRIORITY == 3){
                                $PRIORITY = '<span class="label label-danger">HIGH</span>';
                              }
                                                         


                                echo "
                                    <tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $TICKETNO</td>
                                        <td>$SUBJECT</td>
                                        <td>$CATEGORY</td>
                                        <td>$DATE_RAISED</td>
                                        <td>$PRIORITY</td>
                                        <td>$STATUS</td>
                                        <td>$DATE_UPDATED</td>
                                        <td><a href='index.php?page=ticketlist_detail&tn=$TICKETNO' CLASS='btn btn-xs btn-primary $btn_detail_class'>view</a></td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_tickets);
                            
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




<!-- Modal -->
<div class="modal fade" id="ticket_editor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">NEW TICKET </h4>
      </div>
      <div class="modal-body">

            <form class="form-horizontal">
            <fieldset>
         
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-2 control-label" for="ntSUBJECT">SUBJECT</label>  
              <div class="col-md-10">

              <input id="ntTICKETNO" name="ntTICKETNO" type="hidden" value="0">
              <input id="ntSUBJECT" name="ntSUBJECT" type="text" placeholder="" class="form-control input-md" required="">
                
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-2 control-label" for="ntCONCERN">ISSUES/CONCERN</label>  
              <div class="col-md-10">
              <TEXTAREA id="ntCONCERN" name="ntCONCERN" placeholder="" class="form-control input-md" required="" rows=10 ></TEXTAREA> 
                
              </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
              <label class="col-md-2 control-label" for="ntCATEGORY">CATEGORY</label>
              <div class="col-md-6">
                <select id="ntCATEGORY" name="ntCATEGORY" class="form-control">

                    <?php
                            $cnt=0;
                            $res_category = mysqli_query($con, "SELECT  `ID`,  `CATEGORY`FROM `libcategory`;") or die(mysqli_error());

                            while ($r=mysqli_fetch_array($res_category,MYSQLI_ASSOC)) {
                                $ID=$r['ID'];
                                $CATEGORY=$r['CATEGORY'];                            
                                echo "<option value=\"$ID\">$CATEGORY</option>";

                            }
                            mysqli_free_result($res_category);

                    ?>



                </select>
              </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
              <label class="col-md-2 control-label" for="ntPRIORITY">PRIORITY</label>
              <div class="col-md-6">
                <select id="ntPRIORITY" name="ntPRIORITY" class="form-control">
                  <option value="1">LOW</option>
                  <option value="2" selected>MEDIUM</option>
                  <option value="3">HIGH</option>
                </select>
              </div>
            </div>

            </fieldset>
            </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id=btnsave>Post</button>
      </div>
    </div>
  </div>
</div>




<script>
var row = 0;
    $(document).on("click","#btn_new_ticket",function(e){
        e.preventDefault();
        row = $(this).closest('tr');
        //RESET
        $('#ntPRIORITY').val(2);
        $('#ntCATEGORY').val('General');
        $('#ntCONCERN').val('');
        $('#ntSUBJECT').val('');
        $('#ntTICKETNO').val(0);   

    });

    $(document).on("click", "#btnsave", function(e){
        e.preventDefault();

            var ntPRIORITY = $('#ntPRIORITY').val();
            var ntCATEGORY = $('#ntCATEGORY').val();
            var ntCONCERN = $('#ntCONCERN').val();
            var ntSUBJECT = $('#ntSUBJECT').val();
            var ntTICKETNO = $('#ntTICKETNO').val();  
            var USER_ID = $('#user_info').attr('user_id');


            if (ntSUBJECT==''){
                alert('Subject field is required!');
                return;
            }

            if (ntCONCERN==''){
                alert('Cencern desciption is required!');
                return;
            }
            

            if (ntPRIORITY=='' || ntPRIORITY==0){
                alert('Priority fiend is required!');
                return;
            }

            if (ntCATEGORY == ''){
                alert('Category is required!');
                return;
            }




             $.ajax({  
                type: 'POST',
                url: './proc/ticket_save_proc.php', 
                data: { 
                    ntPRIORITY:ntPRIORITY,
                    ntCATEGORY:ntCATEGORY,
                    ntCONCERN:ntCONCERN,
                    ntSUBJECT:ntSUBJECT,
                    ntTICKETNO:ntTICKETNO,
                    USER_ID:USER_ID
                },
                success: function(response) {
                    //prompt(response,response);
                    //return;

                     if (response.indexOf("**success**") > -1){
                        //    0 - result status
                        //    1 - mode: INSERT | UPDATE
                        //    2 - html table rows for detail section
                        var strarray=response.split('|');
                        var mode = strarray[1];
                        var html = strarray[2];
                       

                        if (mode == 'UPDATE') {
                            row.html(html).fadeOut('fast').fadeIn('slow');
                        }else{
                            $('#clientlist').append(html).fadeIn('fast');
                        }
                        $('#ticket_editor').modal('hide');
                        alert('Saved Successfully');
                        
                       

                     }else if (response.indexOf("**no_changes**") > -1){
                      
                        alert('No changes made!');

                     }
                }
            });   



    });


    $(document).on('click','#delete_client',function(){
        var id = $(this).attr('uid');
        row = $(this).closest('tr');

        if (confirm('You are about to permanently delete this record. Do you want to continue?')){
              $.ajax({  
                type: 'GET',
                url: './proc/employee_delete_proc.php', 
                data: { 
                    id:id
                },
                success: function(response) {
                  //  prompt(response,response);
                    if (response.indexOf("**success**") > -1){
                        row.fadeOut(500, function() {
                            $(this).remove();
                        });

                     }else if (response.indexOf("**failed**") > -1){
                         alert('Unable to delete this client! You can only delete newly added client!');
                     }
                }
        });          
        }

    });


</script>

