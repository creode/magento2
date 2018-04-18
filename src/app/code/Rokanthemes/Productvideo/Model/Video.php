<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */
 
namespace Rokanthemes\Productvideo\Model;

use Rokanthemes\Productvideo\Api\Data\VideoInterface;

class Video extends \Magento\Framework\Model\AbstractModel implements VideoInterface
{
	
	protected $_validatorObject;
	
	public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Validator\DataObjectFactory $validatorObjectFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_validatorObject = $validatorObjectFactory;
    }
	
	protected function _construct()
    {
        $this->_init('Rokanthemes\Productvideo\Model\ResourceModel\Video');
    }
	
	public function validate()
    {
        $validator = $this->_validatorObject->create();
        if (!$validator->isValid($this)) {
            return $validator->getMessages();
        }
        return true;
    }
}