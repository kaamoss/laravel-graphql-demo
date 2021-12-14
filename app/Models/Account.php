<?php

namespace App\Models;

include_once(__DIR__.'/../Annotations/ModelProperty.php');

use DateTime;
use App\Annotations\ModelProperty;

class Account extends BaseModel
{
    /**
     * @var int
     * @ModelProperty()
     */
    public $id;

    /**
     * @var string
     * @ModelProperty()
     */
    public $title;

    /**
     * @var boolean
     * @ModelProperty(entityAccessor="isParent")
     */
    public $isParent;

    public $parentAccount;

    public $primaryUser;

    public $primaryMember;

    public $childAccounts;

    public $members;

    /**
     * @var DateTime
     * @ModelProperty()
     */
    public $createdAt;

    /**
     * @var DateTime
     * @ModelProperty()
     */
    public $updatedAt;

}
