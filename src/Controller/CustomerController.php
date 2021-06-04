<?php
/**
 * @access protected
 */

namespace App\Controller;

use App\Entity\Customer;
use App\ReadModel\CustomerFetcher;
use App\Repository\CustomerRepository;
use App\UseCase\Customer\Create;
use App\UseCase\Customer\Update;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CustomerController
 *
 * @package App\Controller
 */
#[Route('/api', name: 'customer_api')]
class CustomerController extends AbstractController
{
    use RestController;

    /**
     * CustomerController constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ){}

    /**
     * @param CustomerFetcher $fetcher
     * @return JsonResponse
     */
    #[Route('/customers', name: 'customers', methods: ['GET'])]
    public function getCustomers(CustomerFetcher $fetcher): JsonResponse
    {
        return $this->createResponse([
            'success' => true,
            'data' => $fetcher->all(),
            'total' => $fetcher->total()
        ]);
    }

    /**
     * @param Customer $customer
     *
     * @return JsonResponse
     */
    private function respondCustomer(Customer $customer): JsonResponse
    {
        return $this->respondCreated([
            'success' => true,
            'data' => [$customer]
        ]);
    }

    /**
     * @param Request $request
     * @param Create\Handler $handler
     *
     * @return JsonResponse
     */
    #[Route('/customers', name: 'customers_add', methods: ['POST'])]
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
            return $this->respondCustomer($customer);
        } catch (\Throwable $exception) {
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param CustomerRepository $repository
     * @param $id
     *
     * @return JsonResponse
     */
    #[Route('/customers/{id}', name: 'customers_get', methods: ['GET'])]
    public function getCustomer(CustomerRepository $repository , $id): JsonResponse
    {
        /** @var Customer $customer */
        if ($customer = $repository->find($id)) {
            return $this->respondCustomer($customer);
        }

        return $this->respondNotFound('Customer not found');
    }

    /**
     * @param Customer $customer
     * @param Request $request
     * @param Update\Handler $handler
     *
     * @return JsonResponse
     */
    #[Route('/customers/{id}', name: 'customers_put', methods: ['PUT'])]
    public function updateCustomer(Customer $customer, Request $request, Update\Handler $handler): JsonResponse
    {
        /** @var Update\Command $command */
        $command = Update\Command::parse($customer);
        $command->firstName = $request->get('firstName');
        $command->lastName = $request->get('lastName');
        $command->email = $request->get('email');
        $command->phoneNumber = $request->get('phoneNumber');

        $handler->handle($command);

        return $this->respondCustomer($customer);

        ///** @var Customer $customer */
        //if ($customer = $repository->find($id)) {
        //
        //}

        // return $this->respondNotFound('Customer not found');
    }

    /**
     * @param Request $request
     * @param CustomerRepository $repository
     * @param $id
     *
     * @return JsonResponse
     */
    #[Route('/customers/{id}', name: 'customers_delete', methods: ['DELETE'])]
    public function deleteCustomer(Request $request, CustomerRepository $repository , $id): JsonResponse
    {
        /** @var Customer $customer */
        if ($customer = $repository->find($id)) {
            return $this->respondCustomer($customer);
        }

        return $this->respondNotFound('Customer not found');
    }
}
