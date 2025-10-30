<?php

return [
    // Common Messages can be used globally
    'common' => [
        'success' => 'Success!',
        'created' => '{var} created successfully!',
        'created_failed' => 'Failed to create {var}!',
        'updated' => '{var} Updated successfully!',
        'update_failed' => '{var} not updated!',
        'update_restricted' => 'You cannot update this {var}!',
        'deleted' => '{var} Deleted successfully!',
        'delete_failed' => 'Deletion failed!',
        'delete_restricted' => 'You cannot delete this {var}!',
        'active' => '{var} Successfully Active',
        'inactive' => '{var} Successfully Inactive',
        'found' => '{var} Found!',
        'not_found' => '{var} Not Found!',
        'user_not_accessible' => 'User Not Found or User Account may be Blocked!',
        'invalid_request' => 'Invalid Request!',
        'not_in_use' => '{var} Not In Use!',
        'submitted' => '{var} Submitted successfully!',
        'not_submitted' => '{var} Not Submitted!',
        'follow_success' => 'Followed successfully!',
        'follow_restricted' => 'You cannot follow {var}!',
        'unfollow_success' => 'Unfollowed successfully!',
        'unfollow_restricted' => 'You cannot unfollow {var}!',
        'follow_failed' => 'Oops! Not followed successfully!',
        'unfollow_failed' => 'Oops! Not unfollowed successfully!',
        'not_logged_in' => 'You are not logged in!',
        'expired' => '{var} Expired!',
        'rate_limit_exceeded' => 'Rate limit exceeded. Please try again later!',
        'logout_success' => 'Logged Out successfully!',
        'logout_failed' => 'Logout Failed!',
        'not_allowed' => 'You are not allowed to perform this action!',
        'not_verified' => 'You are not verified yet! Please verify your account.',
        'not_active' => 'Your account is not active! Please contact support.',
        'not_approved' => 'Your account is not approved yet! Please wait for approval.',
        'not_verified_email' => 'Your email is not verified! Please verify your email address.',
        'mobile_verification_success' => 'Mobile Number Verified successfully!',
        'email_verification_success' => 'Email Verified successfully!',
        'already_verified_mobile' => 'Mobile Number Already Verified!',
        'not_verified_mobile' => 'Your mobile number is not verified! Please verify your mobile number.',
        'otp_sent' => 'OTP Sent to your mobile number. Please check your mobile.',
        'mobile_verification_required' => 'You are not allowed to perform this action until you verify your mobile number!',
        'not_verified_otp' => 'Your OTP is not verified. Please verify your OTP.',
        'not_matched_otp' => 'Your OTP did not match. Please enter the correct OTP.',
        'issue_occurred' => 'Facing some issues. Please try again later!',
        'phone_email_not_verified'=>'Phone or Email is Not Verified!',
        'cache_cleared' => 'Cache Cleared successfully!',

        'operator_comment_restricted' => 'You are an operator. You cannot comment!',
        'comment_success' => 'Comment submitted successfully!',
        'comment_failed' => "Comment not submitted!",
        'operator_reply_restricted' => 'You are an operator. You cannot reply!',
        'reply_success' => 'Reply submitted successfully!',
        'reply_failed' => 'Reply not submitted!',
        'flag_restricted' => 'You cannot flag your own comment/reply!',
        'flag_success' => 'Flagged successfully!',
        'report_success' => 'Reported successfully!',
        'report_failed' => 'Report submission failed!',

        'like_success' => '{var} Liked successfully!',
        'like_removed' => 'Like removed successfully!',

        'wishlist_added' => 'You added the {var} to your wishlist!',
        'wishlist_add_failed' => 'Not added the {var} to your wishlist!',
        'wishlist_removed' => 'You removed the {var} from your wishlist!',
        'wishlist_remove_failed' => 'Not removed the {var} from your wishlist!',

        'quote_restricted' => 'You cannot request a quote for your own {var}!',
        'quote_request_sent' => 'Quote request sent successfully!',
        'quote_request_failed' => 'Failed to send the quote request!',

        'rating_restricted' => 'You cannot rate yourself!',
        'thank_you_for_review' => 'Thank you for your review!',

        'about_us' => 'About Us',
        'sent_to_operator' => 'Sent to Operator {var}!',

        'registration_successful' => 'Business registered successfully!',
        'registration_failed' => 'Business registration failed!',

        'creation_success' => '{var} created successfully!',
        'creation_failed' => 'Failed to create {var}!',

        'error_occurred' => 'An error occurred while updating data!',
        'page_not_exist' => 'The requested page does not exist!',
        'forbidden_exception' => 'You do not have permission to access this page!',
        'not_operator' => 'You are not operator!',
        'send_for_approval_failed' => 'An error occurred while sending for approval!',
        'send_for_approval' => '{var} sent for approval successfully!',
        'already_send_for_approval' => '{var} already sent for approval successfully!',

        'upload_success' => 'Uploaded Successfully!',
        'upload_failed' => 'Failed to upload!',
        'try_again' => 'Please Try Again!',

        'set_success' => '{var} set successfully!',
        'set_failed' => 'Failed to set {var}!',

        'message_required' => 'Message is required!',
        'message_send' => 'Message Sent!',
        'message_not_sent' => 'Message not sent!',
        'operator_cannot_review' => 'Operator Cannot Review!',
        'technical_issue' => 'Technical Issue! Please try again later.',
        'done' => 'Done!',

        'approved_success'=>'{var} Approved successfully!',
        'rejected'=>'{var} Rejected successfully!',
        'removed' => '{var} removed successfully!',
        'added' => '{var} Added successfully!',

        'successfully' => '{var} successfully!',
        'availabe_for_draft' => '{var} available for draft!',

        'block_restricted' => 'You can not block your own account.',
        'failed' => 'Failed {var}',
        'missing_required_parameters' => 'Missing required parameters',

        'cannot_empty' => '{var} cannot be empty',
        'duration_exceed' => '{var} duration exceed',
        'approved_and_live' => '{var} approved and live successfully.',
        'failed_to' => 'Failed to {var}',
        'failed_to_approve' => 'Failed to approve {var}.',
        'publish' => '{var} Published successfully!',
        'phone_set_verified' => '{var} phone is set to verified!',
        'phone_set_not_verified' => '{var} phone is set to not verified!',
        'facing_technical_problem' => 'Facing Technical Problem',
        'not_approved_by_admin' => '{var} is not approved by admin',

        'session_destroyed' => '{var} session destroyed!',
        'fill_required_fields' => 'Please fill all required fields.',
        'missing' => '{var} is missing!',


    ],

    'authorization' => [
        'social_login' => [
            'source_not_exist' => 'The source does not exist!',
            'inactive_profile' => 'Profile is not active, contact administration!',
            'source_id_mismatch' => 'Source ID is already available in records and does not match the given ID.',
            'otp_mismatch' => 'OTP did not match!',
        ],
        // 'convergent_survey' => [
        //     'message_send_success' => 'Message accepted Successfully, if contact number has whatsaapp account, it will deliver soon',
        //     'message_send_failed' => 'Message Sending Failed',
        // ],
        'request_delete_account' => [
            'delete_in_90_days' => 'Your information will be deleted in the upcoming 90 days. We will miss you!',
        ],
        'deactivate_account' => [
            'deactivation_success' => 'Deactivated successfully! We will miss you.',
            'deactivation_failed' => 'Not Deactivated successfully!',
        ],

    ],

    'park' => [
        'review' => [
            'review_submitted' => 'Thanks for your review! Your review has been sent for approval.',
            'review_failed' => 'Your review has not been sent for approval!',
            'review_already_submitted' => 'Review Already Submitted!',

        ],
        'quote_request' => [
            'operator_restricted' => 'Operators cannot send Quote Requests!',
            'request_sent' => 'Quote Request Sent!',
            'no_verified_operators' => 'Thank you for sending the request! Unfortunately, we currently do not have any verified operators for this park. We are working to onboard trusted partners soon and will notify you once services become available.',
        ],
    ],

    'share_safari' => [
        'organize_safari' => [
            'operator_restricted' => 'Operators cannot create Shared Safaris!',
            'creation_success' => 'Shared Safari Created successfully!',
            'creation_failed' => 'Shared Safari Not Created successfully!',
        ],
        'join_unjoin_safari' => [
            'individuals_only_join' => 'Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris.',
            'individuals_only_unjoin' => 'Only individual users are allowed to unjoin a shared safari. Tour operators cannot participate in shared safaris.',
            'join_success' => 'You joined this shared safari!',
            'join_failed' => 'Not joined!',
            'unjoin_success' => 'You unjoined this shared safari!',
            'unjoin_failed' => 'Not unjoined!',
            'join_restricted' => 'You cannot join this safari!',
        ],
    ],

    'post' => [
        'create_post' => [
            'post_added' => 'Post added successfully!',
            'post_not_added' => 'Failed to add post!',
        ],
        'edit_post' => [
            'edit_restricted' => 'You cannot edit this post!',
            'edit_success' => 'Post edited successfully!',
            'edit_failed' => 'Post edit failed!',
        ]

    ],

    'sighting' => [
        'create_sighting' => [
            'sighting_added' => 'Sighting added successfully!',
            'sighting_not_added' => 'Failed to add sighting!',

        ]
    ],
    'fixed_departure' => [
        'inclusion' => [
            'fail_to_save' => 'Failed to save share safari inclusion option!',
        ]
    ],
    'package' => [
        'inclusion' => [
            'fail_to_save' => 'Failed to save package inclusion option!',
        ]
    ],
    'chat' => [
        'make_call_on_chat' => [
            'phone_unavailable_or_unverified' => 'You cannot perform this action, as phone is not available or verified for any of the chat members',
            'call_requested' => 'Call Requested!',
            'call_initiated' => 'Call initiated!',
            'call_initiation_failed' => 'Failed to initiate the call!',
            'user_number_not_verified' => 'User number is not verified!'
        ],
        'edit_message' => [
            'id_message_required' => 'Chat message ID and message are required!',
            'chat_permission_denied' => 'Chat message not found or you do not have permission to edit it.',
            'edit_time_limit' => 'You can only edit messages within 10 minutes!',
        ],
        'delete_message' => [
            'chat_permission_denied' => 'Chat message not found or you do not have permission to delete it',
            'can_not_delete' => 'You cannot delete messages!',

        ]
    ],
    'leads' => [
        'quotation' => [
            'submit' => 'Quotation Submitted Successfully!',
        ],
        'partner' => [
            'found' => 'Partner Found!',
            'not_found' => 'Partner Not Found!',
        ],
        'reminder' => [
            'added_success' => 'Reminder added successfully!',
        ],
    ],

    'payment' => [
        'payment_success' => 'Payment Successfull!',
        'pament_failed' => 'Payment Failed or Cancelled!',
        'invalid_gateway' => 'Invalid Payment Gateway selected.',

    ]
];
