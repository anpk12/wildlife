<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Om mig',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Om mig'
        ],

        'assignment'  => [
            'text'  => 'Redovisning',
            'url'   => $this->di->get('url')->create('redovisning'),
            'title' => 'Redovisning'
        ],

        'guestbook' => [
            'text' => 'Gästbok',
            'url' => $this->di->get('url')->create('guestbook'),
            'title' => 'Gästbok'
        ],

        'guestbook2' => [
            'text' => 'Gästbok 2',
            'url' => $this->di->get('url')->create('guestbook2'),
            'title' => 'Gästbok 2'
        ],

        'regions' => [
            'text' => 'Regioner',
            'url' => $this->di->get('url')->create('regioner'),
            'title' => 'Regioner'
        ],

        'users' => [
            'text' => 'UsersController',
            'url' => $this->di->get('url')->create('users'),
            'title' => 'Testsida för UsersController'
        ],

        'source'  => [
            'text'  => 'Källkod',
            'url'   => $this->di->get('url')->create('source'),
            'title' => 'Källkod för kursmomentet'
        ],
    ],

    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
