<?php

namespace App\Repositories;

use App\Models\Language;
use Illuminate\Support\Collection;

class LanguageRepository
{
    public function __construct(private readonly Language $language)
    {
    } 

    public function store(array $attributes): Language
    {
        return $this->language->query()->create($attributes);
    }

    public function updateLanguage(int $id, array $values): bool|int
    {
        return $this->language->where('id', $id)->first()->update($values);
    }

    public function deleteLanguageById(int $id): bool|null
    {
        return $this->language->where('id', $id)->first()->delete();
    }

}
