<?php
/*
 * This file is part of the Social App Framework package.
 * (c) 2011-2013 X Studios
 *
 * You should have received a copy of the license (license.txt) distributed
 * with this package. If not, see <http://socialappframework.com/license/>.
 */

//namespace SocialAppFramework\Graph;

/**
 * Facebook object class
 *
 * @package      Social App Framework
 * @category     Facebook
 * @author       Tim Santor <tsantor@xstudiosinc.com>
 */
abstract class SAF_Graph_Object {

    /**
     * Post array
     *
     * @var    array
     */
	protected $_post = array();

    /**
     * SAF instance
     *
     * @var  SAF
     */
    protected $_facebook;

    // ------------------------------------------------------------------------

    /**
     * Constructor
     *
     * @access    public
     * @return    void
     */
    public function __construct() {
        $this->_facebook = SAF::instance();
    }

    // ------------------------------------------------------------------------

    /**
     * Delete an object
     *
     * Note that some objects can't be deleted: checkins, albums, notifications
     *
     * @access    protected
     * @param     string|int  $object_id  the object ID
     * @return    boolean     true if the delete succeeded
     */
    public function delete($object_id) {
        // call the api
        $result = $this->_facebook->api('/'.$object_id, 'delete');

        return $result;
    }

    // ------------------------------------------------------------------------

}

/* End of file */
