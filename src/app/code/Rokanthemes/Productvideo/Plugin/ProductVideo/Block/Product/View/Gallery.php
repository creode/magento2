<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Plugin\ProductVideo\Block\Product\View;

class Gallery
{
	protected $_helper;
	
	public function __construct(
        \Rokanthemes\Productvideo\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }
	
	public function afterGetVideoSettingsJson(\Magento\ProductVideo\Block\Product\View\Gallery $subject, $result) {
		if($this->_helper->isEnabled()){
			$videoSettingData[] = [
				'playIfBase' => $this->_helper->videoAutoPlay(),
				'showRelated' => $this->_helper->videoAutoRelated(),
				'videoAutoRestart' => $this->_helper->videoAutoRestart(),
			];
			return json_encode($videoSettingData);
		}
		return $result;
	}
	public function afterGetMediaGalleryDataJson(\Magento\ProductVideo\Block\Product\View\Gallery $subject, $result) {
		$result = json_decode($result, true);
		if($this->_helper->isEnabled()){
			$product_id = $subject->getProduct()->getId();
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$model = $objectManager->get('Rokanthemes\Productvideo\Model\Video');
			$pro_videos = $model->getCollection()->addVideoToProductFilter($product_id);
			if(count($pro_videos) > 0){
				if($this->_helper->isBeforeImageFixed()){
					$position = 0;
					$new_result = array();
					foreach($pro_videos as $video){
						$link = ($video->getType() == 'vimeo') ? 'https://vimeo.com/' : 'https://www.youtube.com/watch?v=';
						$new_result[$position] = [
							'mediaType' => 'external-video',
							'videoUrl' => $link.$video->getCode(),
							'isBase' => '',
						];
						$position ++;
					}
					foreach($result as $re){
						$new_result[$position] = [
							'mediaType' => $re['mediaType'],
							'videoUrl' => $re['videoUrl'],
							'isBase' => $re['isBase'],
						];
						$position ++;
					}
					$result = $new_result;
				}
				else{
					$position = count($result);
					foreach($pro_videos as $video){
						$link = ($video->getType() == 'vimeo') ? 'https://vimeo.com/' : 'https://www.youtube.com/watch?v=';
						$result[$position] = [
							'mediaType' => 'external-video',
							'videoUrl' => $link.$video->getCode(),
							'isBase' => '',
						];
						$position ++;
					}
				}
			}
		}
		return json_encode($result);
	}
}