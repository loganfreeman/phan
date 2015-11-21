<?php declare(strict_types=1);
namespace Phan\CodeBase;

use \Phan\Language\Element\Property;
use \Phan\Language\FQSEN;

/**
 * Information pertaining to PHP code files that we've read
 */
trait PropertyMap {

    /**
     * @var Property[][]
     * A map from FQSEN  to name to a property
     */
    protected $property_map = [];

    /**
     * @return Property[][]
     * A map from FQSEN to name to property
     */
    public function getPropertyMap() : array {
        return $this->property_map;
    }

    /**
     * @return Property[]
     * A map from name to property
     */
    public function getPropertyMapForScope(FQSEN $fqsen) {
        if (empty($this->property_map[(string)$fqsen])) {
            return [];
        }

        return $this->property_map[(string)$fqsen];
    }

    /**
     * @param Property[] $property_map
     * A map from FQSEN to Property
     *
     * @return null
     */
    public function setPropertyMap(array $property_map) {
        $this->property_map = $property_map;
    }

    /**
     * @return bool
     */
    public function hasProperty(FQSEN $fqsen, string $name) : bool {
        return !empty($this->property_map[(string)$fqsen][$name]);
    }

    /**
     * @return Property
     * Get the property with the given FQSEN
     */
    public function getProperty(FQSEN $fqsen, string $name) : Property {
        return $this->property_map[(string)$fqsen][$name];
    }

    /**
     * @param Property $property
     * Any property
     *
     * @return null
     */
    public function addProperty(Property $property) {
        $this->addPropertyWithNameInScope(
            $property,
            $property->getName(),
            $property->getFQSEN()
        );
    }

    /**
     * @param Property $property
     * Any property
     *
     * @param FQSEN $fqsen
     * The FQSEN to index the property by
     *
     * @return null
     */
    public function addPropertyWithNameInScope(
        Property $property,
        string $name,
        FQSEN $fqsen
    ) {
        $this->property_map[(string)$fqsen][$name] = $property;
    }
}

