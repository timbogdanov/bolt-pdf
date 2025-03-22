<?

namespace BoltPdf\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallBoltPdf extends Command
{
    protected $signature = 'bolt:install';
    protected $description = 'Detect and configure Google Chrome for Bolt PDF';

    public function handle()
    {
        $this->info('🔍 Detecting Chrome binary path...');

        $possiblePaths = [
            '/usr/bin/google-chrome',
            '/usr/bin/chromium-browser',
            '/usr/bin/chromium',
            '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
            'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe'
        ];

        $detected = null;

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $detected = $path;
                break;
            }
        }

        if (! $detected) {
            $this->error("❌ Could not detect Chrome. Please install it or set BOLT_PDF_CHROME_PATH manually in your .env file.");
            return 1;
        }

        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        $pattern = '/^BOLT_PDF_CHROME_PATH=.*$/m';

        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, 'BOLT_PDF_CHROME_PATH="' . $detected . '"', $envContent);
        } else {
            $envContent .= "\nBOLT_PDF_CHROME_PATH=\"$detected\"\n";
        }

        file_put_contents($envPath, $envContent);

        $this->info("✅ Chrome path set to: $detected");
        $this->info("✨ You're ready to use Bolt PDF!");

        return 0;
    }
}