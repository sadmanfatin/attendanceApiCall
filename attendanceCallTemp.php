<?php 
include 'dbConn.php';
include 'common.php';
set_time_limit(0);
     
       $terminalId = 4;
       $terminalUrl =  "http://192.168.1.68/ISAPI/AccessControl/AcsEvent?format=json";
       $ipAddress = "192.168.1.68";
       $inOutType = 1;
       $startTime = '2022-02-17T08:00:00+06:00';

        $endTime = '2022-02-17T09:30:00+06:00';
       //$startTime = date("Y-m-d" , strtotime("-10 day")).'T00:00:00+06:00';
      // $endTime = date("Y-m-d" , strtotime("+1 day")).'T00:00:00+06:00';

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
                     
                    echo "time: ".$time."  serial: ".$serial." verification : ".$verification." employee no : ".$empNo."\n";
                     echo "<br>";                      

                     if ($empNo != null){
                      //  insertApiDataIntoTable($empNo, $time, $inOutType, $ipAddress);
                     }
            }
                                  

          }
        
      }

          
oci_close($dbConn);

?>