<?php

$cur_year = isset($_REQUEST['year'])?$_REQUEST['year']:'2019';
$pre_year = $cur_year - 1;

header('Content-Type: application/json');

$conn = mysqli_connect("mysql1005.mochahost.com","dmcpi1_root","pass@word1","dmcpi1_dmcsm") or die ('error!');

$sqlQuery1 = "

SELECT 
 i.Period_No 
,CONCAT(i.Period_Covered) AS period
,SUM(i.Amt_Due) AS amount 
,(

SELECT 
SUM(Amt_Due) AS amount 
FROM installment_ledger 
WHERE Installment_No > 0 AND Period_Year = $pre_year AND Period_No BETWEEN 1 AND i.Period_No
GROUP BY Period_Year

) AS accu_amount 
FROM installment_ledger i
WHERE i.Installment_No > 0 AND i.Period_Year = $pre_year
GROUP BY i.Period_No, i.Period_Year
ORDER BY i.Period_Year, i.Period_No;



";

$sqlQuery2 = "

SELECT 
 i.Period_No 
,CONCAT(i.Period_Covered) AS period
,SUM(i.Amt_Due) AS amount 
,(

SELECT 
SUM(Amt_Due) AS amount 
FROM installment_ledger 
WHERE Installment_No > 0 AND Period_Year = $cur_year AND Period_No BETWEEN 1 AND i.Period_No
GROUP BY Period_Year

) AS accu_amount 
FROM installment_ledger i
WHERE i.Installment_No > 0 AND i.Period_Year = $cur_year
GROUP BY i.Period_No, i.Period_Year
ORDER BY i.Period_Year, i.Period_No;


";
$result1 = mysqli_query($conn,$sqlQuery1);
$result2 = mysqli_query($conn,$sqlQuery2);

$data1 = array();
foreach ($result1 as $row) {
	$data1[] = $row;
	

	
}

$data2 = array();
foreach ($result2 as $row) {
	$data2[] = $row;
	
}

mysqli_close($conn);

//echo json_encode($data1);
//echo json_encode($data2);

$data1=json_encode($data1);
$data2=json_encode($data2);

$data[] = json_decode($data1,true);
$data[] = json_decode($data2,true);


$json_merge = json_encode($data);

echo $json_merge;

?>