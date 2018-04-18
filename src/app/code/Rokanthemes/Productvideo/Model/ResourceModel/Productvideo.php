<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */
 
namespace Rokanthemes\Productvideo\Model\ResourceModel;

class Productvideo extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }
	
    protected function _construct()
    {
        $this->_init('rokantheme_productvideo_productvideo', 'product_video_id');
    }
}