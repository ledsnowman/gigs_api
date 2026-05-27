<?php
declare(strict_types=1);

namespace App\Models\ORM;

use Database\Factories\GigFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gig extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'gigs';
    protected $primaryKey = 'id';
    protected $fillable = [ 'title', 'description' ];

    protected static function newFactory(): GigFactory
    {
        return GigFactory::new();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'gig_category');
    }

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
        ];
    }
}
