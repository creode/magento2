<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Plugin\Catalog\Block\Product\View;

class Gallery
{
	protected $_helper;
	
	public function __construct(
        \Rokanthemes\Productvideo\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }
	
	public function afterGetGalleryImagesJson(\Magento\Catalog\Block\Product\View\Gallery $subject, $result) {
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
						$new_result[$position] = [
							'thumb' => $video->getImage(),
							'img' => $video->getImage(),
							'full' => $video->getImage(),
							'caption' => '',
							'position' => $position,
							'isMain' => '',
						];
						$position ++;
					}
					foreach($result as $re){
						$new_result[$position] = [
							'thumb' => $re['thumb'],
							'img' => $re['img'],
							'full' => $re['full'],
							'caption' => $re['caption'],
							'position' => $position,
							'isMain' => $re['isMain'],
						];
						$position ++;
					}
					$result = $new_result;
				}
				else{
					$position = count($result);
					foreach($pro_videos as $video){
						$result[$position] = [
							'thumb' => $video->getImage(),
							'img' => $video->getImage(),
							'full' => $video->getImage(),
							'caption' => '',
							'position' => $position,
							'isMain' => '',
						];
						$position ++;
					}
				}
			}
		}
		return json_encode($result);
	}
}