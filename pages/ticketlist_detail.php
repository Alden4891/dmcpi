<?php

	$tn = isset($_REQUEST['tn'])?$_REQUEST['tn']:'';
  //-------------------------------------------
  $res_tickets = mysqli_query($con, "
    SELECT
        `tickets`.`TICKETNO`
        , `libcategory`.`CATEGORY`
        , `tickets`.`PRIORITY`
        , `tickets`.`SUBJECT`
        , `tickets`.`DESCRIPTION`
        , `tickets`.`DATE_RAISED`
        , `tickets`.`DATE_UPDATED`
        , `libstatus`.`ID` AS STATUS_ID
        , `libstatus`.`STATUS`
        , `users`.`user_id` AS USER_ID
        , `users`.`fullname`
    FROM
        `tickets`
        INNER JOIN `users` 
            ON (`tickets`.`USER_ID` = `users`.`user_id`)
        INNER JOIN `libstatus` 
            ON (`libstatus`.`ID` = `tickets`.`STATUS`)
        INNER JOIN `libcategory` 
            ON (`tickets`.`CATEGORY` = `libcategory`.`ID`)            
    WHERE (`tickets`.`TICKETNO` =$tn);
  ");

  $r=mysqli_fetch_array($res_tickets, MYSQLI_ASSOC);

  $TICKETNO = $r['TICKETNO'];
  $USER_ID = $r['USER_ID'];
  $CATEGORY = $r['CATEGORY'];
  $PRIORITY = $r['PRIORITY'];
  $SUBJECT = $r['SUBJECT'];
  $DESCRIPTION = $r['DESCRIPTION'];
  $DATE_RAISED = $r['DATE_RAISED'];
  $DATE_UPDATED = $r['DATE_UPDATED'];
  $STATUS = $r['STATUS'];
  $STATUS_ID = $r['STATUS_ID'];
  $FULLNAME = $r['fullname'];

  if ($PRIORITY == 1) {
    $PRIORITY = 'LOW';
  }else if ($PRIORITY == 2){
    $PRIORITY = 'NORMAL';
  }else if ($PRIORITY == 3){
    $PRIORITY = 'HIGH';
  }


  $editor_disabled = false;
  if (!in_array($STATUS_ID, array(0, 1, 2))) {
     $editor_disabled = true;
  }

  //check if the user is the concerned person
  $cur_user_type = "";
  if ($USER_ID == $user_id) { //db-user == logged=user
    $cur_user_type = "cp";
  } else {
    $cur_user_type = "ts";   
  }





  //get chats ------------------------------------------------

  $res_chats = mysqli_query($con, "

    SELECT
        `chat`.`ID`
        , `chat`.`CONVERSATION`
        , `chat`.`TICKETNO`
        , `chat`.`DATE_POSTED`
        , `users`.`fullname`
        , `users`.`user_id`
    FROM
        `chat`
        INNER JOIN `users` 
            ON (`chat`.`USER_ID` = `users`.`user_id`)
    WHERE (`chat`.`TICKETNO` =$tn)
    ORDER BY `chat`.`DATE_POSTED` DESC;

    ");


 // include 'dbclose.php';


?>

    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
 
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">


            <div class="col-md-12 col-sm-11 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>TICKET# <?=$tn?></h2> 

                  <?php
                    if ($editor_disabled == false) {

                        if ($cur_user_type == "ts") {

                            echo "
                            <div class=\"pull-right\">
                              <div class=\"dropdown\">
                                <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">
                                  Action
                                  <span class=\"caret\"></span>
                                </button>
                                <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">
                                  <li><a href=\"#\" class=\"change_status\" cmd=\"close\">Resolved</a></li>
                                  <li><a href=\"#\" class=\"change_status\" cmd=\"cancel\">Cancel</a></li>
                                </ul>
                              </div>
                            </div>
                            ";
                        } else {
                            echo "
                            <div class=\"pull-right\">
                              <div class=\"dropdown\">
                                <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">
                                  Action
                                  <span class=\"caret\"></span>
                                </button>
                                <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">
                                  <li><a href=\"#\" class=\"change_status\" cmd=\"cancel\">Cancel</a></li>
                                </ul>
                              </div>
                            </div>
                            ";

                        }                     
                    }
                  ?>


                  <!--ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul-->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">


            <!--======== contact =========-->
            <section id="contact3" class="contact3">
                <div class="container">
                    <div class="row">
                        <div class="contact-overlay">
                            <div class="col-md-6">  
                                <h3 class="section-title"><?=$SUBJECT?></h3>
                                <div class="row">

                                    <div class="col-sm-12 ">
                                        <div class="form-group">
                                            <?=$DESCRIPTION ?>                                       
                                        </div>
                                    </div>

                                </div>        
                            </div>
                            <div class="col-md-5 col-md-offset-1" style="border-left:1px solid #cfcfcf;height:250px">
                                <ul class="list-unstyled">
                                    <li class="addr-title"><i class="fa fa-user"> </i> Concerned Person: <b><?=$FULLNAME ?></b></li>
                                </ul>
                                <hr>
                                <ul class="list-unstyled">
                                    <li class="addr-title"><i class="fa fa-ticket"></i> Ticket #: <b><a id=tn><?=$tn ?></a></b></li>
                                    <li><i class="fa fa-tags"></i> <span>Category: <b><?=$CATEGORY ?></b></span></li>
                                    <li><i class="fa fa-tags"></i> <span>Status: <b><?=$STATUS ?></b></span></li>
                                    <li><i class="fa fa-star"></i> <span>Priority: <b><?=$PRIORITY ?></b></span></li>
                                    <li><i class="fa fa-calendar"></i> <span>Date Raised: <b><?=$DATE_RAISED ?></b></span></li>
                                    <li><i class="fa fa-calendar-o"></i> <span>Date Updated: <b><?=$DATE_UPDATED ?></b></span></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>    
            </section>

                </div>
              </div>
            </div>


          <!-- *********************************************************** -->


            <div class="col-md-12 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Conversation</h2> 

                  <?php
                    if ($editor_disabled == false) {
                  echo "
                  <div class=\"pull-right\"><a class=\"btn btn-sm btn-primary\" class=\"btn btn-primary \"  data-toggle=\"modal\" data-target=\"#exampleModal\" >NEW MESSAGE</a></div>

                    ";                      
                    }


                  ?>


                  <!--ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul-->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <ul class="list-unstyled timeline">
                   

                <?php
                  while ($r=mysqli_fetch_array($res_chats, MYSQLI_ASSOC)) {
                    $CONVERSATION_ID = $r['ID'];
                    $CONVERSATION = $r['CONVERSATION'];
                    $DATE_POSTED = $r['DATE_POSTED'];
                    $fullname = $r['fullname'];

                    $start_date = new DateTime($DATE_POSTED);
                    $since_start = $start_date->diff(new DateTime());


                    $lapse = "";
                    if ($since_start->y > 0) {
                      $lapse = $since_start->y.' years ago';
                    }else if ($since_start->m > 0){
                      $lapse = $since_start->m.' months ago';
                    }else if ($since_start->d > 0){
                      $lapse = $since_start->d.' days ago';
                    }else if ($since_start->h > 0){
                      $lapse = $since_start->h.' hours ago';
                    }else if ($since_start->i > 0){
                      $lapse = $since_start->i.' minutes ago';
                    } else {
                      $lapse = ' just now ';
                    }

                    echo "

                    <li>
                      <div class=\"block\">
                        <div class=\"tags \">
                          <a href=\"#\" class=\"tag\">
                            <span>$fullname</span>
                          </a>
                        </div>
                        <div class=\"block_content\">
                          <!--h2 class=\"title\">
                                          <a>$SUBJECT</a></h2-->
                          <div class=\"byline\">
                            <span>$lapse</span> by <a>".ucwords(strtolower($fullname))."</a>
                          </div>
                          <p class=\"excerpt\">$CONVERSATION</p>
                        </div>
                      </div>
                    </li>


                    ";

                  }
                ?>




                  </ul>

                </div>
              </div>
            </div>

  <!-- *********************************************************** -->



                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                              <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                </ul>
                              </div>

                              <div class="btn-group">
                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                              </div>

                              <div class="btn-group">
                                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                              </div>

                              <div class="btn-group">
                                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                              </div>

                              <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                <div class="dropdown-menu input-append">
                                  <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                  <button class="btn" type="button">Add</button>
                                </div>
                                <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                              </div>

                              <div class="btn-group">
                                <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                              </div>

                              <div class="btn-group">
                                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                              </div>
                            </div>

                            <div id="editor-one" class="editor-wrapper"></div>

                           
                            
                            <br />

              
                            <button  type="button" class="btn btn-secondary" value="POST" id=btnsubmitresponse> POST </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                            <!--textarea id=test></textarea-->

                        </div>
                       
                      </div>
                    </div>
                  </div>



                </div>
              </div>
            </div>





    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>

    <script src="../build/js/custom.min.js"></script>




<?php
  mysqli_free_result( $res_tickets);
  mysqli_free_result( $res_chats);
 // mysqli_free_result( $res_cp);

?>


<script type="text/javascript">
$('.change_status').on('click', function(){
  var cmd = $(this).attr('cmd');
  var sender_user_id = $('#user_info').attr('user_id');
  var tn = $('#tn').html()

  if (confirm('You are about to '+cmd+' this ticket. Do you want to continue?')==false) {
    return;
  }

         $.ajax({  
            type: 'POST',
            url: 'proc/ticket_changestatus_proc.php', 
            data: {
              CMD: cmd,
              TICKETNO: tn,
              USER_ID : sender_user_id
            },
            success: function(response) {
                //prompt('Response:',response);
                //return;
                 if (response.indexOf("**success**") > -1){

                    if (cmd=='close'){
                         alert('Ticket #' + tn + ' successfully closed');
                    }else if (cmd=='cancel'){
                         alert('Ticket #' + tn + ' cancelled.');
                    }


                   
                    window.location="index.php?page=ticketlist_ongoing";
                 }else if (response.indexOf("Notice") > -1){
                    alert("An error occured while posting your message. ");
                 }
            }
        });  


});


	$('#btnsubmitresponse').on('click',function (){
		var reply = $('#editor-one').html();
		var tn = $('#tn').html()
    var sender_user_id = $('#user_info').attr('user_id');

	 if ($.trim(reply)=='') {
    alert('Please enter your message.');
    return;
   } 


   //prompt('',reply);
   $('#msg').html = reply;
         $.ajax({  
            type: 'POST',
            url: 'proc/chat_post.php', 
            data: {
              reply: reply,
              TICKETNO: tn,
              sender_user_id: sender_user_id
            },
            success: function(response) {
                //prompt('Response:',response);
                //$('#test').html(response);
                //return;
                 if (response.indexOf("**success**") > -1){
                    alert('Message successfully posted.');
                    window.location="index.php?page=ticketlist_detail&tn=" + tn;
                 }else if (response.indexOf("Notice") > -1){
                    alert("An error occured while posting your message. ");
                 }
            }
        });  
	});

</script>

