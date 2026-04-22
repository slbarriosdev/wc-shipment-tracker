👋 slbarriosdev - Let’s improve your plugin!

Thank you for submitting your plugin, "Trackora – Shipment Tracker for WooCommerce".

Our volunteer reviewers, tools, and/or AI aids identified issues in your plugin that require your attention.

We’ve pended your submission to give you a chance to review and fix these common issues.

This team handles approximately 1,500 plugin reviews each week. That's a lot. To make the most of this process, please do your part and help us help you; otherwise, your plugin won't be approved.

🤖 Please note that this message was generated using a combination of humans, algorithms, and AI in varying proportions. It may not have been reviewed by a human. All AI outputs are marked with the ✨ emoji. Pay attention to it, it's quite accurate.

Who are we?

We are a group of volunteers who help you identify common issues so that you can make your plugin more secure, compatible, reliable and compliant with the guidelines.

For consistency and better communication, your plugin review will be assigned to a single volunteer who will assist you throughout the entire review. However, response times may vary depending on how much time the volunteer is able to contribute to the team and if whether they need to consult something with the rest of the team.

The review process

A email envelope.	Please read this email in full and check each issue, as well as the links to the documentation and the provided examples. Also, search for any other similar occurrences of the same issue that are not explicitly mentioned in the email.
Make sure you understand the issues so that you can incorporate them into your existing skillset.
A plugin author fixing the issues.	If you decide to continue with the review process, you must fix any issues, test your plugin, upload a corrected version and then reply to this email.
In case of any doubt, please fix everything else and ask your questions alongside the update.
A volunteer reviewing the plugin.	Your plugin is manually checked by a volunteer who sends you the remaining identified issues in the plugin.
We will be devoting our time to reviewing your plugin, we ask that you honor this by following the instructions.
Note: Volunteers are not your QA team. They are here to help you identify and understand issues so that you can improve and maintain your plugin in the future. Fixing the issues is your responsibility.
A new review of the plugin.	If there are no further issues, the plugin will be approved 🎉
A warning.	Be brief and direct in your reply (please, avoid copy-pasting bloated AI responses, our AI is quite brief), be patient and make sure you have addressed all the issues and tested your plugin before responding.
It is disheartening to receive an updated plugin only to find that only a few issues have been resolved, or that it causes a fatal error upon activation.

When not making adequate progress in your review, it will be delayed and eventually rejected, for the sake of volunteers devoting their time and other plugin authors who correctly follow the review process.

Each volunteer can review up to 400 plugins per week, and they love to have life besides reviewing plugins, so please make things easier for us.


Understanding the Review Queue

When you reply, your plugin enters the review queue again. Fewer review cycles mean quicker approval, while multiple reviews can extend the process to weeks or months.
Tip: Carefully fix all issues and test your plugin before resubmitting to speed up approval.

This process is designed to help you improve your plugin while making the review experience faster and more efficient for everyone.


Have you read the guidelines and this plugin complies with them?

Upon submitting your plugin, you agreed and confirmed that it complies with the WordPress.org Plugin Directory Guidelines, which apply to all plugins in the directory.

Our automated tools have detected patterns that may require a closer look regarding compliance with certain guidelines. We will verify this during our manual review, but it’s best to address any potential issues beforehand. In particular, please pay attention to the following:
Plugins must not track users without explicit consent. (Guidelines 7 & 9)
Plugins are permitted to require the use of third party/external services. The service itself must provide functionality of substance and be clearly documented (what the service is and what is used for + what data is sent and when + links to privacy and service terms) in the readme file submitted with the plugin. (Guideline 6)

Please check it, and if you think everything is fine, do not worry. Our tools are very thorough and may highlight different things as potential issues.

Have you checked for common technical issues?

Please ensure that your plugin adheres to best practices, including the following:

🔴 Use wp_enqueue commands

ℹ️ Why it matters: Because of performance and compatibility, please make use of the built in functions for including static and dynamic JS and/or CSS.

🔍 Identify JS and CSS outputs: Look for any <script> or <style> HTML tags in your plugin. In the majority of cases you could enqueue them.

🛠 Fix it: Make use of the specific function for enqueue them:
Type of code	Functions
Static JS	wp_register_script(), wp_enqueue_script(), admin_enqueue_scripts()
Inline JS	wp_add_inline_script()
Static CSS	wp_register_style(), wp_enqueue_style()
Inline CSS	wp_add_inline_style()

👉 In the public pages you can enqueue them using the hook wp_enqueue_scripts().
👉 In the admin pages you can enqueue them using the hook admin_enqueue_scripts(). You can also use admin_print_scripts() and admin_print_styles().
👉 As of WordPress 6.3, you can easily pass attributes like defer or async, as of WordPress 5.7, you can pass other attributes by using functions and filters.

Example:
function tracshtr_enqueue_script() {
    wp_enqueue_script( 'tracshtr_js', plugins_url( 'inc/main.js', __FILE__ ), array(), TRACSHTR_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'tracshtr_enqueue_script' );
Your JS/CSS is now enqueued!

Possible cases from your plugin include:
templates/shortcode/tracking.php:160 <script>
templates/myaccount/tracking-info.php:76 <script>


🔴 Nonces and User Permissions Before Processing Requests

ℹ️ Why it matters: Nonces and permissions checks ensure that the request comes from a trusted source, protecting against security threats like CSRF (Cross-Site Request Forgery) attacks.
Please check the official WordPress docs on nonces and this article for details — this is a quick summary.

🔍 Spot it: Look for functions that interact with $_GET, $_POST, $_REQUEST and perform actions triggered by the user/browser that modify data or perform sensitive actions (e.g., privileged actions or data manipulation). For such actions, you should always check for a nonce.
Additionally, verify user permissions if the action is restricted to certain roles (e.g., admin, editor).
When in doubt, play it safe: always check.

🛠 Fix it
Create a nonce ( wp_nonce_field(), wp_nonce_url(), wp_create_nonce() ). If you need to pass the nonce to JavaScript you can make use of wp_localize_script()
Pass it with the request.
Check the nonce ( check_admin_referer(), check_ajax_referer(), wp_verify_nonce() ) , and permissions if applicable ( current_user_can() ) .

Example (nonce check):

function tracshtr_save_email(){
    if ( !isset( $_POST['tracshtr_nonce'] ) || !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tracshtr_nonce'] ) ), 'tracshtr_save_email_action' ) ) {
        wp_send_json_error( 'Invalid nonce.' );
    }

    if ( !current_user_can( 'edit_posts' ) ) {
        wp_send_json_error( 'Insufficient permissions.' );
    }

    if ( isset( $_POST['post_id'] ) && isset( $_POST['price'] ) ) {
        update_post_meta( absint( $_POST['post_id'] ), 'price', floatval( $_POST['price'] ) );
    }
}
add_action( 'wp_ajax_tracshtr_save_email', 'tracshtr_save_email' );
⚠️ Without nonce and permissions checks, anyone could call this AJAX endpoint and change the price data for any post - risky!


Other details

We've detected some other details that you may want to check.

## Undocumented use of a 3rd Party / external service

Plugins are permitted to require the use of third party/external services as long as they are clearly documented.

When your plugin reach out to external services, you must disclose it. This is true even if you are the one providing that service.

You are required to document it in a clear and plain language, so users are aware of: what data is sent, why, where and under which conditions.

To do this, you must update your readme file to clearly explain that your plugin relies on third party/external services, and include at least the following information for each third party/external service that this plugin uses:
What the service is and what it is used for.
What data is sent and when.
Provide links to the service's terms of service and privacy policy.
Remember, this is for your own legal protection. Use of services must be upfront and well documented. This allows users to ensure that any legal issues with data transmissions are covered.

Example:
== External services ==

This plugin connects to an API to obtain weather information, it's needed to show the weather information and forecasts in the included widget.

It sends the user's location every time the widget is loaded (If the location isn't available and/or the user hasn't given their consent, it displays a configurable default location).
This service is provided by "PRT Weather INC": terms of use, privacy policy.

🔗 Please verify that the terms and privacy links exist and they have the proper content. We will check those links in the next review.

Example(s) from your plugin:
includes/class-wcst-actions.php:137 'DPD Local'                 => 'https://apis.track.dpdlocal.co.uk/v1/track?postcode=%2$s&parcel=%1$s',
includes/class-wcst-actions.php:168 'Correos de Mexico'  => 'https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/Rastreo.aspx?num=%1$s',
includes/class-wcst-actions.php:190 'Correos Chile'  => 'https://www.correos.cl/SitePages/rastreo/rastreo.aspx?envio=%1$s',
includes/class-wcst-actions.php:120 'Urgent Cargus' => 'https://app.urgentcargus.ro/Private/Tracking.aspx?CodBara=%1$s',
includes/class-wcst-actions.php:132 'DB Schenker'         => 'http://privpakportal.schenker.nu/TrackAndTrace/packagesearch.aspx?packageId=%1$s',
includes/class-wcst-actions.php:93 'An Post' => 'https://track.anpost.ie/TrackingResults.aspx?rtt=1&items=%1$s',
... out of a total of 10 incidences.
includes/class-wcst-actions.php:73 'PPL.cz'      => 'https://www.ppl.cz/main2.aspx?cls=Package&idSearch=%1$s',



## Internationalization: Text domain does not match plugin slug.

In order to make a string translatable in your plugin you are using a set of special functions. These functions collectively are known as "gettext".

These functions have a parameter called "text domain", which is a unique identifier for retrieving translated strings.

This "text domain" must be the same as your plugin slug so that the plugin can be translated by the community using the tools provided by the directory. As for example, if this plugin slug is "trackora" the Internationalization functions should look like:
esc_html__( 'Hello', 'trackora' );

From your plugin, you have set your text domain as follows:
# This plugin is using the domain "wc-shipment-tracker" for 87 element(s).

However, the current plugin slug is this:
trackora




👉 Your next steps

This is your checklist:
Have you read the guidelines and this plugin complies with them?
Have you checked for common technical issues?
Other details

If there is something that needs to be fixed, please take your time, fix it and update your plugin files at the "Add your plugin" page, while being logged in with your account "slbarriosdev".
Please be concise and do not list the changes done — we will review the entire plugin again — but do share any clarifications or important context you want us to know.

If after checking the list and do the changes you feel that everything is right or need further clarification, please reply to this email and a volunteer will assist you.

If you believe there is a requirement you cannot accomplish and choose not to make changes, your plugin submission will be rejected after three months.

Thanks!

By taking these steps, you're helping the Plugin Review Team work more efficiently — meaning your plugin (along with the thousands of others in the queue) can be reviewed faster. 🚀 We really appreciate your contribution!

Disclaimers

If, at any time during the review process, you wish to change your permalink (aka the plugin slug) "trackora", you must explicitly and clearly tell us what you would like it to be. Just changing it in your code and in the display name is not sufficient. Remember, permalinks cannot be altered after approval.
This email was partially auto-generated, so please be aware that some information might not be entirely accurate. No personal data was shared with the AI during this process. If you notice any obvious errors or something seems off, feel free to reply — we’ll be happy to take a closer look and readjust this automation.

Review ID: AUTOPREREVIEW trackora/slbarriosdev/21Apr26/T1 21Apr26/3.9 (P0TDX301001HGN)


--
WordPress Plugins Team | plugins@wordpress.org
https://make.wordpress.org/plugins/
https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/
https://wordpress.org/plugins/plugin-check/
{#HS:3298328170-1031407#} 