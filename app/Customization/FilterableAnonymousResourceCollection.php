<?php

namespace App\Customization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilterableAnonymousResourceCollection extends AnonymousResourceCollection
{
    public ?array $only = [];

    public function __construct($resource, $collects, ?array $only = [])
    {
        $this->only = $only;
        parent::__construct($resource, $collects);
    }

    public function toArray(Request $request)
    {
        return $this->collection->map->only($this->only)->map->toArray($request)->all();
    }

    public function only(array $only)
    {
        $this->only = $only;

        return $this;
    }
}
