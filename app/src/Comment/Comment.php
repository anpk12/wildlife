<?php

namespace Anpk12\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class Comment extends \Anpk12\MVC\CDatabaseModel
{
    public function deleteFlow($flow)
    {
        $this->db->delete($this->getDataSource(), 'flow = ?');
        return $this->db->execute([$flow]);
    }
}

?>
