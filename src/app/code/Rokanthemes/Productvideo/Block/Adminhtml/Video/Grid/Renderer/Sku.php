<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video\Grid\Renderer;

class Sku extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
		if(count($value) > 0){
			$value = $this->escapeHtml(implode(", ", $value));
		}
		else{
			$value = '';
		}
		$out = "<span>".$value."</span>";
        return $out;
    }
}