<?php

namespace App\Filament\Widgets;

use App\Enums\PostStatus;
use App\Enums\QuestionStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\Question;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingQuestions = Question::where('status', QuestionStatus::Pending)->count();
        $totalQuestions = Question::count();
        $publishedPosts = Post::where('status', PostStatus::Published)->count();
        $totalCategories = Category::where('is_active', true)->count();

        return [
            Stat::make('Pertanyaan Belum Dijawab', $pendingQuestions)
                ->description('Memerlukan tindak lanjut')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingQuestions > 0 ? 'warning' : 'success'),

            Stat::make('Total Pertanyaan Masuk', $totalQuestions)
                ->description('Dari masyarakat')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('info'),

            Stat::make('Artikel Diterbitkan', $publishedPosts)
                ->description('Aktif di portal berita')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Kategori Berita', $totalCategories)
                ->description('Kategori aktif')
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary'),
        ];
    }
}

