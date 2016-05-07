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
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Front page'
        ],

        'questions'  => [
            'text'  => 'Questions',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'Questions'
        ],

        'tags' => [
            'text' => 'Tags',
            'url' => $this->di->get('url')->create('tags'),
            'title' => 'tags'
        ],

        'users' => [
            'text' => 'Users',
            'url' => $this->di->get('url')->create('users'),
            'title' => 'users'
        ],

        'about' => [
            'text' => 'About',
            'url' => $this->di->get('url')->create('about'),
            'title' => 'About this website and its author'
        ],

        'login' => [
            'text' => 'Log in',
            'url' => $this->di->get('url')->create('users/login'),
            'title' => 'Log in'
        ],

        'signup' => [
            'text' => 'Sign up',
            'url' => $this->di->get('url')->create('users/signup'),
            'title' => 'Sign up'
        ],

        'update' => [
            'text' => 'Edit profile',
            'url' => $this->di->get('url')->create('users/update'),
            'title' => 'Sign up'
        ],

        'regions' => [
            'text' => 'Regioner',
            'url' => $this->di->get('url')->create('regioner'),
            'title' => 'Regioner'
        ],

        'source'  => [
            'text'  => 'Source code',
            'url'   => $this->di->get('url')->create('source'),
            'title' => 'Source code for this website'
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
