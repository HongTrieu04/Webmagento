<?php
namespace FoTech\CustomModule\Block;

class NewsIndex extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }

    public function getNews() {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://vnexpress.net/rss/kinh-doanh.rss');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $xml=simplexml_load_string($result, null , LIBXML_NOCDATA ) or die("Error: Cannot create object");
        $data = json_decode(json_encode((array)$xml), TRUE);
        curl_close($curl);

        return $data;
    }
}
