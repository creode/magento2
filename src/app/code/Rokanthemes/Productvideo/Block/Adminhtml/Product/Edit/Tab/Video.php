<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Product\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;

class Video extends \Magento\Backend\Block\Widget\Tab
{
    protected $_template = 'product/edit/video.phtml';
 
    protected $_coreRegistry = null;
 
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }
	
	public function getListProductVideos()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->get('Rokanthemes\Productvideo\Model\Video');
		$result = $model->getCollection()->addVideoToProductFilter($this->getProduct()->getId());
		return $result;
    }
	
	public function getListProductNoAssVideos()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->get('Rokanthemes\Productvideo\Model\Video');
		$result = $model->getCollection();
		return $result;
    }
}
