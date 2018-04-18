<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    
    protected $_collectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Rokanthemes\Productvideo\Model\ResourceModel\Video\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('productvideo_grid');
        $this->setUseAjax(false);
        $this->setDefaultSort('video_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_collectionFactory->create());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'video_id',
            [
                'header' => __('ID #'), 
                'width' => '80px', 
                'type' => 'number', 
                'index' => 'video_id'
            ]
        );
		
		$this->addColumn(
            'code',
            [
                'header' => __('Code'),
                'index' => 'code'
            ]
        );
		
		$this->addColumn(
            'type',
            [
                'header' => __('Type'),
                'index' => 'type'
            ]
        );
		
		$this->addColumn(
            'image',
            [
                 'header' => __('Image'),
				'align' => 'left',
				'index' => 'image',
				'width'     => '100',
				'filter' => false, 
				'sortable' => false,
				'renderer' => '\Rokanthemes\Productvideo\Block\Adminhtml\Video\Grid\Renderer\Image'
            ]
        );
		
		$this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title'
            ]
        );
		
		$this->addColumn('product_skus', array(
            'header' => __('SKUS'),
            'align' => 'left',
            'index' => 'product_skus',
            'filter' => false, 
            'sortable' => false,
            'renderer' => '\Rokanthemes\Productvideo\Block\Adminhtml\Video\Grid\Renderer\Sku'
        ));
		
        if (!$this->_storeManager->isSingleStoreMode()) {
            $this->addColumn(
                'store_id',
                [
                    'header' => __('Store View'),
                    'index' => 'store_id',
                    'type' => 'store',
                    'store_all' => true,
                    'store_view' => true,
                    'sortable' => false,
                    'filter_condition_callback' => [$this, '_filterStoreCondition'],
                    'header_css_class' => 'col-store-view',
                    'column_css_class' => 'col-store-view'
                ]
            );
        }

        $this->addColumn(
            'status',
            [
                'header' => __('Status'), 
				'index' => 'status', 
				'type' => 'options',
				'frame_callback' => array($this, 'decorateStatus'),
				'options' => array (
						0 => __('Disabled'), 
						1 => __('Enabled') )
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
                        'caption' =>__('Edit'),
                        'url' => [
                            'base' => '*/*/edit' ],
                        'field' => 'video_id'
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

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!($value = $column->getFilter()->getValue())) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }
	
	protected function _prepareMassaction()
    {
        $this->setMassactionIdField('video_id');
        $this->getMassactionBlock()->setFormFieldName('ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete Videos&nbsp;&nbsp;'),
             'url'      => $this->getUrl('*/*/massdelete'),
             'confirm'  => __('Are you sure?')
        ));
		
        return $this;
    }
	
	public function decorateStatus($value, $row)
    {
    	$class = '';	
		if ($row->getStatus()) {
			$cell = '<span class="grid-severity-notice"><span>'.$value.'</span></span>';
		} else {
			$cell = '<span class="grid-severity-critical"><span>'.$value.'</span></span>';
		}    	
    	return $cell;
    }
	
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['video_id' => $row->getVideoId()]);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/index', ['_current' => true]);
    }
}
