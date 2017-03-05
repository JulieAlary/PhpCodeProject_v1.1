<?php

namespace CMS\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{

    /**
     * Vérifier si les pages se chargent
     */
    public function testPageIsSuccessful()
    {

        $client = static::createClient();

        foreach ($this->provideUrls() as $url) {

            $client->request('GET', $url);
            $this->assertTrue($client->getResponse()->isSuccessful());
        }
    }

    private function provideUrls()
    {

        return array('/');
    }

    /**
     * Tester si on a bien des mots dans une page
     */
    public function testWordInpage()
    {

        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals('CMS\CoreBundle\Controller\CoreController::indexAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertTrue(200 == $client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h3:contains("Actus")')->count() >= 1);
    }

}