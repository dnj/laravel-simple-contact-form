<?php

namespace dnj\SimpleContactForm\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);

        return $data;
    }
}
