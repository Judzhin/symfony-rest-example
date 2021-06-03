<?php
/**
 * @access protected
 */

namespace App\Controller;


use App\Entity\Customer;
use App\ReadModel\CustomerFetcher;
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
            dd($exception->getMessage());
        }
    }
}
