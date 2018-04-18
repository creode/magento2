<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Productvideo;

use Magento\Framework\App\Action\Context;

class Delete extends \Magento\Framework\App\Action\Action
{
	
    const ADMIN_RESOURCE = 'Rokanthemes_Productvideo::productvideo_productvideo';
	
	protected $_helper;
	
    protected $_resultPageFactory;
	
	protected $_productvideoFactory;
	
    public function __construct(\Rokanthemes\Productvideo\Helper\Data $helper, \Rokanthemes\Productvideo\Model\ProductvideoFactory $productvideoFactory, Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_productvideoFactory = $productvideoFactory;
		$this->_helper = $helper;
		parent::__construct($context);
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
		$model = $this->_productvideoFactory->create()->load($id);
		$model->delete();
		$data_return['status'] = 1;
		$resultJson = $this->_objectManager->get('Magento\Framework\Controller\Result\Json');
        $resultJson->setHeader('Content-type', 'application/json', true);
        $resultJson->setData($data_return);
        return $resultJson;
    }
}
