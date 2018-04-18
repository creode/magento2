<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */
 
namespace Rokanthemes\Productvideo\Model\ResourceModel\Video;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'video_id';
	
	protected $_map = [
        'fields' => [
            'video_id' => 'main_table.video_id'
        ]
    ];
	
    protected function _construct()
    {
        $this->_init(
            'Rokanthemes\Productvideo\Model\Video',
            'Rokanthemes\Productvideo\Model\ResourceModel\Video'
        );
    }
	
	public function addVideoToProductFilter($product_id)
    {
        $alias = 'rokantheme_productvideo' . $product_id;
        if ($this->getFlag($alias)) {
            return $this;
        }
		$this->getSelect()->join(
            [$alias => $this->getTable('rokantheme_productvideo_productvideo')],
            'main_table.video_id = ' . $alias . '.video_id',
            ['product_video_id' => $alias.'.product_video_id']
        )->where(
            $alias . '.product_id = (?)',
            $product_id
        )->group(
            'main_table.video_id'
        );
        $this->setFlag($alias, true);
        return $this;
    }
	
	public function addJoinProductVideo()
    {
        $alias = 'rokantheme_join_productvideo';
        if ($this->getFlag($alias)) {
            return $this;
        }
		$this->getSelect()->join(
            [$alias => $this->getTable('rokantheme_productvideo_productvideo')],
            'main_table.video_id = ' . $alias . '.video_id',
            ['product_video_id' => $alias.'.product_video_id']
        )->group(
            'main_table.video_id'
        );
        $this->setFlag($alias, true);
        return $this;
    }
	
	public function addStoreFilter($store)
    {
        if ($store instanceof \Magento\Store\Model\Store) {
            $store = $store = [$store->getId()];
        }elseif (is_numeric($store)) {
            $store = [$store];
        }

        $alias = 'store_table_' . implode('_', $store);
        if ($this->getFlag($alias)) {
            return $this;
        }

        $storeFilter = [$store];
        if ($this->_isStoreFilterWithAdmin) {
            $storeFilter[] = 0;
        }

        $this->getSelect()->join(
            [$alias => $this->getTable('rokantheme_productvideo_store')],
            'main_table.video_id = ' . $alias . '.video_id',
            []
        )->where(
            $alias . '.store_id IN (?)',
            $storeFilter
        )->group(
            'main_table.video_id'
        );

        $this->setFlag($alias, true);
        return $this;
    }
	
	public function addIsActiveFilter()
    {
        $this->addFilter('status', 1);
        return $this;
    }
}