<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Definisikan relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Definisikan relasi ke User (penanggung jawab task)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi untuk userstamps
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
