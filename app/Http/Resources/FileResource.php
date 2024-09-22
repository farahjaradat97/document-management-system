<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "path" => $this->path,
            "parent_id" => $this->parent_id,
            "parent_name" => $this->parent ? $this->parent->name : null, 
            "is_folder" => $this->is_folder ? true :false,
            "project_id" => $this->is_folder,
            "mime" => $this->mime,
            "size" => $this->get_file_size(),
            "refrence_number" => $this->refrence_number,
            "subject" => $this->subject,
            "date" =>$this-> get_date_format(),
            "created_at" => $this->created_at->diffForHumans(),
            "updated_at" => $this->updated_at->diffForHumans(),
            "created_by" => $this->user->first_name,
            "updated_by" =>$this->user->first_name,
            
        ];    }
}
