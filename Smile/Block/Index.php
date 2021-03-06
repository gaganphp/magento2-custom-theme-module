<?php
namespace Pilot\Smile\Block;
 
use Magento\Framework\View\Element\Template;
 
class Index extends Template
{
   /**
    * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
    */
   protected $layoutProcessors;
 
   public function __construct(
       Template\Context $context,
       array $layoutProcessors = [],
       array $data = []
   ) {
       parent::__construct($context, $data);
       $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
       $this->layoutProcessors = $layoutProcessors;
   }
 
   public function getWelcome()
   {
       if (empty($this->_data['welcome'])) {
           $this->_data['welcome'] = $this->_scopeConfig->getValue(
               'design/header/welcome',
               \Magento\Store\Model\ScopeInterface::SCOPE_STORE
           );
       }
       return __($this->_data['welcome']);
   }
 
}