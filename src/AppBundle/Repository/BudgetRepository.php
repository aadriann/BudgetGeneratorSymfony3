<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Budget;
use AppBundle\Entity\Client;
use AppBundle\Entity\Status;
use AppBundle\Services\ValidatorService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * BudgetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BudgetRepository extends EntityRepository
{
    /**
     * Process all data to insert a budget and check if the user exist, in that case
     * no insert a new user and add the budget to him.
     *
     * @param Request $request
     * @param EntityManager $em
     * @return Budget
     */
    public function createBudget(Request $request, EntityManager $em){
        $status = new Status();
        $arrayRequest = $request->request;
        $client = $this->checkBudgetClient($arrayRequest, $em);
        $validator = new ValidatorService();
        $budget = new Budget();
        $budget->setCategory(trim($validator->validateMandatoryFields($arrayRequest->get('category'))));
        $budget->setSubcategory(trim($validator->validateMandatoryFields($arrayRequest->get('subcategory'))));
        $budget->setDescription(trim($validator->validateMandatoryFields($arrayRequest->get('description'))));
        $budget->setTitle(trim($arrayRequest->get('title')));
        $budget->setPrice(!is_null($arrayRequest->get('price')) ? $arrayRequest->get('price') : 0);
        $budget->setDate(trim($arrayRequest->get('date')));
        $budget->setStatus($validator->validateMandatoryFields($status->getPending()));
        $budget->setUserId($client);

        return $budget;
    }

    /**
     * Process all update data
     *
     * @param Request $request
     * @param EntityManager $em
     * @return Budget|null|object|void
     */
    public function updateBudget(Request $request, EntityManager $em) {
        // Instance Services
        $status = new Status();
        $validator = new ValidatorService();

        // Formatting Request
        $arrayRequest = $request->request;
        // If the status is accepted
        if($arrayRequest->get('status') !== $status->getAccepted()){
            $updateBudget = $em->getRepository("AppBundle:Budget")->findOneBy(array('id' => $request->request->get('id')));
            $updateBudget->setTitle(trim($validator->validateMandatoryFields($arrayRequest->get('title'))));
            $updateBudget->setCategory(trim($validator->validateMandatoryFields($arrayRequest->get('category'))));
            $updateBudget->setSubcategory(trim($validator->validateMandatoryFields($arrayRequest->get('subcategory'))));
        } else {
            $updateBudget = $validator->processException("The budget is not accepted yet", null, JsonResponse::HTTP_BAD_REQUEST);
        }
        return $updateBudget;
    }

    /**
     * Change the status to publish
     *
     * @param Request $request
     * @param EntityManager $em
     */
    public function publishBudget(Request $request, EntityManager $em) {
        $validator = new ValidatorService();
        $status = new Status();
        $arrayRequest = $request->request;
        $budget = $em->getRepository('AppBundle:Budget')
            ->findOneById($arrayRequest->get('id'));
        if(trim($validator->validateMandatoryFields($budget->getCategory())) &&
            trim($validator->validateMandatoryFields($budget->getTitle())))
        {
            $budget->setStatus($status->getAccepted());
        } else{
            $budget = $validator->processException("Category or Description can't be empty", null, JsonResponse::HTTP_BAD_REQUEST);
        }
        return $budget;
    }

    /**
     * Change the status to discarded
     *
     * @param Request $request
     * @param EntityManager $em
     */
    public function discardBudget(Request $request, EntityManager $em) {
        $validator = new ValidatorService();
        $status = new Status();
        $arrayRequest = $request->request;
        $budget = $em->getRepository('AppBundle:Budget')
            ->findOneById($arrayRequest->get('id'));
        if($budget->getStatus() !== $status->getDiscarded())
        {
            $budget->setStatus($status->getDiscarded());
        } else{
            $budget = $validator->processException("The budget was discarded yet", null, JsonResponse::HTTP_BAD_REQUEST);
        }
        return $budget;
    }


    /**
     * Check if the client exist when we add a budget
     *
     * @param $params
     * @param EntityManager $em
     * @return Client
     */
    private function checkBudgetClient($params, EntityManager $em) {
        $validator = new ValidatorService();
        $client = $em->getRepository('AppBundle:Client')
            ->findOneByEmail(trim($validator->validateMandatoryFields($params->get('email'))));
        if ($client) {
            $client->setPhone(
                empty($params->get('phone')) ? $client->getPhone()
                : trim($validator->validateMandatoryFields($params->get('phone')))
            );
            $client->setEmail(
                empty($params->get('email')) ? $client->getAddress()
                : trim($validator->validateMandatoryFields($params->get('email'))));
        } else {
            $client = new Client();
            $client->setName(trim($validator->validateMandatoryFields($params->get('name'))));
            $client->setLastName(trim($params->get('lastName')));
            $client->setPhone(trim($validator->validateMandatoryFields($params->get('phone'))));
            $client->setAddress(trim($params->get('address')));
            $client->setEmail(trim($validator->validateMandatoryFields($params->get('email'))));
            $em->persist($client);
        }
        $em->flush();
        return $client;
    }

    /**
     * Get paginated budgets
     *
     * @param EntityManager $em
     * @param int $pageSize
     * @param int $currentPage
     * @param $request
     * @return Paginator
     */
    public function getAllBudgets(EntityManager $em, $pageSize=5,$currentPage=1, $request){
        $arrayRequest = $request->request;
        if(!is_null($arrayRequest->get('email'))) {
            $client = $em->getRepository("AppBundle:Client")->findOneByEmail($arrayRequest->get('email'));
            $dql = "SELECT b FROM AppBundle:Budget b WHERE b.userId = ".$client->getId();
        } else{
            $dql = "SELECT b FROM AppBundle:Budget b";
        }
        $query = $em->createQuery($dql)
            ->setFirstResult($pageSize*($currentPage-1))
            ->setMaxResults($pageSize);

        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }

    /**
     * Get one budget by id
     *
     * @param Request $request
     * @param EntityManager $em
     * @return array
     */
    public function getBudget(Request $request, EntityManager $em) {
        $arrayRequest = $request->request;
        $budget = "SELECT b FROM AppBundle:Budget b WHERE b.id = ".$arrayRequest->get('id');
        $query = $em->createQuery($budget)->getResult();
        return $query;
    }
}
