<?php

class product {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function AddProduct($insertData) {
        $id = $this->_db->insert(TBL_PRODUCTS, $insertData);
        return $id;
    }

    public function getAllProduct() {
        return $data = $this->_db->get(TBL_PRODUCTS);
    }

    public function getProductByid($id, $field_name = '') {
        //echo "applicant_id".$applicant_id;
        $this->_db->where('id', $id);
        $data = $this->_db->getOne(TBL_PRODUCTS);
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

    public function updateProduct($id, $tableData) {
        $this->_db->where('id', $id);
        return $data = $this->_db->update(TBL_PRODUCTS, $tableData);
    }

    public function deleteProduct($id) {
        $this->_db->where('id', $id);
        return $data = $this->_db->delete(TBL_PRODUCTS);
    }

}
