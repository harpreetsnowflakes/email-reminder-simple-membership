<?php
include_once('functions.php');
//b. callback function for 'work_info' custom meta box (see $callback variable)
function create_work_meta( $post ){
    wp_nonce_field( basename( __FILE__ ), 'work_meta_box_nonce' );
    //custom fields
    $datavalue = get_post_meta( $post->ID, 'datavalue', true );
    $dataclock =  get_post_meta( $post->ID, 'dataclock', true );
    $dataon = get_post_meta( $post->ID, 'dataon', true );
	$emailsubject = get_post_meta( $post->ID, 'emailsubject', true );
	$emailcontent=  get_post_meta($_GET['post'], 'emailcontent' , true ) ;
	$pname = get_post_meta($_GET['post'], 'pname' , true ) ;
	$rstatus = get_post_meta($_GET['post'], 'rstatus' , true ) ;
	$dclock = array('1'=> 'Hour(s)','2'=> 'Day(s)','3'=> 'Week(s)','4'=> 'Month(s)');
	$dcpon = array('1'=> 'Before subscription Expires','2'=> 'After subscription Expires');
    echo '<table class="reminderevent">
        <tr>
			<td>
            <label for=\'Trigger Event\'>Trigger event:</label>
            </td>
			<td>
            <input type=\'text\' name=\'datavalue\' value=\'' . $datavalue .'\' />
			'; ?>
			<select name="dataclock">
				<?php
				foreach($dclock as $key => $value)
				{
					if($key == $dataclock)
					{
						echo "<option value='".$key."' selected>".$value."</option>";
					}
					else
					{
						echo "<option value='".$key."'>".$value."</option>";
					}
				}
				?>
			</select>
			<select name="dataon">
				<?php
				foreach($dcpon as $key => $value)
				{
					if($key == $dataon)
					{
						echo "<option value='".$key."' selected>".$value."</option>";
					}
					else
					{
						echo "<option value='".$key."'>".$value."</option>";
					}
				}
				?>
			</select>
			<br><i>
			Enter the Trigger Event for the email reminder. For Example: 10 days before subscription expire.
			</i>
		</td>
        </tr>
		<tr class="spacer"></tr>
		<tr>
			<td>
				<label for="email-header">Email Subject:</label>
			</td>
			<td>
				<input class="subjectemail" type="text" name="emailsubject" value="<?php echo $emailsubject; ?>">
				<br><i>
				Enter the Email Reminder Subject.
				</i>
			</td>
		</tr>
		<tr class="spacer"></tr>
		<tr>
			<td>
				<label for="email-description">Email Content:</label>
			</td>
			<td>
				<?php wp_editor( htmlspecialchars_decode($emailcontent), 'mettaabox_ID_stylee', $settings = array('textarea_name'=>'emailcontent') ); ?>
				<br><i>
				Enter the Email Reminder Content.
				</i>
			</td>
		</tr>
		<tr class="spacer"></tr>
		<tr>
			<td>
				<label for="email-subscriptions">Subscription(s):</label>
			</td>
			<td>
				<?php
					if($pname == "allplans")
					{
						echo "<input type='radio' name='pname' value='allplans' checked>All Subscriptions<br>";
					}
					else if($pname == "")
					{
						echo "<input type='radio' name='pname' value='allplans' checked>All Subscriptions<br>";
					}
					else
					{
						echo "<input type='radio' name='pname' value='allplans'>All Subscriptions<br>";
					}
				?>
				
				<?php
				$allplans = getallplans();
				//print_r($allplans);
				foreach($allplans as $plan)
				{
					if($plan->alias == $pname)
					{
						echo "<input type='radio' name='pname' value='".$plan->alias."' checked> ".$plan->alias."<br>";
					}
					else
					{
						echo "<input type='radio' name='pname' value='".$plan->alias."'> ".$plan->alias."<br>";
					}
				}
				// echo "<pre>";
				// print_r($allplans);
				// echo "</pre>";
				?>
				<br><i>
				Select the Subscription(s) to which this email reminder should be sent.
				</i>
			</td>
		</tr>
		<tr class="spacer"></tr>
		<tr>
			<td>
				<label for="reminder-status">Status:</label>
			</td>
			<td>
				<select name="rstatus">
				<?php
					if($rstatus == "active")
					{
						echo '<option value="active" selected>Active</option>';
						echo '<option value="inactive">Inactive</option>';
					}
					else
					{
						echo '<option value="active" >Active</option>';
						echo '<option value="inactive" selected>Inactive</option>';
					}
				?>
				</select>
				<br><i>
				Select the Email Reminder Status.
				</i>
			</td>
		</tr>
	<?php
	echo '
        
		</table>';
}

//c. saves data after submitting/updating custom post
function save_work_meta( $post_id ){
    //1. verifies meta box nonce (to prevent CSRF attacks)
   if( !isset( $_POST['work_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['work_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
    //2. if autosaves
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }
    //3. if user's not admin
    if( !current_user_can( 'edit_post', $post_id ) ){
        return;
    } elseif ( !current_user_can ( 'edit_page', $post_id) ){
        return;
    }
    //4. checks all custom field values (see 'create_work_meta()' function)
    if( isset( $_REQUEST['datavalue'] ) ){
        update_post_meta( $post_id, 'datavalue', sanitize_text_field( $_POST['datavalue'] ) );
    }
    if( isset( $_REQUEST['dataclock'] ) ){
        update_post_meta( $post_id, 'dataclock', sanitize_text_field( $_POST['dataclock'] ) );
    }
    if( isset( $_REQUEST['dataon'] ) ){
        update_post_meta( $post_id, 'dataon', sanitize_text_field( $_POST['dataon'] ) );
    }
	if( isset( $_REQUEST['emailsubject'] ) ){
        update_post_meta( $post_id, 'emailsubject', sanitize_text_field( $_POST['emailsubject'] ) );
    }
	if( isset( $_REQUEST['emailcontent'] ) ){
		$datta=htmlspecialchars($_POST['emailcontent']);
        update_post_meta($post_id, 'emailcontent', $datta );
    }
	if( isset( $_REQUEST['pname'] ) ){
        update_post_meta( $post_id, 'pname', sanitize_text_field( $_POST['pname'] ) );
    }
	if( isset( $_REQUEST['rstatus'] ) ){
        update_post_meta( $post_id, 'rstatus', sanitize_text_field( $_POST['rstatus'] ) );
    }
	
}
add_action( 'save_post_email-reminder', 'save_work_meta', 10, 2 );


?>