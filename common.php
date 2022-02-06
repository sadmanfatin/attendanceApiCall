<?php 

 include_once 'dbConn.php';

//the username and password of the api

function getTerminals(){

$query = "SELECT  T.ID, T.IP_ADDRESS , T.IN_OUT, T.API_STRING, T.LOCATION , 
  (SELECT  nvl (  MAX(AM_TIME_IN_OUT), TO_CHAR (sysdate-3 , 'yyyy-mm-dd')||'T00:00:00+06:00' )    FROM  XX_ATTLOG_HIK HIK WHERE HIK.AM_MAC_ID =  T.IP_ADDRESS)    MAX_TIME
 FROM XX_ATT_API T WHERE T.STATUS = 1" ;

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
         
     $response = curl_exec($client);

      curl_close($client);

    //================================================================================
//   $response = '{

//     "AcsEvent": {

//         "searchID": "3166590d-cdb3-43f3-b25e-f6e98a05d359",

//         "totalMatches": 101,

//         "responseStatusStrg": "MORE",

//         "numOfMatches": 30,

//         "InfoList": [

//             {

//                 "major": 2,

//                 "minor": 1024,

//                 "time": "2022-02-03T14:46:02+06:00",

//                 "type": 0,

//                 "serialNo": 1,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T14:46:02+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 2,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 2,

//                 "minor": 39,

//                 "time": "2022-02-03T14:46:04+06:00",

//                 "type": 0,

//                 "serialNo": 3,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 76,

//                 "time": "2022-02-03T14:49:15+06:00",

//                 "cardType": 1,

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 4,

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_144915_30076_0.jpeg@WEB000000000061",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 38,

//                 "time": "2022-02-03T14:49:19+06:00",

//                 "cardType": 1,

//                 "name": "MASUDUL ISLAM JONY",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "32083",

//                 "type": 0,

//                 "serialNo": 5,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp"

//             },

//             {

//                 "major": 5,

//                 "minor": 21,

//                 "time": "2022-02-03T14:49:19+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 6,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 76,

//                 "time": "2022-02-03T14:49:19+06:00",

//                 "cardType": 1,

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 7,

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_144919_30076_0.jpeg@WEB000000000062",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 38,

//                 "time": "2022-02-03T14:49:21+06:00",

//                 "cardType": 1,

//                 "name": "MASUDUL ISLAM JONY",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "32083",

//                 "type": 0,

//                 "serialNo": 8,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp"

//             },

//             {

//                 "major": 5,

//                 "minor": 76,

//                 "time": "2022-02-03T14:49:23+06:00",

//                 "cardType": 1,

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 9,

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_144923_30076_0.jpeg@WEB000000000063",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T14:49:26+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 10,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 3,

//                 "minor": 80,

//                 "time": "2022-02-03T14:49:32+06:00",

//                 "type": 0,

//                 "serialNo": 11,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 2,

//                 "minor": 1024,

//                 "time": "2022-02-03T14:51:02+06:00",

//                 "type": 0,

//                 "serialNo": 12,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T14:51:03+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 13,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 2,

//                 "minor": 39,

//                 "time": "2022-02-03T14:51:04+06:00",

//                 "type": 0,

//                 "serialNo": 14,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T14:51:14+06:00",

//                 "cardType": 1,

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "90",

//                 "type": 0,

//                 "serialNo": 15,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_145114_30075_0.jpeg@WEB000000000064",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 21,

//                 "time": "2022-02-03T14:51:14+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 16,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T14:51:17+06:00",

//                 "cardType": 1,

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "90",

//                 "type": 0,

//                 "serialNo": 17,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_145117_30075_0.jpeg@WEB000000000065",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T14:51:18+06:00",

//                 "cardType": 1,

//                 "name": "Masudul Islam Jony",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "32083",

//                 "type": 0,

//                 "serialNo": 18,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_145118_30075_0.jpeg@WEB000000000066",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T14:51:23+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 19,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T14:53:30+06:00",

//                 "cardType": 1,

//                 "name": "Masudul Islam Jony",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "32083",

//                 "type": 0,

//                 "serialNo": 20,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_145330_30075_0.jpeg@WEB000000000067",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 21,

//                 "time": "2022-02-03T14:53:30+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 21,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T14:53:35+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 22,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 2,

//                 "minor": 1024,

//                 "time": "2022-02-03T15:01:36+06:00",

//                 "type": 0,

//                 "serialNo": 23,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T15:01:37+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 24,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 3,

//                 "minor": 80,

//                 "time": "2022-02-03T15:01:58+06:00",

//                 "type": 0,

//                 "serialNo": 25,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T13:03:10+06:00",

//                 "cardType": 1,

//                 "name": "Masudul Islam Jony",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "32083",

//                 "type": 0,

//                 "serialNo": 26,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_130310_30075_0.jpeg@WEB000000000068",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 21,

//                 "time": "2022-02-03T13:03:10+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 27,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T13:03:13+06:00",

//                 "cardType": 1,

//                 "name": "Masudul Islam Jony",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "32083",

//                 "type": 0,

//                 "serialNo": 28,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_130313_30075_0.jpeg@WEB000000000069",

//                 "picturesNumber": 1

//             },

//             {

//                 "major": 5,

//                 "minor": 22,

//                 "time": "2022-02-03T13:03:18+06:00",

//                 "doorNo": 1,

//                 "type": 0,

//                 "serialNo": 29,

//                 "currentVerifyMode": "invalid"

//             },

//             {

//                 "major": 5,

//                 "minor": 75,

//                 "time": "2022-02-03T13:03:19+06:00",

//                 "cardNo": "00058561930892349",

//                 "cardType": 1,

//                 "name": "MD RABIUL ALAM",

//                 "cardReaderNo": 1,

//                 "doorNo": 1,

//                 "employeeNoString": "10120",

//                 "type": 0,

//                 "serialNo": 30,

//                 "userType": "normal",

//                 "currentVerifyMode": "cardOrFaceOrFp",

//                 "mask": "no",

//                 "pictureURL": "http://192.168.1.64/LOCALS/pic/acsLinkCap/202202_00/03_130319_30075_0.jpeg@WEB000000000070",

//                 "picturesNumber": 1

//             }

//         ]

//     }

// }';


   //=================================================================================

                     
   //echo "response :".$response ." length : ".strlen($response)."<br>"; 
               
 
  //converts json string to array      
   $array = json_decode($response,TRUE);

   //echo "</br>";
  //print_r($array);
  // echo "<br>";

  if (isset($array['AcsEvent'])) {

      // print_r($array);
       // echo "<br>";
      $AcsEventArray = $array['AcsEvent'];

       if (isset($AcsEventArray['InfoList'])) {

              $InfoListArray = $AcsEventArray['InfoList'];
              // print_r( $InfoListArray);


   
                 return $InfoListArray ; 
        }
   } 

}


function  insertApiDataIntoTable($empNo, $inOutTime, $inOutType, $ipAddress){
    
  $query = "INSERT INTO  XX_ATTLOG_HIK (AM_EMPNO, AM_TIME_IN_OUT ,AM_TYPE_IN_OUT , AM_MAC_ID  ) 
                   VALUES ('$empNo' ,  '$inOutTime' , '$inOutType', '$ipAddress' )";

           //  echo "query : ".$query."<br>";
               // echo "------------------------------------------------------------"."<br>" ;
              
          try{
             insertData($query);
          }
          catch(Exception $e){
            "exception occured whie inserting query";
          }

}


?>