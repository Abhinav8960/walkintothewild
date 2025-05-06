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
    const PACKAGE_API_LAYOUT_FULL_WITH_VERSION = "packagefullwithversion";
    const USER_API_LAYOUT_FULL = "userfull";

    

    // ... other constants ...

    /**
     * @var string attribute type.
     */
    const TYPE_INTEGER = 'integer';
    /**
     * @var string attribute type.
     */
    const TYPE_STRING = 'string';
    /**
     * @var string attribute type.
     */
    const TYPE_BOOLEAN = 'boolean';
    /**
     * @var string attribute type.
     */
    const TYPE_DATE = 'date';
    /**
     * @var string attribute type.
     */
    const TYPE_TIME = 'time';
    /**
     * @var string attribute type.
     */
    const TYPE_DATETIME = 'datetime';
    /**
     * @var string attribute type.
     */
    const TYPE_TIMESTAMP = 'timestamp';
    /**
     * @var string attribute type.
     */
    const TYPE_DOUBLE = 'double';
    /**
     * @var string attribute type.
     */
    const TYPE_DECIMAL = 'decimal';
    /**
     * @var string attribute type.
     */
    const TYPE_JSON = 'json';


}
