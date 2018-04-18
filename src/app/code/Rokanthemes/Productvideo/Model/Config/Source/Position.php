<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Model\Config\Source;

class Position implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
    {
        return [['value' => 'after', 'label' => __('After (Image - Video)')], ['value' => 'before', 'label' => __('Before  (Video - Image)')]];
    }

    public function toArray()
    {
        return ['before' => __('Before  (Video - Image)'), 'after' => __('After (Image - Video)')];
    }
}
