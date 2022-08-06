<?php
namespace App\Models;

class Settings extends \Core\Model
{
    /**
     * Get SITE Settings
     * 
     * @return object
     */
    public static function siteSetting()
    {
        return static::select('*', 'site_settings')->exec();
    }

     /**
      * Set SITE details / data
      *
      * @return bool
      **/
    public static function updateSiteSetting($field)
    {
        extract($field);
        
        if(!empty($file['icon']['name'])){
            if(isset(self::siteSetting()->favicon) && self::siteSetting()->favicon !== '' ){
                if(file_exists('.'.self::siteSetting()->favicon ?? '')){
                    unlink('.'.self::siteSetting()->favicon ?? '');
                }
            }
            $_icon = self::uploadImage($file['icon']);
        }
        if(!empty($file['logo']['name'])){
            if(isset(self::siteSetting()->logo) && self::siteSetting()->logo !== ''){
                if(file_exists('.'.self::siteSetting()->logo ?? '')){
                    unlink('.'.self::siteSetting()->logo ?? '');
                }
            }
            $_logo = self::uploadImage($file['logo']);
        }
        // echo json_encode(['logo' => $_logo, 'icon' => $_icon]);

        $setting = array(
            'id' => 0,
            'site_url' => 0,
            'slug' => '',
            'name' => static::clean($name),
            'logo' => static::clean(strip_tags($_logo)),
            'favicon' => static::clean(strip_tags($_icon))
        );

        $sel = static::select('*', 'site_settings');
        if(count($sel) > 0){
            return static::update('site_settings', null, $setting);
        }else{
            static::create('site_settings', $setting);
            return true;
        }
    }

    /**
     * Update Seo Settings
     */
    public static function updateSeoSetting($field)
    {
        extract($field);
        $data = [
            'meta_description' => $meta_description,
            'meta_keyword' => $meta_keyword,
            'google_analytics' => $google_analytics,
            'google_ads' => $google_ads,
        ];  

        $seo = static::select('*', 'site_seo')->obj()->exec();

        if($seo){
            return static::update('site_seo', $data)->exec();
        }else{
            return static::create('site_seo', $data)->exec();
        }
        return false;
    }
    public static function seoSetting()
    {
        return static::select('*', 'site_seo')->obj()->exec();
    }

    /**
     * SITE IMAGE
     * 
     * @return mixed
     */
    protected static function uploadImage($files)
    {
        $name = \basename($files['name']);
        $tmp = $files['tmp_name'];
        $type = $files['type'];
        $newName = time().$name;
        $path = '/Public/images/site/'.$newName;
        if($type == 'image/jpeg' || $type == 'image/png'){
            if(\move_uploaded_file($tmp, dirname('path').$path)){
                return $path;
            }
        }
        return false;
    }
    
    /**
     * Set SOCIAL SETTING
     */
    /**
     * Update Seo Settings
     */
    public static function updateSocialSetting($field)
    {
        extract($field);
        $data = [
            'facebook' => $facebook_link,
            'twitter' => $twitter_link,
            'linkedin' => $linkedin_link,
            'pinterest' => $pinterest_link,
        ];  

        $seo = static::select('social', 'site_option')->obj()->exec();

        if($seo)
            return static::update('site_option', [
                'social' => json_encode($data)
            ])->exec();
        return false;
    }
    public static function socialSetting()
    {
        $social = static::select('social', 'site_option')->obj()->exec();
        return json_decode($social->social);
    }

    /**
     * Set Widget SETTING
     */
    /**
     * Update Seo Settings
     */
    public static function updateWieSetting($field)
    {
        extract($field);
        if($limit == '5' || $limit == '10' || $limit == '15' || $limit == '20'){

            $data = [
                'quickLink' => [
                    'limit' => $limit,
                    'category' => $category,
                    'random' => false
                ],
                'ads' => [
                    'sqr' => $ss,
                    'rlg' => $rlg,
                    'rsm' => $rsm,
                ],
                'gadget' => [
                    'footer' => $gadgetFoot,
                    'side' => $gadgetSide
                ]
            ];
            
        }else{ 
            return false;
        }

        $seo = static::select('social', 'site_option')->obj()->exec();

        if($seo)
            return static::update('site_option', [
                'site' => json_encode($data)
            ])->exec();
        return false;
    }
    public static function wieSetting()
    {
        $social = static::select('site', 'site_option')->obj()->exec();
        return json_decode($social->site);
    }
}
