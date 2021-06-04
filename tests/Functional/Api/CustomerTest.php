<?php


namespace App\Tests\Functional\Api;

use App\Entity\Customer;
use App\Tests\Builder\CustomerBuilder;
use Faker\Factory;
use PHPUnit\Framework\MockObject\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerTest extends WebTestCase
{
    /** @var KernelBrowser  */
    protected KernelBrowser $client;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->client->disableReboot();
    }

    public function testGetCustomers(): void
    {
        $this->client->request(Request::METHOD_GET, '/api/customers');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content = $this->client->getResponse()->getContent());

        /** @var array $data */
        $data = json_decode($content, true);

        $this->assertArrayHasKey('success', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('total', $data);
    }

    /**
     * @return array
     */
    public function testAddCustomer(): array
    {
        /** @var Customer $customer */
        $customer = (new CustomerBuilder)->build();
        /** @var array $parameters */
        $parameters = $customer->jsonSerialize();
        unset($parameters['createdAt']);
        $this->client->request(Request::METHOD_POST, '/api/customers', $parameters);
        $this->assertSame(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content = $this->client->getResponse()->getContent());

        /** @var array $data */
        $data = json_decode($content, true);

        $this->assertArrayHasKey('success', $data);
        $this->assertArrayHasKey('data', $data);

        foreach ($data['data'] as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertNotEmpty($item['id']);
            $this->assertEquals($customer->getFirstName(), $item['firstName']);
            $this->assertEquals($customer->getLastName(), $item['lastName']);
            $this->assertEquals($customer->getEmail(), $item['email']);
            $this->assertEquals($customer->getPhoneNumber(), $item['phoneNumber']);
            return $item;
        }
    }

    /**
     * @depends testAddCustomer
     *
     * @param array $customer
     * @return array
     */
    public function testGetCustomer(array $customer): array
    {
        $this->client->request(Request::METHOD_GET, '/api/customers/' . $customer['id'] );
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content = $this->client->getResponse()->getContent());

        /** @var array $data */
        $data = json_decode($content, true);

        $this->assertArrayHasKey('success', $data);
        $this->assertArrayHasKey('data', $data);

        foreach ($data['data'] as $item) {
            $this->assertEquals($customer['id'], $item['id']);
            $this->assertEquals($customer['firstName'], $item['firstName']);
            $this->assertEquals($customer['lastName'], $item['lastName']);
            $this->assertEquals($customer['email'], $item['email']);
            $this->assertEquals($customer['phoneNumber'], $item['phoneNumber']);
            return $item;
        }
    }

    /**
     * @depends testGetCustomer
     *
     * @param array $customer
     * @return mixed
     */
    public function testUpdateCustomer(array $customer)
    {
        /** @var array $parameters */
        $parameters = $customer;

        /** @var Generator $faker */
        $faker = Factory::create();
        $parameters['firstName'] = $faker->firstName();
        $parameters['lastName'] = $faker->lastName();

        $this->client->request(Request::METHOD_PUT, '/api/customers/' . $customer['id'], $parameters);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content = $this->client->getResponse()->getContent());

        /** @var array $data */
        $data = json_decode($content, true);

        $this->assertArrayHasKey('success', $data);
        $this->assertArrayHasKey('data', $data);

        foreach ($data['data'] as $item) {
            $this->assertEquals($customer['id'], $item['id']);
            $this->assertNotEquals($customer['firstName'], $item['firstName']);
            $this->assertEquals($parameters['firstName'], $item['firstName']);
            $this->assertNotEquals($customer['lastName'], $item['lastName']);
            $this->assertEquals($parameters['lastName'], $item['lastName']);
            $this->assertEquals($customer['email'], $item['email']);
            $this->assertEquals($customer['phoneNumber'], $item['phoneNumber']);
            return $item;
        }
    }

    /**
     * @depends testGetCustomer
     *
     * @param array $customer
     * @return mixed
     */
    public function testDeleteCustomer(array $customer)
    {
        $this->client->request(Request::METHOD_DELETE, '/api/customers/' . $customer['id']);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content = $this->client->getResponse()->getContent());
        /** @var array $data */
        $data = json_decode($content, true);
        $this->assertArrayHasKey('success', $data);
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}