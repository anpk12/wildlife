<?php

namespace Anpk12\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    public function initialize()
    {
        $this->comments = new \Anpk12\Comment\Comment();
        $this->comments->setDI($this->di);
    }

    public function setupAction()
    {
        $this->theme->setTitle('setup users');
        $this->db->dropTableIfExists('comment')->execute();

        $this->db->createTable(
            'comment',
            [
                'id' => ['integer',
                         'primary key',
                         'not null',
                         'auto_increment'],
                'flow' => ['varchar(80)'],
                'email' => ['varchar(80)'],
                'name' => ['varchar(80)'],
                'web' => ['varchar(255)'],
                'content' => ['varchar(512)'],
                'timestamp' => ['datetime'],
                'ip' => ['varchar(16)'],
            ]
        )->execute();

        $this->db->insert('comment',
                         ['flow',
                          'email',
                          'name',
                          'web',
                          'content',
                          'timestamp',
                          'ip']);
        $now = gmdate('Y-m-d H:i:s');
        $this->db->execute(['guestbook',
                           'example@mailyeahohyeah.se',
                           'Administrator',
                           'www.mailyeahohyeah.se',
                           'stupid administrator comment content.',
                           $now,
                           $this->request->getServer('REMOTE_ADDR')]);

        $this->db->execute(['guestbook',
                           'example2@mailyeahohyeah.se',
                           'Assistant',
                           'www.mailyeahohyeah.se',
                           'stupid assistant comment content.',
                           $now,
                           $this->request->getServer('REMOTE_ADDR')]);
    }

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($flow)
    {
        $comments = $this->comments->query()
            ->where("flow IS '$flow'")
            ->execute();

        $showform = $this->request->getGet('showform');
        $this->views->add('comment/comments', [
            'flow' => $flow,
            'comments' => $comments,
            'showform' => $showform
        ]);
        if ( $showform )
        {
            $this->views->add('comment/form', [
                'flow'      => $flow,
                'mail'      => null,
                'web'       => null,
                'name'      => null,
                'content'   => null,
                'output'    => null,
            ]);
        }
    }

    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction($flow)
    {
        $this->session();
        $this->theme->setTitle("Add comment");

        $form = $this->di->form->create([], [
            'content' => [
                'type' => 'text',
                'label' => 'Comment:',
                'required' => true,
                'validation' => ['not_empty']
            ],
            'name' => [
                'type'  => 'text',
                'label' => 'Name:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'web' => [
                'type' => 'text',
                'label' => 'Website:',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'email' => [
                'type'  => 'text',
                'label' => 'Email:',
                'required' => true,
                'validation' => ['not_empty', 'email_adress'],
            ],
            'flow' => [
                'type' => 'hidden',
                'value' => $flow
            ],
            'submit' => [
                'type' => 'submit',
                 'callback' => [$this, 'onSubmit']
            ],
        ]);

        $form->check([$this, 'onSuccess'], [$this, 'onFail']);
        $this->di->views->add('default/page', [
            'title' => "Add user",
            'content' => $form->getHTML()
        ]);
    }

    public function onSubmit($form)
    {
        $now = gmdate('Y-m-d H:i:s');

        $res = $this->comments->save([
            'content' => $form->Value('content'),
            'email ' => $form->Value('email'),
            'name' => $form->Value('name'),
            'web' => $form->Value('web'),
            'timestamp' => $now,
            'ip' => $this->request->getServer('REMOTE_ADDR'),
            'flow' => $form->Value('flow')
        ]);
        // $form->saveInSession = true ??
        
        return $res;
    }

    public function onSuccess($form)
    {
        $form->AddOutput("<p><i>Comment saved</i></p>");
        $url = $this->di->request->getCurrentUrl();
        $this->response->redirect($url);
    }

    public function onFail($form)
    {

    }



    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction()
    {
        $isPosted = $this->request->getPost('doRemoveAll');

        $flow = $this->request->getPost('flow');
        if (!$isPosted) {
            $this->response->redirect();
        }

        $this->comments->deleteAll($flow);

        $this->response->redirect($this->url->create($flow));
    }

    public function presentEditFormAction($flow, $commentId)
    {
        $comment = $this->comments->find($flow, $commentId);

        $this->views->add('comment/editform', [
            'flow'      => $flow,
            'commentId' => $commentId,
            'mail'      => $comment['mail'],
            'web'       => $comment['web'],
            'name'      => $comment['name'],
            'content'   => $comment['content'],
            'output'    => null
        ]);
    }

    public function updateAction($flow, $commentId)
    {
        $this->comments->update($flow,
                          $commentId,
                          $this->request->getPost('content'),
                          time());
        $this->response->redirect($this->url->create($flow));
    }

    public function deleteAction()
    {
        $commentId = $this->request->getGet('commentId');
        //echo "<h2>delete commentId: $commentId</h2>";

        $redirect = $this->request->getGet('redirect');
        $this->comments->deleteSingle($redirect, $commentId);

        //echo "<h2>redirect: $this->request->getGet('redirect')</h2>";

        $this->response->redirect(
            $this->url->create($redirect));
    }
}

