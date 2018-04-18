<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Productvideo;

use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action
{
	const ADMIN_RESOURCE = 'Rokanthemes_Productvideo::productvideo_productvideo';
	
    protected $_resultPageFactory;
	
    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
		parent::__construct($context);
    }
 
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->set(__('Product Video'));
        return $resultPage;
    }
}