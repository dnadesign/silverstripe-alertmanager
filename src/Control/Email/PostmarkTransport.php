<?php

namespace DNADesign\AlertManager;

use Postmark\Transport;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Config\Configurable;

/**
 * Wraps WildBit\Postmark\Transport so that the server_token gets via
 * SilverStripe's config system
 */

class PostmarkTransport extends Transport
{
	use Configurable;

	public function __construct() {
		parent::__construct($this->config()->server_token);
	}
}