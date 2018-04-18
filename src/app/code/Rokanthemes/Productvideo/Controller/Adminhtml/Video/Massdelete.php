<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

class Massdelete extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $videoId = $this->getRequest()->getParam('ids');
		try {
			foreach($videoId as $v){
				$model = $this->_videoFactory->create();
				$model->setVideoId($v);
				$model->delete();
			}			
			// display success message
			$this->messageManager->addSuccess(__('Video was successfully deleted'));
			return $resultRedirect->setPath('*/*/');
		} catch (\Exception $e) {
			// display error message
			$this->messageManager->addError($e->getMessage());
			// go back to edit form
			return $resultRedirect->setPath('*/*/');
		}
    }
}
