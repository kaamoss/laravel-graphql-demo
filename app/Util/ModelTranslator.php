<?php

namespace App\Util;

use App\Annotations\ModelMapping;
use App\Annotations\ModelProperty;
use App\Entities\BaseEntity;
use App\Models\BaseModel;
use Doctrine\ORM\Proxy\Proxy;
use Illuminate\Support\Facades\App;

class ModelTranslator {

    public static function toModelFaster(BaseEntity $entity, string $modelClassOverride=null,
                                         array $parentObjects=[], array $parentChain=[], int $depth=0) {

    }

    public static function toModel(BaseEntity $entity, string $modelClassOverride=null,
                                   array $parentObjects=[], array $parentChain=[], int $depth=0): ?BaseModel {

        if($depth > 3) {
            return null;
        }

        $entityMirror = new \ReflectionClass($entity);
        if($entityMirror->implementsInterface(Proxy::class)) {
            $entityMirror = $entityMirror->getParentClass();
        }
        $annotationReader = App::make(\Doctrine\Common\Annotations\Reader::class);
        $modelMapping = $annotationReader->getClassAnnotation($entityMirror, ModelMapping::class);
        if(!isset($modelMapping->modelClass)) {
            //TODO: log exception here?
            return null;
        }

        $modelClass = $modelClassOverride ?? $modelMapping->modelClass;

        $resultModel = new $modelClass;
        $modelMirror = new \ReflectionClass($resultModel);
        if(!isset($parentObjects[$modelClass][$entity->getId()])) {
            $parentObjects[$modelClass][$entity->getId()] = $resultModel;
        }

        //Check for matching object higher in the parent object chain
        for($i=0, $iMax=count($parentChain); $i < $iMax; $i++) {
            $parentChainItem = $parentChain[$i];
            if($parentChainItem['type'] == $modelClass && $parentChainItem['id'] == $entity->getId()) {
                return $parentChain[$i]['model'];
            }
        }

        $parentChain[] = [
            'type'=>$modelClass,
            'id'=>$entity->getId(),
            'model'=>$resultModel,
        ];

        foreach($modelMirror->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $modelProp) {
            $propAnnotation = $annotationReader->getPropertyAnnotation($modelProp, ModelProperty::class);
            $entityMethodName = $propAnnotation->entityAccessor ?? 'get'.ucfirst($modelProp->getName());

            $ignoreProp = !($entityMirror->hasMethod($entityMethodName) && isset($propAnnotation));

            if(isset($propAnnotation->subModelClass) && !$ignoreProp) {

            }
            else if(!$ignoreProp) {
                $entityMirrorMethod =  $entityMirror->getMethod($entityMethodName);
                //TODO: check if method is public and return type is also an entity
                //$docComment = $modelProp->getDocComment();

                $retType = '';
                if($entityMirrorMethod->getReturnType() !== null) {
                    $retType = $entityMirrorMethod->getReturnType()->getName();
                }

                switch($retType) {
                    case 'Doctrine\Common\Collections\Collection':
                        break;
                    default:
                        try {
                            $resultModel->{$modelProp->getName()} = $entity->{$entityMirrorMethod->getName()}();
                        } catch(\Exception $ex) {
                            //TODO: log exception here?
                            $resultModel->{$modelProp->getName()} = null;
                        }
                        break;
                }
            }
        }

        return $resultModel;
    }
}
