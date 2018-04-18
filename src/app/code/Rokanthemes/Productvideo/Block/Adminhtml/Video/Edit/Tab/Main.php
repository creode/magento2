<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_systemStore;
	
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('permissions_video');
		$isElementDisabled = false;
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('video_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Video Type')]);
		
		$fieldset->addField('image_hidden_link', 'hidden', 
			[
                'name' => 'image_hidden_link'
			]
		);
		
		if ($model->getVideoId()) {
			$fieldset->addField('video_id', 'hidden', 
				[
                    'name' => 'video_id' 
				]
			);
			$fieldset->addField('image', 'hidden', 
				[
                    'name' => 'image' 
				]
			);
			if($model->getType() == 'youtube'){
				$fieldset->addField('type', 'select', 
					[
						'label' => __('Type'), 
						'title' => __('Type'), 
						'name' => 'type',
						'disabled' => 'disabled',
						'required' => true, 
						'options' =>[
							'youtube' => __('YouTube')
						]
					]
				);
				
				$fieldset->addField('code', 'text', 
					[
						'name' => 'code', 
						'label' => __('Youtube Video Code'), 
						'title' => __('Youtube Video Code'), 
						'readonly' => true,
						'style'   => "width: 274px !important; color: #888888;",
						'after_element_html' => '<p class="note"><span>https://www.youtube.com/watch?v=<b>'.$model->getCode().'</b></span></p>',
						'required' => true 
					]
				);
				
				$fieldset->addField(
					'default_preview_video_live',
					'label',
					[
						'label' => __('Preview Video'),
						'title' => __('Preview Video'),
						'after_element_html' => "<div class=\"preview_video\"><div class=\"video-product-container\"><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/".$model->getCode()."\" frameborder=\"0\" allowfullscreen></iframe></div></div>"
					]
				);				
			}
			else{	
				$fieldset->addField('type', 'select', 
					[
						'label' => __('Type'), 
						'title' => __('Type'), 
						'name' => 'type',
						'disabled' => 'disabled',
						'required' => true, 
						'options' =>[
							'vimeo' => __('Vimeo')
						]
					]
				);
				
				$fieldset->addField('code', 'text', 
					[
						'name' => 'code', 
						'label' => __('Vimeo Video Code'), 
						'title' => __('Vimeo Video Code'), 
						'readonly' => true,
						'style'   => "width: 274px !important; color: #888888;",
						'after_element_html' => '<p class="note"><span>https://vimeo.com/<b>'.$model->getCode().'</b></span></p>',
						'required' => true 
					]
				);
				
				$fieldset->addField(
					'default_preview_video_live',
					'label',
					[
						'label' => __('Preview Video'),
						'title' => __('Preview Video'),
						'after_element_html' => "<div class=\"preview_video\"><div class=\"video-product-container\"><iframe src=\"https://player.vimeo.com/video/'+code_vimeo+'?portrait=0\" width=\"640\" height=\"360\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div></div>"
					]
				);	
			}
		}
		else{
			$fieldset->addField('type', 'select', 
				[
					'label' => __('Type'), 
					'title' => __('Type'), 
					'name' => 'type',
					'required' => true, 
					'options' =>[
						'youtube' => __('YouTube'),
						'vimeo' => __('Vimeo')
					]
				]
			);
			
			$fieldset->addField('youtube_code', 'text', 
				[
					'name' => 'youtube_code', 
					'label' => __('Youtube Video Code'), 
					'title' => __('Youtube Video Code'), 
					'after_element_html' => '<p class="note"><span>https://www.youtube.com/watch?v=<b>XXXXXXXX</b></span></p>',
					'required' => true 
				]
			);
			
			$fieldset->addField('vimeo_code', 'text', 
				[
					'name' => 'vimeo_code', 
					'label' => __('Vimeo Video Code'), 
					'title' => __('Vimeo Video Code'), 
					'after_element_html' => '<p class="note"><span>https://vimeo.com/<b>XXXXXXXX</b></span></p>',
					'required' => true 
				]
			);
			
			$fieldset->addField(
				'default_preview_video_live',
				'label',
				[
					'label' => __('Preview Video'),
					'title' => __('Preview Video'),
					'after_element_html' => '<div class="preview_video"></div>'
				]
			);
		}
		
		$fieldset1 = $form->addFieldset('base_fieldset1', ['legend' => __('Video Information')]);
		
		$fieldset1->addField('title', 'text', 
			[
				'name' => 'title', 
				'label' => __('Title'), 
				'title' => __('Title')
			]
		);
		
		$fieldset1->addField('description', 'textarea', 
			[
				'name' => 'description', 
				'label' => __('Description'), 
				'title' => __('Description')
			]
		);
		
		$fieldset1->addField('status', 'select', 
			[
				'label' => __('Status'), 
				'title' => __('Status'), 
				'name' => 'status',
				'required' => true, 
				'options' =>[
					'0' => __('Disabled'), 
                    '1' => __('Enabled')
				]
			]
		);
		
		$note_ = '<div class="preview_image_live">';
		if ($model->getVideoId()) {
			$note_ .= "<img src=".$model->getImage() ." style='width: 200px' />";
		}
		$note_ .= "</div>";
		$fieldset1->addField('image_new', 'image', 
			[
				'label' => __('Image'), 
				'title' => __('Image'), 
				'name' => 'image_new',
				'after_element_html' => '<p class="note"><span id="image_note">Thumbnail will upload from Vimeo, but you can upload custom thumbnail.<br>Supported formats: jpg, jpeg, png, gif</span><br>'.$note_.'</p>' 
			]
		);
		
		if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset1->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'store_id',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true)
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset1->addField(
                'store_id',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }
		
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
