<?php

class Spottercommt_XmlGenerator_Model_System_Config_Source_Category
{
    public $optArr = array();

    /*
    * Prepare data for System->Configuration dropdown
    * */
    public function toOptionArray()
    {
        $category = Mage::getModel('catalog/category');
        $tree = $category->getTreeModel();
        $tree->load();
        $ids = $tree->getCollection()->addAttributeToFilter('level', '2')->getAllIds(); // get sub category of root category(default category)
        $catArr = array();
        foreach ($ids as $id) {
            $catObj = Mage::getModel('catalog/category')->load($id);
            $this->optArr[] = $this->getArr($catObj);
            $firChild = $catObj->getChildren();
            $this->getSubCat($firChild);
        }
        return $this->optArr;
    }

    public function getArr($category)
    {
        $depth = count(explode('/', $category->getPath())) - 2;
        $indent = str_repeat('-', max($depth * 2, 0));
        $options = array(
            'label' => $indent . $category->getName(),
            'value' => $category->getId()
        );
        return $options;
    }

    public function getSubCat($subCat)
    {
        foreach (explode(',', $subCat) as $catId) {
            $sCat = Mage::getModel('catalog/category')->load($catId);
            if ($sCat->getIsActive()) {
                $sCatName = $sCat->getName();
                $this->optArr[] = $this->getArr($sCat);
            }
            $secChild = $sCat->getChildren();
            if ($secChild != '') {
                $this->getSubCat($secChild);
            }
        }
    }
}