<?php

namespace App\Customization;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterableJsonResource extends JsonResource
{
    /**
     * The only fields that should be evaluated and returned when resource is displayed.
     *
     * @var array
     */
    public $only = [];

    /**
     * Returns the default fields that define a resource, which will be filtered when 'only' filter is used.
     *
     * @return array
     */
    public function defaultToArray(Request $request)
    {
        return [];
    }

    /**
     * Set the only fields to be evaluated and returned when a resource is displayed.
     *
     * @return $this
     */
    public function only(array $only)
    {
        $this->only = $only;

        return $this;
    }

    /**
     * Evaluates and returns only the desired fields from default fields when 'only' filter is used.
     */
    public function applyOnlyFilter(array $default_fields): array
    {
        return array_map(
            fn ($item) => ($item instanceof Closure) ? call_user_func($item) : $item,
            ! empty($this->only)
                ? array_filter(
                    $default_fields,
                    fn ($key) => in_array($key, $this->only ?? []), ARRAY_FILTER_USE_KEY)
                : $default_fields
        );
    }

    public function toArray(Request $request)
    {
        if ($defaultArray = $this->defaultToArray($request)) {
            return $this->applyOnlyFilter($defaultArray);
        }

        if (! $this->resource) {
            return [];
        }

        return is_array($this->resource)
            ? $this->resource
            : $this->resource->toArray();
    }

    protected static function newCollection($resource)
    {
        return new FilterableAnonymousResourceCollection($resource, static::class);
    }
}
