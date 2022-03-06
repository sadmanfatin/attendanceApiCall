<?php 
include 'dbConn.php';
include 'common.php';
set_time_limit(0);
$terminalLastEntryTimeArray = array();
$terminalLastEntrySerialArray = array();

//  $terminals = getTerminals(); // all terminal entry from database
while (true){
    $terminals = getTerminals(); 
 // $terminals = getTerminalWithId(6); 
    foreach ($terminals as $terminal) {
     
       $terminalId =  $terminal['ID'];
       $terminalUrl = $terminal['API_STRING'];
       $ipAddress = $terminal['IP_ADDRESS'];
       $inOutType = $terminal['IN_OUT'];
       //echo $meterId."".$meterUrl."<br>";
       $startTime = $terminal ['MAX_TIME'];


      if (! isset  ($terminalLastEntryTimeArray[$ipAddress]) ){            
          $startTime = $terminal ['MAX_TIME']; 
      }
      else {             
          $startTime = $terminalLastEntryTimeArray[$ipAddress];
      }

       //$startTime = date("Y-m-d" , strtotime("-10 day")).'T00:00:00+06:00';
       $endTime = date("Y-m-d" , strtotime("+1 day")).'T00:00:00+06:00';

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

//                       $newStartTime =  date('Y-m-d\TH:i:sP', strtotime( $time."+1 second"));

                        $terminalLastEntryTimeArray[$ipAddress] =   $time;                          

                        // echo "time: ".$time."  serial: ".$serial." verification : ".$verification." employee no : ".$empNo."\n";
                        //  echo "<br>";      
                             
                        if (! isset  ($terminalLastEntrySerialArray[$ipAddress]) ){                                 
                             $lastSerial = -1; 
                        }                         
                        else {                                   
                            $lastSerial = $terminalLastEntrySerialArray[$ipAddress];
                        }     

                              // echo  "LastSerial: ".$lastSerial." serial: ".$serial;
                              //  echo "<br>"; 
       
                        if ($empNo != null and $serial > $lastSerial ){
                            insertApiDataIntoTable($empNo, $time, $inOutType, $ipAddress);                           
                        }

                        if ( $serial > $lastSerial ){
                             $terminalLastEntrySerialArray[$ipAddress] =   $serial;                               
                        }
                                                                }                                     

              }          
          }
          
        }

}

 //$apiUrl="http://192.168.1.64/ISAPI/AccessControl/AcsEvent?format=json";

oci_close($dbConn);

?>