<?php
return [
    'adminEmail' => 'admin@example.com',
    
    'maxFileSize' => 1024 * 1024 * 2,   // 2 megabytes
    'storagePath' => '@frontend/web/uploads/',
    'storageUri' => '/uploads/',    // example: http://images.com/uploads/f1/d7/739f9a9c9a99294.jpg
    
    'postPicture' => [
        'maxWidth' => 940,
        'maxHeight' => 705,
    ],
    
    'feedPostLimit' => 200,
];
