<?php

namespace ServiceTime\Calendar\Services\Translators;

/**
 * Базовый класс транслятора
 */
abstract class BaseTranslator
{
    public function translateAll($collection): array
    {
        $result = [];
        foreach ($collection as $item) {
            $result[] = static::translate($item);
        }
        return $result;
    }

    abstract public function translate($item);
}
