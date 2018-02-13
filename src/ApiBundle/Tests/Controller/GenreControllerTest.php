<?php
/**
 * This file is part of ApiBundle\Tests\Controller package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ApiBundle\Tests\Controller;


class GenreControllerTest extends ControllerTestCase
{
    protected $apiTokenAuthentication = true;

    public function testGenreActionReturnValidData()
    {
        $client = $this->getClient();

        $client->request('GET', '/api/v1/genres');

        $response = $client->getResponse();
        $this->assert200($response);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $data = $data['data'];
        foreach ($data as $item) {
            foreach (['id', 'name', 'photo'] as $key) {
                $this->assertArrayHasKey($key, $item);
            }
        }
    }
}