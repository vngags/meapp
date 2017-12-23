<?php

namespace App\Helpers;
use Image;
use File;

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
        return url('images/avatars/' . $filename . '.png');
    }

    static function save_social_avatar($src, $name) 
    {
        $filename = str_slug($name) . '_' . str_random(6);
        $avatar = Image::make($src);
        if (!file_exists(public_path('images/avatars'))) {
            mkdir(public_path('images/avatars'), 0777, true);
        }
        $avatar->save(public_path('images/avatars/'.$filename.'.png'));
        return url('images/avatars/' . $filename . '.png');
    }

    static public function generate_usercode()
    {
        $code = mt_rand(111111, 999999);
        $count = \App\User::where('uid', $code)->count();
        return  $count ? "{$code}-{$count}" : $code;    
    }

    static public function save_attachment($file, $dir, $filename)
     {
        $watermark = Image::canvas(86, 17, 'rgba(0,0,0,0.02)');
        $watermark->text('COCCOC.ME', 4, 4, function($font) {
            $font->file(public_path('/fonts/logo.ttf'));
            $font->size(12);
            $font->color('rgba(0,0,0,0.15)');
            $font->align('left');
            $font->valign('top');
        });
        $watermark->text('COCCOC.ME', 3, 3, function($font) {
            $font->file(public_path('/fonts/logo.ttf'));
            $font->size(12);
            $font->color('rgba(255,255,255,0.9)');
            $font->align('left');
            $font->valign('top');
        });
        $watermark->rotate(90);
        //\WATERMARK
        // CHECK directory
        if (!file_exists(public_path('images/' . $dir))) {
            mkdir(public_path('images/' . $dir), 0777, true);
        }
        // Check directory
        $image = array();

        $ext = $file->getClientOriginalExtension();

        if ($ext == 'gif') {
            //Nếu là ảnh gif thì copy file
            copy($file->getRealPath(), public_path('images/'.$dir.'/'.$filename.'.'.$ext));
            $image['name'] = $filename.'.'.$ext;
            $image['size'] = File::size(public_path('images/'.$dir.'/'.$filename.'.'.$ext));
            $image['url'] = url('images/' . $dir.'/'.$filename.'.'.$ext);
        }else {
            $img = Image::make($file);
            $w = $img->width();
            $h = $img->height();
            //resize if width > 800
            if($w > 1200) {
                $img->resize(1200, null, function($constraint) {
                $constraint->aspectRatio();
                });
            }
            $img->insert($watermark, 'bottom-right', 0, round($h/2 - 43));
            $img->save(public_path('images/'.$dir.'/'.$filename.'.'.$ext));
            $image['url'] = url('images/' . $dir.'/'.$filename.'.'.$ext);
            $image['size'] = $img->filesize();
            $image['name'] = $filename.'.'.$ext;
        }

        return $image;
    }

    static public function save_attachment_nochange_filename($file, $dir)
     {
        $watermark = Image::canvas(86, 17, 'rgba(0,0,0,0.02)');
        $watermark->text('COCCOC.ME', 4, 4, function($font) {
            $font->file(public_path('/fonts/logo.ttf'));
            $font->size(12);
            $font->color('rgba(0,0,0,0.15)');
            $font->align('left');
            $font->valign('top');
        });
        $watermark->text('COCCOC.ME', 3, 3, function($font) {
            $font->file(public_path('/fonts/logo.ttf'));
            $font->size(12);
            $font->color('rgba(255,255,255,0.9)');
            $font->align('left');
            $font->valign('top');
        });
        $watermark->rotate(90);
        //\WATERMARK
        // CHECK directory
        if (!file_exists(public_path('images/' . $dir))) {
            mkdir(public_path('images/' . $dir), 0777, true);
        }
        // Check directory
        $image = array();
        // $ext = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $filename_without_ext = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        return $filename_without_ext;
        if ($ext == 'gif') {
            //Nếu là ảnh gif thì copy file
            copy($file->getRealPath(), public_path('images/'.$dir.'/'.$filename_without_ext.'.'.$ext));
            $image['url'] = $dir.'/'.$filename_without_ext.'.'.$ext;
        }else {
                $img = Image::make($file);
                $w = $img->width();
                $h = $img->height();
                //resize if width > 800
                if($w > 1200) {
                    $img->resize(1200, null, function($constraint) {
                    $constraint->aspectRatio();
                    });
                }
                $img->insert($watermark, 'bottom-right', 0, round($h/2 - 43));
                $img->save(public_path('images/'.$dir.'/'.$filename_without_ext.'.'.$ext));
                $image['url'] = url('images/' . $dir.'/'.$filename_without_ext.'.'.$ext);
                $image['size'] = $img->filesize();
                $image['name'] = $dir.'/'.$filename_without_ext.'.'.$ext;
        }
        return $image;
    }
}