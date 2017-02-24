<?php
############### Plan Info #######################

// Days = 1
// Weeks = 2
// Months = 3
// Year = 4
// Fixed = 5


##################################################


function getallplans()
{
	global $wpdb;
	$allplans = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."swpm_membership_tbl WHERE id !='1' ");
	return $allplans;
}


function getemailposts()
{
	global $wpdb;
	$allposts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='email-reminder' and post_status='publish' ");
	return $allposts;
}

function fetchplanid($pname)
{
	global $wpdb;
	$planid = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."swpm_membership_tbl WHERE alias='$pname' ");
	return $planid[0]->id;
}

function getallusers()
{
	global $wpdb;
	$allusers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."swpm_members_tbl");
	return $allusers;
}

function getdatafromcheck($id)
{
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."swpm_check_reminder where user_id='$id' ");
	return $result;
}

function updatedatacheck($id)
{
	global $wpdb;
	$sql = "UPDATE ".$wpdb->prefix."swpm_check_reminder set date='".date('Y-m-d')."' where user_id='$id' ";
	$rez = $wpdb->query($sql);
}

function insertdatacheck($id)
{
	global $wpdb;
	$wpdb->insert( $wpdb->prefix . 'swpm_check_reminder', 
		array( 
			'user_id' => $id,
			'date' => date('Y-m-d')
		), 
		array( 
			'%d',
			'%s'
		) 
	);
}

function getplanusers($planid)
{
	global $wpdb;
	$planusers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."swpm_members_tbl WHERE membership_level= $planid ");
	return $planusers;
}


function plandetail($planid)
{
	global $wpdb;
	$plandetail = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."swpm_membership_tbl WHERE id= '$planid' ");
	return $plandetail;
}

function diff_in_hrs_before($value,$plan_period,$subscription_starts) {
	
	$newTime = strtotime('+'.$plan_period.' days', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d', strtotime("-1 day", strtotime ( $to)));
	$currntdate = date('Y-m-d');
	//echo strtotime();
	
	if("$from" == "$currntdate")
	{
		$last_time = 24 - $value;
		$currunttime= date("G:i");
		$ts1 = strtotime($currunttime);
		//echo $last_time.":00";
	    $ts2 = strtotime($last_time.":00");
		//echo '<br>';
		$diff = ($ts2 - $ts1) / 60;
		//echo '<br>';
		if($diff > '0')
		{
			if($last_time==$currunttime){
				//echo "hi";
				$msg = "yes";
			}
			elseif($diff<30 || $diff==30){
				//echo "hi".'<br>';
				$msg = "yes";
			}
			else{
				$msg = "no";
			}
		}
		else
		{
			$msg = "no";
		}
		
	}
	return $msg;
    // $day   = 24 * 3600;
    // $from  = strtotime($from);
    // $to    = strtotime($to);
    // $diff  = $to - $from;
    //$weeks = floor($diff / $day / 7);
    // $days  = $diff / $day;
    // $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	//$out['weeks'] = "$weeks";
    // $out['days'] = "$days";
	// return $out;
    //return implode(', ', $out);
}

function diff_in_hrs_after($value,$plan_period,$subscription_starts) {
	
	$newTime = strtotime('+'.$plan_period.' days', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d', strtotime("-1 day", strtotime ( $to)));
	$currntdate = date('Y-m-d');
	//echo strtotime();
	
	if("$to" == "$currntdate")
	{
		$last_time = 0 + $value;
		$currunttime= date("G:i");
		$ts1 = strtotime($currunttime);
		$last_time.":00";
	    $ts2 = strtotime($last_time.":00");
		echo '<br>';
		echo $diff = ($ts1 - $ts2) / 60;
		echo '<br>';
		if($diff < '0')
		{
			if($last_time==$currunttime){
				echo "hi";
				$msg = "yes";
			}
			elseif($diff > -39 || $diff== -39 ){
				echo "hi".'<br>';
				$msg = "yes";
			}
			else{
				echo $msg = "no";
			}
		}
		else
		{
			$msg = "no";
		}
		
	}
	return $msg;
}

function diff_in_days_before($value,$plan_period,$subscription_starts) {
	
	$newTime = strtotime('+'.$plan_period.' days', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d');
	
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to);
    $diff  = $to - $from;
    //$weeks = floor($diff / $day / 7);
    $days  = $diff / $day;
    $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	//$out['weeks'] = "$weeks";
    $out['days'] = "$days";
	return $out;
    //return implode(', ', $out);
}

function diff_in_days_after($value,$plan_period,$subscription_starts) {
	
	$plan_period = $plan_period + $value;
	$newTime = strtotime('+'.$plan_period.' days', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d');
	
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to);
    $diff  = $to - $from;
    //$weeks = floor($diff / $day / 7);
    $days  = $diff / $day;
    $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	//$out['weeks'] = "$weeks";
    $out['days'] = "$days";
	return $out;
    //return implode(', ', $out);
}



function diff_in_weeks_before($value,$plan_period,$subscription_starts) {
	
	$newTime = strtotime('+'.$plan_period.' weeks', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d');
	
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to);
    $diff  = $to - $from;
    $weeks = floor($diff / $day / 7);
    $days  = $diff / $day - $weeks * 7;
    $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	$out['weeks'] = "$weeks";
    $out['days'] = "$days";
	return $out;
    //return implode(', ', $out);
}

function diff_in_weeks_after($value,$plan_period,$subscription_starts) {
	
	$plan_period = $plan_period + $value ; 
	$newTime = strtotime('+'.$plan_period.' weeks', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d');
	
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to);
    $diff  = $to - $from;
    $weeks = floor($diff / $day / 7);
    $days  = $diff / $day - $weeks * 7;
    $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	$out['weeks'] = "$weeks";
    $out['days'] = "$days";
	return $out;
    //return implode(', ', $out);
}

function get_difference_monthly_before($plan_period,$subscription_starts)
{
	$total_days = $plan_period*30;
	$newTime = strtotime('+'.$plan_period.' months', strtotime($subscription_starts));
	$newdate = date('Y-m-d', $newTime);
	$from = date('2017-03-09');
	
	$day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($newdate);
    $diff  = $to - $from;
    $weeks = floor($diff / $day / 7);
    $days  = $diff / $day;
    $out   = array();
	return $days;

}

function diff_in_years_before($value,$plan_period,$subscription_starts)
{
	$newTime = strtotime('+'.$plan_period.' years', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d');
	
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to);
    $diff  = $to - $from;
    //$weeks = floor($diff / $day / 7);
    $days  = $diff / $day;
    $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	//$out['weeks'] = "$weeks";
    $out['days'] = "$days";
	return $out;
}

function diff_in_years_after($value,$plan_period,$subscription_starts) {
	
	//$plan_period = $plan_period + $value;
	$newTime = strtotime('+'.$plan_period.' year', strtotime($subscription_starts));
	echo $to = date('Y-m-d', $newTime);
	$newTime = strtotime('+'.$value.' days', strtotime($to));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d');
	
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to);
    $diff  = $to - $from;
    //$weeks = floor($diff / $day / 7);
    $days  = $diff / $day;
    $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	//$out['weeks'] = "$weeks";
    $out['days'] = "$days";
	return $out;
    //return implode(', ', $out);
}

function diff_in_years_hrs_before($value,$plan_period,$subscription_starts) {
	
	$newTime = strtotime('+'.$plan_period.' years', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d', strtotime("-1 day", strtotime ( $to)));
	$currntdate = date('Y-m-d');
	//echo strtotime();
	
	if("$from" == "$currntdate")
	{
		$last_time = 24 - $value;
		$currunttime= date("G:i");
		$ts1 = strtotime($currunttime);
		//echo $last_time.":00";
	    $ts2 = strtotime($last_time.":00");
		//echo '<br>';
		echo $diff = ($ts2 - $ts1) / 60;
		//echo '<br>';
		if($diff > '0')
		{
			if($last_time==$currunttime){
				//echo "hi";
				$msg = "yes";
			}
			elseif($diff<10 || $diff==10){
				//echo "hi".'<br>';
				$msg = "yes";
			}
			else{
				$msg = "no";
			}
		}
		else
		{
			$msg = "no";
		}
		
	}
	return $msg;
    // $day   = 24 * 3600;
    // $from  = strtotime($from);
    // $to    = strtotime($to);
    // $diff  = $to - $from;
    //$weeks = floor($diff / $day / 7);
    // $days  = $diff / $day;
    // $out   = array();
    // if ($weeks) $out['weeks'] = "$weeks Week" . ($weeks > 1 ? 's' : '');
    // if ($days)  $out['days'] = "$days Day" . ($days > 1 ? 's' : '');
	//$out['weeks'] = "$weeks";
    // $out['days'] = "$days";
	// return $out;
    //return implode(', ', $out);
}

function diff_in_years_hrs_after($value,$plan_period,$subscription_starts) {
	
	$newTime = strtotime('+'.$plan_period.' years', strtotime($subscription_starts));
	$to = date('Y-m-d', $newTime);
	$from = date('Y-m-d', strtotime("-1 day", strtotime ( $to)));
	$currntdate = date('Y-m-d');
	//echo strtotime();
	
	if("$to" == "$currntdate")
	{
		$last_time = 0 + $value;
		$currunttime= date("G:i");
		$ts1 = strtotime($currunttime);
		$last_time.":00";
	    $ts2 = strtotime($last_time.":00");
		echo '<br>';
		echo $diff = ($ts1 - $ts2) / 60;
		echo '<br>';
		if($diff < '0')
		{
			if($last_time==$currunttime){
				echo "hi";
				$msg = "yes";
			}
			elseif($diff > -39 || $diff== -39 ){
				echo "hi".'<br>';
				$msg = "yes";
			}
			else{
				echo $msg = "no";
			}
		}
		else
		{
			$msg = "no";
		}
		
	}
	return $msg;
}


function sendremindermail($from,$site_name,$to,$subject,$message)
{
	require_once ('Mailer/PHPMailerAutoload.php');
	$mail = new PHPMailer;
	$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'apikey';                 // SMTP username
	$mail->Password = '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';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom($from,$site_name);
	//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	$mail->addAddress($to);               // Name is optional
	$mail->addReplyTo($from,$site_name);
	// $mail->addCC('cc@example.com');
	// $mail->addBCC('bcc@example.com');

	// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = $message;

	if(!$mail->send()) {
		//$msg = 'Message could not be sent.';
		$msg =  'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		$msg = 'send';
	}
	return $msg;
}

?>