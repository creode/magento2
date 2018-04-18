<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */
 
namespace Rokanthemes\Productvideo\Model;

class Productvideo extends \Magento\Framework\Model\AbstractModel
{
	public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
	
	protected function _construct()
    {
        $this->_init('Rokanthemes\Productvideo\Model\ResourceModel\Productvideo');
    }
}