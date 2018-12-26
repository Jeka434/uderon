<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'compilation_scripts');
require_once 'build_config.php';
require_once 'vendor/autoload.php';

function render_recoursevly($dir, string $dirname, $syn, $twig)
{
    if (is_array($dir)) {
        foreach ($dir as $key => $value) {
            render_recoursevly($value, $dirname.'/'.(is_array($value) ? $key : ""), $key, $twig);
        }
    } else {
        $template = $twig->load((is_string($syn) ? $syn : $dir).".tmpl");
        file_put_contents($dirname.$dir, $template->render(UDERON_CONSTANTS['TEMPLATE_PARAMS']));
    }
}

try {
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, array(
        'cache' => 'compilation_cache',
    ));

    render_recoursevly(UDERON_CONSTANTS['FILES_TO_BUILD'], UDERON_CONSTANTS['BUILD_DIR'], "", $twig);

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
