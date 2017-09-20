<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Get paginated budgets
     *
     * @param Request $request
     * @param $page the current page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        try{
            $pageSize = 5;
            $budgetsList = $em->getRepository("AppBundle:Budget")->getAllBudgets($em, $pageSize, $page, $request);
            $totalItems = count($budgetsList);
            $pagesCount = ceil($totalItems/$pageSize);
        } catch (Exception $e){
            $response = new JsonResponse([
                "status" => "KO",
                "success" => false,
                "response" => $e->getMessage()
            ]);
            throw new Exception($response);
        }
        return $this->render("AppBundle:Default:index.html.twig",array(
            "budgets" => $budgetsList,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "page" => $page,
            "page_m" => $page
        ));
    }

    /**
     * Add a budget via post
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        try{
            $budget = $em->getRepository("AppBundle:Budget")->createBudget($request, $em);
            $em->persist($budget);
            $flush = $em->flush();
            if($flush === null){
                $response = new JsonResponse([
                    "status" => "OK",
                    "success" => true,
                    "message" => "The budget has been added"
                ]);
            }
        } catch (\Exception $e){
            $response = new JsonResponse([
                "status" => "KO",
                "success" => false,
                "response" => $e->getMessage()
            ]);
        }
        return $this->redirectToRoute("index", array("response" =>$response));
    }

    /**
     * Update a budget via post
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        try{
            $budget = $em->getRepository("AppBundle:Budget")->updateBudget($request, $em);
            $em->persist($budget);
            $flush = $em->flush();
            if($flush === null){
                $response = new JsonResponse([
                    "status" => "OK",
                    "success" => true,
                    "message" => "Budget updates successfully"
                ]);
            }
        } catch (\Exception $e){
            $response = new JsonResponse([
                "status" => "KO",
                "success" => false,
                "response" => $e->getMessage()
            ]);
        }
        return $this->redirectToRoute("index", array("response" =>$response));
    }

    /**
     * Publish a budget
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function publishAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        try{
            $budget = $em->getRepository("AppBundle:Budget")->publishBudget($request, $em);
            $em->persist($budget);
            $flush = $em->flush();
            if($flush === null){
                $response = new JsonResponse([
                    "status" => "OK",
                    "success" => true,
                    "The budget has been published"
                ]);
            }
        } catch (\Exception $e){
            $response = new JsonResponse([
                "status" => "KO",
                "success" => false,
                "response" => $e->getMessage()
            ]);
        }
        return $this->redirectToRoute("index", array("response" =>$response));
    }

    /**
     * Discard a budget
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function discardAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        try{
            $budget = $em->getRepository("AppBundle:Budget")->discardBudget($request, $em);
            $em->persist($budget);
            $flush = $em->flush();
            if($flush === null){
                $response = new JsonResponse([
                    "status" => "OK",
                    "success" => true,
                    "message" => "The budget has been discarded"
                ]);
            }
        } catch (\Exception $e){
            $response = new JsonResponse([
                "status" => "KO",
                "success" => false,
                "response" => $e->getMessage()
            ]);
        }
        return $this->redirectToRoute("index", array("response" =>$response));
    }

    /**
     * Render the modify view with data
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $budget_repo=$em->getRepository("AppBundle:Budget");
        $response=$budget_repo->findOneBy(array('id' => $request->request->get('id')));
        return $this->render("AppBundle:Default:modify.html.twig", array("budget" => $response));
    }

    /**
     * Render form view
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction(){
        return $this->render("AppBundle:Default:form.html.twig");
    }
}
