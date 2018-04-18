<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_storeScope;
	
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
		$this->_storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        parent::__construct($context);
    }
	
	public function isEnabled()
	{
		if($this->scopeConfig->getValue('productvideo/general/enabled_module', $this->_storeScope)){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function isBeforeImageFixed()
	{
		if($this->scopeConfig->getValue('productvideo/integration/thumbnails_position', $this->_storeScope) != 'after'){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function videoAutoPlay()
	{
		if($this->scopeConfig->getValue('productvideo/video/auto_play', $this->_storeScope)){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function videoAutoRestart()
	{
		if($this->scopeConfig->getValue('productvideo/video/auto_restart', $this->_storeScope)){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function videoAutoShowPupup()
	{
		if($this->scopeConfig->getValue('productvideo/video/show_pupup', $this->_storeScope)){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function videoAutoRelated()
	{
		if($this->scopeConfig->getValue('productvideo/video/show_related', $this->_storeScope)){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function getHtmlItem($videos) {
		if(count($videos) == 0){
			return '';
		}
		$html = '';
		foreach($videos as $val_video){
			$status = '';
			if($val_video->getStatus()){
				$status = __('Enabled');
			}
			else{
				$status = __('Disable');
			}
			$html .= '<tr class="data-row">
					<td class="data-grid-draggable-row-cell">'.$val_video->getVideoId().'</td>
					<td class="data-grid-draggable-row-cell"><img src="'.$val_video->getImage().'" style="width: 100px" /></td>
					<td class="data-grid-draggable-row-cell">'.$val_video->getTitle().'</td>
					<td class="data-grid-draggable-row-cell">'.$val_video->getType().'</td>
					<td class="data-grid-draggable-row-cell">'.$status.'</td>
					<td class="data-grid-draggable-row-cell"><a class="delete-video-ajax" data-id="'.$val_video->getProductVideoId().'" href="javascript:void(0);">'.__('Remove').'</a></td>
				</tr>';
		}
		return $html;
    }
	
	public function getVideoToProductFilter($product_id){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->get('Rokanthemes\Productvideo\Model\Video');
		return $model->getCollection()->addVideoToProductFilter($product_id);
	}
}
