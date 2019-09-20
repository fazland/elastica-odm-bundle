<?php declare(strict_types=1);

namespace Tests\Fixtures\Document;

use Fazland\ODM\Elastica\Annotation\Document;
use Fazland\ODM\Elastica\Annotation\DocumentId;

/**
 * @Document()
 */
class Foo
{
    /**
     * @var string
     *
     * @DocumentId()
     */
    public $id;
}
