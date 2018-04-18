<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Productvideo;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    
    protected $_productFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []
    ) {
        $this->_productFactory = $productFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
         parent::_construct();
        $this->setId('productGridVideo');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
    }

    protected function _prepareCollection()
    {
        parent::_prepareCollection();

		$collection = $this->_productFactory->create()->getCollection()->addAttributeToSelect(
            'sku'
        )->addAttributeToSelect(
            'name'
        );
		
        $this->setCollection($collection);
		return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID #'), 
                'width' => '80px', 
                'type' => 'number', 
                'index' => 'entity_id'
            ]
        );
		
		$this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name'
            ]
        );
		
		$this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku'
            ]
        );
		
		$this->addColumn(
            'entity_id_video',
            [
                'header' => __('Videos'),
                'index' => 'entity_id',
				'filter' => false,
                'sortable' => false,
				'renderer' => '\Rokanthemes\Productvideo\Block\Adminhtml\Video\Grid\Renderer\Video'
            ]
        );
		
        $this->addColumn('action',
            [
                'header' => __('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Add images'),
						'target' => '_blank',
                        'url'     => $this->getUrl('catalog/product/edit/id/$entity_id'),
                        'field'   => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true
            ]
        );

        return parent::_prepareColumns();

    }
}
