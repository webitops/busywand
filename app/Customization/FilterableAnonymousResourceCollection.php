<?php

namespace App\Customization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilterableAnonymousResourceCollection extends AnonymousResourceCollection
{
    public ?array $onlyFields = null;

    public function __construct($resource, $collects, ?array $onlyFields = null)
    {
        $this->onlyFields = $onlyFields;
        parent::__construct($resource, $collects);
    }

    public function toArray(Request $request)
    {
        return $this->collection->map->toArray($request, $this->onlyFields)->all();
    }

    public function only(array $onlyFields)
    {
        $this->onlyFields = $onlyFields;

        return $this;
    }
}
