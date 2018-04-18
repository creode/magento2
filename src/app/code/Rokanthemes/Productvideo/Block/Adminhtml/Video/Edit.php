<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Block\Adminhtml\Video;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'video_id';
        $this->_controller = 'adminhtml_video';
        $this->_blockGroup = 'Rokanthemes_Productvideo';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Video'));
        $this->buttonList->remove('delete');

        $objId = $this->getRequest()->getParam($this->_objectId);

        if (!empty($objId)) {
            $this->addButton(
                'delete',
                [
                    'label' => __('Delete Video'),
                    'class' => 'delete',
                    'onclick' => sprintf(
                        'deleteConfirm("%s", "%s", %s)',
                        __('Are you sure you want to do this?'),
                        $this->getUrl('productvideo/*/delete'),
                        json_encode(['data' => ['video_id' => $objId]])
                    ),
                ]
            );
        }
		
		if (!$this->_coreRegistry->registry('permissions_video')->getVideoId()) {
			$html = "$('#video_vimeo_code').removeClass('required-entry');
				$('.field-vimeo_code').hide();
				$('.field-default_preview_video_live').hide();
				$('#video_status').val(1);";
		}
		else{
			$html = "$('.field-default_preview_video_live').show(); $('#video_status').val(".$this->_coreRegistry->registry('permissions_video')->getStatus().");";
		}
		
		$this->_formScripts[] = "
			require(['jquery'], function($){
				".$html."
				var code_vimeo = '';
				var code_youtube = '';
				$('#video_type').change(function(){
					if($(this).val() == 'youtube'){
						$('#video_vimeo_code').removeClass('required-entry');
						code_vimeo = '';
						$('#video_vimeo_code').val('');
						$('.field-vimeo_code').hide();
						$('#video_youtube_code').addClass('required-entry');
						$('.field-youtube_code').show();
					}
					else{
						code_youtube = '';
						$('#video_youtube_code').removeClass('required-entry');
						$('#video_youtube_code').val('');;
						$('.field-youtube_code').hide();
						$('#video_vimeo_code').addClass('required-entry');
						$('.field-vimeo_code').show();
					}
				});
				$('#video_youtube_code').blur(function(){
					var _code = $(this).val();
					if(_code != code_youtube){
						code_youtube = _code;
						$.ajax({
							type:'GET',
							showLoader: true,
							url: 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='+code_youtube+'&fields=items&key=AIzaSyC8BuMAZKi7T6WjfDlO3PWFOE74V3rqHL4',
							dataType: 'json',
							success: function(data){
								if(typeof data.items[0] !== 'undefined' && typeof data.items[0].id !== 'undefined'){
									$('#video_title').val(data.items[0].snippet.title);
									$('#video_description').html(data.items[0].snippet.description);
									var html_ = '<div class=\"video-product-container\"><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/'+code_youtube+'\" frameborder=\"0\" allowfullscreen></iframe></div>';
									$('.field-default_preview_video_live').show();
									$('.field-default_preview_video_live .preview_video').html(html_);
									if(data.items[0].snippet.thumbnails.standard.url!== 'undefined'){
										$('.preview_image_live').html('<img src=\"'+data.items[0].snippet.thumbnails.standard.url+'\" style=\"width: 200px\" />');
										$('#video_image_hidden_link').val(data.items[0].snippet.thumbnails.standard.url);
									}
								}
								else{
									getErrorNotFoundVideo();
								}
							},
							error: function () {
								getErrorNotFoundVideo();
							}
						});
					}
				});
				$('#video_vimeo_code').blur(function(){
					var _code = $(this).val();
					if(_code != code_vimeo){
						code_vimeo = _code;
						$.ajax({
							type:'GET',
							showLoader: true,
							url: 'http://vimeo.com/api/v2/video/' + code_vimeo + '.json',
							dataType: 'json',
							success: function(data){
								if(typeof data[0].id !== 'undefined'){
									$('#video_title').val(data[0].title);
									$('#video_description').html(data[0].description);
									var html_ = '<div class=\"video-product-container\"><iframe src=\"https://player.vimeo.com/video/'+code_vimeo+'?portrait=0\" width=\"640\" height=\"360\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
									$('.field-default_preview_video_live').show();
									$('.field-default_preview_video_live .preview_video').html(html_);
									$('.preview_image_live').html('<img src=\"'+data[0].thumbnail_large+'\" style=\"width: 200px\" />');
									$('#video_image_hidden_link').val(data[0].thumbnail_large);
								}
								else{
									getErrorNotFoundVideo();
								}
							},
							error: function () {
								getErrorNotFoundVideo();
							}
						});
					}
				});
				function getErrorNotFoundVideo(){
					$('.field-default_preview_video_live').hide();
					$('.field-default_preview_video_live .preview_video').html('');
					$('.preview_image_live').html('');
					$('#video_image_hidden_link').val('');
					alert('Video not found');
				}
			});
        ";
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('permissions_video')->getVideoId()) {
            $questioname = $this->escapeHtml($this->_coreRegistry->registry('permissions_video')->getTitle());
            return __("Edit Video '%1'", $questioname);
        } else {
            return __('New Video');
        }
    }
	
	public function getValidationUrl()
    {
        return $this->getUrl('productvideo/*/validate', ['_current' => true]);
    }
}
