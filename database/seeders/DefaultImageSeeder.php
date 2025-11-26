<?php

namespace Database\Seeders;

use App\Enums\ImageQualityLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultImageSeeder extends Seeder
{
    /**
     * storage/app/public/default_imagesに配置された
     * スポットカテゴリー別のデフォルト画像をimagesテーブルに登録する
     *
     * これらの画像は、各スポットタイプの一般的な画像として使用される
     * （例：神社の画像、城の画像、山の画像など）
     */
    public function run(): void
    {
        $now = Carbon::now();

        /**
         * default_imagesフォルダ内の画像データ
         * 画像は全てdocuments/mvp/temp_prompt.mdに示すスポットカテゴリーの一般的な画像
         */
        $images = [
            // 神社の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'Shrine.png',
                'storage_path' => 'default_images/Shrine.png',
                'alt_text' => '神社',
                'description' => '神社の一般的な画像（鳥居、参道、本殿など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 寺院の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'temple.png',
                'storage_path' => 'default_images/temple.png',
                'alt_text' => '寺院',
                'description' => '寺院の一般的な画像（本堂、五重塔、境内など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 城郭・城跡の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'castle.png',
                'storage_path' => 'default_images/castle.png',
                'alt_text' => '城郭・城跡',
                'description' => '城郭・城跡の一般的な画像（天守、石垣、城門など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 史跡・遺跡の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'ruin.png',
                'storage_path' => 'default_images/ruin.png',
                'alt_text' => '史跡・遺跡',
                'description' => '史跡・遺跡の一般的な画像（古墳、遺跡、古戦場など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 歴史的建造物（近代以前）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'pre-modern.png',
                'storage_path' => 'default_images/pre-modern.png',
                'alt_text' => '歴史的建造物（近代以前）',
                'description' => '歴史的建造物（近代以前）の一般的な画像（武家屋敷、商家、古民家、蔵など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 伝統的町並みの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'traditional-townscape.png',
                'storage_path' => 'default_images/traditional-townscape.png',
                'alt_text' => '伝統的町並み',
                'description' => '伝統的町並みの一般的な画像（重要伝統的建造物群保存地区、門前町、寺町など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 霊場・巡礼地の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'sacred-sites.png',
                'storage_path' => 'default_images/sacred-sites.png',
                'alt_text' => '霊場・巡礼地',
                'description' => '霊場・巡礼地の一般的な画像（四国八十八箇所、西国三十三所、熊野古道など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 山岳・火山の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'mountain.png',
                'storage_path' => 'default_images/mountain.png',
                'alt_text' => '山岳・火山',
                'description' => '山岳・火山の一般的な画像（登山、山頂、火口など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 河川・渓谷の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'river-valley.png',
                'storage_path' => 'default_images/river-valley.png',
                'alt_text' => '河川・渓谷',
                'description' => '河川・渓谷の一般的な画像（清流、渓谷美、川床など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 滝の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'waterfall.png',
                'storage_path' => 'default_images/waterfall.png',
                'alt_text' => '滝',
                'description' => '滝の一般的な画像（日本三大名瀑、裏見の滝、氷瀑など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 湖沼・池の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'lake.png',
                'storage_path' => 'default_images/lake.png',
                'alt_text' => '湖沼・池',
                'description' => '湖沼・池の一般的な画像（カルデラ湖、湧水池、リフレクションなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 海岸・岬の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'coast.png',
                'storage_path' => 'default_images/coast.png',
                'alt_text' => '海岸・岬',
                'description' => '海岸・岬の一般的な画像（リアス式海岸、砂浜、断崖絶壁、奇岩など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 島嶼の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'island.png',
                'storage_path' => 'default_images/island.png',
                'alt_text' => '島嶼（島）',
                'description' => '島嶼の一般的な画像（離島、アートの島、動物の島など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 鍾乳洞・洞窟の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'cave.png',
                'storage_path' => 'default_images/cave.png',
                'alt_text' => '鍾乳洞・洞窟',
                'description' => '鍾乳洞・洞窟の一般的な画像（地底湖、ケイビング、観光鍾乳洞など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 高原・湿原の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'highland.png',
                'storage_path' => 'default_images/highland.png',
                'alt_text' => '高原・湿原',
                'description' => '高原・湿原の一般的な画像（高層湿原、高山植物、星空観測地など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 自然現象の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'natural-phenomena.png',
                'storage_path' => 'default_images/natural-phenomena.png',
                'alt_text' => '自然現象',
                'description' => '自然現象の一般的な画像（流氷、樹氷、雲海、蜃気楼、ホタル鑑賞地など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],

            // === 3. 🌸 動植物・庭園 ===
            // 植物園の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'botanical-garden.png',
                'storage_path' => 'default_images/botanical-garden.png',
                'alt_text' => '植物園',
                'description' => '植物園の一般的な画像（総合植物園、高山植物園、熱帯植物園など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // ハーブ園の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'herb-garden.png',
                'storage_path' => 'default_images/herb-garden.png',
                'alt_text' => 'ハーブ園',
                'description' => 'ハーブ園の一般的な画像（アロマ体験、ハーブ料理レストラン併設など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 庭園の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'garden.png',
                'storage_path' => 'default_images/garden.png',
                'alt_text' => '庭園',
                'description' => '庭園の一般的な画像（日本庭園、イングリッシュガーデン、フラワーパークなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 花畑・名所の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'flower-field.png',
                'storage_path' => 'default_images/flower-field.png',
                'alt_text' => '花畑・名所',
                'description' => '花畑・名所の一般的な画像（桜、梅、紫陽花、藤、ラベンダー、ネモフィラなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 動物園の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'zoo.png',
                'storage_path' => 'default_images/zoo.png',
                'alt_text' => '動物園',
                'description' => '動物園の一般的な画像（行動展示、サファリパーク、ナイトズーなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 水族館の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'aquarium.png',
                'storage_path' => 'default_images/aquarium.png',
                'alt_text' => '水族館',
                'description' => '水族館の一般的な画像（巨大水槽、深海魚展示、イルカショーなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 牧場・ファームの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'ranch.png',
                'storage_path' => 'default_images/ranch.png',
                'alt_text' => '牧場・ファーム',
                'description' => '牧場・ファームの一般的な画像（酪農体験、乗馬、アルパカ・羊とのふれあいなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 野鳥・野生動物観察スポットの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'wild-bird.png',
                'storage_path' => 'default_images/wild-bird.png',
                'alt_text' => '野鳥・野生動物観察スポット',
                'description' => '野鳥・野生動物観察スポットの一般的な画像（バードウォッチング、ホエール・ドルフィンウォッチングなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],

            // === 4. 🏙️ 近代・現代の建造物・インフラ ===
            // タワー・展望台の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'tower.png',
                'storage_path' => 'default_images/tower.png',
                'alt_text' => 'タワー・展望台',
                'description' => 'タワー・展望台の一般的な画像（電波塔、ランドマークタワー、360度パノラマなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 橋梁の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'bridge.png',
                'storage_path' => 'default_images/bridge.png',
                'alt_text' => '橋梁（橋）',
                'description' => '橋梁の一般的な画像（吊り橋、長大橋、歴史的石橋、デザイン性の高い橋など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // ダムの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'dam.png',
                'storage_path' => 'default_images/dam.png',
                'alt_text' => 'ダム',
                'description' => 'ダムの一般的な画像（アーチ式、重力式コンクリート式、観光放水、ダム湖クルーズなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 港・空港の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'port.png',
                'storage_path' => 'default_images/port.png',
                'alt_text' => '港・空港',
                'description' => '港・空港の一般的な画像（フェリーターミナル、国際クルーズ船寄港地、空港展望デッキなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 灯台の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'lighthouse.png',
                'storage_path' => 'default_images/lighthouse.png',
                'alt_text' => '灯台',
                'description' => '灯台の一般的な画像（登れる灯台（参観灯台）、歴史的灯台、絶景スポットなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 駅舎の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'trainstation.png',
                'storage_path' => 'default_images/trainstation.png',
                'alt_text' => '駅舎',
                'description' => '駅舎の一般的な画像（歴史的木造駅舎、無人駅（秘境駅）、絶景駅など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 近代化産業遺産（鉄道遺産）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'railway-heritage.png',
                'storage_path' => 'default_images/railway-heritage.png',
                'alt_text' => '近代化産業遺産（鉄道遺産）',
                'description' => '近代化産業遺産の一般的な画像（廃線跡、旧トンネル、旧工場、鉱山跡など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 歴史的建造物（近代以降）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'historic-buildings.png',
                'storage_path' => 'default_images/historic-buildings.png',
                'alt_text' => '歴史的建造物（近代以降）',
                'description' => '歴史的建造物（近代以降）の一般的な画像（洋館、赤レンガ倉庫、旧銀行、旧学校校舎、教会など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 日本家屋の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'traditional-japanese-house.png',
                'storage_path' => 'default_images/traditional-japanese-house.png',
                'alt_text' => '日本家屋',
                'description' => '日本家屋の一般的な画像（武家屋敷、商家、古民家など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],

            // === 5. 🎨 学術・文化・芸術施設 ===
            // 博物館・科学館の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'museum.png',
                'storage_path' => 'default_images/museum.png',
                'alt_text' => '博物館・科学館',
                'description' => '博物館・科学館の一般的な画像（国立博物館、歴史博物館、民俗資料館、自然史博物館など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 美術館（野外美術館）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'open-air-art-museum.png',
                'storage_path' => 'default_images/open-air-art-museum.png',
                'alt_text' => '美術館（野外美術館）',
                'description' => '美術館の一般的な画像（野外美術館（彫刻の森など）、現代アート、陶磁器など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 文学館・記念館の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'literary-museum.png',
                'storage_path' => 'default_images/literary-museum.png',
                'alt_text' => '文学館・記念館',
                'description' => '文学館・記念館の一般的な画像（作家の旧居・生家、ゆかりの地、特定の作品テーマ館など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 劇場・音楽ホールの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'theater.png',
                'storage_path' => 'default_images/theater.png',
                'alt_text' => '劇場・音楽ホール',
                'description' => '劇場・音楽ホールの一般的な画像（歌舞伎、能、文楽、オペラ、コンサートホールなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 図書館（特殊）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'librarie.png',
                'storage_path' => 'default_images/librarie.png',
                'alt_text' => '図書館（特殊）',
                'description' => '図書館（特殊）の一般的な画像（建築が美しい図書館、専門図書館、カフェ併設など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 大学キャンパスの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'university-campuse.png',
                'storage_path' => 'default_images/university-campuse.png',
                'alt_text' => '大学キャンパス',
                'description' => '大学キャンパスの一般的な画像（歴史的建造物（赤門など）、学食利用、併設ミュージアムなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // ジオパークの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'geo-park.png',
                'storage_path' => 'default_images/geo-park.png',
                'alt_text' => 'ジオパーク',
                'description' => 'ジオパークの一般的な画像（地層、地形、火山活動の痕跡を学ぶエリアなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],

            // === 6. 🤸 体験・アクティビティ ===
            // 伝統工芸体験（陶芸）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'pottery.png',
                'storage_path' => 'default_images/pottery.png',
                'alt_text' => '伝統工芸体験（陶芸）',
                'description' => '伝統工芸体験の一般的な画像（陶芸（ろくろ、手びねり）、染物、和紙漉き、ガラス工芸など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 農業体験（田植え）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'rice-planting.png',
                'storage_path' => 'default_images/rice-planting.png',
                'alt_text' => '農業・漁業体験',
                'description' => '農業・漁業体験の一般的な画像（田植え、稲刈り、果物狩り、野菜収穫、地引網など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // アウトドア（カヌー・カヤック）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'canoeing.png',
                'storage_path' => 'default_images/canoeing.png',
                'alt_text' => 'アウトドア（カヌー・カヤック）',
                'description' => 'アウトドアの一般的な画像（カヌー・カヤック、キャンプ、登山、SUP、ダイビング、ラフティングなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // アスレチック施設の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'athletic-facilities.png',
                'storage_path' => 'default_images/athletic-facilities.png',
                'alt_text' => 'アスレチック施設',
                'description' => 'アスレチック施設の一般的な画像（公園のアスレチック、フィールドアスレチックなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 工場見学（ウイスキー蒸溜所）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'whisky-distillerie.png',
                'storage_path' => 'default_images/whisky-distillerie.png',
                'alt_text' => '工場見学（ウイスキー蒸溜所）',
                'description' => '工場見学の一般的な画像（酒蔵、ビール工場、ウイスキー蒸溜所、自動車工場など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // ワイナリーの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'winerie.png',
                'storage_path' => 'default_images/winerie.png',
                'alt_text' => 'ワイナリー',
                'description' => 'ワイナリーの一般的な画像（試飲、見学、ぶどう畑など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 文化体験（茶道）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'tea-celemony.png',
                'storage_path' => 'default_images/tea-celemony.png',
                'alt_text' => '文化体験（茶道）',
                'description' => '文化体験の一般的な画像（座禅、写経、滝行、茶道、華道、着物・甲冑レンタルなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],

            // === 7. 🛍️ 食・買い物・レジャー ===
            // 市場（朝市）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'morning-market.png',
                'storage_path' => 'default_images/morning-market.png',
                'alt_text' => '市場（朝市）',
                'description' => '市場の一般的な画像（朝市、漁港市場（競り見学）、中央卸売市場（場外市場での食べ歩き）など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 商店街（レトロ商店街）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'retro-shopping-street.png',
                'storage_path' => 'default_images/retro-shopping-street.png',
                'alt_text' => '商店街（レトロ商店街）',
                'description' => '商店街の一般的な画像（レトロ商店街、アーケード街、特定の専門店街、食べ歩きグルメなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 道の駅・SA/PAの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'roadside-station.png',
                'storage_path' => 'default_images/roadside-station.png',
                'alt_text' => '道の駅・SA/PA',
                'description' => '道の駅・SA/PAの一般的な画像（ご当地グルメ、産直野菜・特産品、ユニークな施設など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // グルメスポット（横丁・屋台街）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'food-stalls.png',
                'storage_path' => 'default_images/food-stalls.png',
                'alt_text' => 'グルメスポット（横丁・屋台街）',
                'description' => 'グルメスポットの一般的な画像（ご当地B級グルメ、横丁・屋台街、デパ地下など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // テーマパーク・遊園地の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'amusement-park.png',
                'storage_path' => 'default_images/amusement-park.png',
                'alt_text' => 'テーマパーク・遊園地',
                'description' => 'テーマパーク・遊園地の一般的な画像（大規模リゾート型、ローカル遊園地、レトロ遊園地など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 温泉・スパの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'hot-springs.png',
                'storage_path' => 'default_images/hot-springs.png',
                'alt_text' => '温泉・スパ',
                'description' => '温泉・スパの一般的な画像（温泉街（外湯めぐり）、秘湯、日帰り温泉施設、足湯など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],

            // === 8. 🎬 その他・ニッチ・サブカルチャー ===
            // ロケ地・聖地巡礼（アニメ）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'anime-filming-location.png',
                'storage_path' => 'default_images/anime-filming-location.png',
                'alt_text' => 'ロケ地・聖地巡礼（アニメ）',
                'description' => 'ロケ地・聖地巡礼の一般的な画像（ドラマ、映画、アニメ、漫画、ゲームの舞台など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // パワースポットの一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'spiritual-power-spot.png',
                'storage_path' => 'default_images/spiritual-power-spot.png',
                'alt_text' => 'パワースポット',
                'description' => 'パワースポットの一般的な画像（風水、スピリチュアル、縁起物など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 珍スポット・B級スポット（巨大モニュメント）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'large-monument.png',
                'storage_path' => 'default_images/large-monument.png',
                'alt_text' => '珍スポット・B級スポット（巨大モニュメント）',
                'description' => '珍スポット・B級スポットの一般的な画像（個人の収集物館、巨大モニュメント、不思議なテーマパーク跡など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 廃墟・遺構（廃校）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'abondoned-school.png',
                'storage_path' => 'default_images/abondoned-school.png',
                'alt_text' => '廃墟・遺構（廃校）',
                'description' => '廃墟・遺構の一般的な画像（廃線跡（ウォーキングコース）、廃工場、廃校（※許可・管理されている場所）など）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
            // 夜景スポット（工場夜景）の一般的な画像
            [
                'uuid' => Str::uuid()->toString(),
                'file_name' => 'factory-night-view.png',
                'storage_path' => 'default_images/factory-night-view.png',
                'alt_text' => '夜景スポット（工場夜景）',
                'description' => '夜景スポットの一般的な画像（日本新三大夜景、工場夜景、ライトアップイベントなど）',
                'image_quality_level' => ImageQualityLevel::AiGeneric->value,
                'created_at' => $now,
            ],
        ];

        foreach ($images as $image) {
            DB::table('images')->insert($image);
        }
    }
}
