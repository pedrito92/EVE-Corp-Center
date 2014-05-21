<?php
/**
 * Created by PhpStorm.
 * User: florianneveu
 * Date: 21/05/2014
 * Time: 12:21
 */

namespace EVECorpCenter\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller {

    public function indexAction() {
        return $this->render('EVECorpCenterSiteBundle:Site:index.html.twig');
    }
}