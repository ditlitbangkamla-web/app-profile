<?php

namespace Tests\Feature;

use App\Enums\AnswerStatus;
use App\Enums\PageStatus;
use App\Enums\PostStatus;
use App\Enums\QuestionStatus;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionTopic;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_published_posts(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
        ]);

        Post::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Artikel Uji Coba Pertama',
            'slug' => 'artikel-uji-coba-pertama',
            'summary' => 'Ringkasan singkat',
            'content' => '<p>Isi artikel konten</p>',
            'status' => PostStatus::Published,
            'published_at' => now()->subHour(),
        ]);

        Post::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Artikel Masih Draft',
            'slug' => 'artikel-masih-draft',
            'content' => '<p>Belum tayang</p>',
            'status' => PostStatus::Draft,
        ]);

        $response = $this->getJson('/api/v1/posts');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Artikel Uji Coba Pertama');
    }

    public function test_can_get_single_post_and_increment_views(): void
    {
        $user = User::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Artikel Detail Test',
            'slug' => 'artikel-detail-test',
            'summary' => 'Ringkasan',
            'content' => '<p>Isi artikel detail</p>',
            'status' => PostStatus::Published,
            'published_at' => now(),
            'view_count' => 5,
        ]);

        $response = $this->getJson('/api/v1/posts/artikel-detail-test');

        $response->assertOk()
            ->assertJsonPath('data.title', 'Artikel Detail Test');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'view_count' => 6,
        ]);
    }

    public function test_can_get_published_page(): void
    {
        Page::create([
            'title' => 'Tentang Organisasi',
            'slug' => 'tentang-organisasi',
            'content' => '<p>Profil organisasi kami</p>',
            'status' => PageStatus::Published,
        ]);

        $response = $this->getJson('/api/v1/pages/tentang-organisasi');

        $response->assertOk()
            ->assertJsonPath('data.title', 'Tentang Organisasi');
    }

    public function test_can_list_categories(): void
    {
        Category::create([
            'name' => 'Kajian Strategis',
            'slug' => 'kajian-strategis',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/categories');

        $response->assertOk()
            ->assertJsonPath('data.0.name', 'Kajian Strategis');
    }

    public function test_can_list_slides(): void
    {
        Slide::create([
            'title' => 'Slide Selamat Datang',
            'image' => 'slides/banner.jpg',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/slides');

        $response->assertOk()
            ->assertJsonPath('data.0.title', 'Slide Selamat Datang');
    }

    public function test_can_get_menu_by_location(): void
    {
        $menu = Menu::create([
            'name' => 'Header Nav',
            'location' => 'header',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'label' => 'Beranda',
            'url' => '/',
            'type' => 'custom',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/menus/header');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Header Nav')
            ->assertJsonPath('data.items.0.label', 'Beranda');
    }

    public function test_can_get_settings(): void
    {
        Setting::create([
            'group' => 'general',
            'key' => 'site_name',
            'value' => 'Litbang Kamla',
            'type' => 'text',
        ]);

        $response = $this->getJson('/api/v1/settings');

        $response->assertOk()
            ->assertJsonPath('data.general.site_name', 'Litbang Kamla');
    }

    public function test_can_list_faqs(): void
    {
        $topic = QuestionTopic::create([
            'name' => 'Umum',
            'slug' => 'umum',
        ]);

        Faq::create([
            'topic_id' => $topic->id,
            'question' => 'Apakah layanan ini gratis?',
            'answer' => '<p>Ya, seluruh layanan tidak dipungut biaya.</p>',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->getJson('/api/v1/faqs');

        $response->assertOk()
            ->assertJsonPath('data.0.question', 'Apakah layanan ini gratis?');
    }

    public function test_can_list_public_answered_questions(): void
    {
        $user = User::factory()->create();
        $topic = QuestionTopic::create(['name' => 'Informasi', 'slug' => 'informasi']);

        $question = Question::create([
            'topic_id' => $topic->id,
            'name' => 'Ahmad',
            'email' => 'ahmad@example.com',
            'subject' => 'Tanya Jadwal',
            'body' => 'Kapan pendaftaran magang dibuka?',
            'status' => QuestionStatus::Answered,
        ]);

        QuestionAnswer::create([
            'question_id' => $question->id,
            'user_id' => $user->id,
            'body' => '<p>Pendaftaran dibuka bulan depan.</p>',
            'status' => AnswerStatus::Published,
            'is_published' => true,
        ]);

        $response = $this->getJson('/api/v1/questions');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.subject', 'Tanya Jadwal')
            ->assertJsonPath('data.0.answers.0.body', '<p>Pendaftaran dibuka bulan depan.</p>');
    }

    public function test_can_submit_new_question(): void
    {
        $topic = QuestionTopic::create(['name' => 'Pelayanan', 'slug' => 'pelayanan']);

        $payload = [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'phone' => '081234567890',
            'topic_id' => $topic->id,
            'subject' => 'Permohonan Narasumber Sosialisasi',
            'body' => 'Kami dari universitas ingin mengundang narasumber dari Litbang Keamanan Laut.',
        ];

        $response = $this->postJson('/api/v1/questions', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'Pertanyaan Anda berhasil dikirimkan dan akan segera ditindaklanjuti.')
            ->assertJsonPath('data.subject', 'Permohonan Narasumber Sosialisasi');

        $this->assertDatabaseHas('questions', [
            'email' => 'siti@example.com',
            'status' => QuestionStatus::Pending->value,
        ]);
    }

    public function test_submit_question_validates_required_fields(): void
    {
        $response = $this->postJson('/api/v1/questions', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'subject', 'body']);
    }
}
