<?php

require_once __DIR__ . '/BaseDao.class.php';

class categoryDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("categories");
    }

    public function get_all_categories()
    {
        return $this->query("SELECT * FROM categories", []);
    }

    public function get_category_by_id($category_id)
    {
        return $this->query_unique("SELECT * FROM categories WHERE id = :id", ["id" => $category_id]);
    }

    public function add_category($category)
    {
        return $this->insert('categories', $category);
    }

    public function update_category($category_id, $category)
    {
        return $this->execute_update('categories', $category_id, $category);
    }

    public function delete_category_by_id($category_id)
    {
        $this->execute("DELETE FROM categories WHERE id = :id", ["id" => $category_id]);
    }
}