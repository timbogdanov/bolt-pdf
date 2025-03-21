<?

return [
    'chrome_path' => env('BOLT_PDF_CHROME_PATH', '/usr/bin/google-chrome'),
    'timeout' => env('BOLT_PDF_TIMEOUT', 30),
    'default_options' => [
        'format' => 'A4',
        'landscape' => false,
        'printBackground' => true,
        'margin' => [
            'top' => '20mm',
            'right' => '10mm',
            'bottom' => '20mm',
            'left' => '10mm',
        ],
    ],
];