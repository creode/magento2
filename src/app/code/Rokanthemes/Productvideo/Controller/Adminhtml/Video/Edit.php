<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

use Magento\Framework\Locale\Resolver;

class Edit extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
	public function execute()
    {
        $videoId = $this->getRequest()->getParam('video_id');
        $model = $this->_videoFactory->create();

        if ($videoId) {
            $model->load($videoId);
            if (!$model->getVideoId()) {
                $this->messageManager->addError(__('This video not exists.'));
                $this->_redirect('adminhtml/*/');
                return;
            }
        } else {
            $model->setInterfaceLocale(Resolver::DEFAULT_LOCALE);
        }

        // Restore previously entered form data from session
        $data = $this->_session->getVideoData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('permissions_video', $model);

        if (isset($videoId)) {
            $breadcrumb = __('Edit Video');
        } else {
            $breadcrumb = __('New Video');
        }
        $this->_initAction()->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Video Manager'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Video'));
        $this->_view->renderLayout();
    }
}
