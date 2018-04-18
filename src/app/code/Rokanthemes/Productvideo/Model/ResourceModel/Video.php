<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */
 
namespace Rokanthemes\Productvideo\Model\ResourceModel;

class Video extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected $filterManager;
    protected $date;
	
	public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Filter\FilterManager $filterManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,

        $connectionName = null
    ) {
        $this->date = $date;
        $this->filterManager = $filterManager;
        parent::__construct($context, $connectionName);
    }
	
    protected function _construct()
    {
        $this->_init('rokantheme_productvideo', 'video_id');
    }
	
	protected function _afterDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->getConnection()->delete(
            $this->getTable('rokantheme_productvideo_productvideo'),
            ['video_id = ?' => $object->getId()]
        );		
        return parent::_afterDelete($object);
    }
	
	protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->getConnection()->delete(
            $this->getTable('rokantheme_productvideo_store'),
            ['video_id = ?' => $object->getId()]
        );

        foreach ((array)$object->getData('store_id') as $storeId) {
            $storeArray = [
                'video_id' => $object->getId(),
                'store_id' => $storeId
            ];
            $this->getConnection()->insert($this->getTable('rokantheme_productvideo_store'), $storeArray);
        }
		
        return parent::_afterSave($object);
    }
	
	protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        $select = $this->getConnection()
            ->select()
            ->from($this->getTable('rokantheme_productvideo_store'), ['store_id'])
            ->where('video_id = :video_id');

        $stores = $this->getConnection()->fetchCol($select, [':video_id' => $object->getId()]);

        if ($stores) {
            $object->setData('store_id', $stores);
        }
		
		$select1 = $this->getConnection()
            ->select()
            ->from($this->getTable('rokantheme_productvideo_productvideo'), ['product_id'])
            ->where('video_id = :video_id');

        $product_ids = $this->getConnection()->fetchCol($select1, [':video_id' => $object->getId()]);
		
		if ($product_ids) {
			$where = $this->getConnection()->quoteInto("entity_id IN(?)", $product_ids);
            $select2 = $this->getConnection()
            ->select()
            ->from($this->getTable('catalog_product_entity'), ['sku'])
            ->where($where);
			$skus = $this->getConnection()->fetchCol($select2);
			$object->setData('product_skus', $skus);
		}
        return parent::_afterLoad($object);
    }
}