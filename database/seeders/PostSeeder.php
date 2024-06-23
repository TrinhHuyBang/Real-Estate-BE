<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            ['user_id' => 1,'title' => 'Bán nhà Ngọc Lâm, Long Biên, Hà Nội 84m2* 4T 6.85 tỷ. Nhà đẹp siêu vip, 3 ô tô Civic đỗ cửa','description' => 'Thông tin mô tả.\n- Bán nhà Ngọc Lâm, Long Biên, Hà Nội. Gần bệnh viện Tâm Anh, Long Biên.
                - Nhà cực thoáng đẹp, thiết kế rất hợp lý. Khu vực dân trí vip của Long Biên. Trước nhà hai ô tô 7 chỗ tránh, đường thông, thoáng đẹp.
                - Sổ đỏ chính chủ, sang tên trong ngày.
                - Giá: 6.85 tỷ (thiện chí thương lượng).','province' => 'Thành phố Hà Nội-01','district' => 'Quận Long Biên-004','ward' => 'Phường Ngọc Lâm-00133','street' => '','address' => 'Phường Ngọc Lâm, Quận Long Biên, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 2,'floor' => 4,'size' => 84,'price' => 6850,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 16,'title' => 'Bán gấp biệt thự sân vườn Garden Homes Thủ Đức 246 m2 3 tầng 31,5 tỷ TL','description' => 'Chính chủ cần bán gấp biệt thự sân vườn Garden Homes 246m² (14,5 x 17) 3 Tầng chỉ 31,5 tỳ thương lượng, phường Hiệp Bình Phước Thủ Đức.\nMô Tả:
                + Vị trí ngay trung tâm Thủ Đức, ngay trường THPT NGUYỄN KHUYẾN, bên trong thì yên tĩnh, thoáng mát, xung quanh thì sầm uất tiện ích đầy đủ.
                + Khu vực ven sông, giáp các quận trung tâm, cách phạm văn đồng 5 phút đi xe, rất thuận tiện đi sân bay và các quận trung tâm.
                + Chủ tặng lại toàn bộ nội thất gỗ giá trị cho khách thiện chí.
                + Kết cấu: 3 tầng gác mái, thiết kế 4 phòng ngủ, 4 toilet riêng, sử dụng hệ thống điện năng lượng mặt trời. Sân vườn và gara đậu 3 xe.
                + Khu biệt thự Garden Homes cực kì an ninh, đường nhựa rộng xe hơi ra vào thoải mái, tiện ích nội khu đầy đủ gym, hồ bơi, sân tenic, sân banh, bóng rổ.
                ','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận Thủ Đức-762','ward' => 'Phường Hiệp Bình Phước-26809','street' => '','address' => 'Phường Hiệp Bình Phước, Quận Thủ Đức, Thành phố Hồ Chí Minh','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 4,'floor' => 4,'size' => 246,'price' => 31500,'unit' => 'VND','type_id' => 3,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 10,'title' => 'Cắt lỗ 300 - 800tr/căn chính chủ - Vinhomes Times City gửi danh sách CH chuyển nhượng giá rẻ nhất','description' => 'Trưởng phòng KD Vinhomes Times City - Park Hill.\nKính gửi tới quý khách thông tin liên quan đến căn hộ đang bán tại Vinhomes Times.
                City như sau:
                Cập nhật bảng giá hàng bán T09/2023.
                Tòa từ T1 đến T11 và T18:
                Căn 1PN - 53m² ở các tòa T08, 09, 11; giá từ 2,5-2.6 tỷ.
                Căn 2PN - 75m² ở các tòa T01, 04, 05, 06; 07; giá từ 3,6-3.7 tỷ.
                Căn 2PN - 82m² ở các tòa T08, 09, 11; giá từ 3,8-3.9 tỷ.
                Căn hoa hậu 2PN - 87m² ở các tòa T05, 06, 07; giá 4 - 4.1 tỷ.
                Căn hoa hậu 2PN - 94.3m² ở các tòa T02, 03; giá từ 4,5-4.6 tỷ.
                Căn góc 2PN sáng - 97,5m² ở các tòa T02, 03; giá từ 4.4-4.5 tỷ.
                Căn 2PN - 108.7m² ở các tòa T05, 06, 07; giá từ 5 - 5.1 tỷ.
                Căn 3PN - 95m² ở tòa T18 giá từ 4,5 tỷ bao phí.
                Căn góc 3PN - 104m² ở các tòa T08; 09; giá 5,3-5.4 tỷ.
                Căn góc 3PN - 109m² ở các tòa T08, 09; giá từ 5,7-5.8 tỷ.
                Căn góc 3PN - 110m² ở các tòa T01, 04, 05, 06, 07 giá từ 5.6-6 tỷ.
                Căn 3PN - 118m² ở các tòa từ T02, 03, giá từ 5.7-5.8 tỷ.
                Căn góc 4PN - 160m² ở các tòa T11 giá từ 8 - 8.5 tỷ bao phí.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hai Bà Trưng-007','ward' => 'Phường Vĩnh Tuy-00283','street' => 'Đường Minh Khai','address' => 'Đường Minh Khai, Phường Vĩnh Tuy, Quận Hai Bà Trưng, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 2,'floor' => 0,'size' => 95,'price' => 4500,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 19,'title' => 'Bán nhà 3.5 tầng xây mới ô tô vào nhà giá chỉ 2 tỷ tại Song Phương Hoài Đức Hà Nội.','description' => 'Chính chủ cần bán nhà 3.5 tầng xây mới full nội thất sẵn xách va ly vào ở.\nÔ tô vào nhà.
                Vị trí: Thôn Song Phương, Hoài Đức, Hà Nội.
                Diện tích 41m².
                Sổ đỏ cất két sẵn sang tên.
                Tiện ích ngập tràn như gần chợ, trường học & trạm y tế.
                Không khí trong lành thoáng đãng phù hợp anh chị mua ở để công tác nội đô.
                Vị trí mảnh đất cách Đại Lộ Thăng Long, DH 04 250m.
                Di chuyển trung tâm Hà Nội, bến xe Mỹ Đình 12 phút lái xe.
                Khu vực đường sang năm sẽ trải nhựa toàn khu.
                Cạnh khu quy hoạch làm trung tâm thương mại dịch vụ.
                Được các tập đoàn lớn như VinGroup, HaDo xin quỹ đất làm dự án.
                Khu vực này đang được đầu tư mạnh về hạ tầng để đủ tiêu chí lên quận Hoài Đức trong năm tới.','province' => 'Thành phố Hà Nội-01','district' => 'Huyện Hoài Đức-274','ward' => 'Xã Song Phương-09874','street' => 'Thôn Song Phương, Đường Đại lộ Thăng Long','address' => 'Thôn Song Phương, Đường Đại lộ Thăng Long, Xã Song Phương, Huyện Hoài Đức, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Sang, xịn, mịn, mới.','bedroom' => 3,'toilet' => 4,'floor' => 3,'size' => 41,'price' => 2000,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 1,'title' => 'Chỉ 1.9 tỷ bán nhà riêng, xây độc lập 3 tầng, sát Đại Lộ Thăng Long, Song Phương - Hoài Đức','description' => 'Bán nhà riêng 3 tầng xây độc lập, ô tô đỗ gần, Song Phương - Hoài Đức.\n- Sổ, pháp lý rõ ràng.
                - Diện tích 45m², nhà xây 3 tầng: 3 phòng ngủ, 2 vệ sinh, 1 sân phơi, ô tô đỗ cửa.
                - Bán kính 200m ra trường các cấp, chợ, ủy ban, bưu điện, nhà văn hóa..
                - Vị trí Song Phương - Hoài Đức, di chuyển vào nội thành 15 phút.
                - Giá 1,9 tỷ (có thương lượng)(bao phí sang tên).','province' => 'Thành phố Hà Nội-01','district' => 'Huyện Hoài Đức-274','ward' => 'Xã Song Phương-09874','street' => 'Đường Đại lộ Thăng Long','address' => 'Đường Đại lộ Thăng Long, Xã Song Phương, Huyện Hoài Đức, Thành phố Hà Nội','legal_documents' => 'Sổ, pháp lý rõ ràng','furniture' => 'Nội thất cơ bản','bedroom' => 3,'toilet' => 2,'floor' => 3,'size' => 45,'price' => 1900,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 5,'title' => 'Chỉ 1,77 tỷ, 42m2x4T, ô tô đỗ cửa, gần KĐT Đô Nghĩa cuối đường Tố Hữu','description' => 'Diện tích 42m² cực khủng gần Kđt Đô Nghĩa, Trường ĐH Phenikaa, cuối đường Tố Hữu kéo dài. Chỉ vài phút chạy xe.\n- Vị trí đẹp, sổ pháp lý rõ ràng.
                - Nhà xây 4 tầng, công năng 3 phòng ngủ, 2 vs, 1 sân phơi.
                - Thuận tiện ra BX Yên Nghĩa, Tố Hữu, Lê Trọng Tấn, Đại học Phennikaa.
                - Bán kính 200m là trường, chợ, nhà văn Hoá.
                - Hàng xóm thân thiện.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Yên Nghĩa-09562','street' => 'Đường Tố Hữu','address' => 'Đường Tố Hữu, Phường Yên Nghĩa, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Pháp lý rõ ràng, sổ đỏ đầy đủ','furniture' => 'Nội thất cơ bản','bedroom' => 3,'toilet' => 3,'floor' => 4,'size' => 42,'price' => 1770,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 18,'title' => 'Bán nhà 4 tầng sau KĐT Geleximco Dương Nội, gần Aeonmall, Thiên Đường Bảo Sơn. Giá chỉ 2.53 tỷ','description' => 'Nhà 4 tầng lô góc ôtô đỗ cửa Minh Khai - La Phù. Cách trục đường Lê Trọng Tấn Dương Nội, Khu D Geleximco khoảng 1km.\n- Gần Aeon Mall Hà Đông, Thiên Đường Bảo Sơn,
                - Phù hợp với quý a. C ở Cầu Giấy, Mỹ Đình, Thanh Xuân, Hà Đông.
                - Tiện ích ngập tràn tứ phía, Hỗ trợ trả góp 70%.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Dương Nội-09886','street' => 'Đường Minh Khai','address' => 'Đường Minh Khai, Phường Dương Nội, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Pháp lý rõ ràng','furniture' => 'Nội thất cơ bản','bedroom' => 3,'toilet' => 3,'floor' => 4,'size' => 36,'price' => 2530,'unit' => 'VND','type_id' => 2,'status' => 2, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 18,'title' => 'Chuyên cho thuê căn hộ cao cấp Masteri Thảo Điền từ 1PN - 2PN đến 4PN, giá tốt nhất','description' => 'Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.\nBalcony view hướng ra sông, view hồ bơi và view đại lộ hướng tránh nắng và thông thoáng.
                An ninh: Bảo vệ 24/24, ra vào cổng bằng thẻ từ an ninh dành riêng cho cư dân.
                Vị trí:
                Mặt tiền giáp Xa Lộ Hà Nội (Đường Võ Nguyên Giáp) vị trí thuận lợi cách đến quận 1 chỉ 15 phút di chuyển, 20 phút đến sân bay Tân Sơn Nhất, bước vài bước chân đến nhà ga tuyến Metro và trung tâm thương mại Vincom Megamall Quận 2.
                Khu căn hộ đạt tiêu chuẩn phòng cháy chữa cháy tốt. Có tập huấn định kỳ.
                Tiện ích nội khu gồm: Hồ bơi tầng 3 kết hợp khu BBQ, gym, sân tennis, sân bóng rổ, công viên trung tâm... (miễn phí).
                Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.
                Balcony nhiều hướng view sông Sài Gòn, view hồ bơi và View Landmark 81 hướng tránh nắng và thông thoáng.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 2-769','ward' => 'Phường Thảo Điền-27088','street' => 'Đường Xa Lộ Hà Nội','address' => 'Đường Xa Lộ Hà Nội, Phường Thảo Điền, Quận 2, Thành phố Hồ Chí Minh','legal_documents' => 'Đã có sổ.','furniture' => 'Hoàn thiện full nội thất','bedroom' => 2,'toilet' => 2,'floor' => 0,'size' => 72,'price' => 16,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 8,'title' => 'Chuyên cho thuê căn hộ cao cấp Masteri Thảo Điền từ 1PN - 2PN đến 4PN, giá tốt nhất','description' => 'Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.\nBalcony view hướng ra sông, view hồ bơi và view đại lộ hướng tránh nắng và thông thoáng.
                An ninh: Bảo vệ 24/24, ra vào cổng bằng thẻ từ an ninh dành riêng cho cư dân.
                Vị trí:
                Mặt tiền giáp Xa Lộ Hà Nội (Đường Võ Nguyên Giáp) vị trí thuận lợi cách đến quận 1 chỉ 15 phút di chuyển, 20 phút đến sân bay Tân Sơn Nhất, bước vài bước chân đến nhà ga tuyến Metro và trung tâm thương mại Vincom Megamall Quận 2.
                Khu căn hộ đạt tiêu chuẩn phòng cháy chữa cháy tốt. Có tập huấn định kỳ.
                Tiện ích nội khu gồm: Hồ bơi tầng 3 kết hợp khu BBQ, gym, sân tennis, sân bóng rổ, công viên trung tâm... (miễn phí).
                Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.
                Balcony nhiều hướng view sông Sài Gòn, view hồ bơi và View Landmark 81 hướng tránh nắng và thông thoáng.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 2-769','ward' => 'Phường Thảo Điền-27088','street' => 'Đường Xa Lộ Hà Nội','address' => 'Đường Xa Lộ Hà Nội, Phường Thảo Điền, Quận 2, Thành phố Hồ Chí Minh','legal_documents' => 'Đã có sổ.','furniture' => 'Hoàn thiện full nội thất','bedroom' => 2,'toilet' => 2,'floor' => 0,'size' => 72,'price' => 16,'unit' => 'VND','type_id' => 12,'status' => 2, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 19,'title' => 'CHUYÊN CHO THUÊ CĂN HỘ ECO GREEN 1PN - 2PN - 3PN GIÁ TỐT NHẤT THỊ TRƯỜNG','description' => 'Vị trí của dự án: 107 Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7.\n- Nằm giữa 3 khu đô thị lớn nhất thành phố Sài Gòn là: Quận 1, khu đô thị Phú Mỹ Hưng (quận 7) và khu đô thị mới Thủ Thiêm (quận 2).
                - Mất 12 phút di chuyển đến quận 1 (phố đi bộ Nguyễn Huệ) thông qua tuyến đường Nguyễn Tất Thành - Cầu Tân Thuận Quận 4.
                - Cách Đại học RMIT và Đại học Tôn Đức Thắng 5km.
                Tiện ích dự án:
                - Gym, hồ bơi, khu vui chơi trẻ em, Công Viên nội khu Eco Park kết hợp BBQ.
                - Cửa hàng tiện lợi Family mart 24h, Winmart, Pharmacity, Coffee, Bách Hoá Xanh, Trường học mầm non, trường tiểu học (Cách 500m).','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 7-778','ward' => 'Phường Tân Thuận Tây-27469','street' => 'Đường Nguyễn Văn Linh','address' => 'Đường Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7, Thành phố Hồ Chí Minh','legal_documents' => '','furniture' => 'Nội thất cơ bản chủ đầu tư.','bedroom' => 2,'toilet' => 2,'floor' => 0,'size' => 72,'price' => 12,'unit' => 'VND','type_id' => 12,'status' => 2, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 9,'title' => 'CHUYÊN CHO THUÊ CĂN HỘ ECO GREEN 1PN - 2PN - 3PN GIÁ TỐT NHẤT THỊ TRƯỜNG','description' => 'Vị trí của dự án: 107 Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7.\n- Nằm giữa 3 khu đô thị lớn nhất thành phố Sài Gòn là: Quận 1, khu đô thị Phú Mỹ Hưng (quận 7) và khu đô thị mới Thủ Thiêm (quận 2).
                - Mất 12 phút di chuyển đến quận 1 (phố đi bộ Nguyễn Huệ) thông qua tuyến đường Nguyễn Tất Thành - Cầu Tân Thuận Quận 4.
                - Cách Đại học RMIT và Đại học Tôn Đức Thắng 5km.
                Tiện ích dự án:
                - Gym, hồ bơi, khu vui chơi trẻ em, Công Viên nội khu Eco Park kết hợp BBQ.
                - Cửa hàng tiện lợi Family mart 24h, Winmart, Pharmacity, Coffee, Bách Hoá Xanh, Trường học mầm non, trường tiểu học (Cách 500m).','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 7-778','ward' => 'Phường Tân Thuận Tây-27469','street' => 'Đường Nguyễn Văn Linh','address' => 'Đường Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7, Thành phố Hồ Chí Minh','legal_documents' => '','furniture' => 'Nội thất cơ bản chủ đầu tư.','bedroom' => 2,'toilet' => 2,'floor' => 0,'size' => 72,'price' => 12,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 16,'title' => 'Cho thuê nhà nguyên căn mới hoàn toàn đường Vũ Chí Hiếu, Quận 5, DT 60m2, giá 30 triệu/tháng','description' => '- Nhà mới hoàn toàn, diện tích 60m².\n- Khu nhà ngay chợ Kim Biên, tiện lợi cho việc kinh doanh. Ưu tiên cho anh chị nào có thiện chí thuê ở lâu dài.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 5-774','ward' => 'Phường 13-27343','street' => '47 Đường Vũ Chí Hiếu','address' => '47 Đường Vũ Chí Hiếu, Phường 13, Quận 5, Thành phố Hồ Chí Minh','legal_documents' => 'Hợp đồng mua bán','furniture' => 'Không nội thất','bedroom' => 4,'toilet' => 5,'floor' => 3,'size' => 60,'price' => 30,'unit' => 'VND','type_id' => 13,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 14,'title' => 'Cho thuê nhà, đầy đủ nội thất, khu dân cư Hiệp Thành 3, Tp Thủ Dầu Một','description' => 'Nhà phố, đầy đủ nội thất, nằm ở trung tâm thành phố Thủ Dầu Một.\nDiện tích nhà 175m² có 3 phòng ngủ, 3 nhà vệ sinh.
                Giá thuê 12 triệu / tháng.','province' => 'Tỉnh Bình Dương-74','district' => 'Thành phố Thủ Dầu Một-718','ward' => 'Phường Hiệp Thành-25741','street' => 'Đường Phạm Ngọc Thạch','address' => 'Đường Phạm Ngọc Thạch, Phường Hiệp Thành, Thành phố Thủ Dầu Một, Tỉnh Bình Dương','legal_documents' => '','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 3,'floor' => 3,'size' => 175,'price' => 12,'unit' => 'VND','type_id' => 13,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 15,'title' => 'Chính chủ cần bán gấp căn hộ 96m2 3pn 2wc sổ đỏ chính chủ nội thất đầy đủ đồ toà CT5 Xa La, Hà Đông','description' => 'Nhà có thêm thành viên mới, cần chuyển đổi lên căn hộ rộng hơn, vì vậy, chính chủ mình cần bán gấp căn hộ tòa ct5 Xa La tại khu đô thị Xa La, Hà Đông. Thông tin căn hộ như sau:\n- Diện tích: 96m².
                - Thiết kế căn hộ: 3PN 2WC.
                - Nội thất: Gia đình để lại bàn ghế, điều hòa, nóng lạnh, tủ bếp,...
                - Giá bán: Nhỉnh 2 tỷ.
                Căn hộ ở rất có lộc, nhà đẹp không thấm ẩm, xung quanh tòa nhà bạt ngàn tiện ích, các tuyến đường giao thông đi lại thuận lợi.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 2,'floor' => 1,'size' => 96,'price' => 2550,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 10,'title' => 'Bán gấp trong tuần - căn 84m2 2 ngủ CT1 Xa La - Giá 1,55 tỷ','description' => 'Chính chủ bán căn 84m² tòa CT1 Xa La - Hà Đông - Giá 1,55 tỷ \n- Diện tích: 84m².
                - Hướng cửa: Tây Nam, ban công: Tây Bắc.
                - Thiết kế căn hộ: 2 phòng ngủ, 1 vệ sinh, 1 phòng khách.
                - Nội thất gồm toàn bộ nội thất gắn tường điều hòa, nóng lạnh, giường, tủ quần áo.
                - Giá bán: 1.55 tỷ.
                - Pháp lý: Hợp đồng chính chủ, sẵn sàng giao dịch, sang tên nhanh chóng.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => '','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 1,'floor' => 3,'size' => 84,'price' => 1550,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 1,'title' => 'Chính chủ bán căn hộ 58m2 2PN tòa trung tâm thương mại KĐT Xa La - Có sổ đỏ.','description' => 'Chuyển công tác nên gia đình muốn nhượng lại căn góc ở tòa trung tâm thương mại khu đô thị Xa La cho hộ gia đình nào có nhu cầu. Chi tiết căn hộ như sau:\n- Diện tích: 58m².
                - Hướng cửa: Đông Bắc, ban công: Tây Nam.
                - Thiết kế căn hộ: 2 phòng ngủ, 1 vệ sinh, 1 khách, 1 ban công thoáng.
                - Nội thất gồm những gì để lại: Điều hòa, tủ bếp, nóng lạnh, giường, tủ, bàn ghế... Khách mua chỉ cần xách vali về ở.
                - Giá thương lượng và gia lộc cho khách nhiệt tình hợp duyên).
                - Pháp lý: SĐCC.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => null,'floor' => 3,'size' => 58,'price' => 1230,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 15,'title' => 'Sở hữu căn hộ chung cư học viện Quân Y, Xa La, 70m2, 2 phòng ngủ, 2WC sổ đỏ chính chủ NT full đồ','description' => 'Chuyển công tác nên gia đình muốn nhượng lại căn hộ chung cư tòa học viện Quân Y - Gần khu đô thị Xa La cho hộ gia đình nào có nhu cầu. Chi tiết căn hộ như sau:\n- Diện tích: 70m².
                - Hướng cửa: Đông Bắc, ban công: Tây Nam.
                - Thiết kế căn hộ: 2 phòng ngủ, 2 vệ sinh, 1 khách, 1 ban công thoáng.
                - Nội thất gồm những gì để lại: Điều hòa, tủ bếp, nóng lạnh, giường, tủ, bàn ghế... Khách mua chỉ cần xách vali về ở.
                - Giá bán: 2,0x tỷ (x nhỏ) có thương lượng).
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch, hỗ trợ khách mua trả góp.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 2,'floor' => 3,'size' => 70,'price' => 2050,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 14,'title' => 'Chính chủ bán gấp căn hộ 54m2 tòa CT4 Xa La, sổ đỏ chính chủ, giá 920 triệu.','description' => 'Chính chủ làm ăn được lộc, chuyển sang căn hộ 2 phòng ngủ, vì vậy quyết định bán nhanh căn hộ 1 phòng ngủ tại tòa CT4, chung cư KHu đô thị Xa La, Hà Đông, Hà Nội.\n- Diện tích: 54m vuông, thiết kế 1 phòng ngủ + 1 vệ sinh, 1 phòng khách, 1 ban công thoáng.
                - Nội thất: Đầy đủ đồ cơ bản, khách chỉ việc xách vali về ở.
                - Pháp lý: Sổ hồng chính chủ.
                - Giá bán: 920 triệu.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ hồng','furniture' => 'Cơ bản','bedroom' => 1,'toilet' => 1,'floor' => 2,'size' => 54,'price' => 920,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 4,'title' => 'Bán căn 59m2 2 ngủ tòa CT8 Đại Thanh. Giá 1,29 tỷ - nội thất đẹp','description' => 'Chính chủ bán căn hộ 2 phòng ngủ thoáng đẹp tại tòa CT8, chung cư Đại Thanh, Thanh Trì.\n* Diện tích: 59 m².
                * Hướng cửa: Tây Bắc, ban công Đông Nam.
                * Thiết kế căn hộ: 2 phòng ngủ, 1 vệ sinh, phòng bếp, 1 khách.
                * Nội thất để lại: Full đồ. Sàn gỗ, trần thạch cao, tủ bếp, bếp từ, hút mùi, điều hòa, nóng lạnh, sofa, giường ngủ, quần áo...
                * Pháp lý: Hợp đồng chính chủ, sẵn sàng giao dịch, hỗ trợ khách mua trả góp.
                * Giá: 1,29 tỷ.','province' => 'Thành phố Hà Nội-01','district' => 'Huyện Thanh Trì-020','ward' => 'Xã Tả Thanh Oai-00649','street' => 'Đường Phan Trọng Tuệ','address' => 'Đường Phan Trọng Tuệ, Xã Tả Thanh Oai, Huyện Thanh Trì, Thành phố Hà Nội','legal_documents' => '','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 1,'floor' => 0,'size' => 59,'price' => 1290,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 8,'title' => 'Chính chủ cần bán căn 47m Đại Thanh - Sổ đỏ sẵn sàng giao dịch, Giá 1,1x tỷ','description' => 'Chính chủ thiện chí bán nhanh căn hộ diện tích 47m tại tòa CT10, chung cư Đại Thanh, Thanh Trì, Hà Nội\n- Thiết kế căn hộ: 1 phòng ngủ, 1 vệ sinh, 1 phòng khách rộng, 1 ban công thoáng (Có thể thiết kế thành 2 phòng ngủ)
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch
                - Nội thất: đầy đủ sàn gỗ, bàn ghế, nóng lạnh, điều hòa, giường tủ,... khách mua chỉ việc về ở
                - Giá bán: 1,17 tỷ','province' => 'Thành phố Hà Nội-01','district' => 'Huyện Thanh Trì-020','ward' => 'Xã Tả Thanh Oai-00649','street' => 'Đường Phan Trọng Tuệ','address' => 'Đường Phan Trọng Tuệ, Xã Tả Thanh Oai, Huyện Thanh Trì, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 1,'toilet' => 1,'floor' => 3,'size' => 48,'price' => 1170,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 16,'title' => 'Cần bán căn góc 45,5m2 tầng 28 tòa CT8 Đại Thanh - Có sổ đỏ - Nội thất mới đẹp','description' => 'Chính chủ chuyển đổi sang căn 3 phòng ngủ, vì vậy cần bán nhanh căn hộ lô góc 1 phòng ngủ tại tòa CT8, chung cư Đại Thanh, Thanh Trì, Hà Nội.\n- Diện tích: 45,5m².
                - Thiết kế căn hộ: 2 phòng ngủ, 2 vệ sinh.
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch, hỗ trợ khách mua vay bank.
                - Nội thất: Đầy đủ trần thạch cao, sàn gỗ, điều hòa, nóng lạnh, giường, tủ,...
                - Giá bán: 1,1x tỷ (Có thương lượng).','province' => 'Thành phố Hà Nội-01','district' => 'Huyện Thanh Trì-020','ward' => 'Xã Tả Thanh Oai-00649','street' => 'Đường Phan Trọng Tuệ','address' => 'Đường Phan Trọng Tuệ, Xã Tả Thanh Oai, Huyện Thanh Trì, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 1,'toilet' => 1,'floor' => 0,'size' => 45,'price' => null,'unit' => 'Thoả Thuận','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 5,'title' => 'Bán căn hộ full nội thất đẹp tại tòa CT1 Xa La - 83m2 - 2 ngủ - Có sổ đỏ.','description' => 'Nhà có thêm thành viên mới, cần chuyển đổi lên căn hộ rộng hơn, vì vậy, chính chủ mình cần bán gấp căn hộ tòa Nam Xa La tại khu đô thị Xa La, Hà Đông. Thông tin căn hộ như sau:\n- Diện tích: 83m².
                - Thiết kế căn hộ: 2PN 2WC.
                - Hướng Tây Nam, Ban Công đông Bắc.
                - Nội thất: Gia đình để lại bàn ghế, điều hòa, nóng lạnh, tủ bếp,...
                - Giá bán: 2, x tỷ.
                - Giấy tờ: Sổ hồng chính chủ, sang tên nhanh gọn.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 2,'floor' => 3,'size' => 83,'price' => null,'unit' => 'Thoả Thuận','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 12,'title' => 'Còn duy nhất căn 3 phòng ngủ tòa CT1 Vinmart KĐT Xa La - 101m2 - Có sổ đỏ chính chủ - Giá 2,5x tỷ','description' => 'Chính chủ làm ăn được lộc, đã mua được căn nhà liền kề, vì vậy có nhu cầu bán nhanh căn hộ 3 phòng ngủ tại tòa CT1 gần Vinmart, KĐT Xa La, Hà Đông, Hà Nội.\n- Diện tích: 101m².
                - Thiết kế căn hộ: 3 phòng ngủ, 2 vệ sinh, 1 phòng khách rộng, ban công thoáng.
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch.
                - Nội thất: Sàn gỗ, trần thạch cao, điều hòa, nóng lạnh, bàn ghế, giường, tủ bếp, tủ quần áo,... Khách mua chỉ việc xách vali về ở.
                - Giá bán: 2,5x tỷ (Có thương lượng).','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Phúc La-09553','street' => 'Phố Phùng Hưng','address' => 'Phố Phùng Hưng, Phường Phúc La, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 2,'floor' => 2,'size' => 101,'price' => null,'unit' => 'Thoả Thuận','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 16,'title' => 'Bán nhà Ngọc Lâm, Long Biên, Hà Nội 84m2* 4T 6.85 tỷ. Nhà đẹp siêu vip, 3 ô tô Civic đỗ cửa','description' => 'Thông tin mô tả.\n- Bán nhà Ngọc Lâm, Long Biên, Hà Nội. Gần bệnh viện Tâm Anh, Long Biên.
                - Nhà cực thoáng đẹp, thiết kế rất hợp lý. Khu vực dân trí vip của Long Biên. Trước nhà hai ô tô 7 chỗ tránh, đường thông, thoáng đẹp.
                - Sổ đỏ chính chủ, sang tên trong ngày.
                - Giá: 6.85 tỷ (thiện chí thương lượng).','province' => 'Thành phố Hà Nội-01','district' => 'Quận Ba Đình-001','ward' => 'Phường Thành Công-00034','street' => '','address' => 'Phường Thành Công, Quận Ba Đình, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 1,'toilet' => 0,'floor' => 1,'size' => 181,'price' => 14,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 12,'title' => 'Bán gấp biệt thự sân vườn Garden Homes Thủ Đức 246 m2 3 tầng 31,5 tỷ TL','description' => 'Chính chủ cần bán gấp biệt thự sân vườn Garden Homes 246m² (14,5 x 17) 3 Tầng chỉ 31,5 tỳ thương lượng, phường Hiệp Bình Phước Thủ Đức.\nMô Tả:
                + Vị trí ngay trung tâm Thủ Đức, ngay trường THPT NGUYỄN KHUYẾN, bên trong thì yên tĩnh, thoáng mát, xung quanh thì sầm uất tiện ích đầy đủ.
                + Khu vực ven sông, giáp các quận trung tâm, cách phạm văn đồng 5 phút đi xe, rất thuận tiện đi sân bay và các quận trung tâm.
                + Chủ tặng lại toàn bộ nội thất gỗ giá trị cho khách thiện chí.
                + Kết cấu: 3 tầng gác mái, thiết kế 4 phòng ngủ, 4 toilet riêng, sử dụng hệ thống điện năng lượng mặt trời. Sân vườn và gara đậu 3 xe.
                + Khu biệt thự Garden Homes cực kì an ninh, đường nhựa rộng xe hơi ra vào thoải mái, tiện ích nội khu đầy đủ gym, hồ bơi, sân tenic, sân banh, bóng rổ.
                ','province' => 'Thành phố Hà Nội-01','district' => 'Quận Ba Đình-001','ward' => 'Phường Thành Công-00034','street' => '','address' => 'Phường Thành Công, Quận Ba Đình, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 0,'toilet' => 3,'floor' => 1,'size' => 152,'price' => 14,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 7,'title' => 'Cắt lỗ 300 - 800tr/căn chính chủ - Vinhomes Times City gửi danh sách CH chuyển nhượng giá rẻ nhất','description' => 'Trưởng phòng KD Vinhomes Times City - Park Hill.\nKính gửi tới quý khách thông tin liên quan đến căn hộ đang bán tại Vinhomes Times.
                City như sau:
                Cập nhật bảng giá hàng bán T09/2023.
                Tòa từ T1 đến T11 và T18:
                Căn 1PN - 53m² ở các tòa T08, 09, 11; giá từ 2,5-2.6 tỷ.
                Căn 2PN - 75m² ở các tòa T01, 04, 05, 06; 07; giá từ 3,6-3.7 tỷ.
                Căn 2PN - 82m² ở các tòa T08, 09, 11; giá từ 3,8-3.9 tỷ.
                Căn hoa hậu 2PN - 87m² ở các tòa T05, 06, 07; giá 4 - 4.1 tỷ.
                Căn hoa hậu 2PN - 94.3m² ở các tòa T02, 03; giá từ 4,5-4.6 tỷ.
                Căn góc 2PN sáng - 97,5m² ở các tòa T02, 03; giá từ 4.4-4.5 tỷ.
                Căn 2PN - 108.7m² ở các tòa T05, 06, 07; giá từ 5 - 5.1 tỷ.
                Căn 3PN - 95m² ở tòa T18 giá từ 4,5 tỷ bao phí.
                Căn góc 3PN - 104m² ở các tòa T08; 09; giá 5,3-5.4 tỷ.
                Căn góc 3PN - 109m² ở các tòa T08, 09; giá từ 5,7-5.8 tỷ.
                Căn góc 3PN - 110m² ở các tòa T01, 04, 05, 06, 07 giá từ 5.6-6 tỷ.
                Căn 3PN - 118m² ở các tòa từ T02, 03, giá từ 5.7-5.8 tỷ.
                Căn góc 4PN - 160m² ở các tòa T11 giá từ 8 - 8.5 tỷ bao phí.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Ba Đình-001','ward' => 'Phường Thành Công-00034','street' => '','address' => 'Phường Thành Công, Quận Ba Đình, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 1,'floor' => 1,'size' => 156,'price' => 10,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 14,'title' => 'Bán nhà 3.5 tầng xây mới ô tô vào nhà giá chỉ 2 tỷ tại Song Phương Hoài Đức Hà Nội.','description' => 'Chính chủ cần bán nhà 3.5 tầng xây mới full nội thất sẵn xách va ly vào ở.\nÔ tô vào nhà.
                Vị trí: Thôn Song Phương, Hoài Đức, Hà Nội.
                Diện tích 41m².
                Sổ đỏ cất két sẵn sang tên.
                Tiện ích ngập tràn như gần chợ, trường học & trạm y tế.
                Không khí trong lành thoáng đãng phù hợp anh chị mua ở để công tác nội đô.
                Vị trí mảnh đất cách Đại Lộ Thăng Long, DH 04 250m.
                Di chuyển trung tâm Hà Nội, bến xe Mỹ Đình 12 phút lái xe.
                Khu vực đường sang năm sẽ trải nhựa toàn khu.
                Cạnh khu quy hoạch làm trung tâm thương mại dịch vụ.
                Được các tập đoàn lớn như VinGroup, HaDo xin quỹ đất làm dự án.
                Khu vực này đang được đầu tư mạnh về hạ tầng để đủ tiêu chí lên quận Hoài Đức trong năm tới.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Mộ Lao-09541','street' => '','address' => 'Phường Mộ Lao, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Sang, xịn, mịn, mới.','bedroom' => 0,'toilet' => 2,'floor' => 3,'size' => 63,'price' => 12,'unit' => 'VND','type_id' => 13,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 2,'title' => 'Chỉ 1.9 tỷ bán nhà riêng, xây độc lập 3 tầng, sát Đại Lộ Thăng Long, Song Phương - Hoài Đức','description' => 'Bán nhà riêng 3 tầng xây độc lập, ô tô đỗ gần, Song Phương - Hoài Đức.\n- Sổ, pháp lý rõ ràng.
                - Diện tích 45m², nhà xây 3 tầng: 3 phòng ngủ, 2 vệ sinh, 1 sân phơi, ô tô đỗ cửa.
                - Bán kính 200m ra trường các cấp, chợ, ủy ban, bưu điện, nhà văn hóa..
                - Vị trí Song Phương - Hoài Đức, di chuyển vào nội thành 15 phút.
                - Giá 1,9 tỷ (có thương lượng)(bao phí sang tên).','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 10-771','ward' => 'Phường 04-27193','street' => '','address' => 'Phường 04, Quận 10, Thành phố Hồ Chí Minh','legal_documents' => 'Sổ, pháp lý rõ ràng','furniture' => 'Nội thất cơ bản','bedroom' => 1,'toilet' => 0,'floor' => 0,'size' => 71,'price' => 23,'unit' => 'VND','type_id' => 13,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 2,'title' => 'Chỉ 1,77 tỷ, 42m2x4T, ô tô đỗ cửa, gần KĐT Đô Nghĩa cuối đường Tố Hữu','description' => 'Diện tích 42m² cực khủng gần Kđt Đô Nghĩa, Trường ĐH Phenikaa, cuối đường Tố Hữu kéo dài. Chỉ vài phút chạy xe.\n- Vị trí đẹp, sổ pháp lý rõ ràng.
                - Nhà xây 4 tầng, công năng 3 phòng ngủ, 2 vs, 1 sân phơi.
                - Thuận tiện ra BX Yên Nghĩa, Tố Hữu, Lê Trọng Tấn, Đại học Phennikaa.
                - Bán kính 200m là trường, chợ, nhà văn Hoá.
                - Hàng xóm thân thiện.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 10-771','ward' => 'Phường 04-27193','street' => '','address' => 'Phường 04, Quận 10, Thành phố Hồ Chí Minh','legal_documents' => 'Pháp lý rõ ràng, sổ đỏ đầy đủ','furniture' => 'Nội thất cơ bản','bedroom' => 0,'toilet' => 1,'floor' => 3,'size' => 196,'price' => 2310,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 19,'title' => 'Bán nhà 4 tầng sau KĐT Geleximco Dương Nội, gần Aeonmall, Thiên Đường Bảo Sơn. Giá chỉ 2.53 tỷ','description' => 'Nhà 4 tầng lô góc ôtô đỗ cửa Minh Khai - La Phù. Cách trục đường Lê Trọng Tấn Dương Nội, Khu D Geleximco khoảng 1km.\n- Gần Aeon Mall Hà Đông, Thiên Đường Bảo Sơn,
                - Phù hợp với quý a. C ở Cầu Giấy, Mỹ Đình, Thanh Xuân, Hà Đông.
                - Tiện ích ngập tràn tứ phía, Hỗ trợ trả góp 70%.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 10-771','ward' => 'Phường 04-27193','street' => '','address' => 'Phường 04, Quận 10, Thành phố Hồ Chí Minh','legal_documents' => 'Pháp lý rõ ràng','furniture' => 'Nội thất cơ bản','bedroom' => 1,'toilet' => 1,'floor' => 1,'size' => 166,'price' => 1300,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 12,'title' => 'Chuyên cho thuê căn hộ cao cấp Masteri Thảo Điền từ 1PN - 2PN đến 4PN, giá tốt nhất','description' => 'Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.\nBalcony view hướng ra sông, view hồ bơi và view đại lộ hướng tránh nắng và thông thoáng.
                An ninh: Bảo vệ 24/24, ra vào cổng bằng thẻ từ an ninh dành riêng cho cư dân.
                Vị trí:
                Mặt tiền giáp Xa Lộ Hà Nội (Đường Võ Nguyên Giáp) vị trí thuận lợi cách đến quận 1 chỉ 15 phút di chuyển, 20 phút đến sân bay Tân Sơn Nhất, bước vài bước chân đến nhà ga tuyến Metro và trung tâm thương mại Vincom Megamall Quận 2.
                Khu căn hộ đạt tiêu chuẩn phòng cháy chữa cháy tốt. Có tập huấn định kỳ.
                Tiện ích nội khu gồm: Hồ bơi tầng 3 kết hợp khu BBQ, gym, sân tennis, sân bóng rổ, công viên trung tâm... (miễn phí).
                Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.
                Balcony nhiều hướng view sông Sài Gòn, view hồ bơi và View Landmark 81 hướng tránh nắng và thông thoáng.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 3-770','ward' => 'Phường 04-27148','street' => '','address' => 'Phường 04, Quận 3, Thành phố Hồ Chí Minh','legal_documents' => 'Đã có sổ.','furniture' => 'Hoàn thiện full nội thất','bedroom' => 3,'toilet' => 3,'floor' => 3,'size' => 111,'price' => 4120,'unit' => 'Thoả Thuận','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 2,'title' => 'Chuyên cho thuê căn hộ cao cấp Masteri Thảo Điền từ 1PN - 2PN đến 4PN, giá tốt nhất','description' => 'Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.\nBalcony view hướng ra sông, view hồ bơi và view đại lộ hướng tránh nắng và thông thoáng.
                An ninh: Bảo vệ 24/24, ra vào cổng bằng thẻ từ an ninh dành riêng cho cư dân.
                Vị trí:
                Mặt tiền giáp Xa Lộ Hà Nội (Đường Võ Nguyên Giáp) vị trí thuận lợi cách đến quận 1 chỉ 15 phút di chuyển, 20 phút đến sân bay Tân Sơn Nhất, bước vài bước chân đến nhà ga tuyến Metro và trung tâm thương mại Vincom Megamall Quận 2.
                Khu căn hộ đạt tiêu chuẩn phòng cháy chữa cháy tốt. Có tập huấn định kỳ.
                Tiện ích nội khu gồm: Hồ bơi tầng 3 kết hợp khu BBQ, gym, sân tennis, sân bóng rổ, công viên trung tâm... (miễn phí).
                Căn hộ đã hoàn thiện full nội thất, chỉ việc xách vali vào ở.
                Balcony nhiều hướng view sông Sài Gòn, view hồ bơi và View Landmark 81 hướng tránh nắng và thông thoáng.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 3-770','ward' => 'Phường 04-27148','street' => '','address' => 'Phường 04, Quận 3, Thành phố Hồ Chí Minh','legal_documents' => 'Đã có sổ.','furniture' => 'Hoàn thiện full nội thất','bedroom' => 0,'toilet' => 3,'floor' => 0,'size' => 101,'price' => 4400,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 20,'title' => 'CHUYÊN CHO THUÊ CĂN HỘ ECO GREEN 1PN - 2PN - 3PN GIÁ TỐT NHẤT THỊ TRƯỜNG','description' => 'Vị trí của dự án: 107 Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7.\n- Nằm giữa 3 khu đô thị lớn nhất thành phố Sài Gòn là: Quận 1, khu đô thị Phú Mỹ Hưng (quận 7) và khu đô thị mới Thủ Thiêm (quận 2).
                - Mất 12 phút di chuyển đến quận 1 (phố đi bộ Nguyễn Huệ) thông qua tuyến đường Nguyễn Tất Thành - Cầu Tân Thuận Quận 4.
                - Cách Đại học RMIT và Đại học Tôn Đức Thắng 5km.
                Tiện ích dự án:
                - Gym, hồ bơi, khu vui chơi trẻ em, Công Viên nội khu Eco Park kết hợp BBQ.
                - Cửa hàng tiện lợi Family mart 24h, Winmart, Pharmacity, Coffee, Bách Hoá Xanh, Trường học mầm non, trường tiểu học (Cách 500m).','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Mộ Lao-09541','street' => '','address' => 'Phường Mộ Lao, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => '','furniture' => 'Nội thất cơ bản chủ đầu tư.','bedroom' => 1,'toilet' => 1,'floor' => 0,'size' => 49,'price' => 4400,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 2,'title' => 'CHUYÊN CHO THUÊ CĂN HỘ ECO GREEN 1PN - 2PN - 3PN GIÁ TỐT NHẤT THỊ TRƯỜNG','description' => 'Vị trí của dự án: 107 Nguyễn Văn Linh, Phường Tân Thuận Tây, Quận 7.\n- Nằm giữa 3 khu đô thị lớn nhất thành phố Sài Gòn là: Quận 1, khu đô thị Phú Mỹ Hưng (quận 7) và khu đô thị mới Thủ Thiêm (quận 2).
                - Mất 12 phút di chuyển đến quận 1 (phố đi bộ Nguyễn Huệ) thông qua tuyến đường Nguyễn Tất Thành - Cầu Tân Thuận Quận 4.
                - Cách Đại học RMIT và Đại học Tôn Đức Thắng 5km.
                Tiện ích dự án:
                - Gym, hồ bơi, khu vui chơi trẻ em, Công Viên nội khu Eco Park kết hợp BBQ.
                - Cửa hàng tiện lợi Family mart 24h, Winmart, Pharmacity, Coffee, Bách Hoá Xanh, Trường học mầm non, trường tiểu học (Cách 500m).','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Mộ Lao-09541','street' => '','address' => 'Phường Mộ Lao, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => '','furniture' => 'Nội thất cơ bản chủ đầu tư.','bedroom' => 3,'toilet' => 0,'floor' => 0,'size' => 154,'price' => 14,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 9,'title' => 'Cho thuê nhà nguyên căn mới hoàn toàn đường Vũ Chí Hiếu, Quận 5, DT 60m2, giá 30 triệu/tháng','description' => '- Nhà mới hoàn toàn, diện tích 60m².\n- Khu nhà ngay chợ Kim Biên, tiện lợi cho việc kinh doanh. Ưu tiên cho anh chị nào có thiện chí thuê ở lâu dài.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Hà Đông-268','ward' => 'Phường Mộ Lao-09541','street' => '','address' => 'Phường Mộ Lao, Quận Hà Đông, Thành phố Hà Nội','legal_documents' => 'Hợp đồng mua bán','furniture' => 'Không nội thất','bedroom' => 0,'toilet' => 1,'floor' => 3,'size' => 81,'price' => 13,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 1,'title' => 'Cho thuê nhà, đầy đủ nội thất, khu dân cư Hiệp Thành 3, Tp Thủ Dầu Một','description' => 'Nhà phố, đầy đủ nội thất, nằm ở trung tâm thành phố Thủ Dầu Một.\nDiện tích nhà 175m² có 3 phòng ngủ, 3 nhà vệ sinh.
                Giá thuê 12 triệu / tháng.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 3-770','ward' => 'Phường 04-27148','street' => '','address' => 'Phường 04, Quận 3, Thành phố Hồ Chí Minh','legal_documents' => '','furniture' => 'Đầy đủ','bedroom' => 0,'toilet' => 2,'floor' => 3,'size' => 49,'price' => 16,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 4,'title' => 'Chính chủ cần bán gấp căn hộ 96m2 3pn 2wc sổ đỏ chính chủ nội thất đầy đủ đồ toà CT5 Xa La, Hà Đông','description' => 'Nhà có thêm thành viên mới, cần chuyển đổi lên căn hộ rộng hơn, vì vậy, chính chủ mình cần bán gấp căn hộ tòa ct5 Xa La tại khu đô thị Xa La, Hà Đông. Thông tin căn hộ như sau:\n- Diện tích: 96m².
                - Thiết kế căn hộ: 3PN 2WC.
                - Nội thất: Gia đình để lại bàn ghế, điều hòa, nóng lạnh, tủ bếp,...
                - Giá bán: Nhỉnh 2 tỷ.
                Căn hộ ở rất có lộc, nhà đẹp không thấm ẩm, xung quanh tòa nhà bạt ngàn tiện ích, các tuyến đường giao thông đi lại thuận lợi.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 3-770','ward' => 'Phường 04-27148','street' => '','address' => 'Phường 04, Quận 3, Thành phố Hồ Chí Minh','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 2,'floor' => 3,'size' => 188,'price' => 23,'unit' => 'VND','type_id' => 13,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 3,'title' => 'Bán gấp trong tuần - căn 84m2 2 ngủ CT1 Xa La - Giá 1,55 tỷ','description' => 'Chính chủ bán căn 84m² tòa CT1 Xa La - Hà Đông - Giá 1,55 tỷ \n- Diện tích: 84m².
                - Hướng cửa: Tây Nam, ban công: Tây Bắc.
                - Thiết kế căn hộ: 2 phòng ngủ, 1 vệ sinh, 1 phòng khách.
                - Nội thất gồm toàn bộ nội thất gắn tường điều hòa, nóng lạnh, giường, tủ quần áo.
                - Giá bán: 1.55 tỷ.
                - Pháp lý: Hợp đồng chính chủ, sẵn sàng giao dịch, sang tên nhanh chóng.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Mai Dịch-00163','street' => '','address' => 'Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => '','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 2,'floor' => 1,'size' => 156,'price' => null,'unit' => 'Thoả Thuận','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 5,'title' => 'Chính chủ bán căn hộ 58m2 2PN tòa trung tâm thương mại KĐT Xa La - Có sổ đỏ.','description' => 'Chuyển công tác nên gia đình muốn nhượng lại căn góc ở tòa trung tâm thương mại khu đô thị Xa La cho hộ gia đình nào có nhu cầu. Chi tiết căn hộ như sau:\n- Diện tích: 58m².
                - Hướng cửa: Đông Bắc, ban công: Tây Nam.
                - Thiết kế căn hộ: 2 phòng ngủ, 1 vệ sinh, 1 khách, 1 ban công thoáng.
                - Nội thất gồm những gì để lại: Điều hòa, tủ bếp, nóng lạnh, giường, tủ, bàn ghế... Khách mua chỉ cần xách vali về ở.
                - Giá thương lượng và gia lộc cho khách nhiệt tình hợp duyên).
                - Pháp lý: SĐCC.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Mai Dịch-00163','street' => '','address' => 'Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 1,'toilet' => 0,'floor' => 3,'size' => 109,'price' => 31500,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 18,'title' => 'Sở hữu căn hộ chung cư học viện Quân Y, Xa La, 70m2, 2 phòng ngủ, 2WC sổ đỏ chính chủ NT full đồ','description' => 'Chuyển công tác nên gia đình muốn nhượng lại căn hộ chung cư tòa học viện Quân Y - Gần khu đô thị Xa La cho hộ gia đình nào có nhu cầu. Chi tiết căn hộ như sau:\n- Diện tích: 70m².
                - Hướng cửa: Đông Bắc, ban công: Tây Nam.
                - Thiết kế căn hộ: 2 phòng ngủ, 2 vệ sinh, 1 khách, 1 ban công thoáng.
                - Nội thất gồm những gì để lại: Điều hòa, tủ bếp, nóng lạnh, giường, tủ, bàn ghế... Khách mua chỉ cần xách vali về ở.
                - Giá bán: 2,0x tỷ (x nhỏ) có thương lượng).
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch, hỗ trợ khách mua trả góp.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Mai Dịch-00163','street' => '','address' => 'Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 3,'floor' => 3,'size' => 128,'price' => 4500,'unit' => 'VND','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 11,'title' => 'Chính chủ bán gấp căn hộ 54m2 tòa CT4 Xa La, sổ đỏ chính chủ, giá 920 triệu.','description' => 'Chính chủ làm ăn được lộc, chuyển sang căn hộ 2 phòng ngủ, vì vậy quyết định bán nhanh căn hộ 1 phòng ngủ tại tòa CT4, chung cư KHu đô thị Xa La, Hà Đông, Hà Nội.\n- Diện tích: 54m vuông, thiết kế 1 phòng ngủ + 1 vệ sinh, 1 phòng khách, 1 ban công thoáng.
                - Nội thất: Đầy đủ đồ cơ bản, khách chỉ việc xách vali về ở.
                - Pháp lý: Sổ hồng chính chủ.
                - Giá bán: 920 triệu.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Mai Dịch-00163','street' => '','address' => 'Phường Mai Dịch, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => 'Sổ hồng','furniture' => 'Cơ bản','bedroom' => 3,'toilet' => 2,'floor' => 1,'size' => 92,'price' => 2000,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 5,'title' => 'Bán căn 59m2 2 ngủ tòa CT8 Đại Thanh. Giá 1,29 tỷ - nội thất đẹp','description' => 'Chính chủ bán căn hộ 2 phòng ngủ thoáng đẹp tại tòa CT8, chung cư Đại Thanh, Thanh Trì.\n* Diện tích: 59 m².
                * Hướng cửa: Tây Bắc, ban công Đông Nam.
                * Thiết kế căn hộ: 2 phòng ngủ, 1 vệ sinh, phòng bếp, 1 khách.
                * Nội thất để lại: Full đồ. Sàn gỗ, trần thạch cao, tủ bếp, bếp từ, hút mùi, điều hòa, nóng lạnh, sofa, giường ngủ, quần áo...
                * Pháp lý: Hợp đồng chính chủ, sẵn sàng giao dịch, hỗ trợ khách mua trả góp.
                * Giá: 1,29 tỷ.','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Dịch Vọng-00166','street' => '','address' => 'Phường Dịch Vọng, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => '','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 1,'floor' => 3,'size' => 70,'price' => null,'unit' => 'Thoả Thuận','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 17,'title' => 'Chính chủ cần bán căn 47m Đại Thanh - Sổ đỏ sẵn sàng giao dịch, Giá 1,1x tỷ','description' => 'Chính chủ thiện chí bán nhanh căn hộ diện tích 47m tại tòa CT10, chung cư Đại Thanh, Thanh Trì, Hà Nội\n- Thiết kế căn hộ: 1 phòng ngủ, 1 vệ sinh, 1 phòng khách rộng, 1 ban công thoáng (Có thể thiết kế thành 2 phòng ngủ)
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch
                - Nội thất: đầy đủ sàn gỗ, bàn ghế, nóng lạnh, điều hòa, giường tủ,... khách mua chỉ việc về ở
                - Giá bán: 1,17 tỷ','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Dịch Vọng-00166','street' => '','address' => 'Phường Dịch Vọng, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 3,'toilet' => 0,'floor' => 3,'size' => 83,'price' => 1770,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 3,'title' => 'Cần bán căn góc 45,5m2 tầng 28 tòa CT8 Đại Thanh - Có sổ đỏ - Nội thất mới đẹp','description' => 'Chính chủ chuyển đổi sang căn 3 phòng ngủ, vì vậy cần bán nhanh căn hộ lô góc 1 phòng ngủ tại tòa CT8, chung cư Đại Thanh, Thanh Trì, Hà Nội.\n- Diện tích: 45,5m².
                - Thiết kế căn hộ: 2 phòng ngủ, 2 vệ sinh.
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch, hỗ trợ khách mua vay bank.
                - Nội thất: Đầy đủ trần thạch cao, sàn gỗ, điều hòa, nóng lạnh, giường, tủ,...
                - Giá bán: 1,1x tỷ (Có thương lượng).','province' => 'Thành phố Hà Nội-01','district' => 'Quận Cầu Giấy-005','ward' => 'Phường Dịch Vọng-00166','street' => '','address' => 'Phường Dịch Vọng, Quận Cầu Giấy, Thành phố Hà Nội','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 0,'toilet' => 1,'floor' => 0,'size' => 49,'price' => 2530,'unit' => 'VND','type_id' => 2,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 1,'title' => 'Bán căn hộ full nội thất đẹp tại tòa CT1 Xa La - 83m2 - 2 ngủ - Có sổ đỏ.','description' => 'Nhà có thêm thành viên mới, cần chuyển đổi lên căn hộ rộng hơn, vì vậy, chính chủ mình cần bán gấp căn hộ tòa Nam Xa La tại khu đô thị Xa La, Hà Đông. Thông tin căn hộ như sau:\n- Diện tích: 83m².
                - Thiết kế căn hộ: 2PN 2WC.
                - Hướng Tây Nam, Ban Công đông Bắc.
                - Nội thất: Gia đình để lại bàn ghế, điều hòa, nóng lạnh, tủ bếp,...
                - Giá bán: 2, x tỷ.
                - Giấy tờ: Sổ hồng chính chủ, sang tên nhanh gọn.','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 3-770','ward' => 'Phường 10-27145','street' => '','address' => 'Phường 10, Quận 3, Thành phố Hồ Chí Minh','legal_documents' => 'Sổ đỏ/ Sổ hồng','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 0,'floor' => 3,'size' => 134,'price' => null,'unit' => 'Thoả Thuận','type_id' => 1,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))],
                ['user_id' => 15,'title' => 'Còn duy nhất căn 3 phòng ngủ tòa CT1 Vinmart KĐT Xa La - 101m2 - Có sổ đỏ chính chủ - Giá 2,5x tỷ','description' => 'Chính chủ làm ăn được lộc, đã mua được căn nhà liền kề, vì vậy có nhu cầu bán nhanh căn hộ 3 phòng ngủ tại tòa CT1 gần Vinmart, KĐT Xa La, Hà Đông, Hà Nội.\n- Diện tích: 101m².
                - Thiết kế căn hộ: 3 phòng ngủ, 2 vệ sinh, 1 phòng khách rộng, ban công thoáng.
                - Pháp lý: Sổ đỏ chính chủ, sẵn sàng giao dịch.
                - Nội thất: Sàn gỗ, trần thạch cao, điều hòa, nóng lạnh, bàn ghế, giường, tủ bếp, tủ quần áo,... Khách mua chỉ việc xách vali về ở.
                - Giá bán: 2,5x tỷ (Có thương lượng).','province' => 'Thành phố Hồ Chí Minh-79','district' => 'Quận 3-770','ward' => 'Phường 10-27145','street' => '','address' => 'Phường 10, Quận 3, Thành phố Hồ Chí Minh','legal_documents' => 'Sổ đỏ','furniture' => 'Đầy đủ','bedroom' => 2,'toilet' => 3,'floor' => 3,'size' => 189,'price' => 12,'unit' => 'VND','type_id' => 12,'status' => 1, "created_at" => Carbon::now()->subHours(rand(1, 48)), "updated_at" => Carbon::now()->subHours(rand(1, 48)), "published_at" => Carbon::now()->subHours(rand(1, 48))]
        ]);
    }
}
