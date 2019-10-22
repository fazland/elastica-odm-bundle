<?php declare(strict_types=1);

namespace Tests\Fixtures\Document;

use Fazland\ODM\Elastica\Annotation\Document;
use Fazland\ODM\Elastica\Annotation\DocumentId;
use Fazland\ODM\Elastica\Annotation\Field;

/**
 * @Document("foo_index/foo_type")
 */
class Foo
{
    /**
     * @var string
     *
     * @DocumentId()
     */
    public $id;

    /**
     * @var string
     *
     * @Field()
     */
    public $stringField;
}
