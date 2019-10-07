
            <div class="row">
                <div class="col-lg-10">
                    <h1 class="page-header">Periodic Commision  and Incentive Reports</h1>
                </div>
                <div class="col-lg-2">
                   <BR><BR>
                   <span class=" pull-right">
                   <!--a href="#" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#share_generation_modal"><i class="fa fa-plus" ></i> New</a-->
                   </span>
                </div>
            </div>




<!-- ____________________________________________________________________________________________________________________________________________________ -->

            <!-- generate share ENCODING Modal -->
            <div class="modal fade" id="share_generation_modal" tabindex="-1" role="dialog" aria-labelledby="share_generation_modal_label">
              <div class="modal-dialog" role="document" style="width:1200px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="share_generation_modal_label">PERIODIC INCENTIVES CALCULATOR</h4>
                  </div>
                  <div class="modal-body">
                       <div class="row">
	                        <div class="col-sm-5">
	                            <h4>Criteria:</h4>
	                            <div class="panel panel-default">
	                                <div class="panel-body form-horizontal share-form">
	                                <div class="form-group">
	                                    <label for="p_year" class="col-sm-3 control-label">Year</label>
	                                    <div class="col-sm-9">
	                                        <select class="form-control" id="p_year" name="p_year">
                                           
                                            <?php 
                                                for ($i=2017; $i <= date("Y")+5; $i++) { 
                                                    if (date("Y") == $i) {
                                                        echo "<option value=\"$i\" selected>$i</option>";
                                                    } else {
                                                        echo "<option value=\"$i\">$i</option>";
                                                    }
                                                    
                                                }
                                            ?>

	                                        </select>   
	                                    </div>
	                                </div>
	                                    <div class="form-group">
	                                        <label for="p_month" class="col-sm-3 control-label">Month</label>
	                                        <div class="col-sm-9">
	                                            <select class="form-control" id="p_month" name="p_month">
	                                            <option value="1">Jan</option>
	                                            <option value="2">Feb</option>
	                                            <option value="3">Mar</option>
	                                            <option value="4">Apr</option>
	                                            <option value="5">May</option>
	                                            <option value="6">Jun</option>
	                                            <option value="7">Jul</option>
	                                            <option value="8">Aug</option>
	                                            <option value="9">Sep</option>
	                                            <option value="10">Oct</option>
	                                            <option value="11">Nov</option>
	                                            <option value="12">Dec</option>
	                                        </select>   
	                                    	</div> 
	                                	</div> 
	                        
	                                <div class="form-group">
	                                    <div class="col-sm-12 text-right">
	                                        <button type="button" class="btn btn-default preview-add-button" id=generate_share>
	                                            <span class="glyphicon glyphicon-plus"></span> Generate
	                                        </button>
	                                    </div>
	                                </div>
	                                </div>
	                            </div>
	                        </div> <!-- / panel criteria -->




	                        <div class="col-sm-7">
	                            <h4>Summary:</h4>
	                            <div class="panel panel-default" style="height: 178px;">
	                                <div class="panel-body form-horizontal share-form">

	                                    <table class="table table-condensed">
	                                    <thead>
	                                      <tr>
	                                        <th>Particular</th>
	                                        <th>Value</th>
	                                      </tr>
	                                    </thead>
	                                    <tbody>
	                                      <tr>
	                                        <td>BM Incentive</td><td id=tot_bm_share>0</td>
	                                      </tr>
	                                      <tr>
	                                        <td>Agent Incentive</td><td  id=tot_agent_share>0</td>
	                                      </tr>
                                          <tr>
                                            <td>Total Collection</td><td  id=tot_payment>0</td>
                                          </tr>
	                                      <tr>
	                                        <td>BM/Agent Count</td><td  id=tot_bm_agent_count>0</td>
	                                      </tr>

	                                    </tbody>
	                                    </table>
	                                    

	                                </div>
	                            </div>
	                        </div> <!-- / panel summary -->



                        </div>
                        <div class="row">
                        <div class="col-sm-12">


                            
                            <form name=frmshare id=frmshare class="frmshare">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel panel-default">
                                          <div class="panel-heading"><h4>Details:</h4></div>

                                          <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table details-table">
                                                    <thead>
                                                        <tr>

                                                            <th>NAME</th>
                                                            <th>POSITION</th>
                                                            <th>Collection</th>
                                                            <th>Incentives</th>
                                                            <th>Month</th>
                                                            <th>Year</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id=share_gen_details>
                                                 
                                                        

                                                    </tbody> 
                                                </table>
                                            </div> 

                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </form>  
                        </div>
                        </div>
                         <!-- /generate share modal content here . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . -->


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--button type="button" class="btn btn-primary">POST</button-->
                  </div>
                </div>
              </div>
            </div>
            <!-- //generate share ENCODING Modal -->


<!-- ____________________________________________________________________________________________________________________________________________________ -->


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

                                        <th>BRANCH</th>
                                        <th>No. of Member</th>                                        
                                        <th>GROSS</th>
                                        <th>BRANCH SHARE</th>
                                        <th>AGENT COM.</th>
                                        <th>NET AMOUNT</th>
                                        <th>YEAR</th>
                                        <th>Month</th>
                                        <th>COMMANDS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $res_data = mysqli_query($con, "


                                        SELECT
                                             sc.`BranchID` AS `Branch_ID`
                                            ,sc.`Branch_Name`
                                            ,  (
                                                    SELECT COUNT(*) FROM v_member_year_month 
                                                    WHERE OR_YEAR = YEAR(sc.`ORdate` ) 
                                                    AND OR_MONTH=MONTH(sc.`ORdate`)
                                                    AND BRANCH_ID = sc.`BranchID`
                                                ) AS Member_Count
                                            , SUM(sc.`Amount_Paid`) AS `Gross`
                                            , SUM(sc.`BMShareAmount` + sc.`oi_bm`) AS `Branch Share`
                                            , SUM(sc.`AgentShareAmount` + sc.`oi_ffso`) AS `Agent Com`
                                            , SUM(sc.`Amount_Paid`) - SUM(sc.`BMShareAmount`+sc.`oi_bm`) - SUM(sc.`AgentShareAmount`+sc.`oi_ffso`) AS 'Net Amount'
                                            , YEAR(sc.`ORdate` ) AS `OR_YEAR`
                                            , MONTHNAME(sc.`ORdate` ) AS `OR_MONTH`
                                            , YEAR(sc.`ORdate` ) + MONTH(sc.`ORdate` )  AS 'UID'
                                            , MONTH(sc.`ORdate`) AS `PeriodNo`
                                        FROM
                                            `dmcpi1_dmcsm`.`v_sharecomputation` sc
                                        GROUP BY sc.`Branch_Name`, sc.`BranchID`,OR_YEAR,OR_MONTH
                                        ORDER BY  UID DESC
                                        ;


                                        ") or die(mysqli_error());
                                        while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {

                                            $Branch_ID = $r['Branch_ID'];
                                            $BRANCH = $r['Branch_Name']; 
                                            $Member_Count = $r['Member_Count']; 
                                            $GROSS = number_format($r['Gross'],2);
                                            $BRANCH_SHARE = number_format($r['Branch Share'],2);
                                            $AGENT_COM = number_format($r['Agent Com'],2);
                                            $NET_AMOUNT = number_format($r['Net Amount'],2);
                                            $YEAR = $r['OR_YEAR'];
                                            $MONTH= $r['OR_MONTH'];
                                            $PeriodNo = $r['PeriodNo'];


                                            echo "
                                                <tr id=sharelistdata>
                                                    <td class=\"even gradeC\"> $BRANCH</td>
                                                    <td>$Member_Count</td>
                                                    <td><div class='pull-right' >$GROSS</div></td>
                                                    <td><div class='pull-right' >$BRANCH_SHARE</div></td>
                                                    <td><div class='pull-right' >$AGENT_COM</div></td>
                                                    <td><div class='pull-right' >$NET_AMOUNT</div></td>
                                                    <td><center>$YEAR</center></td>
                                                    <td>$MONTH</td>

                                                    <td>
                                                    

                                                        <a href=\"#\" class=\"btn btn-xs btn-primary btn-circle showmodal_bmagent_share\" 
                                                            PeriodNo=$PeriodNo 
                                                            year=$YEAR 
                                                            month=$MONTH 
                                                            branch_id=$Branch_ID
                                                            data-toggle=\"modal\" 
                                                            data-target=\"#bmagent_sharelist_modal\" 
                                                            id=showmodal_bmagent_share name=showmodal_bmagent_share><i class=\"fa fa-list\"></i></a>
                                                              
                                                            <!--a href=\"#\" class=\"btn btn-xs btn-danger btn-circle\" 
                                                            id=delete_share 
                                                            branch_id=$Branch_ID
                                                            year=$YEAR 
                                                            month='$MONTH'
                                                            ><i class=\"glyphicon glyphicon-remove\"></i></a-->


                                                        <a href=\"./xls/xlsdl_periodicshare.php?year=$YEAR&month=$PeriodNo&branch_id=$Branch_ID\" class=\"btn btn-xs btn-success btn-circle\" 
                                                        id=download_periodic_share 
                                                        year=$YEAR 
                                                        month='$MONTH'
                                                        branch_id=$Branch_ID
                                                        ><i class=\"fa fa-download\"></i></a>
                                                  
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

    <!--script src="../vendor/jquery/jquery.min.js"></script-->


    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $('#dataTables-example2').DataTable({
            responsive: true
        });


    });


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
            $('#showagentscleintsharelist_modalLabel2').html('INCENTIVES COMPUTATION PER MEMBER - ' + months[mmonth-1] + ' ' + yyear);
            
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
                    console.log(response)

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
	                 //prompt("res: ",response);
                     console.log(response);
	                 if (response.indexOf("**success**") > -1){
                    	var strarray=response.split('|');
                    	/*
							0 - result status
							1 - html tagle row for list of shares per agent
                            2 - html tagle row for list of shares per branch
                            3 - html tagle row for list of oi per agent
                            4 - html tagle row for list of oi per bm
                    	*/
                    	$('#agent_share_list').html('');
                        $('#bm_share_list').html('');
                        $('#agent_oi_list').html('');
                        $('#bm_oi_list').html('');

                        $('#agent_share_list').append(strarray[1]);
                        $('#bm_share_list').append(strarray[2]);
                        $('#agent_oi_list').append(strarray[3]);
                        $('#bm_oi_list').append(strarray[4]);

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
                    <h3 class="modal-title" id="bmagent_sharelist_modal_label">INCENTIVE EXPLORER</h3>
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
                              <br>
                                <div id="menu_agent" class="tab-pane fade in active">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>AGENT INITIALS</th>
                                                <th>AGENT</th>
                                                <th>NUMBER OF CLIENT</th>
                                                <th>GROSS</th>
                                                <th>AGENT COM.</th>
                                                <th>OPTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id=agent_share_list>
                                        </tbody>
                                    </table>

                                    Overriding Incentives                                    
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example"
                                    >
                                        <thead>
                                            <tr>
                                                <th>AGENT INITIALS</th>
                                                <th>AGENT</th>
                                                <th>GROSS</th>
                                                <th>OVERIDING INC.</th>
                                                <th>OPTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id=agent_oi_list>
                                        </tbody>
                                    </table>



                                </div>
                                <div id="menu_bm" class="tab-pane fade">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                        <thead>
                                            <tr>
                                                <th>BRANCH MANAGER</th>
                                                <th>NUMBER OF CLIENT</th>
                                                <th>GROSS</th>
                                                <th>BM INCE</th>
                                                <th>OPTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id=bm_share_list>
                                        </tbody>
                                    </table>


                                    Overriding Incentives
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                        <thead>
                                            <tr>
                                                <th>BRANCH MANAGER</th>
                                                <th>GROSS</th>
                                                <th>OVERIDING INC.</th>
                                                <th>OPTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody id=bm_oi_list>
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
	                                <th>MEMBER</th>
                                    <th>PLAN</th>
	                                <th>AMOUNT PAID</th>
	                                <th>INC. RATE</th>
                                    <th>INCENTIVE</th>
                                    <!--th>OVERRIDING INC.</th-->
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
                                    <th>MEMBER</th>
                                    <th>PLAN</th>
                                    <th>AMOUNT PAID</th>
                                    <th>INCENTIVE</th>
                                    <!--th>OVERRIDING INC.</th-->
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
