<?php
define('UDERON_CONSTANTS', array(
    'FILES_TO_BUILD' => array(
        'html' => array(
            'error' => array(
                'error.php' => 'index.php',
            ),
            'index.php',
            'list.php',
            'login.php',
            'slist.php',
        ),
        'php' => array(
            'pidcheck' => array(
                'admin.php',
                'found.php',
                'notfound.php',
            ),
        ),
    ),
    'TEMPLATE_PARAMS' => array(
        'css_version' => 1.41,
    ),
    'BUILD_DIR' => 'uderon.com',
));
