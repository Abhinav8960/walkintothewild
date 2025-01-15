<?php

namespace common\interfaces;


interface NewStatusInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_SUSPEND = 0;
    const STATUS_DELETE = -1;

    const SHARE_SAFARI_API_LAYOUT_FULL = "sharesafarifull";
    const OPERATOR_API_LAYOUT_FULL = "operatorfull";
    const PARK_API_LAYOUT_FOR_FILTER_PARK = "filterpark";
    const PARK_API_LAYOUT_FULL = "parkfull";
    const PARK_API_LAYOUT_WITH_TOP_OPERATORS = "parkwithTopOperators";
    const PACKAGE_API_LAYOUT_FULL = "packagefull";
    const USER_API_LAYOUT_FULL = "userfull";

    



}
