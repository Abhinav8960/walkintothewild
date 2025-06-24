<?php

return [
    // Common Messages can be used as globally
    'common' => [
        'succ' => 'Success!!',
        'udsc' => 'Updated Succesfully!!',
        'nof' => '{var} Not Found!!',
        'invalid_req' => 'Invalid Request!!',
        'notinuse' => '{var} Not In Use',
        'submit' => '{var} Submitted Successfully!!',
        'not_submit' => '{var} Not Submitted!',
        'followed' => 'Follow Successfully!!',
        'unfollowed' => 'Unfollow Successfully!!',
        'not_followed' => 'Oops! Not Follow Successfully!!',
        'not_login' => 'You are not logged in!!',
        'exp' => '{var} Expired!!',

    ],
    //
    'authrization' => [
        'social_login' => [
            'no_source' => 'The source not exist.',
            'inactive_user' => 'Profile is not active, contact administration!!',
            'incorrect_social_login' => 'Source id is already available in records and not matching with given',
            'unmatched_otp' => 'Otp Not matched',
            'logout' => 'Logged Out Successfully',
        ],
        'convergent_survey' => [
            'message_send' => 'Message accepted Successfully, if contact number has whatsaapp account, it will deliver soon',
            'message_failed' => 'Message Sending Failed',
        ],
        'mobile_verification' => [
            'otp_sent' => 'Otp Sent on your mobile no, please check your mobile.',
            'mobile_already_verified' => 'Mobile No aleady Verified',
            'mobile_not_verified' => 'Mobile No  not verified, check mobile no and otp.',
            'rate_limit' => 'Rate limit exceeded. Please try again later.',
            'success' => 'Mobile No Verified Successfully',
        ],
        'request_delete_account' => [
            'delete_request' => 'Your Information Will be deleted in upcoming 90 Days!!!, we will miss you.',
            'facing_issue' => 'Facing some issue, please try again after a while.',
        ],
        'deactivate_account' => [
            'deactivate' => 'Deactivated Successfully, we will miss you.',
            'not_deactivate' => 'Not Deactivated Successfully',
        ],
        'clear_cache' => [
            'success' => 'Cache Cleared Successfully',
        ]
    ],

    'park' => [
        'review' => [
            'review_sent' => "Thanks for Review! Your review sent for approval",
            'review_not_sent' =>  "Your review not sent for approval",
            'review_already' =>  "Review Already submitted",
        ],
        'quoterequest' => [
            'not_allowed' => "You are not allow do peform this action untill you verify mobile no!",
            'cant_send_req' => "Operator Can't do Quote Request!!!",
            'quote_req_sent' => "Quote request sent!!!",
            'zero_count_verified_operator' => "Thank you for sending the request. Unfortunately, we currently don’t have any verified operators for this park. We’re working to onboard trusted partners soon and will notify you once services become available."
        ]
    ],

    'sharesafari' => [
        'orgainze_safari' => [
            'not_allowed_until_verification' => "You are not allow do peform this action untill you verify mobile no!",
            'can_not_create' => "Operator can not create Shared safari!",
            'safari_created' => "Shared safari created successfully",
            'safari_not_created' => "Shared safari not created successfully",
        ],
        'join_unjoin_safari' => [
            'allowed_to_join' => "Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris.",
            'allowed_to_unjoin' => "Only individual users are allowed to unjoin a shared safari. Tour operators cannot participate in shared safaris.",
            'joined' => "You joined this shared safari!",
            'not_joined' => "Not Joined!",
            'unjoined' => "You unjoined this shared safari!",
            'not_unjoined' => "Not unjoined!",
            'can_not_join' => "You can not join this safari!!!",
        ],
        'wishlist_unwishlist' => [
            'not_allowed' => "You are not allowed to perform this!!!",
            'added_to_wishlist' => "You added share safari to wishlist!",
            'not_added_to_wishist' => "Not added share safari to wishlist!",
            'removed_from_wishlist' => "You removed share safari from wishlist!",
            'not_removed_from_wishlist' => "Not removed share safari from wishlist!",

        ],
        'comment_reply' => [
            'can_not_comment' => "You are Operator You can't comment on this safari!!!",
            'commented' => "Comment Successfully!",
            'can_not_reply' => "You are Operator You can't reply on this safari!!!",
            'replied' => "Reply submitted Successfully!",
            'can_not_flag' => "You cannot flag your comment/reply yourself!!!",
            'reported' => "Reported successfully!",
        ],
        'update' => [
            'updated' => "Shared safari updated successfully",
            'can_not_updated' => "You cannot Update this safari!!!",
            'not_updated' => "Shared safari not updated successfully",

        ]
    ]
];
