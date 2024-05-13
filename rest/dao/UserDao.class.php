<?php

require_once __DIR__ . '/BaseDao.class.php';

class userDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("users");
    }

    public function get_all_users() {
        return $this->query("SELECT * FROM users", []);
    }


    public function get_user_by_id($user_id)
    {
        return $this->query_unique("SELECT * FROM users WHERE id = :id", ["id" => $user_id]);
    }

    public function add_user($user)
    {
        return $this->insert('users', $user);
    }

    public function update_user($user_id, $user)
    {
        return $this->execute_update('users', $user_id, $user);
    }

    public function delete_user_by_id($id)
    {
        $this->execute("DELETE FROM users WHERE id = :id", ["id" => $id]);
    }
}