<?php

require_once __DIR__ . '/BaseDao.class.php';

class adDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("ads");
    }

    public function get_all_ads()
    {
        return $this->query("SELECT * FROM ads", []);
    }

    public function get_ad_by_id($ad_id)
    {
        return $this->query_unique("SELECT * FROM ads WHERE id = :id", ["id" => $ad_id]);
    }

    public function add_ad($ad)
    {
        return $this->insert('ads', $ad);
    }

    public function update_ad($ad_id, $ad)
    {
        return $this->execute_update('ads', $ad_id, $ad);
    }

    public function delete_ad_by_id($ad_id)
    {
        $this->execute("DELETE FROM ads WHERE id = :id", ["id" => $ad_id]);
    }
}