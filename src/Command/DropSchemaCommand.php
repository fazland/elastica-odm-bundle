<?php declare(strict_types=1);

namespace Fazland\ODM\ElasticaBundle\Command;

use Fazland\ODM\Elastica\Command\DropSchemaCommand as BaseCommand;

class DropSchemaCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('fazland:elastica:drop-schema');
    }
}
