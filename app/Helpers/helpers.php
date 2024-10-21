<?php

if (! function_exists('getResponse')) {
  function getResponse(string $name)
  {
    $repoSingleton = "App\\Contracts\\Repositories\\{$name}RepositoryInterface";

    return app()->has($repoSingleton) ? app($repoSingleton) : null;
  }
}