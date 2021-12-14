<?php

namespace App\Annotations;

/**
 * Class ModelMapping
 * @package App\Annotations
 * @Annotation
 * @Target({"CLASS"})
 */
class ModelMapping {

    /**
     * @Required
     * @var string
     */
    public $modelClass;
}
