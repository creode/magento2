<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Productvideo;

use Magento\Framework\App\Action\Context;

class Save extends \Magento\Framework\App\Action\Action
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
        $data = $this->getRequest()->getPostValue();
        foreach($data['videos'] as $video){
			$video = [
				'video_id' => $video,
				'product_id' => $data['product_id']
			];
			$model = $this->_productvideoFactory->create();
			$model->setData($video);
			$model->save();
		}
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->get('Rokanthemes\Productvideo\Model\Video');
		$videos = $model->getCollection()->addFieldToFilter('video_id', array('in'=>$data['videos']))->addJoinProductVideo();
		
		$data_return['status'] = 1;
		$data_return['html'] = $this->_helper->getHtmlItem($videos);
		$resultJson = $this->_objectManager->get('Magento\Framework\Controller\Result\Json');
        $resultJson->setHeader('Content-type', 'application/json', true);
        $resultJson->setData($data_return);
        return $resultJson;
    }
}
