<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml\Video;

class NewAction extends \Rokanthemes\Productvideo\Controller\Adminhtml\Video
{
    public function execute()
    {
		$this->_forward('edit');
    }
}
