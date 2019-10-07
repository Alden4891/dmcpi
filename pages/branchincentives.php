
            <div class="row">
                <div class="col-lg-10">
                    <h1 class="page-header">Branch Incentives</h1>
                </div>
                <div class="col-lg-2">

                </div>
            </div>





<!-- ____________________________________________________________________________________________________________________________________________________ -->


            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Total Collection</th>
                                        <th>Branch Incentive</th>
                                        <th>Code</th>
                                        <th>Branch</th>
                                        <th>Branch Manager</th>
                                        <th>COMMANDS</th>

                                    </tr>
                                </thead>
                                <tbody>

                                            <?php 
                                            
                                                $res_members_list = mysqli_query($con, '

                                                SELECT
                                                     `tbl_sharecomputation`.`PeriodNo`
                                                    , `tbl_sharecomputation`.`Year`
                                                    , `tbl_sharecomputation`.`Month`
                                                    , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `TotalCollection`
                                                    , SUM(`tbl_sharecomputation`.`BranchShareAmount`) AS `TotalBranchShare`
                                                    , `branch_details`.`Branch_Code`
                                                    , `branch_details`.`Branch_Name`
                                                    , `branch_details`.`Branch_Manager`
                                                FROM
                                                    `dmcpi1_dmcsm`.`tbl_sharecomputation`
                                                    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
                                                        ON (`tbl_sharecomputation`.`BranchID` = `branch_details`.`Branch_ID`)
                                                WHERE (`branch_details`.`mainoffice` =0)
                                                GROUP BY `tbl_sharecomputation`.`Year`, `tbl_sharecomputation`.`Month`,`tbl_sharecomputation`.`PeriodNo`;
                                                ') or die(mysqli_error());
                                                while ($r=mysqli_fetch_array($res_members_list,MYSQLI_ASSOC)) {
                                                    $Year = $r['Year']; 
                                                    $Month = $r['Month']; 
                                                    $TotalCollection = $r['TotalCollection']; 
                                                    $TotalBranchShare = $r['TotalBranchShare']; 
                                                    $Branch_Code = $r['Branch_Code']; 
                                                    $Branch_Name = $r['Branch_Name'];
                                                    $Branch_Manager = $r['Branch_Manager']; 
                                                    $PeriodNo = $r['PeriodNo'];
                                                    echo "
                                                        <tr id=sharelistdata>
                                                            <td class=\"even gradeC\"> $Year</td>
                                                            <td>$Month</td>
                                                            <td>$TotalCollection</td>
                                                            <td>$TotalBranchShare</td>
                                                            <td>$Branch_Code</td>
                                                            <td>$Branch_Name</td>
                                                            <td>$Branch_Manager</td>

                                                            <td>
                                                            

                                                                <a href=\"#\" class=\"btn btn-primary btn-circle showmodal_bmagent_share \" PeriodNo=$PeriodNo year=$Year month=$Month data-toggle=\"modal\" data-target=\"#bmagent_sharelist_modal\" id=showmodal_bmagent_share name=showmodal_bmagent_share><i class=\"fa fa-list\" ></i></a>
                                                                
                                                                <a href=\"./xls/xlsdl_periodicshare.php?year=$Year&month=$PeriodNo\" class=\"btn btn-success btn-circle \" id=download_periodic_share year=$Year month='$Month'><i class=\"fa fa-download\"  disabled></i></a>
                                                          
                                                            </td>
                                                    </tr>

                                                    ";


                                                }
                                                mysqli_free_result($res_members_list);
                                                
                                            ?>
                                </tbody>
                            </table>

                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-12 -->
            </div>

    

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });



		//CLIENT lEVEL SHARE BY AGENT/BM
        $(document).on("click","#agentbyclientsharelist",function(){
            var mmonth = $(this).attr('month');
            var yyear = $(this).attr('year'); 
            var pid =  $(this).attr('pid');           
            var pname = $(this).attr('pname');
            var ptype = $(this).attr('ptype');

            $('#showperclientsharelabel').html(ptype + ': ' + pname);
            $('#showagentscleintsharelist_modalLabel2').html('Share Computation per client - ' + mmonth + ' ' + yyear);

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
                     //prompt(response,response);
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


            $('#period_label').html('PERIOD: ' + mmonth + ' ' + yyear);

            //store temporary data for future use
            $('#bmagent_sharelist_download').attr("href", "./xls/xlsdl_periodicshare.php?year="+yyear+"&month=" + PeriodNo);

            //post
	        $.ajax({  
	            type: 'GET',
	            url: './proc/showagentshare_proc.php', 
	            data: { 
	                month: mmonth,
	                year: yyear
	            },
	            success: function(response) {
	                 //prompt(response,response);
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
			        <h4 class="modal-title" id="showagentscleintsharelist_modalLabel2">SHARE COMPUTATION PER CLIENT</h4>
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

                        <H6><font color=red><strong>CONSTANT SHARE</strong></font></H6>
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
                    <a href="#" type="button" class="btn btn-primary btn-xs"  id=agentbyclientsharelist_download >Download in excel format</a>
			        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
			      </div>
			    </div>
			  </div>
			</div>
