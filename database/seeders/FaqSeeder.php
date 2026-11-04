<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\QuestionTopic;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infoTopic = QuestionTopic::where('slug', 'layanan-informasi-publik')->first();
        $risetTopic = QuestionTopic::where('slug', 'kerjasama-riset-dan-litbang')->first();

        $faqs = [
            [
                'topic_id' => $infoTopic?->id,
                'question' => 'Bagaimana prosedur permohonan informasi publik instansi?',
                'answer' => '<p>Masyarakat dapat mengajukan permohonan informasi secara online melalui menu formulir pertanyaan di portal ini atau datang langsung ke meja layanan informasi publik kami dengan melampirkan identitas diri.</p>',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'topic_id' => $infoTopic?->id,
                'question' => 'Berapa lama waktu penyelesaian jawaban permohonan informasi?',
                'answer' => '<p>Sesuai dengan standar pelayanan, permohonan informasi akan ditanggapi paling lambat dalam waktu 3 hingga 10 hari kerja kerja.</p>',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'topic_id' => $risetTopic?->id,
                'question' => 'Bagaimana cara mengajukan proposal kerjasama riset maritim?',
                'answer' => '<p>Proposal riset dapat dikirimkan melalui email resmi atau diserahkan secara daring dengan menyertakan surat pengantar dari universitas / lembaga mitra.</p>',
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
