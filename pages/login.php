<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DMCSM - Memorial Plan System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
            setcookie('encoding', '', time() + ($timeout), "/"); 
            setcookie('collections', '', time() + ($timeout), "/"); 
            setcookie('audittrail', '', time() + ($timeout), "/"); 
            setcookie('reporting', '', time() + ($timeout), "/"); 
            setcookie('reporting', '', time() + ($timeout), "/"); 
            setcookie('Branch_Code', '', time() + ($timeout), "/"); 


        }
    }

    include "dbconnect.php";


?>



<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" autofocus id=username required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" id=password required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="#" class="btn btn-lg btn-success btn-block" id=userloginsubmitbutton>Login</a>
                            </fieldset>
                        </form> <br>
                         <a href='#' data-toggle="modal" data-target="#registrationModal"> Register </a>
                            <div id=messagebox>

                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>


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
                            <option value="0">Select</option>
                            <option value="1">Administrator</option>
                            <option value="2">Encoder</option>
                            <option value="3">Collector</option>
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
                      <label class="control-label" for="rbranch">Branch</label>
                      <div class="controls">
                        <select class="form-control" id="rbranch">
                            <option value="0">Select</option>

                            <?php
                                $res_roles  =mysql_query("SELECT branch_id, branch_manager AS branch FROM branch_details");
                                while ($r = mysql_fetch_array($res_roles,MYSQL_ASSOC)) {
                                    $id = $r['branch_id'];
                                    $value = $r['branch'];
                                    echo "<option value=\"$id\"> $value</option>";


                                }

                                mysql_free_result($res_roles);
                            ?>


                        </select>
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


</body>

</html>

<?php 
    include "dbclose.php";
?>


<script>

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

    if ($('#rfullname').val().trim()=='') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Plese enter fullname!.</div>')
        $('#rfullname').focus();
        error_count+=1;
        exit();
    }

    if ($('#rrole').val()=='0'){
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Please select user role</div>')
        $('#rrole').focus();
        error_count+=1;
        exit();
    }

    if ($('#rusername').val().trim()=='') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Plese enter username!.</div>')
        $('#rusername').focus();
        error_count+=1;
        exit();
    }

    if ($('#rpassword1').val().trim()=='') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Plese enter password!.</div>')
        $('#rpassword1').focus();
         error_count+=1;
        exit();
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
        exit();
    }
    if ($('#rbranch').val()=='0') {
        $('#rmessagebox').hide();
        $('#rmessagebox').fadeIn('slow');
        $('#rmessagebox').html('<br><div class="alert alert-danger">Please select branch!.</div>')
        $('#rbranch').focus();
         error_count+=1;
        exit();
    }
    if (error_count==0){
      //send POST here

        $.ajax({  
            type: 'GET',
            url: './proc/userregistration_proc.php', 
            data: { 
                role_id:$('#rrole').val(),
                fullname:$('#rfullname').val(),
                username:$('#rusername').val(),
                password :$('#rpassword1').val(),
                branch :$('#rbranch').val()
               
            },
            success: function(response) {
                // prompt(response,response);
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



//--------------------------------------------------------
$('#userloginsubmitbutton').on('click', function(e) {
    e.preventDefault();
    var error_count = 0;

    if ($('#username').val().trim()=='') {
        $('#messagebox').hide();
        $('#messagebox').fadeIn('slow');
        $('#messagebox').html('<br><div class="alert alert-danger">Plese enter username!.</div>')
        $('#username').focus();

        exit();
    }


    if (error_count==0){
      //send POST here

        $.ajax({  
            type: 'GET',
            url: './proc/login_proc.php', 
            data: { 
                username:$('#username').val(),
                password:$('#password').val()
            },
            success: function(response) {
                 //prompt(response,response);
                 if (response.indexOf("**success**") > -1){
                     window.location.href = 'index.php';
                 }else if (response.indexOf("**failed**") > -1){
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">Access Denied!.</div>')

                 } else {
                    $('#messagebox').hide();
                    $('#messagebox').fadeIn('slow');
                    $('#messagebox').html('<br><div class="alert alert-danger">OPS.</div>')                   
                 }


            }
        });


    } //if error ==0

});

</script>