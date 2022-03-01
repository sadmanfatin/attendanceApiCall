<?php 
 include_once 'dbConn.php';
$attendanceLogTable = "XX_ATTLOG_HIK" ;   

 //$client = curl_init();
//the username and password of the api

function getTerminals(){
 
 global $attendanceLogTable ;

 $query ="SELECT  T.ID, T.IP_ADDRESS , T.IN_OUT, T.API_STRING, T.LOCATION , 
  (SELECT  nvl (  MAX(to_char(to_date(am_time_in_out,'yyyy-mm-dd\"T\"hh24:mi:ss\"+06:00\"')++(1/24/60/60),'yyyy-mm-dd\"T\"hh24:mi:ss\"+06:00\"')), TO_CHAR (sysdate-10 , 'yyyy-mm-dd')||'T00:00:00+06:00' )    FROM  $attendanceLogTable HIK WHERE HIK.AM_MAC_ID =  T.IP_ADDRESS)    MAX_TIME
 FROM XX_ATT_API T WHERE T.STATUS = 1";

$result = getData($query);

 oci_fetch_all($result,$terminals , null , null , OCI_FETCHSTATEMENT_BY_ROW );

 // $meterIdAray = $meterAray['METER_ID'];
 // $meterUrlArray = $meterAray['METER_URL'];
 
   return $terminals;
}

function getTerminalWithId($terminalId){

   global $attendanceLogTable ;

 $query ="SELECT  T.ID, T.IP_ADDRESS , T.IN_OUT, T.API_STRING, T.LOCATION , 
  (SELECT  nvl (  MAX(to_char(to_date(am_time_in_out,'yyyy-mm-dd\"T\"hh24:mi:ss\"+06:00\"')++(1/24/60/60),'yyyy-mm-dd\"T\"hh24:mi:ss\"+06:00\"')), TO_CHAR (sysdate-10 , 'yyyy-mm-dd')||'T00:00:00+06:00' )    FROM  $attendanceLogTable HIK WHERE HIK.AM_MAC_ID =  T.IP_ADDRESS)    MAX_TIME
 FROM XX_ATT_API T WHERE T.STATUS = 1 and T.ID = $terminalId ";

$result = getData($query);

 oci_fetch_all($result,$terminals , null , null , OCI_FETCHSTATEMENT_BY_ROW );

 // $meterIdAray = $meterAray['METER_ID'];
 // $meterUrlArray = $meterAray['METER_URL'];
 
   return $terminals;
}





function getDataFromApi ($apiUrl, $startTime, $endTime ){
         //  echo "-------------------------------------- in getDataFromApi <br>";
    $username="admin";
    $password ="hik12345";

     $body = '{
        "AcsEventCond": {
            "searchID": "3166590d-cdb3-43f3-b25e-f6e98a05d359",
            "searchResultPosition": 0,
            "maxResults": 1000,
            "major": 0,
            "minor": 0,
            "startTime": "'.$startTime.'",
            "endTime": "'.$endTime.'",
            "thermometryUnit":"celcius",
            "currTemperature":1
        }
    }';

     $client = curl_init($apiUrl);

      curl_setopt($client, CURLOPT_URL, $apiUrl);
     // curl_setopt($client, CURLOPT_HEADER, 1 );

     //Specify the username and password using the CURLOPT_USERPWD option.
     curl_setopt($client, CURLOPT_USERPWD, $username . ":" . $password); 

     curl_setopt($client, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
     curl_setopt($client, CURLOPT_POST, 1);
     curl_setopt($client, CURLOPT_POSTFIELDS, $body);

     //Tell cURL to return the output as a string instead
     //of dumping it to the browser.
     curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
     //  curl_setopt($client, CURLOPT_TIMEOUT, 15);

    curl_setopt($client, CURLOPT_CONNECTTIMEOUT, 5);  

     $response = curl_exec($client);

      curl_close($client);
       
      $respLength = strlen($response) ;      
    // echo "response :".$response ." length : ".strlen($respLength)."<br>"; 
              
    if($respLength == 0){
       return "No data";
    }

  //converts json string to array      
   $array = json_decode($response,TRUE);

  // echo "  array  <br>";
  // print_r($array);
  // echo "<br>";

  if (isset($array['AcsEvent'])) {

      $AcsEventArray = $array['AcsEvent'];

      // echo "  AcsEventArray  <br>";
      // print_r($AcsEventArray);
      //  echo "<br>";

       if (isset($AcsEventArray['InfoList'])) {

                $InfoListArray = $AcsEventArray['InfoList'];
               
                // echo "  InfoListArray  <br>";
                // print_r($InfoListArray);
                // echo "<br>";

                // only return array if $InfoListArray is set, otherwise return null
                return $InfoListArray ; 
        }
        else{ //  (isset($AcsEventArray['InfoList']))
                return "No data";   // return no data if InfoList array is not set
        }

   } 
   else{ //  if (isset($array['AcsEvent']))
      return "No data"; // return no data if AcsEvent array is not set
   }


}


function  insertApiDataIntoTable($empNo, $inOutTime, $inOutType, $ipAddress){

    $simpleTime =  date('Y-m-d H:i:s', strtotime($inOutTime));

     global $attendanceLogTable ;
    
  $query = "INSERT INTO  $attendanceLogTable (AM_EMPNO, AM_TIME_IN_OUT ,AM_TYPE_IN_OUT , AM_MAC_ID , AM_TIME_IN_OUT_SIMPLE  ) 
                   VALUES ('$empNo' ,  '$inOutTime' , '$inOutType', '$ipAddress',  TO_DATE ('$simpleTime', 'YYYY-MM-DD HH24:MI:SS') )";

           //  echo "query : ".$query."<br>";
              
          try{
             insertData($query);
          }
          catch(Exception $e){
            "exception occured whie inserting query";
          }

}


function  insertApiDataIntoTableUniquely($empNo, $inOutTime, $inOutType, $ipAddress){

    $simpleTime =  date('Y-m-d H:i:s', strtotime($inOutTime));

    global $attendanceLogTable ;
    
    $query = "INSERT INTO  $attendanceLogTable (AM_EMPNO, AM_TIME_IN_OUT ,AM_TYPE_IN_OUT , AM_MAC_ID , AM_TIME_IN_OUT_SIMPLE  )
             SELECT  '$empNo' ,  '$inOutTime' , '$inOutType', '$ipAddress',  TO_DATE ('$simpleTime', 'YYYY-MM-DD HH24:MI:SS')
             FROM DUAL WHERE NOT  EXISTS (SELECT * FROM $attendanceLogTable H  WHERE H.AM_EMPNO  =  '$empNo' AND H.AM_TIME_IN_OUT = '$inOutTime' )";

           //  echo "query : ".$query."<br>";
              
          try{
             insertData($query);
          }
          catch(Exception $e){
            "exception occured whie inserting query";
          }

}
                   
?>