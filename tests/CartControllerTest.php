<?php

namespace App\Tests;

use App\Factory\CartItemFactory;
use App\Factory\ProductFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CartControllerTest extends WebTestCase
{
    use Factories, ResetDatabase;

    public function testCanSeeEmptyCart(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/panier');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Votre panier est vide', $crawler->text());
        $this->assertStringContainsString('0,00 €', $crawler->text());
    }

    public function testCanSeeCart(): void
    {
        // Arrange
        $product1 = ProductFactory::createOne(['price' => 500]);
        $product2 = ProductFactory::createOne(['price' => 1000]);

        $cartItem = CartItemFactory::createOne(['product' => $product1, 'quantity' => 1]);
        CartItemFactory::createOne(['product' => $product2, 'quantity' => 2, 'cart' => $cartItem->getCart()]);

        // Put session before test request
        $session = static::getContainer()->get('session.factory')->createSession();
        $session->set('cart', $cartItem->getCart()->getId());
        $session->save();

        // Act
        static::ensureKernelShutdown();
        $client = static::createClient();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        $crawler = $client->request('GET', '/panier');

        // Assert
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('6,00 € TTC', $crawler->text());
        $this->assertStringContainsString('12,00 € TTC', $crawler->text());
        $this->assertStringContainsString('24,00 € TTC', $crawler->text());
        $this->assertStringContainsString('25,00 €', $crawler->text());
        $this->assertStringContainsString('5,00 €', $crawler->text());
        $this->assertStringContainsString('30,00 €', $crawler->text());
    }
}