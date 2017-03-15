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
	'user_welcome_title' => 'Bienvenue sur Jeffrey',
	'provider_welcome_title' => 'Bienvenue sur Jeffrey',
	'user_forgot_email_title' => ' Ton nouveau mot de passe ',
	'no_provider_found_cron_title' => 'Aucun Jeffrey Trouvé',
	'request_cancel_by_provider' => 'Demande annulée par le Jeffrey',
	'request_cancel_by_user' => 'Demande annulée par le client',
	'request_completed_invoice' => 'Demande traitée',
	'request_completed_bill' => 'Paiement accepté. Regarde la facture.',
	'new_provider_signup' => 'Nouveau Jeffrey Enregistré',


	'request_cancel_provider' => 'Le Jeffrey a annulé la demande. Désolé!',
	'request_cancel_user' => 'Le Client a annulé la demande. Désolé!',

	'provider_forgot_email_title' =>  'Ton nouveau mot de passe',

	// Push notification title and messages

	// email template 
	'cancel_sorry' => 'Désolé pour cet inconvénient',
	'find_new' => 'Trouvé',
	'need_help' => 'Besoin d\'aide',
	'search_new' => 'Nouvelle recherche',
	'visit_website' => 'Visite notre site',

	// Invoice email
	'note' => 'NOTES',
	'invoice_note'	 => 'THIS IS A COMPUTER GENERATED INVOICE AND DOES NOT REQUIRE ANY SIGNATURE. PLEASE CONTACT ADMINISTRATOR FOR MORE DETAILS.',
	'invoice' => 'FACTURE',
	'web_url'	=>env('APP_URL'),
	'description' => 'Description',
	'amount' => 'Montant',
	'base_fees' => 'Frais de bases',
	'extra_price' => 'Frais en plus',
	'other_price' => 'Autres Frais',
	'tax_price' => 'Taxes',
	'sub_total' => 'Sous-Total',
	'total' => 'Total',
	

	// Push notifications title and messages
	'cancel_by_user_title' => 'Service Annulé',
	'cancel_by_user_message' => 'Le service est annulée par le client.',
	'waiting_cancel_by_user_title' => 'Service Annulé',
	'waiting_cancel_by_user_message' => 'Le service est annulé par le client.',
	'request_completed_user_title' => 'Le client a effectué le paiement',
	'request_completed_user_message' => ' Demande terminée avec succès. ',
	'provider_rated_by_user_title' => 'Note du Client',
	'provider_rated_by_user_message' => 'Le client a noté votre service.',

	// Provider

	'cancel_by_provider_title' => 'Service Annulé',
	'cancel_by_provider_message' => 'Le service est annulé par le Jeffrey.',

	'request_accepted_title' => 'Service Accepté ',
	'request_accepted_message' => 'Le service est accepté par Jeffrey. ',

	'provider_started_title' => 'Provider Started',
	'provider_started_message' => ' Jeffrey est en route. ',

	'provider_arrived_title' => 'Provider Arrived',
	'provider_arrived_message' => ' Jeffrey est arrivé à destination. ',

	'request_started_title' => 'Provider Service Started',
	'request_started_message' => ' Jeffrey commence son service. ',

	'user_rated_by_provider_title' => 'Provider Rated',
	'user_rated_by_provider_message' => 'Jeffrey t\'as donné une note.',

	'cod_paid_confirmation_title' => ' Paiement en espèces. ',
	'cod_paid_confirmation_message' => ' Jeffrey a confirmé ton paiement. ',

	// User
	'request_complete_payment_title' => ' Service terminé. ',

	'request_complete_payment_message' => ' Ta requête est complète. Vérifie les détails de ta facture ',

	'cron_no_provider_title' => 'Aucun Jeffrey disponible pour le moment', 
	'cron_no_provider_message' => 'Aucun Jeffrey disponible pour accepter ta demande.',

	'cron_new_request_title' => 'Nouveau Service',


	//Web User
	'welcome_user'	=> 	'Bienvenue',
	'user_services'	=> 	'Services',
	'service_history'	=> 	'Historique des Services',
	'request_services'	=> 	'Book a Jeffrey',
	'fav_providers'	=> 	'Jeffrey Favoris',
	'payment_method'	=> 	'Méthode de Paiement',
	'account'	=> 	'Compte',
	'rating'	=> 	'Notes',
	'ur_fav_providers'	=> 	'Tes Jeffrey favoris',
	'fav_providers_error'	=> 	'Tu n\'as pas de Jeffrey favoris pour le moment',
	'saved_card'	=> 	'Enregistrer une carte',
	'no_cards'	=> 	'Aucune carte ajoutée pour le moment',
	'add_card'	=> 	'Ajoute une carte',
	'card_num'	=> 	'Numéro de carte',
	'expiry'	=> 	'date d\'expiration',
	'account_details'	=> 	'Details du compte',
	'remove'	=> 	'Remplacer',
	'select_image'	=> 	'Sélectionner image',
	'change'	=> 	'Changer',
	'img_upload' => 'Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+.',
	'update_profile'	=> 	'Mettre à jour le Profil',
	'change_password'	=> 	'Changer le mot de passe',
	'old_password'	=> 	'Ancien mot de passe',
	'confirm_password'	=> 	'Confirme ton mot de passe',
	'cancel'	=> 	'Supprimer',
	'default_payment'	=> 	'Méthode de paiement par défaut',
	'no_default_payment'	=> 	'Aucune méthode de paiement par défaut pour le moment',
	'request_submit'	=>	'Ta requête est postée ! Patiente quelques instants, nous cherchons un Jeffrey disponible',
	'request_cancel'	=> 'Ta demande est supprimée.',
	'request_w_cancel'	=> 'Ta demande a été supprimé',
	'payment_successful'	=> 'Paiement effectué',
	'review_thanks'	=> 'Merci d\'avoir booké ton Jeffrey.',
	'card_default_success' 	=>	'Changer la méthode de paiement par défaut',
	'card_deleted' 	=>	'Supprimé les détails de la carte',
	'unknown_error' 	=>	'Message d\'erreur inconnu, merci de ré-essayer dans quelques instants',
	'something_error' 	=>	'Quelque chose s\'est mal passé ! Merci de ré-essayer dans quelques instants',
	'fav_remove' 	=>	'Supprimer ce Jeffrey de tes favoris',
	'profile_updated' 	=>	'Ton profil a été mis à jour',
	'password_success' 	=>	'Ton mot de passe a été mis à jour. Tu pourras te connecter avec ton nouveau mot de passe lors de ta prochaine connexion.',
	'profile_save'	=>	'Profil sauvegardé',
	'password_save'	=>	'Mot de passe mis à jour',
	'location_updated'	=>	'Emplacement mis à jour !',
	'document_upload_error'	=>	'Télécharge tes documents afin de permettre à Jeffrey-services de valider ton dossier',
	'document_updated'	=>	'Tes documents ont été mis à jour',
	'document_delete'	=>	'Document supprimé ! télécharge un nouveau fichier',
	'request_accept'	=>	'Nouvel demande acceptée !',
	'request_decline'	=>	'Demande refusée.',
	'you_are'	=>	'Tu es',
	'service_comp'	=>	'Service terminé',
	'service_cancel'	=>	'Service supprimé',
	'payment_details'	=>	'Details de paiement',
	'welcome_user_msg'	=>	'Merci pour ton inscription. Profite de Jeffrey dès à présent grâce à la meilleur plateforme de mise en relation des services à la personne. Jeffrey Services analyse et valide chacun des Jeffrey disponible en ligne. Découvre nos différents services et ne l\'oublie pas : grâce à Jeffrey, tout est possible.',
	'request_now' 	=>	'Book ton Jeffrey maintenant!',


	//Web User Request
	'request'	=> 	'Book Jeffrey !',
	'waiting'	=> 	'En attente',
	'servicing'	=> 	'En service',
	'review'	=> 	'Revue des services',
	'select_service'	=> 	'Choix des services',
	'search_loc'	=> 	'Rechercher emplacement',
	'submit_req'	=> 	'Soumettre une demande',
	'req_details'	=> 	'Détail de la demande',
	'requested_time'	=> 	'Durée du service',
	'finish_time'	=> 	'Heure de fin du service',
	'provider_rating'	=> 	'Note du Jeffrey',
	'amount'	=> 	'Montant',
	'select_payment'	=> 	'Méthode de paiement',
	'select_payment_method'	=> 	'Sélectionne une méthode de paiement',
	'select_payment_mode'	=> 	'Sélectionne un mode de paiement',
	'before'	=> 	'Avant',
	'after'	=> 	'Après',
	'rate_provider'	=> 	'Note ton Jeffrey',
	'add_provider_to_fav'	=> 	'Ajoute ce Jeffrey à tes favoris',
	'submit_review'	=> 	'Poste un commentaire',
	'req_status'	=> 	'Statut de la demande',
	'provider_status'	=> 	'Statut du Jeffrey',
	'cancel_requests'	=> 	'Supprimer la demande',
	'map'	=> 	'Carte',
	'no_service'	=> 	'Historique des services vide',
	'user_mobile'	=>	'Utilisateur mobile',
	

	//Web Provider
	'overall_request'	=> 	'Nombre total de booking',
	'month_request'	=> 	'Booking accepté ce mois',
	'provider_since'	=> 	'Jeffrey depuis',
	'approval_waiting'	=> 	'Compte en attente et non approuvé',
	'ongoing'	=> 	'Booking en cours ',
	'your_history'	=> 	'Ton historique des booking',
	'services'	=> 	'Services',
	'upload'	=> 	'Télécharger',
	'select_file'	=> 	'Sélectionne un fichier',
	'added'	=> 	'Ajoute',
	'view'	=> 	'Regarde',
	'submit_documents'	=> 	'Valide tes documents',
	'update_location'	=> 	'Mise à jours de ton emplacement',
	'profile_update'	=> 	'Mise à jour du profil',
	'update_ur_location'	=> 	'Mets à jour ton emplacement !',
	'latitude'	=> 	'Latitude',
	'logitude'	=> 	'Longitude',
	'latitude'	=> 	'Latitude',
	'service_type'	=>	'Sélectionne tes services',
	'no_ongoing'	=> 'Il n\'y a pas de demande de services pour le moment !',
	'your_turn'	=>	'Attends ton tour…',
	'service_completion'	=>	'Service en cour d\'acceptation',
	'started'	=>	'J\'accepte !',
	'arrived'	=>	'Je suis arrivé',
	'before_image'	=>	'Image du lieu de l\'arrivée',
	'after_image'	=>	'Image du lieu lors du départ',
	'service_started'	=>	'Service accepté',
	'service_completed'	=>	'Service effectué',
	'rate_this_user'	=>	'Note cet utilisateur',
	'location_details'	=>	'Details de l\'emplacement',
	'started_on'	=>	'Service commencé à',
	'ended_on'	=>	'Service fini à',
	'no_request'	=>	'Aucun service trouvé',
	'provider'		=>	'Jeffrey',
	'welcome_provider' => 'Bienvenu dans la communauté de Jeffrey ! Tu vas accéder à des demandes en temps réelles et augmenter tes revenus tout en restant maître de ton temps. Choisis tes services et sois certain d\'être capable d\'effectué les tâches demandées ! Il est toujours préférable de refuser un mandat plutôt que de ne pas pouvoir y accéder une fois sur place. Enregistre toi, n\'oublie pas de payer tes charges sur tes revenus et commence au plus vite à servir tes clients !',
	'provider_change_loc' => 'Mets à jour ton emplacement et commence ton service !',
	''	=> '',

	//Web Notification
	'new_request'	=>  'Nouvelle Demande !', 
	'request_waiting'	=>	'Demande en attente',
	'request_progress'	=>	'Demande en cour…', 
	'request_complete_pending'	=>	'Your service closure is pending customer action', 
	'request_rating'	=>	'Noté !', 
	'request_completed'	=>	'Demande terminée',
	'request_cancelled'	=>	'Demande supprimée',
	'no_providers_found'	=>	'Aucun Jeffrey trouvé pour le moment', 

	'provider_none'	=>    'Aucun Jeffrey',
	'provider_accepted'	=>	'Jeffrey a accepté la demande', 
	'provider_started'	=>	'Jeffrey a commencé, il arrive', 
	'provider_arrived'	=>	'Jeffrey Arrivé !', 
	'provider_service_started'	=>	'Jeffrey commence le service', //
	'provider_service_completed'	=>	'Jeffrey a fini le service',
	'provider_rated'	=>	'Jeffrey noté !',

	//Web Registration
	'registration_form'	=>	'Enregistré depuis',
	'already_register'	=>	'Déjà enregistré? Login',
	'register'	=>	'S\'enregistrer',
	'login_form'	=>	'Formulaire de connexion',
	'password_ph'	=>	'Minimum 6 caractères',
	'login'	=>	'Login',
	'forgot_password'	=>	'Mot de passe oublié ?',
	



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
	'welcome'	=>	'Welcome to Hubert. Please sign in to your account',
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