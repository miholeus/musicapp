<?php

namespace ApiBundle\Tests\Controller;

class SecurityControllerTest extends ControllerTestCase
{
    protected $apiKeyAuthentication = true;

    public function testAuthenticationWithInvalidCredentialsFails()
    {
        $client = $this->getClient();

        $client->request('POST', '/api/v1/auth/logins', ['login' => 'foo', 'password' => 'test']);

        $response = $client->getResponse();
        $this->assert404($response);
        $this->assertException($response, 404);
    }

    public function testAuthenticationWithValidCredentials()
    {
        $client = $this->getClient();

        $client->request('POST', '/api/v1/auth/logins', ['login' => 'demo', 'password' => 'demo']);

        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $content = $this->getResponseContent($response);
        $this->assertArrayHasKey('token', $content['data']);
    }

    /**
     * Tests that blocked user cannot be authenticated
     */
    public function testAuthenticationByBlockedUserFails()
    {
        $factory = static::$kernel->getContainer()->get('test_entity_factory');

        /** @var \CoreBundle\Entity\User $user */
        $user = $factory->createUser();
        $password = 'demo';

        /** @var \CoreBundle\Service\User $userService */
        $userService = static::$kernel->getContainer()->get('user.service');
        $userService->block($user);
        $userService->changePassword($user, $password);

        $client = $this->getClient();
        $client->request('POST', '/api/v1/auth/logins', ['login' => $user->getLogin(), 'password' => $password]);

        $response = $client->getResponse();
        $this->assert403($response);
        $this->assertException($response, 403);
    }
}
