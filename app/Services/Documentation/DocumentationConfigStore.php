<?php

namespace App\Services\Documentation;

use Illuminate\Support\Facades\File;

class DocumentationConfigStore
{
    public function deleteVersions(array $slugs): void
    {
        $slugs = collect($slugs)->filter()->unique()->values();

        if ($slugs->isEmpty()) {
            return;
        }

        $path = config_path('documentation.php');
        $config = require $path;

        foreach ($slugs as $slug) {
            unset($config['versions'][$slug]);
        }

        File::put($path, "<?php\n\nreturn ".var_export($config, true).";\n");
    }
}
