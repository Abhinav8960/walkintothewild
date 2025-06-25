<?php

return [
    // Common Messages can be used globally
    'common' => [
        'success' => 'Success!',
        'updated' => 'Updated Successfully!',
        'not_found' => '{var} Not Found!',
        'invalid_request' => 'Invalid Request!',
        'not_in_use' => '{var} Not In Use!',
        'submitted' => '{var} Submitted Successfully!',
        'not_submitted' => '{var} Not Submitted!',
        'follow_success' => 'Followed Successfully!',
        'unfollow_success' => 'Unfollowed Successfully!',
        'follow_failed' => 'Oops! Not Followed Successfully!',
        'not_logged_in' => 'You are not logged in!',
        'expired' => '{var} Expired!',
        'rate_limit_exceeded' => 'Rate limit exceeded. Please try again later.',
        'logout_success' => 'Logged Out Successfully!',
        'logout_failed' => 'Logout Failed!',
        'not_allowed' => 'You are not allowed to perform this action!',
        'not_verified' => 'You are not verified yet! Please verify your account.',
        'not_active' => 'Your account is not active. Please contact support.',
        'not_approved' => 'Your account is not approved yet! Please wait for approval.',
        'not_verified_email' => 'Your email is not verified. Please verify your email address.',
        'mobile_verification_success' => 'Mobile Number Verified Successfully!',
        'already_verified_mobile' => 'Mobile Number Already Verified!',
        'not_verified_mobile' => 'Your mobile number is not verified. Please verify your mobile number.',
        'otp_sent' => 'OTP Sent to your mobile number. Please check your mobile.',
        'mobile_verification_required' => 'You are not allowed to perform this action until you verify your mobile number!',
        'not_verified_otp' => 'Your OTP is not verified. Please verify your OTP.',
        'not_matched_otp' => 'Your OTP is not matched. Please enter correct OTP.',
        'issue_occurred' => 'Facing some issues. Please try again later.',
        'cache_cleared' => 'Cache Cleared Successfully!',


    ],

    'authorization' => [
        'social_login' => [
            'source_not_exist' => 'The source does not exist.',
            'inactive_profile' => 'Profile is not active, contact administration!',
            'source_id_mismatch' => 'Source ID is already available in records and does not match the given ID.',
            'otp_mismatch' => 'OTP Not Matched!',
        ],
         // 'convergent_survey' => [
        //     'message_send_success' => 'Message accepted Successfully, if contact number has whatsaapp account, it will deliver soon',
        //     'message_send_failed' => 'Message Sending Failed',
        // ],
        'request_delete_account' => [
            'delete_in_90_days' => 'Your information will be deleted in the upcoming 90 days. We will miss you!',
        ],
        'deactivate_account' => [
            'deactivation_success' => 'Deactivated Successfully! We will miss you.',
            'deactivation_failed' => 'Not Deactivated Successfully!',
        ],
        
    ],

    'park' => [
        'review' => [
            'review_submitted' => 'Thanks for your review! Your review has been sent for approval.',
            'review_failed' => 'Your review has not been sent for approval.',
            'review_already_submitted' => 'Review Already Submitted!',
            
        ],
        'quote_request' => [
            'operator_restricted' => 'Operators cannot send Quote Requests!',
            'request_sent' => 'Quote Request Sent!',
            'no_verified_operators' => 'Thank you for sending the request. Unfortunately, we currently don’t have any verified operators for this park. We’re working to onboard trusted partners soon and will notify you once services become available.',
        ],
    ],

    'share_safari' => [
        'organize_safari' => [
            'operator_restricted' => 'Operators cannot create Shared Safaris!',
            'creation_success' => 'Shared Safari Created Successfully!',
            'creation_failed' => 'Shared Safari Not Created Successfully!',
        ],
        'join_unjoin_safari' => [
            'individuals_only_join' => 'Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris.',
            'individuals_only_unjoin' => 'Only individual users are allowed to unjoin a shared safari. Tour operators cannot participate in shared safaris.',
            'join_success' => 'You joined this shared safari!',
            'join_failed' => 'Not Joined!',
            'unjoin_success' => 'You unjoined this shared safari!',
            'unjoin_failed' => 'Not Unjoined!',
            'join_restricted' => 'You cannot join this safari!',

        ],
        'wishlist_unwishlist' => [
            'action_restricted' => 'You are not allowed to perform this action!',
            'wishlist_added' => 'You added the shared safari to your wishlist!',
            'wishlist_add_failed' => 'Not added the shared safari to your wishlist!',
            'wishlist_removed' => 'You removed the shared safari from your wishlist!',
            'wishlist_remove_failed' => 'Not removed the shared safari from your wishlist!',

        ],
        'comment_reply' => [
            'comment_restricted' => 'You are an operator. You cannot comment on this safari!',
            'comment_success' => 'Comment Submitted Successfully!',
            'reply_restricted' => 'You are an operator. You cannot reply to this safari!',
            'reply_success' => 'Reply Submitted Successfully!',
            'flag_restricted' => 'You cannot flag your own comment/reply!',
            'report_success' => 'Reported Successfully!',

        ],
        'update' => [
            'update_success' => 'Shared Safari Updated Successfully!',
            'update_restricted' => 'You cannot update this safari!',
            'update_failed' => 'Shared Safari Not Updated Successfully!',
            
        ],
    ],
];