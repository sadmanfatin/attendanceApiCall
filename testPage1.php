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
               
      // curl_close($client);
        echo "response :".$response ." length : ".strlen($response)."<br>"; 
        

         curl_close($client);
         
 //          print_r($response);
 //       echo "<br>";
 // printf($response);
 //  echo "<br>";    
 // print($response);
   //      //  echo "<br>"; 
   //   if($response == null){

   //   // echo "response is null <br>"; 
   //   // $response  = "NUll";
   //   //  return  $response ;
   //   }
   //   else if ($response == "Access denied"){
   //    // echo "response is Access Denied <br>";
   //    //  $response  = "Access denied";
   //  //   return  $response ;
    
   //    }
   //   else if ($response == ""){
   //    // echo "response is No data <br>";
   //    //  $response  = "No data";
   //  //   return  $response ;



oci_close($dbConn);

?>