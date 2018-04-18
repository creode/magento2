<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video\Grid\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    public function __construct(
        \Magento\Backend\Block\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
	
	public function render(\Magento\Framework\DataObject $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $value = $this->escapeHtml($value);
		$out = "<img src=".$value." style='max-width: 100px' />";
        return $out;
    }
}