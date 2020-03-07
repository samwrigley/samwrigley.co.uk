<?php

namespace App;

use App\Article;
use App\Traits\HasManyArticles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SamWrigley\Support\Traits\HasPaths;

class User extends Authenticatable
{
    use HasPaths;
    use HasManyArticles;
    use Notifiable;

    /**
     * The route namespace.
     *
     * @var array
     */
    protected array $namespaces = [
        'web' => 'users.',
        'admin' => 'admin.users.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'email',
        'password',
        'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function publish(Article $article): void
    {
        $this->articles()->save($article);
    }
}
