<?php
    $cmd = (isset($_REQUEST['cmd'])?$_REQUEST['cmd']:'');
    $mode = (isset($_REQUEST['mode'])?$_REQUEST['mode']:'');
    $title = "";
    if ($mode=='' || $mode=='is'){
        $title = "INFORMATION SYSTEM";
    }else if ($mode=='as'){
        $title = "ACCOUNTING SYSTEM";
    }else if ($mode=='ms'){
        $title = "MEMORIAL SYSTEM";
    }


?>


<!DOCTYPE html>
<html lang="en">


  <head>

    <?php
    header("Content-Type: text/html; charset=utf-8");
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DMCPI | Diamond Memorial Care Plans Inc</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../build/css/custom.min.css" rel="stylesheet">


    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>




  </head>


<?php 
    if (isset($_REQUEST['cmd'])){
        if ($_REQUEST['cmd']=='logout'){
            $timeout = -1;
            setcookie('user_id', '', time() + ($timeout), "/"); 
            setcookie('fullname', '', time() + ($timeout), "/"); 
            setcookie('username', '', time() + ($timeout), "/"); 
            setcookie('password', '', time() + ($timeout), "/"); 
            setcookie('role_id', '', time() + ($timeout), "/"); 
            setcookie('role', '', time() + ($timeout), "/"); 
            //setcookie('Branch_Code', '', time() + ($timeout), "/"); 
            //setcookie('Branch_ID', '', time() + ($timeout), "/"); 
            setcookie('branch_ids', '', time() + ($timeout), "/"); 
            setcookie('mode', '', time() + ($timeout), "/"); 


/*
            setcookie('encoding', '', time() + ($timeout), "/"); 
            setcookie('collections', '', time() + ($timeout), "/"); 
            setcookie('audittrail', '', time() + ($timeout), "/"); 
            setcookie('reporting', '', time() + ($timeout), "/"); 
            setcookie('reporting', '', time() + ($timeout), "/"); 
*/

            setcookie('MP_MEMBER_ENCODING', '', time() + ($timeout), '/');
            setcookie('MP_MEMBER_DELETION', '', time() + ($timeout), '/');
            setcookie('MP_PAYMENT', '', time() + ($timeout), '/');
            setcookie('MP_MCPR_UPLOAD', '', time() + ($timeout), '/');
            setcookie('MP_ENCODING_SUMMARY', '', time() + ($timeout), '/');
            setcookie('MP_APPROVAL_OF_REQUESTS', '', time() + ($timeout), '/');
            setcookie('MP_DECEASED_UPDATING', '', time() + ($timeout), '/');
            setcookie('REP_AUDIT_TRAILS', '', time() + ($timeout), '/');
            setcookie('REP_MCPR_REPORTS', '', time() + ($timeout), '/');
            setcookie('REP_MCPR_GENERATE', '', time() + ($timeout), '/');
            setcookie('REP_MCPR_DOWNLOAD', '', time() + ($timeout), '/');
            setcookie('REP_MCPR_OFFLINE_DOWNLOAD', '', time() + ($timeout), '/');
            setcookie('REP_MCPR_DELETE', '', time() + ($timeout), '/');
            setcookie('REP_PERIODIC_INCENTIVES_REPORTS', '', time() + ($timeout), '/');
            setcookie('REP_MANILA_REPORTS', '', time() + ($timeout), '/');
            setcookie('REP_BRANCH_REPORTS', '', time() + ($timeout), '/');
            setcookie('REP_STATEMENT_OF_OPERATION', '', time() + ($timeout), '/');
            setcookie('FM_AGENT_MANAGEMENT', '', time() + ($timeout), '/');
            setcookie('FM_BRANCH_MANAGEMENT', '', time() + ($timeout), '/');
            setcookie('FM_PLANS', '', time() + ($timeout), '/');
            setcookie('FM_POLICY_FORMS', '', time() + ($timeout), '/');
            setcookie('MEMORIAL_SERVICES', '', time() + ($timeout), '/');
            setcookie('ACCT_INCENTIVES_COMPUTATION', '', time() + ($timeout), '/');
            setcookie('ACCT_OR_VERIFICATION', '', time() + ($timeout), '/');
            setcookie('ACCT_COLLECTION_SUMMARY', '', time() + ($timeout), '/');
            setcookie('SUPPORT_TICKETS_OPEN', '', time() + ($timeout), '/');
            setcookie('SUPPORT_TICKETS_CLOSED', '', time() + ($timeout), '/');
            setcookie('SUPPORT_USER_GUIDE', '', time() + ($timeout), '/');
            setcookie('SETTINGS_USER_ACCOUNTS', '', time() + ($timeout), '/');
            setcookie('SETTINGS_ACCESS_ROLES', '', time() + ($timeout), '/');
            setcookie('SETTINGS_BACKUP_RESTOR', '', time() + ($timeout), '/');
            setcookie('DEV_DEBUG', '', time() + ($timeout), '/');


            echo "<script>
            window.location = \"login.php\";
            </script>";
        }
    }
    include "dbconnect.php";
?>



  <!--body class="nav-md" background="images/dmcsm.jpg"-->
  <body style="background-image:url(images/dmcsm.jpg)">


          <?php

          
          if ($dev_mode==1){
            echo "

            <div class=\"container body main_container\">
            <div class=\"jumbotron\">
              <h1>DMCPI - Advisory</h1>
              <p>dmcpi.com is temporarily unavailable due to maintenance. Please try again later.</p>
            
            </div>
            </div>

            ";     
            return;       
          }

?>


    <div class="container body">



<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-10">
    
<br>
   <div class="row">
      <div class="col-md-4" >
        <div class="thumbnail" style="height:490px;opacity: .7">
        <br>
          <img src="images/is.svg" alt="Generic placeholder thumbnail" width="242" height="200">
          <div class="caption">
            <h3>Information System</h3>
            <p>Integrated set of components for collecting, storing, and processing data and for providing information, knowledge, and digital products</p>
            <p><a href="#" data-toggle="modal" data-target="#loginModal" id="btnlogin" system=is class="btn btn-primary" role="button">Login</a> </p>
            <a href='#' data-toggle="modal" data-target="#registrationModal" id=btnregister  system=is> Register new user</a>
          </div>

        </div>

      </div>
      <div class="col-md-4">

        <div class="thumbnail" style="height:490px;opacity: .7">
        <br>
          <img src="images/as.svg" alt="Generic placeholder thumbnail" width="242" height="200">
          <div class="caption">
            <h3>Accounting</h3>
            <p> Records and processes accounting transactions within functional modules such as incentives computation, payroll. etc.</p>
            <p><a href="#" data-toggle="modal" data-target="#loginModal"  class="btn btn-primary" id="btnlogin" system=as role="button">Login</a> </p>
            <a href='#' data-toggle="modal" data-target="#registrationModal" id=btnregister  system=as  > Register new user</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail" style="height:490px;opacity: .7">
        <br>
          <img src="images/ms.svg" alt="Generic placeholder thumbnail" width="242" height="200">
          <div class="caption">
            <h3>Memorial</h3>
            <p>A service that brings people together to celebrate and remember someone they loved through songs, stories and more. It can bring comfort and peace for affected families and friends while representing the unique life of the person lost.</p>
            <p><a href="#" data-toggle="modal" data-target="#loginModal"  class="btn btn-primary"  id="btnlogin" system=ms role="button">Login</a> </p>
            <a href='#' data-toggle="modal" data-target="#registrationModal" id=btnregister system=ms> Register new user</a>
          </div>
        </div>
      </div>
    </div>

    <!--center>
      <p class="bg-warning">
      <font color=#000000>
      Planning a funeral is one of life’s more difficult experiences. Death can bring about feelings that are hard to express, <br>and on top of heavy emotions, family members are faced with deciding how best to honor a loved one.
      </font>
      </p>


    </center-->



  </div>
  <div class="col-md-1"></div>
</div>

    <?php
      include 'footer2.php';
    ?>




    </div>

  </script>


    <!-- buttom page: above the closing body tag -->
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>




  </body>
</html>


    <!-- Modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">User Registration</h4>
                </div>
                <div class="modal-body">

             

                  <fieldset>

                <form class="form-horizontal" action='' method="POST">

                    <input type="hidden" name="selected_mode" id="selected_mode" value="<?=$mode?>">
                    <div class="control-group">
                      <label class="control-label" for="rfullname">Fullname</label>
                      <div class="controls">
                        <input type="text" id="rfullname" name="rfullname" placeholder="" class="form-control">
                        <p class="help-block">[Given Name] [M.i]. [Surname]</p>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="rrole">Role</label>
                      <div class="controls">
                        <select class="form-control" id="rrole">


                        </select>
                        <p class="help-block"></p>
                      </div>
                    </div>

                    <div class="control-group">
                      <!-- Username -->
                      <label class="control-label"  for="rusername">Username</label>
                      <div class="controls">
                        <input type="text" id="rusername" name="rusername" placeholder="" class="form-control">
                        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
                      </div>
                    </div>
                
                    <div class="control-group">
                      <!-- Password-->
                      <label class="control-label" for="rpassword1">Password</label>
                      <div class="controls">
                        <input type="password" id="rpassword1" name="rpassword1" placeholder="" class="form-control">
                        <p class="help-block">Password should be at least 8 characters</p>
                      </div>
                    </div>
                 
                    <div class="control-group">
                      <!-- Password -->
                      <label class="control-label"  for="rpassword2" >Password (Confirm)</label>
                      <div class="controls">
                        <input type="password" id="rpassword2" name="rpassword2" placeholder="" class="form-control " disabled>
                        <p class="help-block">Please confirm password</p>
                      </div>
                    </div>




                    <div class="control-group">
                      <label class="control-label" for="rbranch">Select Branch/es</label>
                      <div class="controls">


                         <div class="button-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Branch <span class="caret"></span></button>
                            <ul class="dropdown-menu">


                            <?php
                              $res_branches = mysqli_query($con, "SELECT Branch_ID, Branch_Name FROM branch_details");
                              while ($r_branches = mysqli_fetch_array($res_branches,MYSQLI_ASSOC)) {
                                $Branch_ID = $r_branches['Branch_ID'];
                                $Branch_Name = $r_branches['Branch_Name'];
                                echo "<li><a href=\"#\" class=\"small\" data-value=\"$Branch_ID\" tabIndex=\"-1\">
                                <input type=\"checkbox\"  
                                id=\"ids\" 
                                name=\"ids[]\" 
                                class=\"ids\"
                                value=\"$Branch_ID\"/>&nbsp;$Branch_Name</a></li>";
                              }
                            ?>

                            </ul>
                          </div>


                        <p class="help-block"></p>
                      </div>
                    </div>

                 
                <div id=rmessagebox ></div>
                  </fieldset>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id=regsitrationbutton>Register</button>


                </div>

                </form>

                            

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                  <div class="login-panel panel panel-default">
                      <div class="panel-heading">
                          <h3 class="panel-title"><CENTER><div id=title></div></CENTER></h3>
                      </div>
                      <div class="panel-body">
                          <form role="form" id=frmlogin>
                              <fieldset>
                                  <div class="form-group">
                                      <input class="form-control" placeholder="Username" name="username" type="username" autofocus id=username required>
                                  </div>
                                  <div class="form-group">
                                      <input class="form-control" placeholder="Password" name="password" type="password" value="" id=password required>
                                      <input type="hidden" name="mode" id="mode" value=""></input>
                                  </div>
                                  <div class="checkbox">
                                      <label>
                                          <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                      </label>
                                  </div>
                                  <!-- Change this to a button or input when using this as a form -->
                                  <!--a href="#" class="btn btn-lg btn-success btn-block" id=userloginsubmitbutton>Login</a-->
                                  <input type="submit" class="btn btn-lg btn-success btn-block" style="background:#2A3F54" value="Login"></input>
                              </fieldset>
                          </form> <br>
                           <!--a href='#' data-toggle="modal" data-target="#registrationModal"> Register </a-->
                           <div id=messagebox></div>

                            <div class="separator">
                              <div>
                                  <center>
                                    <img src="images/dmcpi_smlogo.jpg"/><font size=14> DMCPI </font><font size=6>v2.1</font> <br>
                                    <p>Diamond Memorial Care Sales and Marketing, Koronadal Proper, South Cotabato.<br>Diamond Memorial Care Sales and Marketing © 2018</p>

                                  </center>
                              </div>
                            </div>
                      </div>
                  </div>
               
                </div>

                </form>

                            

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.login modal -->


<script>

$(document).on('click','#btnlogin',function(e){
  e.preventDefault();

  var type = $(this).attr('system');
  var title = "";
  switch (type){
    case 'is': title = "INFORMATION SYSTEM";break;
    case 'ms': title = "MEMORIAL SYSTEM";break;
    case 'as': title = "ACCOUNTING SYSTEM";break;
  }

  $('#username').val('');
  $('#password').val('');
  $('#mode').val(type);
  $('#title').html(title);
});

$(document).on('click','#btnregister',function(e){
  e.preventDefault();
  var stype = $(this).attr('system');
  var opts_response = "";

/*
  if ($mode == 'ms') {
      $sql = "SELECT role_id, role FROM roles WHERE role = 'Memorial'";
  }else if ($mode == 'as'){
      $sql = "SELECT role_id, role FROM roles WHERE role = 'Accouting'";
  }else{
      $sql = "SELECT role_id, role FROM roles WHERE NOT role IN ('Accouting','Memorial')";       
  }
*/


    $('#selected_mode').val(stype);
    if (stype=='ms'){
        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "roles",
                valueMember:  "role_id",
                displayMember:  "role",
                condition: "role = 'Memorial'",
            },
            success: function(response) {
                //prompt(response,response);
                $('#rrole').html(response);
            }
        });

      }else if (stype=='as'){
        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "roles",
                valueMember:  "role_id",
                displayMember:  "role",
                condition: " role = 'Accouting'",
            },
            success: function(response) {
                $('#rrole').html(response);
            }
        });
      }

      else if ( stype=='is'){
        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "roles",
                valueMember:  "role_id",
                displayMember:  "role",
                condition: "NOT role IN ('Accouting','Memorial','Superuser')",
            },
            success: function(response) {
                $('#rrole').html(response);
            }
        });
      }


      

});






$("#rpassword1").keyup(function() {
    if($(this).val().length > 7) {
        // $('#rpassword2').removeClass('');
         $("#rpassword2").prop('disabled',false);
    } else {
         // Disable submit button
         $("#rpassword2").prop('disabled',true);
    }
});

$('#regsitrationbutton').on('click', function(e) {
    e.preventDefault();
    var error_count = 0;
    var ddata = $('.ids:checked').serialize(); //Selected branches

    if ($('#rfullname').val().trim()=='') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Plese enter fullname!.</div>')
        $('#rfullname').focus();
        error_count+=1;
        return;
    }

    if ($('#rrole').val()=='0'){
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Please select user role</div>')
        $('#rrole').focus();
        error_count+=1;
        return;
    }

    if ($('#rusername').val().trim()=='') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Plese enter username!.</div>')
        $('#rusername').focus();
        error_count+=1;
        return;
    }

    if ($('#rpassword1').val().trim()=='') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Plese enter password!.</div>')
        $('#rpassword1').focus();
         error_count+=1;
        return;
    }
/*
    alert($('#rpassword1').val().trim().lenght());
    if ($('#rpassword1').val().trim().lenght < 9 ) {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Password must atleast 8 character!.</div>')
        $('#rpassword1').focus();
         error_count+=1;
        exit();
    }    
*/
    if ($('#rpassword1').val().trim()!=$('#rpassword2').val().trim()) {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Password missmatch!.</div>')
        $('#rpassword2').focus();
         error_count+=1;
        return;
    }

    if (ddata.length==0) {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Please select branch/es!.</div>')
        $('#rbranch').focus();
         error_count+=1;
        return;
    }



    if (error_count==0){
      //send POST here
        

        $.ajax({  
            type: 'GET',
            url: './proc/userregistration_proc.php', 
            data: { 
                data: ddata,
                role_id:$('#rrole').val(),
                fullname:$('#rfullname').val(),
                username:$('#rusername').val(),
                password :$('#rpassword1').val(),
                selected_mode:$('#selected_mode').val()
                //branch :$('#rbranch').val()
               
            },
            success: function(response) {
                 //prompt(response,response);
               
                 if (response.indexOf("**success**") > -1){

                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-success">Registration Successful. You can now login</div>')
                    $('#registrationModal').modal('hide')
                 }else if (response.indexOf("**failed**") > -1){
                    $('#rmessagebox').hide();
                    $('#rmessagebox').fadeIn('slow');
                    $('#rmessagebox').html('<br><div class="alert alert-danger">Registration Failed!.</div>')
                 }else if (response.indexOf("**exists**") > -1){
                    $('#rmessagebox').hide();
                    $('#rmessagebox').fadeIn('slow');
                    $('#rmessagebox').html('<br><div class="alert alert-danger">Username already exists!.</div>')
                 }


            }
        });


    } //if error ==0

});

$("#frmlogin").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.



    var error_count = 0;

    if ($('#username').val().trim()=='') {
        $('#messagebox').hide();
        $('#messagebox').fadeIn('slow');
        $('#messagebox').html('<br><div class="alert alert-danger">Plese enter username!.</div>');
        $('#username').focus();

        return;
    }


    if (error_count==0){
      //send POST here

        $.ajax({  
            type: 'GET',
            url: './proc/login_proc.php', 
            data: { 
                username:$('#username').val(),
                password:$('#password').val(),
                mode:$('#mode').val()
            },
            success: function(response) {
                 //prompt(response,response);
                 

                 if (response.indexOf("**Disabled**") > -1){
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. Please contact the system administrator for the approval of your account.</div>')                    
                 }else if (response.indexOf("**success**") > -1){
                     window.location.href = 'index.php';
                 }else if (response.indexOf("**failed**") > -1){
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!.</div>')
                 }else if (response.indexOf("**ms**") > -1){
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. This account is not for memorial system</div>');

                 }else if (response.indexOf("**as**") > -1){
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. This account is not for accounting system</div>');
                    console.log(response);
                 }else if (response.indexOf("**is**") > -1){
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. This account is not for information system</div>');

                 } else {
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">OPS. </div> <br>ERROR: '+response);       
                     console.log('error:'+response);            
                 }


            }
        });


    } //if error ==0



});

//--------------------------------------------------------
// $('#userloginsubmitbutton').on('click', function(e) {
//     e.preventDefault();
//     var error_count = 0;



//     if ($('#username').val().trim()=='') {
//         $('#messagebox').hide();
//         $('#messagebox').fadeIn('slow');
//         $('#messagebox').html('<br><div class="alert alert-danger">Plese enter username!.</div>')
//         $('#username').focus();

//         exit();
//     }



//     if (error_count==0){
//       //send POST here

//         $.ajax({  
//             type: 'GET',
//             url: './proc/login_proc.php', 
//             data: { 
//                 username:$('#username').val(),
//                 password:$('#password').val()
//             },
//             success: function(response) {
//                  //prompt(response,response);
//                  if (response.indexOf("**success**") > -1){
//                      window.location.href = 'index.php';
//                  }else if (response.indexOf("**ms**") > -1){
//                     $('#messagebox').hide();
//                     $('#messagebox').fadeIn('slow');
//                     $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. This account is not for memorial system</div>');

//                  }else if (response.indexOf("**as**") > -1){
//                     $('#messagebox').hide();
//                     $('#messagebox').fadeIn('slow');
//                     $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. This account is not for accounting system</div>');
//                  }else if (response.indexOf("**is**") > -1){
//                     $('#messagebox').hide();
//                     $('#messagebox').fadeIn('slow');
//                     $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!. This account is not for information system</div>');

//                  } else {
//                     $('#messagebox').hide();
//                     $('#messagebox').fadeIn('slow');
//                     $('#messagebox').html('<br><div class="alert alert-danger">OPS.</div>');                   
//                  }


//             }
//         });


//     } //if error ==0

// });

</script>