<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Nguyễn Công Chung','avatar' => '','address' => null,'phone' => '0987834319','tax_code' => null,'status' => 1,'email' => 'anhchunglinhthuong@gmail.com','password' => '$2y$10$1xFzDvP5j34SlHYku1E90eGQAZGPjd0Dz/NHo3CuBO0hLXSqsJYGm','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Điêu Văn Quỳnh','avatar' => '','address' => null,'phone' => '0372197928','tax_code' => null,'status' => 1,'email' => 'dieuvanquynh94@gmail.com','password' => '$2y$10$Asl7leDtLsE9uYm1mLz5UOXZBlUe.Yl5Uhln8GY99vs95t3vxC7Zu','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Mr Trung','avatar' => '','address' => null,'phone' => '0909268955','tax_code' => null,'status' => 1,'email' => 'trungtien195@gmail.com','password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Hưng','avatar' => '','address' => null,'phone' => '0355054228','tax_code' => null,'status' => 1,'email' => 'hung4@gmail.com','password' => '$2y$10$OxfKM2BI5JlEK8V7ly3CR.D3hq89/YmMg9JMgEnAeu8Sp35EJ8x9S','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Mr Phúc','avatar' => '','address' => null,'phone' => '0915111565','tax_code' => null,'status' => 1,'email' => 'phuc5@gmail.com','password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Bảo Ngọc','avatar' => 'https://guru.batdongsan.com.vn/p/c4e5a9faa55e3dff','address' => null,'phone' => '0376685183','tax_code' => null,'status' => 1,'email' => 'kieumaitrann@gmail.com','password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Lê Hùng','avatar' => 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/anh-dai-dien-facebook-dep-cho-nam-53-28-16-28-17.jpg','address' => null,'phone' => '0357124883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Lê Linh','avatar' => 'https://www.phanmemninja.com/wp-content/uploads/2023/06/avatar-facebook-dep-7.jpeg','address' => null,'phone' => '0357124812','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Nguyễn Hiệp','avatar' => '','address' => null,'phone' => '0357124845','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Phạm Hoàng','avatar' => '','address' => null,'phone' => '0357121283','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Nguyễn Đạt','avatar' => '','address' => null,'phone' => '0356124883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Tuấn Hưng','avatar' => '','address' => null,'phone' => '0356724883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Ngọc Khoa','avatar' => '','address' => null,'phone' => '0357189883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Lương Tuấn','avatar' => '','address' => null,'phone' => '035124883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Nguyễn Huy','avatar' => '','address' => null,'phone' => '0357124383','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Xuân Báu','avatar' => 'https://khoinguonsangtao.vn/wp-content/uploads/2022/05/avatar-dep-chat-nu.jpg','address' => null,'phone' => '0359994883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Đỗ Công Thuần','avatar' => '','address' => null,'phone' => '0357774883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Lê Bảo','avatar' => '','address' => null,'phone' => '0357894883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Nguyễn Linh','avatar' => 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/anh-avatar-facebook-12-1.jpg','address' => null,'phone' => '0312124883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()],
            ['name' => 'Cẩm Tú','avatar' => '','address' => null,'phone' => '0357183883','tax_code' => null,'status' => 1,'email' => Str::random(10)."@gmail.com",'password' => '$2y$10$fZKj/TWziGLKiM592csy1.NrcxjUDoLwX/uE7oVui78wNwIMrtB1y','role' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'email_verified_at' => Carbon::now()]
        ]);
    }
}
