<?php
include_once('functions.php');

function mycronfiveminute()
{
	$admin_email = get_bloginfo('admin_email');
	$site_name = get_bloginfo('name');
	$posts = getemailposts();
	foreach($posts as $post)
	{
		
		$postid = $post->ID;
		$postdata = get_post_meta($postid);
		$post_plan_name = $postdata['pname'][0];
		$before_after = $postdata['dataon'][0];
		$dataclock = $postdata['dataclock'][0];
		$value = $postdata['datavalue'][0];
		$emailsubject = $postdata['emailsubject'][0];
		$emailcontent = nl2br($postdata['emailcontent'][0]);
		if($post_plan_name == "allplans")
		{
			//Get all Plan Users
			$plan_users = getallusers();
		}
		else
		{
			// Get Only Particular Plan Users
			$planid = fetchplanid($post_plan_name);
			$plan_users = getplanusers($planid);
		}
		
			foreach($plan_users as $plan_user)
			{
				//global $user_id;
                $value = $postdata['datavalue'][0];
				$user_id = $plan_user->member_id;
				$user_email = $plan_user->email;
				$user_plan = $plan_user->membership_level;
				$subscription_starts = $plan_user->subscription_starts;
				
				// Now check the Plan Type and Period of Plan
				$plan_details = plandetail($user_plan);				
				$plan_type = $plan_details[0]->subscription_duration_type;
				$plan_period = $plan_details[0]->subscription_period;
				
				$data = getdatafromcheck($user_id);
				$errors = array_filter($data);
				if (!empty($errors)) {
					
					//print_r($data);
					$send_date = strtotime($data[0]->date);
					$currentdate = strtotime(date('Y-m-d'));
					if($send_date == $currentdate)
					{
						//No Function Email Send Today already
					}
					else
					{
						if($plan_type == "1") //Days
						{
							//echo "days";
								if($before_after == "1")
								{
									//before expire
									//echo $value;
									$difference = diff_in_hrs_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($data[0]->user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
										
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire		
									$difference = diff_in_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($data[0]->user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
										
									}
									
								}
							
						}
						
						#################### Days Logics Ends ########################
						
						else if($plan_type == "2")
						{
							//Weeks
							$plan_period = $plan_period * 7;
							if($before_after == "1")
								{
									//before expire
									//echo $value;
									$difference = diff_in_hrs_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($data[0]->user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
										
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire		
									echo $difference = diff_in_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($data[0]->user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							
						}
						
						#################### Weeks Logics Ends ########################	
						
						else if($plan_type == "3")
						{
							$plan_period = $plan_period * 30;
							if($before_after == "1")
								{
									//before expire
									//echo $value;
									$difference = diff_in_hrs_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($data[0]->user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire		
									$difference = diff_in_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($data[0]->user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
						}
						
						#################### Months Logics Ends ########################	
						
						#################### Years Logics Starts ########################	
						
						else if($plan_type == "4")
						{
							
							if($before_after == "1")
								{
									//before expire
									echo $value;
									$difference = diff_in_years_hrs_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire	
									//echo $value;									
									$difference = diff_in_years_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										updatedatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
						}

					}
					
					
				}
				
				else
				{
					if($plan_type == "1") //Days
						{
							//echo "days";
								if($before_after == "1")
								{
									//before expire
									//echo $value;
									$difference = diff_in_hrs_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire		
									$difference = diff_in_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							
						}
						
						#################### Days Logics Ends ########################
						
						else if($plan_type == "2")
						{
							//Weeks
							$plan_period = $plan_period * 7;
							if($before_after == "1")
								{
									//before expire
									//echo $value;
									$difference = diff_in_hrs_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire		
									$difference = diff_in_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							
						}
						
						#################### Weeks Logics Ends ########################	
						
						else if($plan_type == "3")
						{
							$plan_period = $plan_period * 30;
							if($before_after == "1")
								{
									//before expire
									//echo $value;
									$difference = diff_in_hrs_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire		
									$difference = diff_in_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
						}
						
						#################### Months Logics Ends ########################	
						
						#################### Years Logics Starts ########################	
						
						else if($plan_type == "4")
						{
							
							if($before_after == "1")
								{
									//before expire
									echo $value;
									$difference = diff_in_years_hrs_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									// if($difference['days'] == $value)
									// {
										// echo "Send Mail";
										// updatedatacheck($data[0]->user_id);
									// }						
								}
								else
								{
									//after expire	
									//echo $value;									
									$difference = diff_in_years_hrs_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference == "yes")
									{
										echo "send mail";
										insertdatacheck($user_id);
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
						}
						
						#################### Years Logics Ends ########################	
				}
				
				
			}
		
		
		
		
	}
	
}

?>