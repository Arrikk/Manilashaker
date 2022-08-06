<?php
namespace App\Models;

class Site  extends \Core\Model
{
    /**
     *  Site Description (name, title, image, logo etc)
     * @return object;
    **/   
    public static function __site()
    {
        return static::select('*', 'site_option')->obj()->exec();
    }

    /**
     * site Seo Data
     * @return object
     */   
    public static function __seo()
    {
        return static::select('*', 'site_seo')->obj()->exec();
    }

    /**
     * site info
     * @return object
     */
    public static function __info()
    {
        return static::select('*', 'site_info')->obj()->exec();
    }

    /**
     * Site Gallery
     */
    public static function __gallery()
    {
        $path ='Public/asset/images';
        $dir = scandir($path);
        $images = [];
        foreach ($dir as $file) {
            if($file == '.' || $file == '..'){
                continue;
            }else{
                if(is_dir($path.'/'.$file)){
                    $in_dir = scandir($path.'/'.$file);
                    foreach ($in_dir as $img) {
                        if($img == '.' || $img == '..'):
                            continue;
                        else:
                            if(is_dir($path.'/'.$file.'/'.$img) === false)
                            $images[] = $path.'/'.$file.'/'.$img;
                        endif;
                    }
                }else{
                    if(is_dir($path.'/'.$file) === false)
                    $images[] = $path.'/'.$file;
                }
            }
        }
        return $images;
    }

}
