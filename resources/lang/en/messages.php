<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Messages Language Keys
	|--------------------------------------------------------------------------
	|
	|	This is the master keyword file. Any new keyword added to the website
	|	should go here first.
	| 
	|
	*/

	'test'	=> 'test',
	// mail title configure
	'user_welcome_title' => 'Welcome to XUBER',
	'provider_welcome_title' => 'Welcome to XUBER',
	'user_forgot_email_title' => "Your new password",
	'no_provider_found_cron_title' => 'No providers found',
	'request_cancel_by_provider' => 'Request cancelled by provider',
	'request_cancel_by_user' => 'Request cancelled by user',
	'request_completed_invoice' => 'Request Completed',
	'request_completed_bill' => 'Request Payment is done.Check the invoice.',
	'new_provider_signup' => 'New provider registered',


	'request_cancel_provider' => 'Provider cancelled the request.Sorry!',
	'request_cancel_user' => 'User cancelled the request.Sorry!',

	'provider_forgot_email_title' =>  'Your new password',

	// Push notification title and messages

	// email template 
	'cancel_sorry' => 'Sorry for the inconvenience',
	'find_new' => 'Find New',
	'need_help' => 'Need Help',
	'search_new' => 'Search New',
	'visit_website' => 'Visit Website',

	// Invoice email
	'note' => 'NOTES',
	'invoice_note'	 => 'THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE ANY SIGNATURE. PLEASE CONTACT ADMINISTRATOR FOR MORE DETAILS.',
	'invoice' => 'INVOICE',
	'web_url'	=>env('APP_URL'),
	'description' => 'Description',
	'amount' => 'Amount',
	'base_fees' => 'Base Fees',
	'extra_price' => 'Extra Fees',
	'other_price' => 'Other Fees',
	'tax_price' => 'Tax Fees',
	'sub_total' => 'Sub Total',
	'total' => 'Total',
	

	// Push notifications title and messages
	'cancel_by_user_title' => 'Service Cancelled',
	'cancel_by_user_message' => 'The service is cancelled by user.',
	'waiting_cancel_by_user_title' => 'Service Cancelled',
	'waiting_cancel_by_user_message' => 'The service is cancelled by user.',
	'request_completed_user_title' => "User done the Payment",
	'request_completed_user_message' => "Request Completed successfully.",
	'provider_rated_by_user_title' => 'User Rated',
	'provider_rated_by_user_message' => 'The user rated your service.',

	// Provider

	'cancel_by_provider_title' => 'Service Cancelled',
	'cancel_by_provider_message' => 'The service is cancelled by provider.',

	'request_accepted_title' => "Service Accepted",
	'request_accepted_message' => "The Service is accepted by provider.",

	'provider_started_title' => "Provider Started",
	'provider_started_message' => "Provider started from location.",

	'provider_arrived_title' => "Provider Arrived",
	'provider_arrived_message' => "Provider arrived to your location.",

	'request_started_title' => "Provider Service Started",
	'request_started_message' => "The Service is started.",

	'user_rated_by_provider_title' => 'Provider Rated',
	'user_rated_by_provider_message' => 'The provider rated your service.',

	'cod_paid_confirmation_title' => "Provider confirmed COD payment.",
	'cod_paid_confirmation_message' => "Provider confirmed your COD payment.",

	// User
	'request_complete_payment_title' => "Your Request is completed.Please check the invoice details",

	'cron_no_provider_title' => 'No Provider Available', 
	'cron_no_provider_message' => 'No provider available to take the service.',

	'cron_new_request_title' => 'New Service',


	//Web User
	'welcome_user'	=> 	'Welcome',
	'user_services'	=> 	'Services',
	'service_history'	=> 	'Service History',
	'request_services'	=> 	'Book A Service',
	'fav_providers'	=> 	'Favorite Providers',
	'payment_method'	=> 	'Payment Method',
	'account'	=> 	'Account',
	'rating'	=> 	'Rating',
	'ur_fav_providers'	=> 	'Your Favorite Providers',
	'fav_providers_error'	=> 	'You haven\'t made any provider as favorite!',
	'saved_card'	=> 	'Saved Cards',
	'no_cards'	=> 	'No Cards Added',
	'add_card'	=> 	'Add Card',
	'card_num'	=> 	'Card Number',
	'expiry'	=> 	'Expiry',
	'account_details'	=> 	'Account Details',
	'remove'	=> 	'Remove',
	'select_image'	=> 	'Select Image',
	'change'	=> 	'Change',
	'img_upload' => 'Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+.',
	'update_profile'	=> 	'Update Profile',
	'change_password'	=> 	'Change Password',
	'old_password'	=> 	'Old Password',
	'confirm_password'	=> 	'Confirm Password',
	'cancel'	=> 	'Cancel',
	'default_payment'	=> 	'Default Payment Method',
	'no_default_payment'	=> 	'No default Payment Methods enabled',
	'request_submit'	=>	'Your request has been posted. Waiting for provider to respond',
	'request_cancel'	=> 'Your request has been cancelled.',
	'request_w_cancel'	=> 'Request was Canecelled',
	'payment_successful'	=> 'Payment Successful',
	'review_thanks'	=> 'Thank you for reviewing the provider.',
	'card_default_success' 	=>	'changed default payment method',
	'card_deleted' 	=>	'Deleted card details',
	'unknown_error' 	=>	'Unknown error please try again later',
	'something_error' 	=>	'Something went wrong! please try again later',
	'fav_remove' 	=>	'Removed Provider from Favorites',
	'profile_updated' 	=>	'Profile has been updated',
	'password_success' 	=>	'Password has been updated. You can log in with the new password from next time.',
	'profile_save'	=>	'Profile has been saved',
	'password_save'	=>	'Password Updated',
	'location_updated'	=>	'Location Updated',
	'document_upload_error'	=>	'Please upload your document to get approve from admin',
	'document_updated'	=>	'Your Documents Updated',
	'document_delete'	=>	'Your document Deleted! and please upload your new document',
	'request_accept'	=>	'New Request Accepted',
	'request_decline'	=>	'Request Declined!',
	'you_are'	=>	'You are',
	'service_comp'	=>	'Service Completed',
	'service_cancel'	=>	'Service Cancelled',
	'payment_details'	=>	'Payment Details',
	'welcome_user_msg'	=>	'Thank you for signing up. Enjoy fast on-demand services from the best verified and validated service providers from your own neighborhood. Check out the list of best services we provide and enjoy your Xuber experience.',
	'request_now' 	=>	'Request A Service Now!',


	//Web User Request
	'request'	=> 	'Request',
	'waiting'	=> 	'Waiting',
	'servicing'	=> 	'Servicing',
	'review'	=> 	'Review',
	'select_service'	=> 	'Select Service Type',
	'search_loc'	=> 	'Search Location',
	'submit_req'	=> 	'Submit Request',
	'req_details'	=> 	'Request Details',
	'requested_time'	=> 	'Requested Time',
	'finish_time'	=> 	'Finish Time',
	'provider_rating'	=> 	'Provider Rating',
	'amount'	=> 	'Amount',
	'select_payment'	=> 	'Select Payment Option',
	'select_payment_method'	=> 	'Select Payment Method',
	'select_payment_mode'	=> 	'Select Payment Mode',
	'before'	=> 	'Before',
	'after'	=> 	'After',
	'rate_provider'	=> 	'Rate your Provider',
	'add_provider_to_fav'	=> 	'Add Provider to Favorite',
	'submit_review'	=> 	'Submit Feedback',
	'req_status'	=> 	'Request Status',
	'provider_status'	=> 	'Provider Status',
	'cancel_requests'	=> 	'Cancel Request',
	'map'	=> 	'Map',
	'no_service'	=> 	'No Service History',
	'user_mobile'	=>	'User Mobile',
	

	//Web Provider
	'overall_request'	=> 	'Overall Request Count',
	'month_request'	=> 	'Request Accepted by month',
	'provider_since'	=> 	'Provider Since',
	'approval_waiting'	=> 	'Waiting for Approval',
	'ongoing'	=> 	'Ongoing Services',
	'your_history'	=> 	'Your Service History',
	'services'	=> 	'Services',
	'upload'	=> 	'Upload',
	'select_file'	=> 	'Select File',
	'added'	=> 	'Added',
	'view'	=> 	'View',
	'submit_documents'	=> 	'Submit Documents',
	'update_location'	=> 	'Update Location',
	'profile_update'	=> 	'Profile Update',
	'update_ur_location'	=> 	'Update Your Location',
	'latitude'	=> 	'Latitude',
	'logitude'	=> 	'Longitude',
	'latitude'	=> 	'Latitude',
	'service_type'	=>	'Service Type',
	'no_ongoing'	=> 'There is no Ongoing Requests Right Now!',
	'your_turn'	=>	'Please Wait for your turn!',
	'service_completion'	=>	'Service Completion Status',
	'started'	=>	'Started',
	'arrived'	=>	'Arrived',
	'before_image'	=>	'Before Image',
	'after_image'	=>	'After Image',
	'service_started'	=>	'Service Started',
	'service_completed'	=>	'Service Completed',
	'rate_this_user'	=>	'Rate This User',
	'location_details'	=>	'Location Details',
	'started_on'	=>	'Service Started on',
	'ended_on'	=>	'Service Ended on',
	'no_request'	=>	'No Request found',
	'provider'		=>	'Provider',
	'welcome_provider' => 'Open up new and exciting opportunities for your business. Select your service, verify credentials with admin and you\'re set for unlimited business requests on-demand from our very own userbase. Sign up, gear up and Serve your customers now!',
	'provider_change_loc' => 'Update Your Location & Start Your Service',
	''	=> '',

	//Web Notification
	'new_request'	=>  'New Request', 
	'request_waiting'	=>	'Request Waiting',
	'request_progress'	=>	'Request In Progress', 
	'request_complete_pending'	=>	'Your service closure is pending customer action', 
	'request_rating'	=>	'Request Rating', 
	'request_completed'	=>	'Request Completed',
	'request_cancelled'	=>	'Request Cancelled',
	'no_providers_found'	=>	'No Providers are Found', 

	'provider_none'	=>    'Provider None',
	'provider_accepted'	=>	'Provider Accepted', 
	'provider_started'	=>	'Provider Started', 
	'provider_arrived'	=>	'Provider Arrived', 
	'provider_service_started'	=>	'Provider Service Started', //
	'provider_service_completed'	=>	'Provider Service Completed',
	'provider_rated'	=>	'Provider Rated',

	//Web Registration
	'registration_form'	=>	'Registration Form',
	'already_register'	=>	'Already Registered? Login',
	'register'	=>	'Register',
	'login_form'	=>	'Login Form',
	'password_ph'	=>	'Atleast 6 letters',
	'login'	=>	'Login',
	'forgot_password'	=>	'Forgot Password?',
	



//Admin General
	'dashboard'	=> 	'Dashboard',
	'users' 	=>	'Users',
	'currency' 	=>	'Currency',
	'view_users'	=>	'View Users',
	'add_users'	=>	'Add Users',
	'providers'	=>	'Providers',
	'view_providers'	=>	'View Providers',
	'add_providers'	=>	'Add Providers',
	'service_types'	=>	'Service Types',
	'view_service'	=>	'View Service Types',
	'add_service'	=>	'Add Service Types',
	'requests'	=>	'Requests',
	'user_map_view'	=>	'User Map View',
	'provider_map_view'	=>	'Provider Map View',
	'documents'	=>	'Documents',
	'view_documents'	=>	'View Document Type',
	'add_documents'	=>	'Add Document Type',
	'rating_review'	=>	'Rating & Reviews',
	'user_review'	=>	'User Reviews',
	'provider_review'	=>	'Provider Reviews',
	'payment_history'	=>	'Payment History',
	'logout'	=>	'Logout',
	'settings'	=>	'Settings',
	'profile'	=>	'Profile',
	'help'	=>	'Help',
	'id'	=>	'ID',
	'on_off'	=>	'ON / OFF',
	'full_name'	=>	'Full Name',
	'email'	=>	'Email',
	'phone'	=>	'Phone',
	'gender'	=>	'Gender',
	'picture'	=>	'Picture',
	'action'	=>	'Action',
	'delete'	=>	'Delete',
	'select'	=>	'Select',
	'view_history'	=>	'View History',
	'edit'	=> 	'Edit',
	'delete_confirmation'	=> 'Are you sure want to Delete?',
	'first_name'	=>	'First Name',
	'last_name'	=>	'Last Name',
	'male'	=>	'Male',
	'female'	=>	'Female',
	'others'	=>	'Others',
	'contact_num'	=>	'Contact Number',
	'address'	=>	'Address',
	'profile_pic'	=>	'Profile Picture',
	'upload_message'	=>	'Upload only .png, .jpg or .jpeg image files only',
	'status'	=>	'Status',
	'yes'	=>	'Yes',
	'copyright'	=>	'Copyright',
	'copyright_message' => 'All rights reserved',
	'paypal_email'	=>	'Paypal Email',
	'home'	=>	'Home',
	'name'	=>	'Name',
	'default'	=>	'Default',
	'default_lang'	=>	'Default Language',
	'payment_setting'	=>	'Payment Settings',

	//Admin Notifications
	'admin_not_profile'	=>	'Admin Details updated Successfully',
	'admin_not_error'	=>	'Something Went Wrong, Try Again!',
	'admin_not_user'	=>	'User updated Successfully',
	'admin_not_user_del'	=>	'User deleted successfully',
	'admin_not_provider'	=>	'Provider updated Successfully',
	'admin_not_provider_approve'	=>	'Provider Approved Successfully',
	'admin_not_provider_decline'	=>	'Provider Unapproved Successfully',
	'admin_not_provider_del'	=>	'Provider deleted Successfully',
	'admin_not_doc'	=>	'Document created Successfully',
	'admin_not_doc_updated'	=>	'Document updated Successfully',
	'admin_not_doc_del'	=>	'Document deleted Successfully',
	'admin_not_st'	=>	'Service Type created Successfully',
	'admin_not_st_updated'	=>	'Service Type updated Successfully',
	'admin_not_st_del'	=>	'Service Type deleted Successfully',
	'admin_not_ur_del'	=>	'User Review deleted Successfully',
	'admin_not_pr_del'	=>	'Provider Review deleted Successfully',




	//Admin Login
	'welcome'	=>	'Welcome to Xuber. Please sign in to your account',
	'email_add'	=>	'E-mail Address',
	'password'	=>	'Password',
	'login'	=>	'Login',
	'forgot'	=>	'Forgot Your Password?',
	'remember'	=>	'Remember Me',
	'password_reset_msg'	=>	'Enter a new password and log in to your account',
	'password_reset_email'	=>	'Lost your password? Please enter your email address. You will receive a link to create a new password.',
	'password_reset_button'	=>	'Reset Password',
	
	//Admin Dashboard

	'total_request'	=>	'Total Requests',
	'comp_request'	=>	'Completed Requests',
	'cancel_request'	=>	'Cancelled Requests',
	'total_payment'	=>	'Total Payment',
	'card_payment'	=>	'Stripe Payment',
	'cash_payment'	=>	'Cash Payment',
	'paypal_payment'	=>	'Paypal Payment',
	'top_provider'	=>	'Top Rated Provider',
	'tot_revenue'	=>	'Total Revenue',
	'avg_review'	=>	'Average Reviews',
	'avg_rating'	=>	'Average Rating',
	'available'	=>	'Available',
	'n_a'	=>	'N/A',
	'recent_reviews'	=>	'Recent User Reviews',
	'from'	=>	'From',
	'to'	=>	'To',
	'chat_history'	=>	'Chat History',

	//Admin Button
	'submit'	=>	'Submit',
	

	//Admin Users
	'view_photo'	=>	'View Photo',
	'user_list'	=>	'Users List',
	'create_user'	=>	'Create New User',
	'edit_user'	=>	'Edit User',

	//Admin Providers
	'accepted_requests'	=>	'Accepted Requests',
	'availability'	=>	'Availability',
	'approve'	=>	'Approve',
	'decline'	=>	'Decline',
	'view_docs'	=>	'View Documents',
	'approved'	=>	'Approved',
	'unapproved'	=>	'Unapproved',
	'provider_list'	=>	'Providers List',
	'create_provider'	=>	'Create Provider',
	'edit_provider'	=>	'Edit Provider',

	//Admin Service Types
	'service_list'	=>	'Service Types List',
	'service_name'	=>	'Service Type Name',
	'set_default'	=>	'Set as Default',
	'create_service'	=>	'Create Service Type',
	'edit_service'	=>	'Edit Service Type',

	//Admin Documents
	'document_list'	=>	'Documents List',
	'edit_document'	=>	'Edit Document Type',
	'create_document'	=>	'Create New Document Type',
	'document_name'	=>	'Document Name',
	''	=>	'',

	//Admin Reviews
	'user_name'	=>	'User Name',
	'provider_name'	=>	'Provider Name',
	'rating'	=>	'Rating',
	'date_time'	=>	'Date & Time',
	'comments'	=>	'Comments',

	//Admin Payment
	'base_price'	=>	'Base Price',
	'time_price'	=>	'Time Price',
	'total_time'	=>	'Total Time',
	'tax_price'	=>	'Tax Price',
	'total_amount'	=>	'Total Amount',
	'payment_mode'	=>	'Payment Mode',
	'payment_status'	=>	'Payment Status',
	'payment'	=>	'Payment',
	'request_id'	=>	'Request Id',
	'transaction_id'	=>	'Transaction Id',
	'paid'	=>	'Paid',
	'not_paid'	=>	'Not Paid',

	//Admin Settings

	'site_name'	=>	'Site Name',
	'site_logo'	=>	'Site Logo',
	'email_logo'	=>	'Email Logo',
	'site_icon'	=>	'Site Favicon',
	'price_per_min'	=>	'Price Per Minute',
	'provider_time'	=>	'Provider Timout',
	'search_radius'	=>	'Search Radius',
	'stripe_secret'	=>	'Stripe Secret key',
	'stripe_publish'	=>	'Stripe Publishable Key',
	'card'	=>	'Stripe',
	'cod'	=>	'Cash on Delivery',
	'paypal'	=>	'Paypal',
	'manual_request'	=>	'Manual Request',

	//Admin Request

	'booked_by'	=>	'Booked by',
	'request_started'	=>	'Request Started',
	'request_ended'	=>	'Request Ended',
	'before_service'	=>	'Before Service',
	'after_service'	=>	'After Service',
	'admin_profile'	=>	'Admin Profile',
	'provider_cap'	=>	'PROVIDER',
	'user_cap'	=>	'USER',
	'chat_history_delete'	=>	'Chat History Deleted Successfully',
	'no_chat'	=>	'No Chat History Found',

);