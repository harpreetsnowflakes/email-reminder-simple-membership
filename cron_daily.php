<?php
// require_once(ABSPATH . 'wp-load.php');
// include_once('include/cronfunction.php');

// function daily_check()
// {

		// mycronset();


	// mycronset();

// }
// $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
// echo $date->format('Y-m-d H:i:sP') . "\n";
$timezone = 'Asia/Kolkata';  //perl: $timeZoneName = "MY TIME ZONE HERE";

$date = new DateTime('now', new DateTimeZone($timezone));

$currunttime = $date->format('G:i');

//echo "Local time is $currunttime." . "\n";


//$currunttime= date("G:i");
// echo "currunt time is ". $currunttime;
// echo '<br>';
// $ourTime ="11:05";
// $ts1 = strtotime($currunttime);
// $ts2 = strtotime($ourTime);

// echo $diff = ($ts1 - $ts2) / 60;

// echo '<br>';
// if($ourTime==$currunttime){
    // echo "hi";
// }
// elseif($diff<10 || $diff==10){
    // echo "hi".'<br>';
// }
// else{
    // echo "Time difference more then 10 minutes";
// }



require_once('../../../wp-load.php');
include_once( plugin_dir_path( __FILE__ ) . 'include/cronfunction.php');
mycronset();

?>