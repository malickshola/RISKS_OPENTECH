<?php

namespace Risk\PlateformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
class PostsRestController extends Controller
{
    public function getPostsAction($motcle){
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

               $qb->select('a')
                  ->from('RiskAdminBundle:Posts', 'a')
                  ->where("a.expediteur LIKE :motcle OR a.contenu LIKE :motcle OR a.objet LIKE :motcle")
                  ->orderBy('a.dateCreation', 'ASC')
                  ->setParameter('motcle', '%'.$motcle.'%');

               $query = $qb->getQuery();               
               $posts = $query->getResult();
        
        if(!is_object($posts)){
          throw $this->createNotFoundException();
        }
        return $posts;
  }
}
