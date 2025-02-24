<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeFullResource extends Command
{
  protected $signature = 'make:resource-api {name}';
  protected $description = 'Create a full resource with Model, Controller, Repository, Interface, etc.';

  public function handle()
  {
    $name = $this->argument('name');
    $modelName = Str::studly(Str::singular($name));

    if (!File::exists(app_path("Models/{$modelName}.php"))) {
      $this->createModel($modelName);
      $this->info("Model created successfully!");
    } else {
      $this->warn("Model already exists!");
    }

    if (!File::exists(app_path("Http/Controllers/Api/{$modelName}Controller.php"))) {
      $this->createController($modelName);
      $this->info("Controller created successfully!");
    } else {
      $this->warn("Controller already exists!");
    }

    if (!File::exists(app_path("Contracts/Repositories/{$modelName}RepositoryInterface.php"))) {
      $this->createRepositoryInterface($modelName);
      $this->info("Repository Interface created successfully!");
    } else {
      $this->warn("Repository Interface already exists!");
    }

    if (!File::exists(app_path("Repositories/{$modelName}Repository.php"))) {
      $this->createRepository($modelName);
      $this->info("Repository created successfully!");
    } else {
      $this->warn("Repository already exists!");
    }

    $migrationName = "create_" . Str::snake(Str::plural($name)) . "_table";
    $migrationExists = collect(File::files(database_path("migrations")))
      ->contains(function ($file) use ($migrationName) {
        return Str::contains($file->getFilename(), $migrationName);
      });

    if (!$migrationExists) {
      $this->call('make:migration', [
        'name' => $migrationName,
      ]);
    } else {
      $this->warn("Migration already exists!");
    }

    $this->info("Full resource process completed!");
  }

  private function createModel($name)
  {
    $template = <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\HasUploadMultiple;
use App\Models\Traits\HasUserContext;

class $name extends Model
{
    use HasFactory, HasUploadMultiple, HasUserContext;

    protected \$fillable = [
        //
    ];

    protected \$casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
PHP;

    File::put(app_path("Models/{$name}.php"), $template);
  }

  private function createController($name)
  {
    $template = <<<PHP
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\\$name;
use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($name \$model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, $name \$model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($name \$model)
    {
        //
    }
}

PHP;

    File::put(app_path("Http/Controllers/Api/{$name}Controller.php"), $template);
  }

  private function createRepositoryInterface($name)
  {
    $template = <<<PHP
<?php

namespace App\Contracts\Repositories;

interface {$name}RepositoryInterface extends EloquentRepositoryInterface {}
PHP;

    File::put(app_path("Contracts/Repositories/{$name}RepositoryInterface.php"), $template);
  }

  private function createRepository($name)
  {
    $template = <<<PHP
<?php

namespace App\Repositories;

use App\Models\\$name;

class {$name}Repository extends EloquentRepository implements \App\Contracts\Repositories\\{$name}RepositoryInterface
{
    protected array \$allowedFilters = [];

    protected array \$allowedSorts = [];

    public function boot(): void
    {
        parent::boot();
    }

    public function model(): string
    {
        return {$name}::class;
    }
}
PHP;

    File::put(app_path("Repositories/{$name}Repository.php"), $template);
  }
}
