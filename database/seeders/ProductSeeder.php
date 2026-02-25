<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Редуктор главной передачи Mi-8',
                'slug' => 'reduktor-mi-8',
                'sku' => 'HSC-MI8-RGX01',
                'model' => 'Mi-8',
                'category' => 'Трансмиссия',
                'availability' => 'В наличии',
                'price_rub' => 1450000,
                'image_path' => '/styles/images/reductor.jpg',
                'gallery_images' => [
                    '/styles/images/reductor.jpg',
                    '/styles/images/reductor1.jpg',
                    '/styles/images/reductor2.jpg',
                    '/styles/images/reductor3.jpg',
                    '/styles/images/reductor4.png',
                ],
                'short_description' => 'Редуктор главной передачи для вертолётов серии Mi-8.',
                'description' => implode("\n\n", [
                    'Редуктор главной передачи для вертолётов серии Mi-8. Предназначен для передачи крутящего момента от двигателя к несущему винту. Изготовлен из авиационного алюминиевого сплава. Соответствует авиационным стандартам качества и безопасности.',
                    'Используется в гражданской и военной авиации. Прошел все необходимые испытания и сертификацию. Обеспечивает плавную и надежную работу трансмиссии вертолета.',
                ]),
            ],
            [
                'title' => 'Лопасть несущего винта',
                'slug' => 'lopast-mi-17',
                'sku' => 'HSC-MI17-BLD02',
                'model' => 'Mi-17',
                'category' => 'Лопасти',
                'availability' => 'Под заказ',
                'price_rub' => 980000,
                'image_path' => '/styles/images/lopast_vinta.png',
                'gallery_images' => [
                    '/styles/images/lopast_vinta.png',
                    '/styles/images/lopast.jpg',
                    '/styles/images/lopast2.png',
                ],
                'short_description' => 'Лопасть несущего винта для Mi-17 / Mi-8 (серия).',
                'description' => 'Высокопрочная лопасть несущего винта. Рассчитана на эксплуатацию в широком диапазоне температур и режимов. Поставляется как оригинальная запчасть HSC.',
            ],
            [
                'title' => 'Блок авионики NAV-X4',
                'slug' => 'nav-x4',
                'sku' => 'HSC-NAV-X4',
                'model' => 'Универсальный',
                'category' => 'Авионика',
                'availability' => 'В наличии',
                'price_rub' => 320000,
                'image_path' => '/styles/images/block_avioniki.webp',
                'gallery_images' => [
                    '/styles/images/block_avioniki.webp',
                    '/styles/images/panel.png',
                ],
                'short_description' => 'Навигационный/авионический блок для интеграции в бортовые системы.',
                'description' => 'NAV‑X4 — модуль авионики для модернизации и расширения функционала. Поддерживает типовые протоколы обмена и адаптируется под различные борта.',
            ],
            [
                'title' => 'Гидронасос HP-240',
                'slug' => 'gidronasos-hp-240',
                'sku' => 'HSC-HYD-240',
                'model' => null,
                'category' => 'Гидравлика',
                'availability' => 'В наличии',
                'price_rub' => 210000,
                'image_path' => '/styles/images/gidro.png',
                'gallery_images' => [
                    '/styles/images/gidro.png',
                ],
                'short_description' => 'Гидронасос для гидросистем вертолётной техники.',
                'description' => 'HP‑240 предназначен для работы в составе гидросистем. Обеспечивает стабильные параметры давления и расхода.',
            ],
        ];

        foreach ($items as $item) {
            Product::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
