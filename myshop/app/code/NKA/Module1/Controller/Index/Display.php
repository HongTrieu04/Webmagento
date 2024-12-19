<?php
namespace NKA\Module1\Controller\Index;

class Display implements \Magento\Framework\App\Action\HttpGetActionInterface   {
    protected $_pageFactory;
    protected $_context;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory){
        $this->_pageFactory = $pageFactory;
        $this->_context = $context;
    }

    public function execute() {
        return $this->_pageFactory->create();
    }
}
