<?php
namespace App\Controllers\Admin;
use \Core\View;
use \App\Models\Settings as Setting;

class Settings extends Authenticated
{

    // **********************************************
    // *****************SITE SETTING*************
    // **********************************************
    
    /**
     * Render Paystack setting page
     * 
     * @return void
     */
    public function siteAction()
    {
        View::draw('{settings/site}', [
            'title' => "Site Settings",
            '__is_admin' => true
        ]);
    }

    /**
     * Update Site setting 
     * 
     * @return void
     */
    public function updateSiteAction()
    {
        $update = Setting::updateWieSetting($_POST);
        echo $update;
    }

    /**
     * Retrieve Site settings
     * 
     * @return void
     */
    public function siteSettingAction()
    {
        $setting = Setting::wieSetting();
        header('content-type: application/json');
        echo \json_encode($setting);
    }
    // **********************************************
    // *****************SOCIAL SETTING*************
    // **********************************************
    
    /**
     * Render Paystack setting page
     * 
     * @return void
     */
    public function paystackAction()
    {
        View::autoload();
        View::draw('Admin/settings/paystack.html', ['title' => "Paystack Settings"]);
    }

    /**
     * Update Paystack setting 
     * 
     * @return void
     */
    public function updatePaystackAction()
    {
        $update = Setting::updatePaystackSetting($_POST);
        echo $update;
    }

    /**
     * Retrieve email settings
     * 
     * @return void
     */
    public function paystackSettingAction()
    {
        $setting = Setting::paystackSetting();
        header('content-type: application/json');
        echo \json_encode($setting);
    }

    // **********************************************
    // *****************SME SETTING*************
    // **********************************************
    
    /**
     * Render SME setting page
     * 
     * @return void
     */
    public function smeAction()
    {
        View::draw('{settings/site}', [
            'title' => "Site Settings",
            '__is_admin' => true
        ]);
    }

    /**
     * Update SME setting 
     * 
     * @return void
     */
    public function updateSmeApiAction()
    {
        $update = Setting::updateSmeApiSetting($_POST);
        echo $update;
    }

    /**     
     * Retrieve SME settings
     * 
     * @return void
     */
    public function smeApiSettingAction()
    {
        $setting = Setting::smeApiSetting();
        header('content-type: application/json');
        echo \json_encode($setting);
    }

    // **********************************************
    // *****************SEO SETTING*************
    // **********************************************
    
    /**
     * Render SEO setting page
     * 
     * @return void
     */
    public function seoAction()
    {
        View::draw('{settings/seo}', [
            'title' => "SEO Settings",
            '__is_admin' => true
        ]);
    }

    /**
     * Update SEO setting 
     * 
     * @return void
     */
    public function updateSeoAction()
    {
        $update = Setting::updateSeoSetting($_POST);
        echo $update;
    }

    /**
     * Retrieve email settings
     * 
     * @return void
     */
    public function seoSettingAction()
    {
        $setting = Setting::seoSetting();
        header('content-type: application/json');
        echo \json_encode($setting);
    }
    
    // **********************************************
    // *****************SOCIAL SETTING*************
    // **********************************************
    
    /**
     * Render Social setting page
     * 
     * @return void
     */
    public function socialAction()
    {
        View::draw('{/settings/social}', [
            '__is_admin' => true
        ]);
    }

    /**
     * Update Social setting 
     * 
     * @return void
     */
    public function updateSocialAction()
    {
        $update = Setting::updateSocialSetting($_POST);
        echo $update;
    }

    /**
     * Retrieve email settings
     * 
     * @return void
     */
    public function socialSettingAction()
    {
        $setting = Setting::socialSetting();
        header('content-type: application/json');
        echo \json_encode($setting);
    }

    // ++++++++++++++++====================+++++++++++++
    // +++++++++++++++++++++++++++++++++++++++++++++++++
    // ===========+ EMAIL SETTINGS HERE ++++++**********
    // +++++++++++++++++++++++++++++====================

    /**
     * Render Email Setting Page
     * @return void
     */
    public function emailAction()
    {
        View::autoload();
        View::draw('Admin/settings/email.html', ['title' => "Email Settings"]);
    }

    /**
     * Update Email setting
     * 
     * @return void
     */
    public function updateEmailAction()
    {
        $update = Setting::updateEmailSetting($_POST);
        echo $update;
    }

    /**
     * Retrieve email settings
     * 
     * @return void
     */
    public function emailSettingAction()
    {
        $setting = Setting::emailSetting();
        header('content-type: application/json');
        echo \json_encode($setting);
    }

    // ++++++++++++++++====================+++++++++++++
    // +++++++++++++++++++++++++++++++++++++++++++++++++
    // ===========+ PASSWORD SETTINGS HERE ++++++******
    // +++++++++++++++++++++++++++++====================

    /**
     * View Password Page
     */
    public function passwordAction()
    {
        View::draw('{/settings/password}', [
            '__is_admin' => true
        ]);
    }
     /**
     * change Pasword
     * 
     * @return void
     */
    public function passwordSettingAction()
    {
        $result = '';
        if($this->user->verifyPassword($_POST['old'])){
            if($this->user->resetPassword($_POST['new'])){
                $result = "Password Successfully Changed";
            }else{
                \http_response_code(500);
                $result = "Try Again";
            }
        }else{
            \http_response_code(400);
            $result = "Incorrect old Password";
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }  

}
