<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->bind('latex_escape', function (?string $text): string {
            if (empty($text)) {
                return '';
            }
            $replacements = [
                '\\' => '\\textbackslash{}',
                '&' => '\\&',
                '%' => '\\%',
                '$' => '\\$',
                '#' => '\\#',
                '_' => '\\_',
                '{' => '\\{',
                '}' => '\\}',
                '~' => '\\textasciitilde{}',
                '^' => '\\textasciicircum{}',
            ];
            $text = str_replace(array_keys($replacements), array_values($replacements), $text);

            return $text;
        });
    }
}
