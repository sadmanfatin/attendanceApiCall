<?php 

 $startTime =   date("Y-m-d" , strtotime("+1 day")).'T00:00:00+06:00';
 echo $startTime;
 echo "<br>";
// echo $endtime;

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
echo $post;
 echo "<br>";

  $post = '{
    "AcsEventCond": {
        "searchID": "3166590d-cdb3-43f3-b25e-f6e98a05d359",
        "searchResultPosition": 0,
        "maxResults": 1000,
        "major": 0,
        "minor": 0,
        "startTime": "'.$startTime.'",
        "endTime": "2022-02-04T16:18:47+06:00",
        "thermometryUnit":"celcius",
        "currTemperature":1
    }
}';
echo $post;

?>
