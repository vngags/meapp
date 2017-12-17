<?php

namespace App\Helpers;
use Image;

class FunctionHelper 
{
    static public function create_avatar_by_name($name)
    {
        $letter = strtoupper(substr($name, 0, 1));
        $color = array(
            '#0095ff', '#00b1b3', '#E91E63', '#f44336', '#2196F3', '#00bcd4', '#4caf50', '#cddc39', '#ff9800', '#9c27b0', '#673ab7'
        );
        $filename = str_slug($name) . '_' . str_random(6);
        $avatar = Image::canvas(200, 200, $color[array_rand($color)]);
        $avatar->text($letter, 100, 55, function($font) {
            $font->file(public_path('/fonts/arialbd.ttf'));
            $font->size(120);
            $font->color('rgba(255,255,255,1)');
            $font->align('center');
            $font->valign('top');
        });

        if (!file_exists(public_path('images/avatars'))) {
            mkdir(public_path('images/avatars'), 0777, true);
        }

        $avatar->save(public_path('images/avatars/'.$filename.'.png'));
        return url('avatars/' . $filename . '.png');
    }
}