<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    protected $fillable = ['property_id', 'name', 'slug', 'description', 'max_occupancy', 'base_price_minor', 'currency', 'is_active'];

    protected function casts(): array { return ['is_active' => 'boolean', 'max_occupancy' => 'integer', 'base_price_minor' => 'integer']; }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

}
