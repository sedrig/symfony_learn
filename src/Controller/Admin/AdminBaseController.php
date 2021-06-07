<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBaseController extends AbstractController
{
    public function render_Default(){
        return [
            'title'=>'для админки',
        ];
    }

}