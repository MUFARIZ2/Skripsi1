<?php

return [
    'aes_key' => env('VERIFIKASI_AES_KEY'),
    'scan_limit_warning' => env('VERIFIKASI_SCAN_LIMIT_WARNING', 3),
    'scan_limit_pemalsuan' => env('VERIFIKASI_SCAN_LIMIT_PEMALSUAN', 5),
];