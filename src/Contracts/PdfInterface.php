<?

namespace BoltPdf\Contracts;

interface PdfInterface
{
    public function view(string $bladeView, array $data = []);
    public function html(string $html);
    public function format(string $format);
    public function landscape();
    public function timeout(int $seconds);
    public function header(string $html);
    public function footer(string $html);
    public function watermark(string $text);
    public function stream(string $filename);
    public function download(string $filename);
    public function save(string $path);
    public function output();
}