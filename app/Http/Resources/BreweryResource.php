<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BreweryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'              => $this['id'] ?? null,
            'name'            => $this['name'] ?? null,
            'brewery_type'    => $this['brewery_type'] ?? null,

            'address_1'  => $this['address_1'] ?? null,
            'address_2'  => $this['address_2'] ?? null,
            'address_3'  => $this['address_3'] ?? null,
            'city'       => $this['city'] ?? null,
            'state'      => $this['state'] ?? null,  // Può coincidere con 'state_province'
            'state_province' => $this['state_province'] ?? null,
            'postal_code'=> $this['postal_code'] ?? null,
            'country'    => $this['country'] ?? null,
            'street'     => $this['street'] ?? null,

            'longitude'       => $this['longitude'] ?? null,
            'latitude'        => $this['latitude'] ?? null,

            'phone'           => $this['phone'] ?? null,
            'website_url'     => $this['website_url'] ?? null
        ];
    }
}
