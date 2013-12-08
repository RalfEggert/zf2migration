<?php
/**
 * ZF2 migration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace Application\Hydrator;

use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PrefixHydrator
 *
 * @package Application\Hydrator
 */
abstract class PrefixHydrator extends ClassMethods
{
    /**
     * @var string
     */
    protected $prefix = null;

    /**
     * @throws InvalidArgumentException
     */
    function __construct()
    {
        if (is_null($this->getPrefix())) {
            throw new InvalidArgumentException(
                'No prefix is set for the PrefixHydrator!'
            );
        }
    }

    /**
     * @param object $object
     *
     * @return array
     */
    public function extract($object)
    {
        $data = parent::extract($object);

        foreach ($data as $key => $value) {
            $newKey = $this->getPrefix() . $key;

            $data[$newKey] = $value;
            unset($data[$key]);
        }

        return $data;
    }

    /**
     * @param array  $data
     * @param object $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        foreach ($data as $key => $value) {
            $newKey = str_replace($this->getPrefix(), '', $key);

            $data[$newKey] = $value;
            unset($data[$key]);
        }

        return parent::hydrate(
            $data, $object
        );
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = (string)$prefix;
    }


} 