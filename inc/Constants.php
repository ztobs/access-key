<?php

namespace Inc;


/**
* 
*/
class Constants
{

	// DB metadata
	const SUB_PRODUCT_ID = '_ztobs_accesskey_product_id';
	const ACCESSKEY_METAKEY = '_ztobs_accesskey_token';
	const ADMINAPIKEY_METAKEY = '_ztobs_accesskey_adminkey';

	const TOKEN_STATUS_SUCCESS =  "_ztobs_token_status_success";
	const TOKEN_STATUS_INVALID =  "_ztobs_token_status_invalid";
	const TOKEN_STATUS_EXPIRED =  "_ztobs_token_status_expired";

	const EMAIL_SENDER_NAME =  "_ztobs_sender_name";
	const EMAIL_SENDER_EMAIL =  "_ztobs_sender_email";

	const REFRESH_TOKEN_EMAIL_SUBJECT =  "_ztobs_refreshtoken_emailsubject";
	const NEW_USER_EMAIL_SUBJECT =  "_ztobs_newuser_emailsubject";
	const RENEW_SUB_EMAIL_SUBJECT =  "_ztobs_renewsub_emailsubject";

	const REFRESH_TOKEN_EMAIL_BODY =  "_ztobs_refreshtoken_emailbody";
	const NEW_USER_EMAIL_BODY =  "_ztobs_newuser_emailbody";
	const RENEW_SUB_EMAIL_BODY =  "_ztobs_renewsub_emailbody";

	const REFRESH_TOKEN_SEND_EMAIL =  '_ztobs_refreshtoken_sendemail';
	const NEW_USER_SEND_EMAIL =  '_ztobs_newuser_sendemail';
	const RENEW_SUB_SEND_EMAIL =  '_ztobs_renewsub_sendemail';

}