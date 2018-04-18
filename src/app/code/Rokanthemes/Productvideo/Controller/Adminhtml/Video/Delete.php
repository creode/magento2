<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

class Delete extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
	public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $videoId = $this->getRequest()->getParam('video_id');

        if ($videoId = (int)$this->getRequest()->getPost('video_id')) {
            try {
                $model = $this->_videoFactory->create();
                $model->setVideoId($videoId);
                $model->delete();
                
				// display success message
                $this->messageManager->addSuccess(__('Video was successfully deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['video_id' => $videoId]);
            }
        }
        $this->messageManager->addError(__('Unable to find a video to delete'));
        return $resultRedirect->setPath('*/*/');
    }
}
