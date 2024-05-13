<?php

require_once __DIR__ . '/../dao/AdDao.class.php';

class adservice
{
    private $ad_dao;

    public function __construct()
    {
        $this->ad_dao = new adDao();
    }

    public function get_all_ads()
    {
        return $this->ad_dao->get_all_ads();
    }

    public function get_ad_by_id($ad_id)
    {
        return $this->ad_dao->get_ad_by_id($ad_id);
    }

    public function add_ad($ad)
    {
        return $this->ad_dao->add_ad($ad);
    }

    public function update_ad($ad_id, $ad)
    {
        return $this->ad_dao->update_ad($ad_id, $ad);
    }

    public function delete_ad_by_id($ad_id)
    {
        return $this->ad_dao->delete_ad_by_id($ad_id);
    }
}