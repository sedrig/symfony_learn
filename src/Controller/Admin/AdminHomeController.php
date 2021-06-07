<?php


namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
class AdminHomeController extends AdminBaseController
{
    /**
     * @Route ("/admin", name="admin_home")
     */
    public function index(){
        $forRender=parent::render_Default();
        return $this->render('admin/index.html.twig',$forRender);
    }
}