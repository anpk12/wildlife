<?php

namespace Anpk12\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($flow, $comment)
    {
        $allComments = $this->session->get('comments', []);
        $allComments[$flow][] = $comment;

        $this->session->set('comments', $allComments);
    }



    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($flow)
    {
        $allComments = $this->session->get('comments', []);
        return array_key_exists($flow, $allComments) ? $allComments[$flow] :
                                                       [];
    }

    public function find($flow, $commentId)
    {
        $comments = $this->findAll($flow);
        // TODO error checking :-)
        return $comments[$commentId];
    }

    public function update($flow, $commentId, $content, $timestamp)
    {
        //$comment = $this->find($commentId);

        $allComments = $this->session->get('comments', []);
        if ( !array_key_exists($flow, $allComments) )
        {
            throw new Exception("unknown comment flow: $flow");
        }
        $comments = $allComments[$flow];

        $comments[$commentId]['content'] = $content;
        $comments[$commentId]['timestamp'] = $timestamp;

        $allComments[$flow] = $comments;

        $this->session->set('comments', $allComments);
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll($flow)
    {
        $allComments = $this->session->get('comments', []);
        if ( array_key_exists($flow, $allComments) )
        {
            unset($allComments[$flow]);
            $this->session->set('comments', $allComments);
        }
    }

    public function deleteSingle($flow, $commentId)
    {
        $allComments = $this->session->get('comments', []);

        if ( array_key_exists($flow, $allComments) )
        {
            unset($allComments[$flow][$commentId]);
            $this->session->set('comments', $allComments);
        }
    }
}
