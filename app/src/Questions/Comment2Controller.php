<?php

namespace Anpk12\Questions;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class Comment2Controller implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    public function initialize()
    {
        $this->comments = new \Anpk12\Questions\Comment();
        $this->comments->setDI($this->di);
    }

    public function setupAction()
    {
        $this->theme->setTitle('setup comments');
        $this->db->dropTableIfExists('comment')->execute();

        $this->db->createTable(
            'comment',
            [
                'id' => ['integer',
                         'primary key',
                         'not null',
                         'auto_increment'],
                'questionid' => ['integer'],
                'answerid' => ['integer'],
                'userid' => ['integer'],
                'content' => ['varchar(512)'],
                'votes' => ['integer'],
                'timestamp' => ['datetime'],
            ]
        )->execute();

        $this->db->insert('comment',
                         ['questionid',
                          'answerid',
                          'userid',
                          'content',
                          'votes',
                          'timestamp']);
        $now = gmdate('Y-m-d H:i:s');
        $this->db->execute([11,
                           'null',
                           4,
                           'sample question comment #1',
                           0,
                           $now]);
        $this->db->execute(['null',
                           3,
                           4,
                           'sample answer comment #1',
                           0,
                           $now]);
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

        $this->views->add('comment/comments', [
            'flow' => $flow,
            'comments' => $comments,
        ]);
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
                'type' => 'textarea',
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
            'title' => "Add comment",
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
        $redirectUrl = $this->url->create($form->Value('flow'));
        $form->AddOutput("<p><i><a href=\"$redirectUrl\">
            Comment saved
            </a></i></p>"
        );
        $url = $this->di->request->getCurrentUrl();
        $this->response->redirect($url);
        //$this->response->redirect($this->url->create($form->Value('flow')));
    }

    public function onFail($form)
    {

    }



    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction($flow)
    {
        $this->comments->deleteFlow($flow);
        $this->response->redirect($this->url->create("comment/view/$flow"));

        //$this->response->redirect($this->url->create($flow));
    }

    public function updateAction($flow, $commentId)
    {
        $this->session();
        $this->theme->setTitle("Update comment");

        $comment = $this->comments->find($commentId);

        $form = $this->di->form->create([], [
            'content' => [
                'type' => 'textarea',
                'label' => 'Comment:',
                'value' => $comment->content,
                'required' => true,
                'validation' => ['not_empty']
            ],
            'name' => [
                'type'  => 'text',
                'label' => 'Name:',
                'value' => $comment->name,
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'web' => [
                'type' => 'text',
                'label' => 'Website:',
                'value' => $comment->web,
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'email' => [
                'type'  => 'text',
                'label' => 'Email:',
                'value' => $comment->email,
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
            'title' => "Update comment",
            'content' => $form->getHTML()
        ]);
    }

    public function deleteAction($flow, $commentId)
    {
        $this->comments->delete($commentId);
        $this->response->redirect(
            $this->url->create($flow));
    }

    /////////////

    public function getQuestionComments($questionId)
    {
        $comments = $this->comments->query()
            ->where("questionid IS '$questionId'")
            ->execute();

        // Also get users
        $this->UsersController->initialize();
        foreach ( $comments as $comment )
        {
            $comment->user =
                $this->UsersController->getUser($comment->userid);
        }
        return $comments;
    }

    public function getAnswerComments($answerId)
    {
        $comments = $this->comments->query()
            ->where("answerid IS '$answerId'")
            ->execute();

        // Also get users
        $this->UsersController->initialize();
        foreach ( $comments as $comment )
        {
            $comment->user =
                $this->UsersController->getUser($comment->userid);
        }

        return $comments;
    }

    public function commentQuestionAction($questionId)
    {
        $this->session();
        $this->theme->setTitle("Comment on a question");

        $form = $this->di->form->create([], [
            'content' => [
                'type' => 'textarea',
                'label' => 'Comment:',
                'required' => true,
                'validation' => ['not_empty']
            ],
            'questionid' => [
                'type' => 'hidden',
                'value' => $questionId
            ],
            'submit' => [
                'type' => 'submit',
                 'callback' => [$this, 'onCommentQuestionSubmit']
            ],
        ]);

        $form->check([$this, 'onCommentQuestionSuccess'],
                     [$this, 'onCommentQuestionFail']);
        $this->di->views->add('default/page', [
            'title' => "Add comment",
            'content' => $form->getHTML()
        ]);
    }

    public function onCommentQuestionSubmit($form)
    {
        $now = gmdate('Y-m-d H:i:s');

        $this->UsersController->initialize();
        $user = $this->UsersController->getLoggedInUser();
        if ( $user == null )
            return false;

        $res = $this->comments->save([
            'questionid' => $form->Value('questionid'),
            'answerid' => null,
            'userid' => $user[0],
            'content' => $form->Value('content'),
            'votes ' => 0,
            'timestamp' => $now,
        ]);
        
        return $res;
    }

    public function onCommentQuestionSuccess($form)
    {
        $url = $this->url->create(
            'questions/view/' .  $form->Value('questionid'));
        $this->response->redirect($url);
    }

    public function onCommentQuestionFail($form)
    {
        $form->AddOutput("<p><i>Failed to save comment</a></i></p>");
        $url = $this->di->request->getCurrentUrl();
        $this->response->redirect($url);
    }

    public function commentAnswerAction($questionId, $answerId)
    {
        $this->session();
        $this->theme->setTitle("Comment on an answer");

        $form = $this->di->form->create([], [
            'content' => [
                'type' => 'textarea',
                'label' => 'Comment:',
                'required' => true,
                'validation' => ['not_empty']
            ],
            'questionid' => [
                'type' => 'hidden',
                'value' => $questionId
            ],
            'answerid' => [
                'type' => 'hidden',
                'value' => $answerId
            ],
            'submit' => [
                'type' => 'submit',
                 'callback' => [$this, 'onCommentAnswerSubmit']
            ],
        ]);

        $form->check([$this, 'onCommentAnswerSuccess'],
                     [$this, 'onCommentAnswerFail']);
        $this->di->views->add('default/page', [
            'title' => "Add comment",
            'content' => $form->getHTML()
        ]);
    }

    public function onCommentAnswerSubmit($form)
    {
        $now = gmdate('Y-m-d H:i:s');

        $this->UsersController->initialize();
        $user = $this->UsersController->getLoggedInUser();
        if ( $user == null )
            return false;

        $res = $this->comments->save([
            'questionid' => null,
            'answerid' => $form->Value('answerid'),
            'userid' => $user[0],
            'content' => $form->Value('content'),
            'votes ' => 0,
            'timestamp' => $now,
        ]);
        
        return $res;
    }

    public function onCommentAnswerSuccess($form)
    {
        $url = $this->url->create(
            'questions/view/' .  $form->Value('questionid'));
        $this->response->redirect($url);
    }

    public function onCommentAnswerFail($form)
    {
        $form->AddOutput("<p><i>Failed to save comment</a></i></p>");
        $url = $this->di->request->getCurrentUrl();
        $this->response->redirect($url);
    }
}
