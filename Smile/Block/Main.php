<?php
namespace Pilot\Smile\Block;
 
use Magento\Framework\View\Element\Template;


 
class Main extends Template
{
   /**
    * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
    */
    
    protected $_dataSlides;
    protected $_dataBanner;
    protected $_categoryCollectionFactory;
    protected $_categoryHelper;
    protected $_productCollectionFactory;
    protected $imageHelper;
    
   public function __construct(
       Template\Context $context,
       array $data = [],
       \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
       \Pilot\Smile\Model\SliderFactory  $slides,
       \Magento\Catalog\Helper\Image $imageHelper,
       \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
       \Pilot\Smile\Model\BannerFactory  $banner
   ) {
       parent::__construct($context, $data);
       $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
       $this->_dataSlides = $slides;
       $this->_productCollectionFactory = $productCollectionFactory;    
       $this->imageHelper = $imageHelper;
       $this->_dataBanner = $banner;
   }

   public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
   {
       $collection = $this->_categoryCollectionFactory->create();
       $collection->addAttributeToSelect('*');        
       
       // select only active categories
       if ($isActive) {
           $collection->addIsActiveFilter();
       }
               
       // select categories of certain level
       if ($level) {
           $collection->addLevelFilter($level);
       }
       
       // sort categories by some value
       if ($sortBy) {
           $collection->addOrderField($sortBy);
       }
       
       // select certain number of categories
       if ($pageSize) {
           $collection->setPageSize($pageSize); 
       }    
       
       return $collection;
   }
   
   public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted = false, $asCollection = false, $toLoad = true);
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addFieldToFilter('is_featured', 1);
        $collection->setPageSize(2); 
        return $collection;
    }

    public function getItemImage($productId)
    {
        try {
            $_product = $this->_productCollectionFactory->getById($productId);
        } catch (NoSuchEntityException $e) {
            return 'product not found';
        }
        $image_url = $this->imageHelper->init($_product, 'product_base_image')->getUrl();
        return $image_url;
    }
 
   public function getSlides()
   {
       $slideModel = $this->_dataSlides->create();
       $slideList = $slideModel->getCollection();
       if(!empty($slideList->getData()))
       {
            return $slideList->getData();
       }
       else
       {
            return "no slide available";
       }
   }


   public function getBanners()
   {
       $bannersModel = $this->_dataBanner->create();
       $bannersList = $bannersModel->getCollection();
       if(!empty($bannersList->getData()))
       {
            return $bannersList->getData();
       }
       else
       {
            return "no banners available";
       }
   }
}