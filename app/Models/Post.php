<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=["body","user_id"];

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function group(){
        return $this->belongsTo(Group::class,"group_id");
    }

    public function attachments(){
        return $this->hasMany(PostAttachment::class);
    }
    
}
