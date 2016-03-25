<?php
namespace Anpk12\Users;

// For users and admin related events
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->users = new \Anpk12\Users\User();
        $this->users->setDI($this->di);
    }

    private function showAvailableActions()
    {
        $users = $this->users->findAll();
        $this->di->views->add(
            'users/index',
            ['title' => 'Available actions in UsersController',
             'users' => $users]);
    }

    public function indexAction()
    {
        $this->theme->setTitle('Available actions in UsersController');
        $this->showAvailableActions();
    }

    public function addformAction()
    {
        $this->session();
        $this->theme->setTitle("Users indexAction");

        $form = $this->di->form->create([], [
            'name' => [
                'type'  => 'text',
                'label' => 'Name:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'acronym' => [
                'type'  => 'text',
                'label' => 'Acronym:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'email' => [
                'type'  => 'text',
                'label' => 'Email:',
                'required' => true,
                'validation' => ['not_empty', 'email_adress'],
            ],
            
            'submit' => [
                'type' => 'submit',
                 'callback' => [$this, 'onSubmit']
            ],
        ]);

        $form->check([$this, 'onSuccess'], [$this, 'onFail']);
        $this->di->views->add('default/page', [
            'title' => "Add a user",
            'content' => $form->getHTML()
        ]);
        $this->showAvailableActions();
    }

    public function onSubmit($form)
    {
        $now = gmdate('Y-m-d H:i:s');

        $res = $this->users->save([
            'acronym' => $form->Value('acronym'),
            'email ' => $form->Value('email'),
            'name' => $form->Value('name'),
            'password' => password_hash($form->Value('acronym'), PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now
        ]);
        // $form->saveInSession = true ??
        
        return $res;
    }

    public function onSuccess($form)
    {
        $form->AddOutput("<p>New user successfully added</p>");
        $url = $this->url->create('users/id/' . $this->users->id);
        $this->response->redirect($url);
    }

    public function onFail($form)
    {

    }

    ///////////////////////////////////////////////////////////////////////

    public function listAction()
    {
        $all = $this->users->findAll();

        $this->theme->setTitle("List all users");
        $this->views->add('users/list-all',
                          ['users' => $all,
                           'title' => "View all users"]);
        $this->showAvailableActions();
    }

    public function activeAction()
    {
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("Active users only");
        $this->views->add('users/list-all',
                          ['users' => $all,
                           'title' => "Users that are active"]);
        $this->showAvailableActions();
    }

    // Show users that are inactive but not deleted
    // (my interpretation of requirement 6).
    public function inactiveAction()
    {
        $all = $this->users->query()
            ->where('active IS NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("Inactive users");
        $this->views->add('users/list-all',
                          ['users' => $all,
                           'title' => "Users that are inactive"]);
        $this->showAvailableActions();
    }

    public function deletedAction()
    {
        $all = $this->users->query()
            ->where('deleted IS NOT NULL')
            ->execute();
        $this->theme->setTitle("Soft-deleted users only");
        $this->views->add('users/list-all',
                          ['users' => $all,
                           'title' => "Deleted users"]);
        $this->showAvailableActions();
    }

    public function idAction($id = null)
    {
        $user = $this->users->find($id);
        
        $this->theme->setTitle("View user with id");
        $this->views->add('users/view',
                          ['user' => $user]);
        $this->showAvailableActions();
    }

    public function addAcronymAction($acronym = null)
    {
        if (!isset($acronym))
        {
            die("Missing acronym");
        }

        $now = gmdate('Y-m-d H:i:s');

        $this->users->save([
            'acronym' => $acronym,
            'email ' => $acronym . '@mail.name',
            'name' => 'Mr/Mrs ' . $acronym,
            'password' => password_hash($acronym, PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now
        ]);

        $url = $this->url->create('users/id/' . $this->users->id);
        $this->response->redirect($url);
    }

    public function deleteAction($id = null)
    {
        if ( !isset($id) )
        {
            die("Missing id");
        }

        $res = $this->users->delete($id);

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    public function softDeleteAction($id = null)
    {
        if ( !isset($id) )
        {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');
        $user = $this->users->find($id);

        $user->deleted = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }

    public function undeleteAction($id = null)
    {
        if ( !isset($id ) ) { die("Missing id"); }

        $user = $this->users->find($id);

        $user->deleted = null;
        $user->save();

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    public function activateAction($id = null)
    {
        if ( !isset($id ) ) { die("Missing id"); }

        $user = $this->users->find($id);

        $user->active = gmdate('Y-m-d H:i:s');
        $user->save();

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    public function deactivateAction($id = null)
    {
        if ( !isset($id ) ) { die("Missing id"); }

        $user = $this->users->find($id);

        $user->active = null;
        $user->save();

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    public function updateAction($id = null)
    {
        // TODO implement
        throw new Exception("updateAction not implemented");
    }
}

?>
