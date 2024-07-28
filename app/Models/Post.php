<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'image',
    'admin_id',
  ];

  public function admin()
  {
    return $this->belongsTo(Admin::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class)->whereNull('parent_comment_id');
  }
}