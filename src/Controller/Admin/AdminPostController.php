<?php


namespace App\Controller\Admin;


use App\Controller\Admin\AdminBaseController;
use App\Entity\Post;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AdminPostController extends AdminBaseController
{
    /**
     * @Route("/admin/post", name="admin_post")
     **/
    public function index(){
        $post=$this->getDoctrine()->getRepository(Post::class)
            ->findAll();
        $checkCategory=$this->getDoctrine()->getRepository(Category::class)
            ->findAll();
        $forRender=parent::render_Default();
        $forRender['title']='Посты';
        $forRender['post']=$post;
        $forRender['check_category']=$checkCategory;
        return $this->render('admin/post/index.html.twig',$forRender);
    }

    /**
     * @Route ("/admin/post/create", name="admin_post_create")
     */
    public function create(Request $request){
        $em=$this->getDoctrine()->getManager();
        $post=new Post();
        $form=$this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $post->setCreatedAtValue();
            $post->setUpdatedAtValue();
            $post->setIsPublished();
            $em->persist($post);
            $em->flush();
            $this->addFlash("success",'Пост добавлен');
            return $this->redirectToRoute('admin_post');
        }
        $forRender=parent::render_Default();
        $forRender['title']='Создание поста';
        $forRender['form']=$form->createView();
        return $this->render('admin/post/form.html.twig',$forRender);
    }

    /**
     * @Route("/admin/post/update/{id}", name="admin_post_update")
     */
    public function update(int $id, Request $request){
        $em=$this->getDoctrine()->getManager();
        $post=$this->getDoctrine()->getRepository(Post::class)
            ->find($id);
        $form=$this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            if ($form->get('save')->isClicked()){
                $post->setUpdatedAtValue();
                $this->addFlash('success','Пост обновлен');
            }
            if ($form->get('delete')->isClicked()){
                $em->remove($post);
                $this->addFlash('success','Пост удален');
            }
            $em->flush();
            return $this->redirectToRoute('admin_post');
        }
        $forRender=parent::render_Default();
        $forRender['title']='Редактирование поста';
        $forRender['form']=$form->createView();
        return $this->render('admin/post/form.html.twig',$forRender);

    }


}