<?php

namespace App\Annotations;

/**
 * Class ModelProperty
 * @package App\Annotations
 * @Annotation
 * @Target({"METHOD","PROPERTY"})
 */
class ModelProperty {

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $entityAccessor;

    /**
     * @var string
     */
    public $subModelClass;

    /**
     * @var string
     */
    public $subModelCollectionClass;
}
