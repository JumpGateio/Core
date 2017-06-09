<?php

namespace App\Transformers;

abstract class Transformer
{
    public static function transformAll($resources)
    {
        return collect($resources)->map(function ($resource) {
            return get_called_class()::transform($resource);
        });
    }

    abstract public static function transform($resource);
}
