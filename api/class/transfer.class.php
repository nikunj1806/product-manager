<?php

class transfer {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getAllTrnasfer() {
        return $data = $this->_db->get(TBL_TRANSFER);
    }

    public function getTransferByField($id, $field_name = '') {

        $this->_db->where('id', $id);
        $this->_db->where('type', 4);
        $data = $this->_db->getOne(TBL_MASTERS);
        if ($field_name == "") {
            return $data;
        } else {
            $field_names = explode(',', $field_name);
            $return_data = "";
            foreach ($field_names as $field) {
                $return_data.= $data[0][$field] . ' ';
            }
            return trim($return_data);
        }
    }
    
    public function getTransferedItem($id, $field_name = '') {
        
        $this->_db->where('transfer_id', $id);
        $data = $this->_db->get(TBL_TRANSFERRED_ITEM);
        foreach ($data as $key => $value){
            $return_all[$key] = self::getItemByID($value['item_id']);
            $category = self:: getCategoryById($return_all[$key]['category']);
            $a[$key] = array_merge($return_all[$key],$data[$key],$category);
        }
        return $a;

    }
    
    public function getCategoryById($id) {
        
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_CATEGORY);
    }
    public function getItemByID($id){
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_ITEM);
    }
    
    public function getItemByTransferId($id){
        $this->_db->where('transfer_id', $id);
        return $data = $this->_db->get(TBL_TRANSFERRED_ITEM);
    }
}
