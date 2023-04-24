<?php

namespace App\Http\Resources;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $query = Status('id', '=', $this->status_id)->get();
        return [
            'name' => $this->name,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'status_id' => $this->status_id,
            'createdAt' => $this->create_at,
            'status' => $query,
        ];
    }
}