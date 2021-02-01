<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    private $tags = [
        [
          'name' => 'remote',
        ],
        [
          'name' => 'full time',
        ],
        [
          'name' => 'Contract',
        ],
        [
          'name' => 'freelance',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tags as $index => $tag) {
            $tag['id'] = $this->generateId();
            $tag['created_at'] = now();
            $tag['updated_at'] = now();
            $tag['slug'] = \Illuminate\Support\Str::slug($tag['name'], '-');
            $result = Tag::create($tag);
            if (!$result) {
                $this->command->info('Insert failed at record $index.');
                return;
            }
        }
        $this->command->info('Inserted '.count($this->tags). ' tags');
    }

    /**
     * @return bool|string
     */
    public function generateId(){
        $id = substr(md5(substr(hexdec(uniqid()), -6)), -24);

        if(Tag::where('id', $id)->exists()){
            return $this->generateId();
        }

        return $id;
    }
}
