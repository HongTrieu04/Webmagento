<?php
namespace FoTech\CustomModule\Block;
class CurrencyExchangeRateIndex extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }

    public function getCurrencyExchangeRate() {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx?b=68');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $xml=simplexml_load_string($result) or die("Error: Cannot create object");
        $data = json_decode(json_encode((array)$xml), TRUE);
        curl_close($curl);

        return $data;
    }
}
