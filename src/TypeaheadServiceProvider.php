<?php

namespace Encore\Admin\Typeahead;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field\Text;
use Illuminate\Support\ServiceProvider;

class TypeaheadServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Typeahead $extension)
    {
        if (! Typeahead::boot()) {
            return ;
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/typeahead')],
                'laravel-admin-typeahead'
            );
        }

        Admin::booting(function () {

            Admin::js('vendor/laravel-admin-ext/typeahead/bootstrap3-typeahead.min.js');

            Text::macro('typeahead', Typeahead::handle());
        });
    }
}