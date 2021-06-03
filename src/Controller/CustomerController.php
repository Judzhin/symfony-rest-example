<?php
/**
 * @access protected
 */

namespace App\Controller;


use App\Entity\Customer;
use App\ReadModel\CustomerFetcher;
use App\Repository\CustomerRepository;
use App\UseCase\Customer\Create;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CustomerController
 *
 * @package App\Controller
 *
 * @Route("/api", name="customer_api")
 */
class CustomerController extends AbstractController
{
    use RestController;

    /**
     * @param CustomerFetcher $fetcher
     * @return JsonResponse
     */
    #[Route("/customers", name: 'customers', methods: ["GET"])]
    public function getCustomers(CustomerFetcher $fetcher): JsonResponse
    {
        return $this->createResponse([
            'success' => true,
            'data' => $fetcher->all(),
            'total' => $fetcher->total()
        ]);
    }

    /**
     * @param Request $request
     * @param Create\Handler $handler
     *
     * @return JsonResponse
     */
    #[Route("/customers", name: 'customers_add', methods: ["POST"])]
    public function addCustomer(Request $request, Create\Handler $handler): JsonResponse
    {
        $request = $this->transformJsonBody($request);

        try {
            /** @var Create\Command $command */
            $command = new Create\Command;
            $command->firstName = $request->get('firstName');
            $command->lastName = $request->get('lastName');
            $command->email = $request->get('email');
            $command->phoneNumber = $request->get('phoneNumber');
            $customer = $handler->handle($command);
            return $this->respondCreated([
                'success' => true,
                'data' => [$customer]
            ]);
        } catch (\Throwable $exception) {
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param CustomerRepository $repository
     * @param $id
     *
     * @return JsonResponse
     */
    #[Route("/customers/{id}", name: 'customers_get', methods: ["GET"])]
    public function getCustomer(Request $request, CustomerRepository $repository , $id): JsonResponse
    {
        /** @var Customer $customer */
        if ($customer = $repository->find($id)) {
            return $this->createResponse([
                'success' => true,
                'data' => [$customer]
            ]);
        }

        return $this->respondNotFound("Customer not found");
    }

    /**
     * @param Request $request
     * @param CustomerRepository $repository
     * @param $id
     *
     * @return JsonResponse
     */
    #[Route("/customers/{id}", name: 'customers_get', methods: ["PUT"])]
    public function updateCustomer(Request $request, CustomerRepository $repository , $id): JsonResponse
    {
        /** @var Customer $customer */
        if ($customer = $repository->find($id)) {
            return $this->createResponse([
                'success' => true,
                'data' => [$customer]
            ]);
        }

        return $this->respondNotFound("Customer not found");
    }
}
