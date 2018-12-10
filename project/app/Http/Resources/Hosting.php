<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Hosting extends ResourceCollection
{

    public function toArray($request)
    {
        dd($request);
        return ['domain_name' => $this->domain_name, 'servicepack_id' => $this->servicepack_id, 'name' => $this->name];
    }
}
