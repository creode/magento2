<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

class Index extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
    public function execute()
    {
		$this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Video Manager'));
        $this->_view->renderLayout();
    }
}