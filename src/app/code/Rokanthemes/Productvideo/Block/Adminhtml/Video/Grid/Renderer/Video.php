<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video\Grid\Renderer;

class Video extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->get('Rokanthemes\Productvideo\Model\Productvideo');
		$result = $model->getCollection()->addFieldToFilter('product_id', array('in'=>$value));
		if(count($result) > 0){
			$video_id = array();
			foreach($result as $r){
				$video_id[] = $r->getVideoId();
			}
			$value = $this->escapeHtml(implode(", ", $video_id));
		}
		else{
			$value = '';
		}
		$out = "<span>".$value."</span>";
        return $out;
    }
}