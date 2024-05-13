<?php

require_once __DIR__ . '/../dao/CommentDao.class.php';

class commentservice
{
    private $comment_dao;

    public function __construct()
    {
        $this->comment_dao = new commentDao();
    }

    public function get_all_comments()
    {
        return $this->comment_dao->get_all_comments();
    }

    public function get_comment_by_id($comment_id)
    {
        return $this->comment_dao->get_comment_by_id($comment_id);
    }

    public function add_comment($comment)
    {
        return $this->comment_dao->add_comment($comment);
    }

    public function update_comment($comment_id, $comment)
    {
        return $this->comment_dao->update_comment($comment_id, $comment);
    }

    public function delete_comment_by_id($comment_id)
    {
        return $this->comment_dao->delete_comment_by_id($comment_id);
    }
}