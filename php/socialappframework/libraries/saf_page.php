<?php
/*
 * This file is part of the Social App Framework package.
 * (c) 2011-2013 X Studios
 *
 * You should have received a copy of the license (license.txt) distributed
 * with this package. If not, see <http://socialappframework.com/license/>.
 */

/**
 * Social App Framework Page class
 *
 * @package      Social App Framework
 * @category     Facebook
 * @author       Tim Santor <tsantor@xstudiosinc.com>
 */
class SAF_Page {

    const RSS = 'https://www.facebook.com/feeds/page.php?id=%s&format=rss20';

    // ------------------------------------------------------------------------
    // PRIVATE VARS
    // ------------------------------------------------------------------------

    /**
     * Facebook instance
     *
     * @access    private
     * @var       SAF
     */
    private $_facebook;

    /**
     * Page ID
     *
     * @access    private
     * @var       string|int
     */
    private $_id;

    /**
     * Page data
     *
     * @access    private
     * @var       array
     */
    private $_data;

    // ------------------------------------------------------------------------
    // GETTERS / SETTERS
    // ------------------------------------------------------------------------

    /**
     * Returns the page ID
     *
     * @access    public
     * @return    string|int
     */
    public function getId() {
        return $this->_getValue('id');
    }

    /**
     * Returns the page data
     *
     * @access    public
     * @return    array
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * Returns the page's access token
     *
     * @access    public
     * @return    string
     */
    public function getAccessToken() {
        return $this->_getValue('access_token');
    }

    /**
     * Returns the page's name
     *
     * @access    public
     * @return    string
     */
    public function getName() {
        return $this->_getValue('name', '');
    }

    /**
     * Returns the page's profile URL
     *
     * @access    public
     * @return    string
     */
    public function getProfileUrl() {
        return $this->_getValue('link');
    }

    /**
     * Returns the page's profile picture
     *
     * @access    public
     * @return    string
     */
    public function getProfilePicture() {
        $picture = $this->_getValue('picture');
        if (!empty($picture)) {
            if (isset($picture['data']['url'])) {
                return $picture['data']['url'];
            }
        }

        return FB_Helper::picture_url($this->_id);
    }

    /**
     * Returns the page's like count
     *
     * @access    public
     * @return    string|int
     */
    public function getLikes() {
        return $this->_getValue('likes');
    }

    /**
     * Returns the page's website
     *
     * @access    public
     * @return    string
     */
    public function getWebsite() {
        return $this->_getValue('website');
    }

    /**
     * Returns the tab URL
     *
     * @access    public
     * @return    string
     */
    public function getTabUrl() {
        return $this->_getValue('saf_page_tab_url');
    }

    /**
     * Returns the URL needed to add the app to a page
     *
     * @access    public
     * @return    string
     */
    public function getAddTabUrl() {
        return $this->_getValue('saf_add_page_tab_url');
    }

    /**
     * Returns the app's Canvas URL (if it has one)
     *
     * @access    public
     * @return    string
     */
    public function getCanvasUrl() {
        return $this->_getValue('saf_canvas_url');
    }

    /**
     * Returns true if the page is published
     *
     * @access    public
     * @return    boolean
     */
    public function isPublished() {
        return $this->_getValue('is_published');
    }

    /**
     * Returns true if the user likes this page
     *
     * @access    public
     * @return    boolean
     */
    public function isLiked() {
        return $this->_getValue('saf_page_liked');
    }

    /**
     * Returns true if the page has restrictions
     *
     * @access    public
     * @return    boolean
     */
    public function hasRestrictions() {
        return $this->_getValue('saf_page_restrictions');
    }

    /**
     * Returns the page's RSS URL
     *
     * @access    public
     * @return    string
     */
    public function getRssUrl() {
        return sprintf(self::RSS, $this->_id);
    }

    // ------------------------------------------------------------------------

    /**
     * Constructor
     *
     * @access    public
     * @param     SAF         $facebook
     * @param     string|int  $page_id
     * @return    void
     */
    public function __construct($facebook, $page_id) {
        $this->_facebook = $facebook;
        $this->_id       = $page_id;

        $this->_init();
    }

    // ------------------------------------------------------------------------
    // PRIVATE METHODS
    // ------------------------------------------------------------------------

    /**
     * Init
     *
     * @access    private
     * @return    void
     */
    private function _init() {
        try {

            // get page data
            $this->_data = $this->_facebook->api('/'.$this->_id, 'GET', array(
                //'access_token' => $this->getAccessToken(),
                'fields' => 'access_token, '.SAF_Config::getGraphPageFields()
            ));

            // if we have page data
            if ( !empty($this->_data) ) {

                // inject SAF data, no page restrictions we are aware of
                $this->_data = $this->_injectSAFData(false);

            // probably some sort of page restriction (country/age)
            } else {

                // inject SAF data, some sort of page restriction (country/age)
                $this->_data = $this->_injectSAFData(true);

                // fall back to default page URL as SAF_User will need this value
                $this->_tab_url = 'https://www.facebook.com/';

                $this->debug(__CLASS__.':: Page ('.$this->_id.') may be unpublished or have country/age restrictions', null, 3, true);

            }

            $this->debug(__CLASS__.':: Page ('.$this->_id.') data: ', $this->_data);

        } catch (FacebookApiException $e) {

            $this->debug(__CLASS__.':: '.$e, null, 3, true);

        }

        $this->debug('--------------------');
    }

    // ------------------------------------------------------------------------

    /**
     * Add our own useful social app framework parameter(s) to the page data
     *
     * @access    private
     * @return    array
     */
    private function _injectSAFData($page_restrictions=false) {
        if ( isset($this->_data['link']) ) {
            $url = str_replace( 'http', 'https', $this->_data['link'].'?sk=app_'.SAF_Config::getAppId() );
            $this->_data['saf_page_tab_url'] = $url;
        }

        $this->_data['saf_add_page_tab_url']  = SAF_Config::getAddPageTabUrl();
        $this->_data['saf_canvas_url']        = SAF_Config::getCanvasUrl();
        $this->_data['saf_page_restrictions'] = $page_restrictions;
        $this->_data['saf_page_liked']        = $this->_facebook->isPageLiked();
        $this->_data['saf_rss_url']           = $this->getRssUrl();

        return $this->_data;
    }

    // ------------------------------------------------------------------------

    /**
     * Returns a page key value whether it exists or not
     *
     * @access    private
     * @param     string  $key      key to check for
     * @param     mixed   $default  default value if not set
     * @return    mixed
     */
    private function _getValue($key, $default=false) {
        if ( !isset($this->_data[$key]) ) {
            return $default;
        }

        return $this->_data[$key];
    }

    // ------------------------------------------------------------------------
    // WRAPPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Wrapper around an external class so we can do a simple check if the
     * class (XS_Debug) is avaliable before we attempt to use its method.
     *
     * @access    protected
     * @param     string  $name  name, label, message
     * @param     var     $var   a variable
     * @param     int     $type  (1)log, (2)info, (3)warn, (4)error
     * @param     bool    $log   log to text file
     * @return    void
     */
    protected function debug($name, $var=null, $type=1, $log=false) {
        if (class_exists('XS_Debug')) {
            XS_Debug::addMessage($name, $var, $type, $log);
        }
    }

    // ------------------------------------------------------------------------
    // CONNECTIONS
    // ------------------------------------------------------------------------

    public function getConnection($connection) {
        $connection = '/'.$connection;

        // call the api
        $result = $this->_facebook->api('/'.$this->_id.$connection, 'GET', array(
            'access_token' => $this->getAccessToken()
        ));

        return $result['data'];
    }

    // ------------------------------------------------------------------------

    /**
     * Get the page's wall
     *
     * @access    public
     * @return    array  of Post objects
     */
    public function getFeed() {
        // call the api
        $result = $this->_facebook->api('/'.$this->_id.'/feed');
        return $result['data'];
    }

    // ------------------------------------------------------------------------

    /**
     * Get the page's profile picture
     *
     * @access    public
     * @param     string  $type  square, small, normal, large
     * @return    string  URL of the page's profile picture
     */
    public function getPicture($type='square') {
        // call the api
        $result = $this->_facebook->api('/'.$this->_id.'/picture', 'GET', array(
            'type' => $type
        ));
        return $result['data'];
    }

    // ------------------------------------------------------------------------

    /**
     * Get the page's settings
     *
     * @access    public
     * @return    array  of objects containing setting and value fields
     */
    public function getSettings() {
        // call the api
        $result = $this->_facebook->api('/'.$this->_id.'/settings', 'GET', array(
            'access_token' => $this->getAccessToken()
        ));
        return $result['data'];
    }

    // ------------------------------------------------------------------------

    /**
     * Get the page's tabs
     *
     * @access    public
     * @return    array
     */
    public function getTabs() {
        // call the api
        $result = $this->_facebook->api('/'.$this->_id.'/tabs', 'GET', array(
            'access_token' => $this->getAccessToken()
        ));
        return $result['data'];
    }

    // ------------------------------------------------------------------------

}

/* End of file */
