<?php


namespace App\Controller\Main;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    public function render_Default(){
        return [
            'title'=>'значение по умолчанию',
        ];
    }

}