## Access API Key Tool for Woocommerce Subscriptions

This is a wordpress plugin that uses woocommerce subscription plugin to generate user tokens for your customer and allows third party apps to query the status of your customers token if its valid, expired or invalid



---

## Usage



1. Setup wordpress
2. Setup woocommerce
3. Setup woocommerce subscriptions
4. Create subscription product
5. Install Access Key Tools
6. Configure on email templates and others in "Other Settings" tab
7. When subscription orders are made, the user token will only be generated when the order status has been changed to completed.
8. You can add the user token shortcode to subscriber's account page \[accesskey_user_token\]
9. API endpoint can be found in the settings, its similar to this http://yoursite/wp-json/accesskey/v1/validate/key/{subscriber_token}
10. Dont forget to add "Accesskey-Auth:Bearer {admin_api_key}" to header of API request

---

## Requirements

Here are the requirements to get the plugin working

1. Wordpress version 3.0 and above
2. [Woocommerce subscriptions](https://github.com/wp-premium/woocommerce-subscriptions/) tested on v2.2.18



---

## Issue

If you have any issue, dont forget to submit it. Or send an email to ztobscieng@gmail.com


---

## Donations   

If the plugin works for you can buy me a bear.
Or sponsor my projects to get other free stuffs from me.

Bitcoin: 1HNBcGmE3LfPwoe7TUfbtqcopmRza1nmGg

Payoneer: ztobscieng@gmail.com
