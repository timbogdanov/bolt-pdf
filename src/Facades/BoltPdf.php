<?

namespace BoltPdf\Facades;

use Illuminate\Support\Facades\Facade;

class BoltPdf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'boltpdf';
    }
}