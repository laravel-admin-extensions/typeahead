<?php

namespace Encore\Admin\Typeahead;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use Illuminate\Support\Arr;

class Typeahead extends Extension
{
    public $name = 'typeahead';

    public $assets = __DIR__.'/../resources/assets';

    public static function handle()
    {
        return function ($source, array $options = []) {

            $selector = $this->getElementClassSelector();

            $script = '';

            if (is_array($source) && !Arr::isAssoc($source)) {
                $options = json_encode(array_merge(compact('source'), $options));

                $script = <<<SCRIPT
$('{$selector}').typeahead($options);
SCRIPT;
            } elseif (is_string($source)) {

                $options = empty($options) ? '{}' : json_encode($options);

                $script = <<<SCRIPT
$.get("$source", function(data){

  var options = $options;
  options.source = data;
  
  console.log(options);
  
  $('{$selector}').typeahead(options);
},'json');
SCRIPT;
            }

            Admin::script($script);
        };
    }
}