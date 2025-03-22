# ⚡ Bolt PDF

**Blade-to-PDF rendering for Laravel 10/11/12+ using Headless Chrome — supports full CSS3, JS, modern layouts, headers, footers, watermarks, and more.**

> Built with 💪 performance, 🧠 modern standards, and 🖤 Laravel elegance.

---

## ✨ Features

- 🧾 Convert any **Blade view** to a high-fidelity PDF
- 🎨 Supports **modern CSS3**: flexbox, grid, custom fonts
- 🧠 Executes **JavaScript**: charts, animations, etc.
- 🧢 Add headers, footers, and watermark overlays
- 🧊 Save, stream, download, or cache PDFs
- 🔄 Supports **queued generation** for large documents
- 🔧 Fully configurable, extensible & testable

---

## 🚀 Installation

```bash
composer require timbogdanov/bolt-pdf
If using Laravel < 5.5, register the service provider and facade manually in config/app.php. Otherwise, auto-discovery will handle it.

Publish the config:

bash
Copy
Edit
php artisan vendor:publish --tag=config
⚙️ Configuration
In .env:

env
Copy
Edit
BOLT_PDF_CHROME_PATH=/usr/bin/google-chrome
BOLT_PDF_TIMEOUT=30
In config/boltpdf.php, you can customize default margins, paper size, etc.

🧑‍💻 Usage
From a Blade view:
php
Copy
Edit
use BoltPdf\Facades\BoltPdf;

return BoltPdf::view('pdf.invoice', ['invoice' => $invoice])
              ->format('A4')
              ->landscape()
              ->header('<div>My Header</div>')
              ->footer('<div>Page <span class="pageNumber"></span></div>')
              ->watermark('CONFIDENTIAL')
              ->download('invoice.pdf');
Save to storage:
php
Copy
Edit
BoltPdf::view('pdf.report', $data)
       ->save('reports/weekly.pdf');
Queue generation (for large files):
php
Copy
Edit
GeneratePdfJob::dispatch('pdf.report', $data, 'reports/big.pdf');
📂 API Reference
Method	Description
view($blade, $data)	Load a Blade view
html($html)	Load raw HTML content
format('A4')	Set paper format
landscape()	Switch to landscape mode
timeout(30)	Set render timeout (in seconds)
header($html)	Add header HTML
footer($html)	Add footer HTML
watermark($text)	Add watermark text
stream($filename)	Stream PDF in browser
download($filename)	Force download of the PDF
save($path)	Save to local or cloud storage
output()	Return raw PDF content (binary)
🧪 Testing
bash
Copy
Edit
php artisan test
Or with PHPUnit:

bash
Copy
Edit
./vendor/bin/phpunit
🧩 Roadmap
 Headers & footers
 Watermark overlay
 Queued job support
 Blade directive: @pdf
 Caching support (->cache('key'))
 Chrome process pooling
🛡 Requirements
PHP 8.1+
Laravel 10/11/12+
Chrome or Chromium installed locally (/usr/bin/google-chrome or path in config)
❤️ Credits
Built by Tim Bogdanov.
Powered by chrome-php/chrome and the Laravel ecosystem.

📄 License
MIT © 2025

yaml
Copy
Edit

---

Let me know if you’d like a logo, docs site scaffold, or a publish-to-Packagist checklist!