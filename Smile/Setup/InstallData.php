<?php
namespace Pilot\Smile\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class InstallData implements InstallDataInterface
{
	protected $_optionsFactory;
	protected $_sliderFactory;
	private $eavSetupFactory;

	public function __construct(
		\Pilot\Smile\Model\OptionsFactory $optionsFactory,
		\Pilot\Smile\Model\SliderFactory $sliderFactory,
		EavSetupFactory $eavSetupFactory
		)
	{
		$this->_optionsFactory = $optionsFactory;
		$this->_sliderFactory = $sliderFactory;
		$this->eavSetupFactory = $eavSetupFactory;
	}
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{

		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'is_featured',
				[
				'group' => 'General',
				'type' => 'int',
				'backend' => '',
				'frontend' => '',
				'label' => 'Featured Product',
				'input' => 'boolean',
				'class' => '',
				'source' => '',
				'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'user_defined' => true,
				'default' => '',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => 'simple,configurable,virtual,bundle,downloadable'
				] );
		
		$data = [
			'option_name' => "phone",
			'option_value' => "981429812",
			'status'       => 1
		];
		$smile = $this->_optionsFactory->create();
		$smile->addData($data)->save();

		// slider table
		// $slideData = [
		// 	'slide_title' => "This is first slide",
		// 	'slide_description' => "This is slide description",
		// 	'slide_link'       => 'http://google.com'
		// ];
		// $slide = $this->_sliderFactory->create();
		// $slide->addData($slideData)->save();
	}
}
