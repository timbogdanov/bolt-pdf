<?

namespace BoltPdf;

use Illuminate\Support\ServiceProvider;

class BoltPdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/boltpdf.php', 'boltpdf');

        $this->app->singleton('boltpdf', function () {
            return new PdfFactory();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/boltpdf.php' => config_path('boltpdf.php')
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \BoltPdf\Commands\InstallBoltPdf::class,
            ]);
        }
    }
}