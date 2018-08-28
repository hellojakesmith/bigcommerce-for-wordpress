<?php
/**
 * Listing
 *
 * PHP version 5
 *
 * @category Class
 * @package  BigCommerce\Api\v3
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * BigCommerce Channels API
 *
 * The Channels API enables you to create and manage listings across a BigCommerce merchant's sales channels.
 *
 * OpenAPI spec version: 1.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace BigCommerce\Api\v3\Model;

use \ArrayAccess;

/**
 * Listing Class Doc Comment
 *
 * @category    Class */
/**
 * @package     BigCommerce\Api\v3
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Listing implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'Listing';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'channel_id' => 'int',
        'listing_id' => 'int',
        'product_id' => 'int',
        'external_product_id' => 'string',
        'external_link' => 'string',
        'state' => 'string',
        'name' => 'string',
        'description' => 'string',
        'brand' => 'string',
        'condition' => 'string',
        'categories' => 'string[]',
        'custom_properties' => '\BigCommerce\Api\v3\Model\ListingCustomProperties',
        'created_at' => 'string',
        'updated_at' => 'string',
        'errors' => '\BigCommerce\Api\v3\Model\ListingError[]',
        'variants' => '\BigCommerce\Api\v3\Model\ListingVariant[]'
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'channel_id' => 'channel_id',
        'listing_id' => 'listing_id',
        'product_id' => 'product_id',
        'external_product_id' => 'external_product_id',
        'external_link' => 'external_link',
        'state' => 'state',
        'name' => 'name',
        'description' => 'description',
        'brand' => 'brand',
        'condition' => 'condition',
        'categories' => 'categories',
        'custom_properties' => 'custom_properties',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'errors' => 'errors',
        'variants' => 'variants'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'channel_id' => 'setChannelId',
        'listing_id' => 'setListingId',
        'product_id' => 'setProductId',
        'external_product_id' => 'setExternalProductId',
        'external_link' => 'setExternalLink',
        'state' => 'setState',
        'name' => 'setName',
        'description' => 'setDescription',
        'brand' => 'setBrand',
        'condition' => 'setCondition',
        'categories' => 'setCategories',
        'custom_properties' => 'setCustomProperties',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt',
        'errors' => 'setErrors',
        'variants' => 'setVariants'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'channel_id' => 'getChannelId',
        'listing_id' => 'getListingId',
        'product_id' => 'getProductId',
        'external_product_id' => 'getExternalProductId',
        'external_link' => 'getExternalLink',
        'state' => 'getState',
        'name' => 'getName',
        'description' => 'getDescription',
        'brand' => 'getBrand',
        'condition' => 'getCondition',
        'categories' => 'getCategories',
        'custom_properties' => 'getCustomProperties',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt',
        'errors' => 'getErrors',
        'variants' => 'getVariants'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    const STATE_UNKNOWN_LISTING_STATE = 'unknown_listing_state';
    const STATE_PENDING = 'pending';
    const STATE_PENDING_DISABLE = 'pending_disable';
    const STATE_PENDING_DELETE = 'pending_delete';
    const STATE_QUEUED = 'queued';
    const STATE_SUBMITTED = 'submitted';
    const STATE_ACTIVE = 'active';
    const STATE_ERROR = 'error';
    const STATE_REJECTED = 'rejected';
    const STATE_DISABLED = 'disabled';
    const STATE_DELETED = 'deleted';
    

    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getStateAllowableValues()
    {
        return [
            self::STATE_UNKNOWN_LISTING_STATE,
            self::STATE_PENDING,
            self::STATE_PENDING_DISABLE,
            self::STATE_PENDING_DELETE,
            self::STATE_QUEUED,
            self::STATE_SUBMITTED,
            self::STATE_ACTIVE,
            self::STATE_ERROR,
            self::STATE_REJECTED,
            self::STATE_DISABLED,
            self::STATE_DELETED,
        ];
    }
    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['channel_id'] = isset($data['channel_id']) ? $data['channel_id'] : null;
        $this->container['listing_id'] = isset($data['listing_id']) ? $data['listing_id'] : null;
        $this->container['product_id'] = isset($data['product_id']) ? $data['product_id'] : null;
        $this->container['external_product_id'] = isset($data['external_product_id']) ? $data['external_product_id'] : null;
        $this->container['external_link'] = isset($data['external_link']) ? $data['external_link'] : null;
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['brand'] = isset($data['brand']) ? $data['brand'] : null;
        $this->container['condition'] = isset($data['condition']) ? $data['condition'] : null;
        $this->container['categories'] = isset($data['categories']) ? $data['categories'] : null;
        $this->container['custom_properties'] = isset($data['custom_properties']) ? $data['custom_properties'] : null;
        $this->container['created_at'] = isset($data['created_at']) ? $data['created_at'] : null;
        $this->container['updated_at'] = isset($data['updated_at']) ? $data['updated_at'] : null;
        $this->container['errors'] = isset($data['errors']) ? $data['errors'] : null;
        $this->container['variants'] = isset($data['variants']) ? $data['variants'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
        if ($this->container['product_id'] === null) {
            $invalid_properties[] = "'product_id' can't be null";
        }
        if ($this->container['state'] === null) {
            $invalid_properties[] = "'state' can't be null";
        }
        $allowed_values = ["unknown_listing_state", "pending", "pending_disable", "pending_delete", "queued", "submitted", "active", "error", "rejected", "disabled", "deleted"];
        if (!in_array($this->container['state'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'state', must be one of #{allowed_values}.";
        }

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        if ($this->container['product_id'] === null) {
            return false;
        }
        if ($this->container['state'] === null) {
            return false;
        }
        $allowed_values = ["unknown_listing_state", "pending", "pending_disable", "pending_delete", "queued", "submitted", "active", "error", "rejected", "disabled", "deleted"];
        if (!in_array($this->container['state'], $allowed_values)) {
            return false;
        }
        return true;
    }


    /**
     * Gets channel_id
     * @return int
     */
    public function getChannelId()
    {
        return $this->container['channel_id'];
    }

    /**
     * Sets channel_id
     * @param int $channel_id
     * @return $this
     */
    public function setChannelId($channel_id)
    {
        $this->container['channel_id'] = $channel_id;

        return $this;
    }

    /**
     * Gets listing_id
     * @return int
     */
    public function getListingId()
    {
        return $this->container['listing_id'];
    }

    /**
     * Sets listing_id
     * @param int $listing_id
     * @return $this
     */
    public function setListingId($listing_id)
    {
        $this->container['listing_id'] = $listing_id;

        return $this;
    }

    /**
     * Gets product_id
     * @return int
     */
    public function getProductId()
    {
        return $this->container['product_id'];
    }

    /**
     * Sets product_id
     * @param int $product_id
     * @return $this
     */
    public function setProductId($product_id)
    {
        $this->container['product_id'] = $product_id;

        return $this;
    }

    /**
     * Gets external_product_id
     * @return string
     */
    public function getExternalProductId()
    {
        return $this->container['external_product_id'];
    }

    /**
     * Sets external_product_id
     * @param string $external_product_id
     * @return $this
     */
    public function setExternalProductId($external_product_id)
    {
        $this->container['external_product_id'] = $external_product_id;

        return $this;
    }

    /**
     * Gets external_link
     * @return string
     */
    public function getExternalLink()
    {
        return $this->container['external_link'];
    }

    /**
     * Sets external_link
     * @param string $external_link
     * @return $this
     */
    public function setExternalLink($external_link)
    {
        $this->container['external_link'] = $external_link;

        return $this;
    }

    /**
     * Gets state
     * @return string
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $allowed_values = array('unknown_listing_state', 'pending', 'pending_disable', 'pending_delete', 'queued', 'submitted', 'active', 'error', 'rejected', 'disabled', 'deleted');
        if ((!in_array($state, $allowed_values))) {
            throw new \InvalidArgumentException("Invalid value for 'state', must be one of 'unknown_listing_state', 'pending', 'pending_disable', 'pending_delete', 'queued', 'submitted', 'active', 'error', 'rejected', 'disabled', 'deleted'");
        }
        $this->container['state'] = $state;

        return $this;
    }

    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets description
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets brand
     * @return string
     */
    public function getBrand()
    {
        return $this->container['brand'];
    }

    /**
     * Sets brand
     * @param string $brand
     * @return $this
     */
    public function setBrand($brand)
    {
        $this->container['brand'] = $brand;

        return $this;
    }

    /**
     * Gets condition
     * @return string
     */
    public function getCondition()
    {
        return $this->container['condition'];
    }

    /**
     * Sets condition
     * @param string $condition
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->container['condition'] = $condition;

        return $this;
    }

    /**
     * Gets categories
     * @return string[]
     */
    public function getCategories()
    {
        return $this->container['categories'];
    }

    /**
     * Sets categories
     * @param string[] $categories
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->container['categories'] = $categories;

        return $this;
    }

    /**
     * Gets custom_properties
     * @return \BigCommerce\Api\v3\Model\ListingCustomProperties
     */
    public function getCustomProperties()
    {
        return $this->container['custom_properties'];
    }

    /**
     * Sets custom_properties
     * @param \BigCommerce\Api\v3\Model\ListingCustomProperties $custom_properties
     * @return $this
     */
    public function setCustomProperties($custom_properties)
    {
        $this->container['custom_properties'] = $custom_properties;

        return $this;
    }

    /**
     * Gets created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->container['created_at'];
    }

    /**
     * Sets created_at
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->container['created_at'] = $created_at;

        return $this;
    }

    /**
     * Gets updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->container['updated_at'];
    }

    /**
     * Sets updated_at
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->container['updated_at'] = $updated_at;

        return $this;
    }

    /**
     * Gets errors
     * @return \BigCommerce\Api\v3\Model\ListingError[]
     */
    public function getErrors()
    {
        return $this->container['errors'];
    }

    /**
     * Sets errors
     * @param \BigCommerce\Api\v3\Model\ListingError[] $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->container['errors'] = $errors;

        return $this;
    }

    /**
     * Gets variants
     * @return \BigCommerce\Api\v3\Model\ListingVariant[]
     */
    public function getVariants()
    {
        return $this->container['variants'];
    }

    /**
     * Sets variants
     * @param \BigCommerce\Api\v3\Model\ListingVariant[] $variants
     * @return $this
     */
    public function setVariants($variants)
    {
        $this->container['variants'] = $variants;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\BigCommerce\Api\v3\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\BigCommerce\Api\v3\ObjectSerializer::sanitizeForSerialization($this));
    }
}

