<?php

class shipment {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getShipped($id) {
        $this->_db->where('id', $id);
        $this->_db->where('type', 3);
        return $data = $this->_db->getOne(TBL_MASTERS);
    }

    public function getItemByshipmentId($id) {
        
        $this->_db->where('type', 3);
        $this->_db->where('master_id', $id);
        $data = $this->_db->get(TBL_MASTERS_ITEM);
        
        foreach ($data as $key => $value) {
            $new_arry = self:: getItemByItemId($value['item_id']);
            $category = self:: getCategoryById($new_arry['category']);
            $final[$key] = array_merge($new_arry,$data[$key],$category);
        }
        return $final;
    }

    public function getItemByItemId($id) {
        
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_ITEM);
    }
    public function getCategoryById($id) {
        
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_CATEGORY);
    }

}
