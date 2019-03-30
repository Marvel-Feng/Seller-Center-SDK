<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 14/01/19
 * Time: 11:13 ص
 */

namespace SellerCenter\Model;

class CategoryAttribute
{
    const SC_CATEGORY_ATTRIBUTE = 'Attribute';
    const SC_CATEGORY_NAME = 'Name';
    const SC_CATEGORY_LABEL = 'Label';
    const SC_CATEGORY_IS_MANDATORY = 'isMandatory';
    const SC_CATEGORY_DESCRIPTION = 'Description';
    const SC_CATEGORY_ATTRIBUTE_TYPE = 'AttributeType';
    const SC_CATEGORY_EXAMPLE_VALUE = 'ExampleValue';
    const SC_CATEGORY_GLOBAL_IDENTIFIER = 'GlobalIdentifier';
    const SC_CATEGORY_MULTIPLE_OPTIONS = 'Options';
    const SC_CATEGORY_SINGLE_OPTION = 'Option';

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $label
     */
    protected $label;

    /**
     * @var bool $isMandatory
     */
    protected $isMandatory;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $attributeType
     */
    protected $attributeType;

    /**
     * @var string $exampleValue
     */
    protected $exampleValue;

    /**
     * @var string $globalIdentifier
     */
    protected $globalIdentifier;

    /** @var array $options */
    protected $options;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return bool
     */
    public function isMandatory(): bool
    {
        return $this->isMandatory;
    }

    /**
     * @param bool $isMandatory
     */
    public function setIsMandatory(bool $isMandatory): void
    {
        $this->isMandatory = $isMandatory;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAttributeType(): string
    {
        return $this->attributeType;
    }

    /**
     * @param string $attributeType
     */
    public function setAttributeType(string $attributeType): void
    {
        $this->attributeType = $attributeType;
    }

    /**
     * @return string
     */
    public function getExampleValue(): string
    {
        return $this->exampleValue;
    }

    /**
     * @param string $exampleValue
     */
    public function setExampleValue(string $exampleValue): void
    {
        $this->exampleValue = $exampleValue;
    }


    /**
     * @return string
     */
    public function getGlobalIdentifier(): string
    {
        return $this->globalIdentifier;
    }

    /**
     * @param string $globalIdentifier
     */
    public function setGlobalIdentifier(string $globalIdentifier): void
    {
        $this->globalIdentifier = $globalIdentifier;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }


}