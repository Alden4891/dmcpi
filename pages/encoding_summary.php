
<?php

    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:1900);
    $selectedMonth = (isset($_REQUEST['selectedMonth'])?$_REQUEST['selectedMonth']:1);
    $selectedEncSessionID = (isset($_REQUEST['selectedEncSessionID'])?$_REQUEST['selectedEncSessionID']:0);
    $fltrd = isset($_REQUEST['fltrd'])?1:0;


    $arr_month = array('1'  => 'January' 
                      ,'2'  => 'February' 
                      ,'3'  => 'March' 
                      ,'4'  => 'April' 
                      ,'5'  => 'May' 
                      ,'6'  => 'June' 
                      ,'7'  => 'July' 
                      ,'8'  => 'August' 
                      ,'9'  => 'September' 
                      ,'10' => 'October' 
                      ,'11' => 'November' 
                      ,'12' => 'December'
    );

    function intToMonth($monthNum){
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        return  $dateObj->format('F');  
    }

?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Encoding Summary
        <?php
        if ($fltrd==1){
            $monthname = $arr_month[$selectedMonth];
            echo " for $monthname $selectedYear";
        }
        ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="panel panel-default" id=filter_panel >
  <div class="panel-heading"> Filter</div>
    <div class="panel-body">

    <div class="row" id=filter>
      <form action='index.php' method="GET" name="non_mcpr_getdata">

      <div class="form-row" >

        <div class="form-group col-md-2">
          <label for="selectedYear">Year</label>
            <select class="form-control" id="selectedYear" name=selectedYear  required>
            <?php
                $res_filter = mysqli_query($con,"SELECT DISTINCT YEAR FROM tbl_activities ORDER BY YEAR DESC;") or die(mysqlI_error());
                echo "<option value=\"\">Select</option>";
                while ($r=mysqli_fetch_array($res_filter,MYSQLI_ASSOC)) {
                    $year = $r['YEAR'];
                    echo "<option value=\"$year\">$year</option>";                
                }
                mysqli_free_result($res_filter);
            ?>
            </select>
        </div>
        <div class="form-group col-md-2">
          <label for="selectedMonth">Month</label>
            <select class="form-control" id="selectedMonth" name="selectedMonth"  required>
            </select>
        </div>
            <input type="hidden" name="page" value="encoding_summary"></input>
            <input type="hidden" name="fltrd" value="1"></input>
            <input type="hidden" name="selectedEncSessionID" id="selectedEncSessionID" value="0"></input>


        <div class="form-group col-md-2">
              <font size=3> &nbsp;</font><br>
              <input type="submit" class="btn btn-info" value="DISPLAY"></input>
        </div>
        </div><!--ROW ENDS 2-->
        </form>
    </div> <!-- filter2 -->

  </div>
</div>

<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAME OF ENCODER</th>
                            <th>NO. OF ENCODED RECEIPT</th>
                            <th>GROSS</th>
                            <th>BRANCH</th>
                            <th width="50px">Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $data_sql = "
                            SELECT
                                `users`.`user_id`
                                , `users`.`fullname`
                                , COUNT(`installment_ledger`.`ORno`) AS `Member_Count`
                                , SUM(`installment_ledger`.`Amt_Due`) AS `Amount`
                                , `branch_details`.`Branch_Name`
                            FROM
                                `dmcpi1_dmcsm`.`installment_ledger`
                                INNER JOIN `dmcpi1_dmcsm`.`users` 
                                    ON (`installment_ledger`.`encoded_by` = `users`.`user_id`)
                                INNER JOIN `dmcpi1_dmcsm`.`members_account` 
                                    ON (`installment_ledger`.`Member_Code` = `members_account`.`Member_Code`)
                                INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
                                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                            WHERE `installment_ledger`.`enc_session_id`=$selectedEncSessionID
                                
                            GROUP BY `users`.`user_id`, `users`.`fullname`, `branch_details`.`Branch_Name`
                            ORDER BY `installment_ledger`.`encoded_by` DESC;
                            ";

                            $res_data = mysqli_query($con, $data_sql) or die(mysqli_error());
                            $cnt = 0 ;
                            $monthName = intToMonth($selectedMonth);
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $cnt+=1;
                                $user_id = $r['user_id']; 
                                $fullname = $r['fullname']; 
                                $Member_Count = $r['Member_Count']; 
                                $Amount = $r['Amount']; 
                                $Branch_Name = $r['Branch_Name']; 

                                echo "
                                    <tr class=\"\">
                                        <td class=\"even gradeC\"> $cnt</td>
                                        <td>$fullname</td>
                                        <td>$Member_Count</td>
                                        <td>$Amount</td>
                                        <td>$Branch_Name</td>

                                        <td>
                                            <a href=\"#\" 
                                            id=btnShowDetails
                                            year=$selectedYear
                                            month=$selectedMonth
                                            encoder_id=$user_id
                                            encoder=$fullname
                                            monthName=$monthName
                                            encSessionID=$selectedEncSessionID
                                            data-toggle=\"modal\" 
                                            data-target=\".preview_modal\"
                                            class=\"btn  btn-xs btn-success btn-circle\"><i class=\"glyphicon glyphicon-file\"> </i></a>
                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_data);
                            
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- YEAR(ordate) ="+selectedYear+" ORDER BY MONTH(ordate) -->
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="modal fade bs-example-modal-sm preview_modal" tabindex="-1" role="dialog" aria-labelledby="modal_update_deceased">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">


          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="preview_modal_title"></h3>
          </div>
          <div class="modal-body" id=bmagent_sharelist_modal_body>
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PR#</th>
                            <th>PR DATE</th>
                            <th>AMOUNT</th>
                            <th>DATE ENCODED</th>
                            <th>BRANCH</th>
                        </tr>
                    </thead>
                    <tbody id=rowlist>

                    </tbody>
                </table>

          </div>
          <div class="modal-footer">
            <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
          </div>

    </div>
  </div>
</div>

<script>

    $(document).on('click','#btnShowDetails', function(e){
        e.preventDefault();
        var selectedYear = $(this).attr('year');
        var selectedMonth = $(this).attr('month');
        var encoder_id = $(this).attr('encoder_id');
        var encoder = $(this).attr('encoder');
        var monthName = $(this).attr('monthName');
        var selectedEncSessionID = $(this).attr('encSessionID');

        $.ajax({  
            type: 'GET',
            url: './proc/encoding_summary_proc.php', 
            data: { 
                selectedYear: selectedYear,
                selectedMonth:  selectedMonth,
                encoder_id:  encoder_id,
                selectedEncSessionID:selectedEncSessionID,
            },
            success: function(response) {
//                console.log(response);
                $('#rowlist').html(response);
                $('#preview_modal_title').html('Encoded by '+encoder+' for '+monthName+' '+selectedYear);

            }
        });



    });

    
    $('#selectedYear').change(function(){
        // select distinct MONTH(date_of_membership) as 'MONTH', MONTHNAME(date_of_membership) as 'MONTHNAME' 
        // from members_account where year(date_of_membership) = 2018 order by date_of_membership;


        var selectedYear = $(this).val();
        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "tbl_activities",
                valueMember:  "DISTINCT `MONTHNO`",
                displayMember:  "udf_inttomonthname(`MONTHNO`)",
                condition: "`YEAR`="+selectedYear+" ORDER BY `MONTHNO` DESC",
            },
            success: function(response) {
                //console.log(response);
                $('#selectedMonth').html(response);

            }
        });


    }); 

    $('#selectedMonth').change(function(){
        //SELECT id FROM tbl_activities WHERE YEAR=2019 AND monthno=2;
        var selectedYear = $('#selectedYear').val();
        var selectedMonth = $(this).val();

       $.ajax({  
            type: 'GET',
            url: './proc/getvalue2.php', 
            data: { 
                where:'`tbl_activities`.`YEAR` = ' + selectedYear + ' AND `tbl_activities`.MONTHNO = ' + selectedMonth,
                table:'`tbl_activities`',
                field:'`tbl_activities`.`id`'
            },
            success: function(response) {
                var strarray=response.split('|');
                var selectedEncSessionID = strarray[0];
                $('#selectedEncSessionID').val(selectedEncSessionID);

            }
        });    


    });



$(document).on('click', '#btnLoadData', function(e){
    e.preventDefault();
    $('#branch').val($(this).attr('branch')); 
    $('#branch_id').val($(this).attr('branch_id')); 
}); 


$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});

</script>

