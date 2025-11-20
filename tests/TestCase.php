<?php

namespace Mydnic\VoletFeatureBoardFilamentPlugin\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Mydnic\VoletFeatureBoardFilamentPlugin\VoletFeatureBoardFilamentPluginServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mydnic\\VoletFeatureBoardFilamentPlugin\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            \Filament\FilamentServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
            \Filament\Support\SupportServiceProvider::class,
            \Filament\Actions\ActionsServiceProvider::class,
            \Filament\Forms\FormsServiceProvider::class,
            \Filament\Infolists\InfolistsServiceProvider::class,
            \Filament\Notifications\NotificationsServiceProvider::class,
            \Filament\Tables\TablesServiceProvider::class,
            \Filament\Widgets\WidgetsServiceProvider::class,
            VoletFeatureBoardFilamentPluginServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');

        \Filament\Facades\Filament::registerPanel(
            fn (): \Filament\Panel => \Filament\Panel::make()
                ->id('default')
                ->default()
                ->plugin(new \Mydnic\VoletFeatureBoardFilamentPlugin\VoletFeatureBoardFilamentPlugin())
        );
    }
}
