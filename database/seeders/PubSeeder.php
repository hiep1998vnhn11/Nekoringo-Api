<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Pub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pub::create([
            'user_id' => 1,
            'name' => 'Quán sen',
            'home_photo_path' => 'https://www.oyorooms.com/travel-guide/wp-content/uploads/2019/05/Checking-out-Hyderabads-some-of-the-most-happening-pubs-Image-1.jpg',
            'main_email' => 'quansen.test@gmail.com',
            'phone_number' => '0123456789',
            'description' => 'Quán Sen ngon nhất Việt Nam',
            'address' => 'Hà Nội',
            'business_time' => '08:00 -> 19:00',
            'video_path' => 'https://www.youtube.com/embed/1_qgMtyx4Cw',
            'map_path' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3722.962082480466!2d105.81315221476305!3d21.074176591602587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aaed51aab37b%3A0x8659673a3d2db87c!2zTmjDoCBIw6BuZyBTZW4gVMOieSBI4buT!5e0!3m2!1svi!2s!4v1604934062393!5m2!1svi!2s'
        ]);

        Pub::create([
            'user_id' => 1,
            'name' => 'Nhà Hàng Rượu Thuốc',
            'home_photo_path' => 'https://lh5.googleusercontent.com/p/AF1QipMDIC42PWu4RKbdLYWswlejVqVZIzAtu9vDcoeq=w180-h180-n-k-no',
            'main_email' => 'quansen.test@gmail.com',
            'phone_number' => '0123456789',
            'description' => 'Trời chuyển mùa, nhâm nhi li rượu thuốc vàng óng ánh với chút mồi đặc sản thì là nhất rồi!',
            'address' => '88 Hồ, Phương Liệt, Đống Đa',
            'business_time' => '08:00 -> 22:00',
            'video_path' => 'https://www.youtube.com/embed/1_qgMtyx4Cw',
            'map_path' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3722.962082480466!2d105.81315221476305!3d21.074176591602587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aaed51aab37b%3A0x8659673a3d2db87c!2zTmjDoCBIw6BuZyBTZW4gVMOieSBI4buT!5e0!3m2!1svi!2s!4v1604934062393!5m2!1svi!2s'
        ]);

        Pub::create([
            'user_id' => 1,
            'name' => 'Quán Nhà Hàng Hoàng Thanh',
            'home_photo_path' => 'https://lh5.googleusercontent.com/p/AF1QipOZ-cjtZ-uWN1ZHGZijP2zI6WovUR4okTNODADU=w180-h180-n-k-no',
            'main_email' => 'hoangthanh.nhahang@gmail.com',
            'phone_number' => '0964253333',
            'description' => 'Ngon, giá hợp lý, phục vu nhiệt tình',
            'address' => 'Số 1, Ngách 53, Ngõ 252, Phố Tây Sơn, Trung Liệt, Đống Đa, Hà Nội',
            'business_time' => '10:00 -> 23:00',
            'video_path' => 'https://www.youtube.com/embed/PnjGhUMEYJk',
            'map_path' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3722.962082480466!2d105.81315221476305!3d21.074176591602587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aaed51aab37b%3A0x8659673a3d2db87c!2zTmjDoCBIw6BuZyBTZW4gVMOieSBI4buT!5e0!3m2!1svi!2s!4v1604934062393!5m2!1svi!2s'
        ]);

        Category::create([
            'name' => 'Sushi'
        ]);
        Dish::create([
            'category_id' => 1,
            'name' => 'Sushi',
            'photo_path' => 'https://upload.wikimedia.org/wikipedia/commons/6/60/Sushi_platter.jpg',
            'description' => 'Là món ăn Nhật Bản gồm cơm trộn giấm, kết hợp với các nguyên liệu khác'
        ]);
        Dish::create([
            'category_id' => 1,
            'name' => 'Dom Sushi',
            'photo_path' => 'https://daynauan.info.vn/wp-content/uploads/2015/06/sushi-hoa-van.jpg',
            'description' => 'Là món ăn Nhật Bản gồm cơm trộn giấm, kết hợp với các nguyên liệu khác'
        ]);

        Category::create([
            'name' => 'Buffet'
        ]);
        Dish::create([
            'category_id' => 2,
            'name' => 'Buffet Hải sản',
            'photo_path' => 'https://pasgo.vn/Upload/anh-chi-tiet/nha-hang-bay-seafood-buffet-ho-tay-1-normal-1166733542089.jpg',
            'description' => 'Chuyên các loại buffet hải sản cao cấp'
        ]);
        Dish::create([
            'category_id' => 2,
            'name' => 'Buffet Nướng',
            'photo_path' => 'https://storage.googleapis.com/senpoint-media-release/static/common/img/news-contents/aac4e209c7d4f6ba4649f906db4ecf9f_400_400.jpg',
            'description' => 'Buffet nướng cao cấp nhấtnhất'
        ]);

        Category::create([
            'name' => 'Barbecue'
        ]);
        Dish::create([
            'category_id' => 3,
            'name' => 'Sường nướng',
            'photo_path' => 'https://daylambanh.edu.vn/wp-content/uploads/2020/02/uop-thit-nuong-ngon.jpg',
            'description' => 'Thịt nướng siêu ngon'
        ]);
        Dish::create([
            'category_id' => 3,
            'name' => 'Thịt nướng',
            'photo_path' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcR_SSRkYIV3XpbXTeTg_S0av_WWYVFF3lljuw&usqp=CAU',
            'description' => 'Buffet nướng cao cấp nhấtnhất'
        ]);
    }
}
