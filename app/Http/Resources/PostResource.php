<?php

namespace App\Http\Resources;

use App\Models\Bookmark;
use App\Models\PostImage;
use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->type_id < 12) {
            $type = 'sell';
        } else {
            $type = 'rent';
        }
        $images = PostImage::where('post_id', $this->id)->get();
        $number_image = count($images);
        $image = $images[0]->url;
        $bookmark = Bookmark::where('post_id', $this->id)->where('user_id', auth()->user()?->id)->first();
        if($bookmark) {
            $bookmarked = 1;
        } else {
            $bookmarked = 0;
        }
        $fields = [
            'id' => $this->id,
            'title' => $this->title,
            'type_id' => $this->type_id,
            'size' => $this->size,
            'price' => $this->price,
            'unit' => $this->unit,
            'province' => $this->province,
            'district' => $this->district,
            'published_at' => $this->published_at,
            'day_display' => $this->date_display,
            'point_avg' => $this->point_avg ? $this->point_avg : null,
            'bedroom' => $this->bedroom,
            'toilet' => $this->toilet,
            'floor' => $this->floor,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'address' => $this->address,
        ];
        return array_merge($fields, [
            'image' => $image,
            'number_image' => $number_image,
            'bookmark' => $bookmarked,
            'type' => $type,
        ]);
    }
}
