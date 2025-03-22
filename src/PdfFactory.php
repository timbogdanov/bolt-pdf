<?

namespace BoltPdf;

use HeadlessChromium\BrowserFactory;
use Illuminate\Support\Facades\View;
use BoltPdf\Exceptions\PdfGenerationException;
use BoltPdf\Support\HtmlCleaner;
use Illuminate\Support\Facades\Storage;

class PdfFactory implements Contracts\PdfInterface
{
    protected string $html;
    protected array $options = [];

    public function view(string $bladeView, array $data = [])
    {
        $this->html = View::make($bladeView, $data)->render();
        return $this;
    }

    public function html(string $html)
    {
        $this->html = $html;
        return $this;
    }

    public function format(string $format)
    {

        $formats = [
            'A4' => ['paperWidth' => 8.27, 'paperHeight' => 11.69],
            'Letter' => ['paperWidth' => 8.5, 'paperHeight' => 11],
            'Legal' => ['paperWidth' => 8.5, 'paperHeight' => 14],
        ];

        if (isset($formats[$format])) {
            $this->options = array_merge($this->options, $formats[$format]);
        }

        return $this;
    }

    public function landscape()
    {
        $this->options['landscape'] = true;
        return $this;
    }

    public function timeout(int $seconds)
    {
        $this->options['timeout'] = $seconds * 1000;
        return $this;
    }

    public function header(string $html)
    {
        $this->options['displayHeaderFooter'] = true;
        $this->options['headerTemplate'] = $html;
        return $this;
    }

    public function footer(string $html)
    {
        $this->options['displayHeaderFooter'] = true;
        $this->options['footerTemplate'] = $html;
        return $this;
    }

    public function watermark(string $text)
    {
        $this->html .= "<div style='position: fixed; opacity: 0.1; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 5em;'>$text</div>";
        return $this;
    }

    public function stream(string $filename = 'document.pdf')
    {
        $pdf = $this->generate();
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "inline; filename=\"$filename\"");
    }

    public function download(string $filename = 'document.pdf')
    {
        $pdf = $this->generate();
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function save(string $path)
    {
        Storage::put($path, $this->generate());
        return $this;
    }

    public function output()
    {
        return $this->generate();
    }

    protected function generate()
    {
        $html = HtmlCleaner::clean($this->html);
        $chromePath = config('boltpdf.chrome_path');
        $timeout = config('boltpdf.timeout', 30);

        $browserFactory = new BrowserFactory($chromePath);
        $browser = $browserFactory->createBrowser([ 'noSandbox' => true ]);

        try {
            $page = $browser->createPage();
            $dataUrl = 'data:text/html,' . rawurlencode($html);
            $page->navigate($dataUrl)->waitForNavigation();

            $pdf = $page->pdf(array_merge(config('boltpdf.default_options'), $this->options))->getBase64();
            return base64_decode($pdf);
        } catch (\Throwable $e) {
            throw new PdfGenerationException($e->getMessage());
        } finally {
            $browser->close();
        }
    }
}