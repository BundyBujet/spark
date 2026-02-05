<?php

return [
    'notification_phone' => env('ITEMS_NOTIFICATION_PHONE', ''),
    'expiring_soon_days' => (int) env('ITEMS_EXPIRING_SOON_DAYS', 7),
    'scheduler_time' => env('ITEMS_SCHEDULER_TIME', '08:00'),
];
