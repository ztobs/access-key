
<br>
<div class="notice is-dismissible hidden"><p></p></div>
<br><br>

<!-- Tab Links -->
<div class="tab">
  <button class="tablinks" id="one" onclick="openTab(event, 'users_token')"><?php _e("USERS API TOKENs", "accesskey"); ?></button>
  <button class="tablinks" onclick="openTab(event, 'admin_key')"><?php _e("ADMIN API KEY", "accesskey"); ?></button>
  <button class="tablinks" onclick="openTab(event, 'other_settings')"><?php _e("OTHER SETTINGS", "accesskey"); ?></button>
</div>


<!-- Tab Contents -->
<!-- Tab1 -->
<div class="ztobs_accesskey tabcontent" id="users_token">
	<h1><?php _e("USERS API TOKENs", "accesskey"); ?></h1>
	<div class="container">
		<div class="table-container">
			<table id="accesskey-users" class="display" style="width:100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Token</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$users = $subscriber->getSubscribers();
						if(count($users) < 1) $users = array();
						foreach ($users as $user) 
						{
					?>
					<tr>
						<td><?php echo $user['user_id']; ?></td>
						<td><?php echo $user['name']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td id="key_<?php echo $user['user_id']; ?>" ><b><?php echo $user['key']; ?></b></td>
						<td><?php echo $user['start']; ?></td>
						<td><?php echo $user['end']; ?></td>
						<td><?php echo strtoupper($user['status']); ?></td>
						<td>
							<?php
								if($user['status'] == 'active')
									echo "<button class='button-primary' onclick='refreshToken(".$user['user_id'].")'>Refresh Token</button>"
						 	?>
						 </td>
					</tr>
						
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="shortcode_container">
			Add this shortcode to your customer pages
			 <code><b> [accesskey_user_token] </b></code>
		</div>
	</div>
</div>

<!-- Tab2 -->
<div class="admin-apikey tabcontent" id="admin_key">
	<h1><?php _e("ADMIN API KEY", "accesskey"); ?></h1>
	<div>
		<input type="text" name="ztobs_admin_apikey" id="ztobs_admin_apikey" size="60" value="<?php echo get_option( Constants::ADMINAPIKEY_METAKEY );?>" />&nbsp;
		<button class="button-primary" onclick="updateKey()"><?php _e("UPDATE", "accesskey"); ?></button>&nbsp;
		<button class="button-primary" onclick="rand()"><?php _e("RANDOMIZE", "accesskey"); ?></button>
		<br><br>
		<div>
			<?php echo _e( 'API Endpoint', 'accesskey' ) .": <code>".site_url( 'wp-json/accesskey/v1/validate/key/{subscriber_token}', null );?></code>
			<br><br>
			<?php _e('Add', 'accesskey'); ?> <code>Accesskey-Auth:Bearer <i id="usage-key"><?php echo get_option( Constants::ADMINAPIKEY_METAKEY );?></i></code> <?php _e('to your API request header', 'accesskey'); ?>
		</div>
	</div>
</div>


<!-- Tab3 -->
<div class="admin-others tabcontent" id="other_settings">
	<h1><?php _e("OTHER SETTINGS", "accesskey"); ?></h1>
	<div>
		<form>
			<table>
				<tr>
					<td><?php _e("Subscription Product", "accesskey"); ?>:</td>
					
					<td>
						<select style="width:60%" id="product_id" >
							<option value="" >None</option>
							<?php
								$prods = wc_get_products(array());
								foreach ($prods as $prod) 
								{
							?>
								<option value="<?php echo $prod->get_id(); ?>" <?php echo ($prod->get_id()==get_option(Constants::SUB_PRODUCT_ID, ''))?"selected":"" ?> ><?php echo $prod->get_name(); ?>
								</option>
							<?php
								}
							?>
							
						</select>
					</td>
				</tr>
				<tr>
					<td><?php _e("Token Status Success", "accesskey"); ?>:</td>
					<td><input style="width:60%" type="text" id="token_status_success" value="<?php echo get_option( Constants::TOKEN_STATUS_SUCCESS, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Token Status Invalid", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="token_status_invalid" value="<?php echo get_option( Constants::TOKEN_STATUS_INVALID, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Token Status Expired", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="token_status_expired" value="<?php echo get_option( Constants::TOKEN_STATUS_EXPIRED, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Email Sender Name", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="email_sender_name" value="<?php echo get_option( Constants::EMAIL_SENDER_NAME, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Sender Email", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="email_sender_email" value="<?php echo get_option( Constants::EMAIL_SENDER_EMAIL, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Refresh Token Email Subject", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="refresh_email_subject" value="<?php echo get_option( Constants::REFRESH_TOKEN_EMAIL_SUBJECT, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Refresh Token Email Body", "accesskey"); ?>:</td>
					<td><textarea id="refresh_email_body"><?php echo get_option( Constants::REFRESH_TOKEN_EMAIL_BODY, '' ); ?></textarea></td>
				</tr>
				<tr>
					<td><?php _e("Send Email Refresh Token", "accesskey"); ?>:</td>
					<td><input type="checkbox" id="send_refresh_email" <?php echo  get_option( Constants::REFRESH_TOKEN_SEND_EMAIL, '' )=="true"? "checked":""; ?> /></td>
				</tr>

				<tr>
					<td><?php _e("New User Email Subject", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="new_email_subject" value="<?php echo get_option( Constants::NEW_USER_EMAIL_SUBJECT, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("New User Email Body", "accesskey"); ?>:</td>
					<td><textarea id="new_email_body"><?php echo get_option( Constants::NEW_USER_EMAIL_BODY, '' ); ?></textarea></td>
				</tr>
				<tr>
					<td><?php _e("Send Email New User", "accesskey"); ?>:</td>
					<td><input type="checkbox" id="send_new_email" <?php echo  get_option( Constants::NEW_USER_SEND_EMAIL, '' )=="true"? "checked":""; ?> /></td>
				</tr>

				<tr>
					<td><?php _e("Renew Subscription Email Subject", "accesskey"); ?>:</td>
					<td><input type="text" style="width:60%" id="renew_email_subject" value="<?php echo get_option( Constants::RENEW_SUB_EMAIL_SUBJECT, '' ); ?>" /></td>
				</tr>
				<tr>
					<td><?php _e("Renew Subscription Email Body", "accesskey"); ?>:</td>
					<td><textarea id="renew_email_body"><?php echo get_option( Constants::RENEW_SUB_EMAIL_BODY, '' ); ?></textarea></td>
				</tr>
				<tr>
					<td><?php _e("Send Email Renew Subscription", "accesskey"); ?>:</td>
					<td><input type="checkbox" id="send_renew_email" <?php echo  get_option( Constants::RENEW_SUB_SEND_EMAIL, '' )=="true"? "checked":""; ?> /></td>
				</tr>
			</table>
		</form>
		<br>
		Available psedocodes <code>{name}</code>, <code>{token}</code>, <code>{start_date}</code>, <code>{end_date}</code> for email body.
		<br><br><br>
		<button class="button-primary" onclick="update_others()">
			<?php _e("UPDATE", "accesskey"); ?>
		</button>
	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function(){
		document.getElementById("one").click();
	})
</script>