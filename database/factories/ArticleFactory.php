<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $judul = $this->faker->name();
        $slug = Str::slug($judul, '-');
        $body = $this->faker->text();

        return [
            'uuid_article' => (string) Str::uuid(),
            'slug' => $slug,
            'judul' => $judul,
            'gambar' => '4y08aCotlIhktaFnqWSISGOyIrtfvfpcZPjMT1YcfVqi05FdUL.png',
            'gambar_rezized' => '4y08aCotlIhktaFnqWSISGOyIrtfvfpcZPjMT1YcfVqi05FdUL.png',
            'body' => $body,
            'body_clean' => $body,
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'total_view' => 0,
            'username' => 'user',
            'is_show' => 1
        ];
    }
}
