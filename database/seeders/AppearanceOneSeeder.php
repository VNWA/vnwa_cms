<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appearance;

class AppearanceOneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appearance::truncate();

        Appearance::create([
            'type' => 'top_nav',
            'value' => [
                [
                    'name' => 'Promotion',
                    'icon' => ['fas', 'percent'],
                    'link' => '/promotion'
                ],
                [
                    'name' => 'Showroom',
                    'icon' => ['fas', 'building-flag'],
                    'link' => '/showrooms'
                ],
                [
                    'name' => 'Business Consulting',
                    'icon' => ['fas', 'briefcase'],
                    'link' => '/business-consulting'
                ],
                [
                    'name' => 'Contact',
                    'icon' => ['fas', 'phone-volume'],
                    'link' => '/contact'
                ],
                [
                    'name' => 'News',
                    'icon' => ['fas', 'newspaper'],
                    'link' => '/news'
                ],
            ],
        ]);
        Appearance::create([
            'type' => 'bot_search',
            'value' => [
                [
                    'name' => 'Redeem Points Up To 5 Dollars',
                    'link' => '/'
                ],
                [
                    'name' => 'Laptop Ai',
                    'link' => '/'
                ],
                [
                    'name' => 'Desktop',
                    'link' => '/'
                ],
                [
                    'name' => 'Macbook',
                    'link' => '/'
                ],
                [
                    'name' => 'Build PC',
                    'link' => '/'
                ],
            ],
        ]);
        Appearance::create([
            'type' => 'logo',
            'value' => [
                'logo_full' => 'https://file.vinawebapp.com/uploads/images/Company/vnwaLogoFull.png',
                'logo_icon' => 'https://file.vinawebapp.com/uploads/images/Company/vnwaLogoIcon.png',
                'favicon' => 'https://file.vinawebapp.com/uploads/images/Company/vnwaLogoIcon.png'
            ],
        ]);
        Appearance::create([
            'type' => 'footer',
            'value' => [
                'footer_sidebar' => [
                    [
                        'name' => 'Customer Support',
                        'value' => [
                            [
                                'name' => 'Installment payment policy',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Incentives for Businesses',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Installment payment policy',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Repair service',
                                'link' => '/'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Purchase policy',
                        'value' => [
                            [
                                'name' => 'General trading conditions',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Warranty policy',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Return policy',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Delivery and Installation at home',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Payment security policy',
                                'link' => '/'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Information',
                        'value' => [
                            [
                                'name' => 'About Us',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Showroom',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Privacy policy',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Technology news',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Recruitment',
                                'link' => '/'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Contact Us',
                        'value' => [
                            [
                                'name' => 'Customer Support: cskh@example.com',

                                'link' => '/'
                            ],
                            [
                                'name' => 'Contact for quote: cskh@example.com',
                                'link' => '/'
                            ],
                            [
                                'name' => 'Development cooperation: cskh@example.com',
                                'link' => '/'
                            ]
                        ]
                    ]
                ],
                'footer_bottom' => '<p><span class=\"text-small\" style=\"color:hsl(0,0%,0%);\"><strong>CÔNG TY TNHH VINAWEBAPP.COM</strong> &nbsp;GPĐKKD số: </span><span class=\"text-small\" style=\"background-color:rgb(255,255,255);color:rgb(33,37,41);font-family:Arial, Helvetica, sans-serif;\"><strong>0402211956&nbsp;</strong></span><span class=\"text-small\" style=\"color:hsl(0,0%,0%);\"> Người đại diện: Nguyễn Phan Nhật Nguyên</span><br><br><br><span class=\"text-small\" style=\"color:hsl(0,0%,0%);\">VINAWEBAPP.COM @2015 - 2024 – VINAWEBAPP.COM là công ty hàng đầu tại Việt Nam trong lĩnh vực phát triển phần mềm, cung cấp các giải pháp công nghệ tiên tiến cho doanh nghiệp. Chúng tôi mang đến sự tiện lợi, tối ưu hóa quy trình kinh doanh và giúp khách hàng nâng cao năng lực cạnh tranh thông qua các sản phẩm phần mềm chất lượng cao. Với trụ sở chính tại Đà Nẵng và chi nhánh tại TP.HCM, Hà Nội, Bình Dương, chúng tôi hỗ trợ và cung cấp dịch vụ trên khắp cả nước, bao gồm các tỉnh thành như Bà Rịa Vũng Tàu, Bình Phước, Đồng Nai, Tây Ninh, An Giang, Bạc Liêu, Bến Tre, Cà Mau, Cần Thơ, Đồng Tháp, Hậu Giang, Kiên Giang, Long An, Sóc Trăng, Tiền Giang, Bình Định, Bình Thuận, Đà Nẵng, Khánh Hòa, Ninh Thuận, Phú Yên, Quảng Nam, Quảng Ngãi, Trà Vinh, Vĩnh Long, Đắk Lắk, Đắk Nông, Gia Lai, Kon Tum, Lâm Đồng, Bắc Ninh, Hà Nam, Hải Dương, Hải Phòng, Hưng Yên, Nam Định, Ninh Bình, Thái Bình, Vĩnh Phúc, Điện Biên, Hòa Bình, Lai Châu, Lào Cai, Sơn La, Yên Bái, Bắc Giang, Bắc Kạn, Cao Bằng, Hà Giang, Lạng Sơn, Phú Thọ, Quảng Ninh, Thái Nguyên, Tuyên Quang, Hà Tĩnh, Nghệ An, Quảng Bình, Quảng Trị, Thanh Hóa, Thừa Thiên Huế. VINAWEBAPP.COM luôn đồng hành cùng khách hàng trong hành trình chuyển đổi số, mang lại sự khác biệt và hiệu quả cao. DMCA.com Protection Status.. </span><a href=\"https://www.dmca.com/Protection/Status.aspx?ID=27c7bd2a-af6a-40b8-87f5-498526e3ff8f&amp;refurl=https://www.tdm.vn/bon-cau-bet-ve-sinh\"><span class=\"text-small\" style=\"color:hsl(0,0%,0%);\"><img src=\"https://images.dmca.com/Badges/dmca-badge-w100-5x1-08.png?ID=27c7bd2a-af6a-40b8-87f5-498526e3ff8f\" alt=\"DMCA.com Protection Status\" width=\"100\" height=\"20\"></span></a></p>',
            ],
        ]);
    }
}
