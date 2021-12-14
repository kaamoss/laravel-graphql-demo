<?php

namespace App\Util;

use App\Annotations\ModelMapping;
use App\Annotations\ModelProperty;
use Illuminate\Support\Facades\App;

class ModelReflectionCache
{

    public static function fetchCache() {
        $array = unserialize(file_get_contents(__DIR__.'/../Generated/ModelMappingCache.bin'));
        return $array;
    }

    public static function generateCache() {
        $cache = [
            'entities'=>[],
            'models'=>[],
        ];

        $typeStrs = static::getTypeStringsForDir(__DIR__.'/../Entities');
        $annotationReader = App::make(\Doctrine\Common\Annotations\Reader::class);
        foreach($typeStrs as $typeStr) {
            $entityMirror = new \ReflectionClass($typeStr);
            $modelMapping = $annotationReader->getClassAnnotation($entityMirror, ModelMapping::class);
            if(isset($modelMapping->modelClass)) {
                $cache['entities'][$typeStr] = $modelMapping->modelClass;
            }
        }

        $typeStrs = static::getTypeStringsForDir(__DIR__.'/../Models');
        foreach($typeStrs as $typeStr) {
            $model = [];
            $modelMirror = new \ReflectionClass($typeStr);
            $modelProps = $modelMirror->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
            foreach($modelProps as $modelProp) {
                $propAnnotation = $annotationReader->getPropertyAnnotation($modelProp, ModelProperty::class);
                if(isset($propAnnotation)) {
                    $model[$modelProp->getName()] = get_object_vars($propAnnotation);
                }
            }
            if(count($model) > 0) {
                $cache['models'][$typeStr] = $model;
            }
        }

        file_put_contents(__DIR__.'/../Generated/ModelMappingCache.bin',serialize($cache));

        //return $cache;
    }

    protected static function getTypeStringsForDir(string $dir): array {
        $typeStrs = [];

        $entityFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
        $phpFiles = new \RegexIterator($entityFiles, '/\.php$/');

        foreach($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for($idx=0; isset($tokens[$idx]); $idx++) {
                if(!isset($tokens[$idx][0])) {
                    continue;
                }
                if(T_NAMESPACE === $tokens[$idx][0]) {
                    $idx += 2; //skip the namespace keyword and whitespace
                    while(isset($tokens[$idx]) && is_array($tokens[$idx])) {
                        $namespace .= $tokens[$idx++][1];
                    }
                }
                if(T_CLASS === $tokens[$idx][0]) {
                    $idx += 2; //skip class keyword and whitespace
                    if(strlen(trim($tokens[$idx][1])) > 1) {
                        $typeStrs[] = $namespace . '\\'.$tokens[$idx][1];
                    }
                }
            }
        }

        return $typeStrs;
    }
}
