# Social App Framework Docs
### Version 1.0.0

## Table of Contents

* [SAF Config](saf_config.md)
* [SAF Class](saf.md)
* [SAF Base Class](saf_base.md)
* [SAF Signed Request Class](saf_signed_request.md)
* [SAF Fan Page Class](saf_fan_page.md)
* [SAF Facebook User Class](saf_facebook_user.md)
* [SAF Session](saf_session.md)

# SAF Session Class
The SAF Session class is a small class with a simple task: Maintain a session
that contains vital signed request, fan page and user data.

##Public Methods
This document **does not** outline each of the methods available since its methods
are the same methods available to each individual class (with a few exceptions):

* Signed Request
* Fan Page
* Facebook User

The only difference being that all public methods available to SAF Session are
static methods.

Usage Example:
    
    // signed request
    SAF_Session::getSignedRequestData();

    // user
    SAF_Session::getUserData();

    // fan page
    SAF_Session::getPageData();