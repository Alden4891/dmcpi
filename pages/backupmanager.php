<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Backup / Restore Database</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="alert alert-success hidden" id=message role="alert"></div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
              <ul class="nav nav-tabs">

                <li class="active"><a data-toggle="tab" href="#menu_backup">BACKUP/RESTORE</a></li>
                <li><a data-toggle="tab" href="#menu_upload">UPLOAD</a></li>
              </ul>

              <div class="tab-content">
                <div id="menu_backup" class="tab-pane fade in active">
                <br>
                <div class="pull-right">
                <a href="#" class="btn btn-success" id=btnNewBackup >New Backup</a>
                </div>
            
    <?php
        include 'dbconnect.php';
    ?>
    <br>
    <br>
        
            <br>
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>FILENAME</th>
                        <th width="13%">TIME</th>
                        <th width="10%">COMMANDS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        $result = mysqli_query($con,"SELECT backupid,filename,description,filedate,user_id FROM backups ORDER BY backupid DESC")or die(mysql_error());
                        while($row = mysqli_fetch_array($result)){
                            $backupid = $row['backupid'];
                            $filename = $row['filename'];
                            $filedate = $row['filedate'];
                                
                            echo "
                                <tr>
                                    <td>$backupid</td>
                                    <td><a href=\"backup\\$filename\">$filename</a></td>
                                    <td>$filedate</td>
                                    <td>
                                        <button 
                                        id=restore_backup 
                                        fn=\"$filename\"
                                        type=\"button\" class=\"btn btn-xs btn-info  \"><i class=\"fa fa-database\"></i> </button>
                                        <button id=delete_backup fn=\"$filename\" type=\"button\"  class=\"btn btn-xs btn-danger  \"><i class=\"glyphicon glyphicon-trash\"></i> </button>
                                    </td>
                                </tr>
                            ";
                        }
                        mysqli_free_result($result);

                    ?>
                </tbody>
            </table>
            </div>

            <div id="menu_upload" class="tab-pane fade">
            <br>
                <form  id="uploadbackup" method="POST" enctype="multipart/form-data" style="border:1px solid #000; width:100%; padding:20px;">
                    <label>Upload SQL File:</label>
                    <input type="file" name="file" class="form-control"> <br>
                    <input type="hidden" name="process" class="form-control" value="upload"> <br>

                    <input type="submit" name="submit" class="btn btn-success" value="Upload Database" />
                </form>
            </div>
          </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>


<script type="text/javascript">


    $('#uploadbackup').on("submit",function (e) {
        e.preventDefault();    
         
         $.ajax({  
            contentType: false,       
            cache: false,             
            processData:false,        
            type: 'POST',
            url: 'proc/backup_upload.php', 
            data: new FormData(this),
            success: function(response) {
                $('#message').removeClass('hidden');
                if (response.indexOf("**success**") > -1){                    
                    $('#message').html("Backup Successfully Uploaded!\n\r  <BR><BR><button id=restore_backup fn=\"uploaded_backup.sql\" type=\"button\" class=\"btn btn-xs btn-info \"><i class=\"fa fa-database\"></i> <b>RESTORE NOW!</b></button> ");    
                }else{

                }
            }
        });       



     });







    <?php if(isset($_POST['add_room'])) echo '$.jGrowl("Added Successfully!");'; ?>
    $(document).on("click","#btnNewBackup",function (e) {
        e.preventDefault();
        if (confirm('you are about to create backup. Do you want to continue?')){
            
             $.ajax({  
                type: 'GET',
                url: './proc/backup_create.php', 
                success: function(response) {
                    var strarray=response.split('|');
                    $('#message').removeClass('hidden');
                    $('#message').html("Backup Successfully! Download the <a href=\"backup/"+strarray[1]+"\" target=_blank >SQL FILE </a> OR RESTORE IT ANY TIME");
                    //window.location = "index.php?process=backupsuccess&page=backup";   
                }
            });           
        }else{
            return;
        }
    })
    


    $(document).on("click","#restore_backup",function (e) {
        e.preventDefault();    
        var fn =$(this).attr('fn');
        if (confirm("You are about to restore this backup. Do you want to continue?\n\rBackup: "+fn)){
            //window.location = "index.php?page=backup&process=restore&fn="+fn;
             $.ajax({  
                type: 'GET',
                url: './proc/backup_restore.php',
                    data: { 
                        mode:'restore',
                        fn:fn
                    },
                success: function(response) {
                   // alert(response);
                    $('#message').removeClass('hidden');
                    $('#message').html("Backup <b>"+fn+"</b> successfully restored");
                    //window.location = "index.php?process=backupsuccess&page=backup";   
                }
            });                        
        }
    });


    $(document).on("click","#delete_backup",function (e) {
        e.preventDefault();    
        var fn =$(this).attr('fn');
        if (confirm("You are about to delete this backup. Do you want to continue?\n\r Backup: "+fn)){
                 $.ajax({  
                    type: 'GET',
                    url: './proc/backup_delete_proc.php', 
                    data: { 
                        mode:'delete',
                        fn:fn
                    },
                    success: function(response) {
                      // prompt(response,response);

                         if (response.indexOf("**success**") > -1){
                            $("#clientlist #row"+role_id).remove();                           
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Delete failed!");
                           
                         }
                         
                    }
                });  
        }
    });


</script>
