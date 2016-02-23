<?php

namespace Anpk12\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($flow)
    {
        $comments = new \Anpk12\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->findAll($flow);

        $this->views->add('comment/comments', [
            'flow' => $flow,
            'comments' => $all,
        ]);
    }



    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $flow = $this->request->getPost('flow');

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ];

        $comments = new \Anpk12\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->add($flow, $comment);

        $this->response->redirect($this->url->create($flow));
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

        $comments = new \Anpk12\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->deleteAll($flow);

        $this->response->redirect($this->url->create($flow));
    }

    public function presentEditFormAction($flow, $commentId)
    {
        $comments = new \Anpk12\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comment = $comments->find($flow, $commentId);

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

    public function updateAction()
    {
        $commentId = $this->request->getPost('commentId');
        $comments = new \Anpk12\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $flow = $this->request->getPost('flow');
        $comments->update($flow,
                          $commentId,
                          $this->request->getPost('content'),
                          time());
        $this->response->redirect($this->url->create($flow));
    }

    public function deleteAction()
    {
        $commentId = $this->request->getGet('commentId');
        echo "<h2>delete commentId: $commentId</h2>";
        $comments = new \Anpk12\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $redirect = $this->request->getGet('redirect');
        $comments->deleteSingle($redirect, $commentId);

        //echo "<h2>redirect: $this->request->getGet('redirect')</h2>";

        $this->response->redirect(
            $this->url->create($redirect));
    }
}

