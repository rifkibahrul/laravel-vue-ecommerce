<?php

namespace App\Http\Resources;

use App\Enums\CustomerStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->user_id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->user->email,
            'name'          => $this->user->name,
            'phone'         => $this->phone,
            'status'        => $this->status === CustomerStatus::Active->value,
            'created_at'    => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at'    => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
            'customerAddress' => [
                'id' => $this->customerAddress->id ?? null,
                'address' => $this->customerAddress->address ?? null,
                'city_id' => $this->customerAddress->city_id ?? null,
                'city_name' => $this->customerAddress->city_name ?? null,
                'province_id' => $this->customerAddress->province_id ?? null,
                'province_name' => $this->customerAddress->province_name ?? null,
                'zipcode' => $this->customerAddress->zipcode ?? null,
            ],
        ];
    }
}
