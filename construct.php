<?php
require_once 'build_config.php';
require_once 'vendor/autoload.php';

try {
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, array(
        'cache' => 'compilation_cache',
    ));

    foreach (FILES_TO_BUILD as $key => $value) {
        $template = $twig->load($key.'.tmpl');
        file_put_contents(BUILD_DIR.$value, $template->render(TEMPLATE_PARAMS));
    }
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
