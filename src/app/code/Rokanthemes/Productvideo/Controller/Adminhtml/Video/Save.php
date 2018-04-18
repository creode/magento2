<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */
 
namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

class Save extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
	
    public function execute()
    {
		$resultRedirect = $this->resultRedirectFactory->create();
        $videoId = $this->getRequest()->getParam('video_id');
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
           return $resultRedirect->setPath('*/*/');
        }
		
		if(!isset($data['video_id'])){
			if($data['type'] == 'youtube'){
				$data['code'] = $data['youtube_code'];			
			}
			else{
				$data['code'] = $data['vimeo_code'];
			}
			$data['image'] = $data['image_hidden_link'];
		}
		if (isset($_FILES['image_new']['error']) && $_FILES['image_new']['error'] == 0) {
			try {
				$uploader = $this->_fileUploaderFactory->create(['fileId' => 'image_new']);
				$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
				$uploader->setAllowRenameFiles(true);
				$uploader->setFilesDispersion(true);
				$uploader->setAllowCreateFolders(true);
				$path = $this->_directory_list->getPath('media');
				$result = $uploader->save($path);
				if(isset($result['file'])){
					$data['image'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).$result['file'];
				}
			} catch (Exception $e) {
			}
		}
        /** @var $model \Magento\User\Model\User */
        $model = $this->_videoFactory->create()->load($videoId);
        if ($videoId && $model->isObjectNew()) {
            $this->messageManager->addError(__('This Video no exists.'));
            return $resultRedirect->setPath('*/*/');
        }
        
		$model->setData($data);

		try {
			$model->save();
			$this->messageManager->addSuccess(__('Video was successfully saved'));
			$this->_session->setVideoData(false);
			return $resultRedirect->setPath('*/*/');
		} catch (\Exception $e) {
			$this->messageManager->addError($e->getMessage());
		}
		$this->_session->setVideoData($data);
		return $resultRedirect->setPath('*/*/edit', ['video_id' => $this->getRequest()->getParam('video_id')]);	
    }
}
