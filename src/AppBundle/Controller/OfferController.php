<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Offer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class OfferController extends FOSRestController
{
    /**
     * @Rest\Get("offers")
     */
    public function getAction()
    {
        $offers = $this->getDoctrine()->getRepository('AppBundle:Offer')->findAll();

        if ($offers === null) {
            return new View("there are no offer", Response::HTTP_NOT_FOUND);
        }

        return $offers;
    }


    /**
     * @Rest\Get("/offers/{id}")
     */
    public function idAction($id)
    {
        $offer = $this->getDoctrine()->getRepository('AppBundle:Offer')->find($id);

        if ($offer === null) {
            return new View("offer not found", Response::HTTP_NOT_FOUND);
        }

        return $offer;

    }

    /**
     * @Rest\Post("/offers")
     */
    public function postAction(Request $request)
    {
        $offer = New Offer();
        $title = $request->get('title');
        $description = $request->get('description');

        if (empty($title) || empty($description)) {
            return New View("null values are not allowed", Response::HTTP_NOT_ACCEPTABLE);
        }

        $offer->setTitle($title);
        $offer->setDescription($description);

        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();

        return new View('offer added successfully', Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/offers/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $data = new Offer();
        $title = $request->get('title');
        $description = $request->get('description');

        $em = $this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()->getRepository('AppBundle:Offer')->find($id);

        if (empty($offer)) {
            return new View('no offer found', Response::HTTP_NOT_FOUND);
        }
        elseif (!empty($title) && !empty($description)) {
            $offer->setTitle($title);
            $offer->setDescription($description);
            $em->persist($offer);
            $em->flush();

            return new View('offer updated successfully', Response::HTTP_OK);
        }
        elseif (empty($title) && !empty($description)) {
            $offer->setDescription($description);
            $em->persist($offer);
            $em->flush();

            return new View('description updated successfully', Response::HTTP_OK);
        }
        elseif (!empty($title) && empty($description)) {
            $offer->setTile($title);
            $em->persist($offer);
            $em->flush();

            return new View('title updated successfully', Response::HTTP_OK);
        }
        else return new View('Offer title and description cannot be empty');

    }

    /**
     * @Rest\Delete("/offers/{id}")
     */
    public function deleteAction($id)
    {
        $data = new Offer();
        $em = $this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()->getRepository('AppBundle:Offer')->find($id);

        if (empty($offer)) {
            return new View('no offer found', Response::HTTP_NOT_FOUND);
        }
        else {
            $em->remove($offer);
            $em->flush();
        }
        return new View('Offer deleted successfully', Response::HTTP_OK);
    }

}
