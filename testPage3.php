<?php 

 $startTime =   date("Y-m-d" , strtotime("+1 day")).'T00:00:00+06:00';
 echo "<br>";
 $startTime2 = date('Y-m-d H:i:s', strtotime($startTime) + 1);
// echo $endtime;
 //$tt = strtotime($startTime , 'Y-m-d/Thh:mm:ss');
$fixed = date('Y-m-d/Th:m:s', strtotime( $startTime));
 echo  $fixed;
 echo "<br>";

 $date = "SELECT  T.ID, T.IP_ADDRESS , T.IN_OUT, T.API_STRING, T.LOCATION , 
  (SELECT  nvl (  MAX(to_char(to_date(am_time_in_out,'yyyy-mm-dd\"T\"hh24:mi:ss\"+06:00\"')++(1/24/60/60),'yyyy-mm-dd\"T\"hh24:mi:ss\"+06:00\"')), TO_CHAR (sysdate-10 , 'yyyy-mm-dd')||'T00:00:00+06:00' )    FROM  XX_ATTLOG_HIK HIK WHERE HIK.AM_MAC_ID =  T.IP_ADDRESS)    MAX_TIME
 FROM XX_ATT_API T WHERE T.STATUS = 1;";
  echo  $date;
//  $post = '{
//     "AcsEventCond": {
//         "searchID": "3166590d-cdb3-43f3-b25e-f6e98a05d359",
//         "searchResultPosition": 0,
//         "maxResults": 1000,
//         "major": 0,
//         "minor": 0,
//         "startTime": "2022-02-03T00:00:00+06:00",
//         "endTime": "2022-02-04T16:18:47+06:00",
//         "thermometryUnit":"celcius",
//         "currTemperature":1
//     }
// }';
// echo $post;
//  echo "<br>";

//   $post = '{
//     "AcsEventCond": {
//         "searchID": "3166590d-cdb3-43f3-b25e-f6e98a05d359",
//         "searchResultPosition": 0,
//         "maxResults": 1000,
//         "major": 0,
//         "minor": 0,
//         "startTime": "'.$startTime.'",
//         "endTime": "2022-02-04T16:18:47+06:00",
//         "thermometryUnit":"celcius",
//         "currTemperature":1
//     }
// }';
// echo $post;

?>
