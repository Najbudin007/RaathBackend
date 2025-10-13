<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait to generate a unique slug only when the title changes.
     */
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug($model, $model->title ?: $model->name);
        });

        static::updating(function ($model) {
            // Only update the slug if the title has changed
            if ($model->isDirty('name') || $model->isDirty('title')) {
                $model->slug = static::generateUniqueSlug($model, $model->title?: $model->name, $model->id);
            }
        });
    }

    /**
     * Generate a unique slug efficiently using SQL query.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $title
     * @param int|null $id (For updates, to exclude the current record)
     * @return string
     */
    protected static function generateUniqueSlug($model, $title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        // Check for existing slugs using LIKE
        $existingSlugs = $model->where('slug', 'LIKE', "$originalSlug%")
            ->when($id, fn($query) => $query->where('id', '!=', $id))
            ->pluck('slug')->toArray();

        // If no duplicate slug, return the original
        if (!in_array($slug, $existingSlugs)) {
            return $slug;
        }

        // Find the highest numerical suffix
        $max = 1;
        foreach ($existingSlugs as $existingSlug) {
            if (preg_match('/^' . preg_quote($originalSlug, '/') . '-(\d+)$/', $existingSlug, $matches)) {
                $max = max($max, (int) $matches[1] + 1);
            }
        }

        return $originalSlug . '-' . $max;
    }
}
