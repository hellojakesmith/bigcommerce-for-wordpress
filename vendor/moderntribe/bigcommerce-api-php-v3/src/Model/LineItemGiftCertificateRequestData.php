<?php
/**
 * LineItemGiftCertificateRequestData
 *
 * PHP version 5
 *
 * @category Class
 * @package  BigCommerce\Api\v3
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Data Model for BigCommerce's v3 Server-to-Server Cart API
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: v0.0.1
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
 * LineItemGiftCertificateRequestData Class Doc Comment
 *
 * @category    Class */
/**
 * @package     BigCommerce\Api\v3
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class LineItemGiftCertificateRequestData implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'LineItemGiftCertificateRequestData';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'name' => 'string',
        'theme' => 'string',
        'amount' => 'float',
        'quantity' => 'int',
        'sender' => '\BigCommerce\Api\v3\Model\ContactEntity',
        'recipient' => '\BigCommerce\Api\v3\Model\ContactEntity',
        'message' => 'string'
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
        'name' => 'name',
        'theme' => 'theme',
        'amount' => 'amount',
        'quantity' => 'quantity',
        'sender' => 'sender',
        'recipient' => 'recipient',
        'message' => 'message'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'name' => 'setName',
        'theme' => 'setTheme',
        'amount' => 'setAmount',
        'quantity' => 'setQuantity',
        'sender' => 'setSender',
        'recipient' => 'setRecipient',
        'message' => 'setMessage'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'name' => 'getName',
        'theme' => 'getTheme',
        'amount' => 'getAmount',
        'quantity' => 'getQuantity',
        'sender' => 'getSender',
        'recipient' => 'getRecipient',
        'message' => 'getMessage'
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
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['theme'] = isset($data['theme']) ? $data['theme'] : null;
        $this->container['amount'] = isset($data['amount']) ? $data['amount'] : null;
        $this->container['quantity'] = isset($data['quantity']) ? $data['quantity'] : null;
        $this->container['sender'] = isset($data['sender']) ? $data['sender'] : null;
        $this->container['recipient'] = isset($data['recipient']) ? $data['recipient'] : null;
        $this->container['message'] = isset($data['message']) ? $data['message'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
        if ($this->container['name'] === null) {
            $invalid_properties[] = "'name' can't be null";
        }
        if ($this->container['theme'] === null) {
            $invalid_properties[] = "'theme' can't be null";
        }
        if ($this->container['amount'] === null) {
            $invalid_properties[] = "'amount' can't be null";
        }
        if (($this->container['amount'] > 1000.0)) {
            $invalid_properties[] = "invalid value for 'amount', must be smaller than or equal to 1000.0.";
        }

        if (($this->container['amount'] < 1.0)) {
            $invalid_properties[] = "invalid value for 'amount', must be bigger than or equal to 1.0.";
        }

        if ($this->container['quantity'] === null) {
            $invalid_properties[] = "'quantity' can't be null";
        }
        if (($this->container['quantity'] < 1)) {
            $invalid_properties[] = "invalid value for 'quantity', must be bigger than or equal to 1.";
        }

        if ($this->container['sender'] === null) {
            $invalid_properties[] = "'sender' can't be null";
        }
        if ($this->container['recipient'] === null) {
            $invalid_properties[] = "'recipient' can't be null";
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
        if ($this->container['name'] === null) {
            return false;
        }
        if ($this->container['theme'] === null) {
            return false;
        }
        if ($this->container['amount'] === null) {
            return false;
        }
        if ($this->container['amount'] > 1000.0) {
            return false;
        }
        if ($this->container['amount'] < 1.0) {
            return false;
        }
        if ($this->container['quantity'] === null) {
            return false;
        }
        if ($this->container['quantity'] < 1) {
            return false;
        }
        if ($this->container['sender'] === null) {
            return false;
        }
        if ($this->container['recipient'] === null) {
            return false;
        }
        return true;
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
     * @param string $name Given name for gift certificate line item.
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets theme
     * @return string
     */
    public function getTheme()
    {
        return $this->container['theme'];
    }

    /**
     * Sets theme
     * @param string $theme Currently supports `Birthday`, `Boy`, `Celebration`, `Christmas`, `General`, and `Girl`.
     * @return $this
     */
    public function setTheme($theme)
    {
        $this->container['theme'] = $theme;

        return $this;
    }

    /**
     * Gets amount
     * @return float
     */
    public function getAmount()
    {
        return $this->container['amount'];
    }

    /**
     * Sets amount
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {

        if (($amount > 1000.0)) {
            throw new \InvalidArgumentException('invalid value for $amount when calling LineItemGiftCertificateRequestData., must be smaller than or equal to 1000.0.');
        }
        if (($amount < 1.0)) {
            throw new \InvalidArgumentException('invalid value for $amount when calling LineItemGiftCertificateRequestData., must be bigger than or equal to 1.0.');
        }

        $this->container['amount'] = $amount;

        return $this;
    }

    /**
     * Gets quantity
     * @return int
     */
    public function getQuantity()
    {
        return $this->container['quantity'];
    }

    /**
     * Sets quantity
     * @param int $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {

        if (($quantity < 1)) {
            throw new \InvalidArgumentException('invalid value for $quantity when calling LineItemGiftCertificateRequestData., must be bigger than or equal to 1.');
        }

        $this->container['quantity'] = $quantity;

        return $this;
    }

    /**
     * Gets sender
     * @return \BigCommerce\Api\v3\Model\ContactEntity
     */
    public function getSender()
    {
        return $this->container['sender'];
    }

    /**
     * Sets sender
     * @param \BigCommerce\Api\v3\Model\ContactEntity $sender
     * @return $this
     */
    public function setSender($sender)
    {
        $this->container['sender'] = $sender;

        return $this;
    }

    /**
     * Gets recipient
     * @return \BigCommerce\Api\v3\Model\ContactEntity
     */
    public function getRecipient()
    {
        return $this->container['recipient'];
    }

    /**
     * Sets recipient
     * @param \BigCommerce\Api\v3\Model\ContactEntity $recipient
     * @return $this
     */
    public function setRecipient($recipient)
    {
        $this->container['recipient'] = $recipient;

        return $this;
    }

    /**
     * Gets message
     * @return string
     */
    public function getMessage()
    {
        return $this->container['message'];
    }

    /**
     * Sets message
     * @param string $message Message shown to recipient, as provided by sender.
     * @return $this
     */
    public function setMessage($message)
    {
        $this->container['message'] = $message;

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


