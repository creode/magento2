<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

class Validate extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
    
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(0);
        $errors = null;
        $videoId = (int)$this->getRequest()->getParam('video_id');
        $data = $this->getRequest()->getPostValue();
		
        try {
            /** @var $model \Magento\User\Model\User */
            $model = $this->_videoFactory->create()->load($videoId);
            $model->setData($data);
            $errors = $model->validate();
        } catch (\Magento\Framework\Validator\Exception $exception) {
            /* @var $error Error */
            foreach ($exception->getMessages(\Magento\Framework\Message\MessageInterface::TYPE_ERROR) as $error) {
                $errors[] = $error->getText();
            }
        }

        if ($errors !== true && !empty($errors)) {
            foreach ($errors as $error) {
                $this->messageManager->addError($error);
            }
            $response->setError(1);
            $this->_view->getLayout()->initMessages();
            $response->setHtmlMessage($this->_view->getLayout()->getMessagesBlock()->getGroupedHtml());
        }

        $this->getResponse()->representJson($response->toJson());
    }
}
