

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Sync Offline Encoding
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                SUMMMARY OF UPLOADED DATA
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="home">
                    <BR>
                    <?php



                    echo " 
                    $aes_notification
                    <button 
                        type=\"button\" 
                        class=\"btn btn-info pull-right\" 
                        aria-label=\"Left Align\" 
                        data-toggle=\"modal\" 
                        data-target=\"#ledger_payment_emcoding_modal\"
                        >
                           <span class=\"glyphicon glyphicon-saved disabled \" aria-hidden=\"true\"></span>
                            UPLOAD EXCEL
                           </button>
                    ";
                    
                    ?>

                    <br><br>



<?php


error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');


require_once dirname(__FILE__) . '/xls/Classes/PHPExcel.php';


function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


?>


<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-ledger">

    <thead>
        <tr>
            <th>#</th>
            <th>MEMBER</th>
            <th>INS</th>
            <th>OR DATE</th>
            <th>OR NUMBER</th>
            <th>AMOUNT PAID</th>
            <th>PERIOD COVERED</th>
        </tr>
    </thead>
    <tbody id=rowcontainer>

<?php 
$BRANCH="";
$AGENT="";
$PERIOD="";
$MCPR_ID="";
$TOTAL_AMOUNT = 0;
$IS_READY = 0;
 //Check valid spreadsheet has been uploaded

function getXlsValue($sheet, $cell){
    $value = $sheet->getCell($cell)->getValue(); 
    if (strlen($value)>0) {
        if ($value[0]=="="){
            return $sheet->getCell($cell)->getCalculatedValue();
        }else{
            return $sheet->getCell($cell)->getValue();
        }
    }
}


$COUNTER=1;
if(isset($_FILES['spreadsheet'])){
    if($_FILES['spreadsheet']['tmp_name']){
        if(!$_FILES['spreadsheet']['error']){
              $inputFile = $_FILES['spreadsheet']['tmp_name'];
              //$extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
              $extension = strtoupper(pathinfo($_FILES['spreadsheet']['name'], PATHINFO_EXTENSION));
             // $extension = strtoupper(explode(".", $_FILES['spreadsheet']['name'])[1]);

              
              if($extension == 'XLSX' || $extension == 'ODS'){

                  //Read spreadsheeet workbook
                  try {
                       $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                       $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                           $objPHPExcel = $objReader->load($inputFile);
                  } catch(Exception $e) {
                          die($e->getMessage());
                  }

                  //Get worksheet dimensions
                  $sheet = $objPHPExcel->getSheet(0); 
                  $highestRow = $sheet->getHighestRow(); 
                  $highestColumn = $sheet->getHighestColumn();

                  //GET HEADER
                  $BRANCH = $sheet->getCell("D5")->getValue();
                  $AGENT = $sheet->getCell("E5")->getValue();
                  //$PERIOD = $sheet->getCell("J5")->getValue();
                  $PERIOD = str_replace("Collection", "", $sheet->getCell("J5")->getValue());

                  //Loop through each row of the worksheet in turn
                  $mcpr_details_update_sqls="";
                  $COUNTER=1;
                  for ($row = 8; $row <=$highestRow; $row++){ 
                          //  Read a row of data into an array
                          //$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                          //Insert into database
                          
                      if ($sheet->getCell("A".$row)->getValue()==''){
                        break;
                      }
                          $MCPR_EID = $sheet->getCell("A".$row)->getValue();
                          $MCPR_ID = $sheet->getCell("B".$row)->getValue();

                          $MEMBER = $sheet->getCell("D".$row)->getValue();
                          $INS1 = getXlsValue($sheet,"J".$row);
                          $INS2 = getXlsValue($sheet,"K".$row);
                          $INS2 = $INS2 == $INS1?"":$INS2;  
                          $INS = $INS1.($INS2==""?"":"-".$INS2);

                          $ORDATE = $sheet->getCell("L".$row)->getValue();
                          $ORNO = $sheet->getCell("M".$row)->getValue();
                          $AMOUNT = $sheet->getCell("N".$row)->getValue();
                          $PC1 = $sheet->getCell("O".$row)->getValue();
                          $PC2 = $sheet->getCell("P".$row)->getValue();
                          $PC2 = $PC2 == $PC1?"":$PC2;  
                          $PC = $PC1."-".$PC2;
                          $PC = $PC1.($PC2==""?"":"-".$PC2);

                          $TOTAL_AMOUNT +=$AMOUNT;

                          if (!validateDate($ORDATE)){
                              $ORDATE = date('Y-m-d',  strtotime(gmdate("d-m-Y", ($ORDATE - 25569) * 86400)));
                          }

                            //echo date(31014);
                          if ($INS!='' && $ORNO!='' && $AMOUNT!='' && $ORDATE!='') {

                            echo "
                            <tr class=\"odd gradeX\">
                                <td class=\"center\">$COUNTER</td>
                                <td class=\"text-primary\">$MEMBER</td>
                                <td class=\"center\">$INS</td>
                                <td class=\"center\">$ORDATE</td>
                                <td class=\"center\">$ORNO</td>
                                <td class=\"center\">$AMOUNT</td>
                                <td class=\"center\">$PC</td>
                            </tr>
                            ";

                            $mcpr_details_update_sqls.="
                            Update tbl_mcpr_details
                                set
                                      ENC_INS = '$INS'
                                    , ENC_OR = '$ORNO'
                                    , ENC_ORDATE = '$ORDATE'
                                    , ENC_AMOUNT = '$AMOUNT'
                                    , ENC_PC = '$PC'
                                    , ENC_DATEENCODED = now()
                                    , ENC_USERID = '$user_id'
                            WHERE MCPR_EID = $MCPR_EID
                                  AND (ENC_VALIDATED IS NULL OR ENC_VALIDATED=0)
                            ;
                            ";                           

                          } 


                        $COUNTER++;

                  }
                  //echo "$mcpr_details_update_sqls";

                  if ($mcpr_details_update_sqls == '') {
                          echo "
                            <div class=\"alert alert-danger\" role=\"alert\">
                              <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
                              <span class=\"sr-only\">Upload Failed!</span>
                                Please check if your file does have data. If so, it should be complete <br> 
                                 
                            </div>
                        ";


                  }else{
                    $result = mysqli_multi_query($con,"$mcpr_details_update_sqls") or die(mysqli_error());
                    if (!$result) {
                          $IS_READY=0;
                          echo "
                              <div class=\"alert alert-danger\" role=\"alert\">
                                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
                                <span class=\"sr-only\">Upload Failed!</span>
                                 It seems that your file doesn't coincide with the database. 
                              </div>
                          ";
                    }else{
                          $IS_READY=1;
                          echo "
                              <div class=\"alert alert-success\" role=\"alert\" id=prompt>
                                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
                                <span class=\"sr-only\" ></span>
                                  <div id=prompt_message>
                                      Uploading successful! Please review your data before syncing to database. 
                                  </div>
                              </div>
                          ";

                    }

                  }



              }
              else{

                  echo "<br>Please upload an XLSX or ODS file";
              }
          }
        else{
            echo $_FILES['spreadsheet']['error'];
        }
    }
}

          
        ?>

    </tbody>
</table>




								<!-- PAYMENT ENCODING Modal -->
								<div class="modal fade" id="ledger_payment_emcoding_modal" tabindex="-1" role="dialog" aria-labelledby="ledger_payment_emcoding_modal_label">
								  <div class="modal-dialog" role="document" style="width:600px;">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <input type="hidden" id=MCPR_ID value="<?=$MCPR_ID?>"></input>
								        <h4 class="modal-title" id="ledger_payment_emcoding_modal_label">UPLOADED ENCODED MCPR</h4>
								      </div>
								      <div class="modal-body">


                                        <form method="post" enctype="multipart/form-data">
                                        Upload File: <input type="file" name="spreadsheet" id="spreadsheet"/>
                                        <br>
                                        <input class="btn btn-success" type="submit" name="submit" value="Submit" />
                                        
                                        </form>

								      </div>
								    </div>
								  </div>
								</div>
								<!-- //PAYMENT ENCODING Modal -->



                                </div>

                            </div>

                        </div>
                        <!-- /.panel-body -->
                    
                    </div>
                    <!-- /.panel -->






                </div>


                <!-- /.col-lg-6 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            INFORMATION
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>PART.</th>
                                            <th>DESC</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        echo "
                                            <tr><td><b>PERIOD</b></td><td>$PERIOD</td></tr>
                                            <tr><td><b>BRANCH</b></td><td>$BRANCH</td></tr>
                                            <tr><td><b>AGENT</b></td><td>$AGENT</td></tr>
                                            <tr><td><b>TRANS. ID</b></td><td>$MCPR_ID</td></tr>
                                            <tr><td><b>TOTAL AMOUNT</b></td><td>$TOTAL_AMOUNT</td></tr>
                                            <tr><td><b>NO. OF ENTRIES</b></td><td>".($COUNTER-1)."</td></tr>

                                        ";

                                    ?>
                                    </tbody>
                                </table>


                            </div>
                            <!-- /.table-responsive -->
                            <BR>
                        
                        <?php
                            $attr_disabled="disabled";
                            if ($IS_READY){
                                $attr_disabled="";
                            }

                            echo "
                                <button 
                                    $attr_disabled 
                                    id=btnSync
                                    type=\"button\" 
                                    class=\"btn btn-info form-control\" 
                                    aria-label=\"Left Align\" 
                                    width=100%
                                    >
                                    <span class=\"glyphicon glyphicon-saved disabled \" aria-hidden=\"true\"></span>
                                    SYNC NOW!
                                </button>

                            ";
                        ?>

                    

                        </div>
                        <!-- /.panel-body -->
            
                    </div>
                    <!-- /.panel -->
            
                </div>
                <!-- /.col-lg-6 -->
            
            </div>
            <!-- /.row -->
            
    <!--script src="../vendor/jquery/jquery.min.js"></script-->



<script>

$('#spreadsheet').bind('change', function() {
    $('#MCPR_ID').val('');
    if ($('#spreadsheet').val().substr( ($('#spreadsheet').val().lastIndexOf('.') +1)) != 'xlsx'){
        $("#spreadsheet").replaceWith($("#spreadsheet").val('').clone(true));
        alert("Invalid file type, please try again.");
        return;        
    }
});


$(document).on('click', '#btnSync', function(){ 
    if (confirm('Are you sure you want to import this data to the database?')) {



       $.ajax({  
            type: 'POST',
            url: './proc/mcpr_uploading_check_proc.php', 
            data: { 
                MCPR_ID: "<?=$MCPR_ID?>"
            },
            success: function(response) {
                
                console.log("res: " + response);
                 if (response.indexOf("**failed**") > -1){
                    alert('Synced failed! One or more OR/PR already used');
                    var arr=response.split("|");
                    $('#prompt').removeClass("alert-success");
                    $('#prompt').addClass("alert-danger");

                    $('#prompt').html(arr[1]);
                    return;

                 }else if (response.indexOf("**success**") > -1){

                       $.ajax({  
                            type: 'POST',
                            url: './proc/mcpr_uploading_proc.php', 
                            data: { 
                                MCPR_ID: "<?=$MCPR_ID?>"
                            },
                            success: function(response) {
                                
                                //console.log("res: " + response);
                                 if (response.indexOf("**success**") > -1){
                                    alert('Offline data successfully synced!');
                                    
                                    $('#btnSync').attr('disabled', 'true');
                                    $('#rowcontainer').html('');

                                    $('#prompt').removeClass("alert-danger");
                                    $('#prompt').addClass("alert-success");
                                    $('#prompt').html('Offline data successfully synced!');

                                 }else if (response.indexOf("**failed**") > -1){
                                    alert('An error has occured while syncing data');
                                 }                
                            }
                        });


                 }                
            }
        });





    }   
});






function getMonth(monthStr){
    return new Date(monthStr+'-1-01').getMonth()+1

}
function numToShortMonth(numMonth) {
    var arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    
    return arr[numMonth-1];
}



</script>

