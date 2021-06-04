<?php
/**
 * @access protected
 */

namespace App\Controller;

use App\Entity\Customer;
use App\Exception\EntityNotFoundException;
use App\ReadModel\CustomerFetcher;
use App\Repository\CustomerRepository;
use App\UseCase\Customer\Create;
use App\UseCase\Customer\Delete;
use App\UseCase\Customer\Update;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->createResponse([
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
            return $this
                ->setStatusCode(Response::HTTP_CREATED)
                ->respondCustomer($customer);
        } catch (\Throwable $exception) {
            $this->logger->warning($message = $exception->getMessage());
            return $this->respondWithErrors($message);
        }
    }

    /**
     * @param CustomerFetcher $fetcher
     * @param $id
     *
     * @return JsonResponse
     */
    #[Route('/customers/{id}', name: 'customers_get', methods: ['GET'])]
    public function getCustomer(CustomerFetcher $fetcher , $id): JsonResponse
    {
        try {
            /** @var Customer $customer */
            $customer = $fetcher->find($id);
            return $this->respondCustomer($customer);
        } catch (EntityNotFoundException $exception) {
            $this->logger->alert($message = $exception->getMessage());
            return $this->respondNotFound($message);
        } catch (\Throwable $exception) {
            $this->logger->warning($message = $exception->getMessage());
            return $this->respondWithErrors($message);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @param Update\Handler $handler
     *
     * @return JsonResponse
     */
    #[Route('/customers/{id}', name: 'customers_put', methods: ['PUT'])]
    public function updateCustomer(Request $request, string $id, Update\Handler $handler): JsonResponse
    {
        $request = $this->transformJsonBody($request);

        /** @var Update\Command $command */
        $command = new Update\Command($id);
        $command->firstName = $request->get('firstName');
        $command->lastName = $request->get('lastName');
        $command->email = $request->get('email');
        $command->phoneNumber = $request->get('phoneNumber');

        try {
            $customer = $handler->handle($command);
            return $this->respondCustomer($customer);
        } catch (EntityNotFoundException $exception) {
            $this->logger->alert($message = $exception->getMessage());
            return $this->respondNotFound($message);
        } catch (\Throwable $exception) {
            $this->logger->warning($message = $exception->getMessage());
            return $this->respondWithErrors($message);
        }
    }

    /**
     * @param Delete\Handler $handler
     * @param $id
     *
     * @return JsonResponse
     */
    #[Route('/customers/{id}', name: 'customers_delete', methods: ['DELETE'])]
    public function deleteCustomer(Delete\Handler $handler , $id): JsonResponse
    {
        /** @var Delete\Command $command */
        $command = new Delete\Command($id);

        try {
            $handler->handle($command);
            return $this->respondWithSuccess('Customer deleted successfully');
        } catch (EntityNotFoundException $exception) {
            $this->logger->alert($message = $exception->getMessage());
            return $this->respondNotFound($message);
        } catch (\Throwable $exception) {
            $this->logger->warning($message = $exception->getMessage());
            return $this->respondWithErrors($message);
        }
    }
}