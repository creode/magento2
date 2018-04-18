<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
   
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productvideo_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Video Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'main_section',
            [
                'label' => __('Video Information'),
                'title' => __('Video Information'),
                'content' => $this->getLayout()->createBlock('Rokanthemes\Productvideo\Block\Adminhtml\Video\Edit\Tab\Main')->toHtml(),
                'active' => true
            ]
        );
        return parent::_beforeToHtml();
    }
}
