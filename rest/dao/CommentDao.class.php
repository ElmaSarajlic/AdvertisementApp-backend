<?php

require_once __DIR__ . '/BaseDao.class.php';

class commentDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("comments");
    }

    public function get_all_comments()
    {
        return $this->query("SELECT * FROM comments", []);
    }

    public function get_comment_by_id($comment_id)
    {
        return $this->query_unique("SELECT * FROM comments WHERE id = :id", ["id" => $comment_id]);
    }

    public function add_comment($comment)
    {
        return $this->insert('comments', $comment);
    }

    public function update_comment($comment_id, $comment)
    {
        return $this->execute_update('comments', $comment_id, $comment);
    }

    public function delete_comment_by_id($comment_id)
    {
        $this->execute("DELETE FROM comments WHERE id = :id", ["id" => $comment_id]);
    }
}