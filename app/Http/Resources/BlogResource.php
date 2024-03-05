<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'publish_date' => $this->publish_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
