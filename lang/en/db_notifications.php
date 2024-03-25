<?php

return [
    'subscription_payment_status' => [
        'completed' => [
            'title' =>  'Your payment has been confirmed',
            'description' =>  'Congratulations! Your subscription payment has been confirmed',
        ],
        'canceled' => [
            'title' =>  'Your payment has been canceled',
            'description' =>  'Unfortunately! Your subscription payment has been canceled',
        ],
        'on_hold' => [
            'title' =>  'Your payment has been put on hold',
            'description' =>  'You will be notified once the payment is confirmed',
        ],
        'failed' => [
            'title' =>  'Your payment has failed',
            'description' =>  'Unfortunately! Your subscription payment has failed',
        ],
        'in_review' => [
            'title' =>  'Subscription payment pending confirmation',
            'description' =>  'There is a subscription payment pending confirmation',
        ]
    ]
];
