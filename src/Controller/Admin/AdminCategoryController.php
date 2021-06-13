<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    /**
     * @Route("/admin/category", name="admin_category")
     **/
    public function index(){
        $category=$this->getDoctrine()->getRepository(Category::class)
            ->findAll();

        $forRender=parent::render_Default();
        $forRender['title']='Категории';
        $forRender['category']=$category;
        return $this->render('admin/category/index.html.twig',$forRender);
    }

    /**
     * @Route ("/admin/category/create", name="admin_category_create")
     */
    public function create(Request $request){
        $em=$this->getDoctrine()->getManager();
        $category=new Category();
        $form=$this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $category->setCreatedAtValue();
            $category->setUpdatedAtValue();
            $category->setIsPublished();
            $em->persist($category);
            $em->flush();
            $this->addFlash("success",'Категория добавлена');
            return $this->redirectToRoute('admin_category');
        }
        $forRender=parent::render_Default();
        $forRender['title']='Создание категории';
        $forRender['form']=$form->createView();
        return $this->render('admin/category/form.html.twig',$forRender);
    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     */
    public function update(int $id, Request $request){
        $em=$this->getDoctrine()->getManager();
        $category=$this->getDoctrine()->getRepository(Category::class)
            ->find($id);
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            if ($form->get('save')->isClicked()){
                $category->setUpdatedAtValue();
                $this->addFlash('success','Категория обновлена');
            }
            if ($form->get('delete')->isClicked()){
                $em->remove($category);
                $this->addFlash('success','Категория удалена');
            }
            $em->flush();
            return $this->redirectToRoute('admin_category');
        }
        $forRender=parent::render_Default();
        $forRender['title']='Редактирование категории';
        $forRender['form']=$form->createView();
        return $this->render('admin/category/form.html.twig',$forRender);

    }
}