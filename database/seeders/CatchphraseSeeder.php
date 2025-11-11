<?php

namespace Database\Seeders;

use App\Data\SourceAnalysisData;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * デモ用キャッチコピーを作成
 */
class CatchphraseSeeder extends Seeder
{
    public function run(): void
    {
        // 開発環境での再実行を考慮し、既存データをクリア
        DB::table('catchphrases')->truncate();

        $now = Carbon::now();

        /**
         * デモ用キャッチコピーデータ
         * Phase 4でGemini APIによる生成に置き換え予定
         */
        $catchphrases = [
            [
                'content' => '港町の風を感じながら、異国情緒あふれる神戸を満喫する特別な一日',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '兵庫県神戸市',
                    keywords: ['港町', '異国情緒', 'ハーバーランド']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '歴史と食が交差する大阪で、心もお腹も満たされる贅沢な時間',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '大阪府大阪市',
                    keywords: ['歴史', '食', '大阪城', '道頓堀']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '千年の都が織りなす美しい風景に、心が洗われる京都旅',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '京都府京都市',
                    keywords: ['千年の都', '清水寺', '嵐山']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '愛らしい鹿たちと触れ合い、古都の静けさに包まれる癒やしのひととき',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '奈良県奈良市',
                    keywords: ['鹿', '古都', '奈良公園', '東大寺']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '白鷺の舞うような美しい城で、日本の歴史ロマンに浸る',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '兵庫県姫路市',
                    keywords: ['白鷺城', '世界遺産', '姫路城']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '抹茶の香りに包まれ、平安の雅を感じる宇治での贅沢なひととき',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '京都府宇治市',
                    keywords: ['抹茶', '平等院', '宇治川']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '紀州の歴史を今に伝える城下町で、悠久の時に想いを馳せる',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '和歌山県和歌山市',
                    keywords: ['紀州', '城下町', '和歌山城']
                ),
                'performance_score' => null,
            ],
            [
                'content' => '日本最大の湖が見せる雄大な景色に、心が解き放たれる',
                'source_analysis' => new SourceAnalysisData(
                    cluster: '滋賀県大津市',
                    keywords: ['琵琶湖', '雄大', '湖畔']
                ),
                'performance_score' => null,
            ],
        ];

        foreach ($catchphrases as $catchphrase) {
            DB::table('catchphrases')->insert([
                'content' => $catchphrase['content'],
                'source_analysis' => json_encode($catchphrase['source_analysis']->toArray()),
                'performance_score' => $catchphrase['performance_score'],
                'created_at' => $now,
            ]);
        }
    }
}
