<?php
//require __DIR__.'/config_with_app.php';
require __DIR__.'/config.php';

// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di)
{
    $controller = new Anpk12\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});
$app = new \Anax\Kernel\CAnax($di);

/* Use my me-theme */
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
//$app->theme->setVariable('title', "Me-sida: Anton");

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


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

    $editId = $app->request->getGet('edit', -1);

    if ( $editId == -1 )
    {
        $app->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'view',
            'params'     => ['flow' => 'redovisning']
        ]);
    } else
    {
        $app->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'presentEditForm',
            'params'     => ['flow' => 'redovisning',
                             'commentId' => $editId]
        ]);
    }
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

$app->router->add('guestbook', function() use ($app)
{
    $app->theme->setTitle("Välkommen till anpk12:s gästbok");

    $editId = $app->request->getGet('edit', -1);

    if ( $editId == -1 )
    {
        $app->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'view',
            'params'     => ['flow' => 'guestbook']
        ]);
    } else
    {
        $app->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'presentEditForm',
            'params'     => ['flow' => 'guestbook',
                             'commentId' => $editId]
        ]);
    }
});

$app->router->add('guestbook2', function() use ($app)
{
    $app->theme->setTitle("Välkommen till anpk12:s andra gästbok");

    $editId = $app->request->getGet('edit', -1);

    if ( $editId == -1 )
    {
        $app->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'view',
            'params'     => ['flow' => 'guestbook2']
        ]);
    } else
    {
        $app->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'presentEditForm',
            'params'     => ['flow' => 'guestbook2',
                             'commentId' => $editId]
        ]);
    }
});

$app->router->handle();
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->render();

?>
