
            <div class="row">
                <div class="col-lg-10">
                    <h1 class="page-header">Periodic Shares</h1>
                </div>
                <div class="col-lg-2">
                   <BR><BR>
                   <span class=" pull-right">
                   <a href="#" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#share_generation_modal"><i class="fa fa-plus" ></i> Generate Share</a>
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
                    <h4 class="modal-title" id="share_generation_modal_label">SHARE GENERATOR</h4>
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
	                                            <option value="2013" selected>2013</option>
	                                            <option value="2014">2014</option>
	                                            <option value="2015">2015</option>
	                                            <option value="2016">2016</option>
	                                            <option value="2017">2017</option>
	                                            <option value="2018">2018</option>
	                                            <option value="2019">2019</option>
	                                            <option value="2020">2020</option>
	                                            <option value="2021">2021</option>
	                                            <option value="2022">2022</option>
	                                            <option value="2023">2023</option>
	                                            <option value="2024">2024</option>
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
	                                        <td>BM Share</td><td id=tot_bm_share>12,000</td>
	                                      </tr>
	                                      <tr>
	                                        <td>Agent Share</td><td  id=tot_agent_share>18,000</td>
	                                      </tr>
	                                      <tr>
	                                        <td>BM/Agent Count</td><td  id=tot_bm_agent_count>18</td>
	                                      </tr>
	                                      <tr>
	                                        <td>Client Count</td><td  id=tot_clients>18</td>
	                                      </tr>

	                                    </tbody>
	                                    </table>
	                                    

	                                </div>
	                            </div>
	                        </div> <!-- / panel summary -->



                        </div>
                        <div class="row">
                        <div class="col-sm-12">


                            <h4>Details:</h4>
                            <form name=frmshare id=frmshare class="frmshare">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table details-table">
                                                <thead>
                                                    <tr>

                                                        <th>Agent</th>
                                                        <th>BM Share</th>
                                                        <th>Agent Share</th>
                                                        <th>Total Share</th>
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>BM SHARES</th>
                                        <th>AGENT SHARES</th>
                                        <th>TOTAL</th>
                                        <th>AGENT COUNT</th>
                                        <th>CLIENT COUNT</th>
                                        <th>COMMANDS</th>

                                    </tr>
                                </thead>
                                <tbody>

                                            <?php 
                                            
                                                $res_members_list = mysql_query('SELECT * FROM vperiodicsharelist order by year desc, PeriodNo desc') or die(mysql_error());
                                                while ($r=mysql_fetch_array($res_members_list,MYSQL_ASSOC)) {
                                                    $Year = $r['Year']; 
                                                    $Month = $r['Month']; 
                                                    $BM_SHARES = $r['BM SHARES']; 
                                                    $AGENT_SHARES = $r['AGENT SHARES']; 
                                                    $TOTAL = $r['TOTAL']; 
                                                    $AGENT_COUNT = $r['AGENT_COUNT'];
                                                    $CLIENT_COUNT = $r['CLIENT_COUNT']; 
                                                    echo "
                                                        <tr>
                                                            <td class=\"even gradeC\"> $Year</td>
                                                            <td>$Month</td>
                                                            <td>$BM_SHARES</td>
                                                            <td>$AGENT_SHARES</td>
                                                            <td>$TOTAL</td>
                                                            <td>$AGENT_COUNT</td>
                                                            <td>$CLIENT_COUNT</td>

                                                            <td>
                                                                <!--a href=\"#\" class=\"btn btn-success btn-circle\"><i class=\"fa fa-money\"></i></a-->
                                                                <a href=\"#\" class=\"btn btn-primary btn-circle showmodal_bmagent_share\" year=$Year month=$Month data-toggle=\"modal\" data-target=\"#bmagent_sharelist_modal\" id=showmodal_bmagent_share name=showmodal_bmagent_share><i class=\"fa fa-list\"></i></a>
                                                                <a href=\"#\" class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-remove\"></i></a>
                                                           
                                                            </td>
                                                    </tr>

                                                    ";


                                                }
                                                mysql_free_result($res_members_list);
                                                
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


       


    <script src="../vendor/jquery/jquery.min.js"></script>



    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });




		//   CLEINT SHARE 


        $('.agentbyclientsharelist').on('click',function(e){
            e.preventDefault();
            alert(1);
            
        });





/*

            var mmonth = $(this).attr('month');
			var yyear = $(this).attr('year'); 
			var agentid =  $(this).attr('agentid');           
			var agentname = $(this).attr('agentname');

            $('#showperclientsharelabel').html('PERIOD: ' + mmonth + ' ' + yyear + ' - ' + $agentname);

	        $.ajax({  
	            type: 'GET',
	            url: './proc/showagentsharebyclient_proc.php', 
	            data: { 
	                month: mmonth,
	                year: yyear
	            },
	            success: function(response) {
	                 

	                 prompt(response,response);
	                 if (response.indexOf("**success**") > -1){
                    	var strarray=response.split('|');
                    	$('#agentclient_share_list').html('');
                    	//$('#agentclient_share_list').append(strarray[1]);

	                 }else if (response.indexOf("**failed**") > -1){
	                        alert('No record found');
	                 }



	            }
	        });
*/


        //   PERIODIC SHARE LIST DETAIL
        $('.showmodal_bmagent_share').on('click',function(e){
            e.preventDefault();
            var mmonth = $(this).attr('month');
			var yyear = $(this).attr('year');            


            $('#period_label').html('PERIOD: ' + mmonth + ' ' + yyear);

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

	                 }else if (response.indexOf("**failed**") > -1){
	                        alert('No record found');
	                 }



	            }
	        });

        });

    //GENERATE SHARE
    $('#generate_share').on('click', function(e) {
        e.preventDefault();
       $.ajax({  
            type: 'GET',
            url: './proc/sharelist_proc.php', 
            data: { 
                p_year:$('#p_year').val(),
                p_month:$('#p_month').val()
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
                    $('#tot_clients').html(strarray[4]);


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
		                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                                <thead>
		                                    <tr>
		                                        <th>AGENT</th>
		                                        <th>AMOUNT PAID</th>
		                                        <th>BM SHARES</th>
		                                        <th>AGENT SHARES</th>
		                                        <th>TOTAL SHARE</th>
		                                        <th>COUNT OF CLIENT</th>
		                                        <th>OPTIONS</th>

		                                    </tr>
		                                </thead>
		                                <tbody id=agent_share_list>


		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                </div>
		            </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- //showmodal_bmagent_share modal-->     


<!-- ____________________________________________________________________________________________________________________________________________________ -->



			<div class="modal fade showagentscleintsharelist_modal" id="showagentscleintsharelist_modal" tabindex="-1" role="dialog" aria-labelledby="showagentscleintsharelist_modalLabel2">
			  <div class="modal-dialog" role="document" style="width:1200px;">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="showagentscleintsharelist_modalLabel2">SHARE COMPUTATION PER CLIENT</h4>
			      </div>
			      <div class="modal-body" >
			      <H2>
			      	<div id=showperclientsharelabel></div>
			      </H2><BR>
	                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	                        <thead>
	                            <tr>
	                                <th>Member Code</th>
	                                <th>Client's Name</th>
	                                <th>Paid</th>
	                                <th>BM SHARE RATE</th>
	                                <th>AGENT SHARE RATE</th>
	                                <th>MODE OF COMPUTATION</th>
	                                <th>BM SHARE</th>
	                                <th>AGENT SHARE</th>
	                                <th>TOTAL</th>
	                            </tr>
	                        </thead>
	                        <tbody id=agentclient_share_list>


	                        </tbody>
	                    </table>			        
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
