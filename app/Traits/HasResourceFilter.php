<?php

namespace App\Traits;

use App\Customization\FilterableAnonymousResourceCollection;

trait HasResourceFilter
{
    protected ?array $onlyFields = null;

    public static function collection($resource, ?array $onlyFields = null)
    {
        return tap(static::newCollection($resource, $onlyFields), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    protected static function newCollection($resource, ?array $onlyFields = null)
    {
        return new FilterableAnonymousResourceCollection($resource, static::class, $onlyFields);
    }

    public function only(array $onlyFields)
    {
        $this->onlyFields = $onlyFields;

        return $this;
    }

    protected function applyFieldsFilter(array $default_fields, ?array $onlyFieldsForCollection): array
    {
        return $this->onlyFields ?
            array_filter($default_fields,
                fn ($key) => in_array($key, $this->onlyFields ?? []), ARRAY_FILTER_USE_KEY)
            : (
                $onlyFieldsForCollection
                    ? array_filter($default_fields,
                        fn ($key) => in_array($key, $onlyFieldsForCollection ?? []), ARRAY_FILTER_USE_KEY)
                    : $default_fields);
    }
}
