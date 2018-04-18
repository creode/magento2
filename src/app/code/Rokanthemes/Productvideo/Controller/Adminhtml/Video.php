<?php
/**
 * Copyright © 2016 tonypham.web.developer@gmail.com
 */

namespace Rokanthemes\Productvideo\Controller\Adminhtml;

abstract class Video extends \Magento\Backend\App\AbstractAction
{
	
	const ADMIN_RESOURCE = 'Rokanthemes_Productvideo::productvideo_video';
	
	protected $_fileUploaderFactory;
	
	protected $_coreRegistry;
	
	protected $_videoFactory;
	
	protected $_filesystem;
	
	protected $_directory_list;
	
	protected $_storeManager;
	
	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Rokanthemes\Productvideo\Model\VideoFactory $videoFactory,
		\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
		\Magento\Framework\App\Filesystem\DirectoryList $directory_list,
		\Magento\Store\Model\StoreManagerInterface $store_manager
    ) {
        parent::__construct($context);
		$this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_videoFactory = $videoFactory;
		$this->_directory_list = $directory_list;  
		$this->_storeManager = $store_manager;  
    }

	protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Rokanthemes_Productvideo::productvideo_video'
        )->_addBreadcrumb(
            __('Rokanthemes'),
            __('Rokanthemes')
        )->_addBreadcrumb(
            __('Product Videos'),
            __('Product Videos')
        )->_addBreadcrumb(
            __('Video Manager'),
            __('Video Manager')
        );
        return $this;
    }
}
