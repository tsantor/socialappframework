<?php
/*
 * This file is part of the Social App Framework package.
 * (c) 2011-2013 X Studios
 *
 * You should have received a copy of the license (license.txt) distributed
 * with this package. If not, see <http://socialappframework.com/license/>.
 */

require_once dirname(__FILE__).'/facebook/sdk/facebook.php';
require_once dirname(__FILE__).'/saf_config.php';
require_once dirname(__FILE__).'/saf_base.php';
require_once dirname(__FILE__).'/saf_signed_request.php';
require_once dirname(__FILE__).'/saf_fan_page.php';
require_once dirname(__FILE__).'/saf_facebook_user.php';
require_once dirname(__FILE__).'/saf_session.php';
require_once dirname(__FILE__).'/../config/config.php';
require_once dirname(__FILE__).'/../helpers/fb_helper.php';

/**
 * Instantiates the entire SAF Core.
 * We don't really do anything here but load all required files
 * and give ourselves a nice way to instantiate with new SAF()
 *
 * @package      Social App Framework
 * @category     Facebook
 * @author       Tim Santor <tsantor@xstudiosinc.com>
 */
class SAF extends SAF_Facebook_User {

    protected static $_instance = null;

    // ------------------------------------------------------------------------

    /**
     * CONSTRUCTOR
     *
     * @access    public
     * @return    void
     */
    public function __construct() {
        // this is used in conjuction with SAF_Config::setThirdPartyCookieFix(true)
        // allows us a workaround for browsers which do not allow 3rd party
        // cookies (eg - cookies from iframe apps)
        if ( SAF_Config::getThirdPartyCookieFix() == true && isset($_GET['saf_redirect']) == true ) {
            header('Location: '.$_GET['saf_redirect']);
            exit;
        }

        parent::__construct();
    }

    // ------------------------------------------------------------------------

    /**
     * Get instance
     *
     * @access    public
     * @return    SAF instance
     */
    final public static function instance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    // ------------------------------------------------------------------------

    /**
     * INIT SAF
     *
     * Must be called to init the framework. Manual call to allow us to have
     * finer control over when the framework actually initializes after it's
     * been constructed.
     *
     * @access    public
     * @return    void
     */
    public function init() {
        //parent::__construct();
    }

    // ------------------------------------------------------------------------

    /**
     * Disallow cloning
     */
    final public function __clone() {
        return false;
    }

    // ------------------------------------------------------------------------

}

/* End of file */
