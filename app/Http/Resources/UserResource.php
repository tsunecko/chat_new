<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
//            'token' => $this->token
        ];
    }


    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('Authorization', $this->token);
    }

//    /**
//     * Get additional data that should be returned with the resource array.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return array
//     */
//    public function with($request)
//    {
//        return [
//            'meta' => [
//                'key' => 'value',
//            ],
//        ];
//    }
}
