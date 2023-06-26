<?php

class ControllerSaleOrder extends Controller
{
    public function invoice() {
        include_once DIR_SYSTEM . 'library/invoice/ControllerWaybill.php';

        $waybill = new ControllerWaybill($this->registry);

        $waybill->invoice();
    }
}