<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/admin/v1/iam.proto

namespace Google\Iam\Admin\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The service account sign blob response.
 *
 * Generated from protobuf message <code>google.iam.admin.v1.SignBlobResponse</code>
 */
class SignBlobResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The id of the key used to sign the blob.
     *
     * Generated from protobuf field <code>string key_id = 1;</code>
     */
    private $key_id = '';
    /**
     * The signed blob.
     *
     * Generated from protobuf field <code>bytes signature = 2;</code>
     */
    private $signature = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $key_id
     *           The id of the key used to sign the blob.
     *     @type string $signature
     *           The signed blob.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Iam\Admin\V1\Iam::initOnce();
        parent::__construct($data);
    }

    /**
     * The id of the key used to sign the blob.
     *
     * Generated from protobuf field <code>string key_id = 1;</code>
     * @return string
     */
    public function getKeyId()
    {
        return $this->key_id;
    }

    /**
     * The id of the key used to sign the blob.
     *
     * Generated from protobuf field <code>string key_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setKeyId($var)
    {
        GPBUtil::checkString($var, True);
        $this->key_id = $var;

        return $this;
    }

    /**
     * The signed blob.
     *
     * Generated from protobuf field <code>bytes signature = 2;</code>
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * The signed blob.
     *
     * Generated from protobuf field <code>bytes signature = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSignature($var)
    {
        GPBUtil::checkString($var, False);
        $this->signature = $var;

        return $this;
    }

}

