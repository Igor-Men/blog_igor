<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use AppBundle\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{

    /**
     * @Route("/admin/create_post/")
     */
    public function createAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'one_post',
                array('id' => $post->getId())
            ));
        }

        return $this->render(':default:experement.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/list_post/")
     */
    public function listAction () {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        return $this->render(':default:list_post.html.twig', array('posts' => $posts));
    }

    /**
     * @Route("/post/{id}", name="one_post")
     */
    public function postAction ($id) {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
        return $this->render(':default:onepost.html.twig', array('post' => $post));
    }

}
