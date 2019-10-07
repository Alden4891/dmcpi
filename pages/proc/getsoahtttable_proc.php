<?php
    include '../dbconnect.php';
    $Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'0');
    $res_soa = mysqli_query($con, "call sp_soa('$Member_Code','DESC');") or die(mysqli_error());
    echo "
    <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-mcpr\">
        <thead>
            <tr>
                <th>AMOUNT DUE</th>
                <th>OVERDUE</th>
                <th>INS #</th>
                <th>O.R. DATE</th>
                <th>O.R. #</th>
                <th>AMOUNT</th>
                <th>REMARKS</th>
                <th>REPORT DATE</th>
            </tr>
        </thead>
        <tbody>
    ";
    while($r=mysqli_fetch_array($res_soa,MYSQLI_ASSOC)){
        $Amt_Due= $r['Amt_Due'];  
        $Over_Due = $r['Over_Due'];  
        $Installment_No= $r['Installment_No'];  
        $ORdate= $r['OrDate'];  
        $ORno= $r['OrNo'];  
        $Rec_Amt= $r['Rec_Amt'];  
        $Remarks= $r['Remarks'];  
        $report_period= $r['report_period'];  


        //even gradeC or even gradeX
        echo "
            <tr class=\"odd gradeX\">

                <td>$Amt_Due</td>
                <td>$Over_Due</td>                                                            
                <td>$Installment_No</td>
                <td>$ORdate</td>

                <td>$ORno</td>
                <td>$Rec_Amt</td>
                <td>$Remarks</td>
                <td class=\"center\">$report_period</td>

            </tr>
        ";
    }
                                              
    mysqli_free_result($res_soa);

echo "
    </tbody>
    </table>
";

include '../dbclose.php';
?>