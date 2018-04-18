<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml;

class Video extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->addData(
            [
                \Magento\Backend\Block\Widget\Container::PARAM_CONTROLLER => 'adminhtml_video',
                \Magento\Backend\Block\Widget\Grid\Container::PARAM_BLOCK_GROUP => 'Rokanthemes_Productvideo',
                \Magento\Backend\Block\Widget\Grid\Container::PARAM_BUTTON_NEW => __('Add New Video'),
                \Magento\Backend\Block\Widget\Container::PARAM_HEADER_TEXT => __('Video Manager'),
            ]
        );
        parent::_construct();
        $this->_addNewButton();
    }
}
