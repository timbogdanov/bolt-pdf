<?

namespace BoltPdf\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use BoltPdf\BoltPdfServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [BoltPdfServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('boltpdf.chrome_path', '/usr/bin/google-chrome');
    }
}