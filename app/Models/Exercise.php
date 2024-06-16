<?php

namespace App\Models;

use App\Enums\Orientation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\Muscle;

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
        'primary_muscles',
        'secondary_muscles'
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
        'primary_muscles' => 'array',
        'secondary_muscles' => 'array',
    ];

    public function getPrimaryMusclesLabelAttribute()
    {
        return collect($this->primary_muscles)
            ->map(fn($muscle) => Muscle::tryFrom($muscle)?->getLabel() ?? $muscle)
            ->implode(', ');
    }

    public function getSecondaryMusclesLabelAttribute()
    {
        return collect($this->secondary_muscles)
            ->map(fn($muscle) => Muscle::tryFrom($muscle)?->getLabel() ?? $muscle)
            ->implode(', ');
    }

    public function diaryEntries(): HasMany
    {
        return $this->hasMany(DiaryEntry::class);
    }
}
