<?php
declare(strict_types=1);

namespace App\Models\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $primaryKey = 'id';

    public function gigs(): BelongsToMany
    {
        return $this->belongsToMany(Gig::class, 'gig_category');
    }
}
