<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? null,
            'description' => $this->description ?? null,
            'user' => $this->user ? new UserResource($this->user) : null,
            'image'    => $this->image ? asset('images/blogs/' . $this->image) : null, 
            'slug' => $this->slug ?? null,
            'created_at' => $this->created_at->format('Y-m-d') ?? null, 
        ];
    }
}
