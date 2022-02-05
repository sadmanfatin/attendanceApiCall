<?php 
 set_time_limit(298);
include 'dbConn.php';
include 'common.php';


 $apiUrl="http://192.168.1.64/ISAPI/AccessControl/AcsEvent?format=json";
$username = "admin";
$password = "hik12345";
date_default_timezone_set("Asia/Dhaka");

 $current_date = date("Y-m-dH:i" ) ;


 $post = '{
    "AcsEventCond": {
        "searchID": "3166590d-cdb3-43f3-b25e-f6e98a05d359",
        "searchResultPosition": 0,
        "maxResults": 1000,
        "major": 0,
        "minor": 0,
        "startTime": "2022-02-03T00:00:00+06:00",
        "endTime": "2022-02-04T16:18:47+06:00",
        "thermometryUnit":"celcius",
        "currTemperature":1
    }
}';

// echo  $post; 
// $data = json_decode($post);
// print_r($data) ; 

   $client = curl_init($apiUrl);

   

    curl_setopt($client, CURLOPT_URL, $apiUrl);
   // curl_setopt($client, CURLOPT_HEADER, 1 );

            // //Specify the username and password using the CURLOPT_USERPWD option.
      curl_setopt($client, CURLOPT_USERPWD, $username . ":" . $password);       
      curl_setopt($client, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($client, CURLOPT_POST, 1);
         
         curl_setopt($client, CURLOPT_POSTFIELDS, $post);


      // //Tell cURL to return the output as a string instead
      // //of dumping it to the browser.
       curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
          //  curl_setopt($client, CURLOPT_TIMEOUT, 15);
       

        $response = curl_exec($client);
               
      
      //  echo "response :".$response ." length : ".strlen($response)."<br>"; 
        

       
 curl_close($client);
         
        
     // if($response == null){

     // echo "response is null <br>"; 
     // $response  = "NUll";
     //   return  $response ;
     // }
     // else if ($response == "Access denied"){
     //  echo "response is Access Denied <br>";
     //   $response  = "Access denied";
     //   return  $response ;
    
     //  }
     // else if ($response == ""){
     //  echo "response is No data <br>";
     //   $response  = "No data";
     //   return  $response ;
    

     //  }


       
      $array = json_decode($response,TRUE);

 //echo "</br>";
//print_r($array);
// echo "<br>";

  if (isset($array['AcsEvent'])) {

      // print_r($array);
      //  echo "<br>";

    //  $successCount++;
      // echo "Success Count :" . $successCount . "<br>";

      $AcsEventArray = $array['AcsEvent'];

      // echo "--------------  row";
      // echo "<br>";
      // print_r($row);
          $InfoListArray = $AcsEventArray['InfoList'];

           print_r( $InfoListArray);

      // if (isset($AcsEvent['Timestamp'])) {
      //    // if row has no array, it itself an associative array of Timestamp, value ,seq
      //    // echo "in (isset (row['Timestamp'] )";
      //    //echo "<br>";

      //    $InfoList = $row['InfoList'];
      //    $value = $row['Value'];
      //    $sequence = $row['Seq'];
      //    $status = "";
      //    // echo $date . "<br>";
      //    // echo $Timestamp;
      //    //  $delayMinutes =  date_diff(  strtotime($date) ,$Timestamp)    ;
      //    $delayMinutes = $delay;

      //    if ($Timestamp > date('yy-m-d H:i:s', strtotime($date))) {
      //       // if ($sequence > $lastSeqNo) {
      //       // echo $sequence;
      //     //  insertApiDataIntoTrendLogTable($meterId, $Timestamp, $value, $sequence, $delayMinutes, $status);
      //    }
      // } else if (!isset($row['Timestamp'])) {

      //    // echo " in ( !!! isset (row['Timestamp'] )" . "<br>";
      //    //  $row contains array of multiple Timestamp, value , sequence

         foreach ($InfoListArray as $InfoList) {
     // echo "<\br>";
            $time = $InfoList['time'];
            $serial = $InfoList['serialNo'];
            $verification = $InfoList['currentVerifyMode'];
              $employeeNo = $year = isset($InfoList['employeeNoString']) ? $InfoList['employeeNoString'] : null;   
            //  $delayMinutes = date_diff( strtotime($date),$Timestamp);
             
echo "time: ".$time."  serial: ".$serial." verification : ".$verification." employee no : ".$employeeNo."\n";
//echo "</br>";  
            // echo $date . '-' . "<br>";
            // echo $Timestamp . "<br>";

            // if (date('yy-m-d H:i:s', strtotime($Timestamp)) > date('yy-m-d H:i:s', strtotime($date))) {
            //    // if ($sequence > $lastSeqNo) {
            //    // echo $sequence;

            //  //  insertApiDataIntoTrendLogTable($meterId, $Timestamp, $value, $sequence, $delayMinutes, $status);
            // }
            // //   echo "time : ".$Timestamp."Value : ".$value." Sequence : ".$sequence."<br>";

         }
      // }
      // echo "==========================================================================================================================="."<br>" ;         

   } 


oci_close($dbConn);

?>