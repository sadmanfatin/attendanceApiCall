<?php 
include 'dbConn.php';
include 'common.php';
set_time_limit(0);
$terminalLastEntryArray = array();


/// =========================================== values of day and terminal to run script ===========================================================

$startDate = "2022-02-16"; 
$endDate = "2022-02-20"; 

$terminals = getTerminals();        // all terminal entry from database
//$terminals = getTerminalWithId(6);    //  specific terminal entry from database

/// ============================================================================================================================


    foreach ($terminals as $terminal) {
     
       $terminalId =  $terminal['ID'];
       $terminalUrl = $terminal['API_STRING'];
       $ipAddress = $terminal['IP_ADDRESS'];
       $inOutType = $terminal['IN_OUT'];
       //echo $meterId."".$meterUrl."<br>";
      // $startTime = $terminal ['MAX_TIME'];

       $startTime =  $startDate.'T06:00:00+06:00';
       $endTime =   $endDate.'T22:00:00+06:00';
       
       
        // echo $startTime;
        // echo "<br>";
        // echo $endTime;
        // echo "<br>";

       while ($startTime <  $endTime ) {


          // echo "========  Terminal info  ========="."<br>";
          // echo "=== Terminal Id: ".$terminalId.", Terminal URL: ".$terminalUrl.", IP Address: ".$ipAddress.", In/Out: ".$inOutType.", start time: ".$startTime."<br>";
          //  echo "========  Terminal info  ========="."<br>";
      
   
           $InfoListArray  = getDataFromApi($terminalUrl, $startTime  , $endTime  );
             

          
              if ($InfoListArray != "No Data") { // if InfoList array is not set then for loop will give error

                 if (is_array($InfoListArray) || is_object($InfoListArray))
                 {

                    foreach ($InfoListArray as $InfoList) {
                            // echo "<\br>";
                            $time = $InfoList['time'];
                            $serial = $InfoList['serialNo'];
                            $verification = $InfoList['currentVerifyMode'];
                            $empNo = isset($InfoList['employeeNoString']) ? $InfoList['employeeNoString'] : null; 

                            $newStartTime =  date('Y-m-d\TH:i:sP', strtotime( $time."+1 second"));
                           
                             $startTime = $newStartTime;
                           // $terminalLastEntryArray[$ipAddress] =  $newStartTime ; 

                             // echo "time: ".$time."  serial: ".$serial." verification : ".$verification." employee no : ".$empNo."\n";
                             // echo "<br>";                      

                             if ($empNo != null){                            
                                  
                                insertApiDataIntoTableUniquely($empNo, $time, $inOutType, $ipAddress);
                            
                             }
                    }
                                          

                  }
                
              }
       

        }
  

          
     }



 //$apiUrl="http://192.168.1.64/ISAPI/AccessControl/AcsEvent?format=json";


oci_close($dbConn);

?>