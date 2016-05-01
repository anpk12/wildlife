<?php
//require __DIR__.'/config_with_app.php';
require __DIR__.'/config.php';

// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('form', '\Mos\HTMLForm\CForm');

$di->set('UsersController', function() use ($di)
{
    $controller = new Anpk12\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentController', function() use ($di)
{
    $controller = new Anpk12\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('db', function()
{
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
    $db->connect();
    return $db;
});

$app = new \Anax\Kernel\CAnax($di);

/* Use my grid theme */
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
//$app->theme->configure(ANAX_APP_PATH . 'config/theme.php');
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

/*$app->router->add('', function() use ($app)
{
    $app->theme->setTitle("Om mig");

    mdpage('anton.md', $app);
});*/

$app->router->add('', function() use ($app)
{
    $app->theme->setTitle("Infinite Recursion");

    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2: <i class="fa fa-camera-retro"></i> fa-camera-retro', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('<h2>Recent questions</h2><h2>Popular tags</h2><h2>Most active users</h2>', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footercol-1', 'footercol-1')
               ->addString('footercol-2', 'footercol-2')
               ->addString('footercol-3', 'footercol-3')
               ->addString('footercol-4', 'footercol-4');
});

$app->router->add('questions', function () use ($app)
{
    $app->theme->setTitle("Questions");
    $app->views->add('me/page',
                       ['content' => "<h2>Questions</h2>", 'byline' => "my byline"]);
});

$app->router->add('tags', function () use ($app)
{
    $app->theme->setTitle("Tags");
    $app->views->add('me/page',
                       ['content' => "<h2>Tags</h2>", 'byline' => "my byline"]);
});

$app->router->add('users', function () use ($app)
{
    $app->theme->setTitle("Users");
    $app->views->add('me/page',
                       ['content' => "<h2>Users</h2>", 'byline' => "my byline"]);
});

$app->router->add('about', function () use ($app)
{
    $app->theme->setTitle("About this website, and me");
    $app->views->add('me/page',
                       ['content' => "<h2>About this website</h2>", 'byline' => "my byline"]);
});

$app->router->add('redovisning', function() use ($app) {
    $app->theme->setTitle("Redovisning");

    mdpage('redovisning.md', $app);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params'     => ['flow' => 'redovisning']
    ]);
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

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params'     => ['flow' => 'guestbook']
    ]);
});

$app->router->add('guestbook2', function() use ($app)
{
    $app->theme->setTitle("Välkommen till anpk12:s andra gästbok");

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params'     => ['flow' => 'guestbook2']
    ]);
});

$app->router->add('regioner', function() use ($app)
{

    //$app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner");

    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2: <i class="fa fa-camera-retro"></i> fa-camera-retro', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footercol-1', 'footercol-1')
               ->addString('footercol-2', 'footercol-2')
               ->addString('footercol-3', 'footercol-3')
               ->addString('footercol-4', 'footercol-4');
});

$app->router->add('setup_users', function() use ($app)
{
    $app->theme->setTitle('setup users');
    $app->db->dropTableIfExists('user')->execute();

    $app->db->createTable(
        'user',
        [
            'id' => ['integer',
                     'primary key',
                     'not null',
                     'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime']
        ]
    )->execute();

    $app->db->insert('user',
                     ['acronym',
                      'email',
                      'name',
                      'password',
                      'created',
                      'active']);
    $now = gmdate('Y-m-d H:i:s');
    $app->db->execute(['admin',
                       'anpk12@student.bth.se',
                       'Administrator',
                       password_hash('admin', PASSWORD_DEFAULT),
                       $now,
                       $now]);

    $app->db->execute(['doe',
                       'doe@student.bth.se',
                       'John Doe',
                       password_hash('doe', PASSWORD_DEFAULT),
                       $now,
                       $now]);
});

$app->router->add('sysinfo', function() use ($app)
{
    $sysinfo = new Anpk12\Sysinfo\Snapshot();

    $wohoo = $sysinfo->loadavg(); // returns [0, 1, 2]
    $totmem = $sysinfo->memTotal();
    $sysReport = $sysinfo->htmlReport(false);

    $app->theme->setTitle("Sysinfo");

    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2: <i class="fa fa-camera-retro"></i> fa-camera-retro', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString($sysReport, 'main')
               //->addString("<p>$wohoo[0], $wohoo[1], $wohoo[2]</p><p>$sysinfo->memTotal(), $sysinfo->memAvailable()</p>", 'main')
               //->addString("<p>$wohoo[0], $wohoo[1], $wohoo[2]</p><p>Total memory: " . $totmem['value'] . ' ' . $totmem['unit'] . "</p>", 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1!!!', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               //->addString("$wohoo[0], $wohoo[1] and yeah: $wohoo[2]", 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footercol-1', 'footercol-1')
               ->addString('footercol-2', 'footercol-2')
               ->addString('footercol-3', 'footercol-3')
               ->addString('footercol-4', 'footercol-4');
});



$app->router->handle();
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_so.php');
$app->theme->render();

?>
