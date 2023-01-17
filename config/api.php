<?php

return [
	/* Api related message */
	'api_errors' => [

		1000    => [        // this is to handle laravel default exceptions
            'message'	=> 'Something went wrong'
        ],
        1001    => [        // jwt exception
            'message'	=> 'Token not found.'
        ],
        1002    => [        // jwt exception
            'message'	=> 'Token expired.'
        ],
        1003    => [        // jwt exception
            'message'	=> 'Token is invalid.'
        ],
        1004    => [        // jwt exception
            'message'	=> 'User not found.'
        ],
        1005    => [        // jwt exception
            'message'	=> 'Token blacklisted.'
        ],
        1006    => [        // login api
            'message'	=> 'Required data missing or incorrect for login.'
        ],
        1007    => [        // login api
            'message'	=> 'Invalid Email and/or Password.'
        ],
        1008    => [        // login api
            'message'	=> 'Your account has been deactivated.'
        ],
        1009    => [		// login api
            'message'	=> 'Login Unsuccessful. An error occurred while performing an action.'
        ],
        1011	=> [		// login api
            'message'	=> 'Please verify your email address to login.'
        ],
        1012    => [        // register api
            'message'	=> 'Required data missing or incorrect for registration.'
        ],
        1013	=> [		// register api
            'message'	=> 'Invalid promotional code.'
        ],
        1014	=> [		// register api
            'message'	=> 'Unable to register. Please try again.'
        ],
        1015	=> [		// register api
            'message'	=> 'Unable to register you at this moment. Kindly try after some time.'
        ],
        1016	=> [		// forgot password api
            'message'	=> 'Required data missing or incorrect for forgot password.'
        ],
        1017	=> [		// forgot password api
            'message'	=> 'No user found with the requested email address.'
        ],
        1018	=> [		// forgot password api
            'message'	=> 'Unable to process your request.'
        ],
        1019	=> [		// forgot password api
            'message'	=> 'Unable to process your request.'
        ],
        1020	=> [		// get events api
            'message'	=> 'Packages not found.'
        ],
        1021	=> [		// InvalidArgumentException
			'message'	=> 'Invalid argument sent.'
		],
		1022	=> [		// logout api
			'message'	=> 'Error occurred while performing logout.'
		],
        1023    => [        // Jwt Middleware
            'message'   => 'Your account has been deactivated.'
        ],
        1024    => [        // Jwt Middleware
            'message'   => 'Please verify your email address.'
        ],
        1025    => [        // get states api
            'message'   => 'Countries not found.'
        ],
        1026	=> [		// get states api
            'message'	=> 'States not found.'
        ],
        1027    => [        // get cities api
            'message'   => 'Cities not found.'
        ],
        1028    => [        // get menu api
            'message'   => 'Menu not found.'
        ],
		1029    => [        // get menu api
            'message'   => 'You haven\'t purchase this product yet.'
        ],
        1030    => [        // get menu api
            'message'   => 'Email address is already in use. Please try different email address.'
        ],


	]
];
