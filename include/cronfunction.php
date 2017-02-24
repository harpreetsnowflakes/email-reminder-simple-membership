<?php
include_once('functions.php');
############### Plan Info ########################

// Days = 1
// Weeks = 2
// Months = 3
// Year = 4
// Fixed = 5


##################################################


function mycronset()
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
							if($dataclock == "2") //Days
							{ 
								if($before_after == "1")
								{
									//before expire
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}						
								}
								else
								{
									//after expire		
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							}
							
							else if($dataclock == "3") //Weeks
							{
								if($before_after == "1")
								{
									
									
									//before expire
									$value = $value * 7 ;
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 7 ;
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							
							else if($dataclock == "4") //Months
							{
								if($before_after == "1")
								{
									
									
									//before expire
									$value = $value * 30 ;
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 30 ;
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							
						}
						
						#################### Days Logics Ends ########################
						
						
						
						#################### Weeks Logics Start ########################							
						
						else if($plan_type == "2")
						{
							//Weeks
							$plan_period = $plan_period * 7;
							
							if($dataclock == "2") //Days
							{ 
								if($before_after == "1")
								{
									//before expire
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}						
								}
								else
								{
									//after expire		
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							}
							
							else if($dataclock == "3") //Weeks
							{
								if($before_after == "1")
								{
									//before expire
									$value = $value * 7 ;
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 7 ;
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							else if($dataclock == "4") //Months
							{
								if($before_after == "1")
								{
									//before expire
									$value = $value * 30 ;
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 30 ;
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							
						}
						
						#################### Weeks Logics Ends ########################	
						
						#################### Months Logics Start ########################	
						
						
						else if($plan_type == "3")
						{
							//Months
							$plan_period = $plan_period * 30;
							if($dataclock == "2") //Days
							{ 
								if($before_after == "1")
								{
									//before expire
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}						
								}
								else
								{
									//after expire		
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							}
							
							else if($dataclock == "3") //Weeks
							{
								if($before_after == "1")
								{
									//before expire
									$value = $value * 7 ;
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 7 ;
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							else if($dataclock == "4") //Months
							{
								if($before_after == "1")
								{
									//before expire
									$value = $value * 30 ;
									$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 30 ;
									$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
						}

						#################### Months Logics Ends ########################	
						
						#################### Year Logics Starts ########################	
						
						else if($plan_type == "4")
						{ 
							echo "year";
							//echo $plan_period;
							if($dataclock == "2") //Days
							{ 
								if($before_after == "1")
								{
									//before expire
									$difference = diff_in_years_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}						
								}
								else
								{
									//after expire		
									
									$difference = diff_in_years_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							}
							
							else if($dataclock == "3") //Weeks
							{
								if($before_after == "1")
								{
									//before expire
//echo "before";
									$value = $value * 7 ;
									$difference = diff_in_years_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 7 ;
									$difference = diff_in_years_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							else if($dataclock == "4") //Months
							{
								if($before_after == "1")
								{
									//before expire
									$value = $value * 30 ;
									$difference = diff_in_years_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 30 ;
									$difference = diff_in_years_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										updatedatacheck($data[0]->user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
						}
						
						#################### Year Logics Ends ########################
					}
				}
				else
				{
					
					if($plan_type == "1") //Days
					{
						//echo "days";
						if($dataclock == "2") //Days
						{ 
							if($before_after == "1")
							{
								//before expire
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}						
							}
							else
							{
								//after expire		
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}
								
							}
						}
						
						else if($dataclock == "3") //Weeks
						{
							if($before_after == "1")
							{
								
								
								//before expire
								$value = $value * 7 ;
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}														
							}
							else
							{
								
								//after expire  
								$value = $value * 7 ;
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}												
							}
						}
						
						
						else if($dataclock == "4") //Months
						{
							if($before_after == "1")
							{
								
								
								//before expire
								$value = $value * 30 ;
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}														
							}
							else
							{
								
								//after expire  
								$value = $value * 30 ;
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}												
							}
						}
						
						
					}
					
					#################### Days Logics Ends ########################
					
					
					
					#################### Weeks Logics Start ########################							
					
					else if($plan_type == "2")
					{
						//Weeks
						$plan_period = $plan_period * 7;
						
						if($dataclock == "2") //Days
						{ 
							if($before_after == "1")
							{
								//before expire
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}						
							}
							else
							{
								//after expire		
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);;
								}
								
							}
						}
						
						else if($dataclock == "3") //Weeks
						{
							if($before_after == "1")
							{
								//before expire
								$value = $value * 7 ;
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}														
							}
							else
							{
								
								//after expire  
								$value = $value * 7 ;
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}												
							}
						}
						
						else if($dataclock == "4") //Months
						{
							if($before_after == "1")
							{
								//before expire
								$value = $value * 30 ;
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									echo $user_id;
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}														
							}
							else
							{
								
								//after expire  
								$value = $value * 30 ;
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}												
							}
						}
						
						
					}
					
					#################### Weeks Logics Ends ########################	
					
					#################### Months Logics Start ########################	
					
					
					else if($plan_type == "3")
					{
						//Months
						$plan_period = $plan_period * 30;
						if($dataclock == "2") //Days
						{ 
							if($before_after == "1")
							{
								//before expire
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}						
							}
							else
							{
								//after expire		
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}
								
							}
						}
						
						else if($dataclock == "3") //Weeks
						{
							if($before_after == "1")
							{
								//before expire
								$value = $value * 7 ;
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}														
							}
							else
							{
								
								//after expire  
								$value = $value * 7 ;
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}												
							}
						}
						
						else if($dataclock == "4") //Months
						{
							if($before_after == "1")
							{
								//before expire
								$value = $value * 30 ;
								$difference = diff_in_days_before($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == $value)
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}														
							}
							else
							{
								
								//after expire  
								$value = $value * 30 ;
								$difference = diff_in_days_after($value,$plan_period,$subscription_starts); 
								print_r($difference);
								if($difference['days'] == '0')
								{
									echo "Send Mail";
									insertdatacheck($user_id);
									sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
								}												
							}
						}
						
					}

					#################### Months Logics Ends ########################
					
					#################### Year Logics Starts ########################	
						
						else if($plan_type == "4")
						{ 
							echo "year";
							//echo $plan_period;
							if($dataclock == "2") //Days
							{ 
								if($before_after == "1")
								{
									//before expire
									$difference = diff_in_years_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										insertdatacheck($user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}						
								}
								else
								{
									//after expire		
									
									$difference = diff_in_years_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										insertdatacheck($user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}
									
								}
							}
							
							else if($dataclock == "3") //Weeks
							{
								if($before_after == "1")
								{
									//before expire
//echo $value."<br>";
									$value = $value * 7 ;
									$difference = diff_in_years_before($value,$plan_period,$subscription_starts); 
									//print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										insertdatacheck($user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 7 ;
									$difference = diff_in_years_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										insertdatacheck($user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
							
							else if($dataclock == "4") //Months
							{
								if($before_after == "1")
								{
									//before expire
									$value = $value * 30 ;
									$difference = diff_in_years_before($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == $value)
									{
										echo "Send Mail";
										insertdatacheck($user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}														
								}
								else
								{
									
									//after expire  
									$value = $value * 30 ;
									$difference = diff_in_years_after($value,$plan_period,$subscription_starts); 
									print_r($difference);
									if($difference['days'] == '0')
									{
										echo "Send Mail";
										insertdatacheck($user_id);										
										sendremindermail($admin_email,$site_name,$user_email,$emailsubject,$emailcontent);
									}												
								}
							}
						}
						
						#################### Year Logics Ends ########################					
				}
			}
			// echo "<pre>";
			// print_r($postdata);
			
		//}/////////// else allplans
	}
}

##################################################



?>