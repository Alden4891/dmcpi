


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Encoding Sessions</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id=row_count>
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="pull-right">

                <a href="#" class="btn btn-success" id=btnNewSession data-toggle="modal" data-target="#modal-session-editor">New Schedule</a>

                </div>
                <br><br><br>

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-sessions">
                    <thead>
                        <tr>
                            <th>SESSION ID</th>
                            <th>PARTICULAR</th>
                            <th>DATE_START</th>
                            <th>DATE_END</th>
                            <th>MONTH</th>
                            <th>YEAR</th>
                            <th>STATUS</th>
                            <th>OPTIONS</th>
                        </tr>
                    </thead>
                    <tbody id=sessionlist class="sessionlist">
                    <div id=dummyrow></div>
                        <?php 
                            $res_data = mysqli_query($con, "
                            SELECT 
                              ID,
                              PARTICULAR,
                              DATE(DATE_START) AS DATE_START,
                              DATE(DATE_END) AS DATE_END,
                              MONTHNAME(CONCAT(`YEAR`, '-', MONTHNO, '-15')) AS `MONTH`,
                              MONTHNO,
                              `YEAR` ,
                              IF(ISACTIVE=1,'ACTIVE','') AS STATUS,
                              ISACTIVE
                            FROM
                              tbl_activities 
                            ORDER BY DATE_START DESC; 

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $SESSION_ID = $r['ID']; 
                                $PARTICULAR = $r['PARTICULAR']; 
                                $DATE_START = $r['DATE_START']; 
                                $DATE_END = $r['DATE_END']; 
                                $MONTH = $r['MONTH']; 
                                $MONTHNO = $r['MONTHNO'];
                                $YEAR = $r['YEAR'];
                                $STATUS= $r['STATUS'];
                                $ROW_CLASS = ($r['ISACTIVE']==1?'success':'');

                                $btn_edit_htm = "
                                            <a href=\"#\" class=\"btn  btn-xs btn-info btn-circle\" id=btnsessionedit data-toggle=\"modal\" data-target=\"#modal-session-editor\"
                                                LES_SESSION_ID =\"$SESSION_ID\"
                                                LES_PARTICULAR =\"$PARTICULAR\"
                                                LES_DATE_START =\"$DATE_START\"
                                                LES_DATE_END =\"$DATE_END\"
                                                LES_MONTH =\"$MONTHNO\"
                                                LES_YEAR =\"$YEAR\"

                                            >
                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
                                ";
                                $btn_rem_htm = "
                                            <a href=\"#\" 
                                                LES_SESSION_ID=$SESSION_ID
                                                id=btnsessiondelete 
                                            class=\"btn btn-danger btn-xs btn-circle disabled\"><i class=\"glyphicon glyphicon-trash\"></i></a>";
                                $btn_act_htm = "
                                            <a href=\"#\" class=\"btn  btn-xs btn-success btn-circle\" id=btnsessioneactivate 
                                                LES_SESSION_ID =\"$SESSION_ID\"
                                            >
                                            <i class=\"glyphicon glyphicon-ok\"></i></a>
                                ";

                                if ($r['ISACTIVE']==1) {
                                    $btn_act_htm = "";
                                }


                                echo "
                                    <tr class='$ROW_CLASS' id=row$SESSION_ID>
                                        <td class=\"even gradeC\"> $SESSION_ID</td>
                                        <td>$PARTICULAR</td>
                                        <td>$DATE_START</td>
                                        <td>$DATE_END</td>
                                        <td>$MONTH</td>
                                        <td>$YEAR</td>
                                        <td>$STATUS</td>
     
                                        
                                        <td>
                                            
                                        $btn_edit_htm
                                        $btn_rem_htm
                                        $btn_act_htm




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







<script>
    $(document).ready(function() {
        /*
        $('#dataTables-sessions').DataTable({
            responsive: true
        });
        */


    });
    
    //NEW SESSION
    $(document).on("click","#btnNewSession",function (e) {
        e.preventDefault();

        //alert("<?=$current_date?>");

        $('#ES_SESSION_ID').val(0);
        $('#ES_PARTICULAR').val('');

        $('#ES_YEAR').val("<?=$current_year?>");
        $('#ES_MONTH').val("<?=$current_month?>");

        $('#ES_START').val("<?=$current_date?>");

                
        var d = new Date("<?=$current_year?>","<?=($current_month)?>","<?=$current_day?>");
        d.setMonth(d.getMonth()+1);
        $('#ES_END').val(d.getFullYear()+'-'+('0'+d.getMonth()).slice(-2)+'-'+('0'+d.getDate()).slice(-2));

    });



    
    function isEmpty(value) {
        if ($.trim(value) == '') return true;
        else if (value == undefined) return true;
        else if ($.trim(value) == '0') return true;
        else if ($.trim(value) == undefined) return true;
        else return false;
    }
    
    //SAVE SESSION
    $(document).on("click","#btnsession_save",function (e) {
        e.preventDefault();    

        var ES_SESSION_ID =$('#ES_SESSION_ID').val();
        var ES_PARTICULAR =$('#ES_PARTICULAR').val();
        var ES_MONTH =$('#ES_MONTH').val();
        var ES_YEAR =$('#ES_YEAR').val();
        var ES_START =$('#ES_START').val();
        var ES_END =$('#ES_END').val();

        //validation


        if (isEmpty(ES_PARTICULAR)){
            alert('Particular is required!');
            $('#ES_PARTICULAR').closest("div").addClass("has-error");
        }

        if (ES_START>=ES_END){
            alert('start date must be less than the end date!');
            $('#ES_START').closest("div").addClass("has-error");
            $('#ES_END').closest("div").addClass("has-error");
        }

        
         $.ajax({  
            type: 'GET',
            url: './proc/deencodingsessioncheck_proc.php', 
            data: { 
                ES_SESSION_ID:ES_SESSION_ID,
                ES_START:ES_START,
                ES_END:ES_END,
            },
            success: function(response) {
                
                 if (response.indexOf("**success**") > -1){
                    var mode = '';
                    if (ES_SESSION_ID==0){
                        mode='insert';
                    }else{
                        mode='update';
                    }

                     $.ajax({  
                        type: 'GET',
                        url: './proc/deencodingsession_proc.php', 
                        data: { 
                            save_mode:mode,
                            ES_SESSION_ID:ES_SESSION_ID,
                            ES_PARTICULAR:ES_PARTICULAR,
                            ES_MONTH:ES_MONTH,
                            ES_YEAR:ES_YEAR,
                            ES_START:ES_START,
                            ES_END:ES_END,

                        },
                        success: function(response) {
                             //prompt('response: ',response);

                             if (response.indexOf("**success**") > -1){
                                //0:**success**
                                //1:html row
                                var strarray=response.split('|');
                                var row = strarray[1];
                                if (mode=='update') {
                                    $("#sessionlist #row"+ES_SESSION_ID).replaceWith( row );
                                    alert("Update Successful!");
                                    window.location.reload();
                                } else if (mode=='insert') {
                                    $( "#sessionlist" ).append( row );
                                    alert("New encoding schedule successfully established!");
                                    window.location.reload();
                                }           
                                
                             }else if (response.indexOf("**failed**") > -1){
                                
                                alert("Save failed: An error has occured while saving data. Please contact your system developer. ");


                             }else if (response.indexOf("**noChanges**") > -1){
                                    alert("Same data - no changes made");
                                

                             }
                        }
                    });       


                 }else if (response.indexOf("**conflict**") > -1){
                    var strarray=response.split('|');
                    var error_message = strarray[1];
                    alert(error_message);   
                 }
            }
        });       


        return;


    });

    //ACTIVATE SESSION
    $(document).on("click","#btnsessioneactivate",function(e){
        e.preventDefault();
         if (confirm("Activate this session as active?")){
              var SESSION_ID =$(this).attr('LES_SESSION_ID');

                 $.ajax({  
                    type: 'GET',
                    url: './proc/deEncodingSession_proc.php', 
                    data: { 
                        save_mode:'activate',
                        ES_SESSION_ID:SESSION_ID                    },
                    success: function(response) {
                         if (response.indexOf("**success**") > -1){
                            
                            alert("Sessions ID#"+SESSION_ID+" activated successfully");    
                            window.location.reload() ;                     
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Activation failed!");
                         }
                    }
                });                  
         }


    });

    //DELETE SESSONS
    $(document).on("click","#btnsessiondelete",function (e) {
        e.preventDefault();    
        /*
        var ClientCount =$(this).attr('ClientCount');
        if (ClientCount > 0) {
            alert("Unable to delete this session. You have an exisitng record associated with it!");
            return;
        }
        */

        if (confirm("You are about to delete this encoding schedule. Do you want to continue?")){
            var SESSION_ID =$(this).attr('LES_SESSION_ID');

            
                 $.ajax({  
                    type: 'GET',
                    url: './proc/deEncodingSession_proc.php', 
                    data: { 
                        save_mode:'delete',
                        ES_SESSION_ID:SESSION_ID                    },
                    success: function(response) {
                         if (response.indexOf("**success**") > -1){
                            $("#sessionlist #row"+SESSION_ID).remove();     
                            alert("Sessions ID#"+SESSION_ID+" deleted successfully");                      
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Delete failed!");
                         }
                    }
                });  
        }
    });

    //LOAD SESSION TO EDITOR
    $(document).on("click","#btnsessionedit",function (e) {
        e.preventDefault();
        var ES_SESSION_ID =$(this).attr('LES_SESSION_ID');
        var ES_PARTICULAR =$(this).attr('LES_PARTICULAR');
        var ES_MONTH =$(this).attr('LES_MONTH');
        var ES_YEAR =$(this).attr('LES_YEAR');
        var ES_START =$(this).attr('LES_DATE_START');
        var ES_END =$(this).attr('LES_DATE_END');

        $('#ES_SESSION_ID').val(ES_SESSION_ID);
        $('#ES_PARTICULAR').val(ES_PARTICULAR);
        $('#ES_MONTH').val(ES_MONTH);
        $('#ES_YEAR').val(ES_YEAR);
        $('#ES_START').val(ES_START);
        $('#ES_END').val(ES_END);
        
        $('#btnsession_save').html('UPDATE')
    })

/*
     $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
     });  
*/
    //SEARCH 
    $(document).on("click","#btnsearch",function(){
        var search_criteria = $('#search_criteria').val();

        $('#sessionlist').html('');  
            $.ajax({  
                type: 'GET',
                url: './proc/planlistsearch_proc.php', 
                data: { 
                    search_criteria:search_criteria

                },
                success: function(response) {
                    // prompt(response,response);

                     if (response.indexOf("**success**") > -1){
                        //    0 - result status
                        //    1 - html table rows for detail section
                        //    2 - row count
                        var strarray=response.split('|');
                        
                         $('#sessionlist').append(strarray[1]).fadeIn('slow');
                         $('#row_count').html( strarray[2] +' record found');

                     }else if (response.indexOf("**failed**") > -1){
                        $('#row_count').html('No record found');
                        alert('No record found');

                     }
                }
        });
    });
    
    //
    jQuery(document).ready(function() {
        $("#share_computation").on('change', function() {
            var computation_type = $(this).val();
            if (computation_type == 1){
                $("#comp_fixed").removeClass("hidden").fadeIn(500);
                $("#comp_percentage").fadeOut(500).addClass("hidden");
            }else{
                $("#comp_fixed").fadeOut(500).addClass("hidden");
                $("#comp_percentage").removeClass("hidden").fadeIn(500);

            }

        });

        $('#oi_computation').on('change',function(){
                var id = parseInt($(this).val(), 10);
                if($(this).is(":checked")) {
                    // checkbox is checked -> do something
                    $('#overiding_inc').removeClass('hidden').fadeIn(500);
                } else {
                    $('#overiding_inc').fadeOut(500).addClass('hidden');
                    // checkbox is not checked -> do something different
                }
        });


    });


</script>

<!-- Modal -->
<div class="modal fade" id="modal-session-editor" tabindex="-1" role="dialog" aria-labelledby="modal-session-editorLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-horizontal">
            <fieldset>
                <legend>ENCODING SESSION</legend>
            </fieldset>

              <div class="form-group">

                <label for="ES_PARTICULAR" class="control-label col-xs-4">PARTICULAR</label> 
                <div class="col-xs-8">
                  <input type="hidden" id="ES_SESSION_ID" value="">
                  <textarea id="ES_PARTICULAR" name="ES_PARTICULAR" cols="40" rows="5" class="form-control" required="required" aria-describedby="ES_PARTICULARHelpBlock"></textarea> 
                  <span id="ES_PARTICULARHelpBlock" class="help-block">The description of the activity</span>
                </div>
             

              </div>
              <div class="form-group">
                <label for="ES_MONTH" class="control-label col-xs-4">FOR MONTH</label> 
                <div class="col-xs-8">
                  <select id="ES_MONTH" name="ES_MONTH" required="required" class="select form-control">
                    <option value="1">JANUARY</option>
                    <option value="2">FEBRUARY</option>
                    <option value="3">MARCH</option>
                    <option value="4">APRIL</option>
                    <option value="5">MAY</option>
                    <option value="6">JUNE</option>
                    <option value="7">JULY</option>
                    <option value="8">AUGUST</option>
                    <option value="9">SEPTEMBER</option>
                    <option value="10">OCTOBER</option>
                    <option value="11">NOVEMBER</option>
                    <option value="12">DECEMBER</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="ES_YEAR" class="control-label col-xs-4">FOR YEAR</label> 
                <div class="col-xs-8">
                  <select id="ES_YEAR" name="ES_YEAR" required="required" class="select form-control">
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="ES_START" class="control-label col-xs-4">START DATE</label> 
                <div class="col-xs-8">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar-check-o"></i>
                    </div> 
                    <input id="ES_START" name="ES_START" type="date" class="form-control" required="required">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="ES_END" class="control-label col-xs-4">END DATE</label> 
                <div class="col-xs-8">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar-times-o"></i>
                    </div> 
                    <input id="ES_END" name="ES_END" type="date" class="form-control" required="required">
                  </div>
                </div>
              </div> 
            </form>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id=btnsession_save>Save</button>
      </div>
    </div>
  </div>
</div>