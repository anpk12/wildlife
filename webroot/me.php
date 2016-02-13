<?php
require __DIR__.'/config_with_app.php';

/* Use my me-theme */
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
//$app->theme->setVariable('title', "Me-sida: Anton");

//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


function mdpage($filename, $leApp)
{
    $content = $leApp->fileContent->get($filename);
    $content = $leApp->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $leApp->fileContent->get('byline.md');
    $byline = $leApp->textFilter->doFilter($byline, 'shortcode, markdown');

    $leApp->views->add('me/page', ['content' => $content, 'byline' => $byline]);
}

$app->router->add('', function() use ($app)
{
    $app->theme->setTitle("Om mig");

    mdpage('anton.md', $app);
});

$app->router->add('redovisning', function() use ($app) {
    $app->theme->setTitle("Redovisning");

    mdpage('redovisning.md', $app);
    /*$content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('me/page', ['content' => $content]);*/


});

$app->router->add('source', function() use ($app)
{
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', ['content' => $source->View()]);
});

$app->router->handle();
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->render();

?>
