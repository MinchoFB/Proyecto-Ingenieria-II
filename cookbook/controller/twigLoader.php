<?php


    function getTwigEnviroment(){
        $cwd = getcwd();
        $loader = new \Twig_Loader_Filesystem($cwd.'/view/');
        $twig = new \Twig_Environment($loader);
        return $twig;
    }
    
//    public function index(){
//        
//        $twig = $this->getTwigEnviroment();
//        $template = $twig->loadTemplate('frontend-home.html.twig');
//        
//        echo $template->render(array());
//    }
//    
//    public function about() {
//
//        $twig = $this->getTwigEnviroment();
//        $template = $twig->loadTemplate('about.html.twig');
//
//        echo $template->render(array());
//    }
