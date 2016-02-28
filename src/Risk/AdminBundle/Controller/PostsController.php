<?php

namespace Risk\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Risk\AdminBundle\Entity\Posts;
use Risk\AdminBundle\Form\PostsType;

/**
 * Posts controller.
 *
 */
class PostsController extends Controller
{

    /**
     * Lists all Posts entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RiskAdminBundle:Posts')->findBy(array('idUtilisateurs'=>$this->getUser()));

        return $this->render('RiskAdminBundle:Posts:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Posts entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Posts();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setIdUtilisateurs($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('Threads_show', array('id' => $entity->getId())));
        }

        return $this->render('RiskAdminBundle:Posts:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Posts entity.
     *
     * @param Posts $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Posts $entity)
    {
        $form = $this->createForm(new PostsType(), $entity, array(
            'action' => $this->generateUrl('Threads_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Posts entity.
     *
     */
    public function newAction()
    {
        $entity = new Posts();
        $form   = $this->createCreateForm($entity);

        return $this->render('RiskAdminBundle:Posts:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Posts entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RiskAdminBundle:Posts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Posts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RiskAdminBundle:Posts:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Posts entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RiskAdminBundle:Posts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Posts entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RiskAdminBundle:Posts:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Posts entity.
    *
    * @param Posts $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Posts $entity)
    {
        $form = $this->createForm(new PostsType(), $entity, array(
            'action' => $this->generateUrl('Threads_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Posts entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RiskAdminBundle:Posts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Posts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('Threads_edit', array('id' => $id)));
        }

        return $this->render('RiskAdminBundle:Posts:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Posts entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RiskAdminBundle:Posts')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Posts entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('Threads'));
    }

    /**
     * Creates a form to delete a Posts entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Threads_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
public function rechercherAction()
{               
    $request = $this->container->get('request');

    if($request->isXmlHttpRequest())
    {
        $motcle = '';
        $motcle = $request->request->get('motcle');

        $em = $this->container->get('doctrine')->getEntityManager();

        if($motcle != '')
        {
               $qb = $em->createQueryBuilder();

               $qb->select('a')
                  ->from('RiskAdminBundle:Posts', 'a')
                  ->where("a.expediteur LIKE :motcle OR a.contenu LIKE :motcle OR a.objet LIKE :motcle")
                  ->orderBy('a.dateCreation', 'ASC')
                  ->setParameter('motcle', '%'.$motcle.'%');

               $query = $qb->getQuery();               
               $acteurs = $query->getResult();
               $qa = $em->createQueryBuilder();

               $qa->select('a')
                  ->from('RiskAdminBundle:Email', 'a')
                  ->where("a.domain LIKE :motcle")
                  ->setParameter('motcle', '%'.$motcle.'%');

               $query1 = $qa->getQuery();               
               $mail = $query1->getResult();
        }
        else {
            $acteurs = $em->getRepository('RiskAdminBundle:Posts')->findAll();
        }

        return $this->container->get('templating')->renderResponse('RiskPlateformBundle:Default:result.html.twig', array(
            'thread' => $acteurs,
             'mail'=>$mail
            ));
    }
    else {
        return $this->listerAction();
    }
}


public function checkBlacklistAction()
{               
    $request = $this->container->get('request');

    if($request->isXmlHttpRequest())
    {
        $motcle = '';
        $motcle = $request->request->get('motcle');

        $em = $this->container->get('doctrine')->getEntityManager();

        if($motcle != '')
        {
               $rbls = [
	'barracudacentral.org',
	'cbl.abuseat.org',
	'http.dnsbl.sorbs.net',
	'misc.dnsbl.sorbs.net',
	'socks.dnsbl.sorbs.net',
	'web.dnsbl.sorbs.net',
	'dnsbl-1.uceprotect.net',
	'dnsbl-3.uceprotect.net',
	'sbl.spamhaus.org',
	'zen.spamhaus.org',
	'psbl.surriel.com',
	'dnsbl.njabl.org',
	'rbl.spamlab.com',
	'noptr.spamrats.com',
	'cbl.anti-spam.org.cn',
	'dnsbl.inps.de',
	'httpbl.abuse.ch',
	'korea.services.net',
	'virus.rbl.jp',
	'wormrbl.imp.ch',
	'rbl.suresupport.com',
	'ips.backscatterer.org',
	'opm.tornevall.org',
	'multi.surbl.org',
	'tor.dan.me.uk',
	'relays.mail-abuse.org',
	'dialups.mail-abuse.org',
	'rdts.dnsbl.net.au',
	'duinv.aupads.org',
	'dynablock.sorbs.net',
	'residential.block.transip.nl',
	'dynip.rothen.com',
	'dul.blackhole.cantv.net',
	'mail.people.it',
	'blacklist.sci.kun.nl',
	'all.spamblock.unit.liu.se',
	'spamguard.leadmon.net',
    'csi.cloudmark.com',
];
$ip = gethostbyname($motcle);

echo $ip;
$rev         = join('.', array_reverse(explode('.', trim($ip))));
$i           = 1;
$rbl_count   = count($rbls);
$listed_rbls = [];
foreach ($rbls as $rbl)
{
    printf('Recherche sur %s, %d of %d... ', $rbl, $i, $rbl_count);
    $lookup = sprintf('%s.%s', $rev, $rbl);
    echo '<br/>';
    $listed = gethostbyname($lookup) !== $lookup;
    printf('[%s]%s', $listed ? 'LISTED' : 'OK', PHP_EOL);
    if ( $listed )
    {
        $listed_rbls[] = $rbl;
    }
    $i++;
}
printf('%s  n\'est listes sur %d des %d blacklists connues %s', $ip, count($listed_rbls), $rbl_count, PHP_EOL);
if ( ! empty($listed_rbls) )
{
    printf('%s list� sur %s%s', $ip, join(', ', $listed_rbls), PHP_EOL);
}
        }
        

        
    }
    return $this->container->get('templating')->renderResponse('RiskPlateformBundle:Default:resultBlacklist.html.twig'
            );
}
}
