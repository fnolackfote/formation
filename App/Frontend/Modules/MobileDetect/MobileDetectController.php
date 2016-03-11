<?php

/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 07/03/2016
 * Time: 17:16
 */

namespace App\Frontend\Modules\MobileDetect;

use \OCFram\BackController;

class MobileDetectController extends BackController
{
    public function executeDetect()
    {
        $detect = new \Mobile_Detect();
        $detecter = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

        $this->page->addVar('detecter', $detecter);
    }
}