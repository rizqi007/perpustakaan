<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;
use App\Traits\Trashable;

class NavigationMenu extends Model
{
    use HasFactory, LogsActivity, Trashable;

    protected $fillable = [
        'label',
        'url',
        'route_name',
        'parent_id',
        'order',
        'is_active',
        'open_in_new_tab',
        'icon',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    /**
     * Parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavigationMenu::class, 'parent_id');
    }

    /**
     * Child menu items (sub-menus / dropdowns).
     */
    public function children(): HasMany
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get active children.
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    /**
     * Scope to get only top-level (root) menu items.
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get only active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the resolved URL for this menu item.
     */
    public function getResolvedUrlAttribute(): string
    {
        if ($this->route_name) {
            try {
                return route($this->route_name);
            } catch (\Exception $e) {
                return $this->url ?? '#';
            }
        }

        return $this->url ?? '#';
    }

    /**
     * Check if this menu item has children.
     */
    public function hasChildren(): bool
    {
        return $this->activeChildren()->count() > 0;
    }

    /**
     * Clear navigation menu cache on saved or deleted.
     */
    protected static function booted(): void
    {
        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget('navigation_menus'));
        static::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('navigation_menus'));
    }
}
