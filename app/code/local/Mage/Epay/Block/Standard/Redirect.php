<?php
/**
 * Copyright ePay | Dit Online Betalingssystem, (c) 2016.
 * This program is free software. You are allowed to use the software but NOT allowed to modify the software.
 * It is also not legal to do any changes to the software and distribute it in your own name / brand.
 */
class Mage_Epay_Block_Standard_Redirect extends Mage_Core_Block_Template
{
    public function _toHtml()
    {
        $data = $this->getData();

        $html = '<h2 class="epay_redirect">'.$data["headerText"].'</h2>';
        $html .= '<h3 class="epay_redirect">'.$data["headerText2"].'</h3>';
        $html .= '<script type="text/javascript">
                    var isPaymentWindowReady = false;

                    function PaymentWindowReady()
                    {
                        paymentwindow = new PaymentWindow(
                        {
                            '.$data["paymentRequest"] .'
                        });';

        if($data["isOverlay"] === true)
        {
            $html .= 'paymentwindow.on("close",function(){ window.location.href = "'. $data["cancelUrl"] .'";});';
        }

        $html.='isPaymentWindowReady = true;
                }
                </script>';

        $html .= '<script type="text/javascript" src="https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/paymentwindow.js" charset="UTF-8"></script>';
        $html .= '<script type="text/javascript">
                    var timerOpenWindow;

                    function openPaymentWindow()
                    {
                        if(isPaymentWindowReady)
                        {
                            clearInterval(timerOpenWindow);
                            paymentwindow.open();
                        }
                    }

                    document.onreadystatechange = function ()
                    {
                        if(document.readyState === "complete")
                        {
                            timerOpenWindow = setInterval("openPaymentWindow()", 500);
                        }
                    }
                </script>';

        return $html;
    }
}