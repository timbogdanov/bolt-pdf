<?

namespace BoltPdf\Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use BoltPdf\Facades\BoltPdf;

class PdfGenerationTest extends TestCase
{
    public function test_pdf_can_be_generated_and_saved()
    {
        Storage::fake();

        BoltPdf::view('pdf.test', ['foo' => 'bar'])
            ->format('A4')
            ->save('test.pdf');

        Storage::assertExists('test.pdf');
    }
}