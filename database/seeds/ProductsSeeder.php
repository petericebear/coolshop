<?php

use Elasticsearch\Client;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $client = app(Client::class);

        $products = [];

        $products[] = [
            'id' => str_random(32),
            'url' => 'https://www.routercenter.nl/product/761432/category-254888/tp-link-deco-m5-multiroom-wifi.html',
            'image' => 'https://image.coolblue.io/products/728174?width=170&height=170',
            'awardImage' => 'https://image.coolblue.io/content/224144',
            'title' => 'TP-Link Deco M5 Multiroom wifi',
            'rating' => 4.5,
            'reviewCount' => 160,
            'productOptions' => [
                'Multiroom wifi',
                'Wifi snelheid: 400 + 867 Mbps',
                'MU-MIMO, Ouderlijke controle',
            ],
            'price' => 259,
            'priceSecondChance' => 247,
            'inStock' => true,
            'typeRouter' => [
                'Middenklasse',
                'Zakelijk',
                'Multiroom wifi',
            ],
            'brand' => 'TP-Link',
            'coolbluesChoice' => 'Nee',
            'administratorOptions' => [
                'Firewall',
                'Gastnetwerk',
                'Ouderlijke controle',
            ]
        ];

        $products[] = [
            'id' => str_random(32),
            'url' => 'https://www.routercenter.nl/product/733895/category-254888/netgear-orbi-rbk50-multiroom-wifi.html',
            'image' => 'https://image.coolblue.io/products/556763?width=170&height=170',
            'awardImage' => 'https://assets.coolblue.nl/images/default/coolblues-choice/label-right.png',
            'title' => 'Netgear Orbi RBK50 Multiroom wifi',
            'rating' => 4.5,
            'reviewCount' => 255,
            'productOptions' => [
                'Multiroom wifi',
                'Wifi snelheid: 450 + 866 + 1733 Mbps',
                'MU-MIMO, Ouderlijke controle',
            ],
            'price' => 369,
            'priceSecondChance' => 351,
            'inStock' => true,
            'typeRouter' => [
                'Gaming',
                'Zakelijk',
                'Topklasse',
                'Multiroom wifi',
            ],
            'brand' => 'Netgear',
            'coolbluesChoice' => 'Ja',
            'administratorOptions' => [
                'Firewall',
                'Gastnetwerk',
                'Ouderlijke controle',
            ]
        ];

        $products[] = [
            'id' => str_random(32),
            'url' => 'https://www.routercenter.nl/product/795147/category-254888/google-wifi-triple-pack-multiroom-wifi.html',
            'image' => 'https://image.coolblue.io/products/909025?width=170&height=170',
            'title' => 'Google Wifi Triple Pack Multiroom wifi',
            'rating' => 4.5,
            'reviewCount' => 83,
            'productOptions' => [
                'Multiroom wifi',
                'Wifi snelheid: 300 + 866',
                'Ouderlijke controle, Beamforming',
            ],
            'price' => 349,
            'inStock' => true,
            'typeRouter' => [
                'Gaming',
                'Zakelijk',
                'Topklasse',
                'Multiroom wifi',
            ],
            'brand' => 'Google',
            'coolbluesChoice' => 'Nee',
            'administratorOptions' => [
                'Firewall',
                'Gastnetwerk',
                'Ouderlijke controle',
                'Mobiele applicatie',
            ]
        ];

        foreach ($products as $product) {
            $params = [
                'index' => 'coolshop',
                'type' => 'doc',
                'id' => $product['id'],
                'body' => $product,
            ];

            $client->index($params);
        }
    }
}
