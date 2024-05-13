<?php

require_once __DIR__ . '/../dao/categoryDao.class.php';

class categoryservice
{
    private $category_dao;

    public function __construct()
    {
        $this->category_dao = new categoryDao();
    }

    public function get_all_categories()
    {
        return $this->category_dao->get_all_categories();
    }

    public function get_category_by_id($category_id)
    {
        return $this->category_dao->get_category_by_id($category_id);
    }

    public function add_category($category)
    {
        return $this->category_dao->add_category($category);
    }

    public function update_category($category_id, $category)
    {
        return $this->category_dao->update_category($category_id, $category);
    }

    public function delete_category_by_id($category_id)
    {
        return $this->category_dao->delete_category_by_id($category_id);
    }
}