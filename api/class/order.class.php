<?php

class order {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getAllOrder() {
        $this->_db->where('type', 2);
        return $data = $this->_db->get(TBL_MASTERS);
    }

    public function getOrderByField($id, $field_name = '') {

        $this->_db->where('id', $id);
        $this->_db->where('type', 2);
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

    public function orderedItemByItem($id) {

        $this->_db->where('master_id', $id);
        $this->_db->where('type', 2);
        $data = $this->_db->get(TBL_MASTERS_ITEM);
        foreach ($data as $key => $value) {
            $new_arry = self:: getItemByItemId($value['item_id']);
            $category = self:: getCategoryById($new_arry['category']);
            $final[$key] = array_merge($new_arry, $data[$key], $category);
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

    public function contactByField($contact_id, $field_name = "") {

        $this->_db->where('id', $contact_id);
        $data = $this->_db->get(TBL_CONTACT);
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

    public function orderItemByItem($id) {

        $this->_db->where('item_id', $id);
        $this->_db->where('type', 2);
        $data = $this->_db->get(TBL_MASTERS_ITEM);
        if (sizeof($data) != 0) {
            foreach ($data as $key => $value) {
                $new_arry = self:: getItemByItemId($value['item_id']);
                $category = self:: getCategoryById($new_arry['category']);
                $master = self::master_order($value['master_id']);
                $final[$key] = array_merge($new_arry, $data[$key], $category, $master);
                $final[$key]['contact_name'] = self::contactByField($master['contact'], 'name');
            }
            return $final;
        } else {
            return $a = array();
        }
    }

    public function master_order($id) {

        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_MASTERS);
    }

}
