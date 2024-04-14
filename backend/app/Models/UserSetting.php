<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'user_settings';
    protected $guarded = [];

    public function getSourcesAttribute(?string $value)
    {
        if (is_null($value)) return null;
        $sources = json_decode($value);
        return Source::whereIn('id', $sources)->get();
    }
    public function setSourcesAttribute(array $value): void
    {
        $this->attributes['sources'] = json_encode($value);
    }

    public function getCategoriesAttribute(?string $value)
    {
        if (is_null($value)) return null;
        $categories = json_decode($value);

        return Category::whereIn('id', $categories)->get();
    }
    public function setCategoriesAttribute(array $value): void
    {
        $this->attributes['categories'] = json_encode($value);
    }

    public function getAuthorsAttribute(?string $value)
    {
        if (is_null($value)) return null;
        $authors = json_decode($value);

        return Author::whereIn('id', $authors)->get();
    }
    public function setAuthorsAttribute(array $value): void
    {
        $this->attributes['authors'] = json_encode($value);
    }
}
