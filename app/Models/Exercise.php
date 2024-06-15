<?php

namespace App\Models;

use App\Enums\Orientation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'number',
        'height',
        'uses_cable',
        'url',
        'orientation',
        'video_url',
        'preview_image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uses_cable' => 'boolean',
        'orientation' => Orientation::class,
    ];

    public function diaryEntries(): HasMany
    {
        return $this->hasMany(DiaryEntry::class);
    }

    public function muscles(): BelongsToMany
    {
        return $this->belongsToMany(Muscle::class, 'exercise_muscle', 'exercise_id', 'muscle_id');
    }
}
