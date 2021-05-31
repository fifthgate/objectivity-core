<?php
/**
 * A simple trait to fluff json serialization in the absence of something better.
 *
 * @category ValueObject
 * @package  Objectivity Core
 * @author   Sam Baynham <sam@fifthgate.net>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/fifthgate/objectivity-core
 * @since    2021
 */
namespace Fifthgate\Objectivity\Core\Domain\Traits;

use ReflectionMethod;
use \DateTimeInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\JsonSerializableDomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\JsonSerializableDomainEntityCollectionInterface;
use JsonSerializable;

/**
 * Soft Deletiong trait for objectivity-compatible Domain Entities.
 *
 * @category ValueObject
 * @package  Objectivity Core
 * @author   Sam Baynham <sam@fifthgate.net>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/fifthgate/objectivity-core
 * @since    2021
 */
trait SoftDeletes
{
     protected $deletedAt;

    final public function setDeletedAt(DateTimeInterface $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    final public function getDeletedAt() : ? DateTimeInterface
    {
        return $this->deletedAt;
    }
}