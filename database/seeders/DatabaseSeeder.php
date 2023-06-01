<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $carpeta = 'public/storage/posts';
    
        if (file_exists($carpeta)) {
            $this->deleteDirectory($carpeta);
        }
    
        mkdir($carpeta, 0777, true);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        Post::factory(5)->create();
    }
    
    /**
     * Elimina un directorio y su contenido de forma recursiva.
     *
     * @param string $dir
     * @return void
     */
    private function deleteDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
    
        $files = array_diff(scandir($dir), ['.', '..']);
    
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
    
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
    
        rmdir($dir);
    }
    
}
