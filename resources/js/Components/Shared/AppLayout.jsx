import { Link } from '@inertiajs/react';

export default function AppLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col bg-gradient-to-br from-secondary-light via-secondary to-secondary-lighter animate-gradientShift relative overflow-hidden">
            {/* 装飾的な背景要素 */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-warm-100/10 rounded-full blur-3xl animate-float" style={{ animationDelay: '0s', animationDuration: '8s' }}></div>
            <div className="absolute bottom-0 left-0 w-96 h-96 bg-warm-200/10 rounded-full blur-3xl animate-float" style={{ animationDelay: '2s', animationDuration: '10s' }}></div>
            <div className="absolute top-1/2 left-1/2 w-64 h-64 bg-primary/5 rounded-full blur-3xl animate-float" style={{ animationDelay: '4s', animationDuration: '12s' }}></div>

            {/* コンテンツラッパー */}
            <div className="relative z-10 min-h-screen flex flex-col">
            {/* ヘッダー */}
            <header className="bg-white/80 backdrop-blur-sm shadow-md border-b-2 border-primary/20" role="banner">
                <nav className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3" aria-label="メインナビゲーション">
                    <Link
                        href="/"
                        className="inline-flex items-center gap-3 hover:opacity-80 transition-opacity"
                        aria-label="日帰り地図帳 ホームページに戻る"
                    >
                        {/* バナー画像 */}
                        <img
                            src="/banner.png"
                            alt="日帰り地図帳"
                            className="h-12 sm:h-14 w-auto"
                        />
                    </Link>
                </nav>
            </header>

            {/* メインコンテンツ */}
            <main className="flex-1" role="main">
                {children}
            </main>

            {/* フッター */}
            <footer className="bg-white/30 backdrop-blur-sm mt-auto border-t border-gray-300/30" role="contentinfo">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    <p className="text-center text-xs text-gray-600/80">
                        &copy; {new Date().getFullYear()} 日帰り地図帳 (Daytrip Atlas). All rights reserved.
                    </p>
                </div>
            </footer>
            </div>
        </div>
    );
}
