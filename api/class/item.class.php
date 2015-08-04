<?php

class item {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getAllItem() {
        return $data = $this->_db->get(TBL_ITEM);
    }

    public function getItemByid($id, $field_name = '') {

        $this->_db->where('id', $id);
        $data = $this->_db->getOne(TBL_ITEM);
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

    public function getItemByfields($id, $field_name = '') {
        $this->_db->where('id', $id);
        $data = $this->_db->get(TBL_ITEM);
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

    public function getOrderItemByOrderid($id, $field_name = '') {

        $this->_db->where('master_id', $id);
        $this->_db->where('type', 2);
        $data = $this->_db->get(TBL_MASTERS_ITEM);
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

    public function getItemByCategory_id($id, $field_name = '') {

        $this->_db->where('category', $id);
        $data = $this->_db->get(TBL_ITEM);
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

    public function getOnOrderItemByitemId($id, $field_name = '') {

        $this->_db->where('item_code', $id);
        $data = $this->_db->get(TBL_ORDERED_ITEM);
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

    public function getTransactionByItem($id) {
        $this->_db->where('item_id', $id);
        $this->_db->orderBy('modified_date', 'ASC');
        $data = $this->_db->get(TBL_MASTERS_ITEM);
        if (sizeof($data) != 0) {
            foreach ($data as $key => $val) {
                $this->_db->where('id', $val['master_id']);
                $master = $this->_db->getOne(TBL_MASTERS);
                $final[$key] = array_merge($master, $data[$key]);
            }

            return $final;
        } else {
            return $a = array();
        }
    }

    public function getItemBygeneralId($id) {
        $this->_db->where('general_id', $id);
        $data = $this->_db->getOne(TBL_MASTERS_ITEM);
        return $data;
    }

}
