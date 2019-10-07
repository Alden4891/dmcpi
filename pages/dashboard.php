<style type="text/css">

#chart-container {
    width: 98%;
    height: 10;
}
</style>

<?php
    $prev_year = $current_year-1;
    $res_activities = mysqli_query($con,"
        SELECT 
             ID
            ,PARTICULAR
            ,date(DATE_START) as DATE_START
            ,date(DATE_END) as DATE_END
            ,ISACTIVE
        FROM tbl_activities  
        WHERE monthno > 0
        ORDER BY DATE_START DESC
        LIMIT 0,5;
    ");
    $res_toptile = mysqli_query($con,"
        SELECT 
         (SELECT COUNT(*) FROM members_account) AS registered_count
        ,(SELECT COUNT(*) FROM members_account WHERE account_status = 'Active') AS active_count
        ,(SELECT COUNT(*) FROM members_account WHERE NOT account_status = 'Active') AS inactive_count
        ,(SELECT SUM(Amt_Due) AS collection FROM installment_ledger WHERE Period_Year=$prev_year) AS prev_collection
        ,(SELECT SUM(Amt_Due) AS collection FROM installment_ledger WHERE Period_Year=$current_year) AS curr_collection"
    );

    $row_toptile=mysqli_fetch_row($res_toptile);
    $registered_count = $row_toptile[0];
    $active_count = $row_toptile[1];
    $inactive_count = $row_toptile[2];
    $prev_collection = $row_toptile[3];
    $curr_collection = $row_toptile[4];

    $active_prec = $active_count / $registered_count * 100;
    $inactive_prec = $inactive_count / $registered_count * 100;

    $increase = $curr_collection - $prev_collection;
    $variance_perc=0;
    $curr_collection_label= "";
    if ($increase>0){   //if increased 
        $variance_perc = number_format($increase / $prev_collection * 100,2);
        $curr_collection_label = "<i class='green'><i class='fa fa-sort-asc'></i>$variance_perc% </i> CY $current_year";
 
    }else{ //else if decreased
        $decrease = $prev_collection - $curr_collection;
        $variance_perc = number_format($decrease / $prev_collection * 100,2);
        $curr_collection_label = "<i class='red'><i class='fa fa-sort-desc'></i>$variance_perc% </i> CY $current_year";
    
    }
?>

    <div class="container body">
        <!-- page content -->
        <div class="" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Active Members</span>
              <div class="count"><?=number_format($active_count,0)?></div>
              <span class="count_bottom"><i class="green"><?=number_format($active_prec,0)?>% </i> of <?=number_format($registered_count,0)?> Mem.</span>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Inactive Members</span>
              <div class="count"><?=number_format($inactive_count,0)?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?=number_format($inactive_prec,0)?>% </i> of <?=number_format($registered_count,0)?> Mem.</span>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Previous Year Collection</span>
              <div class="count"><?=number_format($prev_collection,0)?></div>
              <span class="count_bottom"> CY <?=$prev_year?></span>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Current Year Collection</span>
              <div class="count"><?=number_format($curr_collection,0)?></div>
              <span class="count_bottom"><?=$curr_collection_label?></span>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Collection Performance <small>2018 vs 2019</small></h3>
                  </div>

                  <div class="col-md-6">
                    <!--div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div-->
                  </div>
                </div>


                    <div id="chart-container">
                        <canvas id="graphCanvas">
                            

                        </canvas>
                    </div>
                

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                  <h2>Schedule of Activities</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <!--ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul-->
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                 <div class="x_content">
                 
                <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Session ID</th>
                            <th class="column-title">Activities </th>
                            <th class="column-title">Date Start</th>
                            <th class="column-title">Date End</th>
                            <th class="column-title">Status </th>
                          </tr>
                        </thead>

                        <tbody>

                        <?php
                            //ID,PARTICULAR,DATE_START,DATE_END,ISACTIVE

                            $cnt = 0;
                            while ($r = mysqli_fetch_array($res_activities,MYSQLI_ASSOC)) {
                                $cnt+=1;
                                $row_class = ($cnt%2?"even pointer":"odd pointer");

                                $ID = $r["ID"];
                                $PARTICULAR = $r["PARTICULAR"];
                                $DATE_START = $r["DATE_START"];
                                $DATE_END = $r["DATE_END"];
                                $ISACTIVE = $r["ISACTIVE"];

                                $STATUS = "";
                                if ($ISACTIVE==1){
                                    $STATUS = "Current";
                                }else if ($DATE_END<$current_date) {
                                    $STATUS = "Passed";
                                }

                                echo "
                                  <tr class=\"$row_class\">
                                    <td class=\" \">$ID</td>
                                    <td class=\" \">$PARTICULAR</td>
                                    <td class=\" \">$DATE_START</td>
                                    <td class=\" \">$DATE_END</td>
                                    <td class=\" \">$STATUS</td>
                                  </tr>
                                ";

                            }

                        ?>

                          
                        </tbody>
                      </table>
                    </div>

                </div>
              </div>
            </div>
         </div>        
        </div>
        </div>
        <!-- /page content -->

      </div>
    </div>

	
    <script>
        $(document).ready(function () {

            showGraph();
            //width: 1206px; height: 603px;
          
            $('#graphCanvas').css('width', '1206px');
            $('#graphCanvas').css('height', '203px');

        });


        function showGraph()
        {
            {
                $.post("proc/dashboard_getchart_collection_perf.php",{year:2019},
                function (data)
                {
                   
                    var periods = [];
                    var amounts = [];

                    var periods2 = [];
                    var amounts2 = [];

                    for (var i in data[0]) {
                        periods.push(data[0][i].period);
                        amounts.push(data[0][i].accu_amount);
                    }
                    for (var i in data[1]) {
                        periods2.push(data[1][i].period);
                        amounts2.push(data[1][i].accu_amount);
                    }



                    //console.log(data[0]);

                    var chartdata = {
                        labels: periods,
                        options: {  
                            responsive: true,
                            maintainAspectRatio: false
                        },
                        datasets: [
                              {
                                label: '2018 Collection',
                                //backgroundColor: '#49e2ff',
                                borderColor: '#FF0000',
                                //hoverBackgroundColor: '#DBF3FA',
                                //hoverBorderColor: '#DBF3FA',
                                data: amounts
                             }, 

                             {
                                label: '2019 Collection',
                                //backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                //hoverBackgroundColor: '#DBF3FA',
                                //hoverBorderColor: '#DBF3FA',
                                data: amounts2
                            }, 


                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata
                    });
                });
            }
        }
        </script>
