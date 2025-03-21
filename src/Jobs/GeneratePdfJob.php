<?

namespace BoltPdf\Jobs;

use BoltPdf\Facades\BoltPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $view;
    protected array $data;
    protected string $path;

    public function __construct(string $view, array $data, string $path)
    {
        $this->view = $view;
        $this->data = $data;
        $this->path = $path;
    }

    public function handle(): void
    {
        BoltPdf::view($this->view, $this->data)->save($this->path);
    }
}
