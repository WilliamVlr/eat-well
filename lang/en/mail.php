<?php

return [
    'order_prepared' => [
        'subject' => 'Order #:order_id is being prepared',
        'greeting' => 'Hello!',
        'content' => 'Status update of Order #:order_id. 
                        Your food is being prepared right on! Please kindly wait.',
        'outro' => 'Thank you for your patience.'
    ],
    'order_delivered' => [
        'subject' => 'Order #order_id is delivered',
        'greeting' =>  'Hello!',
        'content' => 'The status of your Order #:order_id has been updated. 
                        The vendor is delivering your food. Please kindly wait.',
        'outro' => 'Thank you for your patience.'
    ],
    'order_arrived' => [
        'subject' => 'Order #:order_id has arrived', 
        'greeting' => 'Hello',
        'content' => 'Status update of Order #:order_id. Enjoy your food while it\'s hot!',
        'outro' => 'Thank you for your patience. Eat Well!'
    ],
];