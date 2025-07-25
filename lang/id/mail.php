<?php

return [
    'order_prepared' => [
        'subject' => 'Pesanan #:order_id sedang dibuat',
        'greeting' => 'Halo!',
        'content' => 'Perubahan status Pesanan #:order_id. 
                        Makanan anda sedang dipersiapkan. Mohon kesediaannya untuk menunggu.',
        'outro' => 'Terima kasih karena telah menunggu.'
    ],
    'order_delivered' => [
        'subject' => 'Pesanan #:order_id sedang dikirim',
        'greeting' =>  'Halo!',
        'content' => 'Perubahan status Pesanan #:order_id. 
                        Vendor sedang mengirim makanan anda. Mohon kesediannya untuk menunggu',
        'outro' => 'Terima kasih karena telah menunggu.'
    ],
    'order_arrived' => [
        'subject' => 'Pesanan #:order_id telah sampai', 
        'greeting' => 'Halo!',
        'content' => 'Perubahan status Pesanan #:order_id. Selamat menikmati makanan anda!',
        'outro' => 'Terima kasih karena telah menunggu.'
    ],
];