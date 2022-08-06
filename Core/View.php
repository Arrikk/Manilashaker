<?php
namespace Core;
/**
 * View Base Controller
 * 
 * PHP version 7.4.8
 */
class View 
{
    /**
     * Render a view file
     * 
     * @param string $view the view file
     * 
     * @return void 
     */
    public static function draw($view = null, $args = [], $autoload = true){
        if($autoload){
            self::autoload();
        }
        extract($args, EXTR_SKIP);
        $__page = '';    
        if(preg_match('/\{([^\}]+)\}/i', $view, $matches)){
            $view = 'index.php';
            $__page = $matches[1];
        }
        $file = 'App/Views/'.$view;

        if(is_readable($file)){
            require $file;
        }else{
            echo "$file Not Found";
        }
    }



    /**
     * Autoload component files 
     * 
     * @param string $path the component folder
     * 
     * @return void
     */
    public static function autoload($path = ''){
        $path = 'App/Views/components/'.$path;
        $dir = scandir($path);
        $files = [];
        // \extract($GLOBALS['settings']);     
        foreach($dir as $dir){
            if($dir == '..' || $dir == '...' || $dir == '.'){
                continue;
            }else{
                if(is_dir($path.$dir) === false){
                    // require $path.$dir;
                    $files[] = $path.$dir;
                }elseif (is_dir($path.$dir)) {
                    $inDir = \scandir($path.$dir);
                    foreach ($inDir as $in_dir) {
                        if($in_dir == '..' || $in_dir == '...' || $in_dir == '.'){
                            continue;
                        }else{
                            if(is_dir($path.$dir.'/'.$in_dir) === false){
                                // require $path.$dir.'/'.$in_dir;
                                $files[] = $path.$dir.'/'.$in_dir;
                            }
                        }
                    }
                }
            }
        }

        foreach ($files as $key) {
            require $key;
        }
    }

    /**
     * Render a Twig template File
     */
    public static function render($view, $args = [])
    {
        static $twig = null;
        if($twig === null){
            $loader = new \Twig_Loader_Filesystem('App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('user', \App\Auth::getUser());
            $twig->addGlobal('message', \App\Flash::getMessage());
            $twig->addGlobal('URL', \App\Config::BASE_URL);
            
        }
        echo $twig->render($view, $args);
    }

    /**
     * Render a Twig template File
     */
    public static function template($view, $args = [])
    {
        static $twig = null;
        if($twig === null){
            $loader = new \Twig_Loader_Filesystem('App/Views');
            $twig = new \Twig_Environment($loader);
            
        }
        return $twig->render($view, $args);
    }
}
