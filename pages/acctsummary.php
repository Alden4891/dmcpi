
            <div class="row">
                <div class="col-lg-10">
                    <h1 class="page-header">COLLECTION SUMMARY</h1>
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
                                        <th>BRANCH</th>                                        
                                        <th>MONTH</th>
                                        <th>YEAR</th>
                                        <th>GROSS</th>
                                        <th>TOTAL INCENTIVES/COMMISSION</th>
                                        <th>NET AMOUNT</th>

                                        <th class="none">TOTAL AGENT COMMISSION : </th>
                                        <th class="none">TOTAL BM COMMISSION :</th>
                                        <th class="none">TOTAL OVERRIDING INCENTIVES FOR BM :</th>
                                        <th class="none">TOTAL OVERRIDING INCENTIVES FOR FFSO :</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $res_data = mysqli_query($con, "

                                    SELECT
                                        `branch_details`.`Branch_ID`
                                        , `branch_details`.`Branch_Name`
                                        , udf_inttomonthname(tbl_activities.MONTHNO) AS `MONTH`
                                        , tbl_activities.YEAR
                                        , SUM(`installment_ledger`.`Amt_Due`) AS GROSS
                                        , SUM(`tbl_sharecomputation`.`AgentShareAmount`) AS `AG_INC`
                                        , SUM(`tbl_sharecomputation`.`BMShareAmount`) AS `BM_INC`
                                        , SUM(`tbl_sharecomputation`.`oi_bm`) AS `BM_OI`
                                        , SUM(`tbl_sharecomputation`.`oi_ffso`) AS `AG_OI`

                                        , SUM(`tbl_sharecomputation`.`AgentShareAmount`) + 
                                          SUM(`tbl_sharecomputation`.`BMShareAmount`) +
                                          SUM(`tbl_sharecomputation`.`oi_bm`) +
                                          SUM(`tbl_sharecomputation`.`oi_ffso`) AS `TOTAL_INC`

                                        , SUM(`installment_ledger`.`Amt_Due`) - 
                                          SUM(`tbl_sharecomputation`.`AgentShareAmount`) - 
                                          SUM(`tbl_sharecomputation`.`BMShareAmount`) -
                                          SUM(`tbl_sharecomputation`.`oi_bm`) -
                                          SUM(`tbl_sharecomputation`.`oi_ffso`) AS `NET_AMOUNT`

                                        FROM
                                        `dmcpi1_dmcsm`.`installment_ledger`
                                        INNER JOIN `dmcpi1_dmcsm`.`members_account` 
                                            ON (`installment_ledger`.`Member_Code` = `members_account`.`Member_Code`)
                                        INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
                                            ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                                        LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
                                            ON (`installment_ledger`.`ORno` = `tbl_sharecomputation`.`ORno`)
                                        INNER JOIN `dmcpi1_dmcsm`.`tbl_activities`
                                            ON (`tbl_activities`.ID = `installment_ledger`.enc_session_id)
                                         
                                        WHERE NOT `installment_ledger`.`AcctDateApproved` IS NULL
                                        GROUP BY `branch_details`.`Branch_ID`, `branch_details`.`Branch_Name`,tbl_activities.YEAR,udf_inttomonthname(tbl_activities.MONTHNO)
                                        ORDER BY `installment_ledger`.`ORdate` DESC;

    ;


                                        ") or die(mysqli_error());
                                        $cnt=0;
                                        while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                            $cnt+=1;
                                            $Branch_Name = $r['Branch_Name'];
                                            $YEAR = $r['YEAR']; 
                                            $MONTH = $r['MONTH']; 
                                            $GROSS = number_format($r['GROSS'],2); 
                                            $AG_INC = number_format($r['AG_INC'],2);
                                            $BM_INC = number_format($r['BM_INC'],2);
                                            $BM_OI = number_format($r['BM_OI'],2);
                                            $AG_OI= number_format($r['AG_OI'],2);

                                            $TOTAL_INC = number_format($r['TOTAL_INC'],2);
                                            $NET_AMOUNT = number_format($r['NET_AMOUNT'],2);


                                            echo "
                                                <tr id=sharelistdata>
                                                    <td class=\"even gradeC\"> $cnt</td>
                                                    <td>$Branch_Name</td>
                                                    <td><div  >$MONTH</div></td>
                                                    <td><div  >$YEAR</div></td>
                                                    <td><div class='pull-right' >$GROSS</div></td>
                                                    <td><div class='pull-right' >$TOTAL_INC</div></td>
                                                    <td><div class='pull-right' >$NET_AMOUNT</div></td>
                                                    
                                                    <td><div class='pull-right' >$AG_INC</div></td>
                                                    <td><div class='pull-right' >$BM_INC</div></td>
                                                    <td><div class='pull-right' >$BM_OI</div></td>
                                                    <td><div class='pull-right' >$AG_OI</div></td>

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

    <!--script src="../vendor/jquery/jquery.min.js"></script-->


    <script>
    /*
    $(document).ready(function() {
        $('#datatable-buttons').DataTable({
            responsive: true
        });
    });
*/

        //DELETE SHARE
         $(document).on("click","#delete_share",function(){


            var mmonth = $(this).attr('month');
            var yyear = $(this).attr('year'); 
            var userid  = $('#user_info').attr('user_id');
            var row = $(this).closest('tr');

            if (confirm("You are about to delete Incentive computation for " + mmonth + ' ' + yyear)){

                $.ajax({  
                    type: 'GET',
                    url: './proc/delete_share_proc.php', 
                    data: { 
                        month: mmonth,
                        year: yyear,
                        userid: userid
                    },
                    success: function(response) {
                         //prompt(response,response);
                         if (response.indexOf("**success**") > -1){
                            row.fadeOut(500, function() {
                                $(this).remove();
                            });
                         }else if (response.indexOf("**failed**") > -1){
                                alert('Unable to delete this computation');
                         }
                    }
                });                                                    
            }
         });


        
		//CLIENT lEVEL SHARE BY AGENT/BM
        $(document).on("click","#agentbyclientsharelist",function(){
            
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var mmonth = $(this).attr('month');
            var yyear = $(this).attr('year'); 
            var pid =  $(this).attr('pid');           
            var pname = $(this).attr('pname');
            var ptype = $(this).attr('ptype');

            $('#showperclientsharelabel').html(ptype + ': ' + pname);
            $('#showagentscleintsharelist_modalLabel2').html('Share Computation per client - ' + months[mmonth-1] + ' ' + yyear);
            
            $.ajax({  
                type: 'GET',
                url: (ptype=='AGENT'?'./proc/showagentsharebyclient_proc.php':'./proc/showbmsharebyclient_proc.php'), 
                data: { 
                    month: mmonth,
                    year: yyear,
                    pid: pid,
                    ptype: ptype,
                },
                success: function(response) {
                     if (response.indexOf("**success**") > -1){
                        var strarray=response.split('|');
                        $('#agentclient_share_list').html('');
                        $('#agentclient_share_list').append(strarray[1]);

                        $('#agentclient_share_list2').html('');
                        $('#agentclient_share_list2').append(strarray[2]);
                     }else if (response.indexOf("**failed**") > -1){
                            alert('No record found');
                     }
                }
            });
        });


        //   PERIODIC SHARE LIST DETAIL (Agent/BM level)
        $('.showmodal_bmagent_share').on('click',function(e){
            e.preventDefault();
            var mmonth = $(this).attr('month');
			var yyear = $(this).attr('year');            
            var PeriodNo = $(this).attr('PeriodNo');
            var branch_id = $(this).attr('branch_id');

            $('#period_label').html('PERIOD: ' + mmonth + ' ' + yyear);

            //store temporary data for future use
            $('#bmagent_sharelist_download').attr("href", "./xls/xlsdl_periodicshare.php?year="+yyear+"&month=" + PeriodNo +'&branch_id='+branch_id);

            //post
	        $.ajax({  
	            type: 'GET',
	            url: './proc/showagentshare_proc.php', 
	            data: { 
                    branch_id: branch_id,
	                month: PeriodNo,
	                year: yyear
	            },
	            success: function(response) {
	                // prompt(response,response);
	                 if (response.indexOf("**success**") > -1){
                    	var strarray=response.split('|');
                    	/*
							0 - result status
							1 - html tagle row for list of shares per agent
                    	*/
                    	$('#agent_share_list').html('');
                        $('#agent_share_list').append(strarray[1]);
                        $('#bm_share_list').append(strarray[2]);
	                 }else if (response.indexOf("**failed**") > -1){
	                        alert('No record found');
	                 }
	            }
	        });

        });

    //GENERATE SHARE
    $('#generate_share').on('click', function(e) {
        e.preventDefault();
         var userid  = $('#user_info').attr('user_id');
       $.ajax({  
            type: 'GET',
            url: './proc/periodicshare_proc.php', 
            data: { 
                p_year:$('#p_year').val(),
                p_month:$('#p_month').val(),
                userid:userid
            },
            success: function(response) {
                 //prompt(response,response);

                 if (response.indexOf("**success**") > -1){
                    /*
                        0 - result status
                        1 - total bm share
                        2 - total agent share
                        3 - total number of bm and agent
                        4 - total number of client paid for the specified period
                        5 - html table rows for detail section
                    */

                    var strarray=response.split('|');
                    //alert(strarray[5]);
                    $('#share_gen_details').html('');
                    $('#share_gen_details').append(strarray[5]);
                    $('#tot_bm_share').html(strarray[1]);
                    $('#tot_agent_share').html(strarray[2]);
                    $('#tot_bm_agent_count').html(strarray[3]);
                    $('#tot_payment').html(strarray[4]);
                    alert("Success! Press 'F5' key to update the result list");
                    
                    //window.location = "index.php?page=periodicshare"; 

                 }else if (response.indexOf("**failed**") > -1){
                    $('#share_gen_details').html('');
                    $('#tot_bm_share').html('');
                    $('#tot_agent_share').html('');
                    $('#tot_bm_agent_count').html('');
                    $('#tot_payment').html('');                        
                    alert('Record not found!');
                 }
            }
        });


    });


    </script>


<!-- ____________________________________________________________________________________________________________________________________________________ -->


         <!-- showmodal_bmagent_share modal -->
            <div class="modal fade bmagent_sharelist_modal" id="bmagent_sharelist_modal" name=bmagent_sharelist_modal tabindex="-1" role="dialog" aria-labelledby="bmagent_sharelist_modal_label">
              <div class="modal-dialog" role="document" style="width:1100px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="bmagent_sharelist_modal_label">LIST OF SHARES PER AGENT</h3>
                  </div>
                  <div class="modal-body" id=bmagent_sharelist_modal_body>
		            <div class="row">
		                <div class="col-lg-12">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            <div id=period_label ></div>
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">



                              <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#menu_agent">AGENTS</a></li>
                                <li><a data-toggle="tab" href="#menu_bm">BRANCH MANAGERS</a></li>
                              </ul>

                              <div class="tab-content">
                                <div id="menu_agent" class="tab-pane fade in active">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>AGENT INITIALS</th>
                                                <th>AGENT</th>
                                                <th>NUMBER OF CLIENT</th>
                                                <th>BASE AMOUNT</th>
                                                <th>SHARE</th>
                                                <th>OPTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id=agent_share_list>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="menu_bm" class="tab-pane fade">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                        <thead>
                                            <tr>
                                                <th>BRANCH MANAGER</th>
                                                <th>NUMBER OF CLIENT</th>
                                                <th>BASE AMOUNT</th>
                                                <th>SHARE</th>
                                                <th>OPTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id=bm_share_list>
                                        </tbody>
                                    </table>

                                </div>
                              </div>
		                        </div>    
		                    </div>
		                </div>
		            </div>
                  </div>
                  <div class="modal-footer">
                     <a href="" type="button" class="btn btn-primary btn-xs"  id=bmagent_sharelist_download >Download in excel format</a>
                    <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
                  </div>
                </div>
              </div>
            </div>
            <!-- //showmodal_bmagent_share modal-->     


<!-- ____________________________________________________________________________________________________________________________________________________ -->
			<div class="modal fade showagentscleintsharelist_modal" id="showagentscleintsharelist_modal" tabindex="-1" role="dialog" aria-labelledby="showagentscleintsharelist_modalLabel2">
			  <div class="modal-dialog" role="document" style="width:1200px;top: 70px;">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="showagentscleintsharelist_modalLabel2">INCENTIVES COMPUTATION PER CLIENT</h4>
			      </div>
			      <div class="modal-body" >
			      <H4>
			      	<div id=showperclientsharelabel></div>
			      </H4><BR>

                        <H6><font color=red><strong>COMPUTATION BASED ON PERCENTAGE</strong></font></H6>
	                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	                        <thead>
	                            <tr>
	                                <th>CODE</th>
	                                <th>CLIENT</th>
	                                <th>AMOUNT PAID</th>
	                                <th>SHARE RATE</th>
	                                <th>SHARE</th>
	                            </tr>
	                        </thead>
	                        <tbody id=agentclient_share_list>
	                        </tbody>
	                    </table>	
                        <br>

                        <H6><font color=red><strong>FIX COMPUTATION</strong></font></H6>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>CODE</th>
                                    <th>CLIENT</th>
                                    <th>AMOUNT PAID</th>
                                    <th>SHARE</th>
                                </tr>
                            </thead>
                            <tbody id=agentclient_share_list2>
                            </tbody>
                        </table>                            


			      </div>
			      <div class="modal-footer">
                    <!--a href="#" type="button" class="btn btn-primary btn-xs"  id=agentbyclientsharelist_download >Download in excel format</a-->
			        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
			      </div>
			    </div>
			  </div>
			</div>
