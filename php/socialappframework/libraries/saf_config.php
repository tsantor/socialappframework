<?php
/**
 * Social App Framework Config class
 *
 * Helps manage the SAF config so we have a nice and easy get/set methods
 * as well as helpful code completion in IDEs
 *
 * @author       Tim Santor <tsantor@xstudiosinc.com>
 * @version      1.0
 * @copyright    2012 X Studios
 * @link         http://www.xstudiosinc.com
 *
 * You should have received a copy of the license along with this program.
 * If not, see <http://socialappframework.com/license/>.
 */
class SAF_Config {

    // CONSTANTS
    const APP_TYPE_TAB              = 'tab';
    const APP_TYPE_CANVAS           = 'canvas';
    const APP_TYPE_FACEBOOK_CONNECT = 'facebook connect';

    // app type
    private static $_app_type = self::APP_TYPE_FACEBOOK_CONNECT;

    // facebook vars
    private static $_fb_app_id;
    private static $_fb_app_secret;
    private static $_fb_app_domain;

    private static $_fb_use_cookie  = true;
    private static $_fb_file_upload = true;

    private static $_fb_app_namespace = '';
    private static $_fb_admins        = '';
    private static $_fb_developers    = '';

    // app url vars
    private static $_url_base = ''; // base url of our app

    // permission vars
    private static $_perms_extended           = '';
    private static $_perms_extended_admin     = '';
    private static $_perms_auto_request_tab   = false;
    private static $_perms_auto_request_app   = false;
    private static $_perms_auto_request_admin = false;

    // signed request vars
    private static $_sr_fan_page_hash       = '';
    private static $_sr_redirect_tab        = false;
    private static $_sr_redirect_canvas     = false;
    private static $_sr_redirect_tab_url    = '';
    private static $_sr_redirect_canvas_url = '';

    // SAF redirect
    private static $_force_redirect = false;

    // graph fields
    private static $_user_fields = '';
    private static $_page_fields = '';

    // ------------------------------------------------------------------------

    /**
     * Set app type
     *
     * @param    string  $value
     */
    public static function setAppType($value) {
        self::$_app_type = $value;
    }

    /**
     * Get app id
     */
    public static function getAppType() {
        return self::$_app_type;
    }

    // ------------------------------------------------------------------------
    // FACEBOOK
    // ------------------------------------------------------------------------

    /**
     * Set app id
     *
     * @param    string  $value
     */
    public static function setAppID($value) {
        self::$_fb_app_id = $value;
    }

    /**
     * Get app id
     */
    public static function getAppID() {
        return self::$_fb_app_id;
    }

    // ------------------------------------------------------------------------

    /**
     * Set app secret
     *
     * @param    string  $value
     */
    public static function setAppSecret($value) {
        self::$_fb_app_secret = $value;
    }

    /**
     * Get app secret
     */
    public static function getAppSecret() {
        return self::$_fb_app_secret;
    }

    // ------------------------------------------------------------------------

    /**
     * Set app domain
     *
     * @param    string  $value
     */
    public static function setAppDomain($value) {
        self::$_fb_app_domain = $value;
    }

    /**
     * Get app domain
     */
    public static function getAppDomain() {
        return self::$_fb_app_domain;
    }

    // ------------------------------------------------------------------------

    /**
     * Set use cookie
     *
     * @param    bool  $value
     */
    public static function setUseCookie($value) {
        self::$_fb_use_cookie = $value;
    }

    /**
     * Get use cookie
     */
    public static function getUseCookie() {
        return self::$_fb_use_cookie;
    }

    // ------------------------------------------------------------------------

    /**
     * Set file upload
     *
     * @param    bool  $value
     */
    public static function setFileUpload($value) {
        self::$_fb_file_upload = $value;
    }

    /**
     * Get file upload
     */
    public static function getFileUpload() {
        return self::$_fb_file_upload;
    }

    // ------------------------------------------------------------------------

    /**
     * Set app namespace
     *
     * @param    string  $value
     */
    public static function setAppNamespace($value) {
        self::$_fb_app_namespace = $value;
    }

    /**
     * Get app namespace
     */
    public static function getAppNamespace() {
        return self::$_fb_app_namespace;
    }

    // ------------------------------------------------------------------------

    /**
     * Set admins
     *
     * @param    string  $value  comma delimited
     */
    public static function setAdmins($value) {
        self::$_fb_admins = $value;
    }

    /**
     * Get admins
     */
    public static function getAdmins() {
        return self::$_fb_admins;
    }

    // ------------------------------------------------------------------------

    /**
     * Set developers
     *
     * @param    string  $value  comma delimited
     */
    public static function setDevelopers($value) {
        self::$_fb_developers = $value;
    }

    /**
     * Get developers
     */
    public static function getDevelopers() {
        return self::$_fb_developers;
    }

    // ------------------------------------------------------------------------
    // APP URLS
    // ------------------------------------------------------------------------

    /**
     * Set base URL
     *
     * @param    string  $value
     */
    public static function setBaseURL($value) {
        self::$_url_base = $value;
    }

    /**
     * Get base URL
     */
    public static function getBaseURL() {
        return self::$_url_base;
    }

    // ------------------------------------------------------------------------

    /**
     * Get Canvas app URL
     */
    public static function getCanvasURL() {
        return 'https://apps.facebook.com/'.self::getAppNamespace().'/';
    }

    /**
     * Get Page Tab URL
     */
    public static function getPageTabURL() {
        return 'https://www.facebook.com/'.self::getFanPageHash().'?sk=app_'.self::getAppID();
    }

    /**
     * Get Add Page Tab URL
     */
    public static function getAddPageTabURL() {
        return 'https://www.facebook.com/dialog/pagetab?app_id='.self::getAppID().'&next=https://www.facebook.com/';
    }

    // ------------------------------------------------------------------------
    // PERMISSIONS
    // ------------------------------------------------------------------------

    /**
     * Set extended perms
     *
     * @param    string  $value
     */
    public static function setExtendedPerms($value) {
        self::$_perms_extended = $value;
    }

    /**
     * Get extended perms
     */
    public static function getExtendedPerms() {
        return self::$_perms_extended;
    }

    // ------------------------------------------------------------------------

    /**
     * Set extended perms for the admin
     *
     * @param    string  $value
     */
    public static function setExtendedPermsAdmin($value) {
        self::$_perms_extended_admin = $value;
    }

    /**
     * Get extended perms for the admin
     */
    public static function getExtendedPermsAdmin() {
        return self::$_perms_extended_admin;
    }

    // ------------------------------------------------------------------------

    /**
     * Set auto-request perms for a tab app
     *
     * @param    string  $value
     */
    public static function setAutoRequestPermsTab($value) {
        self::$_perms_auto_request_tab = $value;
    }

    /**
     * Get auto-request perms for a tab app
     */
    public static function getAutoRequestPermsTab() {
        return self::$_perms_auto_request_tab;
    }

    // ------------------------------------------------------------------------

    /**
     * Set auto-request perms for a canvas app
     *
     * @param    string  $value
     */
    public static function setAutoRequestPermsCanvas($value) {
        self::$_perms_auto_request_app = $value;
    }

    /**
     * Get auto-request perms for a canvas app
     */
    public static function getAutoRequestPermsCanvas() {
        return self::$_perms_auto_request_app;
    }

    // ------------------------------------------------------------------------

    /**
     * Set auto-request perms for the page admin
     *
     * @param    string  $value
     */
    public static function setAutoRequestPermsAdmin($value) {
        self::$_perms_auto_request_admin = $value;
    }

    /**
     * Get auto-request perms for the page admin
     */
    public static function getAutoRequestPermsAdmin() {
        return self::$_perms_auto_request_admin;
    }

    // ------------------------------------------------------------------------
    // SIGNED REQUEST
    // ------------------------------------------------------------------------

    /**
     * Set fan page hash
     *
     * This is used as a fallback value
     *
     * @param    string  $value
     */
    public static function setFanPageHash($value) {
        self::$_sr_fan_page_hash = $value;
    }

    /**
     * Get fan page hash
     */
    public static function getFanPageHash() {
        return self::$_sr_fan_page_hash;
    }

    // ------------------------------------------------------------------------

    /**
     * Set force redirect tab app
     *
     * @param    bool  $value
     */
    public static function setForceRedirectTab($value) {
        self::$_sr_redirect_tab = $value;
    }

    /**
     * Get force redirect tab app
     */
    public static function getForceRedirectTab() {
        return self::$_sr_redirect_tab;
    }

    // ------------------------------------------------------------------------

    /**
     * Set force redirect canvas app
     *
     * @param    bool  $value
     */
    public static function setForceRedirectCanvas($value) {
        self::$_sr_redirect_canvas = $value;
    }

    /**
     * Get force redirect canvas app
     */
    public static function getForceRedirectCanvas() {
        return self::$_sr_redirect_canvas;
    }

    // ------------------------------------------------------------------------

    /**
     * Set tab app redirect URL
     *
     * @param    string  $value
     */
    public static function setTabRedirectURL($value) {
        self::$_sr_redirect_tab_url = $value;
    }

    /**
     * Get tab app redirect URL
     */
    public static function getTabRedirectURL() {
        return self::$_sr_redirect_tab_url;
    }

    // ------------------------------------------------------------------------

    /**
     * Set canvas redirect URL
     *
     * @param    string  $value
     */
    public static function setCanvasRedirectURL($value) {
        self::$_sr_redirect_canvas_url = $value;
    }

    /**
     * Get canvas app redirect URL
     */
    public static function getCanvasRedirectURL() {
        return self::$_sr_redirect_canvas_url;
    }

    // ------------------------------------------------------------------------
    // SAF REDIRECT
    // ------------------------------------------------------------------------

    /**
     * Set force redirect
     *
     * Fixes an issue with browsers that block 3rd part cookies
     *
     * @param    bool  $value
     */
    public static function setForceRedirect($value) {
        self::$_force_redirect = $value;
    }

    /**
     * Get force redirect URL
     */
    public static function getForceRedirect() {
        return self::$_force_redirect;
    }

    // ------------------------------------------------------------------------
    // GRAPH FIELDS
    // ------------------------------------------------------------------------

    /**
     * Set graph user fields
     *
     * @param    string  $value  comma delimited
     */
    public static function setGraphUserFields($value) {
        self::$_user_fields = $value;
    }

    /**
     * Get graph user fields
     */
    public static function getGraphUserFields() {
        return self::$_user_fields;
    }

    // ------------------------------------------------------------------------

    /**
     * Set graph page fields
     *
     * @param    string  $value  comma delimited
     */
    public static function setGraphPageFields($value) {
        self::$_page_fields = $value;
    }

    /**
     * Get graph page fields
     */
    public static function getGraphPageFields() {
        return self::$_page_fields;
    }

    // ------------------------------------------------------------------------

}

/* End of file */
