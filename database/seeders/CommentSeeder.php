<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::create([
            'user_id' => 1,
            'pub_id' => 1,
            'image_path' => 'https://ttol.vietnamnetjsc.vn//2017/10/29/18/32/5-mon-ngon-an-xong-chang-thay-tiec-cong-lam_1.jpg',
            'rate' => 5,
            'content' => 'Đồ ăn rất ngon'
        ]);
        Rating::create([
            'user_id' => 1,
            'pub_id' => 2,
            'image_path' => 'https://znews-photo.zadn.vn/w660/Uploaded/mdf_eioxrd/2020_09_02/pho_ga_ha_noi_1.jpg',
            'rate' => 3,
            'content' => 'Đồ ăn rất ngon'
        ]);
        Rating::create([
            'user_id' => 1,
            'pub_id' => 3,
            'image_path' => 'https://dulichvietnam.com.vn/vnt_upload/news/12_2019/ruou-ngon-3.jpg',
            'rate' => 5,
            'content' => 'Rượu ngon'
        ]);
        Rating::create([
            'user_id' => 2,
            'pub_id' => 1,
            'rate' => 3,
            'content' => 'Đồ ăn rất ngon'
        ]);
        Rating::create([
            'user_id' => 2,
            'pub_id' => 2,
            'image_path' => 'https://ttol.vietnamnetjsc.vn//2017/10/29/18/32/5-mon-ngon-an-xong-chang-thay-tiec-cong-lam_1.jpg',
            'rate' => 4,
            'content' => 'Đồ ăn rất ngon'
        ]);
        Rating::create([
            'user_id' => 2,
            'pub_id' => 3,
            'image_path' => 'https://ruouquehanoi.com/wp-content/uploads/2018/01/r%C6%B0%C6%A1%CC%A3u-ngon-4-660x330.jpg',
            'rate' => 3,
            'content' => 'Đồ ăn rất ngon'
        ]);

        Comment::create([
            'user_id' => 1,
            'pub_id' => 1,
            'content' => 'Ăn có ngon không?'
        ]);
    }
}
