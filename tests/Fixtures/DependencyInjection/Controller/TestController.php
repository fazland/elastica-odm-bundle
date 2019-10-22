<?php declare(strict_types=1);

namespace Tests\Fixtures\DependencyInjection\Controller;

use Fazland\ODM\Elastica\DocumentManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Tests\Fixtures\Document\Foo;

class TestController extends AbstractController
{
    public function testAction(DocumentManagerInterface $documentManager)
    {
        $documentManager->persist($foo = new Foo());
        $foo->stringField = 'test';

        $documentManager->flush();

        $documents = $documentManager->getRepository(Foo::class)->findAll();

        return new Response(\count($documents));
    }
}
