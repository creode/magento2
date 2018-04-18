<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Model\ResourceModel\Productvideo;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Rokanthemes\Productvideo\Model\Productvideo',
            'Rokanthemes\Productvideo\Model\ResourceModel\Productvideo'
        );
    }
}